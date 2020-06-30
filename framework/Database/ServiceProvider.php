<?php


namespace Framework\Database;


use Framework\AbstractServiceProvider;


class ServiceProvider extends AbstractServiceProvider
{

    public $bindings = [
        DatabaseContract::class => Database::class,
    ];

    /**
     * @inheritDoc
     */
    function register(): void
    {
        //
    }
}