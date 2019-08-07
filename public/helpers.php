<?php

// Define application version
define('APP_VERSION', '2.0.7');
define('ROOT_PATH', dirname(__DIR__));
define('BOOT_PATH', ROOT_PATH . '/boot');

chdir(ROOT_PATH);

// Try to load autoload composer
if (!@include_once(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new \ParseError('Unable to load file autoload.php at ' .
        dirname(__DIR__) . '/vendor/');
    die;
}

if (!glob(dirname(__DIR__) . '/.env')) {
    throw new \ParseError('Unable to load file .env at ' .
        dirname(__DIR__) . '/');
    die;
}

// Load dotenv
$dotenv = Dotenv\Dotenv::create(ROOT_PATH);
$dotenv->load();

if (!function_exists('env')) {
    // Custom dotenv value default
    function env($key, $default = null)
    {
        // Get dotenv value
        $value = getenv($key);

        // Check value is false
        if ($value === false) {
            return $default;
        }

        return $value;
    }
}
