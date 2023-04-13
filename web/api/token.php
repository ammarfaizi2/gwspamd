<?php

const TOKEN_TYPE_USER = 0 << 1;
const TOKEN_TYPE_ADMIN = 1 << 1;

function extract_token(string $token): ?array
{
	$data = decrypt($token, APP_KEY);
	if (!$data)
		return NULL;
	if (strlen($data) < 13)
		return NULL;

	$token_type = unpack("C", $data)[1];
	$user_id = unpack("N", substr($data, 1, 4))[1];
	$timestamp = unpack("J", substr($data, 5, 8))[1];
	return [
		"token_type" => $token_type,
		"user_id" => $user_id,
		"timestamp" => $timestamp
	];
}

function generate_token_user(int $user_id): string
{
	$data = pack("CNJ", TOKEN_TYPE_USER, $user_id, time());
	return encrypt($data, APP_KEY);
}

function generate_token_admin(int $user_id): string
{
	$data = pack("CNJ", TOKEN_TYPE_ADMIN, $user_id, time());
	return encrypt($data, APP_KEY);
}
