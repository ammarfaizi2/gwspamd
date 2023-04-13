<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

require __DIR__ . "/../init.php";

if (isset($_SESSION["user"]))
	require __DIR__ . "/home.php";
else
	require __DIR__ . "/login.php";
