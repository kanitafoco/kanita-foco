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
    
        // Check email uniqueness
        if ($this->dao->getByEmail($data['email'])) {
            return [
                "error" => true,
                "message" => "Email already exists!"
            ];
        }
    
        return $this->dao->add($data);
    }
    public function update($id, $data) { 
        return $this->dao->update($data, $id, 'user_id'); 
    }
    public function delete($id) { 
        $stmt = Database::connect()->prepare("SELECT COUNT(*) AS total FROM orders WHERE user_id = :uid");
        $stmt->execute(['uid' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            return [
                "error" => true,
                "message" => "User cannot be deleted because they have existing orders."
            ];
        }

        // ✔️ Ako nema narudžbi – obriši usera
        $this->dao->delete($id, 'user_id');

        return [
            "error" => false,
            "message" => "User has been deleted successfully."
        ];
    }

    public function get_by_email($email) {
        return $this->dao->getByEmail($email);
    }
}
