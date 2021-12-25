<?php

namespace App\Controllers\Pages;

use App\Utils\View;
use App\Models\Entity\Organization;

class About extends Page
{
  public static function getAbout()
  {
    return 'About';
    $organization = new Organization;
    $attrs = get_class_vars(get_class($organization));
    $content = View::render('pages/sobre', $attrs);
    return parent::getPage('About Page', $content);
  }
}
