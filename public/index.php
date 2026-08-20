<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// If the app has not been installed yet and .env is missing an APP_KEY,
// generate one so sessions/cookies work while the installer runs.
$envFile = __DIR__.'/../.env';
if (file_exists($envFile)) {
    $envContents = file_get_contents($envFile);
    if (! preg_match('/^APP_KEY=.+$/m', $envContents)) {
        $key = 'base64:'.base64_encode(random_bytes(32));
        $envContents = $envContents === '' || substr($envContents, -1) !== "\n"
            ? $envContents."\n"
            : $envContents;
        file_put_contents($envFile, $envContents.'APP_KEY='.$key."\n");
    }
}

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
