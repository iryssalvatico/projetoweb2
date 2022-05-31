<?php
class Login
{
    private $message = "";
    private $error = "";
    public function __construct()
    {
        Transaction::open();
    }
    public function controller()
    {
        $form = new Template("public/view/login.html");
        $this->message = $form->saida();
    }
    public function salvar()
    {
        if (isset($_POST["email"]) && isset($_POST["senha"])) {
        try {
        $conexao = Transaction::get();
        $email = $conexao->quote($_POST["email"]);
        $senha = $conexao->quote(sha1($_POST["senha"]));
        $crud = new Crud("usuario");
        $usuario = $crud->select(
            "*",
            "email={$email} AND senha={$senha}"
        );
        if (!$crud->getError()) {
            Session::startSession();
            Session::setValue("id", $usuario[0]["id"]);
            Session::setValue("nome", $usuario[0]["nome"]);
            header("Location:/irysweb2/restrita.php");
        }
        $this->message = $crud->getMessage();
        $this->message = "Login ou senha inválidos!";
        $this->error = $crud->getError();
        } catch (Exception $e) {
            $this->message = "Ocorreu um erro! " . $e->getMessage();
            $this->error = TRUE;
        }////////
        } else {
            $this->message = "Preencha todos os campos! ";
            $this->error = TRUE;
        }
    }
    public function getMessage()
    {
        if (is_string($this->error)) {
            return $this->message;
            } else {
                $msg = new Template("shared/view/msg.html");
                if ($this->error) {
                    $msg->set("cor", "danger");
                } else {
                    $msg->set("cor", "success");
                }
            $msg->set("msg", $this->message);
            $msg->set("uri", "/irysweb2/?class=Login");
            return $msg->saida();
        }
    }
    public function getError()
    {
        return $this->error;
    }
    public function __destruct()
    {
        Transaction::close();
    }
}