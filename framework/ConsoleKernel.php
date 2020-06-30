<?php


namespace Framework;

use App\Commands;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Framework\Contracts\ConsoleKernelContract;
use Framework\Contracts\DatabaseContract;

class ConsoleKernel implements ConsoleKernelContract
{
    /**
     * @var Application
     */
    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    /**
     * @inheritDoc
     */
    public function handle(): void
    {
        $this->application->bootstrap();

        /** @var DatabaseContract $database */
        $database = $this->application->make(DatabaseContract::class);

        $helperSet = ConsoleRunner::createHelperSet($database->getEntityManager());

        ConsoleRunner::run($helperSet, [
            new Commands\DoctrineFixturesLoadCommand(),
        ]);
    }
}