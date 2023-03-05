<?php
namespace Jonathan13779\Framework\Modules\Middleware;

use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\Modules\Container\Container;

class MiddlewareHandler extends MiddlewareHandlerContract{
    

    public function handle($inputData)
    {
        $middleware = current($this->middlewares);
        next($this->middlewares);
        $result = $this->execute($inputData, $middleware);
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

    protected function execute($inputData)
    {
        return null;
    }


/*    public function execute($middleware){
        
        if($middleware && class_exists($middleware)){
            $object = Container::build($middleware);
            if (is_callable( $object)){
                return $object();
            }
            else{
                //if ($middleware=='ZEngine\Core')
				$response = $object->process($this->request,$this);
				
                return $response;
            }
        }
        else{
            return $this->process($this->request,$this);
            //return $this->response;
        }
    }*/

}