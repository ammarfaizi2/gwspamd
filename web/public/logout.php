<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

require_once __DIR__ . "/../init.php";

load_api("login");
load_api("audit_log");

$u = get_user_session();
if ($u) {
	add_user_audit_log($u["id"], "logout", [
		"ip" => $_SERVER["REMOTE_ADDR"] ?? NULL,
		"ua" => $_SERVER["HTTP_USER_AGENT"] ?? NULL,
	]);
}

session_destroy();
setcookie("token_user", NULL, 0, "/");
header("Location: login.php");
