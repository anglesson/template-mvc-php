<?php

namespace App\Controllers\Pages;

use App\Utils\View;

class Page 
{
  public static function getPage($title, $content) 
  {
    return View::render('pages/page', [
      'title' => $title,
      'content' => $content
    ]);
  }
}