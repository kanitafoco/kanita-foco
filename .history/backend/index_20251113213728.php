<?php
require __DIR__ . '/../vendor/autoload.php';

// === REGISTER SERVICES ===
require_once __DIR__ . '/../rest/services/CategoryService.php';
require_once __DIR__ . '/../rest/services/ProductService.php';
require_once __DIR__ . '/../rest/services/UserService.php';
require_once __DIR__ . '/../rest/services/ReviewService.php';
require_once __DIR__ . '/../rest/services/OrderService.php';
require_once __DIR__ . '/../rest/services/OrderItemService.php';

Flight::register('category_service', 'CategoryService');
Flight::register('product_service', 'ProductService');
Flight::register('user_service', 'UserService');
Flight::register('review_service', 'ReviewService');
Flight::register('order_service', 'OrderService');
Flight::register('order_item_service', 'OrderItemService');

// === ROUTES ===
require_once __DIR__ . '/../rest/routes/CategoryRoutes.php';
require_once __DIR__ . '/../rest/routes/ProductRoutes.php';
require_once __DIR__ . '/../rest/routes/UserRoutes.php';
require_once __DIR__ . '/../rest/routes/ReviewRoutes.php';
require_once __DIR__ . '/../rest/routes/OrderRoutes.php';
require_once __DIR__ . '/../rest/routes/OrderItemRoutes.php';

// === HEALTH CHECK ===
Flight::route('GET /health', function () {
    Flight::json(['status' => 'OK', 'time' => time()]);
});

Flight::start();
