<div class="content">
	<div class="mw-full d-flex justify-content-center">
		<form action="api.php?action=settings&amp;section=password" method="POST" id="change-pass-form" class="w-400 mw-full form-inline">
			<table id="user-info" class="table">
				<tr>
					<th>
						<div>Change Password</div>
					</th>
				</tr>
				<tr>
					<td>Current Password</td>
					<td><input type="password" class="form-control" name="current_password" placeholder="Current Password" required /></td>
				</tr>
				<tr>
					<td>New Password</td>
					<td><input type="password" class="form-control" name="new_password" placeholder="New Password" required /></td>
				</tr>
				<tr>
					<td>Confirm New Password</td>
					<td><input type="password" class="form-control" name="confirm_new_password" placeholder="Confirm New Password" required /></td>
				</tr>
			</table>
			<input class="btn btn-primary btn-block" type="submit" value="Save" />
		</form>
	</div>
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
				alert("Password updated!");
				window.location = "?ref=settings";
			} else {
				alert(res.error || "Unknown error");
				toggle_all_inputs(true);
			}
		};
		xhr.send(new FormData(form_password));
		toggle_all_inputs(false);
	});
</script>
