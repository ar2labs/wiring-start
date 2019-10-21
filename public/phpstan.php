<?php

// Define application version
define('ROOT_PATH', dirname(__DIR__));

chdir(ROOT_PATH);

// Try to load autoload composer
if (!@include_once(ROOT_PATH . '/vendor/autoload.php')) {
    throw new \ParseError('Unable to load file autoload.php at ' .
        ROOT_PATH . '/vendor/');
    die;
}
