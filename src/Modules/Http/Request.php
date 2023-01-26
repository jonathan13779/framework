<?php

namespace Jonathan13779\Framework\Modules\Http;

use Jonathan13779\Framework\Modules\Http\Server;

class Request{
	private $server;
	public $route;

	public function __construct(Server $server)
	{
		//print_r($_SERVER);
		$this->server = $server;	
	}

	public function __set($param,$value){
		$this->$param = $value;
		$_REQUEST[$param] = $value;
	}
	
	public function __get($param){
		if (array_key_exists($param,$_REQUEST)){
			return $_REQUEST[$param];
		}
		return false;
	}
	
	public function isAjax(){
		
        if ($this->server->get('HTTP_X_REQUESTED_WITH') == 'XMLHttpRequest') {
            return true;
        }	
		return false;
	}
	
	public function getUri(){
		$uri = explode('?',$this->server->get('REQUEST_URI'))[0];
		if(!$uri)
			$uri = '/';
		return $uri;
	}

	public function getMethod(){		
		$method = $this->server->get('REQUEST_METHOD');
		if (!$method)
			$method = 'GET';
		return $method;
	}
	public function getContentType(){
		return $this->server->get('CONTENT_TYPE');
	}

	public function getHeader($header){
		return $this->server->get($header);
	}
}