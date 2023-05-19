<?php


    require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

return $config = [
    'name' => $_ENV['DB_NAME'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD'],
    'connection' => $_ENV['DB_CONNECTION'],
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ]
];

