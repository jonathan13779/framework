<?php
namespace Jonathan13779\Framework\Modules\Middleware;

use Jonathan13779\Framework\Modules\Container\Container;

trait MiddlewareHandlerTrait{
    

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

}