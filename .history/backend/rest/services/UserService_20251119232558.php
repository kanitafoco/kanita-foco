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
        return $this->dao->add($data); 
    }
    public function update($id, $data) { 
        return $this->dao->update($data, $id, 'user_id'); 
    }
    public function delete($id) { 
        
        return $this->dao->delete($id, 'user_id'); 
    }

    public function get_by_email($email) {
        return $this->dao->getByEmail($email);
    }
}
