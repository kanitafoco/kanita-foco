<?php
require_once 'services/UserService.php';
require_once 'services/CategoryService.php';
require_once 'services/ProductService.php';
require_once 'services/OrderService.php';
require_once 'services/OrderItemService.php';
require_once 'services/ReviewService.php';

// Inicijalizacija servisa
$userService = new UserService();
$categoryService = new CategoryService();
$productService = new ProductService();
$orderService = new OrderService();
$orderItemService = new OrderItemService();
$reviewService = new ReviewService();

// --- USERS ---
echo "<pre>Users:\n";
$users = $userService->getAll();
print_r($users);
echo "</pre>";

// --- CATEGORIES ---
echo "<pre>Categories:\n";
$categories = $categoryService->getAll();
print_r($categories);
echo "</pre>";

// --- PRODUCTS ---
echo "<pre>Products:\n";
$products = $productService->getAll();
print_r($products);
echo "</pre>";

// --- ORDERS ---
echo "<pre>Orders:\n";
$orders = $orderService->getAll();
print_r($orders);
echo "</pre>";

// --- ORDER ITEMS ---
echo "<pre>Order Items:\n";
$orderItems = $orderItemService->getAll();
print_r($orderItems);
echo "</pre>";

// --- REVIEWS ---
echo "<pre>Reviews:\n";
$reviews = $reviewService->getAll();
print_r($reviews);
echo "</pre>";

echo "<hr><h3 style='color:green'>✅ Service layer test complete</h3>";
?>

