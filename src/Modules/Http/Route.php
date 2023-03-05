<?php

namespace Jonathan13779\Framework\Modules\Http;

class Route{
	public $method = '__invoke';
	public $controller = '';
	public $params = [];
	public $middlewares = [];
	public $conf = [];

	public function __get($param){
		return $this->$param;
	}
	
	public function __construct(Array $data){
		$parseController = explode('@',$data['controller']);
		$this->controller = $parseController[0];
		if (array_key_exists(1,$parseController))
			$this->method = $parseController[1];
		$this->middlewares = $data['middleware'];
		$this->conf = $data['conf'];
		//$this->middlewares[] = self::class;
		if($data['params'])
		$this->params = $data['params'];
		
	}
	
}

?>