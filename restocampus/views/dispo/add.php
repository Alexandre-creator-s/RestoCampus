<?php include('views/layout/header.php'); ?>

<div class="container mt-4">
  <div class="card shadow-sm mx-auto p-4" style="max-width: 600px;">
    <h3 class="text-center text-primary mb-4">
      <i class="bi bi-calendar-check"></i> 
      <?= isset($dispo) ? "Modifier" : "Ajouter"; ?> une disponibilité
    </h3>

    <form method="post">
      <div class="mb-3">
        <label for="idArticle" class="form-label fw-semibold">Article</label>
        <select id="idArticle" name="idArticle" class="form-select" required>
          <option value="">-- Sélectionner --</option>
          <?php foreach($articles as $a): ?>
            <option value="<?= $a['idArticle']; ?>" 
              <?= (isset($dispo) && $dispo['idArticle'] == $a['idArticle']) ? 'selected' : ''; ?>>
              <?= htmlspecialchars($a['nom']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="dateHeureDebut" class="form-label fw-semibold">Date et heure de début</label>
        <input type="datetime-local" id="dateHeureDebut" name="dateHeureDebut" 
               value="<?= isset($dispo) ? str_replace(' ', 'T', $dispo['dateHeureDebut']) : ''; ?>" 
               class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="dateHeureFin" class="form-label fw-semibold">Date et heure de fin</label>
        <input type="datetime-local" id="dateHeureFin" name="dateHeureFin" 
               value="<?= isset($dispo) ? str_replace(' ', 'T', $dispo['dateHeureFin']) : ''; ?>" 
               class="form-control" required>
      </div>

      <div class="mb-3">
        <label for="quantiteMax" class="form-label fw-semibold">Quantité maximale</label>
        <input type="number" id="quantiteMax" name="quantiteMax" 
               value="<?= $dispo['quantiteMax'] ?? ''; ?>" 
               class="form-control" min="1" required>
      </div>

      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check-circle"></i> <?= isset($dispo) ? "Modifier" : "Ajouter"; ?>
        </button>
      </div>
    </form>

    <div class="text-center mt-4">
      <a href="index.php?action=listerDispo" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Retour à la liste des disponibilités
      </a>
    </div>
  </div>
</div>

<?php include('views/layout/footer.php'); ?>
