<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../../../vendor/autoload.php';

$paths = [
    realpath(__DIR__ . '/doc_setup.php'),
    realpath(__DIR__ . '/../../../rest/routes'),
    realpath(__DIR__ . '/../../../rest'),
];

echo "<pre>Scanning these paths:\n";
print_r($paths);
echo "</pre>";

$openapi = \OpenApi\Generator::scan($paths);

header('Content-Type: application/json');
echo $openapi->toJson();
