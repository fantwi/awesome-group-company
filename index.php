<?php
declare(strict_types=1);
require_once 'includes/config.php';
$pageTitle = 'Home';
require 'includes/header.php';
?>
<section class="hero">
    <div class="hero-copy">
        <span class="eyebrow">Technology • Consulting • Growth</span>
        <h1>Building systems that move <em>great ideas</em> forward.</h1>
        <p>Awesome Group Company transforms ambitious business ideas into reliable digital services, backed by a team that cares about measurable results.</p>
        <div class="hero-actions">
            <a class="button primary" href="about.php">Discover our company <span>→</span></a>
            <a class="button ghost" href="contact.php">Start a conversation</a>
        </div>
        <div class="hero-stats">
            <div><strong>12+</strong><span>Projects delivered</span></div>
            <div><strong>4</strong><span>Focused specialists</span></div>
            <div><strong>100%</strong><span>Committed</span></div>
        </div>
    </div>
    <div class="slider" aria-label="Company highlights">
        <div class="slider-orbit"></div>
        <img id="slider-image" src="assets/images/slide-1.svg" alt="Digital collaboration illustration">
        <button class="slider-arrow previous" type="button" aria-label="Previous image">←</button>
        <button class="slider-arrow next" type="button" aria-label="Next image">→</button>
        <div class="slider-caption">
            <span id="slide-number">01 / 05</span>
            <strong id="slide-title">Ideas into impact</strong>
        </div>
    </div>
</section>

<section class="ticker" aria-label="Company announcements">
    <span class="ticker-label">Now at Awesome</span>
    <div class="ticker-window"><p id="scrolling-text">Innovating together • Building secure systems • Creating lasting value • Your vision, engineered brilliantly •</p></div>
</section>

<section class="section team-section">
    <div class="section-heading">
        <div><span class="eyebrow">Meet the team</span><h2>Four minds. One mission.</h2></div>
        <p>Our group combines research, design, development, and data skills to create a complete information system.</p>
    </div>
    <div class="team-grid">
        <?php
        $members = [
            ['Member One', 'STUDENT-ID-001', 'Project Lead', 'M1', 'coral'],
            ['Member Two', 'STUDENT-ID-002', 'UI/UX Designer', 'M2', 'blue'],
            ['Member Three', 'STUDENT-ID-003', 'Backend Developer', 'M3', 'gold'],
            ['Member Four', 'STUDENT-ID-004', 'Database Engineer', 'M4', 'green'],
        ];
        foreach ($members as $member):
        ?>
        <article class="team-card">
            <div class="avatar <?= e($member[4]) ?>"><span><?= e($member[3]) ?></span></div>
            <div><span class="member-role"><?= e($member[2]) ?></span><h3><?= e($member[0]) ?></h3><p><?= e($member[1]) ?></p></div>
        </article>
        <?php endforeach; ?>
    </div>
    <p class="edit-note">Replace the placeholder names, IDs, and avatar areas in <code>index.php</code> with your group’s details and photographs.</p>
</section>

<section class="cta-strip">
    <div><span class="eyebrow light">Protected workspace</span><h2>Manage company records securely.</h2></div>
    <a class="button light-button" href="login.php">Open information system →</a>
</section>
<?php require 'includes/footer.php'; ?>

