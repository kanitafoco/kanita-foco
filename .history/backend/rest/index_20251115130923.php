<?php
require 'vendor/autoload.php';

// Registruj servise
Flight::register('category_service', 'CategoryService');
Flight::register('order_service', 'OrderService'); 
Flight::register('order_item_service', 'OrderItemService');
Flight::register('product_service', 'ProductService');
Flight::register('review_service', 'ReviewService');
Flight::register('user_service', 'UserService');

// Uključi rute
require_once 'routes/category_routes.php';
require_once 'routes/order_routes.php';
require_once 'routes/order_item_routes.php';
require_once 'routes/product_routes.php';
require_once 'routes/review_routes.php';
require_once 'routes/user_routes.php';

// Swagger dokumentacija
require_once 'swagger.php';

Flight::start();
?>