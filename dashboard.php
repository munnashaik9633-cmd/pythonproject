<?php
require_once __DIR__ . '/../includes/functions.php';
$user = require_role('student');
$stmt = db()->prepare("SELECT f.id, f.session_name, f.created_at, s.name AS subject_name, u.name AS faculty_name, f.teaching, f.communication, f.punctuality, f.knowledge, f.interaction FROM feedback f JOIN subjects s ON s.id=f.subject_id JOIN users u ON u.id=f.faculty_id WHERE f.student_id=? ORDER BY f.created_at DESC");
$stmt->execute([$user['id']]); $submitted = $stmt->fetchAll();
$subjects = db()->query("SELECT s.id, s.name, s.code, u.name faculty_name, d.name department_name FROM subjects s JOIN users u ON u.id=s.faculty_id LEFT JOIN departments d ON d.id=s.department_id WHERE s.is_active=1 ORDER BY s.name")->fetchAll();
$pageTitle = 'Student dashboard';
require __DIR__ . '/../includes/header.php';
?>
<div class="page-heading"><div><div class="eyebrow">STUDENT PORTAL</div><h1>Your feedback matters.</h1><p>Share an honest view of your learning experience. Your identity is never shown to faculty.</p></div><span class="page-symbol">✦</span></div>
<div class="stats-grid two-stats"><div class="stat-card"><span class="stat-label">SUBMISSIONS MADE</span><strong><?= count($submitted) ?></strong><small>Feedback responses recorded</small></div><div class="stat-card"><span class="stat-label">AVAILABLE SUBJECTS</span><strong><?= count($subjects) ?></strong><small>Subjects open for feedback</small></div></div>
<div class="content-card">
  <div class="card-heading"><div><h2>Available subjects</h2><p>Select a subject and submit your feedback for this session.</p></div></div>
  <?php if (!$subjects): ?><p class="empty-state">No active subjects are available yet. Please contact your administrator.</p><?php else: ?>
  <div class="table-wrap"><table><thead><tr><th>Subject</th><th>Faculty</th><th>Department</th><th>Action</th></tr></thead><tbody>
  <?php foreach ($subjects as $s): ?>
    <tr><td><b><?= e($s['name']) ?></b><small class="table-sub"><?= e($s['code']) ?></small></td><td><?= e($s['faculty_name']) ?></td><td><?= e($s['department_name'] ?? '—') ?></td><td><a class="table-action" href="/student/feedback.php?subject_id=<?= (int)$s['id'] ?>">Give feedback →</a></td></tr>
  <?php endforeach; ?>
  </tbody></table></div><?php endif; ?>
</div>
<div class="content-card">
  <div class="card-heading"><div><h2>Your recent submissions</h2><p>Only you can see the subjects you have responded to.</p></div></div>
  <?php if (!$submitted): ?><p class="empty-state">You haven't submitted feedback yet.</p><?php else: ?>
  <div class="table-wrap"><table><thead><tr><th>Subject</th><th>Faculty</th><th>Session</th><th>Average rating</th><th>Date</th></tr></thead><tbody>
  <?php foreach ($submitted as $f): ?><tr><td><?= e($f['subject_name']) ?></td><td><?= e($f['faculty_name']) ?></td><td><?= e($f['session_name']) ?></td><td><span class="rating-pill"><?= number_format(average_rating($f),1) ?>/5</span></td><td><?= e(date('d M Y', strtotime($f['created_at']))) ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
