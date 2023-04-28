<h2 class="content-title">Update Profile</h2>
<hr />
<div class="row">
	<div class="col-lg-4 order-lg-12">
		<div class="mw-full text-center">
			<button id="photo-btn" type="button" data-toggle="modal" data-target="modal-profile">
				<img id="user-photo" class="img-fluid h-auto rounded-circle" src="<?= e($u["photo_path"]); ?>" alt="<?= e($u["full_name"]); ?>" />
			</button>
			<div>
				<a style="cursor: pointer;" id="photo-btn" type="button" data-toggle="modal" data-target="modal-profile">
					Edit Photo
				</a>
			</div>
		</div>
	</div>
	<div class="col-lg-8 order-lg-1">
		<form class="mw-full" action="api.php?action=settings&amp;section=profile" enctype="multipart/form-data" method="POST" id="edit-profile-form">
			<div class="form-group">
		       <label for="first_name">First name</label>
		       <input type="text" class="form-control" name="first_name" placeholder="<?= e($u["first_name"]); ?>" value="<?= e($u["first_name"]); ?>" required="required">
		     </div>
			 <div class="form-group">
 		       <label for="last_name">Last name</label>
 		       <input type="text" class="form-control" name="last_name" placeholder="<?= e($u["last_name"]); ?>" value="<?= e($u["last_name"]); ?>" required="required">
 		     </div>
			 <div class="form-group">
 		       <label for="username">Username</label>
 		       <input type="text" class="form-control" name="username" placeholder="<?= e($u["username"]); ?>" value="<?= e($u["username"]); ?>" required="required">
 		     </div>
			 <div class="form-group">
 		       <label for="email">Email</label>
 		       <input type="email" class="form-control" name="email" placeholder="<?= e($u["email"]); ?>" value="<?= e($u["email"]); ?>" required="required">
 		     </div>
			 <div class="form-group">
			  <label for="password" class="required">Current password</label>
			  <input type="password" class="form-control" name="password" placeholder="Current password" required="required">
			  <div class="form-text">
				Enter your current password to edit your profile
			  </div>
			</div>
			<input class="btn btn-primary" type="submit" value="Save">
		</form>
	</div>

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
