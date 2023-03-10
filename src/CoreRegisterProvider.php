<?php
namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Contracts\RouterInterface;
use Jonathan13779\Framework\Modules\Http\Router;

class CoreRegisterProvider{
    public static function register(){
        $singleton = [
            RouterInterface::class => Router::class
        ];
        Container::$singleton = Container::$singleton + $singleton;

    }
}