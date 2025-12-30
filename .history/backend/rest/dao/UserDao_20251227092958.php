<?php
require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO {
    public function __construct() {
        parent::__construct('users');
    }

    
    public function create($data) {
        return $this->add($data);
    }

    
    public function updateUser($user_id, $data) {
        return $this->update($data, $user_id, 'user_id');
    }

    
    public function getByEmail($email) {
        return $this->query_unique("SELECT * FROM {$this->table_name} WHERE email = :email", ['email' => $email]);
    }

    
    public function getAllOrdered() {
        return $this->query("SELECT * FROM {$this->table_name} ORDER BY created_at DESC");
    }

    
    public function search($term) {
        $param = '%' . $term . '%';
        return $this->query("SELECT * FROM {$this->table_name} 
                             WHERE full_name LIKE :term OR email LIKE :term", ['term' => $param]);
    }
}
?>
