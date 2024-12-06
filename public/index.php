<?php
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;
use DI\ContainerBuilder;

define('APP_ROOT', dirname(__DIR__));
require APP_ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$builder = new ContainerBuilder;
$container = $builder->addDefinitions(APP_ROOT . '/config/definitions.php')->build();

AppFactory::setContainer($container);

$app = AppFactory::create();
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$collector = $app->getRouteCollector();
$collector->setDefaultInvocationStrategy(new RequestResponseArgs);

// routes
require '../src/App/routes.php';

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
// $errorHandler = $errorMiddleware->getDefaultErrorHandler();
// $errorHandler->forceContentType('application/json');

$app->run();