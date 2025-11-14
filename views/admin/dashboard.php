<?php include('views/layout/header.php'); ?>

<div class="container mt-4">

    <h2 class="mb-4 text-primary text-center fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard – Commandes du jour
    </h2>

    <?php if (!empty($_SESSION['message_admin'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['message_admin']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
        <?php unset($_SESSION['message_admin']); ?>
    <?php endif; ?>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-receipt-cutoff"></i> Commandes du jour
        </div>
        <div class="card-body">
            <?php if (!empty($commandesToday)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Article</th>
                                <th>Début</th>
                                <th>Fin</th>
                                <th>Quantité</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($commandesToday as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['idCommande']); ?></td>
                                    <td><?= htmlspecialchars($c['utilisateur']); ?></td>
                                    <td><?= htmlspecialchars($c['article']); ?></td>
                                    <td><?= htmlspecialchars($c['dateHeureDebut']); ?></td>
                                    <td><?= htmlspecialchars($c['dateHeureFin']); ?></td>
                                    <td><?= (int)$c['quantite']; ?></td>
                                    <td>
                                        <?php if ($c['statut'] === 'réservée'): ?>
                                            <span class="badge bg-warning text-dark">Réservée</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Récupérée</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($c['statut'] === 'réservée'): ?>
                                            <a href="index.php?action=marquerRecuperee&id=<?= $c['idCommande']; ?>" class="btn btn-success btn-sm">
                                                <i class="bi bi-check-circle"></i> Récupéré
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>—</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Aucune commande pour aujourd'hui.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-header bg-secondary text-white fw-semibold">
            <i class="bi bi-bar-chart-line"></i> Statistiques par article
        </div>
        <div class="card-body">
            <?php if (!empty($totauxParArticle)): ?>
                <ul class="list-group">
                    <?php foreach ($totauxParArticle as $t): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= htmlspecialchars($t['article']); ?>
                            <span class="badge bg-primary rounded-pill"><?= (int)$t['total']; ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total général :
                        <span class="badge bg-success rounded-pill"><?= (int)$totalCommandes; ?></span>
                    </li>
                </ul>
            <?php else: ?>
                <p class="text-muted">Aucune réservation enregistrée.</p>
            <?php endif; ?>
        </div>
    </div>

</div>

<?php include('views/layout/footer.php'); ?>
