<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Modules\Middleware\MiddlewareHandler;
use Jonathan13779\Framework\Modules\Container\Container;
use Jonathan13779\Framework\Modules\Http\Request;
use Throwable;

class CoreHttp extends MiddlewareHandler{

    private $handler;

    public function __construct(
        Request $request,

    )
    {
        $this->request = $request;
    }

   public function process(Request $request){
        try{

        }
        catch(Throwable $err){
            
        }

        echo 'dsdsd';
        var_dump($request);
    }
}