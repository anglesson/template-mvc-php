<?php

use \App\Http\Response;
use App\Controllers\Pages;

// Rota Home
$router->get('/', [
  function() {
    return new Response(200, Pages\Home::getHome());
  }
]);

// Rota Home
$router->get('/sobre', [
  function() {
    return new Response(200, Pages\About::getAbout());
  }
]);