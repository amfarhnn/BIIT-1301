<?php
// Environment variables are used by Docker; defaults keep local XAMPP usage working.
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'system');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'password');
define('DB_CONNECTION_STRING', getenv('DB_CONNECTION_STRING') ?: 'localhost:1521/XE');
define('APP_NAME', 'E-Commerce System');
?>
