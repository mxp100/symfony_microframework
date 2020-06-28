<?php


namespace Framework;


use Framework\Cached\ServiceContainer;
use Framework\Contracts\ContainerContract;
use Framework\Contracts\DatabaseContract;
use Framework\Contracts\EnvironmentContract;
use Framework\Contracts\LoggerContract;
use Framework\Contracts\ViewContract;
use Framework\Traits\Singleton;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Application
 *
 * @property Router $router
 * @property Request $request
 * @package Framework\
 */
class Application
{
    use Singleton;

    public $basePath;
    public $configPath;
    public $storagePath;
    public $resourcePath;
    public $applicationPath;

    /** @var ServiceContainer */
    protected $container;

    public function __construct()
    {
        $this->registerPaths();
        $this->registerServices();
    }

    /**
     * Return container
     * @return ServiceContainer
     */
    public function getContainer(): ServiceContainer
    {
        return $this->container;
    }

    protected function registerPaths(): void
    {
        $this->basePath = __DIR__ . '/../';
        $this->configPath = $this->basePath . 'config/';
        $this->storagePath = $this->basePath . 'storage/';
        $this->resourcePath = $this->basePath . 'resources/';
        $this->applicationPath = $this->basePath . 'app/';
    }

    protected function registerServices(): void
    {
        $cachedContainerFile = $this->storagePath . 'cache/app/container.php';
        $containerConfigCache = new ConfigCache($cachedContainerFile, true);
        if (!$containerConfigCache->isFresh() || 1) {
            $containerBuilder = new ContainerBuilder();
            $containerBuilder->setParameter('path.base', $this->basePath);
            $containerBuilder->setParameter('path.config', $this->configPath);
            $containerBuilder->setParameter('path.storage', $this->storagePath);
            $containerBuilder->setParameter('path.resource', $this->resourcePath);
            $containerBuilder->setParameter('path.app', $this->applicationPath);
            $loader = new PhpFileLoader($containerBuilder, new FileLocator($this->configPath));
            $loader->load('services.php');
            $containerBuilder->compile();

            $dumper = new PhpDumper($containerBuilder);
            $containerConfigCache->write(
                $dumper->dump([
                    'class' => 'ServiceContainer',
                    'namespace' => __NAMESPACE__ . '\Cached'
                ]),
                $containerBuilder->getResources()
            );
        }
        require_once $cachedContainerFile;
        $this->container = new Cached\ServiceContainer();
    }

}