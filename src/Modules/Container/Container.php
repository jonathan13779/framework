<?php
namespace Jonathan13779\Framework\Modules\Container;

use ReflectionClass;
use ReflectionMethod;
use ReflectionFunction;
use Jonathan13779\Framework\Contracts\RouterInterface;

class Container{

    public static $singleton = [];
    private static $instances = [];
    public static $definitions = [];
	public static $config = [];

	public static function set($definition, $value){
		self::$config[$definition] = $value;
	}

    public static function isDefined($definition): bool
    {
        if (isset(self::$definitions[$definition])){
            return true;
        }
        if (isset(self::$singleton[$definition])){
            return true;
        }


        return false;
    }


	public static function register($definition, $value){
		self::set($definition, $value);
	}
    public static function buildParams($params,&$buildedParams,$setDefault=true){
        foreach ($params as $key => $param) {
			$name = $param->getName();
			if (array_key_exists($name,self::$config)){
				$buildedParams[] = self::$config[$name];
			}
			else
            if ($param->getType()) {
                $className = $param->getType()->getName();
                if (isset(self::$singleton[$param->getType()->getName()]))
                    $className = self::$singleton[$param->getType()->getName()];
                
                $buildedParams[] = self::build($className);
            } else {
				
                if ($setDefault)
                $buildedParams[] = $param->getDefaultValue();
            }
        }
    }

    public static function setInstance($class,$object){
        if (isset(self::$singleton[$class]))
        self::$instances[$class] = $object;
    }

    public static function executeMethod($object,$method){
        $class = get_class($object);
        $metodoReflexionado = new ReflectionMethod($class, $method);
        $params = $metodoReflexionado->getParameters();
        $finalParams = [];
        self::buildParams($params,$finalParams);
        $metodoReflexionado->invokeArgs($object, $finalParams);
    }

    public static function getParams($source){
        $funcionReflexionada = new ReflectionFunction($source);
        $params = $funcionReflexionada->getParameters();
        $finalParams = [];
        self::buildParams($params,$finalParams,false);
        return $finalParams;
    }

    public static function build($class,$config=[])
    {   
        if ($class instanceof \Closure) {
            
            $funcionReflexionada = new ReflectionFunction($class);
            $params = $funcionReflexionada->getParameters();
            $finalParams = [];
            self::buildParams($params,$finalParams);

            return $funcionReflexionada->invokeArgs($finalParams);
        }
        $sourceClass = $class;
        if (isset(self::$instances[$class])){
            return self::$instances[$class];
        }
        
        if(isset(self::$singleton[$class])){            
            $class = self::$singleton[$class];
        }
        else
        {
            $class = self::getDefinition($class);
        }
        
        if (is_callable($class)){
            $object = $class();
            self::setInstance($sourceClass,$object);
            return $object;
        }

        $objReflection = new ReflectionClass($class);
        
        $contructor = $objReflection->getConstructor();
        if (is_null($contructor)) {
            $object = new $class;
            self::setInstance($sourceClass,$object);
            if (isset($config['execute'])){                
                self::executeMethod($object,$config['execute']);
            }   
            return $object;         
            
        }

        $params = $contructor->getParameters();

        $finalParams = [];
        
        self::buildParams($params,$finalParams,false);

        $object = $objReflection->newInstanceArgs($finalParams);
		
        self::setInstance($sourceClass,$object);

        if (isset($config['execute'])){                
            self::executeMethod($object,$config['execute']);
        }  
              
        return $object;
    }

    private static function getDefinition($class){
        if (is_string($class) && isset(self::$definitions[$class])){
            
            return self::getDefinition(self::$definitions[$class]);
        }
        return $class;
    } 

    public static function get($class,$config=[]){
        return self::build($class,$config);
    }
    
    
}

?>