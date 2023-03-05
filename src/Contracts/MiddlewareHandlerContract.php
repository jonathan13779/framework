<?php
namespace Jonathan13779\Framework\Contracts;

abstract class MiddlewareHandlerContract{
    protected $middlewares = [];

    public function setMiddlewares(...$middlewares)
    {
        $this->middlewares = array_merge($this->middlewares, $middlewares);
    }

    abstract public function handle($inputData);
    abstract protected function execute($inputData);
}