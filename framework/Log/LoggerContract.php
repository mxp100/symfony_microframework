<?php


namespace Framework\Log;


use Psr\Log\LoggerInterface;

interface LoggerContract
{
    /**
     * Get channel
     *
     * @param $channel
     * @return LoggerInterface
     */
    public static function channel($channel): LoggerInterface;

    /**
     * Get default channel
     *
     * @return LoggerInterface
     */
    public static function default(): LoggerInterface;
}