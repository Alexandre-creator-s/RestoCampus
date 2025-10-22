<?php include('views/layout/header.php'); ?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2 class="h4 mb-0">Disponibilités des articles</h2>
      <small class="text-muted">Gérez les créneaux de réservation disponibles</small>
    </div>
    <div>
      <a href="index.php?action=ajouterDispo" class="btn btn-primary me-2">
        <i class="bi bi-plus-circle"></i> Ajouter une disponibilité
      </a>
      <a href="index.php?action=dashboardAdmin" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
      </a>
    </div>
  </div>

  <?php if (empty($disponibilites)): ?>
    <div class="alert alert-light border text-center py-4">
      <p class="mb-2">Aucune disponibilité enregistrée.</p>
      <a href="index.php?action=ajouterDispo" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Ajouter une disponibilité
      </a>
    </div>

  <?php else: ?>
    <div class="card shadow-sm border-0">
      <div class="card-body p-3">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Article</th>
                <th>Date / Heure début</th>
                <th>Date / Heure fin</th>
                <th>Quantité max</th>
                <th style="width:180px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($disponibilites as $d): ?>
                <tr>
                  <td><strong><?= htmlspecialchars($d['article']); ?></strong></td>
                  <td><?= htmlspecialchars($d['dateHeureDebut']); ?></td>
                  <td><?= htmlspecialchars($d['dateHeureFin']); ?></td>
                  <td>
                    <span class="badge bg-secondary">
                      <?= htmlspecialchars($d['quantiteMax']); ?>
                    </span>
                  </td>
                  <td>
                    <a href="index.php?action=modifierDispo&id=<?= $d['idDispo']; ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bi bi-pencil-square"></i> Modifier
                    </a>
                    <a href="index.php?action=supprimerDispo&id=<?= $d['idDispo']; ?>"
                       onclick="return confirm('Supprimer cette disponibilité ?');"
                       class="btn btn-sm btn-outline-danger">
                      <i class="bi bi-trash"></i> Supprimer
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
