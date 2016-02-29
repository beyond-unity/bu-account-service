<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERRORS') ?  getenv('DISPLAY_ERRORS') : true,
        
         // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log'
        ],
        'account.service.amqp' => [
        	'host' => 'localhost',
        	'port' => 5672,
        	'user' => 'guest',
        	'pass' => 'guest'
        ],
        'account.service.rest' => [
            'url' => 'http://testing.bd/'
        ]
    ]
];