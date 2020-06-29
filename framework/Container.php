<?php


namespace Framework;


use Closure;
use Framework\Contracts\ContainerContract;
use RuntimeException;

class Container implements ContainerContract
{

    protected $instances = [];

    /** @var static */
    protected static $instance;

    /**
     * @inheritDoc
     */
    public function instance(string $abstract, $instance, $force = false): object
    {
        if (!$force && $this->has($abstract)) {
            throw new RuntimeException('class "' . $abstract . '" already instantiate');
        }

        $this->instances[$abstract] = $instance;
        return $this->make($abstract);
    }

    /**
     * @inheritDoc
     */
    public function bind(string $abstract, $concrete, $force = false): void
    {
        if (!$force && $this->has($abstract)) {
            throw new RuntimeException('class "' . $abstract . '" already instantiate');
        }

        $this->instances[$abstract] = $concrete;
    }

    /**
     * @inheritDoc
     */
    public function make(string $abstract, array $parameters = [])
    {
        if (!$this->has($abstract)) {
            throw new RuntimeException($abstract . ' not found in container');
        }

        $instance = $this->instances[$abstract];
        if ($instance instanceof Closure) {
            $this->instances[$abstract] = $instance($this, ...$parameters);
        }
        if (is_string($instance) && class_exists($instance)) {
            $this->instances[$abstract] = new $instance(...$parameters);
        }

        return $this->instances[$abstract];
    }

    /**
     * @inheritDoc
     */
    public function has(string $abstract): bool
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