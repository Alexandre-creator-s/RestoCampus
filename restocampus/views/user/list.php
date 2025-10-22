<?php include('views/layout/header.php'); ?>

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h2 class="h4 mb-0">Gérer les utilisateurs</h2>
      <small class="text-muted">Liste — ajouter, modifier, supprimer</small>
    </div>
    <div>
      <a class="btn btn-primary me-2" href="index.php?action=ajouterUser">
        <i class="bi bi-person-plus-fill"></i> Ajouter un utilisateur
      </a>
      <a class="btn btn-outline-secondary" href="index.php?action=dashboardAdmin">
        <i class="bi bi-arrow-left"></i> Retour
      </a>
    </div>
  </div>

  <?php if (empty($users)): ?>
    <div class="alert alert-light border text-center py-4">
      <p class="mb-2">Aucun utilisateur trouvé.</p>
      <a class="btn btn-primary" href="index.php?action=ajouterUser">
        <i class="bi bi-person-plus-fill"></i> Ajouter le premier utilisateur
      </a>
    </div>

  <?php else: ?>
    <div class="card shadow-sm border-0">
      <div class="card-body p-3">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th style="width:60px">ID</th>
                <th>Login</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th style="width:150px">Rôle</th>
                <th style="width:180px">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $u): ?>
                <tr>
                  <td><?= (int)$u['idUtilisateur'] ?></td>
                  <td><?= htmlspecialchars($u['login']) ?></td>
                  <td><?= htmlspecialchars($u['nom']) ?></td>
                  <td><?= htmlspecialchars($u['prenom']) ?></td>
                  <td>
                    <?php if ($u['role'] === 'admin'): ?>
                      <span class="badge bg-primary">Administrateur</span>
                    <?php else: ?>
                      <span class="badge bg-secondary">Étudiant</span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <a class="btn btn-sm btn-outline-primary me-1" href="index.php?action=modifierUser&id=<?= (int)$u['idUtilisateur'] ?>">
                      <i class="bi bi-pencil-square"></i> Modifier
                    </a>

                    <a class="btn btn-sm btn-outline-danger"
                       href="index.php?action=supprimerUser&id=<?= (int)$u['idUtilisateur'] ?>"
                       onclick="return confirm('Supprimer cet utilisateur ?');">
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
