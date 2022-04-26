<?php
class Form
{
  private $message = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    $form = new Template("view/form.html");
    $this->message = $form->saida();
  }
  public function salvar()
  {
    if (isset($_POST['exercicio']) && isset($_POST['tempo']) && isset($_POST['descanso'])){
      try {
        $conexao = Transaction::get();
        $academia = new Crud('academia');
        $exercicio = $conexao->quote($_POST['exercicio']);
        $tempo = $conexao->quote($_POST['tempo']);
        $descanso = $conexao->quote($_POST['descanso']);
        $resultado = $academia->insert("exercicio,tempo,descanso", "$exercicio,$tempo,$descanso");
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }
  public function getMessage()
  {
    return $this->message;
  }
  public function __destruct()
  {
    Transaction::close();
  }
}