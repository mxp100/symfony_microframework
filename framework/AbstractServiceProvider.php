<?php


namespace Framework;


abstract class AbstractServiceProvider
{
    /**
     * Register bindings
     *
     * @example AppContract::class => App::class
     * @var array
     */
    public $bindings = [];

    /**
     * Register singletons
     *
     * @example AppContract::class => App::class
     * @var array
     */
    public $singletons = [];

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