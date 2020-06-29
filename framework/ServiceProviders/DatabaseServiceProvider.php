<?php


namespace Framework\ServiceProviders;


use Framework\Contracts\DatabaseContract;
use Framework\Services\Database;

class DatabaseServiceProvider extends ServiceProvider
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