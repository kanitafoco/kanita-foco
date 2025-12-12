<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';
require_once __DIR__ . '/data/Roles.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
   if(
       strpos(Flight::request()->url, '/auth/login') === 0 ||
       strpos(Flight::request()->url, '/auth/register') === 0 ||
       strpos(Flight::request()->url, '/docs') === 0
   ) {
       return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token))
                return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
 
        }
    }
 });
 

// REGISTER SERVICES
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

// ROUTES
require_once __DIR__ .'/rest/routes/CategoryRoutes.php';
require_once __DIR__ .'/rest/routes/ProductRoutes.php';
require_once __DIR__ .'/rest/routes/UserRoutes.php';
require_once __DIR__ .'/rest/routes/OrderRoutes.php';
require_once __DIR__ .'/rest/routes/OrderItemRoutes.php';
require_once __DIR__ .'/rest/routes/ReviewRoutes.php';
require_once __DIR__ .'/rest/routes/AuthRoutes.php';
require_once __DIR__ .'/rest/routes/test.php';

Flight::start();
