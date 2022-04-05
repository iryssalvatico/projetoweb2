<?php
class Template
{
  private $arquivo;
  private $valores = array();
  public function __construct($arquivo)
  {
    $this->arquivo = $arquivo;
  }
  public function set($chave, $valor)
  {
    $this->valores[$chave] = $valor;
  }
  public function saida()
  {
    if (!file_exists($this->arquivo)) {
      return "Arquivo não encontrado";
    } else {
      $saida = file_get_contents($this->arquivo);
      if (count($this->valores) > 0) {
        foreach ($this->valores as $chave => $valor) {
          $tag = "{{$chave}}";
          $saida = str_replace($tag, $valor, $saida);
        }
      }
      return $saida;
    }
  }
}