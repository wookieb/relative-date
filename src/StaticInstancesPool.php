<?php

namespace Wookieb\RelativeDate;


class StaticInstancesPool
{

    protected static function getInstance($name)
    {
        if (isset(static::$instances[$name])) {
            return static::$instances[$name];
        }
    }

    protected static function setInstance($name, $instance)
    {
        static::$instances[$name] = $instance;
    }

    protected static function getOrCreate($name, \Closure $factory)
    {
        $instance = self::getInstance($name);
        if (!$instance) {
            $instance = $factory();
            static::setInstance($name, $instance);
        }
        return $instance;
    }

}