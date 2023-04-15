<?php load_view("head"); ?>
<link rel="stylesheet" href="<?= e(asset("css/home.css")); ?>">
<?php load_view("component/navbar"); ?>
<div id="main-box">
	<h1>Welcome <?= e($u["first_name"]); ?></h1>
</div>
<?php load_view("foot"); ?>
