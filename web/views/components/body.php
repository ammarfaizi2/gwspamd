<!DOCTYPE html>
<html>
<head>
	<?= isset($opt["title"]) ? "<title>".e($opt["title"])."</title>" : ""; ?>
	<?php require __DIR__."/head.php"; ?>
</head>
<body>
	<?php require __DIR__."/header.php"; ?>
	<?php require __DIR__."/navbar.php"; ?>
	<?= $content ?>
	<?php require __DIR__."/footer.php"; ?>
</body>
</html>
