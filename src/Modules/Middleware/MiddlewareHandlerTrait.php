<?php
namespace Jonathan13779\Framework\Modules\Middleware;

use Jonathan13779\Framework\Modules\Container\Container;

trait MiddlewareHandlerTrait{
    

    public function handle($inputData)
    {
        $middleware = current($this->middlewares);
        next($this->middlewares);

        if ($middleware) {
            $middleware = Container::build($middleware);

            $response = $middleware->process($inputData, $this);

            return $response;
        }
        else{
            return $this->execute($inputData);
        }

        return $result;
    }

}