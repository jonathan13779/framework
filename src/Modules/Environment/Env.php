<?php

namespace Jonathan13779\Framework\Modules\Environment;

class Env{
    private static $data = [];
    public static function getRootPath(){
        if (isset($data['root_path'])){
            return $data['root_path'];
        }

        return self::defineRootPath();
    }

    public static function defineRootPath(){
        $path = __DIR__;

		$pos = strpos($path, '/vendor/');
		if ($pos!==false){
			return self::$data['root_path'] = substr($path,0, $pos);
		}

		$pos = strpos($path, '/src/');
		if ($pos!==false){
			return self::$data['root_path'] = substr($path,0, $pos);
		}
    }
}

