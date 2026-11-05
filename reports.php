<?php
require_once __DIR__ . '/includes/functions.php';
$user=require_role('admin','faculty');
$facultyFilter=$user['role']==='faculty'?(int)$user['id']:(int)($_GET['faculty_id']??0);
$departments=db()->query("SELECT id,name FROM departments ORDER BY name")->fetchAll();
$faculty=db()->query("SELECT id,name FROM users WHERE role='faculty' ORDER BY name")->fetchAll();
$deptFilter=(int)($_GET['department_id']??0);$sessionFilter=trim($_GET['session']??'');
$sql="SELECT f.session_name,s.name subject_name,s.code,d.name department,u.name faculty_name,COUNT(f.id) responses,AVG(f.teaching) teaching,AVG(f.communication) communication,AVG(f.punctuality) punctuality,AVG(f.knowledge) knowledge,AVG(f.interaction) interaction,AVG((f.teaching+f.communication+f.punctuality+f.knowledge+f.interaction)/5) avg_rating FROM feedback f JOIN subjects s ON s.id=f.subject_id JOIN departments d ON d.id=s.department_id JOIN users u ON u.id=f.faculty_id WHERE 1=1";
$params=[];
if($facultyFilter){$sql.=" AND f.faculty_id=?";$params[]=$facultyFilter;}
if($deptFilter){$sql.=" AND d.id=?";$params[]=$deptFilter;}
if($sessionFilter){$sql.=" AND f.session_name=?";$params[]=$sessionFilter;}
$sql.=" GROUP BY f.subject_id,f.session_name ORDER BY d.name,s.name";
$stmt=db()->prepare($sql);$stmt->execute($params);$rows=$stmt->fetchAll();
if(($_GET['export']??'')==='csv'){
 header('Content-Type: text/csv; charset=utf-8');header('Content-Disposition: attachment; filename="campus-feedback-report.csv"');
 $out=fopen('php://output','w');fputcsv($out,['Session','Department','Subject','Code','Faculty','Responses','Teaching','Communication','Punctuality','Knowledge','Interaction','Average']);
 foreach($rows as $r)fputcsv($out,[$r['session_name'],$r['department'],$r['subject_name'],$r['code'],$r['faculty_name'],$r['responses'],$r['teaching'],$r['communication'],$r['punctuality'],$r['knowledge'],$r['interaction'],$r['avg_rating']]);fclose($out);exit;
}
$pageTitle='Feedback reports';require __DIR__.'/includes/header.php';
?>
<div class="page-heading"><div><div class="eyebrow">REPORTING & ANALYTICS</div><h1>Feedback reports</h1><p>Filter feedback results and export a report for academic review.</p></div></div>
<div class="content-card"><form method="get" class="filter-form">
<?php if($user['role']==='admin'):?><label>Faculty<select name="faculty_id"><option value="">All faculty</option><?php foreach($faculty as $f):?><option value="<?=$f['id']?>" <?=((int)($_GET['faculty_id']??0)==$f['id'])?'selected':''?>><?=e($f['name'])?></option><?php endforeach;?></select></label><?php endif;?>
<label>Department<select name="department_id"><option value="">All departments</option><?php foreach($departments as $d):?><option value="<?=$d['id']?>" <?=$deptFilter===$d['id']?'selected':''?>><?=e($d['name'])?></option><?php endforeach;?></select></label>
<label>Session<input name="session" value="<?=e($sessionFilter)?>" placeholder="e.g. 2026-27 Semester 1"></label><button class="btn btn-primary">Apply filters</button><a class="btn btn-light" href="<?= BASE_URL ?>/reports.php">Reset</a>
</form></div>
<div class="content-card"><div class="card-heading"><div><h2>Report results</h2><p><?=count($rows)?> subject/session records · Anonymous aggregate data</p></div><div class="export-actions"><a class="btn btn-light" href="?<?=e(http_build_query(array_merge($_GET,['export'=>'csv'])))?>">↓ Export CSV</a><button class="btn btn-primary" onclick="window.print()">Print / Save PDF</button></div></div>
<div class="table-wrap"><table><thead><tr><th>Department</th><th>Subject</th><th>Faculty</th><th>Responses</th><th>Teaching</th><th>Communication</th><th>Punctuality</th><th>Knowledge</th><th>Interaction</th><th>Average</th></tr></thead><tbody><?php foreach($rows as $r):?><tr><td><?=e($r['department'])?></td><td><?=e($r['subject_name'])?></td><td><?=e($r['faculty_name'])?></td><td><?=$r['responses']?></td><td><?=number_format((float)$r['teaching'],1)?></td><td><?=number_format((float)$r['communication'],1)?></td><td><?=number_format((float)$r['punctuality'],1)?></td><td><?=number_format((float)$r['knowledge'],1)?></td><td><?=number_format((float)$r['interaction'],1)?></td><td><span class="rating-pill"><?=number_format((float)$r['avg_rating'],2)?></span></td></tr><?php endforeach;?></tbody></table></div>
<?php if(!$rows):?><p class="empty-state">No feedback matches these filters yet.</p><?php endif;?></div>
<?php require __DIR__.'/includes/footer.php';?>
