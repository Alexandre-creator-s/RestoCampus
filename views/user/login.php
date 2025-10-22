<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - RestoCampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            border-radius: 8px;
        }

        .form-control {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="card login-card p-4">
        <h3 class="text-center text-primary mb-3">RestoCampus</h3>
        <h5 class="text-center mb-4">Connexion</h5>

        <?php if(!empty($message)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post" action="index.php?controller=user&action=verifier">
            <div class="mb-3">
                <label for="login" class="form-label">Nom d'utilisateur</label>
                <input type="text" id="login" name="login" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
        </form>

        <p class="text-center text-muted mt-3 mb-0" style="font-size: 0.9em;">
            © <?= date('Y') ?> RestoCampus
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
