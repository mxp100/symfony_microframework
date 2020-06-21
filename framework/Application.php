<?php


namespace Framework;


use Framework\Contracts\ContainerContract;
use Framework\Contracts\DatabaseContract;
use Framework\Contracts\EnvironmentContract;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\ViewContract;
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
    public $resourcePath;
    public $applicationPath;

    protected function __construct()
    {
        $this->registerPaths();
    }

    public static function load()
    {
        $app = self::getInstance();
        $app->registerBindings();
        return $app;
    }

    protected function registerPaths(): void
    {
        $this->basePath = __DIR__ . '/../';
        $this->configPath = $this->basePath . 'config/';
        $this->storagePath = $this->basePath . 'storage/';
        $this->resourcePath = $this->basePath . 'resources/';
        $this->applicationPath = $this->basePath . 'app/';
    }

    protected function registerBindings(): void
    {
        $this->instance(ContainerContract::class, $this);
        $this->instance(ExceptionHandlerContract::class, new ExceptionHandler());
        $this->instance(EnvironmentContract::class, new Environment());
        $this->instance(DatabaseContract::class, new Database());
        $this->instance(ViewContract::class, new View());
    }

}