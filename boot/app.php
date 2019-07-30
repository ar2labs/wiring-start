<?php

use App\Http\Middleware\SessionMiddleware;

use Wiring\Application;
use Wiring\Interfaces\{ConfigInterface, DatabaseInterface, RouterInterface};
use Wiring\Http\Middleware\{EmitterMiddleware, RouterMiddleware};

use Zend\Diactoros\{Response, ServerRequestFactory};
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

// Create a dependency injection container
$builder = new DI\ContainerBuilder();
$builder->useAnnotations(false);
$builder->useAutowiring(true);

// Check enviroment isn't local
if (getenv('APP_ENV') !== 'local') {
    // Set cache provider
    $builder->enableCompilation(ROOT_PATH . '/storage/cache');
}

// Adding settings
$builder->addDefinitions(ROOT_PATH . '/boot/container.php');

// Generate container
$container = $builder->build();

// Short Config
$config = $container->get(ConfigInterface::class);

// Set default timezone
date_default_timezone_set($config->get('timezone'));

// Eloquent bootloader
if ($config->get('database') === 'eloquent') {
    /** @var \Illuminate\Database\Capsule\Manager */
    $database = $container->get(DatabaseInterface::class);
    $database->bootEloquent();
}

// PSR-7 HTTP Message implementation
$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$response = new Response();
$emitter = new SapiEmitter();

// Create application
$app = new Application($container, $request, $response);

/** @var \League\Route\RouteCollection $route */
$route = $container->get(RouterInterface::class);

// Adding global middlewares
$app->addRouterMiddleware(new RouterMiddleware($route))
    ->addMiddleware(new SessionMiddleware, 'session')
    ->addEmitterMiddleware(new EmitterMiddleware($emitter));

// Let's Go!
$app->run();