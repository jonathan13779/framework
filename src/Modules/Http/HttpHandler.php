<?php

namespace Jonathan13779\Framework\Modules\Http;

use Jonathan13779\Framework\Modules\Http\Request;

class HttpHandler{
    private Request $request;

    public function __construct(
        Request $request
    )
    {
        $this->request = $request;    
    }

}
