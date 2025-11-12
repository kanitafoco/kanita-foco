<?php
require_once __DIR__ . "/../Config.php";

class BaseDAO{
    protected $connection;
    protected $table_name;

    public function __construct($table_name){
        $this->table_name=$table_name;
        try{
            //print_r("Successfully connected to the database!");
            $this->connection = new PDO("mysql:host=" . Config::DB_HOST() . ";dbname=" . Config::DB_NAME() . 
            ";charset=utf8;port=" . Config::DB_PORT(), Config::DB_USER(), Config::DB_PASSWORD(), [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch(PDOException $e){
            print_r($e);
            throw $e;
        }
    }
    
    protected function query($query, $params = []){
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    protected function query_unique($query, $params){
        $results = $this->query($query, $params);
        return reset($results);
    }

    //Method for adding an entry to a database table
    public function add($entity){
        $query = "INSERT INTO " . $this->table_name . " (";
        foreach($entity as $column => $value){
            $query .= $column . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ") VALUES (";
        foreach($entity as $column => $value){
            $query .= ":" . $column . ', ';
        }
        $query = substr($query, 0, -2); //Remove the , and whitespace after the above loop finishes
        $query .= ")";
        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }
    
    //Method for updating an entry from a database table
    public function update($entity, $id, $id_column = "id"){
        $query = "UPDATE " . $this->table_name . " SET ";
        foreach($entity as $column => $value){
            $query .= $column . "=:" . $column . ", ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE " . $id_column . " = :id";
        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
        return $entity;
    }

    //Method for deleting an entry from a database table
    public function delete($id){
        $stmt = $this->connection->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    //Method for getting all entries (no filter criteria) from a database table
    public function get_all(){
        return $this->query("SELECT * FROM " . $this->table_name, []);
    }
}


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
