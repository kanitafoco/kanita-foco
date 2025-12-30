<?php


require_once __DIR__ . '/../dao/ProductDAO.php';

class ReviewService {
    private $dao;

    public function __construct() {
        $this->dao = new ReviewDAO();
    }
    public function get_all() { 
        return $this->dao->getAll(); 
    }
    public function get_by_id($id) {
        return $this->dao->getById($id, 'review_id'); 
    }
    public function add($data) { 
        return $this->dao->add($data); 
    }

    public function update($id, $data) {
        return $this->dao->update($data, $id, 'review_id');
    }

    public function delete($id) { 
        return $this->dao->delete($id, 'review_id'); 
    }

    public function get_by_product_id($product_id) {
        return $this->dao->getByProduct($product_id);
    }
}
