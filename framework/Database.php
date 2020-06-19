<?php


namespace Framework;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Framework\Contracts\DatabaseContract;

class Database implements DatabaseContract
{


    protected function initDoctrine()
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../app/Entities"), $isDevMode,
            $proxyDir, $cache, $useSimpleAnnotationReader);

        $conn = require config_path('database.php');

// obtaining the entity manager
        $entityManager = EntityManager::create($conn, $config);
    }
}