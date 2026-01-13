<?php
$path = '.env';
$env = file_get_contents($path);

// Force DB Connection
if (strpos($env, 'DB_CONNECTION=') !== false) {
    $env = preg_replace('/^DB_CONNECTION=.*$/m', 'DB_CONNECTION=mysql', $env);
} else {
    $env .= "\nDB_CONNECTION=mysql";
}

// Force DB Host
if (strpos($env, 'DB_HOST=') !== false) {
    $env = preg_replace('/^DB_HOST=.*$/m', 'DB_HOST=127.0.0.1', $env);
} else {
    $env .= "\nDB_HOST=127.0.0.1";
}

// Force DB Port
if (strpos($env, 'DB_PORT=') !== false) {
    $env = preg_replace('/^DB_PORT=.*$/m', 'DB_PORT=3306', $env);
} else {
    $env .= "\nDB_PORT=3306";
}

// Force DB Database
if (strpos($env, 'DB_DATABASE=') !== false) {
    $env = preg_replace('/^DB_DATABASE=.*$/m', 'DB_DATABASE=restoqr', $env);
} else {
    $env .= "\nDB_DATABASE=restoqr";
}

// Force DB Username
if (strpos($env, 'DB_USERNAME=') !== false) {
    $env = preg_replace('/^DB_USERNAME=.*$/m', 'DB_USERNAME=root', $env);
} else {
    $env .= "\nDB_USERNAME=root";
}

// Force DB Password
if (strpos($env, 'DB_PASSWORD=') !== false) {
    $env = preg_replace('/^DB_PASSWORD=.*$/m', 'DB_PASSWORD=', $env);
} else {
    $env .= "\nDB_PASSWORD=";
}

// Fix Session Driver if needed (database is good for production but file is fine for dev)
// Let's set SESSION_DRIVER=file to be safe and simple
//$env = preg_replace('/^SESSION_DRIVER=.*$/m', 'SESSION_DRIVER=file', $env);

file_put_contents($path, $env);
echo "Env updated via Force Script\n";
echo "Current Env Content:\n" . $env . "\n";
