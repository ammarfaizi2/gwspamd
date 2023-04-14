<?php

if (isset($u["photo"])) {
	$photo = "img/user/{$u["photo"]}";
} else {
	$photo = asset("img/default_pp.png");
}

?><?php load_view("head"); ?>
<body>
	<link rel="stylesheet" href="<?= e(asset("css/profile.css")); ?>"/>
	<?php load_view("component/navbar"); ?>
	<div id="main-box">
		<h1><?= e($u["full_name"]); ?></h1>
		<img id="user-photo" src="<?= e($photo); ?>" alt="<?= e($u["full_name"]); ?>"/>
		<table id="user-info">
			<tr><th align="center" colspan="3" id="profile-info">Profile Info</th></tr>
			<tr><td>User ID</td><td>:</td><td><?= e($u["id"]); ?></td></tr>
			<tr><td>First Name</td><td>:</td><td><?= e($u["first_name"]); ?></td></tr>
			<tr><td>Last Name</td><td>:</td><td><?= e($u["last_name"]); ?></td></tr>
			<tr><td>Username</td><td>:</td><td><?= e($u["username"]); ?></td></tr>
			<tr><td>Email</td><td>:</td><td><?= e($u["email"]); ?></td></tr>
		</table>
	</div>
</body>
<?php load_view("foot"); ?>
