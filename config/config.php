<?php

return [
    'url' => env('AUTH_APP_URL'),
    'client_id' => env('AUTH_APP_CLIENT_ID'),
    'dashboard_url' => env('AUTH_APP_AFTER_LOGIN_URL', config('app.url')),
];
