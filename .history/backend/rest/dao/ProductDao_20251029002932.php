<?php
require_once 'BaseDAO.php';

class ProductDAO extends BaseDAO {
    public function __construct() {
        parent::__construct('products');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function updateProduct($id, $data) {
        return $this->update($data, $id, 'product_id');
    }

    public function getByCategory($categoryId) {
        return $this->query("SELECT * FROM {$this->table_name} WHERE category_id = :category_id", ['category_id' => $categoryId]);
    }

    public function search($term) {
        $param = '%' . $term . '%';
        return $this->query("SELECT * FROM {$this->table_name} WHERE name LIKE :term OR description LIKE :term", ['term' => $param]);
    }
}
?>
