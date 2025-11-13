<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Učitaj composer autoload
require __DIR__ . '/../../../vendor/autoload.php';

// Definiši BASE_URL odmah
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('BASE_URL', 'http://localhost:8006');
} else {
    define('BASE_URL', 'https://add-production-server-after-deployment/backend/');
}

// ⚠️ Uključi doc_setup.php prije skeniranja
require_once __DIR__ . '/doc_setup.php';

// Pokreni OpenAPI scan samo za potrebne direktorije
$openapi = \OpenApi\Generator::scan([
    realpath(__DIR__ . '/../../../rest/routes')
]);

// Vrati rezultat kao JSON
header('Content-Type: application/json');
echo $openapi->toJson();
