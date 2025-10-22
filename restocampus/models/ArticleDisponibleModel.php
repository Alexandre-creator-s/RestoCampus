<?php
require_once "config/Db.php";

class ArticleDisponibleModel {
    private $pdo;

    public function __construct() {
        $this->pdo = Db::getInstance()->getConnection();
    }

    // Ajouter une disponibilité
    public function add($idArticle, $dateHeureDebut, $dateHeureFin, $quantiteMax) {
        $stmt = $this->pdo->prepare("
            INSERT INTO articleDisponible (idArticle, dateHeureDebut, dateHeureFin, quantiteMax)
            VALUES (:idArticle, :dateHeureDebut, :dateHeureFin, :quantiteMax)
        ");
        $stmt->execute([
            'idArticle' => $idArticle,
            'dateHeureDebut' => $dateHeureDebut,
            'dateHeureFin' => $dateHeureFin,
            'quantiteMax' => $quantiteMax
        ]);
    }

    // Modifier une disponibilité
    public function update($idDispo, $idArticle, $dateHeureDebut, $dateHeureFin, $quantiteMax) {
        $stmt = $this->pdo->prepare("
            UPDATE articleDisponible
            SET idArticle = :idArticle, dateHeureDebut = :dateHeureDebut, dateHeureFin = :dateHeureFin, quantiteMax = :quantiteMax
            WHERE idDispo = :idDispo
        ");
        $stmt->execute([
            'idDispo' => $idDispo,
            'idArticle' => $idArticle,
            'dateHeureDebut' => $dateHeureDebut,
            'dateHeureFin' => $dateHeureFin,
            'quantiteMax' => $quantiteMax
        ]);
    }

    // Supprimer une disponibilité
    public function delete($idDispo) {
        $stmt = $this->pdo->prepare("DELETE FROM articleDisponible WHERE idDispo = :idDispo");
        $stmt->execute(['idDispo' => $idDispo]);
    }

    // Récupérer une disponibilité par ID
    public function getById($idDispo) {
        $stmt = $this->pdo->prepare("SELECT * FROM articleDisponible WHERE idDispo = :idDispo");
        $stmt->execute(['idDispo' => $idDispo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lister toutes les disponibilités
    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT ad.idDispo, a.nom AS article, ad.dateHeureDebut, ad.dateHeureFin, ad.quantiteMax
            FROM articleDisponible ad
            JOIN article a ON a.idArticle = ad.idArticle
            ORDER BY ad.dateHeureDebut ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer tous les articles pour un select
    public function getArticles() {
        $stmt = $this->pdo->query("SELECT idArticle, nom FROM article ORDER BY nom ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
