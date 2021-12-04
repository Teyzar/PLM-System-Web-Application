<?php

return [
    'url' => env('APP_URL', env('HEROKU_APP_NAME') ? 'https://' . env('HEROKU_APP_NAME') . '.herokuapp.com' : 'http://localhost'),
    'key' => strpos(env('APP_KEY'), 'base64:') !== false ? env('APP_KEY') : substr(env('APP_KEY'), 0, 32),
];
