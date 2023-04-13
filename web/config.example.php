<?php

const DB_HOST = "127.0.0.1";
const DB_PORT = 3306;
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "gwspamd";

const PDO_PARAM = [
	"mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT,
	DB_USER,
	DB_PASS,
	[
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
	]
];

const JSON_ENCODE_FLAGS = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

define("API_DIR", __DIR__ . "/api");
define("PUBLIC_DIR", __DIR__ . "/public");
define("VIEWS_DIR", __DIR__ . "/views");
define("STORAGE_DIR", __DIR__ . "/storage");

define("BASE_URL", "http" . (isset($_SERVER["HTTPS"]) ? "s" : "") . "://" . $_SERVER["HTTP_HOST"]);
define("ASSET_BASE_URL", BASE_URL . "/assets");
