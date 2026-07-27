<?php
declare(strict_types=1);
require_once 'includes/config.php';
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $sent = true;
}
$pageTitle = 'Contact';
require 'includes/header.php';
?>
<section class="page-hero compact">
    <span class="eyebrow">Contact us</span>
    <h1>Let’s create something <em>awesome.</em></h1>
    <p>Tell us what you are working on. Our team will get back to you as soon as possible.</p>
</section>
<section class="section contact-layout">
    <div class="contact-details">
        <span class="eyebrow">Get in touch</span>
        <h2>Good conversations start here.</h2>
        <p>Whether you have a complete brief or just the start of an idea, we would love to hear from you.</p>
        <div class="contact-item"><span>@</span><div><strong>Email</strong><a href="mailto:hello@awesomegroup.test">hello@awesomegroup.test</a></div></div>
        <div class="contact-item"><span>☎</span><div><strong>Phone</strong><a href="tel:+233200000000">+233 20 000 0000</a></div></div>
        <div class="contact-item"><span>⌖</span><div><strong>Office</strong><p>Cape Coast, Ghana</p></div></div>
    </div>
    <form class="form-card" method="post">
        <?php if ($sent): ?><div class="success-box">Thank you! Your demonstration message has been received.</div><?php endif; ?>
        <input type="hidden" name="csrf_token" value="<?= e(csrfToken()) ?>">
        <div class="form-row">
            <label>Full name<input name="name" required placeholder="Your name"></label>
            <label>Email address<input type="email" name="email" required placeholder="you@example.com"></label>
        </div>
        <label>Subject<input name="subject" required placeholder="How can we help?"></label>
        <label>Message<textarea name="message" rows="6" required placeholder="Tell us a little about your project..."></textarea></label>
        <button class="button primary" type="submit">Send message →</button>
    </form>
</section>
<?php require 'includes/footer.php'; ?>

