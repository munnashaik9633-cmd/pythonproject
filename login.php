<?php
require_once __DIR__ . '/includes/functions.php';
if (current_user()) redirect(dashboard_url(current_user()['role']));
$error = '';
$selectedRole = $_GET['role'] ?? 'student';
if (!in_array($selectedRole, ['student','faculty','admin'], true)) $selectedRole = 'student';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'student';
    $stmt = db()->prepare("SELECT id, name, username, password_hash, role, department_id FROM users WHERE username = ? AND role = ? AND is_active = 1 LIMIT 1");
    $stmt->execute([$username, $role]);
    $record = $stmt->fetch();
    if ($record && password_verify($password, $record['password_hash'])) {
        unset($record['password_hash']);
        session_regenerate_id(true);
        $_SESSION['user'] = $record;
        redirect(dashboard_url($role));
    }
    $error = 'Incorrect username, password or account type.';
    $selectedRole = in_array($role, ['student','faculty','admin'], true) ? $role : 'student';
}
$pageTitle = 'Sign in';
require __DIR__ . '/includes/header.php';
?>
<div class="auth-layout">
  <div class="auth-aside"><div class="eyebrow light-eyebrow">CAMPUS FEEDBACK LENS</div><h1>Every voice<br>moves us <span>forward.</span></h1><p>Thoughtful feedback creates better classrooms, stronger connections and a better campus experience.</p><div class="auth-aside-bottom">✦ &nbsp; Your feedback. Your impact.</div></div>
  <div class="auth-panel">
    <div class="auth-heading"><div class="eyebrow">WELCOME BACK</div><h2>Sign in</h2><p>Choose your role to continue.</p></div>
    <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-stack">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <div class="role-tabs">
        <?php foreach (['student'=>'Student','faculty'=>'Faculty','admin'=>'Admin'] as $role=>$label): ?>
          <label class="role-option"><input type="radio" name="role" value="<?= $role ?>" <?= $selectedRole === $role ? 'checked' : '' ?>><span><?= $label ?></span></label>
        <?php endforeach; ?>
      </div>
      <label>Username<input name="username" autocomplete="username" placeholder="Enter your username" required></label>
      <label>Password<input type="password" name="password" autocomplete="current-password" placeholder="Enter your password" required></label>
      <button class="btn btn-primary btn-full" type="submit">Sign in as <span id="role-label"><?= e($selectedRole) ?></span> <span>→</span></button>
    </form>
    <div class="demo-box"><b>Demo accounts</b><p>Use these accounts after running setup.php.</p>
      <div class="demo-credentials"><span>Student</span><code>student / student123</code><button type="button" data-fill-user="student" data-fill-pass="student123">Fill</button></div>
      <div class="demo-credentials"><span>Faculty</span><code>faculty / faculty123</code><button type="button" data-fill-user="faculty" data-fill-pass="faculty123">Fill</button></div>
      <div class="demo-credentials"><span>Admin</span><code>admin / admin123</code><button type="button" data-fill-user="admin" data-fill-pass="admin123">Fill</button></div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/includes/footer.php'; ?>
