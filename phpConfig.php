<?php
require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/');
define('DEBUG', false);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
