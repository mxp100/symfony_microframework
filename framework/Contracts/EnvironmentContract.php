<?php


namespace Framework\Contracts;


interface EnvironmentContract
{
    /**
     * Gets the value of an environment variable.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null);
}