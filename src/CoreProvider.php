<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Contracts\BaseCoreProvider;

class CoreProvider{

    public static function singletons(array $singletons){
        Container::$singleton = array_merge(Container::$singleton, $singletons);
    }


    public static function definitions($definitions){
        Container::$definitions = array_merge(Container::$definitions, $definitions);
        
    }

    public static function register(BaseCoreProvider $provider){
        $provider::register();
        self::singletons($provider::$singletons);
        self::definitions($provider::$definitions);
    }
}