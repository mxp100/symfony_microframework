<?php

use Framework\Router;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Framework\Services;
use Framework\Contracts;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function (ContainerConfigurator $configurator) {
    $parameters = $configurator->parameters();


    $services = $configurator->services();

    $services->set('logger', Services\Logger::class)->public()->args([
        __DIR__ . '/logger.php',
    ]);

    $services->set('router', Router::class)->public();
    $services->set('request', Router::class)->public();
    $this->application->getContainer()->set(RequestContract::class, Request::createFromGlobals());
//    $this->application->getContainer()->set(ExceptionHandlerContract::class, new ExceptionHandler());

    $services->set('db', Services\Database::class)->public();
    $services->set('view', Services\View::class)->public();
};