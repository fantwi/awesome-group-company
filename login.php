<?php
declare(strict_types=1);
require_once 'includes/config.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = strtolower(trim($_POST['email'] ?? ''));
    $statement = db()->prepare('SELECT * FROM users WHERE email = ?');
    $statement->execute([$email]);
    $user = $statement->fetch();
    if ($user && password_verify($_POST['password'] ?? '', $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        flash('success', 'Welcome back, ' . $user['full_name'] . '!');
        header('Location: dashboard.php');
        exit;
    }
    $error = 'The email address or password is incorrect.';
}
$pageTitle = 'Staff Login';
require 'includes/header.php';
?>
<section class="auth-layout">
    <div class="auth-intro"><span class="eyebrow light">Information system</span><h1>Your company data, organised.</h1><p>Sign in to add, retrieve, update, and delete operational records.</p></div>
    <form class="auth-card" method="post">
        <span class="eyebrow">Welcome back</span><h2>Sign in to your account</h2>
        <?php if ($error): ?><div class="error-box"><?= e($error) ?></div><?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Email address<input type="email" name="email" required autocomplete="email" placeholder="name@company.com"></label>
        <label>Password<input type="password" name="password" required autocomplete="current-password" placeholder="Enter your password"></label>
        <button class="button primary full" type="submit">Sign in →</button>
        <div class="demo-credentials"><strong>Demo account</strong><code><?= DEMO_EMAIL ?></code><code><?= DEMO_PASSWORD ?></code></div>
        <p class="form-switch">New here? <a href="register.php">Create an account</a></p>
    </form>
</section>
<?php require 'includes/footer.php'; ?>

