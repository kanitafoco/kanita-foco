<?php
require_once 'BaseDAO.php';

class CategoryDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('categories');
    }

    // Create a new category
    public function create($data) {
        return $this->add($data);
    }

    // Update an existing category
    public function updateCategory($id, $data) {
        return $this->update($data, $id);
    }

    // Get category by name
    public function getByName($name) {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE name = :name", ['name' => $name]);
    }

    // Get all categories with the number of related recipes
    public function getAllWithRecipeCount() {
        return $this->query("SELECT c.*, COUNT(r.id) AS recipe_count
                             FROM {$this->table_name} c
                             LEFT JOIN recipes r ON c.id = r.category_id
                             GROUP BY c.id
                             ORDER BY c.name");
    }

    // Check if a category name already exists
    public function nameExists($name, $excludeId = null) {
        $query = "SELECT id FROM {$this->table_name} WHERE name = :name";
        $params = ['name' => $name];
        if ($excludeId) {
            $query .= " AND id != :exclude_id";
            $params['exclude_id'] = $excludeId;
        }
        return !empty($this->query($query, $params));
    }

    // Check if category can be safely deleted
    public function canDelete($id) {
        $result = $this->query_unique("SELECT COUNT(*) AS count FROM recipes WHERE category_id = :id", ['id' => $id]);
        return $result['count'] == 0;
    }
}
?>
