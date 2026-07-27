<?php
declare(strict_types=1);
require_once 'includes/config.php';
$pageTitle = 'JavaScript Pop-ups';
require 'includes/header.php';
?>
<section class="page-hero compact">
    <span class="eyebrow">JavaScript demonstration</span>
    <h1>Three pop-ups. <em>Three purposes.</em></h1>
    <p>Use the controls below to demonstrate JavaScript alert, confirm, and prompt dialog boxes.</p>
</section>
<section class="section popup-grid">
    <article class="popup-card"><span>01</span><h2>Alert</h2><p>Displays a message and waits for the user to acknowledge it.</p><button class="button primary" type="button" data-popup="alert">Try alert()</button></article>
    <article class="popup-card featured"><span>02</span><h2>Confirm</h2><p>Asks the user to approve or cancel an action and returns a Boolean value.</p><button class="button primary" type="button" data-popup="confirm">Try confirm()</button></article>
    <article class="popup-card"><span>03</span><h2>Prompt</h2><p>Requests a short text response and makes the entered value available to JavaScript.</p><button class="button primary" type="button" data-popup="prompt">Try prompt()</button></article>
</section>
<div id="popup-result" class="result-box" aria-live="polite">Your interaction result will appear here.</div>
<?php require 'includes/footer.php'; ?>

