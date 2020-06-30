<?php

ini_set('display_errors', 'on');

use App\Http\Middleware\RequestJsonMiddleware;
use Framework\Application;
use Framework\HttpKernel\HttpKernelContract;
use Framework\Request\Request;
use Framework\Request\RequestContract;

require __DIR__ . '/../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

/** @var HttpKernelContract $kernel */
$kernel = $app->make(HttpKernelContract::class, [$app]);
$kernel->pushMiddleware(new RequestJsonMiddleware());

/** @var Request $request */
$request = $app->instance(RequestContract::class, Request::createFromGlobals());

$response = $kernel->handle($request);
$response->send();

$app->terminate($request, $response);