<?php

require_once __DIR__ . '/../dao/OrderItemDAO.php';

class OrderItemService {
    private $dao;

    public function __construct(){
        $this->dao = new OrderItemDAO();
    }

    public function add($data){ return $this->dao->add($data); }
}
