<?php

// Database connection using PHP MySQLi-Database-Class
require_once __DIR__ . '/../MysqliDb.php';

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'alumni_db');

// Initialize the database instance
$db = new MysqliDb(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check the connection
if (!$db->ping()) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}
