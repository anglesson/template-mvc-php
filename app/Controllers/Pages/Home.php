<?php

namespace App\Controllers\Pages;

use App\Utils\View;
use App\Models\Entity\Organization;

class Home extends Page
{
  public static function getHome()
  {
    $organization = new Organization;
    $attrs = get_class_vars(get_class($organization));
    $content = View::render('pages/home', $attrs);
    return parent::getPage('Home Page', $content);
  }
}
