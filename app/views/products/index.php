<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0908">
    <title>Products | Stockroom</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url('css/stockroom.css')) ?>">
</head>
<body class="page-shell dashboard">
    <header class="topbar">
        <a class="brand" href="<?= site_url('products') ?>" aria-label="Stockroom home">
            <span>Stockroom</span>
        </a>
        <div class="account">
            <span class="account-name"><?= htmlspecialchars($username ?? 'Guest') ?></span>
            <?php if ($logged_in): ?>
                <form class="inline-form" method="post" action="<?= site_url('auth/logout') ?>">
                    <button class="btn btn-quiet" type="submit">Log out</button>
                </form>
            <?php else: ?>
                <a href="<?= site_url('login') ?>" class="btn btn-quiet">Log in</a>
            <?php endif; ?>
        </div>
    </header>
    <main class="page-content">
        <section class="stock-summary" aria-label="Stock summary">
            <div class="summary-stat">
                <strong><?= number_format($summary['products']) ?></strong>
                <span>products</span>
            </div>
            <div class="summary-stat">
                <strong><?= number_format($summary['units']) ?></strong>
                <span>units on hand</span>
            </div>
            <div class="summary-stat">
                <strong><?= htmlspecialchars('₱' . number_format($summary['value'], 2)) ?></strong>
                <span>stock value</span>
            </div>
            <div class="summary-stat">
                <strong><?= number_format($summary['low_stock']) ?></strong>
                <span>low on stock (≤ 5)</span>
            </div>
        </section>

        <form class="search-form" method="get" action="<?= site_url('products') ?>">
            <label class="visually-hidden" for="product-search">Search product name</label>
            <input
                id="product-search"
                type="search"
                name="q"
                value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Search product name"
            >
        </form>

        <?php if ($logged_in): ?>
            <a href="<?= site_url('products/create') ?>" class="btn btn-primary add-product-button">Add product</a>
        <?php endif; ?>

        <div class="card">
            <?php if (!empty($products)): ?>
                <div class="table-scroll"><table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <span class="product-name"><?= htmlspecialchars($product['product_name']) ?></span>
                                    <?php if (!empty($product['description'])): ?>
                                        <span class="product-description"><?= htmlspecialchars($product['description']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="numeric"><?= htmlspecialchars('₱' . number_format((float) $product['price'], 2)) ?></td>
                                <td><span class="quantity-pill"><?= number_format((int) $product['quantity']) ?></span></td>
                                <td class="date-cell"><?= !empty($product['created_at']) ? htmlspecialchars(date('Y-m-d', strtotime($product['created_at']))) : '—' ?></td>
                                <td>
                                    <?php if ($logged_in): ?>
                                        <div class="actions-inline">
                                            <a href="<?= site_url('products/edit/' . $product['id']) ?>" class="btn btn-quiet">Edit</a>
                                            <form class="inline-form" method="post" action="<?= site_url('products/delete/' . $product['id']) ?>">
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Delete this product?');">Delete</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table></div>
            <?php elseif ($search !== ''): ?>
                <div class="empty">No products match “<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>”.</div>
            <?php else: ?>
                <div class="empty">No products found.</div>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>
