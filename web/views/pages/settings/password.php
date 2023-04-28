<h2 class="content-title">Update Password</h2>
<hr />
<div class="mw-full w-400">
	<form action="api.php?action=settings&amp;section=password" method="POST" id="change-pass-form">
		<div class="form-group">
		  <label for="current_password" class="required">Current Password</label>
		  <input type="password" class="form-control" id="password" name="current_password" placeholder="Current Password" required="required"/>
		</div>
		<div class="form-group">
		  <label for="new_password" class="required">New Password</label>
		  <input type="password" class="form-control" name="new_password" id="new_password" placeholder="New Password" required="required"/>
		</div>
		<div class="form-group">
		  <label for="confirm_new_password" class="required">Confirm New Password</label>
		  <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password" required="required"/>
		</div>
		<input class="btn btn-primary" type="submit" value="Save" />
	</form>
</div>
<script>
	let form_password = gid("change-pass-form");
	form_password.addEventListener("submit", function(e) {
		e.preventDefault();
		let xhr = new XMLHttpRequest();
		xhr.withCredentials = true;
		xhr.open("POST", form_password.action, true);
		xhr.onload = function() {
			let res;

			try {
				res = JSON.parse(xhr.responseText);
			} catch (e) {
				console.log("Error", e);
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
		xhr.send(new FormData(form_password));
		toggle_all_inputs(false);
	});
</script>
