<?php


namespace Framework\ServiceProviders;


use Framework\Contracts\RouterContract;
use Framework\Services\Router;

class RoutingServiceProvider extends ServiceProvider
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