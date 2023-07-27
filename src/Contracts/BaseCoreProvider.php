<?php

namespace Jonathan13779\Framework\Contracts;

abstract class BaseCoreProvider{
    public static $singletons = [];
    public static $definitions = [];
    abstract public static function register();
}