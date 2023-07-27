<?php


namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\CoreRegisterProvider;
use Jonathan13779\Framework\CoreProvider;
class CoreFactory{

    public static function create($coreClassHandler, array $middlewares = []): MiddlewareHandlerContract
    {        
        CoreProvider::register(new CoreRegisterProvider);
        $core = Container::build($coreClassHandler);
        call_user_func_array([$core, 'setMiddlewares'], $middlewares);
        return $core;
    }

}