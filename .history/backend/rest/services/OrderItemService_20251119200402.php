<?php
require_once __DIR__ . '/../dao/OrderItemDAO.php';

class OrderItemService {
    private $dao;

    public function __construct() {
        $this->dao = new OrderItemDAO();
    }

    public function get_all() {
        return $this->dao->getAll();
    }

    public function get_by_id($id) {
        return $this->dao->getById($id, 'order_item_id');
    }

    public function add($data) {

        // dozvoljena polja
        $allowed = ["order_id", "product_id", "quantity", "unit_price"];

        // uzmi samo ta polja
        $clean = array_intersect_key($data, array_flip($allowed));

        // validacija
        foreach ($allowed as $field) {
            if (!isset($clean[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }

        return $this->dao->add($clean);
    }
    
    public function add($data) {
        return $this->dao->add($data);
    }

    public function update($id, $data) {
        return $this->dao->update($data, $id, 'order_item_id');
    }

    public function delete($id) {
        return $this->dao->delete($id, 'order_item_id');
    }

    public function get_by_order_id($orderId) {
        return $this->dao->getByOrder($orderId);
    }
    
}