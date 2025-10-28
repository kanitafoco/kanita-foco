<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/OrderDao.php';

class OrderService extends BaseService {
    public function __construct() {
        parent::__construct(new OrderDao());
    }

    public function getByUser($user_id) {
        return $this->dao->getByUserId($user_id);
    }
}
?>
