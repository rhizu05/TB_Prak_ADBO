<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=restoqr', 'root', '');
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$tables = [
    'users', 'password_reset_tokens', 'sessions', 
    'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs',
    'migrations',
    'tables', 'categories', 'products', 'orders', 'order_items', 'payments'
];
foreach ($tables as $table) {
    try {
        $pdo->exec("DROP TABLE IF EXISTS $table");
        echo "Dropped $table\n";
    } catch (Exception $e) {
        echo "Failed to drop $table: " . $e->getMessage() . "\n";
    }
}
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
