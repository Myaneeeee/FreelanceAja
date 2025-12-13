<?php

/**
 * Vercel Serverless Entry Point
 * * 1. Redirects 'storage' to '/tmp/storage'
 * 2. Redirects 'bootstrap/cache' files to '/tmp/bootstrap/cache'
 */

require __DIR__ . '/../vendor/autoload.php';

// --- CONFIGURATION: PREPARE /tmp DIRECTORIES ---

$tmpDir = '/tmp';
$storageDir = $tmpDir . '/storage';
$cacheDir = $tmpDir . '/bootstrap/cache';

// 1. Ensure /tmp/storage exists
if (!is_dir($storageDir)) {
    mkdir($storageDir, 0777, true);
    // Create standard Laravel storage structure
    $folders = [
        '/app',
        '/framework/cache',
        '/framework/cache/data',
        '/framework/sessions',
        '/framework/views',
        '/logs'
    ];
    foreach ($folders as $folder) {
        mkdir($storageDir . $folder, 0777, true);
    }
}

// 2. Ensure /tmp/bootstrap/cache exists
if (!is_dir($cacheDir)) {
    mkdir($cacheDir, 0777, true);
}

// --- OVERRIDE LARAVEL PATHS ---

// Force Laravel to look for cache files in /tmp instead of /var/task
// We use putenv() so the Application instance picks these up immediately.
putenv("APP_PACKAGES_CACHE={$cacheDir}/packages.php");
putenv("APP_SERVICES_CACHE={$cacheDir}/services.php");
putenv("APP_CONFIG_CACHE={$cacheDir}/config.php");
putenv("APP_ROUTES_CACHE={$cacheDir}/routes.php");
putenv("APP_EVENTS_CACHE={$cacheDir}/events.php");

// Load the App
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Use the new storage path
$app->useStoragePath($storageDir);

// Run the application
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);