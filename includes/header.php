<?php
declare(strict_types=1);
$pageTitle = $pageTitle ?? APP_NAME;
$currentPage = basename($_SERVER['PHP_SELF']);
$flashMessage = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Awesome Group Company information system">
    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/main.js" defer></script>
</head>
<body>
<header class="site-header">
    <a class="brand" href="index.php" aria-label="Awesome Group home">
        <span class="brand-mark">A</span>
        <span>Awesome<span>Group</span></span>
    </a>
    <button class="menu-toggle" type="button" aria-label="Open navigation" aria-expanded="false">☰</button>
    <nav class="site-nav" aria-label="Main navigation">
        <a class="<?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
        <a class="<?= $currentPage === 'about.php' ? 'active' : '' ?>" href="about.php">Company</a>
        <a class="<?= $currentPage === 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a>
        <a class="<?= $currentPage === 'popups.php' ? 'active' : '' ?>" href="popups.php">Pop-ups</a>
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a class="<?= $currentPage === 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Records</a>
            <a class="nav-button" href="logout.php">Log out</a>
        <?php else: ?>
            <a href="login.php">Log in</a>
            <a class="nav-button" href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
<?php if ($flashMessage): ?>
    <div class="flash <?= e($flashMessage['type']) ?>" role="status"><?= e($flashMessage['message']) ?></div>
<?php endif; ?>
<main>

