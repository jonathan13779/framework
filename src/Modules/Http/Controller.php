<?php
namespace Jonathan13779\Framework\Modules\Http;

use Jonathan13779\Framework\Modules\Http\Response;

class Controller{

	protected ?string $viewName = null;
	protected array $data = [];
	protected ?string $file = null;

	public function __call($name, $arguments)
	{
		if (property_exists($this, $name)){
		
			return call_user_func_array([$this->$name,'__invoke'],$arguments);
			
		}
	}
	
	public function viewTo($viewName = '', $params = []){
		$this->data = array_merge($this->data, $params);
		$this->viewName = $viewName;
	}
	
	public function view(){
		if($this->viewName!=''){
			extract($this->data);
			require '../app/View/'.$this->viewName.'.php';
		}

	}

	public function getData(){
		return $this->data;
	}

    public function getViewName(){
		return $this->viewName;
	}

	public function getFile(){
		return $this->file;
	}

	protected function responseFile($file, $status = 200): Response
	{
		$response = new Response;
		$response->file = $file;
		return $response;
	}

	protected function responseView($viewName, $data=[], $status = 200): Response
	{
		$response = new Response;
		$response->viewName = $viewName;
		$response->data = $data;
		return $response;		
	}

	protected function responseJSON($data, $status = 200): Response
	{
		$response = new Response;
		$response->data = $data;
		return $response;		
	}
	


}

?>