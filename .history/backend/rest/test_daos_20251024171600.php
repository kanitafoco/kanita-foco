<?php
require_once 'dao/UserDao.php';
require_once 'dao/CategoryDao.php';
require_once 'dao/ProductDao.php';
require_once 'dao/OrderDao.php';
require_once 'dao/OrderItemDao.php';
require_once 'dao/ReviewDao.php';

// Inicijalizacija DAO objekata
$userDao = new UserDao();
$categoryDao = new CategoryDao();
$productDao = new ProductDao();
$orderDao = new OrderDao();
$orderItemDao = new OrderItemDao();
$reviewDao = new ReviewDao();

// --- USERS ---
echo "<h3>Users:</h3>";
$user = $userDao->getAll();
print_r($user);
echo "<br><br>";

// --- CATEGORIES ---
echo "<h3>Categories:</h3>";
$categories = $categoryDao->getAll();
print_r($categories);
echo "<br><br>";

// --- PRODUCTS ---
echo "<h3>Products:</h3>";
$products = $productDao->getAll();
print_r($products);
echo "<br><br>";

// --- ORDERS ---
echo "<h3>Orders:</h3>";
$orders = $orderDao->getAll();
print_r($orders);
echo "<br><br>";

// --- ORDER ITEMS ---
echo "<h3>Order Items:</h3>";
$orderItems = $orderItemDao->getAll();
print_r($orderItems);
echo "<br><br>";

// --- REVIEWS ---
echo "<h3>Reviews:</h3>";
$reviews = $reviewDao->getAll();
print_r($reviews);
echo "<br><br>";
?>
