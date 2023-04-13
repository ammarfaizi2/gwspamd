<?php

require __DIR__."/config.php";

function pdo(): PDO
{
	return new PDO(...PDO_PARAM);
}
