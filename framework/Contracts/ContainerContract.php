<?php


namespace Framework\Contracts;


use Closure;

interface ContainerContract
{
    /**
     * Get class instance
     *
     * @param string $abstract
     * @param Closure|object $instance
     * @param bool $force
     * @return object
     */
    public function instance(string $abstract, $instance, $force = false): object;

    /**
     * Get class instance
     *
     * @param string $abstract
     * @param Closure|string $instance
     * @param bool $force
     */
    public function bind(string $abstract, $instance, $force = false);

    /**
     * Get instance via contract
     *
     * @param string $abstract
     * @param array $parameters
     * @return object|string
     */
    public function make(string $abstract, array $parameters = []);

    /**
     * Check exists instance in container
     *
     * @param string $abstract
     * @return bool
     */
    public function has(string $abstract): bool;
}