<?php
require_once "BaseService.php";
require_once __DIR__ . "/../dao/UserDAO.php";

class UserService extends BaseService {
    public function __construct() {
        parent::__construct(new UserDAO());
    }

    public function get_by_email($email) {
        return $this->dao->get_by_email($email);
    }
}
