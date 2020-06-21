<?php

use App\Commands;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Framework\Application;
use Framework\Contracts\DatabaseContract;

require __DIR__ . '/vendor/autoload.php';

$app = Application::load();

/** @var DatabaseContract $database */
$database = $app->make(DatabaseContract::class);

$helperSet = ConsoleRunner::createHelperSet($database->getEntityManager());

ConsoleRunner::run($helperSet, [
    new Commands\DoctrineFixturesLoadCommand(),
]);