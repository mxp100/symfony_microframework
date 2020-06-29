<?php


namespace Framework\ServiceProviders;


use Framework\Contracts\EnvironmentContract;
use Framework\Services\Environment;

class EnvServiceProvider extends ServiceProvider
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