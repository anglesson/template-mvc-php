<?php

namespace App\Http;

class Request 
{

  /**
   * Metodo HTTP da requisição
   * @var string
   */
  private $method;

  /**
   * URI da página
   * @var string
   */
  private $uri;

  /**
   * Parâmetros da URL GET
   * @var string
   */
  private $query;

  /**
   * Parâmetros da URL POST
   * @var string
   */
  private $params;

  /**
   * Cabecalho da Requisição
   * @var string
   */
  private $headers;

  public function __construct()
  {
    $this->query = $_GET ?? [];
    $this->params = $_POST ?? [];
    $this->headers = getallheaders();
    $this->method = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
  }

  public function getHttpMethod() {
    return $this->method;
  }

  public function getUri() {
    return $this->uri;
  }

  public function getQuery() {
    return $this->query;
  }

  public function getParams() {
    return $this->params;
  }

  public function getHeaders() {
    return $this->headers;
  }
}