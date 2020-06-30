<?php


namespace Framework\Environment;


use Framework\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{

    public $bindings = [
        EnvironmentContract::class => Environment::class
    ];

    /**
     * @inheritDoc
     */
    function register(): void
    {
        //
    }
}