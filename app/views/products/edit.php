<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body { margin:0; font-family:Arial,sans-serif; background:#f8fafc; color:#0f172a; }
        .container { max-width:700px; margin:40px auto; padding:24px; }
        .card { background:white; border-radius:18px; box-shadow:0 10px 30px rgba(15,23,42,0.08); padding:28px; }
        h1 { margin-top:0; color:#1d4ed8; }
        .alert { background:#fee2e2; color:#991b1b; border-radius:10px; padding:10px 14px; margin-bottom:18px; }
        label { display:block; margin:14px 0 8px; font-weight:600; }
        input, textarea { width:100%; padding:12px 14px; border-radius:10px; border:1px solid #cbd5e1; box-sizing:border-box; }
        textarea { min-height:120px; resize:vertical; }
        .row { display:flex; gap:16px; }
        .row > div { flex:1; }
        .actions { margin-top:20px; display:flex; gap:12px; flex-wrap:wrap; }
        .btn { display:inline-block; padding:10px 16px; border-radius:10px; text-decoration:none; font-weight:600; }
        .btn-primary { background:#2563eb; color:#fff; border:none; }
        .btn-muted { background:#e2e8f0; color:#1f2937; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <h1>Edit Product</h1>

            <?php if (!empty($error)): ?>
                <div class="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('products/update/' . $product['id']) ?>">
                <label for="product_name">Product Name</label>
                <input type="text" id="product_name" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>

                <label for="description">Description</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

                <div class="row">
                    <div>
                        <label for="price">Price</label>
                        <input type="number" step="0.01" min="0" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
                    </div>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input type="number" min="0" id="quantity" name="quantity" value="<?= htmlspecialchars($product['quantity']) ?>" required>
                    </div>
                </div>

                <div class="actions">
                    <button class="btn btn-primary" type="submit">Update Product</button>
                    <a href="<?= site_url('products') ?>" class="btn btn-muted">Back to Products</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
