<?php
$opt["title"] = "Audit Log";
load_api("audit_log");

function build_extra_edit_profile($extra)
{
	$e = json_decode($extra, true);
	ob_start();
	?>
		Username: <?= e($e["username"]); ?><br>
		First name: <?= e($e["first_name"]); ?><br>
		Last name: <?= e($e["last_name"]); ?><br>
		Email: <?= e($e["email"]); ?><br>
		Photo: <?= e($e["photo_id"] ?? "(unchanged)"); ?><br>
	<?php
	return ob_get_clean();
}

function build_extra_ipua($extra)
{
	$e = json_decode($extra, true);
	ob_start();
	?>
		IP: <?= e($e["ip"]); ?><br>
		User Agent: <?= e($e["ua"]); ?><br>
	<?php
	return ob_get_clean();
}

function build_extra_data(string $action, $extra)
{
	switch ($action) {
	case "edit_profile":
		return build_extra_edit_profile($extra);
		break;
	case "login":
	case "logout":
	case "change_password":
		return build_extra_ipua($extra);
		break;
	}

	return "";
}

if (isset($_GET["page"])) {
	$page = (int)$_GET["page"];
} else {
	$page = 1;
}

if ($page <= 0)
	$page = 1;

$limit = 10;
$offset = ($page - 1) * $limit;

$st = get_audit_log_st($u["id"], $limit, $offset);
$nr_pages = get_audit_log_page_num($u["id"], $limit);

ob_start();
?>
<div class="paginator">
	<?php for ($i = 1; $i <= $nr_pages; $i++): ?>
		<div><a href="?page=<?= $i; ?>"><?= $i; ?></a></div>
	<?php endfor; ?>
</div>
<?php
$paginator = ob_get_clean();


?>
<style>
.audit-log-main {
	text-align: center;
	width: 900px;
	margin: auto;
	border: 1px solid #000;
	margin-top: 80px;
	padding: 30px;
	padding-bottom: 50px;
	margin-bottom: 150px;
}
.audit-log-table {
	margin: auto;
	border-collapse: collapse;
}
.audit-log-table tr th {
	padding: 10px;
}
.audit-log-table tr td {
	padding: 10px;
}
.paginator {
	width: 10px;
	margin-top: 20px;
	font-size: 30px;
	display: flex;
}
.paginator div {
	padding : 10px;
	border: 1px solid #000;
	margin: 10px;
}
</style>
<div class="audit-log-main">
<h1>Audit Log</h1>
<?= $paginator; ?>
<table class="audit-log-table" border="1">
	<thead>
		<tr><th>ID</th><th>Action</th><th>Extra</th><th>Datetime</th></tr>
	</thead>
	<tbody>
		<?php foreach ($st->fetchAll() as $row): ?>
		<tr>
			<td><?= e($row["id"]); ?></td>
			<td><?= e($row["action"]); ?></td>
			<td align="left"><?= build_extra_data($row["action"], $row["extra"]); ?></td>
			<td><?= e($row["created_at"]); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?= $paginator; ?>
</div>
