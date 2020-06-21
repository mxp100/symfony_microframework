<?php


namespace Framework;


use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Configuration as DBALConfiguration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Framework\Contracts\DatabaseContract;

class Database implements DatabaseContract
{
    /** @var array */
    protected $config;
    /** @var Connection */
    protected $connection;
    /** @var EntityManager */
    protected $entityManager;

    public function __construct()
    {
        $this->loadConfig();
        $this->initDBAL();
        $this->initORM();
    }

    /**
     * @inheritDoc
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * Loading config file
     */
    protected function loadConfig()
    {
        $this->config = require config_path('database.php');
    }

    /**
     * Initialize DBAL
     * @throws DBALException
     */
    protected function initDBAL()
    {
        $dbalConfig = new DBALConfiguration();
        $this->connection = DriverManager::getConnection($this->config, $dbalConfig);
    }

    /**
     * Initialize ORM
     */
    protected function initORM()
    {
        $cache = new ArrayCache();

        $config = Setup::createAnnotationMetadataConfiguration(
            [app_path('Entity')],
            env('APP_DEBUG'),
            app_path('Entity'),
            $cache,
            false
        );

        $this->entityManager = EntityManager::create($this->config, $config);
    }

}