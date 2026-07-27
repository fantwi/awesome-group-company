<?php
declare(strict_types=1);
require_once 'includes/config.php';
$pageTitle = 'About the Company';
require 'includes/header.php';
?>
<section class="page-hero">
    <span class="eyebrow">About Awesome Group</span>
    <h1>We make complex business challenges feel <em>possible.</em></h1>
    <p>We are a multidisciplinary technology company helping organisations work smarter through thoughtful strategy and dependable digital systems.</p>
</section>
<section class="section story-grid">
    <div class="story-visual">
        <span>AG</span>
        <div class="floating-note"><strong>Our promise</strong><br>Clarity at every step.</div>
    </div>
    <div class="story-copy">
        <span class="eyebrow">Our story</span>
        <h2>Created to turn teamwork into momentum.</h2>
        <p>Awesome Group Company began with a simple belief: the best systems are designed around people. Our team brings together business insight, accessible design, and practical engineering.</p>
        <p>From an early idea to daily operations, we work alongside our clients to create solutions that are secure, useful, and built to grow.</p>
        <div class="values-list">
            <div><span>01</span><strong>Think clearly</strong><p>We simplify the complicated.</p></div>
            <div><span>02</span><strong>Build responsibly</strong><p>Security and quality come first.</p></div>
            <div><span>03</span><strong>Grow together</strong><p>Partnership powers progress.</p></div>
        </div>
    </div>
</section>
<section class="section services">
    <div class="section-heading"><div><span class="eyebrow">What we do</span><h2>Services built around progress.</h2></div></div>
    <div class="service-grid">
        <article><span class="service-icon">⌁</span><h3>Digital Systems</h3><p>Purpose-built information systems that organise work and make good decisions easier.</p></article>
        <article><span class="service-icon">✦</span><h3>Business Advisory</h3><p>Practical research and strategy that turns challenges into clear, achievable plans.</p></article>
        <article><span class="service-icon">◎</span><h3>Data & Insights</h3><p>Clean, useful reporting that gives teams confidence in what they do next.</p></article>
    </div>
</section>
<?php require 'includes/footer.php'; ?>

