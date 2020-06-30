<?php


namespace Framework\Exception;



use Framework\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
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