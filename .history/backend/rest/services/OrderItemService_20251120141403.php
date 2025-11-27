<?php
require_once __DIR__ . '/../dao/OrderItemDAO.php';

class OrderItemService {
    private $dao;

    public function __construct() {
        $this->dao = new OrderItemDAO();
    }

    private function validate_foreign_keys($data) {
        $db = Database::connect();
    
        // Pokušaj pronaći order
        $stmt = $db->prepare("SELECT order_id FROM orders WHERE order_id = :id");
        $stmt->execute(['id' => $data['order_id']]);
        $order = $stmt->fetch();
    
        // 🔥 AKO ORDER NE POSTOJI → AUTOMATSKI GA KREIRAJ
        if (!$order) {
            $stmt = $db->prepare("INSERT INTO orders (order_id, user_id, status, total_amount, created_at)
                                  VALUES (:id, 1, 'pending', 0, NOW())");
            $stmt->execute(['id' => $data['order_id']]);
        }
    
        // provjeri product
        $stmt = $db->prepare("SELECT product_id FROM products WHERE product_id = :id");
        $stmt->execute(['id' => $data['product_id']]);
        $product = $stmt->fetch();
    
        if (!$product) {
            throw new Exception("Product with ID {$data['product_id']} does not exist.");
        }
    
        return true;
    }

    public function get_all() {
        return $this->dao->getAll();
    }

    public function get_by_id($id) {
        return $this->dao->getById($id, 'order_item_id');
    }

    public function add($data) {
        $allowed = ["order_id", "product_id", "quantity", "unit_price"];

        // izvuci samo polja koja postoje u tabeli
        $clean = array_intersect_key($data, array_flip($allowed));

        // validacija
        foreach ($allowed as $field) {
            if (!isset($clean[$field])) {
                throw new Exception("Missing required field: $field");
            }
        }
        $this->validate_foreign_keys($clean);
        return $this->dao->add($clean);
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
