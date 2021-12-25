<?php

namespace App\Utils;

class View 
{
  /**
   * Método reponsável por retornar o conteúdo de uma view
   * @param string $view
   * @return string
   */
  public static function getContentView($view)
  {
    $file = __DIR__.'/../../resources/views/'.$view.'.html';
    return file_exists($file) ? file_get_contents($file) : '';
  }

  /**
   * Método reponsável por retornar o conteúdo renderizado de uma view
   * @param string $view
   * @param array $vars
   * @return string
   */
  public static function render($view, $vars = [])
  {
    // Conteudo da view
    $contentView = self::getContentView($view);

    // Chaves do arrays
    $keys = array_keys($vars);
    $keys = array_map(function($item){
      return '{{'.$item.'}}';
    }, $keys);

    // Retorna o conteudo renderizado
    return str_replace($keys, array_values($vars), $contentView);
  }

}