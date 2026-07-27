<?php
declare(strict_types=1);
require_once 'includes/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $name = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    if (strlen($name) < 2 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        $error = 'Enter a valid name and email, and use at least 8 characters for the password.';
    } else {
        try {
            db()->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)')
                ->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
            flash('success', 'Account created successfully. You can now sign in.');
            header('Location: login.php');
            exit;
        } catch (PDOException $exception) {
            $error = 'An account with that email address already exists.';
        }
    }
}
$pageTitle = 'Register';
require 'includes/header.php';
?>
<section class="auth-layout register-layout">
    <div class="auth-intro"><span class="eyebrow light">Join the workspace</span><h1>One account. Better teamwork.</h1><p>Create your secure account to manage Awesome Group’s company records.</p></div>
    <form class="auth-card" method="post">
        <span class="eyebrow">Create account</span><h2>Get started today</h2>
        <?php if ($error): ?><div class="error-box"><?= e($error) ?></div><?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <label>Full name<input name="full_name" required autocomplete="name" value="<?= e($_POST['full_name'] ?? '') ?>" placeholder="Your full name"></label>
        <label>Email address<input type="email" name="email" required autocomplete="email" value="<?= e($_POST['email'] ?? '') ?>" placeholder="name@company.com"></label>
        <label>Password<input type="password" name="password" required minlength="8" autocomplete="new-password" placeholder="At least 8 characters"></label>
        <button class="button primary full" type="submit">Create account →</button>
        <p class="form-switch">Already registered? <a href="login.php">Sign in</a></p>
    </form>
</section>
<?php require 'includes/footer.php'; ?>

