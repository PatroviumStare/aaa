<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

define('STORAGE_PATH', __DIR__ . '/storage/');
define('USERS_FILE', STORAGE_PATH . 'users.json');
define('TASKS_FILE', STORAGE_PATH . 'tasks.json');
define('UPLOAD_PATH', __DIR__ . '/uploads/');

if (!is_dir(STORAGE_PATH)) mkdir(STORAGE_PATH, 0755, true);
if (!is_dir(UPLOAD_PATH)) mkdir(UPLOAD_PATH, 0755, true);

if (!file_exists(USERS_FILE)) file_put_contents(USERS_FILE, '[]');
if (!file_exists(TASKS_FILE)) file_put_contents(TASKS_FILE, '[]');

define('BASE_URL', '/Tasks/IP2/'); 
?>