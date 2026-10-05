<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f5f5f1">
    <title>Add product | Stockroom</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url('css/stockroom.css')) ?>">
</head>
<body>
    <main class="page-shell">
        <header class="topbar">
            <a class="brand" href="<?= site_url('products') ?>" aria-label="Stockroom home">
                <span class="brand-mark brand-mark-small" aria-hidden="true">S</span>
                <span>stockroom<span class="brand-dot">.</span></span>
            </a>
            <span class="account-name"><?= htmlspecialchars($username ?? 'Signed in') ?></span>
        </header>
        <section class="card form-card">
            <p class="eyebrow">NEW ITEM</p>
            <h1>Add a product</h1>

            <?php if (!empty($error)): ?>
                <div class="alert" role="alert"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form class="product-form" method="post" action="<?= site_url('products/store') ?>">
                <label for="product_name">Product name
                    <input type="text" id="product_name" name="product_name" required>
                </label>

                <label for="description">Description
                    <textarea id="description" name="description" rows="4" required></textarea>
                </label>

                <div class="form-row">
                    <label for="price">Price
                        <input type="number" step="0.01" min="0" id="price" name="price" required>
                    </label>
                    <label for="quantity">Quantity
                        <input type="number" min="0" id="quantity" name="quantity" required>
                    </label>
                </div>

                <div class="form-actions">
                    <a href="<?= site_url('products') ?>" class="btn btn-quiet">Cancel</a>
                    <button class="btn btn-primary" type="submit">Add product</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
