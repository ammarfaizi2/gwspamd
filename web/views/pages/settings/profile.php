
<link rel="stylesheet" href="<?= e(asset("css/profile.css")); ?>"/>
<img id="user-photo" src="<?= e($photo); ?>" alt="<?= e($u["full_name"]); ?>"/>
<form action="settings.php?section=profile&save=1" enctype="multipart/form-data" method="POST">
	<table id="user-info">
		<tr><th align="center" colspan="3" id="profile-info">Profile Info</th></tr>
		<tr><td>User ID</td><td>:</td><td><?= e($u["id"]); ?></td></tr>
		<tr><td>Photo</td><td>:</td><td><input type="file" name="photo"/></td></tr>
		<tr><td>First Name</td><td>:</td><td><input type="text" value="<?= e($u["first_name"]); ?>" required/></td></tr>
		<tr><td>Last Name</td><td>:</td><td><input type="text" value="<?= e($u["last_name"]); ?>"/></td></tr>
		<tr><td>Username</td><td>:</td><td><input type="text" value="<?= e($u["username"]); ?>" required/></td></tr>
		<tr><td>Email</td><td>:</td><td><input type="text" value="<?= e($u["email"]); ?>" required/></td></tr>
		<tr><td align="center" colspan="3"><div style="margin-top: 30px;">Enter your current password to edit your profile:</div></td></tr>
		<tr><td align="center" colspan="3"><input type="password" name="password" placeholder="Password" required/></td></tr>
		<tr><td align="center" colspan="3"><button type="submit">Save</button></td></tr>
	</table>
</form>
