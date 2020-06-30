<?php


namespace Framework\Log;


use Framework\AbstractServiceProvider;
use Framework\Application;

class ServiceProvider extends AbstractServiceProvider
{

    /**
     * @inheritDoc
     */
    function register(): void
    {
        $this->application->instance(LoggerContract::class, function (Application $application) {
            return new Logger(require $application->configPath('logger.php'));
        });
    }
}