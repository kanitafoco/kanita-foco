<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ReviewDao.php';

class ReviewService extends BaseService {
    public function __construct() {
        parent::__construct(new ReviewDao());
    }

    public function getByProduct($product_id) {
        return $this->dao->getByProductId($product_id);
    }

    public function getByUser($user_id) {
        return $this->dao->getByUserId($user_id);
    }
}
?>
