<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Running migrate:fresh...\n";
    Illuminate\Support\Facades\Artisan::call('migrate:fresh');
    echo Illuminate\Support\Facades\Artisan::output();

    echo "\nRunning db:seed...\n";
    Illuminate\Support\Facades\Artisan::call('db:seed');
    echo Illuminate\Support\Facades\Artisan::output();
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
