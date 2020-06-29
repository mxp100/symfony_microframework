<?php


namespace Framework\ServiceProviders;


use Framework\Application;
use Framework\Contracts\LoggerContract;
use Framework\Services\Logger;

class LogServiceProvider extends ServiceProvider
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