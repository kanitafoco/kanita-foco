<?php
require_once dirname(__DIR__, 2) . '/Database.php';

class BaseDAO {
    protected $connection;
    protected $table_name;

    public function __construct($table_name) {
        $this->connection = Database::connect();
        $this->table_name = $table_name;
    }

    
    public function getAll() {
        return $this->query("SELECT * FROM {$this->table_name}");
    }

    
    public function getById($id, $id_column = 'id') {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE {$id_column} = :id", ['id' => $id]);
    }

    
    public function add($entity) {
        $columns = implode(", ", array_keys($entity));
        $placeholders = ":" . implode(", :", array_keys($entity));
        $query = "INSERT INTO {$this->table_name} ($columns) VALUES ($placeholders)";
        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        return $this->connection->lastInsertId();
    }

    
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

    
    public function delete($id, $id_column = 'id') {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE {$id_column} = :id");
        return $stmt->execute(['id' => $id]);
    }

   
    protected function query($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    protected function query_unique($query, $params = []) {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
