<?php

//// This file returns credentials to log into the db
/*
return  $config = [
    
        'name' => 'Owly',
        'username' => 'root',
        'password' => '[Piasar7]',
        'connection' => 'mysql:host=127.0.0.1',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ]
    ]
    ;

    */

    require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

return [
    'name' => getenv('DB_NAME'),
    'username' => getenv('DB_USERNAME'),
    'password' => getenv('DB_PASSWORD'),
    'connection' => getenv('DB_CONNECTION'),
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ]
];
