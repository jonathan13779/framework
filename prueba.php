<?php

require __DIR__.'/vendor/autoload.php';

use Jonathan13779\Framework\CoreFactory;
use Jonathan13779\Framework\CoreHttp;
use Jonathan13779\Framework\Modules\Http\Request;
use Jonathan13779\Framework\Modules\Http\Router;
$_SERVER['REQUEST_URI'] = '/api/administracion/facturacion';
//$_SERVER['REQUEST_URI'] = '/cliente/5/grupo/8';

//Router::get('/api/contabilidad/clientes','controller');  

class Test{
    public function process($input , $handler)
    {
        $res = $handler->handle($input);
        return $res;
    }
}

class Test2{
    public function process($input , $handler)
    {
        $res = $handler->handle($input);
        return $res;
    }
}


class Test3{
    public function process($input , $handler)
    {
        $res = $handler->handle($input);
        return $res;
    }
}



Router::group('/api', function(){
    
    Router::group('/administracion', function(){
        Router::get('/clientes','controller');
    });
    
    
    //Router::get('/clientesfes','controller');
    
},[Test::class]);

Router::group('/api/administracion', function(){
    Router::get('/facturacion','controller',[Test3::class]);
},[Test2::class]);


Router::get('/cliente/:id/grupo/:grupo','controller');


$core = CoreFactory::create(CoreHttp::class, [
    Test::class
]);

$res = $core->handle(new Request);
//echo Router::obtenerRutaStorage()."\n";
var_dump($res);
