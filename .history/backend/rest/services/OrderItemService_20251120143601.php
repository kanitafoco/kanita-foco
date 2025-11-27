<?php
require_once __DIR__ . '/../dao/OrderItemDAO.php';

class OrderItemService {
    private $dao;

    public function __construct() {
        $this->dao = new OrderItemDAO();
    }

    private function validate_foreign_keys($data) {
        $db = Database::connect();
    
        // pokušaj pronaći order sa datim ID-em
        $stmt = $db->prepare("SELECT order_id FROM orders WHERE order_id = :id");
        $stmt->execute(['id' => $data['order_id']]);
        $order = $stmt->fetch();
    
        // ako order NE postoji — kreiramo ga u lokalnoj bazi
        if (!$order) {

            // uzmi JEDNOG korisnika koji POSTOJI u backend bazi
            $userQuery = $db->query("SELECT user_id FROM users LIMIT 1");
            $existingUser = $userQuery->fetch();
        
            if (!$existingUser) {
                throw new Exception("Cannot create order because no users exist in the database.");
            }
        
            $insert = $db->prepare("
                INSERT INTO orders (order_id, user_id, order_date, status, total_amount)
                VALUES (:order_id, :uid, NOW(), 'pending', 0)
            ");
        
            $insert->execute([
                'order_id' => $data['order_id'],
                'uid'      => $existingUser['user_id']
            ]);
        }
    
        // provjera proizvoda
        $stmt = $db->prepare("SELECT product_id FROM products WHERE product_id = :id");
        
        $stmt->execute(['id' => $data['product_id']]);
        $product = $stmt->fetch();
        
        if (!$product) {
            // uzmi neku kategoriju da se proizvod može kreirati
            
            $catQuery = $db->query("SELECT category_id FROM categories LIMIT 1");
            $category = $catQuery->fetch();
            
            if (!$category) {
                throw new Exception("Cannot create product because no categories exist.");
            }
            
            // automatski kreiraj proizvod u backend bazi
            $auto = $db->prepare("
            INSERT INTO products (product_id, category_id, name, description, price, stock)
            VALUES (:id, :cat, 'Auto Product', 'Auto-created product', 0, 0)
    ");

    $auto->execute([
        'id' => $data['product_id'],
        'cat' => $category['category_id']
    ]);
    
    
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
