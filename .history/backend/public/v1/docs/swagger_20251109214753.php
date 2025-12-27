<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../vendor/autoload.php';

if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', 'http://localhost/kanita-foco/backend');
} else {
    define('BASE_URL', 'https://your-production-server-link/backend/');
}

$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../rest/routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();

<?php
/**
 * @OA\Info(
 *     title="Shoes Shop API",
 *     description="API documentation for the Shoes Shop project",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="kanita.foco@stu.ibu.edu.ba",
 *         name="Shoes Shop"
 *     )
 * )
 */

/**
 * @OA\Server(
 *     url=BASE_URL,
 *     description="Local API server"
 * )
 */

/**
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
