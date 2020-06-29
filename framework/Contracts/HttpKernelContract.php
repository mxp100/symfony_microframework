<?php

namespace Framework\Contracts;

use Framework\Request;
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
     * @param MiddlewareContract $middleware
     * @return static
     */
    public function pushMiddleware(MiddlewareContract $middleware);
}