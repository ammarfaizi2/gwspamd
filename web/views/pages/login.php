<?php
$opt["title"] = "Login GWSpamD";
?>
<link rel="stylesheet" type="text/css" href="<?= e(asset("css/login.css")); ?>">
<div id="login-box">
<h1>Login Page</h1>
<form method="POST" action="javascript:void(0);" id="login-form">
	<div>
		<div class="input-label"><label for="username">Username</label></div>
		<div class="input-field">
			<input type="text" name="username" placeholder="Username" required/>
		</div>
	</div>
	<div>
		<div class="input-label"><label for="password">Password</label></div>
		<div class="input-field">
			<input type="password" name="password" placeholder="Password" required/>
			<input type="hidden" name="use_cookie" value="1"/>
		</div>
	</div>
	<div><button type="submit" id="login-button">Login</button></div>
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
