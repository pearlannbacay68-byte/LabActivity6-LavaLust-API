<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Product Manager</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #eef2ff, #dbeafe);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            width: min(420px, 90%);
            background: white;
            border-radius: 18px;
            box-shadow: 0 20px 50px rgba(59, 130, 246, 0.2);
            padding: 32px;
        }
        h2 {
            margin-top: 0;
            color: #1d4ed8;
        }
        .alert {
            background: #fee2e2;
            color: #991b1b;
            border-radius: 10px;
            padding: 10px 14px;
            margin-bottom: 16px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1f2937;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            margin-bottom: 18px;
            font-size: 14px;
        }
        button {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
        }
        .meta {
            margin-top: 16px;
            font-size: 13px;
            color: #475569;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/authenticate') ?>">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>

        <div class="meta">Demo credentials: bacaypearlann@gmail.com / 12345</div>
    </div>
</body>
</html>
