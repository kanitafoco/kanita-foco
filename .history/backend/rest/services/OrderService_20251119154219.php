<?php

require_once __DIR__ . '/../dao/OrderDAO.php';

class OrderService {
    private $dao;

    public function __construct(){
        $this->dao = new OrderDAO();
    }

    public function get_all(){ return $this->dao->getAll(); }
    public function get_by_id($id){ return $this->dao->getById($id); }
    public function add($data){ return $this->dao->add($data); }
}
