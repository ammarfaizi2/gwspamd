<!DOCTYPE html>
<html>

<head>
	<?= isset($opt["title"]) ? "<title>" . e($opt["title"]) . "</title>" : ""; ?>
	<?php require __DIR__ . "/head.php"; ?>
</head>

<body class="dark-mode with-custom-webkit-scrollbars with-custom-css-scrollbars" data-sidebar-shortcut-enabled="true" data-dm-shortcut-enabled="true" data-set-preferred-mode-onload="true">
	<?php require __DIR__ . "/modal.php"; ?>
	<div class="page-wrapper <?php if (isset($_SESSION["user_id"])) : ?>with-sidebar with-navbar<?php endif; ?> with-transision" id="page-wrapper" data-sidebar-type="overlayed-sm-and-down">
		<?php if (isset($_SESSION["user_id"])) : ?>
			<?php require __DIR__ . "/sidebar.php"; ?>

			<?php require __DIR__ . "/navbar.php"; ?>
		<?php endif; ?>
		<div class="sticky-alerts"></div>
		<div class="content-wrapper css-scrollbar-transparent-track">
			<div class="container-lg">
				<?= $content ?>
			</div>
		</div>
	</div>
	<?php require __DIR__ . "/footer.php"; ?>
</body>

</html>
