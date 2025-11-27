<?php
require_once __DIR__ . '/../Database.php';

class BaseDAO {
    protected $connection;
    protected $table_name;

    public function __construct($table_name) {
        $this->connection = Database::connect();
        $this->table_name = $table_name;
    }

    // ✅ Get all rows from the table
    public function getAll() {
        return $this->query("SELECT * FROM {$this->table_name}");
    }

    // ✅ Get a single row by ID
    public function getById($id, $id_column = 'id') {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE {$id_column} = :id", ['id' => $id]);
    }

    // ✅ Insert a new row
    public function add($entity) {
        $columns = implode(", ", array_keys($entity));
        $placeholders = ":" . implode(", :", array_keys($entity));
        $query = "INSERT INTO {$this->table_name} ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        return $this->connection->lastInsertId();
    }

    // ✅ Update an existing row
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

    // ✅ Delete a row by ID
    public function delete($id, $id_column = 'id') {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE {$id_column} = :id");
        return $stmt->execute(['id' => $id]);
    }

    // 🔹 Helper: fetch multiple rows
    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Helper: fetch a single row
    protected function query_unique($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
