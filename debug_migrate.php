<?php
define('LARAVEL_START', microtime(true));
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
try {
    $kernel->call('migrate', ['-v' => true]);
    echo $kernel->output();
} catch (\Exception $e) {
    echo "CAUGHT EXCEPTION:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
