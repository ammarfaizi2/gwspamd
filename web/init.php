<?php
// SPDX-License-Identifier: GPL-2.0-only
/*
 * Copyright (C) 2023  Ammar Faizi <ammarfaizi2@gnuweeb.org>
 */

if (!defined("__INIT")):

define("__INIT", true);

require __DIR__."/config.php";

static $session_has_started = false;

function create_pdo(): PDO
{
	return new PDO(...PDO_PARAM);
}

function pdo(): PDO
{
	static $pdo = NULL;

	if (!$pdo)
		$pdo = create_pdo();

	return $pdo;
}

if (!defined("WEB_DONT_START_SESSION")) {
	if (!$session_has_started) {
		session_start();
		$session_has_started = true;
	}
}

function load_view(string $name, array $data = [])
{
	extract($data);
	return require VIEWS_DIR . "/{$name}.php";
}

function load_api(string $name, array $data = [])
{
	extract($data);
	return require API_DIR . "/{$name}.php";
}

function e(?string $str): string
{
	if (!is_string($str))
		return "";

	return htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function asset(?string $str): string
{
	return rtrim(ASSET_BASE_URL, "/") . "/{$str}";
}

function encrypt(string $data, string $key, bool $encode = true): string
{
	$method = "AES-256-CBC";
	$key = hash('sha256', $key, true);
	$iv = openssl_random_pseudo_bytes(16);

	$ciphertext = openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv);
	$hash = hash_hmac('sha256', $ciphertext . $iv, $key, true);

	$ret = $iv . $hash . $ciphertext;
	$try = gzdeflate($ret, 9);

	/*
	 * If the compressed data is smaller than the original data,
	 * we use the compressed data. Otherwise, we use the original
	 * data.
	 */
	if (strlen($try) < strlen($ret))
		$ret = "\1".$try;
	else
		$ret = "\0".$ret;

	if ($encode)
		$ret = str_replace(["+", "/", "="], [".", "@", "^"], base64_encode($ret));

	return $ret;
}

function decrypt(string $data, string $key, bool $encode = true): ?string
{
	if ($encode)
		$data = str_replace([".", "@", "^"], ["+", "/", "="], base64_decode($data));

	if ($data[0] === "\1") {
		$data = gzinflate(substr($data, 1));
		if ($data === false)
			return NULL;
	} else {
		$data = substr($data, 1);
	}

	$method = "AES-256-CBC";
	$iv = substr($data, 0, 16);
	$hash = substr($data, 16, 32);
	$ciphertext = substr($data, 48);
	$key = hash('sha256', $key, true);

	if (!hash_equals(hash_hmac('sha256', $ciphertext . $iv, $key, true), $hash))
		return NULL;

	return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}

endif;
