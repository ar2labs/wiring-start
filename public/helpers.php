<?php

declare(strict_types=1);

// Define application version
define('APP_VERSION', '2.3.7');
define('PHP_MIN_VER', '8.5.0');
define('ROOT_PATH', dirname(__DIR__));
define('BOOT_PATH', ROOT_PATH . '/boot');
define('STORAGE_PATH', ROOT_PATH . '/storage');

// Change directory
chdir(ROOT_PATH);

// Check PHP version
if (version_compare(PHP_VERSION, PHP_MIN_VER, '<')) {
    throw new \ParseError('This PHP binary is not version ' .
        PHP_MIN_VER . ' or greater.');
}

// Try to load autoload composer
if (!@include_once(dirname(__DIR__) . '/vendor/autoload.php')) {
    throw new \ParseError('Unable to load file autoload.php at ' .
        ROOT_PATH . '/vendor/');
}

// Load dotenv when available. Defaults keep CLI tooling usable before .env exists.
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->safeLoad();

if (!function_exists('env')) {
    /**
     * Read an environment value with light casting for common .env literals.
     *
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

        if ($value === false || $value === null) {
            return $default;
        }

        if (!is_string($value)) {
            return $value;
        }

        $normalized = strtolower(trim($value));

        return match ($normalized) {
            'true', '(true)' => true,
            'false', '(false)' => false,
            'null', '(null)' => null,
            'empty', '(empty)' => '',
            default => trim($value, "\"'"),
        };
    }
}
