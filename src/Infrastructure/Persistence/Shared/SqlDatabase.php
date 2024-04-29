<?php

namespace LG\Infrastructure\Persistence\Shared;

/**
 * Clase que gestiona la conexión a la base de datos.
 */
class SqlDatabase implements DatabaseInterface
{
    private static ?DatabaseInterface $instance = null;
    private \PDO $con;

    private function __construct()
    {
        $db_host = 'mysql';
        $db_name = 'lg_db';
        $db_username = 'lg_user';
        $port = "3306";
        $db_password = 'lg_password';

        $this->con = new \PDO("mysql:host=$db_host; port=$port; dbname=$db_name",$db_username,$db_password);
        $this->con->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): DatabaseInterface
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    final public function getConnection(): \PDO
    {
        return $this->con;
    }
}