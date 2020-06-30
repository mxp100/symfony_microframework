<?php


namespace App\Entity;


use Framework\Application;
use Framework\Database\DatabaseContract;
use JsonSerializable;

abstract class BaseEntity implements JsonSerializable
{
    private static $serializer;

    public function jsonSerialize()
    {
        if (!self::$serializer) {
            /** @var DatabaseContract $database */
            $database = Application::getInstance()->make(DatabaseContract::class);

            self::$serializer = $database->getSerializer();
        }

        return self::$serializer->normalize($this);
    }
}