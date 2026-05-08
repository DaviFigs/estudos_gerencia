<?php
require_once __DIR__ . '/../phpConfig.php';

class BANCO{

    static function conectar(){
        try{
            $con = new PDO(
                'pgsql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASS']
            );

            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $con;
        }
        catch(Exception $e){
            echo "Erro Conexão: " . $e->getMessage();
            return null;
        }
    }

}