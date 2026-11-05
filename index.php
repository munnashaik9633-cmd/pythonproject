<?php
require_once __DIR__ . '/includes/functions.php';
$pageTitle = 'Your Feedback, Better Education';
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <div class="eyebrow"><span class="eyebrow-dot"></span> FOR COLLEGES & UNIVERSITIES</div>
    <h1>Your Feedback,<br><span>Better Education.</span></h1>
    <p class="hero-lead">A single place for students to rate teaching and facilities, and for management to see clear, anonymous insights on what's working and what needs attention.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="<?= BASE_URL ?>/login.php?role=student">Submit feedback <span>↗</span></a>
      <a class="btn btn-light" href="<?= BASE_URL ?>/login.php?role=admin">Admin login</a>
    </div>
    <div class="hero-note"><span class="avatar-stack"><i> S </i><i> F </i><i> A </i></span><span>One platform for students, faculty and management</span></div>
  </div>
  <div class="hero-visual">
    <div class="visual-orbit orbit-one"></div><div class="visual-orbit orbit-two"></div>
    <div class="visual-card">
      <div class="visual-card-top"><span class="mini-label">CAMPUS PULSE</span><span class="live-dot">● LIVE</span></div>
      <div class="visual-score">4.6<span>/5</span></div>
      <div class="visual-stars">★★★★★</div>
      <div class="visual-caption">Overall teaching experience</div>
      <div class="mini-bars"><i style="height:38%"></i><i style="height:58%"></i><i style="height:49%"></i><i style="height:76%"></i><i style="height:64%"></i><i style="height:92%"></i><i style="height:80%"></i><i style="height:100%"></i></div>
      <div class="visual-card-bottom"><span>Feedback overview</span><b>+12.8% <small>this term</small></b></div>
    </div>
    <div class="float-note note-a"><span class="float-icon">✓</span><span><b>Anonymous by design</b><small>Your voice stays private</small></span></div>
    <div class="float-note note-b"><span class="float-icon purple">↗</span><span><b>Actionable insights</b><small>Turn feedback into progress</small></span></div>
  </div>
</section>
<section class="feature-section">
  <div class="section-heading"><div class="eyebrow">THE COMPLETE FEEDBACK CYCLE</div><h2>Everything a feedback cycle needs</h2><p>From collecting responses to presenting results at the academic council meeting.</p></div>
  <div class="feature-grid">
    <article class="feature-card"><div class="feature-icon blue">☷</div><h3>Structured feedback forms</h3><p>1–5 rating on teaching, communication, punctuality, knowledge and interaction.</p></article>
    <article class="feature-card"><div class="feature-icon violet">⌁</div><h3>Live analysis dashboards</h3><p>Faculty, subject and department comparisons with clear rating summaries.</p></article>
    <article class="feature-card"><div class="feature-icon green">◉</div><h3>Anonymous by design</h3><p>Faculty see summaries and comments — never who wrote them.</p></article>
    <article class="feature-card"><div class="feature-icon orange">♙</div><h3>Role-based access</h3><p>Separate dashboards for students, faculty and administrators.</p></article>
    <article class="feature-card"><div class="feature-icon pink">▤</div><h3>PDF & CSV reports</h3><p>Export filtered institution reports for review and action.</p></article>
    <article class="feature-card"><div class="feature-icon teal">✓</div><h3>One response per session</h3><p>Duplicate submissions for the same subject and session are blocked.</p></article>
  </div>
</section>
<section class="audience-strip">
  <div><span class="audience-icon">♧</span><b>For Students</b><p>Speak up safely and see that your response was recorded.</p></div>
  <div><span class="audience-icon">⌂</span><b>For Faculty</b><p>Understand strengths and concrete areas to improve.</p></div>
  <div><span class="audience-icon">▥</span><b>For Management</b><p>Compare departments and subjects with evidence, not anecdotes.</p></div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>
