<?php include('views/layout/header.php'); ?>

<div class="container mt-4">
  <div class="card shadow-sm mx-auto p-4" style="max-width: 600px;">
    <h3 class="text-center text-primary mb-4">
      <i class="bi bi-person-fill"></i>
      <?= isset($user) ? 'Modifier un utilisateur' : 'Ajouter un utilisateur' ?>
    </h3>

    <?php if (!empty($message)): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="login" class="form-label fw-semibold">Login</label>
        <input type="text" id="login" name="login"
               value="<?= htmlspecialchars($user['login'] ?? '') ?>"
               class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="nom" class="form-label fw-semibold">Nom</label>
        <input type="text" id="nom" name="nom"
               value="<?= htmlspecialchars($user['nom'] ?? '') ?>"
               class="form-control">
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label fw-semibold">Prénom</label>
        <input type="text" id="prenom" name="prenom"
               value="<?= htmlspecialchars($user['prenom'] ?? '') ?>"
               class="form-control">
      </div>

      <div class="mb-3">
        <label for="motDePasse" class="form-label fw-semibold">Mot de passe</label>
        <input type="password" id="motDePasse" name="motDePasse"
               class="form-control" <?= isset($user) ? '' : 'required' ?>>
        <?php if (isset($user)): ?>
          <small class="text-muted">Laisser vide pour conserver l’actuel.</small>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label for="role" class="form-label fw-semibold">Rôle</label>
        <select id="role" name="role" class="form-select">
          <option value="etudiant" <?= (isset($user) && $user['role'] === 'etudiant') ? 'selected' : '' ?>>Étudiant</option>
          <option value="admin" <?= (isset($user) && $user['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
        </select>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> <?= isset($user) ? 'Modifier' : 'Ajouter' ?>
        </button>
      </div>

    <div class="text-center mt-4">
      <a href="index.php?action=listerUsers" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Retour à la liste
      </a>
    </div>            

    </form>
  </div>
</div>

<?php include('views/layout/footer.php'); ?>
