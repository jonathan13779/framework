<?php

namespace Jonathan13779\Framework\Modules\Http;

use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Modules\Middleware\MiddlewareHandlerTrait;
use Jonathan13779\Framework\Modules\Http\Response;

class RouterHandler extends MiddlewareHandlerContract{
    use MiddlewareHandlerTrait;

    public function __construct(
        private Route $route)
    {
    }

    public function handle($request)
    {
        return $this->handleMiddleware($request);
    }

    protected function execute($request)
    {
        $controller = Container::build($this->route->controller);
        return call_user_func_array([$controller, $this->route->method], $this->route->params);       
    }
}
