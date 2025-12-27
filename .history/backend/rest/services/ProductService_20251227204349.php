<?php

require_once __DIR__ . '/../dao/ProductDAO.php';
require_once __DIR__ . '/../Database.php';

class ProductService {
    private $dao;

    public function __construct() {
        $this->dao = new ProductDAO();
    }

    public function get_all() {
        return $this->dao->getAll();
    }

    public function get_by_id($id) {
        return $this->dao->getById($id, 'product_id');
    }

    public function add($data) {
        return $this->dao->add($data);
    }

    public function update($id, $data) {
        return $this->dao->update($data, $id, 'product_id');
    }

    public function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM reviews WHERE product_id = :id");
        $stmt->execute(['id' => $id]);
        return $this->dao->delete($id, 'product_id');
    }

    public function get_by_category_id($category_id) {
        return $this->dao->getByCategory($category_id);
    }
    
}
