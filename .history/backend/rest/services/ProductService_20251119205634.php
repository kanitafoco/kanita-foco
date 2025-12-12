<?php

require_once __DIR__ . '/../dao/ProductDAO.php';

class ProductService {
    private $dao;

    public function __construct() {
        $this->dao = new ProductDAO();
    }

    public function get_all() {
        return $this->dao->getAll();
    }

    public function get_by_id($id) {
        return $this->dao->getById($id, <h1>500 Internal Server Error</h1>
        <h3>SQLSTATE[42S22]: Column not found: 1054 Unknown column 'id' in 'where clause' (42S22)</h3>
        <pre>#0 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/rest/dao/BaseDAO.php(49): PDOStatement->execute(Array)
    #1 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/rest/services/ProductService.php(29): BaseDAO->delete('1')
    #2 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/rest/routes/ProductRoutes.php(142): ProductService->delete('1')
    #3 [internal function]: {closure}('1')
    #4 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(366): call_user_func_array(Object(Closure), Array)
    #5 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(299): flight\core\Dispatcher->invokeCallable(Object(Closure), Array)
    #6 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Engine.php(616): flight\core\Dispatcher->execute(Object(Closure), Array)
    #7 [internal function]: flight\Engine->_start()
    #8 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(388): call_user_func_array(Array, Array)
    #9 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(299): flight\core\Dispatcher->invokeCallable(Array, Array)
    #10 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(143): flight\core\Dispatcher->execute(Array, Array)
    #11 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(106): flight\core\Dispatcher->runEvent('start', Array)
    #12 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Engine.php(154): flight\core\Dispatcher->run('start', Array)
    #13 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Flight.php(125): flight\Engine->__call('start', Array)
    #14 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/index.php(28): Flight::__callStatic('start', Array)
    #15 {main}</pre>);
    }

    public function add($data) {
        return $this->dao->add($data);
    }

    public function update($id, $data) {
        return $this->dao->update($id, $data);
    }

    public function delete($id) {
        return $this->dao->delete($id);
    }
}
