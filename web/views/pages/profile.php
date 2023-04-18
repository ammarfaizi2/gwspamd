<?php

$opt["title"] = $u["full_name"];

?>
<div class="mw-full text-center">
	<img id="user-photo" class="img-fluid rounded-circle" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?> Images">
	<div class="content">
		<h1 class="font-weight-bolder"><?= $u["full_name"]; ?></h1>
		<a href="settings.php?section=profile" class="btn btn-action m-5">Edit Profile</a>

		<table class="table table-striped">
			<tbody>
				<tr>
					<th>User ID</th>
					<td><?= e($u["id"]); ?></td>
				</tr>
				<tr>
					<th>First Name</th>
					<td><?= e($u["first_name"]); ?></td>
				</tr>
				<tr>
					<th>Last Name</th>
					<td><?= e($u["last_name"]); ?></td>
				</tr>
				<tr>
					<th>User Name</th>
					<td><?= e($u["username"]); ?></td>
				</tr>
				<tr>
					<th>Email</th>
					<td><?= e($u["email"]); ?></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
