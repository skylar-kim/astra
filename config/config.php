<?php
session_start(); // put it here so that session is started on every page that requires this config.php file

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$server = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

define('DB_HOST', $host);
define('DB_USER', $username);
define('DB_PASS', $password);
define('DB_NAME', $db);


?>