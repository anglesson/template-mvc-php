<?php

namespace App\Http;

class Response
{
  private $httpCode = 200;

  private $headers = [];

  private $contentType = 'text/html';

  private $content;

  public function __construct($httpCode, $content, $contentType = 'text/html')
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }

  /**
   * Método responsável por alterar o conteudo do response.
   * @param string $contentType
   */
  public function setContentType($contentType)
  {
    $this->contentType = $contentType;
    $this->addHeader('Content-Type', $contentType);
  }

  /**
   * Adiciona uma resgistro no cabecalho.
   * @param mixed
   */
  public function addHeader($key, $value)
  {
    $this->headers[$key] = $value;
  }

  /**
   * Enviar os headers para o navegador.
   */
  private function sendHeaders()
  {
    http_response_code($this->httpCode);
    foreach($this->headers as $key => $value)
    {
      header("$key: $value");
    }
  }

  /**
   * Método responsável por enviar a resposta para o usuário.
   */
  public function sendResponse()
  {
    $this->sendHeaders();
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;
        exit;
    }
  }
}
