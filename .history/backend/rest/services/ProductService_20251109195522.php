<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/ProductDAO.php";

class ProductService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductDAO());
    }

    public function get_by_category_id($category_id) {
        return $this->dao->get_by_category_id($category_id);
    }
}
