<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

return [
    'default_channel' => 'default',
    'channels' => [
        'default' => [
            new StreamHandler(storage_path('logs/framework.log'), Logger::WARNING),
        ]
    ]
];