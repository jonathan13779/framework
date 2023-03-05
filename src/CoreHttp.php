<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\Modules\Middleware\MiddlewareHandlerTrait;
use Jonathan13779\Framework\Modules\Http\Router;
use Jonathan13779\Framework\Modules\Http\Request;
use Throwable;

class CoreHttp extends MiddlewareHandlerContract{
    use MiddlewareHandlerTrait;
    private Request $request;

    protected function execute($request)
    {
        $this->request = $request;
        $route = Router::match($request);
        return $route;
    
    }
}