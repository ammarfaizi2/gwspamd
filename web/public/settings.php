<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

require_once __DIR__ . "/../init.php";

load_api("login");
$u = get_user_session();
if (!$u) {
	header("Location: login.php?ref=settings");
	exit(0);
}

if (isset($_GET["section"]) && is_string($_GET["section"]))
	$section = $_GET["section"];
else
	$section = "default";

load_view("pages/settings", ["u" => $u, "section" => $section]);
