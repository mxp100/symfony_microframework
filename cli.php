<?php


use Framework\Application;
use Framework\Contracts\ConsoleKernelContract;

require __DIR__ . '/vendor/autoload.php';

$app = new Application(__DIR__);

/** @var ConsoleKernelContract $kernel */
$kernel = $app->make(ConsoleKernelContract::class, [$app]);
$kernel->handle();
