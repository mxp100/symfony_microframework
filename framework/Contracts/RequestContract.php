<?php


namespace Framework\Contracts;

/**
 * Interface RequestContract
 * @package Framework\Contracts
 */
interface RequestContract
{
    /**
     * Current request is json type
     * @return bool
     */
    public function isJson(): bool;

}