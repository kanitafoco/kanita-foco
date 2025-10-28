<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/OrderItemDao.php';

class OrderItemService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderItemDao());
    }

    public function getByOrder($order_id) {
        return $this->dao->getByOrderId($order_id);
    }
}
?>
