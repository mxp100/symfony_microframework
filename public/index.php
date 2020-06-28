<?php

ini_set('display_errors', 'on');

use App\Http\Middleware\RequestJsonMiddleware;
use Framework\Application;
use Framework\Contracts\KernelContract;
use Framework\HttpKernel;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application;

$kernel = new HttpKernel($app);
$app->getContainer()->set('http.kernel', $kernel);

$kernel->pushMiddleware(new RequestJsonMiddleware());

$response = $kernel->handle();
$response->send();