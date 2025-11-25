<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Path to Laravel project
$laravelPath = __DIR__ . '/cict-alumni';

// Maintenance mode check
if (file_exists($maintenance = $laravelPath . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Composer autoload
require $laravelPath . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once $laravelPath . '/bootstrap/app.php';

// Handle the request
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
