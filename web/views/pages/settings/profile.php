<div class="mw-full text-center">
	<button id="photo-btn" type="button" data-toggle="modal" data-target="modal-profile">
		<img id="user-photo" class="img-fluid rounded-circle" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?>" />
	</button>
	<div>
		<a style="cursor: pointer;" id="photo-btn" type="button" data-toggle="modal" data-target="modal-profile">
			Edit Photo
		</a>
	</div>
</div>

<div class="mw-full d-flex justify-content-center">
	<form class="w-400 mw-full" action="api.php?action=settings&amp;section=profile" enctype="multipart/form-data" method="POST" id="edit-profile-form">
		<table class="table " id="user-info">
			<tr>
				<th align="center" colspan="3">
					<div>Profile Info</div>
				</th>
			</tr>
			<tr>
				<td>User ID</td>
				<td><?= e($u["id"]); ?></td>
			</tr>
			<tr>
				<td>First Name</td>
				<td><input class="form-control" type="text" name="first_name" value="<?= e($u["first_name"]); ?>" required /></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><input class="form-control" type="text" name="last_name" value="<?= e($u["last_name"]); ?>" /></td>
			</tr>
			<tr>
				<td>Username</td>
				<td><input class="form-control" type="text" name="username" value="<?= e($u["username"]); ?>" required /></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><input class="form-control" type="email" name="email" value="<?= e($u["email"]); ?>" required /></td>
			</tr>
			<tr>
				<td align="center" colspan="3">
					<div style="margin-top: 30px;">Enter your current password to edit your profile</div>
				</td>
			</tr>
			<tr>
				<td align="center" colspan="3"><input class="form-control" type="password" name="password" placeholder="Password" required /></td>
			</tr>
		</table>
		<input class="btn btn-primary btn-block" type="submit" value="Save" />
	</form>
</div>
<script>
	var apply_photo, form_error;
	let form_profile = gid("edit-profile-form");
	let photo_blob = null;
	let photo_filename = null;
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
				toastErorrAlert(e);
				return;
			}

			if (this.status == 200) {
				halfmoon.toggleModal('modal-success')
			} else {
				if (res.error) {
					toastErorrAlert(res.error);
				} else {
					toastErorrAlert("Unknown error");
				}
				toggle_all_inputs(true);
			}
		};
		toggle_all_inputs(false);
		let fd = new FormData(form_profile);
		if (photo_blob !== null)
			fd.append("photo", photo_blob, photo_filename);
		xhr.send(fd);
	});
</script>
<script type="module">
	import {
		Cropo
	} from "<?= e(asset("js/cropo.js")); ?>";

	const canvas = gid("photo_canvas");
	const range = gid("photo_range");
	const user_photo = gid("user-photo");
	const modal_photo = gid("modal-photo");
	const cropo = new Cropo({
		imageUrl: "<?= e($u["photo_path"]); ?>",
		canvas: canvas,
		rangeInput: range
	});
	let photo = gid("photo");
	photo.addEventListener("change", (e) => {
		let file = photo.files?.[0];
		if (!file)
			return;

		let fr = new FileReader();
		fr.onload = function() {
			cropo.loadImageFromUrl(fr.result);
			range.style.display = "";
			photo_filename = file.name;
		};
		fr.readAsDataURL(file);
	});

	apply_photo = function() {
		cropo.getBlob().then(function(blob) {
			photo_blob = blob;
		}).catch(function(err) {
			toastErorrAlert(err)
		});
		user_photo.src = cropo.getDataUrl();
	}
</script>
