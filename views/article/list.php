<?php include('views/layout/header.php'); ?>

<div class="container my-4">

  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="h4 mb-0">Gestion des articles</h2>
      <p class="text-muted mb-0">Ajoutez, modifiez ou supprimez les plats proposés à la réservation.</p>
    </div>
    <div>
      <a href="index.php?action=ajouterArticle" class="btn btn-primary me-2">
        <i class="bi bi-plus-circle"></i> Ajouter un article
      </a>
      <a href="index.php?action=dashboardAdmin" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
      </a>
    </div>
  </div>

  <?php if (empty($articles)): ?>
    <div class="alert alert-info text-center p-4" role="alert">
      <h5 class="mb-3">Aucun article enregistré</h5>
      <p class="text-muted mb-3">Commencez par ajouter un premier plat pour le menu du campus.</p>
      <a href="index.php?action=ajouterArticle" class="btn btn-primary">Ajouter un article</a>
    </div>

  <?php else: ?>
    <div class="card shadow-sm border-0">
      <div class="card-body p-3">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Nom</th>
                <th>Description</th>
                <th>Ingrédients</th>
                <th class="text-center" style="width:180px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($articles as $a): ?>
              <tr>
                <td class="fw-semibold"><?= htmlspecialchars($a['nom']); ?></td>
                <td><?= htmlspecialchars($a['description']); ?></td>
                <td><span class="text-muted"><?= htmlspecialchars($a['ingredients']); ?></span></td>
                <td class="text-center">
                  <a href="index.php?action=modifierArticle&id=<?= $a['idArticle']; ?>" class="btn btn-sm btn-outline-primary me-1">
                    <i class="bi bi-pencil-square"></i>
                  </a>
                  <a href="index.php?action=supprimerArticle&id=<?= $a['idArticle']; ?>"
                     onclick="return confirm('Voulez-vous vraiment supprimer cet article ?');"
                     class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
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
