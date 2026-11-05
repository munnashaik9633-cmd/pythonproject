<?php
require_once __DIR__ . '/config/database.php';
$message = ''; $error = '';
try {
    $pdo = db();
    $schema = file_get_contents(__DIR__ . '/database/schema.sql');
    $statements = array_filter(array_map('trim', preg_split('/;\s*[\r\n]+/', $schema)));
    foreach ($statements as $statement) if ($statement !== '') $pdo->exec($statement);

    $count = (int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    if ($count === 0) {
        $pdo->beginTransaction();
        $dept = $pdo->prepare("INSERT INTO departments(name,code) VALUES(?,?)");
        foreach ([['Computer Science','CSE'],['Information Technology','IT'],['Electronics & Communication','ECE']] as $d) $dept->execute($d);
        $departments = $pdo->query("SELECT id,code FROM departments")->fetchAll(PDO::FETCH_KEY_PAIR);
        $user = $pdo->prepare("INSERT INTO users(name,username,password_hash,role,department_id) VALUES(?,?,?,?,?)");
        $user->execute(['System Administrator','admin',password_hash('admin123',PASSWORD_DEFAULT),'admin',null]);
        $user->execute(['Demo Student','student',password_hash('student123',PASSWORD_DEFAULT),'student',$departments['IT']]);
        $user->execute(['Demo Faculty','faculty',password_hash('faculty123',PASSWORD_DEFAULT),'faculty',$departments['IT']]);
        $facultyId = (int)$pdo->lastInsertId();
        $subject = $pdo->prepare("INSERT INTO subjects(name,code,faculty_id,department_id) VALUES(?,?,?,?)");
        $subject->execute(['Database Management Systems','IT301',$facultyId,$departments['IT']]);
        $subject->execute(['Web Technologies','IT302',$facultyId,$departments['IT']]);
        $subject->execute(['Data Structures','CSE201',$facultyId,$departments['CSE']]);
        $pdo->commit();
    }
    $message = 'Setup completed. Database tables and demo accounts are ready.';
} catch (Throwable $e) {
    if (isset($pdo) && $pdo->inTransaction()) $pdo->rollBack();
    $error = $e->getMessage();
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Project setup</title><link rel="stylesheet" href="assets/style.css"></head><body><main class="setup-wrap"><div class="content-card"><div class="eyebrow">INSTALLATION</div><h1>Campus Feedback Lens setup</h1><?php if($message):?><div class="alert success"><?=htmlspecialchars($message)?></div><p>Demo accounts:</p><ul><li>Student: <b>student / student123</b></li><li>Faculty: <b>faculty / faculty123</b></li><li>Admin: <b>admin / admin123</b></li></ul><p><b>Important:</b> Delete or rename <code>setup.php</code> after successful installation.</p><a class="btn btn-primary" href="index.php">Open website →</a><?php else:?><div class="alert error"><?=htmlspecialchars($error)?></div><p>Check your database settings in <code>config/config.php</code>, create the database, and retry.</p><?php endif;?></div></main></body></html>
