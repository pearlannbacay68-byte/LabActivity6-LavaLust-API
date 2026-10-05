<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f5f1">
    <title>Register | Stockroom</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url('css/stockroom.css')) ?>">
</head>
<body class="auth-page">
    <main class="login-card">
        <div class="brand-mark" aria-hidden="true">S</div>
        <p class="eyebrow">STOCKROOM / INVENTORY</p>
        <h1>Create your account.</h1>
        <p class="muted">Register to start managing your products.</p>

        <?php if (!empty($error)): ?>
            <div class="alert" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form class="login-form" method="post" action="<?= site_url('auth/register') ?>">
            <label for="username">Username
                <input
                    type="text"
                    id="username"
                    name="username"
                    maxlength="100"
                    autocomplete="username"
                    value="<?= htmlspecialchars($form['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </label>

            <label for="email">Email
                <input
                    type="email"
                    id="email"
                    name="email"
                    maxlength="255"
                    autocomplete="email"
                    value="<?= htmlspecialchars($form['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                >
            </label>

            <label for="password">Password
                <input type="password" id="password" name="password" autocomplete="new-password" minlength="6" required>
            </label>

            <button class="btn btn-primary btn-wide" type="submit">Register</button>
        </form>

        <p class="login-note">Already have an account? <a class="auth-link" href="<?= site_url('login') ?>">Sign in</a></p>
    </main>
</body>
</html>
