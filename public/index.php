<?php

ini_set('display_errors', 'on');

use App\Http\Middleware\RequestJsonMiddleware;
use Framework\Application;
use Framework\Contracts\KernelContract;
use Framework\HttpKernel;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));
$app->



/** @var HttpKernel $kernel */
$kernel = $app->instance(KernelContract::class, new HttpKernel($app));
$kernel->pushMiddleware(new RequestJsonMiddleware());

$response = $kernel->handle();
$response->send();