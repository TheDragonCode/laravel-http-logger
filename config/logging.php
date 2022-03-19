<?php

return [
    'http' => [
        'enabled' => env('LOG_HTTP_ENABLED', true),

        'connection' => env('DB_CONNECTION'),

        'table' => 'http_logs',
    ],
];
