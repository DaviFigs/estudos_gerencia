<?php
require __DIR__ . '/vendor/autoload.php';

define('BASE_PATH', __DIR__ . '/');
define('DEBUG', false);

if (session_status() !== PHP_SESSION_ACTIVE) {

    $lifetime = 60 * 60 * 24 * 30;

    session_set_cookie_params([
        'lifetime' => $lifetime,
        'path' => '/',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    ini_set('session.gc_maxlifetime', $lifetime);

    session_start();
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();