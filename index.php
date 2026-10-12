<?php

define('LARAVEL_START', microtime(true));

$projectDir = __DIR__;

$autoload = $projectDir . '/vendor/autoload.php';

if (!file_exists($autoload)) {
    die(
        'Error: Could not find vendor/autoload.php.<br>' .
        'Expected: ' . htmlspecialchars($autoload)
    );
}

require $autoload;

$app = require_once $projectDir . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::capture();

$response = $kernel->handle($request);

$response->send();

$kernel->terminate($request, $response);