// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

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
