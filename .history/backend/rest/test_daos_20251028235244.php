<?php
require_once 'dao/UserDAO.php';
require_once 'dao/CategoryDAO.php';
require_once 'dao/ProductDAO.php';
require_once 'dao/OrderDAO.php';
require_once 'dao/OrderItemDAO.php';
require_once 'dao/ReviewDAO.php';

echo "<h2>=== DAO Testing Script ===</h2>";

$userDao = new UserDAO();
$categoryDao = new CategoryDAO();
$productDao = new ProductDAO();
$orderDao = new OrderDAO();
$orderItemDao = new OrderItemDAO();
$reviewDao = new ReviewDAO();

function testDAO($name, $dao) {
    echo "<h3>$name:</h3>";
    if (method_exists($dao, 'getAll')) {
        $result = $dao->getAll();
    } elseif (method_exists($dao, 'getAllOrdered')) {
        $result = $dao->getAllOrdered();
    } else {
        $result = "❌ $name DAO has no getAll() or getAllOrdered() method!";
    }
    echo "<pre>";
    print_r($result);
    echo "</pre><br><br>";
}

testDAO("Users", $userDao);
testDAO("Categories", $categoryDao);
testDAO("Products", $productDao);
testDAO("Orders", $orderDao);
testDAO("Order Items", $orderItemDao);
testDAO("Reviews", $reviewDao);

echo "<h3 style='color:green;'>✅ DAO Test Script Completed!</h3>";
?>
