<?php

require __DIR__ . "/token.php";

/**
 *
 * Return 1 if validation failed, otherwise return 0.
 * 
 * The request must have "username" and "password" string parameters
 * via POST method.
 *
 */
function validate_must_have_user_pass(): int
{
	if ($_SERVER["REQUEST_METHOD"] !== "POST") {
		api_error(405, "Invalid request method");
		return 1;
	}

	if (!isset($_POST["username"]) || !is_string($_POST["username"])) {
		api_error(400, "Missing \"username\" string parameter");
		return 1;
	}

	if (!isset($_POST["password"]) || !is_string($_POST["password"])) {
		api_error(400, "Missing \"password\" string parameter");
		return 1;
	}

	return 0;
}

function set_token_cookie(int $type, string $token)
{
	switch ($type) {
	case TOKEN_TYPE_USER:
		$key = "token_user";
		break;
	case TOKEN_TYPE_ADMIN:
		$key = "token_admin";
		break;
	default:
		throw new Exception("Invalid token type {$type}");
	}

	setcookie($key, $token, time() + 86400 * 30, "/");
}

/*
 * Return 1 if validation failed, otherwise return 0.
 */
function validate_password($pass, $row): int
{
	if (!$row || !password_verify($pass, $row["password"])) {
		api_error(401, "Invalid username or password");
		return 1;
	}

	return 0;
}

function handle_api_login_user(): int
{
	if (validate_must_have_user_pass())
		return 1;

	$user = $_POST["username"];
	$pass = $_POST["password"];

	if (filter_var($user, FILTER_VALIDATE_EMAIL))
		$q = "SELECT `id`, `password` FROM `users` WHERE `email` = ? LIMIT 1;";
	else
		$q = "SELECT `id`, `password` FROM `users` WHERE `username` = ? LIMIT 1;";

	$pdo = pdo();
	$st = $pdo->prepare($q);
	$st->execute([$user]);
	$row = $st->fetch(PDO::FETCH_ASSOC);
	if (validate_password($pass, $row))
		return 1;

	$row["id"] = (int)$row["id"];
	$token = generate_token_user($row["id"]);
	if (isset($_POST["use_cookie"]) && $_POST["use_cookie"]) {
		set_token_cookie(TOKEN_TYPE_USER, $token);
		$_SESSION["user_id"] = $row["id"];
	}

	api_response(200, ["token" => $token]);
	return 0;
}

function handle_api_login_admin(): int
{
	if (validate_must_have_user_pass())
		return 1;

	$user = $_POST["username"];
	$pass = $_POST["password"];

	if (filter_var($user, FILTER_VALIDATE_EMAIL))
		$q = "SELECT `id`, `password` FROM `admins` WHERE `email` = ? LIMIT 1;";
	else
		$q = "SELECT `id`, `password` FROM `admins` WHERE `username` = ? LIMIT 1;";

	$pdo = pdo();
	$st = $pdo->prepare($q);
	$st->execute([$user]);
	$row = $st->fetch(PDO::FETCH_ASSOC);
	if (validate_password($pass, $row))
		return 1;

	$row["id"] = (int)$row["id"];
	$token = generate_token_admin($row["id"]);
	if (isset($_POST["use_cookie"]) && $_POST["use_cookie"]) {
		set_token_cookie(TOKEN_TYPE_ADMIN, $token);
		$_SESSION["admin_id"] = $row["id"];
	}

	api_response(200, ["token" => $token]);
	return 0;
}

const GET_USER_SESSION_QUERY = <<<SQL
	SELECT
		a.id, a.username, a.first_name, a.last_name, a.email,
		b.sha1_sum, b.md5_sum, b.ext, a.created_at, a.updated_at
	FROM
		users AS a LEFT JOIN files AS b ON b.id = a.photo
	WHERE a.id = ? LIMIT 1;
SQL;

function get_user_session(array $extra = []): ?array
{
	if (!isset($_SESSION["user_id"]))
		return NULL;

	$pdo = pdo();
	$st = $pdo->prepare(GET_USER_SESSION_QUERY);
	$st->execute([(int)$_SESSION["user_id"]]);
	$row = $st->fetch(PDO::FETCH_ASSOC);
	if (!$row)
		return NULL;

	$row["id"] = (int)$row["id"];
	$row["full_name"] = $row["first_name"];
	if (isset($row["last_name"]))
		$row["full_name"] .= " " . $row["last_name"];

	return $row;
}
