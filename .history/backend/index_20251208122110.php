<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authentication");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    die();
}

require __DIR__ . '/vendor/autoload.php';

// MIDDLEWARE & CONFIG
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/Roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// ERROR REPORTING
ini_set('display_errors', 1);
error_reporting(E_ALL);

// REGISTER MIDDLEWARE
Flight::register('auth_middleware', 'AuthMiddleware');

// DEFAULT ROUTE

Flight::route('/', function () {

    echo 'Hello world!';
    
    });

// AUTH CHECK (GLOBAL MIDDLEWARE)
Flight::before('start', function() {
    $url = Flight::request()->url;
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        return TRUE;
    }
   }
});

// =============================
// REGISTER SERVICES
// =============================
require_once __DIR__ . '/rest/services/CategoryService.php';
require_once __DIR__ . '/rest/services/ProductService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/OrderService.php';
require_once __DIR__ . '/rest/services/OrderItemService.php';
require_once __DIR__ . '/rest/services/ReviewService.php';
require_once __DIR__ . '/rest/services/AuthService.php';

Flight::register('category_service', 'CategoryService');
Flight::register('product_service', 'ProductService');
Flight::register('user_service', 'UserService');
Flight::register('order_service', 'OrderService');
Flight::register('order_item_service', 'OrderItemService');
Flight::register('review_service', 'ReviewService');
Flight::register('auth_service', 'AuthService');


// =============================
// ROUTES
// =============================
require_once __DIR__ . '/rest/routes/CategoryRoutes.php';
require_once __DIR__ . '/rest/routes/ProductRoutes.php';
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/OrderRoutes.php';
require_once __DIR__ . '/rest/routes/OrderItemRoutes.php';
require_once __DIR__ . '/rest/routes/ReviewRoutes.php';
require_once __DIR__ . '/rest/routes/AuthRoutes.php';
require_once __DIR__ . '/rest/routes/test.php';

// START APP
Flight::start();
