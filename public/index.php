<?php

// Define enviroment settings
ini_set('display_errors', '1');

// Try to load autoload composer
if (!@include_once('helpers.php')) {
    throw new \Exception('Unable to load file helpers.php at ' .
        ROOT_PATH . '/');
}

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ .
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    throw new \Exception('Invalid requests, check webserver settings.');
}

// Try to load boot application
if (!@include_once(BOOT_PATH . '/app.php')) {
    throw new \Exception('Unable to load file app.php at ' . BOOT_PATH . '/');
}
