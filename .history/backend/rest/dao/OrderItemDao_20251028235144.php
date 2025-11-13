<?php
require_once 'BaseDAO.php';

class OrderItemDAO extends BaseDAO {

    public function __construct() {
        parent::__construct('order_items');
    }

    public function create($data) {
        return $this->add($data);
    }

    public function getByOrder($orderId) {
        return $this->query("
            SELECT oi.*, p.name AS product_name, p.price 
            FROM {$this->table_name} oi
            JOIN products p ON oi.product_id = p.product_id
            WHERE oi.order_id = :order_id", ['order_id' => $orderId]);
    }

    public function deleteByOrder($orderId) {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table_name} WHERE order_id = :order_id");
        $stmt->bindValue(':order_id', $orderId);
        return $stmt->execute();
    }
}
?>
