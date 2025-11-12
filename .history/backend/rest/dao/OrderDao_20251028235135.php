<?php
require_once 'BaseDAO.php';

class OrderDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('orders');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function getByUser($userId) {
        return $this->query("SELECT * FROM {$this->table_name} WHERE user_id = :user_id ORDER BY created_at DESC", ['user_id' => $userId]);
    }

    public function updateOrderStatus($orderId, $status) {
        return $this->update(['status' => $status], $orderId, 'order_id');
    }

    public function getDetails($orderId) {
        return $this->query_unique("
            SELECT o.*, u.full_name, u.email 
            FROM {$this->table_name} o
            JOIN users u ON o.user_id = u.user_id
            WHERE o.order_id = :order_id", ['order_id' => $orderId]);
    }
}
?>
