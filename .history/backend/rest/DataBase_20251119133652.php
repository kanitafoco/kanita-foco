<?php
require_once 'Config.php';

class Database {

    private static $connection;

    // Create and return a PDO connection
    public static function connect() {
        if (!self::$connection) {
            try {
                $dsn = "mysql:host=" . Config::DB_HOST() .
                        ";dbname=" . Config::DB_NAME()
                       ";port=" . Config::DB_PORT() .
                       ;

                self::$connection = new PDO($dsn, Config::DB_USER(), Config::DB_PASSWORD());
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("<h3 style='color:red'>❌ Database connection failed: " . $e->getMessage() . "</h3>");
            }
        }
        return self::$connection;
    }
}
?>


