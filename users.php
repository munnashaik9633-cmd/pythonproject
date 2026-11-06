<?php
require_once __DIR__ . '/../includes/functions.php';
require_role('admin');
if($_SERVER['REQUEST_METHOD']==='POST'){
 verify_csrf();
 $name=trim($_POST['name']??''); $username=trim($_POST['username']??''); $password=$_POST['password']??''; $role=$_POST['role']??'student'; $dept=(int)($_POST['department_id']??0);
 if($name===''||$username===''||strlen($password)<8||!in_array($role,['student','faculty','admin'],true)){flash('error','Enter valid details. Password must contain at least 8 characters.');}
 else{
  try{$q=db()->prepare("INSERT INTO users(name,username,password_hash,role,department_id) VALUES(?,?,?,?,?)");$q->execute([$name,$username,password_hash($password,PASSWORD_DEFAULT),$role,$dept?:null]);flash('success','User account created.');}
  catch(PDOException $e){flash('error','Could not create user. The username may already exist.');}
 }
 redirect('/admin/users.php');
}
$users=db()->query("SELECT u.id,u.name,u.username,u.role,u.is_active,d.name department FROM users u LEFT JOIN departments d ON d.id=u.department_id ORDER BY u.role,u.name")->fetchAll();
$departments=db()->query("SELECT id,name FROM departments ORDER BY name")->fetchAll();
$pageTitle='Manage users';require __DIR__.'/../includes/header.php';
?>
<div class="page-heading"><div><div class="eyebrow">ADMINISTRATION</div><h1>Manage users</h1><p>Create student, faculty and administrator accounts.</p></div></div>
<div class="content-card"><div class="card-heading"><div><h2>Create an account</h2><p>Use a unique username and a strong password.</p></div></div>
<form method="post" class="admin-form"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>">
<label>Full name<input name="name" required></label><label>Username<input name="username" required></label><label>Temporary password<input name="password" type="password" minlength="8" required></label>
<label>Role<select name="role"><option value="student">Student</option><option value="faculty">Faculty</option><option value="admin">Admin</option></select></label>
<label>Department<select name="department_id"><option value="">Not assigned</option><?php foreach($departments as $d):?><option value="<?=$d['id']?>"><?=e($d['name'])?></option><?php endforeach;?></select></label><button class="btn btn-primary" type="submit">Create account</button></form></div>
<div class="content-card"><div class="card-heading"><div><h2>All accounts</h2><p>Account list and access roles.</p></div></div><div class="table-wrap"><table><thead><tr><th>Name</th><th>Username</th><th>Role</th><th>Department</th><th>Status</th></tr></thead><tbody><?php foreach($users as $u):?><tr><td><?=e($u['name'])?></td><td><?=e($u['username'])?></td><td><span class="role-badge"><?=e($u['role'])?></span></td><td><?=e($u['department']??'—')?></td><td><?=$u['is_active']?'Active':'Inactive'?></td></tr><?php endforeach;?></tbody></table></div></div>
<?php require __DIR__.'/../includes/footer.php';?>
