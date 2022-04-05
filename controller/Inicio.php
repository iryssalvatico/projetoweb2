<?php

class Inicio
{
  public function controller()
  {
    $inicio = new Template('view/inicio.html');
    $inicio->set('inicio', 'Olá seja bem vindo!!!');
    return $inicio->saida();
  }
}