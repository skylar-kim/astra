<?php
session_start(); // put it here so that session is started on every page that requires this config.php file

$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$dbhost = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

define('DB_HOST', $url["host"]);
define('DB_USER', $url["user"]);
define('DB_PASS', $url["pass"]);
define('DB_NAME', substr($url["path"],1));


?>