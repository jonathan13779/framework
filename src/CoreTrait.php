<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;

trait CoreTrait{

    public static function singletons(array $singletons){
        Container::$singleton = array_merge(Container::$singleton, $singletons);
    }


    public static function definitions($definitions){
        Container::$definitions = array_merge(Container::$definitions, $definitions);
        
    }

    public static function register($class){
        $class::register();
    }

    public function handle($request)
    {
        return $this->handleMiddleware($request);
    }


}