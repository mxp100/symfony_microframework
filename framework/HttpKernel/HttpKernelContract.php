<?php

namespace Framework\HttpKernel;

use Framework\Request\Request;
use Symfony\Component\HttpFoundation\Response;

interface HttpKernelContract
{
    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response;

    /**
     * Add middleware
     *
     * @param string $middleware classFQN with implemented MiddlewareContract
     * @return static
     */
    public function pushMiddleware(string $middleware);

    /**
     * Register middleware
     *
     * @param string $middleware classFQN with implemented MiddlewareContract
     * @param string|null $alias short alias for using in routes
     * @return mixed
     */
    public function registerMiddleware(string $middleware, ?string $alias = null);
}