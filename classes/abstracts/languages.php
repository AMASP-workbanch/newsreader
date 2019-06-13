<?php


namespace newsreader\abstracts;

abstract class languages
{
    public static function getConstants()
    {
        // "static::class" here does the magic
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }
}