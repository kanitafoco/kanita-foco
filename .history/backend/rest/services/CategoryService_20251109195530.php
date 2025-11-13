<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/CategoryDAO.php";

class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDAO());
    }
}
