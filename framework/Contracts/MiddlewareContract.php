<?php


namespace Framework\Contracts;


interface MiddlewareContract
{
    /**
     * Middleware handler
     * @param RequestContract $request
     */
    public function handle(RequestContract $request): void;
}