<?php

require_once __DIR__ . '/../dao/OrderDAO.php';

class OrderService {
    private $dao;

    public function __construct(){
        $this->dao = new OrderDAO();
    }

    public function get_all(){
        return $this->dao->getAll();
    }

    public function get_by_id($id){
        return $this->dao->getById($id, 'order_id');
    }

    <h1>500 Internal Server Error</h1>
    <h3>Call to undefined method OrderDAO::getByUserId() (0)</h3>
    <pre>#0 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/rest/routes/OrderRoutes.php(46): OrderService->get_by_user_id('1')
#1 [internal function]: {closure}('1')
#2 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(366): call_user_func_array(Object(Closure), Array)
#3 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(299): flight\core\Dispatcher->invokeCallable(Object(Closure), Array)
#4 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Engine.php(616): flight\core\Dispatcher->execute(Object(Closure), Array)
#5 [internal function]: flight\Engine->_start()
#6 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(388): call_user_func_array(Array, Array)
#7 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(299): flight\core\Dispatcher->invokeCallable(Array, Array)
#8 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(143): flight\core\Dispatcher->execute(Array, Array)
#9 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/core/Dispatcher.php(106): flight\core\Dispatcher->runEvent('start', Array)
#10 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Engine.php(154): flight\core\Dispatcher->run('start', Array)
#11 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/vendor/mikecao/flight/flight/Flight.php(125): flight\Engine->__call('start', Array)
#12 /Applications/XAMPP/xamppfiles/htdocs/kanita-foco/backend/index.php(28): Flight::__callStatic('start', Array)
#13 {main}</pre>
    }

    public function add($data){
        return $this->dao->add($data);
    }

    public function update($id, $data){
        return $this->dao->update($data, $id, 'order_id'); 
    }

    public function delete($id){
        $itemService = new OrderItemService();
        $items = $itemService->get_by_order_id($id);
        foreach ($items as $item) {
            $itemService->delete($item['order_item_id']);
    }
        return $this->dao->delete($id, 'order_id');
    }
}
