<?php


namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;

class CoreFactory{

    public static function create(string $coreClassHandler){
        $core = Container::build($coreClassHandler);
        return $core;
    }

}