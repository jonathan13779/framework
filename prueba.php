<?php

require __DIR__.'/vendor/autoload.php';

use Jonathan13779\Framework\Contracts\RouterInterface;
use Jonathan13779\Framework\CoreFactory;
use Jonathan13779\Framework\CoreHttp;
use Jonathan13779\Framework\Modules\Http\Request;
use Jonathan13779\Framework\Modules\Http\Router;

use Jonathan13779\Framework\Modules\Container\Container;


class tres{

}

class cuatro{
    
}

class dos{
    function __construct(
        public tres $tres
    )
    {
        echo "dos\n";        
    }
}

class uno extends dos {

    public function __construct(
        cuatro $cuatro
    )
    {
        echo "uno\n";
    }

}

/*
Container::build(uno::class);


interface RouterInterface{

}

class RouterModule implements RouterInterface{

}

Container::$singleton[RouterInterface::class] = function (){
    return new RouterModule;
};


Container::$definitions[RouterModule::class] = function (){
    return new RouterModule;
};
*/


//Container::build(RouterInterface::class);


$_SERVER['REQUEST_URI'] = '/api/administracion/facturacion/5/prueba';
//$_SERVER['REQUEST_URI'] = '/cliente/5/grupo/8';

//Router::get('/api/contabilidad/clientes','controller');  

class TestConstroller{
    public function __invoke($id,$action)
    {
        return 'hola mundo'.$id.$action;
    }
}

class Test{
    public function process($input , $handler)
    {
        $res = 'fin'.$handler->handle($input);
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
        Router::get('/clientes',TestConstroller::class);
    });
    
    
    //Router::get('/clientesfes','controller');
    
},[Test::class]);

Router::group('/api/administracion', function(){
    Router::get('/facturacion/:id/:action',TestConstroller::class,[Test3::class]);
},[Test2::class]);


Router::get('/cliente/:id/grupo/:grupo',TestConstroller::class);


$core = CoreFactory::create(CoreHttp::class, [
    Test::class
]);

$res = $core->handle(new Request);
//echo Router::obtenerRutaStorage()."\n";
var_dump($res);
