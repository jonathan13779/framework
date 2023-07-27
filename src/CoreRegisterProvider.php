<?php
namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Contracts\RouterInterface;
use Jonathan13779\Framework\Modules\Http\Router;
use Jonathan13779\Framework\Contracts\BaseCoreProvider;

class CoreRegisterProvider extends BaseCoreProvider{

    public static $singletons = [
        RouterInterface::class => Router::class
    ];

    public static function register(){

    }
}