<?php
require_once 'dao/UserDAO.php';
require_once 'dao/CategoryDAO.php';
require_once 'dao/ProductDAO.php';
require_once 'dao/OrderDAO.php';
require_once 'dao/OrderItemDAO.php';
require_once 'dao/ReviewDAO.php';

// ================================
// 🔹 Inicijalizacija DAO objekata
// ================================
$userDao = new UserDAO();
$categoryDao = new CategoryDAO();
$productDao = new ProductDAO();
$orderDao = new OrderDAO();
$orderItemDao = new OrderItemDAO();
$reviewDao = new ReviewDAO();

// ================================
// 🔹 TEST USER DAO
// ================================
echo "<h3>Users:</h3>";
if (method_exists($userDao, 'getAll')) {
    $users = $userDao->getAll();
} elseif (method_exists($userDao, 'getAllOrdered')) {
    $users = $userDao->getAllOrdered();
} else {
    $users = "❌ UserDAO nema getAll() ili getAllOrdered() metodu!";
}
echo "<pre>";
print_r($users);
echo "</pre><br><br>";

// ================================
// 🔹 TEST CATEGORY DAO
// ================================
echo "<h3>Categories:</h3>";
if (method_exists($categoryDao, 'getAll')) {
    $categories = $categoryDao->getAll();
} elseif (method_exists($categoryDao, 'getAllOrdered')) {
    $categories = $categoryDao->getAllOrdered();
} else {
    $categories = "❌ CategoryDAO nema getAll() metodu!";
}
echo "<pre>";
print_r($categories);
echo "</pre><br><br>";

// ================================
// 🔹 TEST PRODUCT DAO
// ================================
echo "<h3>Products:</h3>";
if (method_exists($productDao, 'getAll')) {
    $products = $productDao->getAll();
} elseif (method_exists($productDao, 'getAllOrdered')) {
    $products = $productDao->getAllOrdered();
} else {
    $products = "❌ ProductDAO nema getAll() metodu!";
}
echo "<pre>";
print_r($products);
echo "</pre><br><br>";

// ================================
// 🔹 TEST ORDER DAO
// ================================
echo "<h3>Orders:</h3>";
if (method_exists($orderDao, 'getAll')) {
    $orders = $orderDao->getAll();
} elseif (method_exists($orderDao, 'getAllOrdered')) {
    $orders = $orderDao->getAllOrdered();
} else {
    $orders = "❌ OrderDAO nema getAll() metodu!";
}
echo "<pre>";
print_r($orders);
echo "</pre><br><br>";

// ================================
// 🔹 TEST ORDER ITEM DAO
// ================================
echo "<h3>Order Items:</h3>";
if (method_exists($orderItemDao, 'getAll')) {
    $orderItems = $orderItemDao->getAll();
} elseif (method_exists($orderItemDao, 'getAllOrdered')) {
    $orderItems = $orderItemDao->getAllOrdered();
} else {
    $orderItems = "❌ OrderItemDAO nema getAll() metodu!";
}
echo "<pre>";
print_r($orderItems);
echo "</pre><br><br>";

// ================================
// 🔹 TEST REVIEW DAO
// ================================
echo "<h3>Reviews:</h3>";
if (method_exists($reviewDao, 'getAll')) {
    $reviews = $reviewDao->getAll();
} elseif (method_exists($reviewDao, 'getAllOrdered')) {
    $reviews = $reviewDao->getAllOrdered();
} else {
    $reviews = "❌ ReviewDAO nema getAll() metodu!";
}
echo "<pre>";
print_r($reviews);
echo "</pre><br><br>";

echo "<h3 style='color:green;'>✅ Test DAO skripta završena!</h3>";
?>
