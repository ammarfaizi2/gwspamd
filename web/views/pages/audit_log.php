<?php
$opt["title"] = "Audit Log";
load_api("audit_log");

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

<nav aria-label="Pagination Log">
	<ul class="pagination text-center m-5">
		<?php for ($i = 1; $i <= $nr_pages; $i++) : ?>
			<li class="page-item<?= ($page == $i) ? " active" : ""; ?>">
				<a href="?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
			</li>
		<?php endfor; ?>
	</ul>
</nav>
<?php
$paginator = ob_get_clean();


?>
<div class="card">
	<h1 class="card-title">Audit Log</h1>
	<?= $paginator; ?>
	<style>

	</style>
	<ol class="activity-feed">
		<?php foreach ($st->fetchAll() as $row) : ?>
			<li class="feed-item">
				<time class="date" datetime="<?= e($row["created_at"]); ?>"><?= e($row["created_at"]); ?></time>
				<span class="text"><?= e($row["action"]); ?></span>
				<br>
				<span class="text">
					<?= build_extra_data($row["action"], $row["extra"]); ?>
				</span>
			</li>
		<?php endforeach; ?>
	</ol>
	<?= $paginator; ?>
</div>
