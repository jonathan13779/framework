<?php
namespace Jonathan13779\Framework\Contracts;

use Jonathan13779\Framework\Modules\Container\Container;

abstract class MiddlewareHandlerContract{
    protected $middlewares = [];

    public function setMiddlewares(...$middlewares)
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
    }

    public function handleMiddleware($inputData)
    {
        $middleware = current($this->middlewares);
        next($this->middlewares);

        if ($middleware) {
            $middleware = Container::build($middleware);

            $result = $middleware->process($inputData, $this);

            return $result;
        }
        else{
            
            return $this->execute($inputData);
        }

    }

    abstract public function handle($inputData);
    abstract protected function execute($inputData);
}