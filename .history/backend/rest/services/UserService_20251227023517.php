<?php

require_once __DIR__ . '/../dao/UserDAO.php';

class UserService {
    private $dao;

    public function __construct() {
        $this->dao = new UserDAO();
    }

    public function get_all() { 
        return $this->dao->getAll(); 
    }
    public function get_by_id($id) { 
        return $this->dao->getById($id, 'user_id'); 
    }
    public function add($data) { 
        $allowed_roles = ['user', 'admin', 'cust', 'guest'];

        if (!isset($data['role']) || !in_array($data['role'], $allowed_roles)) {
            return [
                "error" => true,
                "message" => "Invalid role value."
            ];
        }
    
        
        if ($this->dao->getByEmail($data['email'])) {
            $data['email'] = $data['email'] . "_dup_" . rand(1000,9999);
        }
    
        return $this->dao->add($data);
    }
    public function update($id, $data) { 
        return $this->dao->update($data, $id, 'user_id'); 
    }
    public function delete($id) { 
        $db = Database::connect();

    
    $stmt = $db->prepare("SELECT order_id FROM orders WHERE user_id = :uid");
    $stmt->execute(['uid' => $id]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($orders as $order) {
        $oid = $order['order_id'];

        
        $delItems = $db->prepare("DELETE FROM order_items WHERE order_id = :oid");
        $delItems->execute(['oid' => $oid]);
    }

    
    $deleteOrders = $db->prepare("DELETE FROM orders WHERE user_id = :uid");
    $deleteOrders->execute(['uid' => $id]);

    
    $this->dao->delete($id, 'user_id');

    return [
        "error" => false,
        "message" => "User and all related orders have been deleted."
    ];
    }

    public function get_by_email($email) {
        return $this->dao->getByEmail($email);
    }
}
