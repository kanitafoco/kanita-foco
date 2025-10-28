<?php
require_once __DIR__ . '/../dao/BaseDao.php';

class BaseService {
    protected $dao;

    public function __construct($dao) {
        $this->dao = $dao;
    }

    public function getAll() {
        return $this->dao->getAll();
    }

    public function getById($id, $id_column = 'id') {
        return $this->dao->getById($id, $id_column);
    }

    public function create($data) {
        return $this->dao->insert($data);
    }

    public function update($id, $data, $id_column = 'id') {
        return $this->dao->update($id, $data, $id_column);
    }

    public function delete($id, $id_column = 'id') {
        return $this->dao->delete($id, $id_column);
    }
}
?>
