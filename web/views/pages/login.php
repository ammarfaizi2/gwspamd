<?php load_view("head"); ?>
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
<script type="text/javascript" src="<?= e(asset("js/login.js")); ?>"></script>
<?php load_view("foot"); ?>
