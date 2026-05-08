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

            // 🔥 FORÇA conexão IPv4 + SSL (SOLUÇÃO REAL)
            $dsn = "pgsql:host=$host;port=5432;dbname=$dbname;sslmode=require";

            $con = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 10
            ]);

            return $con;

        } catch (Exception $e) {
            echo "Erro Conexão: " . $e->getMessage();
            return null;
        }
    }
}