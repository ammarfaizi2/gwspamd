<?php

if (isset($u["photo"])) {
	$photo = "img/user/{$u["photo"]}";
} else {
	$photo = asset("img/default_pp.png");
}

?><?php load_view("head"); ?>
<body>
	<link rel="stylesheet" href="<?= e(asset("css/settings.css")); ?>"/>
	<?php load_view("component/navbar"); ?>
	<div id="main-box">
		<h1>Settings</h1>
		<?php switch ($section) {
		case "profile":
		case "password":
			?><a href="settings.php?ref=setting-section-<?= $section ?>">Back to settings</a><?php
			?><div style="margin-top: 20px;"><?php
			load_view("pages/settings/{$section}", ["u" => $u, "photo" => $photo]);
			?></div><?php
			break;
		default: ?>
			<table id="settings-box">
				<tr><td><a href="?section=profile">Edit profile</a></td></tr>
				<tr><td><a href="?section=password">Change password</a></td></tr>
			</table><?php
			break;
		} ?>
	</div>
</body>
<?php load_view("foot"); ?>
