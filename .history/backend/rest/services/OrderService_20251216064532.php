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

    public function get_by_user_id($user_id){
        $orders = $this->dao->getAll(); 

    // filtriraj samo one koje pripadaju useru
    return array_values(array_filter($orders, function($order) use ($user_id){
        return $order['user_id'] == $user_id;
    }));
    }

    public function add($data){
        $db = Database::connect();

    // ako frontend pošalje user_id koji NE POSTOJI → uzmi jednog koji postoji
    $userCheck = $db->prepare("SELECT user_id FROM users WHERE user_id = :uid");
    $userCheck->execute(['uid' => $data['user_id']]);
    $exists = $userCheck->fetch();

    if (!$exists) {
        // uzmi postojeceg korisnika
        $fallback = $db->query("SELECT user_id FROM users LIMIT 1")->fetch();

        if (!$fallback) {
            throw new Exception("Cannot create order because no users exist in the database.");
        }

        // zamijeni nepostojeći user_id onim koji backend zaista ima
        $data['user_id'] = $fallback['user_id'];
    }
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
