<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, #dbeafe 0%, #93c5fd 45%, #3b82f6 100%);
            margin: 0;
            padding: 40px 20px;
            color: #2d2d2d;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 40px;
            box-shadow: 0 10px 30px rgba(59, 130, 246, 0.25);
            padding: 40px 48px;
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            border-bottom: 2px solid #eff6ff;
            padding-bottom: 16px;
        }

        h2 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #1e3a8a;
        }

        .badge {
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            color: #fff;
            padding: 8px 20px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.35);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        thead {
            background: transparent;
        }

        thead th {
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            color: #ffffff;
            text-align: left;
            padding: 16px 20px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        thead th:first-child {
            border-radius: 999px 0 0 999px;
        }

        thead th:last-child {
            border-radius: 0 999px 999px 0;
        }

        tbody tr {
            background: #f0f7ff;
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            transform: scale(1.01);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
        }

        tbody td {
            padding: 16px 20px;
            font-size: 14px;
            color: #1e3a5f;
        }

        tbody td:first-child {
            border-radius: 999px 0 0 999px;
        }

        tbody td:last-child {
            border-radius: 0 999px 999px 0;
        }

        td.id-cell {
            font-weight: 700;
            color: #2563eb;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Users</h2>
            <span class="badge"><?= count($users) ?> total</span>
        </div>

        <?php if (!empty($users)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="id-cell"><?= $user['id'] ?></td>
                        <td><?= $user['firstname'] ?></td>
                        <td><?= $user['lastname'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['username'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
            <div class="empty">No users found.</div>
        <?php endif; ?>
    </div>
</body>
</html>