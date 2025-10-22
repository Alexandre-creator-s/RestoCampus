<?php
require_once "config/Db.php";

class CommandeModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Db::getInstance()->getConnection();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Vérifie que le créneau est actuellement ouvert.
     * Retourne la ligne de articleDisponible si ouvert, false sinon.
     */
    public function isCreneauOuvert(int $idDispo) {
        $stmt = $this->pdo->prepare("
            SELECT idDispo, idArticle, dateHeureDebut, dateHeureFin, quantiteMax
            FROM articleDisponible
            WHERE idDispo = :idDispo
              AND dateHeureDebut <= NOW()
              AND dateHeureFin >= NOW()
            LIMIT 1
        ");
        $stmt->execute(['idDispo' => $idDispo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: false;
    }

    /**
     * Retourne la quantité restante (int) pour un idDispo.
     */
    public function quantiteDisponible(int $idDispo): int {
        // Récupérer quantiteMax
        $stmt = $this->pdo->prepare("SELECT quantiteMax FROM articleDisponible WHERE idDispo = :idDispo");
        $stmt->execute(['idDispo' => $idDispo]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) return 0;

        // Somme des quantités réservées (statut 'réservée' ou 'récupérée' ? On prend toutes sauf 'annulée')
        $stmt2 = $this->pdo->prepare("
            SELECT IFNULL(SUM(quantite),0) AS total
            FROM commande
            WHERE idDispo = :idDispo
              AND statut != 'annulée'
        ");
        $stmt2->execute(['idDispo' => $idDispo]);
        $s = $stmt2->fetch(PDO::FETCH_ASSOC);
        $reserved = (int)($s['total'] ?? 0);

        $available = (int)$row['quantiteMax'] - $reserved;
        return max(0, $available);
    }

    /**
     * Tente de réserver une quantité pour un utilisateur.
     * Retourne un tableau ['success' => bool, 'message' => string].
     *
     * Utilise transaction + verrou sur la disponibilité et les commandes associées.
     */
    public function reserver(int $idDispo, int $idUtilisateur, int $quantite): array {
        if ($quantite <= 0) {
            return ['success' => false, 'message' => 'Quantité invalide.'];
        }

        try {
            $this->pdo->beginTransaction();

            // Verrouiller la ligne de la disponibilité
            $stmt = $this->pdo->prepare("
                SELECT quantiteMax, dateHeureDebut, dateHeureFin
                FROM articleDisponible
                WHERE idDispo = :idDispo
                FOR UPDATE
            ");
            $stmt->execute(['idDispo' => $idDispo]);
            $ad = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$ad) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => "Disponibilité inexistante."];
            }

            // Vérifier que le créneau est ouvert (utiliser les mêmes bornes que isCreneauOuvert)
            $now = new DateTime();
            $debut = new DateTime($ad['dateHeureDebut']);
            $fin   = new DateTime($ad['dateHeureFin']);
            if (!($debut <= $now && $now <= $fin)) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => "Le créneau n'est pas ouvert."];
            }

            // Calculer quantité déjà réservée (verrouillée)
            $stmt2 = $this->pdo->prepare("
                SELECT IFNULL(SUM(quantite),0) AS total 
                FROM commande 
                WHERE idDispo = :idDispo
                  AND statut != 'annulée'
                FOR UPDATE
            ");
            $stmt2->execute(['idDispo' => $idDispo]);
            $s = $stmt2->fetch(PDO::FETCH_ASSOC);
            $reserved = (int)($s['total'] ?? 0);

            $available = (int)$ad['quantiteMax'] - $reserved;
            if ($quantite > $available) {
                $this->pdo->rollBack();
                return ['success' => false, 'message' => "Quantité insuffisante (reste $available)."];
            }

            // Insérer la commande avec statut 'réservée'
            $stmt3 = $this->pdo->prepare("
                INSERT INTO commande (idDispo, idUtilisateur, quantite, statut, dateCommande)
                VALUES (:idDispo, :idUtilisateur, :quantite, 'réservée', NOW())
            ");
            $stmt3->execute([
                'idDispo' => $idDispo,
                'idUtilisateur' => $idUtilisateur,
                'quantite' => $quantite
            ]);

            $this->pdo->commit();
            return ['success' => true, 'message' => 'Réservation enregistrée.'];

        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) $this->pdo->rollBack();
            // pour debug, tu peux logger $e->getMessage()
            return ['success' => false, 'message' => 'Erreur serveur lors de la réservation.'];
        }
    }

    /**
     * Récupérer les disponibilités ouvertes avec quantité restante > 0.
     */
    public function getDisponibilitesOuvertes(): array {
        $stmt = $this->pdo->query("
            SELECT ad.idDispo, a.nom AS article, ad.dateHeureDebut, ad.dateHeureFin, ad.quantiteMax,
                   (ad.quantiteMax - IFNULL(SUM(CASE WHEN c.statut != 'annulée' THEN c.quantite ELSE 0 END),0)) AS dispoRestante
            FROM articleDisponible ad
            JOIN article a ON ad.idArticle = a.idArticle
            LEFT JOIN commande c ON ad.idDispo = c.idDispo
            WHERE ad.dateHeureDebut <= NOW() AND ad.dateHeureFin >= NOW()
            GROUP BY ad.idDispo
            HAVING dispoRestante > 0
            ORDER BY ad.dateHeureDebut ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupérer les commandes d'un utilisateur (historique).
     */
    public function getMesCommandes(int $idUtilisateur): array {
        $stmt = $this->pdo->prepare("
            SELECT c.idCommande, a.nom AS article, ad.dateHeureDebut, ad.dateHeureFin, c.quantite, c.statut, c.dateCommande
            FROM commande c
            JOIN articleDisponible ad ON c.idDispo = ad.idDispo
            JOIN article a ON ad.idArticle = a.idArticle
            WHERE c.idUtilisateur = :idUtilisateur
            ORDER BY c.dateCommande DESC
        ");
        $stmt->execute(['idUtilisateur' => $idUtilisateur]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Annuler une commande : met le statut à 'annulée' (si elle appartient à l'utilisateur).
     * Retourne true si une ligne a été modifiée.
     */
    public function annuler($idCommande, $idUtilisateur) {
    $stmt = $this->pdo->prepare("
        UPDATE commande
        SET statut = 'annulée'
        WHERE idCommande = :idCommande
        AND idUtilisateur = :idUtilisateur
        AND statut = 'réservée'
    ");
    $stmt->execute([
        'idCommande' => $idCommande,
        'idUtilisateur' => $idUtilisateur
    ]);
    return $stmt->rowCount() > 0;
}

    // Compter le nombre de réservations par article
    public function countReservationsByArticle(): array {
        $stmt = $this->pdo->query("
            SELECT a.nom AS article, SUM(c.quantite) AS total
            FROM commande c
            JOIN articleDisponible ad ON c.idDispo = ad.idDispo
            JOIN article a ON ad.idArticle = a.idArticle
            WHERE c.statut != 'annulée'
            GROUP BY a.idArticle
            ORDER BY total DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Marquer une commande comme récupérée
    public function marquerRecuperee(int $idCommande): bool {
        $stmt = $this->pdo->prepare("
            UPDATE commande
            SET statut = 'récupérée'
            WHERE idCommande = :idCommande
                AND statut = 'réservée'
        ");
        $stmt->execute(['idCommande' => $idCommande]);
        return ($stmt->rowCount() > 0);
    }

    // Obtenir les commandes du jour (méthode utilisée dans dashboardAdmin)
    public function getCommandesDuJour(): array {
        $stmt = $this->pdo->query("
            SELECT c.idCommande, c.idUtilisateur, c.idDispo, c.quantite, c.statut, c.dateCommande,
                    a.nom AS article, u.login AS utilisateur,
                    ad.dateHeureDebut, ad.dateHeureFin
            FROM commande c
            JOIN articleDisponible ad ON c.idDispo = ad.idDispo
            JOIN article a ON ad.idArticle = a.idArticle
            JOIN utilisateur u ON c.idUtilisateur = u.idUtilisateur
            WHERE DATE(c.dateCommande) = CURDATE()
            ORDER BY c.dateCommande ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   
}

