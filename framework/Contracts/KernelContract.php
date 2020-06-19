<?php

namespace Framework\Contracts;

use Symfony\Component\HttpFoundation\Response;

interface KernelContract
{
    public function handle(RequestContract $request = null):Response;
}