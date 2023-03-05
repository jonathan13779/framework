<?php

namespace Jonathan13779\Framework\Modules\Storage;

class Storage{
    private string $path = '';
    
    public function __construct()
    {
        $rutaFachada = realpath(__DIR__);
        $rutaRaiz = dirname(dirname(dirname($rutaFachada)));
        $this->path = $rutaRaiz . '/storage';
    }
}