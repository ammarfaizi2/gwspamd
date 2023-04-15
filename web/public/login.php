<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

require_once __DIR__ . "/../init.php";

load_api("login");
$u = get_user_session();
if ($u) {
	header("Location: home.php?ref=login");
	exit(0);
}

load_page("login");
