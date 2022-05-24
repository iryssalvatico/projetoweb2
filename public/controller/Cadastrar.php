<?php
    class Cadastrar{
        private $message = "";
        private $error = "";
        public function __construct(){
            Transaction::open();
        }

        public function controller(){
            $form = new Template("public/view/cadastrar.html");
            $this->message = $form->saida();
        }

        public function salvar(){
            if (isset($_POST["nome"]) && isset($_POST['email']) && isset($_POST['senha'])) {
                try {
                    $conexao = Transaction::get();
                    $nome = $conexao->quote($_POST["nome"]);
                    $email = $conexao->quote($_POST["email"]);
                    $senha = $conexao->quote(sha1($_POST["senha"]));
                    $crud = new Crud("usuario");
                    $crud->insert(
                        "nome, email, senha",
                        "{$nome}, {$email}, {$senha}"
                    );
                    $this->message = $crud->getMessage();
                    $this->error = $crud->getError();
                } catch (Exception $e){
                    $this->message = "Ocorreu um erro! " . $e->getMessage();
                    $this->error = TRUE;   
                }
            } else {
                $this->message = "Preencha todos os campos! ";
                $this->error = TRUE;    
            }
        }

        public function getMessage(){
            if (is_string($this->error)){
                return $this->message;
            } else {
                $msg = new Template("shared/view/msg.html");
                if ($this->error) {
                    $msg->set("cor", "danger");
                } else {
                    $msg->set("cor", "success");
                }
                $msg->set("msg", $this->message);
                $msg->set("uri", "/modelo/?class=Login");
                return $msg->saida();    
            }    
        }

        public function getError(){
            return $this->error;
        }

        public function __destruct(){
            Transaction::close();
        }
    }