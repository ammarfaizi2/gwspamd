<?php

function inc_file_ref_count(PDO $pdo, int $file_id)
{
	$st = $pdo->prepare("UPDATE files SET ref_count = ref_count + 1, updated_at = ? WHERE id = ?;");
	$st->execute([date("Y-m-d H:i:s"), $file_id]);
}

function dec_file_ref_count(PDO $pdo, int $file_id)
{
	$st = $pdo->prepare("UPDATE files SET ref_count = ref_count - 1, updated_at = ? WHERE id = ?;");
	$st->execute([date("Y-m-d H:i:s"), $file_id]);
}

function save_file_to_db(PDO $pdo, string $ext, string $sha1_sum,
			 string $md5_sum, bool &$new_file): ?int
{
	$st = $pdo->prepare("SELECT id FROM files WHERE md5_sum = ? AND sha1_sum = ? LIMIT 1;");
	$st->execute([$md5_sum, $sha1_sum]);
	$row = $st->fetch(PDO::FETCH_ASSOC);
	if ($row) {
		$new_file = false;
		inc_file_ref_count($pdo, (int)$row["id"]);
		return (int)$row["id"];
	}

	$new_file = true;
	$st = $pdo->prepare("INSERT INTO files (md5_sum, sha1_sum, ext, ref_count, created_at) VALUES (?, ?, ?, 1, ?);");
	$st->execute([$md5_sum, $sha1_sum, $ext, date("Y-m-d H:i:s")]);
	return (int)$pdo->lastInsertId();
}

function mkdir_hash_path(string $path, string $hash): string
{
	$hash = str_split($hash, 2);

	$dir = $path;
	if (!is_dir($dir))
		mkdir($dir);

	foreach ($hash as $h) {
		$dir .= "/$h";
		if (!is_dir($dir))
			mkdir($dir);
	}

	return $dir;
}

function save_file_to_storage(string $tmp_file, string $ext, string $md5_sum,
			      string $sha1_sum): bool
{
	$md5_sum = bin2hex($md5_sum);
	$sha1_sum = bin2hex($sha1_sum);
	$dir = mkdir_hash_path(STORAGE_DIR."/files", substr($md5_sum, 0, 6));

	$dir .= "/{$md5_sum}_{$sha1_sum}.{$ext}";
	return move_uploaded_file($tmp_file, $dir);
}

function get_file_and_save($name, $path, $max_size = 0, $allowed_exts = [],
			   ?string &$err = NULL): ?string
{
	if (empty($_FILES[$name]["tmp_name"]))
		return NULL;

	$f = $_FILES[$name];
	$ext = strtolower(pathinfo($f["name"], PATHINFO_EXTENSION));

	if ($max_size && $f["size"] > $max_size) {
		$err = "File is too big";
		return NULL;
	}

	if ($allowed_exts && !in_array($ext, $allowed_exts)) {
		$err = "File extension not allowed";
		return NULL;
	}

	$sha1_sum = sha1_file($f["tmp_name"], true);
	$md5_sum = md5_file($f["tmp_name"], true);

	try {
		$new_file = false;
		$pdo = pdo();
		$pdo->beginTransaction();
		$file_id = save_file_to_db($pdo, $ext, $sha1_sum, $md5_sum,
					   $new_file);
		$pdo->commit();
	} catch (PDOException $e) {
		$pdo->rollBack();
		$err = "PDOExeption: " . $e->getMessage();
		return NULL;
	}

	if (!$new_file)
		return $file_id;

	if (!save_file_to_storage($f["tmp_name"], $ext, $md5_sum, $sha1_sum)) {
		$err = "Failed to save file to storage";
		return NULL;
	}

	return $file_id;
}

function fetch_file_path(string $name)
{
	$x = str_split(substr($name, 0, 6), 2);
	$x = implode("/", $x);
	return "{$x}/{$name}";
}
