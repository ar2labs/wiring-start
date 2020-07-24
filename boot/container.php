<?php

declare(strict_types=1);

use App\Provider\Eloquent;
use App\Provider\Router;

use League\Route\Strategy\ApplicationStrategy;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Noodlehaus\Config;

use PHPMailer\PHPMailer\PHPMailer;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use Wiring\Http\Exception\ErrorHandler;
use Wiring\Http\Helpers\Console;
use Wiring\Http\Helpers\Loader;
use Wiring\Http\Helpers\Mailer;
use Wiring\Http\Helpers\Session;
use Wiring\Interfaces\ConfigInterface;
use Wiring\Interfaces\ConsoleInterface;
use Wiring\Interfaces\DatabaseInterface;
use Wiring\Interfaces\ErrorHandlerInterface;
use Wiring\Interfaces\JsonStrategyInterface;
use Wiring\Interfaces\MailerInterface;
use Wiring\Interfaces\RouterInterface;
use Wiring\Interfaces\SessionInterface;
use Wiring\Interfaces\ViewStrategyInterface;
use Wiring\Strategy\JsonStrategy;
use Wiring\Strategy\ViewStrategy;

use Zend\Diactoros\Response;

return [

    // Get config path
    ConfigInterface::class => function () {
        return new Config(ROOT_PATH . '/config');
    },

    RouterInterface::class => function (ContainerInterface $container) {
        // Mapper routes
        $strategy = (new ApplicationStrategy());
        $strategy->setContainer($container);

        // Create router
        $route = new Router();

        // Set strategy
        $route->setStrategy($strategy);

        // Loader routes path
        $loader = new Loader();
        $loader->addPath(ROOT_PATH . '/routes');

        foreach ($loader->load() as $routes) {
            // Get routes
            require $routes;
        }

        return $route;
    },

    // Inline Response
    ResponseInterface::class => DI\get(Response::class),

    // Inline Factories
    ContainerInterface::class => DI\get(DI\Container::class),

    JsonStrategyInterface::class => DI\create(JsonStrategy::class),

    ViewStrategyInterface::class => DI\factory(function (
        ContainerInterface $container
    ) {
        // Get debug
        $debug = $container
            ->get(ConfigInterface::class)
            ->get('displayErrorDetails');

        // The cache option is a compilation cache directory
        $cache = false; // ROOT_PATH . '/storage/cache';

        // Create template engine
        $loader = new FilesystemLoader(ROOT_PATH . '/resources/view');

        $engine = new Environment($loader, [
            'debug' => $debug,
            'strict_variables' => false,
            'cache' => $cache,
            'auto_reload' => null,
            'optimizations' => -1,
        ]);

        // Registers some extensions to be available in your templates.
        $engine->addExtension(new \App\Provider\TwigExtension());

        // Add session as global template variable
        $session = $container->get(SessionInterface::class);
        $engine->addGlobal('session', $session);

        // Create a view renderer
        $view = new ViewStrategy($engine);

        return $view;
    }),

    ConsoleInterface::class => DI\create(Console::class),

    SessionInterface::class => DI\create(Session::class),

    DatabaseInterface::class => DI\factory(function (
        ContainerInterface $container
    ) {
        // Load database settings
        $params = $container->get(ConfigInterface::class)->get('connections');
        $conn = null;

        // Check enviroment database connection is Eloquent
        if (env('DB_CONNECTION') == 'eloquent') {
            // Create a Capsule instance
            $conn = new Eloquent($params[env('DB_CONNECTION', 'eloquent')]);
        }

        return $conn;
    }),

    MailerInterface::class => function (ContainerInterface $container) {
        // Get config
        $config = $container->get(ConfigInterface::class);

        // Create e-mail transport
        $mailer = new PHPMailer(false);
        $mailer->Host = $config->get('mail.host');
        $mailer->Port = $config->get('mail.port');
        $mailer->Username = $config->get('mail.username');
        $mailer->Password = $config->get('mail.password');
        $mailer->FromName = $config->get('mail.from.name');
        $mailer->From = $config->get('mail.from');
        $mailer->SMTPAuth = true;
        $mailer->SMTPSecure = '';
        $mailer->isSMTP();
        $mailer->isHTML(true);

        return new Mailer($mailer, $container);
    },

    LoggerInterface::class => DI\factory(function () {
        // Create a log channel
        $logger = new Logger('app');

        $fileHandler = new StreamHandler(
            ROOT_PATH . 'storage/log/app.log',
            Logger::DEBUG
        );

        $fileHandler->setFormatter(new LineFormatter());

        $logger->pushHandler($fileHandler);

        return $logger;
    }),

    ErrorHandlerInterface::class => function (ContainerInterface $container) {
        return function (
            ServerRequestInterface $request,
            ResponseInterface $response,
            Throwable $exception
        ) use ($container) {

            // Get logger and config instance
            $logger = $container->get(LoggerInterface::class);
            $config = $container->get(ConfigInterface::class);

            // Get debug settings from config
            $debug = $config
                ->get('displayErrorDetails');

            $loggerContext = [];

            // Create a error handler instance
            $handler = new ErrorHandler(
                $request,
                $response,
                $exception,
                $logger,
                $loggerContext,
                $debug
            );

            $title = $debug ?
                $config
                ->get('lang.alerts.error_debug') : $config
                ->get('lang.alerts.error');

            $error = $handler->error($title);

            if ($handler->isJson()) {
                $json = $container->get(JsonStrategyInterface::class);

                return $json
                    ->render($error, JSON_UNESCAPED_SLASHES)
                    ->to($response);
            }

            $view = $container->get(ViewStrategyInterface::class);

            switch ($error['code']) {
                case 404:
                    return $view
                        ->render('error/error404.twig')
                        ->to($response, 404);
                case 405:
                    // Define allow methods
                    return $view
                        ->render('error/error405.twig', ['allow' => []])
                        ->to($response, 405);
                default:
                    return $view
                        ->render('error/error.twig', $error)
                        ->to($response);
            }
        };
    },

];
