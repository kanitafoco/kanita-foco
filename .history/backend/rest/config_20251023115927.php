<?php
class Database {
    private static $host = '127.0.0.1';
    private static $dbName = 'milestone2_db';
    private static $username = 'root';
    private static $password = 'tvoja_lozinka_iz_dbeavera';
    private static $connection = null;

    public static function connect() {
        if (self::$connection == null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$host . ";port=3306;dbname=" . self::$dbName . ";charset=utf8mb4",
                    self::$username,
                    self::$password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public static function disconnect() {
        self::$connection = null;
    }
}
?>
