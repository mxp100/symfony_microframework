<?php


namespace Framework\Log;


use Exception;
use Monolog\Logger as MonologLogger;
use Psr\Log\LoggerInterface;

class Logger implements LoggerContract
{
    /** @var MonologLogger[] */
    protected static $channels;

    protected static $config;

    public function __construct($config)
    {
        self::$config = $config;

        foreach (self::$config['channels'] as $channel => $handlers) {
            self::$channels[$channel] = new MonologLogger($channel);
            foreach ($handlers as $handler) {
                self::$channels[$channel]->pushHandler($handler);
            }
        }
    }

    /**
     * Get channel logger
     *
     * @param $channel
     * @return MonologLogger
     * @throws Exception
     */
    public static function channel($channel): LoggerInterface
    {
        if (!isset(self::$channels[$channel])) {
            throw new Exception('channel "' . $channel . '" not found');
        }

        return self::$channels[$channel];
    }

    /**
     * Get default logger
     *
     * @return MonologLogger
     * @throws Exception
     */
    public static function default(): LoggerInterface
    {
        return self::channel(self::$config['default_channel']);
    }

    /**
     * Proxy to logger
     *
     * @param $name
     * @param $arguments
     * @return mixed
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        return self::default()->$name(...$arguments);
    }
}