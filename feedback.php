<?php
require_once __DIR__ . '/../includes/functions.php';
$user = require_role('student');
$subjectId = (int)($_GET['subject_id'] ?? $_POST['subject_id'] ?? 0);
$stmt = db()->prepare("SELECT s.*, u.name faculty_name, d.name department_name FROM subjects s JOIN users u ON u.id=s.faculty_id LEFT JOIN departments d ON d.id=s.department_id WHERE s.id=? AND s.is_active=1");
$stmt->execute([$subjectId]); $subject = $stmt->fetch();
if (!$subject) { flash('error','Subject not found or inactive.'); redirect('/student/dashboard.php'); }
$sessionName = trim($_POST['session_name'] ?? '2026-27 Semester 1');
$already = db()->prepare("SELECT id FROM feedback WHERE student_id=? AND subject_id=? AND session_name=?");
$already->execute([$user['id'],$subjectId,$sessionName]);
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $ratings = [];
    foreach (['teaching','communication','punctuality','knowledge','interaction'] as $key) {
        $ratings[$key] = (int)($_POST[$key] ?? 0);
        if ($ratings[$key] < 1 || $ratings[$key] > 5) $error = 'Please provide a rating from 1 to 5 for every criterion.';
    }
    $comment = trim($_POST['comment'] ?? '');
    if (mb_strlen($comment) > 1500) $error = 'Comments must be 1,500 characters or fewer.';
    if ($already->fetch()) $error = 'You have already submitted feedback for this subject and session.';
    if (!$error) {
        try {
            $insert = db()->prepare("INSERT INTO feedback (student_id, subject_id, faculty_id, session_name, teaching, communication, punctuality, knowledge, interaction, comment) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $insert->execute([$user['id'],$subjectId,$subject['faculty_id'],$sessionName,$ratings['teaching'],$ratings['communication'],$ratings['punctuality'],$ratings['knowledge'],$ratings['interaction'],$comment ?: null]);
            flash('success','Thank you! Your anonymous feedback has been recorded.');
            redirect('/student/dashboard.php');
        } catch (PDOException $ex) {
            if ($ex->getCode() === '23000') $error = 'A response for this subject and session has already been recorded.';
            else throw $ex;
        }
    }
}
$pageTitle = 'Submit feedback';
require __DIR__ . '/../includes/header.php';
$criteria = ['teaching'=>'Teaching quality','communication'=>'Communication','punctuality'=>'Punctuality','knowledge'=>'Subject knowledge','interaction'=>'Student interaction'];
?>
<div class="form-page">
  <a class="back-link" href="<?= BASE_URL ?>/student/dashboard.php">← Back to dashboard</a>
  <div class="form-intro"><div class="eyebrow">YOUR VOICE MATTERS</div><h1>Share your feedback</h1><p>Your response is confidential. Faculty can view only combined results, not individual identities.</p></div>
  <div class="subject-summary"><div><span class="summary-label">SUBJECT</span><b><?= e($subject['name']) ?> <small>(<?= e($subject['code']) ?>)</small></b><span><?= e($subject['faculty_name']) ?> · <?= e($subject['department_name'] ?? '') ?></span></div><span class="lock-icon">⌑</span></div>
  <?php if ($error): ?><div class="alert error"><?= e($error) ?></div><?php endif; ?>
  <form method="post" class="content-card feedback-form">
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="subject_id" value="<?= $subjectId ?>">
    <label>Academic session<input name="session_name" value="<?= e($sessionName) ?>" required maxlength="40"></label>
    <div class="rating-intro"><h2>Rate your experience</h2><p>Choose a rating for each criterion, from 1 (Needs improvement) to 5 (Excellent).</p></div>
    <?php foreach ($criteria as $key=>$label): ?>
      <fieldset class="rating-field"><legend><?= e($label) ?></legend><div class="rating-options">
        <?php for ($i=1;$i<=5;$i++): ?><label><input type="radio" name="<?= $key ?>" value="<?= $i ?>" required><span><?= $i ?></span></label><?php endfor; ?>
      </div><div class="rating-hints"><span>Needs improvement</span><span>Excellent</span></div></fieldset>
    <?php endforeach; ?>
    <label>Additional comments <span class="optional">(optional)</span><textarea name="comment" rows="4" maxlength="1500" placeholder="What is going well? What could be improved?"></textarea></label>
    <div class="privacy-note">🔒 <span><b>Anonymous by design</b><br>Your name and username are never included in faculty or management reports.</span></div>
    <button class="btn btn-primary btn-full" type="submit">Submit anonymous feedback →</button>
  </form>
</div>
<?php require __DIR__ . '/../includes/footer.php'; ?>
