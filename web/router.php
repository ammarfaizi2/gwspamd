<?php

$uri = $_SERVER["REQUEST_URI"];
$uri = explode("?", $uri);
if (file_exists(__DIR__."/public/{$uri[0]}"))
	return false;

require __DIR__."/public/404.php";
return true;
