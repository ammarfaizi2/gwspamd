<?php
$opt["title"] = "Login GWSpamD";
?>
<div class="card w-full" id="login-box">
<h1>Login Page</h1>
<form class="form-inline  mw-full" method="POST" action="javascript:void(0);" id="login-form">
	<div class="form-group">
	<label class="required w-100" for="username">Username</label>
	<input type="text" class="form-control" name="username" placeholder="Username" required="required"/>
</div>
<div class="form-group">
	<label class="required w-100" for="password">Password</label>
	<input type="password" class="form-control pass" name="password" placeholder="Password" required="required"/>
	<input class="d-none" type="hidden" name="use_cookie" value="1"/>
</div>
<div class="form-group">
	<input type="submit" id="login-button" class="btn btn-primary ml-auto" value="Login">
</div>
</form>
</div>
<script type="text/javascript">
let form = gid("login-form");

function handle_login(text)
{
	let j = JSON.parse(text);

	if ("error" in j) {
		alert(j.error);
		return;
	}

	if ("token" in j)
		window.location.href = "/";
}

form.addEventListener("submit", function () {
	let xhr = new XMLHttpRequest();
	xhr.useCredentials = true;
	xhr.open("POST", "/api.php?action=login_user", true);
	xhr.onreadystatechange = function() {
		if (this.readyState == 4)
			handle_login(this.responseText);
	};
	xhr.send(new FormData(form));
});
</script>
