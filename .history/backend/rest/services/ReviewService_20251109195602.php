<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/ReviewDAO.php";

class ReviewService extends BaseService {
    public function __construct() {
        parent::__construct(new ReviewDAO());
    }

    public function get_by_product_id($product_id) {
        return $this->dao->get_by_product_id($product_id);
    }
}
