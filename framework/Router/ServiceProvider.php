<?php


namespace Framework\Router;


use Framework\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{

    public $bindings = [
        RouterContract::class => Router::class
    ];

    /**
     * @inheritDoc
     */
    function register(): void
    {
        //
    }
}