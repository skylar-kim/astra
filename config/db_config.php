<?php
$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

define('DB_HOST2', $url["host"]);
define('DB_USER2', $url["user"]);
define('DB_PASS2', $url["pass"]);
define('DB_NAME2', substr($url["path"],1));