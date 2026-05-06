<?php
require_once '../phpConfig.php';

class Auth
{
    public static function check()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return !empty($_SESSION['logged']);
    }

    public static function require_logout()
    {
        if (self::check()) {
            header("Location: home.php");
            exit;
        }

        return true;
    }
    public static function requireLogin()
    {
        if (!self::check()) {

            // modo debug
            if (defined('DEBUG') && DEBUG) {
                echo "<pre>Usuário não logado</pre>";
                return false; // não trava execução
            }
            header("Location: login.php");
            exit;
        }

        return true;
    }

    public static function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header("Location: login.php");
        exit;
    }
}