<?php

require_once __DIR__ . '/../dao/OrderDAO.php';

class OrderService {
    private $dao;

    public function __construct(){
        $this->dao = new OrderDAO();
    }

    public function get_all(){
        return $this->dao->getAll();
    }

    public function get_by_id($id){
        return $this->dao->getById($id, 'order_id');
    }

    public function get_by_user_id($user_id){
        return $this->dao->getByUserId($user_id);
    }

    public function add($data){
        return $this->dao->add($data);
    }

    public function update($id, $data){
        return $this->dao->update($data, $id, 'order_id'); 
    }

    public function delete($id){
        return $this->dao->delete($id, 'order_id');
    }
}
