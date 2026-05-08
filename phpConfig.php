<?php
require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/');
define('DEBUG', true);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
