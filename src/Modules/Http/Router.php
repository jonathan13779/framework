<?php

namespace Jonathan13779\Framework\Modules\Http;

use Jonathan13779\Framework\Modules\Http\Route;

class Router{
    private static $prefix = '';
	private static $middlewares = [];
	private static $routes = [
		'GET'=>[],
		'POST'=>[],
		'PUT'=>[],
		'DELETE'=>[]
	];

    private static $groups = [];


	public static function reset(){
		self::$routes = [
			'GET'=>[],
			'POST'=>[],
			'PUT'=>[],
			'DELETE'=>[]
		];	
        self::$groups = [];	
	}    

    public static function group($route, $callable, $middlewares = []){
        $route = self::$prefix.$route;
        //self::$groups[$ruta] = new Group($ruta, $callable, $middlewares);
		self::$groups[] =[
			'route'=>$route,
			'callback'=>$callable,
			'middleware'=>$middlewares
		];

    }
    
    public static function get($route, $controller, $middleware=[], $config = [] ){
		self::registerRoute('GET', $route, $controller, $middleware, $config);
	}

	private static function registerRoute(String $method, $route, $controller, $middleware=[], $config = [] ){
		/*if (self::$matchedGroup){
			$group = self::$matchedGroup;
			$route = $group['route'].$route;
			$middleware = array_merge($group['middleware'],$middleware);
		}*/
		
		self::$routes[$method][] = [
			'route'=> self::$prefix . $route,
			'controller' => $controller,
			'middleware' => array_merge(self::$middlewares, $middleware),
			'conf' => $config,
		];
	}



    public static function match(Request $request){
        $uri =  $request->getUri();
        $method = $request->getMethod();
        $groups = self::$groups;
        $routes = self::$routes[$method];
		
        foreach($groups as $group){
            self::getRule($group);
            $rule = $group['rule'];
            
			if ( preg_match('/' . $rule .'/', $uri, $matches)){
                self::$prefix =  $group['route'];
				$middlewares = self::$middlewares;
				self::$middlewares = array_merge(self::$middlewares, $group['middleware']);
                self::reset();
                $group['callback']();
                $result = self::match($request);
                if($result){
                    return $result;
                }
				else{
					self::$middlewares = $middlewares;
				}
                
            }
        }
		
		foreach($routes as $route){
			self::getRule($route);
			$rule = $route['rule'];
			if ( preg_match('/^' . $rule .'$/', $uri, $matches)){
				if ($route['params'])
				$route['params'] = (array_intersect_key($matches,$route['params']));
				
				return  new Route($route);
			}
		}		

        return false;

    }

	private static function getRule(&$routeArr){
		$route = $routeArr['route'];
		$routeParams = self::getRouteParams($route);
		$rule = self::getRouteParamRule($route,$routeParams);
		$routeArr['rule'] = $rule;
		$routeArr['params'] = $routeParams;
	}

	public static function getRouteParams($route){
		$params = [];
		$result = preg_match_all('/:([a-z]+)+/', $route , $params);
		if ($result){
			$params = $params[1];
			$fields = array_splice($params,0);
			//$fileds = array_flip($fields);
			$fields = array_fill_keys($fields, '');
			//exit;

			return $fields;
		}
			 
		return false;
	}

	public static function getRouteParamRule($route,$routeParams){
		if ($routeParams)
			$route = preg_replace('/:([a-z]+)/', '(?P<\1>[^/]+)', $route);
		$route = str_replace('/', '\/', $route);
		return $route;
	}

}