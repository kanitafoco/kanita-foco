<?php
class Database {
   private static $host = 'localhost';
   private static $dbName = 'milestone2_db';
   private static $username = 'root';
   private static $password = 'root';
   private static $connection = null;

   private static $host = '127.0.0.1'; 
private static $port = '3306'; 
private static $dbName = 'tvoja_baza'; 
private static $username = 'root'; 
private static $password = 'tvoj_password'; 


   public static function connect() {
       if (self::$connection === null) {
           try {
               self::$connection = new PDO(
                   "mysql:host=" . self::$host . ";dbname=" . self::$dbName,
                   self::$username,
                   self::$password,
                   [
                       PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                       PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                   ]
               );
               echo
           } catch (PDOException $e) {
               die("Connection failed: " . $e->getMessage());
           }
       }
       return self::$connection;
   }
}
?>

