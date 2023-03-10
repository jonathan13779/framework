<?php
namespace Jonathan13779\Framework\Modules\Http;

class Response{
	
	public $request;
	public ?string $viewName = null;
	public $data = [];
	private $status = 200;
	private $controller = false;
	public $headers = [];
	public $file = false;


	public function __get($property){
		return $this->$property;
	}
	
	public function __set($property, $value){
		$this->$property = $value;
	}
	
	public function setController($controller){
		$this->controller = $controller;
	}	

	public function setHeader($header,$value){
		$this->headers[$header] = $value;
	}

	public function sendHeaders(){
		foreach($this->headers as $key=>$value){
			header($key.': '.$value);
			
		}
	}

	public function getHeader($key){
		if (isset($this->headers[$key]))
			return $this->headers[$key];
		return false;
	}

	public function view(){
		if($this->viewName!=''){
			$root = $this->getPathRoot();
			extract($this->data);
			require $root.'/'.$this->viewName;
		}

	}

	private function getPathRoot(){
		//return $root_path = dirname(__DIR__);
		$path = __DIR__;

		$pos = strpos($path, '/vendor/');
		if ($pos!==false){
			return substr($path,0, $pos);
		}

		$pos = strpos($path, '/src/');
		if ($pos!==false){
			return substr($path,0, $pos);
		}

		$pos = strpos($path, '/public/');
		if ($pos!==false){
			return substr($path,0, $pos);
		}

		$pos = strpos($path, '/app/');
		if ($pos!==false){
			return substr($path,0, $pos);
		}

		

		

		return $root_path = realpath(__DIR__ );
		return $_SERVER['DOCUMENT_ROOT'];
        $rutaFachada = realpath(__DIR__);
        $rutaRaiz = dirname(dirname(dirname($rutaFachada)));
		return $rutaRaiz;
	}

	private function sendFile(){
		$file = $this->file;
		$fileName = explode('/',$file);
		$fileName = end($fileName);

		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Transfer-Encoding: binary");
		header("Content-Type: binary/octet-stream");
		header("Content-Disposition: attachment; filename=" . $fileName);
		header('Pragma: no-cache');
		header("Content-length: " . filesize($file));

		return readfile($file);		
	}

	
}
?>