<?php

require __DIR__.'/vendor/autoload.php';

use \App\Http\Router;

define('URL', 'http://localhost/mvc');

$router = new Router(URL);

include __DIR__.'/routes/pages.php';

// Print response of the route.
$router->run()->sendResponse();