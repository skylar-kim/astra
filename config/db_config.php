<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

$dbhost = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$db = substr($url["path"],1);

//define('DB_HOST', $dbhost);
//define('DB_USER', $username);
//define('DB_PASS', $password);
//define('DB_NAME', $db);
define('DB_HOST2', $url["host"]);
define('DB_USER2', $url["user"]);
define('DB_PASS2', $url["pass"]);
define('DB_NAME2', substr($url["path"],1));