<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ispravna putanja, 3 foldera iznad NIJE ti potrebna
require __DIR__ . '/../../../vendor/autoload.php';

// AUTOMATSKI BASE URL – ne vezan za port!!
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    define('BASE_URL', 'http://localhost/kanita-foco/backend');
} else {
    define('BASE_URL', 'https://production-server/backend');
}

// GENERISANJE OPENAPI SPECIFIKACIJE
$openapi = \OpenApi\Generator::scan([
    __DIR__ . '/doc_setup.php',
    __DIR__ . '/../../../rest/routes'
]);

header('Content-Type: application/json');
echo $openapi->toJson();
