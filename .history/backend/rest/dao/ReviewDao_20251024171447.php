<?php
require_once 'BaseDao.php';

class ReviewDao extends BaseDao {
    public function __construct() {
        parent::__construct('reviews');
    }

    public function getByProductId($product_id) {
        return $this->query(
            "SELECT * FROM reviews WHERE product_id = :product_id",
            ["product_id" => $product_id]
        );
    }

    public function getByUserId($user_id) {
        return $this->query(
            "SELECT * FROM reviews WHERE user_id = :user_id",
            ["user_id" => $user_id]
        );
    }
}
?>
