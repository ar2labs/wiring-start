<?php

// Define application version
define('APP_VERSION', '2.2.1');
define('PHP_MIN_VER', '7.1.0');
define('ROOT_PATH', dirname(__DIR__));
define('BOOT_PATH', ROOT_PATH . '/boot');

// Change directory
chdir(ROOT_PATH);

// Check PHP version
if (version_compare(PHP_VERSION, PHP_MIN_VER, '<')) {
    throw new \ParseError('This PHP binary is not version ' .
        PHP_MIN_VER . ' or greater.');
    die;
}

// Try to load autoload composer
if (!@include_once(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new \ParseError('Unable to load file autoload.php at ' .
        ROOT_PATH . '/vendor/');
    die;
}

if (!glob(dirname(__DIR__) . '/.env')) {
    throw new \ParseError('Unable to load file .env at ' .
        ROOT_PATH . '/');
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
