<?php


namespace Framework\Contracts;


use Symfony\Component\HttpFoundation\Response;
use Throwable;

interface ExceptionHandlerContract
{
    /**
     * Handle exceptions
     * @param Throwable $throwable
     * @return Response
     */
    public function handle(Throwable $throwable): Response;
}