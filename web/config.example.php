<?php

const DB_HOST = "127.0.0.1";
const DB_PORT = 3306;
const DB_USER = "username";
const DB_PASS = "password";
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
