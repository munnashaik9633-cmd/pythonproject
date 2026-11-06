<?php
require_once __DIR__ . '/../includes/functions.php';require_role('admin');
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();$name=trim($_POST['name']??'');$code=strtoupper(trim($_POST['code']??''));$faculty=(int)($_POST['faculty_id']??0);$dept=(int)($_POST['department_id']??0);
 if(!$name||!$code||!$faculty||!$dept)flash('error','Complete all subject details.');
 else{try{$q=db()->prepare("INSERT INTO subjects(name,code,faculty_id,department_id) VALUES(?,?,?,?)");$q->execute([$name,$code,$faculty,$dept]);flash('success','Subject created.');}catch(PDOException $e){flash('error','Subject code already exists or details are invalid.');}}
 redirect('/admin/subjects.php');
}
$faculty=db()->query("SELECT id,name FROM users WHERE role='faculty' AND is_active=1 ORDER BY name")->fetchAll();$departments=db()->query("SELECT id,name FROM departments ORDER BY name")->fetchAll();
$subjects=db()->query("SELECT s.name,s.code,u.name faculty,d.name department,s.is_active FROM subjects s JOIN users u ON u.id=s.faculty_id JOIN departments d ON d.id=s.department_id ORDER BY s.name")->fetchAll();
$pageTitle='Manage subjects';require __DIR__.'/../includes/header.php';?>
<div class="page-heading"><div><div class="eyebrow">ADMINISTRATION</div><h1>Manage subjects</h1><p>Assign subjects to faculty members and departments.</p></div></div>
<div class="content-card"><div class="card-heading"><div><h2>Add a subject</h2><p>Subject codes must be unique.</p></div></div>
<form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><label>Subject name<input name="name" required></label><label>Subject code<input name="code" required></label><label>Faculty<select name="faculty_id" required><option value="">Select faculty</option><?php foreach($faculty as $f):?><option value="<?=$f['id']?>"><?=e($f['name'])?></option><?php endforeach;?></select></label><label>Department<select name="department_id" required><option value="">Select department</option><?php foreach($departments as $d):?><option value="<?=$d['id']?>"><?=e($d['name'])?></option><?php endforeach;?></select></label><button class="btn btn-primary">Add subject</button></form></div>
<div class="content-card"><div class="card-heading"><div><h2>Current subjects</h2></div></div><div class="table-wrap"><table><thead><tr><th>Subject</th><th>Code</th><th>Faculty</th><th>Department</th><th>Status</th></tr></thead><tbody><?php foreach($subjects as $s):?><tr><td><?=e($s['name'])?></td><td><?=e($s['code'])?></td><td><?=e($s['faculty'])?></td><td><?=e($s['department'])?></td><td><?=$s['is_active']?'Active':'Inactive'?></td></tr><?php endforeach;?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php';?>
