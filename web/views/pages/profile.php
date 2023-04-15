<?php

if (isset($u["photo"])) {
	load_api("file");
	$photo = asset("files/".fetch_file_path($u["photo"]));
} else {
	$photo = asset("img/default_pp.png");
}

$opt["title"] = $u["full_name"];

?>

<link rel="stylesheet" href="<?= e(asset("css/profile.css")); ?>"/>
<div id="main-box">
	<h1><?= e($u["full_name"]); ?></h1>
	<img id="user-photo" src="<?= e($photo); ?>" alt="<?= e($u["full_name"]); ?>"/>
	<div class="edit-profile-link"><a href="settings.php?section=profile">Edit profile</a></div>
	<table id="user-info">
		<tr><th align="center" colspan="3"><div>Profile Info</div></th></tr>
		<tr><td>User ID</td><td>:</td><td><?= e($u["id"]); ?></td></tr>
		<tr><td>First Name</td><td>:</td><td><?= e($u["first_name"]); ?></td></tr>
		<tr><td>Last Name</td><td>:</td><td><?= e($u["last_name"]); ?></td></tr>
		<tr><td>Username</td><td>:</td><td><?= e($u["username"]); ?></td></tr>
		<tr><td>Email</td><td>:</td><td><?= e($u["email"]); ?></td></tr>
	</table>
</div>
