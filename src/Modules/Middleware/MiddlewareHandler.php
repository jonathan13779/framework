<?php
namespace Jonathan13779\Framework\Modules\Middleware;

use ZEngine\Module\Container;

class MiddlewareHandler{
    
    protected $middlewares = [];    
    protected $request;

    public function execute($middleware){
        
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
    }

    public function handle(){
	
        $middleware = array_shift($this->middlewares);
        
        return $this->execute($middleware);
       
    }
}