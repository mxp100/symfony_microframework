<?php


namespace Framework\Contracts;


use Framework\Request;

interface MiddlewareContract
{
    /**
     * Middleware handler
     * @param Request $request
     */
    public function handle(Request $request): void;
}