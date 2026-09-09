<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 24px;
        }
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }
        h1 {
            margin: 0;
            color: #1d4ed8;
        }
        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: #2563eb;
            color: #fff;
        }
        .btn-danger {
            background: #dc2626;
            color: #fff;
        }
        .btn-muted {
            background: #e2e8f0;
            color: #1f2937;
        }
        .card {
            background: white;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .empty {
            padding: 32px;
            text-align: center;
            color: #64748b;
        }
        .actions-inline {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .small {
            color: #64748b;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topbar">
            <div>
                <h1>Products</h1>
                <div class="small">Logged in as <?= htmlspecialchars($username ?? 'Guest') ?></div>
            </div>
            <div class="actions">
                <?php if ($logged_in): ?>
                    <a href="<?= site_url('products/create') ?>" class="btn btn-primary">Add Product</a>
                    <a href="<?= site_url('auth/logout') ?>" class="btn btn-muted">Logout</a>
                <?php else: ?>
                    <a href="<?= site_url('login') ?>" class="btn btn-primary">Login</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <?php if (!empty($products)): ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= htmlspecialchars($product['id']) ?></td>
                                <td><?= htmlspecialchars($product['product_name']) ?></td>
                                <td><?= htmlspecialchars($product['description']) ?></td>
                                <td><?= htmlspecialchars($product['price']) ?></td>
                                <td><?= htmlspecialchars($product['quantity']) ?></td>
                                <td><?= htmlspecialchars($product['created_at']) ?></td>
                                <td>
                                    <?php if ($logged_in): ?>
                                        <div class="actions-inline">
                                            <a href="<?= site_url('products/edit/' . $product['id']) ?>" class="btn btn-muted">Edit</a>
                                            <a href="<?= site_url('products/delete/' . $product['id']) ?>" class="btn btn-danger" onclick="return confirm('Delete this product?');">Delete</a>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty">No products found.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
