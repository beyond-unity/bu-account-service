<?php

return [
    'settings' => [
        'displayErrorDetails' => getenv('DISPLAY_ERRORS') ?  getenv('DISPLAY_ERRORS') : true,

         // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log'
        ],
        'mongohost' => 'mongodb://127.0.0.1',
        'mongodb' => 'bu_accounts'
    ]
];