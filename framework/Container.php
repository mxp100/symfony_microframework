<?php


namespace Framework;


use Framework\Contracts\ContainerContract;
use RuntimeException;

class Container implements ContainerContract
{

    protected $instances;

    /**
     * Get class instance
     *
     * @param $abstract
     * @param $instance
     * @param bool $override
     * @return mixed
     */
    public function instance($abstract, $instance, $override = false)
    {
        if (!($instance instanceof $abstract)) {
            throw new RuntimeException('class not implement contract');
        }
        if (!$override && isset($this->instances[$abstract])) {
            throw new RuntimeException('class already instantiate');
        }

        $this->instances[$abstract] = $instance;

        return $this->instances[$abstract];
    }

    /**
     * Get instance via contract
     *
     * @param $abstract
     * @return mixed
     */
    public function make($abstract)
    {
        if (!isset($this->instances[$abstract])) {
            throw new RuntimeException('class not found');
        }

        return $this->instances[$abstract];
    }

}