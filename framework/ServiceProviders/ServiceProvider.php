<?php


namespace Framework\ServiceProviders;


use Framework\Application;

abstract class ServiceProvider
{
    /**
     * Register bindings
     *
     * @var array
     */
    public $bindings = [];

    protected $application;

    final public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * Register provider
     * @return void
     */
    abstract function register(): void;

    /**
     * Booting service provider
     */
    public function boot(): void
    {

    }
}