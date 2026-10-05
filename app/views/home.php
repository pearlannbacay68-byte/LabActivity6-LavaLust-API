<?php

defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$dashboardUrl = !empty($logged_in) ? site_url('products') : site_url('login');
$dashboardLabel = !empty($logged_in) ? 'Open stockroom' : 'Sign in';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#111315">
    <meta name="description" content="Manage stock and connect to the Stockroom inventory API.">
    <title>Stockroom | Inventory API</title>
    <link rel="stylesheet" href="<?= htmlspecialchars(base_url('css/stockroom.css')) ?>">
</head>
<body class="landing-page">
    <header class="landing-nav">
        <a class="landing-brand" href="<?= site_url('/') ?>" aria-label="Stockroom home">
            <span class="landing-brand-mark" aria-hidden="true">S</span>
            <span>Stockroom<span class="landing-brand-dot">.</span></span>
        </a>
        <nav class="landing-nav-links" aria-label="Main navigation">
            <a href="<?= site_url('api') ?>">API</a>
            <a href="<?= site_url('register') ?>">Register</a>
            <a class="landing-nav-cta" href="<?= $dashboardUrl ?>"><?= $dashboardLabel ?> <span aria-hidden="true">↗</span></a>
        </nav>
    </header>

    <main>
        <section class="landing-hero">
            <div class="landing-copy">
                <p class="landing-kicker"><span></span> INVENTORY MANAGEMENT, MADE CLEAR</p>
                <h1>Know your stock.<br><span>Move with confidence.</span></h1>
                <p class="landing-description">
                    Keep products organized, track what is on hand, and get a clear view of your stockroom from one simple dashboard.
                </p>
                <div class="landing-actions">
                    <a class="landing-button landing-button-primary" href="<?= $dashboardUrl ?>"><?= $dashboardLabel ?> <span aria-hidden="true">→</span></a>
                    <a class="landing-button landing-button-secondary" href="<?= site_url('api') ?>">Explore the API <span aria-hidden="true">↗</span></a>
                </div>
                <p class="landing-note"><span class="landing-status-dot"></span> Stockroom API is ready to connect</p>
            </div>

            <aside class="landing-preview" aria-label="Example API response">
                <div class="preview-topbar">
                    <div class="preview-lights" aria-hidden="true"><i></i><i></i><i></i></div>
                    <span>GET /api</span>
                    <span class="preview-method">200 OK</span>
                </div>
                <div class="preview-body">
                    <p class="preview-comment">// Your stockroom, ready when you are.</p>
                    <pre><code>{
  <span>"name"</span>: <span>"LavaLust Product Management API"</span>,
  <span>"status"</span>: <span class="preview-green">"ok"</span>,
  <span>"version"</span>: <span class="preview-orange">"1.0.0"</span>,
  <span>"endpoints"</span>: [
    <span>"POST /api/auth/login"</span>,
    <span>"GET|POST /api/products"</span>
  ]
}</code></pre>
                </div>
                <a class="preview-footer" href="<?= site_url('api') ?>">View API overview <span aria-hidden="true">→</span></a>
            </aside>
        </section>

        <section class="landing-features" aria-label="Stockroom features">
            <article>
                <span class="feature-number">01</span>
                <h2>See the full picture</h2>
                <p>Review product counts, units on hand, stock value, and low-stock items at a glance.</p>
            </article>
            <article>
                <span class="feature-number">02</span>
                <h2>Find items faster</h2>
                <p>Search your product list and get to the inventory details you need without the clutter.</p>
            </article>
            <article>
                <span class="feature-number">03</span>
                <h2>Connect your tools</h2>
                <p>Use the API endpoints for authentication and product management in your own client.</p>
            </article>
        </section>
    </main>

    <footer class="landing-footer">
        <span>Stockroom <span class="landing-brand-dot">.</span></span>
        <span>Inventory management &amp; API</span>
        <a href="<?= site_url('api') ?>">API overview <span aria-hidden="true">↗</span></a>
    </footer>
</body>
</html>
