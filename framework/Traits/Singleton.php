<?php


namespace Framework\Traits;

/**
 * Realize pattern singleton
 *
 * Trait Singleton
 * @package Framework\Traits
 */
trait Singleton
{
    protected static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    protected function __wakeup()
    {
    }
}