<?php
class Db {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new PDO("mysql:host=localhost;dbname=restful", "root", "");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Db();
        }
        return self::$instance->connection;
    }
}
