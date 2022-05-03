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
    $form->set("id", "");
    $form->set("exercicio", "");
    $form->set("tempo", "");
    $form->set("descanso", "");
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
        if (empty($_POST["id"])) {
          $academia->insert("exercicio,tempo,descanso", "$exercicio,$tempo,$descanso");
        } else {
          $id = $conexao->quote($_POST['id']);
          $academia->update("exercicio=$exercicio,tempo=$tempo,descanso=$descanso", "id=$id");
        }
      } catch (Exception $e) {
        echo $e->getMessage();
      }
    }
  }
  public function editar()
  {
    if (isset($_GET['id'])) {
      try {
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET['id']);
        $academia = new Crud('academia');
        $resultado = $academia->select("*", "id=$id");
        $form = new Template("view/form.html");
        foreach ($resultado[0] as $cod => $valor) {
          $form->set($cod, $valor);
        }
        $this->message = $form->saida();
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