<?php include('views/layout/header.php'); ?>

<div class="container mt-4">
  <div class="card shadow-sm mx-auto p-4" style="max-width: 600px;">
    <h3 class="text-center text-primary mb-4">
      <i class="bi bi-plus-circle"></i> Ajouter un article
    </h3>

    <form method="post">
      <div class="mb-3">
        <label for="nom" class="form-label fw-semibold">Nom de l'article</label>
        <input type="text" id="nom" name="nom" class="form-control" required placeholder="Ex : Pizza Bolognaise">
      </div>

      <div class="mb-3">
        <label for="description" class="form-label fw-semibold">Description</label>
        <textarea id="description" name="description" rows="3" class="form-control" placeholder="Brève description de l'article..."></textarea>
      </div>

      <div class="mb-3">
        <label for="ingredients" class="form-label fw-semibold">Ingrédients (séparés par des virgules)</label>
        <input type="text" id="ingredients" name="ingredients" class="form-control" placeholder="Ex : tomate, fromage, jambon">
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> Ajouter l'article
        </button>
      </div>
    </form>

    <div class="text-center mt-4">
      <a href="index.php?action=listerArticles" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Retour à la liste des articles
      </a>
    </div>
  </div>
</div>

<?php include('views/layout/footer.php'); ?>
