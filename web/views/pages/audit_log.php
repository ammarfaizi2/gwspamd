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

const NUM_OF_BUTTONS = 3;

$num_of_buttons = min($nr_pages, NUM_OF_BUTTONS);
$first_button = ceil(max(min($page - $num_of_buttons / 2, $nr_pages - $num_of_buttons + 1), 1));
$last_button = $first_button + $num_of_buttons - 1;
$show_prev_dots = ($first_button > 1);
$show_next_dots = ($last_button < $nr_pages - 1);
?>

<nav aria-label="Pagination Log">
	<ul class="pagination text-center m-5">
		<?php if ($page > 1): ?>
			<li class="page-item<?= ($page == $i) ? " active" : ""; ?>">
				<a href="?page=<?= $page - 1; ?>" class="page-link">&lt;</a>
			</li>
		<?php endif; ?>

		<?php if ($show_prev_dots): ?>
			<li class="page-item">
				<a href="?page=1" class="page-link">1</a>
			</li>
			<li class="page-item ellipsis"></li>
		<?php endif; ?>

		<?php for ($i = $first_button; $i <= $last_button; $i++) : ?>
			<li class="page-item<?= ($page == $i) ? " active" : ""; ?>">
				<a href="?page=<?= $i; ?>" class="page-link"><?= $i; ?></a>
			</li>
		<?php endfor; ?>

		<?php if ($show_next_dots): ?>
			<li class="page-item ellipsis"></li>
			<li class="page-item">
				<a href="?page=<?= $nr_pages; ?>" class="page-link"><?= $nr_pages; ?></a>
			</li>
		<?php endif; ?>

		<?php if ($page != $nr_pages): ?>
			<li class="page-item">
				<a href="?page=<?= $page + 1; ?>" class="page-link">&gt;</a>
			</li>
		<?php endif; ?>
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
			<li id="log-<?= e($row["id"]); ?>" class="feed-item">
				<time class="date" datetime="<?= e($row["created_at"]); ?>"><?= e($row["created_at"]); ?></time>
				<span class="text">[<?= e($row["id"]); ?>] <?= e($row["action"]); ?></span>
				<br>
				<span class="text">
					<?= build_extra_data($row["action"], $row["extra"]); ?>
				</span>
			</li>
		<?php endforeach; ?>
	</ol>
	<?= $paginator; ?>
</div>
