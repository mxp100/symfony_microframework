<?php


namespace Framework\Contracts;

use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Interface RequestContract
 * @property InputBag|ParameterBag $request
 * @package Framework\Contracts
 */
interface RequestContract
{
    /**
     * Current request is json type
     * @return bool
     */
    public function isJson(): bool;

    /**
     * Get content from request
     * @param bool $asResource
     * @return mixed
     */
    public function getContent(bool $asResource = false);
}