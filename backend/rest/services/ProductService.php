<?php
require_once 'BaseService.php';
require_once __DIR__ . '/../dao/ProductDao.php';

class ProductService extends BaseService {
    public function __construct() {
        parent::__construct(new ProductDao());
    }

    public function getByCategory($category_id) {
        return $this->dao->getByCategory($category_id);
    }

    public function createProduct($data) {
        if ($data['price'] <= 0) {
            throw new Exception("Price must be positive!");
        }
        return $this->create($data);
    }
}
?>
