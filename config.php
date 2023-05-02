<?php

//// This file returns credentials to log into the db

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