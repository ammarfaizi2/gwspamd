<link rel="stylesheet" href="<?= e(asset("css/profile.css")); ?>"/>
<img id="user-photo" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?>"/>
<form action="api.php?action=settings&amp;section=profile" enctype="multipart/form-data" method="POST" id="edit-profile-form">
<table id="user-info">
	<tr><th align="center" colspan="3"><div>Profile Info</div></th></tr>
	<tr><td>User ID</td><td>:</td><td><?= e($u["id"]); ?></td></tr>
	<tr><td>Photo</td><td>:</td><td><input type="file" name="photo"/></td></tr>
	<tr><td>First Name</td><td>:</td><td><input type="text" name="first_name" value="<?= e($u["first_name"]); ?>" required/></td></tr>
	<tr><td>Last Name</td><td>:</td><td><input type="text" name="last_name" value="<?= e($u["last_name"]); ?>"/></td></tr>
	<tr><td>Username</td><td>:</td><td><input type="text" name="username" value="<?= e($u["username"]); ?>" required/></td></tr>
	<tr><td>Email</td><td>:</td><td><input type="email" name="email" value="<?= e($u["email"]); ?>" required/></td></tr>
	<tr><td align="center" colspan="3"><div style="margin-top: 30px;">Enter your current password to edit your profile:</div></td></tr>
	<tr><td align="center" colspan="3"><input type="password" name="password" placeholder="Password" required/></td></tr>
	<tr><td align="center" colspan="3"><button type="submit">Save</button></td></tr>
</table>
</form>
<script>
	let form_profile = gid("edit-profile-form");
	form_profile.addEventListener("submit", function(e) {
		e.preventDefault();
		let xhr = new XMLHttpRequest();
		xhr.withCredentials = true;
		xhr.open("POST", form_profile.action, true);
		xhr.onload = function() {
			let res;

			try {
				res = JSON.parse(xhr.responseText);
			} catch (e) {
				console.log("Error", e);
				return;
			}

			if (this.status == 200) {
				alert("Profile updated!");
				window.location = "profile.php?ref=settings";
			} else {
				alert(res.error || "Unknown error");
				toggle_all_inputs(true);
			}
		};
		toggle_all_inputs(false);
		xhr.send(new FormData(form_profile));
	});
</script>
