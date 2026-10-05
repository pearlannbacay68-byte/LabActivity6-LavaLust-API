<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f5f1">
    <title>Sign in | Stockroom</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url('css/stockroom.css')) ?>">
</head>
<body class="auth-page">
    <main class="login-card">
        <div class="brand-mark" aria-hidden="true">S</div>
        <p class="eyebrow">STOCKROOM / INVENTORY</p>
        <h1>Good to see you.</h1>
        <p class="muted">Sign in to manage your products.</p>

        <?php if (!empty($error)): ?>
            <div class="alert" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="success" role="status"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form class="login-form" method="post" action="<?= site_url('auth/authenticate') ?>">
            <label for="username">Username
                <input type="text" id="username" name="username" autocomplete="username" value="<?= htmlspecialchars($username ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </label>

            <label for="password">Password
                <input type="password" id="password" name="password" autocomplete="current-password" required>
            </label>

            <button class="btn btn-primary btn-wide" type="submit">Sign in</button>
        </form>

        <p class="login-note">Need an account? <a class="auth-link" href="<?= site_url('register') ?>">Register</a></p>
    </main>
</body>
</html>
