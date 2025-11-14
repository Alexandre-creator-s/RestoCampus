<?php include('views/layout/header.php'); ?>

<div class="container my-5" style="max-width: 650px;">
  <div class="card shadow-sm border-0 p-4">
    <div class="card-body">
      <h2 class="h4 mb-4 text-center text-primary">Modifier l’article</h2>

      <form method="post">
        <div class="mb-3">
          <label class="form-label fw-semibold">Nom :</label>
          <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($article['nom']); ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Description :</label>
          <textarea name="description" rows="3" class="form-control"><?= htmlspecialchars($article['description']); ?></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label fw-semibold">Ingrédients (séparés par des virgules) :</label>
          <input 
            type="text" 
            name="ingredients" 
            class="form-control"
            value="<?= htmlspecialchars(implode(',', array_column($article['ingredients'], 'nom'))); ?>">
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
          <a href="index.php?action=listerArticles" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Retour
          </a>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Enregistrer les modifications
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
