<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/OrderItemDAO.php";

class OrderItemService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemDAO());
    }

    public function get_by_order_id($order_id) {
        return $this->dao->get_by_order_id($order_id);
    }
}
