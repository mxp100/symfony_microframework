<?php


namespace Framework\Services;


use Exception;
use Framework\Contracts\LoggerContract;
use Monolog\Logger as MonologLogger;

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
    public static function channel($channel): MonologLogger
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
    public static function default(): MonologLogger
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