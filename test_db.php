<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=restoqr', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE TABLE IF NOT EXISTS test_connectivity (id INT)");
    echo "Table created successfully\n";
    $pdo->exec("DROP TABLE test_connectivity");
    echo "Table dropped successfully\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
