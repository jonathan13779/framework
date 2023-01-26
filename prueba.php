<?php

require __DIR__.'/vendor/autoload.php';

use Jonathan13779\Framework\CoreFactory;
use Jonathan13779\Framework\CoreHttp;

$core = CoreFactory::create(CoreHttp::class);
$core->handle();
