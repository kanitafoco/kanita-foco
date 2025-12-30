<?php
require_once 'Config.php';

class Database {

    private static $connection;

    
    public static function connect() {
        if (!self::$connection) {
            try {
                
                self::$connection = new PDO(
                    "mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . ";port=" . Config::DB_PORT(),
                    Config::DB_USER(),
                    Config::DB_PASSWORD(),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("<h3 style='color:red'>❌ Database connection failed: " . $e->getMessage() . "</h3>");
            }
        }
        return self::$connection;
    }
}
?>


