<?php


namespace Framework\Validator;


use Framework\AbstractServiceProvider;

class ServiceProvider extends AbstractServiceProvider
{

    public $singletons = [
        ValidatorContract::class => Validator::class,
    ];

    /**
     * @inheritDoc
     */
    function register(): void
    {
        // TODO: Implement register() method.
    }
}