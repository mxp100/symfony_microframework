<?php


namespace Framework;


use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Configuration as DBALConfiguration;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Configuration as ORMConfiguration;
use Framework\Contracts\DatabaseContract;

class Database implements DatabaseContract
{
    /** @var array */
    protected $config;
    protected $connection;

    public function __construct()
    {
        $this->loadConfig();
        $this->initDBAL();
        $this->initORM();
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
        $ormConfig = new ORMConfiguration;
        $cache = new ArrayCache();
        $ormConfig->setQueryCacheImpl($cache);
        $ormConfig->setProxyDir(base_path('app/Entity'));
        $ormConfig->setProxyNamespace('EntityProxy');
        $ormConfig->setAutoGenerateProxyClasses(true);

//        AnnotationRegistry::
    }
}