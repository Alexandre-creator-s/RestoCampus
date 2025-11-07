<?php include('views/layout/header.php'); ?>

<style>
  :root {
    --aspais-blue: #004080;
    --aspais-green: #00a651;
  }

  body {
    background: url('views/student/Melun.jpg') center/cover no-repeat fixed;
    min-height: 100vh;
    margin: 0;
    padding: 0;
  }


  .dash-card {
    background-color: rgba(255, 255, 255, 0.25); 
    backdrop-filter: blur(5px); 
    border-radius: 1rem;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .dash-card:hover {
    transform: scale(1.02);
    box-shadow: 0 12px 50px rgba(0, 0, 0, 0.45);
  }

  .btn-primary {
    background-color: var(--aspais-blue);
    border-color: var(--aspais-blue);
  }
  .btn-primary:hover {
    background-color: #002b5e;
  }

  .btn-outline-success {
    color: var(--aspais-green);
    border-color: var(--aspais-green);
  }
  .btn-outline-success:hover {
    background-color: var(--aspais-green);
    color: #fff;
  }

  .text-on-img {
    color: #ffffff;
    text-shadow: 0 2px 6px rgba(0,0,0,0.6);
  }

  @media (max-width: 576px) {
    .dash-card { padding: 28px; }
  }
</style>

<div class="d-flex align-items-center justify-content-center" style="min-height:100vh;">
  <div class="container text-center">
    <div class="mx-auto" style="max-width:720px;">
      <div class="dash-card">
        <h2 class="mb-2 text-on-img fw-bold">Bienvenue sur RestoCampus 🍽️</h2>
        <p class="mb-4 text-on-img">Connecté en tant que <strong><?= htmlspecialchars($_SESSION['login'] ?? ''); ?></strong></p>

        <div class="d-grid gap-3 col-12 col-md-8 mx-auto">
          <a href="index.php?action=reserver" class="btn btn-primary btn-lg">
            Voir les articles disponibles
          </a>
          <a href="index.php?action=mesCommandes" class="btn btn-outline-success btn-lg">
            Mes réservations
          </a>
        </div>

        <p class="mt-4 small text-on-img mb-0">© <?= date('Y') ?> Institution Saint-Aspais - RestoCampus</p>
      </div>
    </div>
  </div>
</div>
