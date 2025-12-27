<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../vendor/autoload.php';

// BASE URL
if ($_SERVER['SERVER_NAME'] === 'localhost') {
    define('BASE_URL', 'http://localhost/kanita-foco/backend');
} else {
    define('BASE_URL', 'https://production-url.com');
}

// GENERATE OPENAPI
$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../..rest/routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();
