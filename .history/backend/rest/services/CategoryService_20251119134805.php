<?php

require_once __DIR__ . '/../dao/CategoryDAO.php';

class CategoryService {
    private $dao;

    public function __construct() {
        $this->dao = new CategoryDAO();
    }

    public function get_all() {
        return $this->dao->get_all();
    }

    public function get_by_id($id) {
        return $this->dao->get_by_id($id);
    }

    public function add($data) {
        return $this->dao->add($data);
    }

    public function update($id, $data) {
        return $this->dao->update($data, $id);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
