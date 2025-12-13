<?php

/**
 * Vercel Serverless Entry Point
 * * This file replaces public/index.php for Vercel deployments.
 * It ensures storage and cache paths are redirected to /tmp.
 */

// 1. Register the Auto Loader
require __DIR__ . '/../vendor/autoload.php';

// 2. Load the Application (do not run it yet)
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Fix: Redirect Storage to /tmp (The only writable path in Lambda)
$storagePath = '/tmp/storage';

if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    // Recreate the necessary structure usually found in /storage
    $folders = [
        '/app',
        '/framework/cache',
        '/framework/cache/data',
        '/framework/sessions',
        '/framework/views',
        '/logs'
    ];
    
    foreach ($folders as $folder) {
        if (!is_dir($storagePath . $folder)) {
            mkdir($storagePath . $folder, 0777, true);
        }
    }
}

// Tell Laravel to use this new path
$app->useStoragePath($storagePath);

// 4. Handle the Request
// We use the Kernel manually to ensure we catch the request after config modification
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);