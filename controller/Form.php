<?php
class Form
{
  private $message = "";
  private $error = "";
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
    if (isset($_POST['exercicio']) && isset($_POST['tempo']) && isset($_POST['descanso'])) {
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
        $this->message = $academia->getMessage();
        $this->error = $academia->getError();
      } catch (Exception $e) {
        $this->message = $e->getMessage();
        $this->error = true;
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
        if (!$academia->getError()) {
          $form = new Template("view/form.html");
          foreach ($resultado[0] as $cod => $valor) {
            $form->set($cod, $valor);
          }
          $this->message = $form->saida();
        } else {
          $this->message = $computador->getMessage();
          $this->error = true;
        }
      } catch (Exception $e) {
        $this->message = $e->getMessage();
        $this->error = true;
      }
    }
  }
  public function getMessage()
  {
    if (is_string($this->error)) {
      return $this->message;
    } else {
      $msg = new Template("view/msg.html");
      if ($this->error) {
        $msg->set("cor", "danger");
      } else {
        $msg->set("cor", "success");
      }
      $msg->set("msg", $this->message);
      $msg->set("uri", "?class=Tabela");
      return $msg->saida();
    }
  }
  public function __destruct()
  {
    Transaction::close();
  }
}