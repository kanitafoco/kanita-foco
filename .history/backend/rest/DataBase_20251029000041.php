<?php
require_once 'Config.php';

class Database {

    private static $connection;

    // Create and return a PDO connection
    public static function connect() {
        if (!self::$connection) {
            try {
                $dsn = "mysql:host=" . Config::DB_HOST() .
                       ";port=" . Config::DB_PORT() .
                       ";dbname=" . Config::DB_NAME() .
                       ";charset=utf8";

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


<?php
require_once 'Database.php';

class BaseDAO {
    protected $connection;
    protected $table_name;

    public function __construct($table_name) {
        $this->connection = Database::connect();
        $this->table_name = $table_name;
    }

    // Get all rows from the table
    public function getAll() {
        return $this->query("SELECT * FROM {$this->table_name}");
    }

    // Get a single row by ID
    public function getById($id, $id_column = 'id') {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE {$id_column} = :id", ['id' => $id]);
    }

    // Insert new row
    public function add($entity) {
        $columns = implode(", ", array_keys($entity));
        $placeholders = ":" . implode(", :", array_keys($entity));
        $query = "INSERT INTO {$this->table_name} ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        return $this->connection->lastInsertId();
    }

    // Update existing row
    public function update($entity, $id, $id_column = 'id') {
        $set_clause = "";
        foreach ($entity as $key => $value) {
            $set_clause .= "$key = :$key, ";
        }
        $set_clause = rtrim($set_clause, ", ");
        $query = "UPDATE {$this->table_name} SET $set_clause WHERE {$id_column} = :id";
        $entity['id'] = $id;
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($entity);
    }

    // Delete row by ID
    public function delete($id, $id_column = 'id') {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE {$id_column} = :id");
        return $stmt->execute(['id' => $id]);
    }

    // Execute query returning multiple rows
    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Execute query returning single row
    protected function query_unique($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
