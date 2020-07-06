<?php


namespace Framework\Helpers;


class Arr
{
    public static function except($array, $excepts): array
    {
        return array_diff_key($array, array_flip((array) $excepts));
    }
}