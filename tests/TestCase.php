<?php

namespace Tests;

use DI\ContainerBuilder;
use Slim\App;
use Slim\Factory\AppFactory;
use Symfony\Component\Dotenv\Dotenv;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected App $app;

    public function setUp(): void
    {
        $containerBuilder = new ContainerBuilder();

        $this->loadEnv();
        $this->importServices($containerBuilder);
        $this->initApp($containerBuilder);
    }

    public function tearDown(): void
    {
        unset($this->app);
    }

    private function loadEnv(): void
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__ . '/../.env');
    }

    private function importServices(ContainerBuilder $containerBuilder): void
    {
        $dependencies = require __DIR__ . '/../app/services.php';
        $dependencies($containerBuilder);
    }

    private function initApp(ContainerBuilder $containerBuilder): void
    {
        $container = $containerBuilder->build();
        AppFactory::setContainer($container);

        $this->app = AppFactory::create();

        $displayErrorDetails = true;
        $errorMiddleware = $this->app->addErrorMiddleware($displayErrorDetails, true, true);
        $errorHandler = $errorMiddleware->getDefaultErrorHandler();
        $errorHandler->forceContentType('application/json');
    }
}


