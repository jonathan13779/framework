<?php

namespace Jonathan13779\Framework;

use Jonathan13779\Framework\Contracts\MiddlewareHandlerContract;
use Jonathan13779\Framework\Modules\Middleware\MiddlewareHandlerTrait;
use Jonathan13779\Framework\Modules\Http\Router;
use Jonathan13779\Framework\Modules\Http\RouterHandler;
use Jonathan13779\Framework\Modules\Http\Request;
use Jonathan13779\Framework\Contracts\RouterInterface;
use Jonathan13779\Framework\Modules\Http\Response;
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
        $response = $this->handleMiddleware($request);        
        return $response;        
    }


    protected function execute($request)
    {
        $route = $this->router->match($request);
        if ($route){
            $routerHandler = new RouterHandler($route);
            call_user_func_array([$routerHandler, 'setMiddlewares'], $route->middlewares);
            $response = $routerHandler->handle($request);
        }

        $this->send($response);            
        return $response;
     
    }

    private function send(Response $response){
        http_response_code($response->status);

        if ($response->viewName){
            $response->view();
            return $response;
        }
        
		header('Content-Type: application/json');
		echo json_encode($this->data);				
		
        session_write_close();
		if (function_exists('fastcgi_finish_request'))
		fastcgi_finish_request();
    
    }

}