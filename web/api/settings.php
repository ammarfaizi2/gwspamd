<?php

function validate_save_profile_inputs(): int
{
	if (!isset($_POST["first_name"]) || !is_string($_POST["first_name"])) {
		api_error(400, "Missing \"first_name\" string parameter");
		return 1;
	}

	if (!isset($_POST["last_name"]) || !is_string($_POST["last_name"])) {
		api_error(400, "Missing \"last_name\" string parameter");
		return 1;
	}

	if (!isset($_POST["username"]) || !is_string($_POST["username"])) {
		api_error(400, "Missing \"username\" string parameter");
		return 1;
	}

	if (!isset($_POST["email"]) || !is_string($_POST["email"])) {
		api_error(400, "Missing \"email\" string parameter");
		return 1;
	}

	if (!isset($_POST["password"]) || !is_string($_POST["password"])) {
		api_error(400, "Missing \"password\" string parameter");
		return 1;
	}

	$c = strlen($_POST["email"]);
	if ($c < 4) {
		api_error(400, "Email must be at least 4 characters long");
		return 1;
	}

	if ($c > 256) {
		api_error(400, "Email cannot be longer than 256 characters");
		return 1;
	}

	if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		api_error(400, "Invalid \"email\" parameter");
		return 1;
	}

	$c = strlen($_POST["username"]);
	if ($c < 4) {
		api_error(400, "Username must be at least 4 characters long");
		return 1;
	}

	if ($c > 32) {
		api_error(400, "Username cannot be longer than 32 characters");
		return 1;
	}

	if (!preg_match("/^[a-zA-Z0-9\_]+$/", $_POST["username"])) {
		api_error(400, "Allowed characters for username are: a-z, A-Z, 0-9, _");
		return 1;
	}

	$_POST["first_name"] = trim($_POST["first_name"]);
	$c = strlen($_POST["first_name"]);
	if ($c < 1) {
		api_error(400, "First name must be at least 1 character long");
		return 1;
	}

	if ($c > 64) {
		api_error(400, "First name cannot be longer than 64 characters");
		return 1;
	}

	if (!preg_match("/^[a-zA-Z\s\'\-]+$/", $_POST["first_name"])) {
		api_error(400, "Allowed characters for first name are: a-z, A-Z, space, ', -");
		return 1;
	}

	/*
	 * Allow empty last name.
	 */
	$_POST["last_name"] = trim($_POST["last_name"]);
	$c = strlen($_POST["last_name"]);
	if (!$c) {
		$_POST["last_name"] = NULL;
		return 0;
	}

	if ($c > 64) {
		api_error(400, "Last name cannot be longer than 64 characters");
		return 1;
	}

	if (!preg_match("/^[a-zA-Z\s\'\-]+$/", $_POST["last_name"])) {
		api_error(400, "Allowed characters for last name are: a-z, A-Z, space, ', -");
		return 1;
	}

	return 0;
}

function __handle_api_settings_profile(): int
{
	api_response(200, ["success" => "Profile updated"]);
	return 0;
}

const MAX_UPLOAD_SIZE = 1024 * 1024 * 4;
const ALLOWED_EXT = ["jpg", "jpeg", "png", "gif", "bmp"];

function handle_api_settings_profile(): int
{
	$u = get_user_session();
	if (!$u) {
		api_error(401, "Not logged in");
		return 1;
	}

	if (validate_save_profile_inputs())
		return 1;

	if (!password_verify($_POST["password"], $u["password"])) {
		api_error(400, "Wrong password");
		return 1;
	}

	load_api("file");
	$err = NULL;
	$file_id = get_file_and_save("photo", MAX_UPLOAD_SIZE, ALLOWED_EXT, $err);
	if ($file_id === NULL && $err) {
		api_error(400, "File error: {$err}");
		return 1;
	}

	if ($file_id)
		$fq = ", photo = {$file_id}";
	else
		$fq = "";

	$q = "UPDATE users SET first_name = ?, last_name = ?, username = ?, email = ?, updated_at = ? {$fq} WHERE id = ? LIMIT 1;";

	try {

		$pdo = pdo();
		$pdo->beginTransaction();
		$st = $pdo->prepare($q);
		$st->execute([
			$_POST["first_name"],
			$_POST["last_name"],
			$_POST["username"],
			$_POST["email"],
			date("Y-m-d H:i:s"),
			$u["id"],
		]);
		$pdo->commit();
		api_response(200, ["success" => "Profile updated"]);
		return 0;
	} catch (PDOException $e) {
		$pdo->rollBack();
		api_error(500, "Database error: " . $e->getMessage());
		dec_file_ref_count($pdo, $file_id);
		return 1;
	}
}

function handle_api_settings_password(): int
{
	$u = get_user_session();
	if (!$u) {
		api_error(401, "Not logged in");
		return 1;
	}

	if (!isset($_POST["current_password"]) || !is_string($_POST["current_password"])) {
		api_error(400, "Missing \"current_password\" string parameter");
		return 1;
	}

	if (!isset($_POST["new_password"]) || !is_string($_POST["new_password"])) {
		api_error(400, "Missing \"new_password\" string parameter");
		return 1;
	}

	if (!isset($_POST["confirm_new_password"]) || !is_string($_POST["confirm_new_password"])) {
		api_error(400, "Missing \"confirm_new_password\" string parameter");
		return 1;
	}

	if (!password_verify($_POST["current_password"], $u["password"])) {
		api_error(400, "Wrong current password");
		return 1;
	}

	if ($_POST["new_password"] !== $_POST["confirm_new_password"]) {
		api_error(400, "New password and confirm new password do not match");
		return 1;
	}

	$c = strlen($_POST["new_password"]);
	if ($c < 6) {
		api_error(400, "Password must be at least 6 characters long");
		return 1;
	}

	if ($c > 512) {
		api_error(400, "Password cannot be longer than 512 characters");
		return 1;
	}

	if ($_POST["new_password"] === $_POST["current_password"]) {
		api_error(400, "New password cannot be the same as current password");
		return 1;
	}

	$q = "UPDATE users SET password = ?, updated_at = ? WHERE id = ? LIMIT 1;";

	try {
		$pdo = pdo();
		$pdo->beginTransaction();
		$st = $pdo->prepare($q);
		$st->execute([
			password_hash($_POST["new_password"], PASSWORD_BCRYPT),
			date("Y-m-d H:i:s"),
			$u["id"],
		]);
		$pdo->commit();
		api_response(200, ["success" => "Password updated"]);
		return 0;
	} catch (PDOException $e) {
		$pdo->rollBack();
		api_error(500, "Database error: " . $e->getMessage());
		return 1;
	}
}

function handle_api_settings(): int
{
	if (!isset($_GET["section"]) || !is_string($_GET["section"])) {
		api_error(400, "Missing \"section\" string parameter");
		return 1;
	}

	load_api("login");
	switch ($_GET["section"]) {
	case "profile":
		return handle_api_settings_profile();
	case "password":
		return handle_api_settings_password();
	default:
		$pdo->rollBack();
		api_error(400, "Invalid \"section\" parameter");
		return 1;
	}
}
