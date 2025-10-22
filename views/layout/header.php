<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RestoCampus</title>

  <!-- ✅ Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- ✅ Icônes Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

  <!-- ✅ Style personnalisé -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

<!-- 🌐 Barre de navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="bi bi-egg-fried"></i> RestoCampus
    </a>

    <!-- Bouton hamburger pour mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <!-- Menu Administrateur -->
          <li class="nav-item"><a class="nav-link" href="index.php?action=listerUsers"><i class="bi bi-people"></i> Utilisateurs</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?action=listerArticles"><i class="bi bi-journal-text"></i> Articles</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?action=listerDispo"><i class="bi bi-calendar-event"></i> Disponibilités</a></li>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'etudiant'): ?>
          <!-- Menu Étudiant -->
          <li class="nav-item"><a class="nav-link" href="index.php?action=reserver"><i class="bi bi-bag-check"></i> Voir les articles disponibles</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?action=mesCommandes"><i class="bi bi-receipt"></i> Mes commandes</a></li>

        <?php endif; ?>
      </ul>

      <!-- Partie droite de la navbar -->
      <div class="d-flex align-items-center">
        <?php if (isset($_SESSION['login'])): ?>
          <span class="text-white me-3">
            Bonjour <strong><?= htmlspecialchars($_SESSION['login']) ?></strong>
          </span>
          <a href="index.php?controller=user&action=logout" class="btn btn-outline-light btn-sm">
            <i class="bi bi-box-arrow-right"></i> Déconnexion
          </a>
        <?php else: ?>
          <a href="index.php?controller=user&action=login" class="btn btn-outline-light btn-sm">
            <i class="bi bi-box-arrow-in-right"></i> Connexion
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>

<!-- Conteneur principal -->
<div class="container my-4">
