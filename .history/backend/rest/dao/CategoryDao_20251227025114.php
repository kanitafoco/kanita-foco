<?php
require_once __DIR__ . '/BaseDAO.php';


class CategoryDAO extends BaseDAO {
    public function __construct() {
        parent::__construct('categories');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function updateCategory($id, $data) {
        return $this->update($data, $id);
    }

    public function getByName($name) {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE name = :name", ['name' => $name]);
    }

    public function nameExists($name, $excludeId = null) {
        $query = "SELECT id FROM {$this->table_name} WHERE name = :name";
        $params = ['name' => $name];
        if ($excludeId) {
            $query .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }
        return !empty($this->query($query, $params));
    }
}
?>
