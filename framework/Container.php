<?php


namespace Framework;


use Closure;
use Framework\Contracts\ContainerContract;
use RuntimeException;

class Container implements ContainerContract
{

    protected $instances;

    protected static $instance;

    /**
     * Get class instance
     *
     * @param $abstract
     * @param Closure|mixed $instance
     * @param bool $override
     * @return mixed
     */
    public function instance($abstract, $instance, $override = false)
    {
        if (!$override && $this->has($abstract)) {
            throw new RuntimeException('class already instantiate');
        }

        if ($instance instanceof Closure){
            $instance = $instance->call($this);
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
        if (!$this->has($abstract)) {
            throw new RuntimeException($abstract . ' not found in container');
        }

        return $this->instances[$abstract];
    }

    public function has($abstract)
    {
        return isset($this->instances[$abstract]);
    }

    /**
     * Set shared container
     *
     * @param ContainerContract $container
     * @return ContainerContract
     */
    public static function setInstance(ContainerContract $container)
    {
        return static::$instance = $container;
    }

    /**
     * Get shared container
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

}