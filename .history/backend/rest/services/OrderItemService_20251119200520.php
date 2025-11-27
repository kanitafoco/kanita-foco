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