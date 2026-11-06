<?php
require_once __DIR__ . '/functions.php';
$user = current_user();
$flashMessage = get_flash();
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?> · <?= APP_NAME ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/style.css">
</head>
<body>
<header class="topbar">
  <a class="brand" href="<?= $user ? BASE_URL . dashboard_url($user['role']) : BASE_URL . '/index.php' ?>">
    <span class="brand-mark">✦</span><span>Campus Feedback <b>Lens</b></span>
  </a>
  <nav class="nav-links">
    <?php if ($user): ?>
      <span class="user-chip"><?= e(ucfirst($user['role'])) ?> · <?= e($user['name']) ?></span>
      <a href="<?= BASE_URL . dashboard_url($user['role']) ?>">Dashboard</a>
      <a class="nav-logout" href="<?= BASE_URL ?>/logout.php">Sign out</a>
    <?php else: ?>
      <a href="<?= BASE_URL ?>/login.php">Sign in</a>
      <a class="nav-cta" href="<?= BASE_URL ?>/login.php?role=student">Submit feedback</a>
    <?php endif; ?>
  </nav>
</header>
<main class="main-wrap">
<?php if ($flashMessage): ?>
  <div class="alert <?= e($flashMessage['type']) ?>"><?= e($flashMessage['message']) ?></div>
<?php endif; ?>
