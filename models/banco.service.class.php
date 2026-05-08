<?php
require_once __DIR__ . '/../phpConfig.php';

class BANCO {

    static function conectar() {
        try {

            $url = $_ENV['DATABASE_URL'];
            $db = parse_url($url);

            $host = $db['host'];
            $user = $db['user'];
            $pass = $db['pass'];
            $dbname = ltrim($db['path'], '/');

            // 🔥 FORÇA IPv4 resolvendo DNS manualmente
            $ip = gethostbyname($host);

            $dsn = "pgsql:host=$ip;port=5432;dbname=$dbname;sslmode=require";

            $con = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            return $con;

        } catch (Exception $e) {
            echo "Erro Conexão: " . $e->getMessage();
            return null;
        }
    }
}