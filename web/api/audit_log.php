<?php

function add_user_audit_log(int $user_id, string $action, $extra = NULL)
{
	if (!is_null($extra))
		$extra = json_encode($extra);

	$pdo = pdo();
	$st = $pdo->prepare("INSERT INTO user_audit_logs (user_id, action, extra, created_at) VALUES (?, ?, ?, ?)");
	$st->execute([$user_id, $action, $extra, date("Y-m-d H:i:s")]);
}

function get_audit_log_page_num(int $user_id, int $limit = 100)
{
	$pdo = pdo();
	$st = $pdo->prepare("SELECT COUNT(*) FROM user_audit_logs WHERE user_id = ?");
	$st->execute([$user_id]);
	$count = $st->fetch(PDO::FETCH_NUM)[0];
	return ceil($count / $limit);
}

function get_audit_log_st(int $user_id, int $limit = 100, int $offset = 0)
{
	$pdo = pdo();
	$st = $pdo->prepare("SELECT * FROM user_audit_logs WHERE user_id = ? ORDER BY created_at DESC LIMIT {$limit} OFFSET {$offset}");
	$st->execute([$user_id]);
	return $st;
}
