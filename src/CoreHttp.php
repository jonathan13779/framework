<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\Modules\Middleware\MiddlewareHandlerTrait;
use Jonathan13779\Framework\Modules\Http\Router;
use Jonathan13779\Framework\Modules\Http\RouterHandler;
use Jonathan13779\Framework\Modules\Http\Request;
use Jonathan13779\Framework\Contracts\RouterInterface;
use Throwable;

class CoreHttp extends MiddlewareHandlerContract{
    use MiddlewareHandlerTrait;
    
    public function __construct(
        private RouterInterface $router
    )
    {        
    }


    public function handle($request)
    {
        return $this->handleMiddleware($request);
    }

    protected function execute($request)
    {
        $route = $this->router->match($request);
        if ($route){
            $routerHandler = new RouterHandler($route);
            call_user_func_array([$routerHandler, 'setMiddlewares'], $route->middlewares);
            return $routerHandler->handle($request);
        }
        return $route;
   
    }
}