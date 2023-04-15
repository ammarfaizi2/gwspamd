<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */
require __DIR__ . "/../init.php";

function api_response(int $code, $data): void
{
	http_response_code($code);
	echo json_encode($data, JSON_ENCODE_FLAGS), "\n";
}

function api_error(int $code, string $msg): void
{
	api_response($code, ["error" => $msg]);
}

function handle_api(string $action): int
{
	$ret = 0;

	switch ($action) {
	case "csrf":
		load_api("csrf");
		$ret = handle_api_csrf();
		break;
	case "login_user":
		load_api("login");
		$ret = handle_api_login_user();
		break;
	case "login_admin":
		load_api("login");
		$ret = handle_api_login_admin();
		break;
	case "settings":
		load_api("settings");
		$ret = handle_api_settings();
		break;
	default:
		api_error(400, "Invalid \"action\" parameter");
		return 1;
	}

	return $ret;
}

function main(): int
{
	header("Content-Type: application/json");

	if (!isset($_GET["action"]) || !is_string($_GET["action"])) {
		api_error(400, "Missing \"action\" string parameter");
		return 1;
	}

	try {
		return handle_api($_GET["action"]);
	} catch (Error $e) {
		api_error(500, $e->getMessage());
		return 1;
	}
}

main();
