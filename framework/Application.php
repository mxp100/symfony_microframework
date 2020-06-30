<?php


namespace Framework;


use Framework\Contracts\ConsoleKernelContract;
use Framework\Contracts\ExceptionHandlerContract;
use Framework\Contracts\HttpKernelContract;
use Framework\Contracts\RequestContract;
use Framework\ServiceProviders\EnvServiceProvider;
use Framework\ServiceProviders\LogServiceProvider;
use Framework\ServiceProviders\RoutingServiceProvider;
use Framework\ServiceProviders\ServiceProvider;
use Framework\Services\ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Application
 *
 * @package Framework\
 */
class Application extends Container
{

    protected $basePath;

    protected $booted = false;

    protected $serviceProviders = [];

    protected $config;

    public function __construct($basePath)
    {
        $this->setBasePath($basePath);

        $this->loadConfig();

        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
    }

    /**
     * Set base paths of application
     *
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');
    }

    /**
     * Load application config
     */
    public function loadConfig()
    {
        $this->config = require $this->configPath('app.php');
    }

    /**
     * Register base bindings
     */
    protected function registerBaseBindings()
    {
        static::setInstance($this);
        $this->bind(Container::class, $this);

        $this->bind(HttpKernelContract::class, HttpKernel::class);
        $this->bind(ConsoleKernelContract::class, ConsoleKernel::class);
        $this->bind(ExceptionHandlerContract::class, ExceptionHandler::class);
    }

    /**
     * Register base service providers
     */
    protected function registerBaseServiceProviders(): void
    {
        $this->register(EnvServiceProvider::class);
        $this->register(LogServiceProvider::class);
        $this->register(RoutingServiceProvider::class);
    }

    /**
     * Register service providers
     *
     * @param ServiceProvider|string $serviceProvider Instance or classname of service provider
     * @param bool $force Force register
     * @return ServiceProvider
     */
    public function register($serviceProvider, $force = false): ServiceProvider
    {
        if (($registered = $this->getServiceProvider($serviceProvider)) && !$force) {
            return $registered;
        }

        if (is_string($serviceProvider)) {
            $serviceProvider = $this->resolveProvider($serviceProvider);
        }

        $serviceProvider->register();

        if (property_exists($serviceProvider, 'bindings')) {
            foreach ($serviceProvider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }

        $this->serviceProviders[] = $serviceProvider;

        if ($this->isBooted()) {
            $this->bootServiceProvider($serviceProvider);
        }

        return $serviceProvider;
    }

    /**
     * Bootstrap application
     */
    public function bootstrap(): void
    {
        $providers = $this->config['providers'] ?? [];
        foreach ($providers as $provider) {
            $this->register($provider);
        }

        $this->boot();
    }

    /**
     * Boot application service providers
     */
    public function boot(): void
    {
        if ($this->isBooted()) {
            return;
        }

        foreach ($this->serviceProviders as $serviceProvider) {
            $this->bootServiceProvider($serviceProvider);
        }
        $this->booted = true;
    }

    public function terminate(
        RequestContract $request,
        Response $response
    ) {
        foreach ($this->serviceProviders as $serviceProvider) {
            if (method_exists($serviceProvider, 'terminate')) {
                $serviceProvider->terminate($request, $response);
            }
        }
    }

    public function isConsole()
    {
        return PHP_SAPI === 'cli';
    }

    /**
     * Boot service provider
     *
     * @param ServiceProvider $serviceProvider
     */
    protected function bootServiceProvider(ServiceProvider $serviceProvider): void
    {
        if (method_exists($serviceProvider, 'boot')) {
            $serviceProvider->boot();
        }
    }

    /**
     * Get registered service provider
     *
     * @param ServiceProvider|string $serviceProvider
     * @return ServiceProvider|null
     */
    public function getServiceProvider($serviceProvider): ?ServiceProvider
    {
        $className = is_string($serviceProvider) ? $serviceProvider : get_class($serviceProvider);
        foreach ($this->serviceProviders as $value) {
            if ($value instanceof $className) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Application is booted?
     *
     * @return bool
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * Resolve service provider
     *
     * @param string $provider
     * @return ServiceProvider
     */
    public function resolveProvider(string $provider): ServiceProvider
    {
        return new $provider($this);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path
     * @return string
     */
    public function path($path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'app' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @param string $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = ''): string
    {
        return $this->basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the public / web directory.
     *
     * @param string $path
     * @return string
     */
    public function publicPath(string $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the storage directory.
     *
     * @param string $path
     * @return string
     */
    public function storagePath(string $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'storage' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string $path
     * @return string
     */
    public function resourcePath(string $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'resources' . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }


}