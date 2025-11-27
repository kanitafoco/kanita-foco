<?php

require_once __DIR__ . '/../dao/ProductDAO.php';

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
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        return $this->dao->delete($id, 'product_id');
    }
}
