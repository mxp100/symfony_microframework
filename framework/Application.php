<?php


namespace Framework;


use Framework\Contracts\ContainerContract;
use Framework\Contracts\DatabaseContract;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Traits\Singleton;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Application
 *
 * @property Router $router
 * @property Request $request
 * @package Framework\
 */
class Application extends Container
{
    use Singleton;

    public $basePath;
    public $configPath;
    public $storagePath;

    protected function __construct()
    {
        $this->registerPaths();
        $this->registerBindings();
    }

    protected function registerPaths(): void
    {
        $this->basePath = __DIR__ . '/../';
        $this->configPath = $this->basePath . 'config/';
        $this->storagePath = $this->basePath . 'storage/';
    }

    protected function registerBindings(): void
    {
        $this->instance(ContainerContract::class, $this);
        $this->instance(ExceptionHandlerContract::class, new ExceptionHandler());
        $this->instance(DatabaseContract::class, new Database());
    }

}