<?php

namespace LG\Infrastructure\Persistence\Shared;

/**
 * Clase que gestiona la conexión a la base de datos.
 */
class Database
{
    private static $instance;
    private \PDO $pdo;

    private function __construct()
    {
        $db_host = 'mysql';
        $db_name = 'lg_db';
        $db_username = 'lg_user';
        $port = "3306";
        $db_password = 'lg_password';

        $this->pdo = new \PDO("mysql:host=$db_host; port=$port; dbname=$db_name",$db_username,$db_password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): \PDO
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}