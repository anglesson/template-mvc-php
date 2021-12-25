<?php

namespace App\Http;

use \Closure;
use Exception;

class Router
{
  /**
   * URL completa do projeto.
   * @var string
   */
  private $url = '';

  /**
   * Prefixo de todas as rotas.
   * @var string
   */
  private $prefix = '';

  /**
   * Indice das rotas.
   * @var array
   */
  private $routes = [];

  /**
   * Instancia de Request
   * @var Request
   */
  private $request;

  public function __construct($url)
  {
    $this->request = new Request();
    $this->url = $url;
    $this->setPrefix();
  }

  public function setPrefix()
  {
    $parseUrl = parse_url($this->url);
    $this->prefix = $parseUrl['path'] ?? '';
  }

  private function addRoute($method, $route, $params = [])
  {
    foreach ($params as $key=>$value) 
    {
      if($value instanceof Closure)
      {
        $params['controller'] = $value;
        unset($params[$key]);
        continue;
      }
    }

    // Padrão da Rota
    $patternRoute = '/^'.str_replace('/', '\/', $route).'$/';
    $this->routes[$patternRoute][$method] = $params;
  }

  /**
   * Método responsável por definir uma rota de GET
   * @param string $route
   * @param array $params
   */
  public function get($route, $params = []) 
  {
    return $this->addRoute('GET', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de POST
   * @param string $route
   * @param array $params
   */
  public function post($route, $params = []) 
  {
    return $this->addRoute('POST', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de PUT
   * @param string $route
   * @param array $params
   */
  public function put($route, $params = []) 
  {
    return $this->addRoute('PUT', $route, $params);
  }

  /**
   * Método responsável por definir uma rota de DELETE
   * @param string $route
   * @param array $params
   */
  public function delete($route, $params = []) 
  {
    return $this->addRoute('DELETE', $route, $params);
  }

  /**
   * Retorna a URI desconsiderando o prefixo
   * @return string
   */
  private function getUri()
  {
    $uri = $this->request->getUri();
    $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
    // Retorna a URI sem prefixo.
    return end($xUri);
  }

  private function getRoute()
  {
    $uri = $this->getUri();
    $httpMethod = $this->request->getHttpMethod(); 
    foreach($this->routes as $patternRoute=>$methods)
    {
      // Verifica se a URI está no padrão esperado.
      if(preg_match($patternRoute, $uri))
      {
        // Verifica o metodo.
        if($methods[$httpMethod])
        {
          //Retorno dos parametros da rota
          return $methods[$httpMethod];
        }
        // Método não permitido
        throw new Exception("Método não permitido", 405);
      }
    }
    // URL não encontrada
    throw new Exception("URL não encontrada", 404);
  }

  public function run()
  {
    try {
      
      //Get Current Route
      $route = $this->getRoute();

      // Verifica o controlador
      if(!isset($route['controller']))
      {
        throw new Exception("A URL não pôde ser processada", 500);
      }

      // Argumentos da função
      $args = [];

      // Retorna a execução da função
      return call_user_func_array($route['controller'], $args);
    } catch (\Exception $e) {
      return new Response($e->getCode(), $e->getMessage());
    }
  }
}