<?php


namespace Framework\ServiceProviders;


use Framework\Contracts\ExceptionHandlerContract;
use Framework\Services\ExceptionHandler;

class ExceptionServiceProvider extends ServiceProvider
{

    public $singletons = [
        ExceptionHandlerContract::class => ExceptionHandler::class,
    ];

    /**
     * @inheritDoc
     */
    function register(): void
    {
        //
    }
}