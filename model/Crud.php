<?php
class Crud
{
  private $tabela;
  public function __construct($tabela)
  {
    $this->tabela = $tabela;
  }
  public function select($campos = "*", $condicao = NULL)
  {
    $conexao = Transaction::get();
    if (!$condicao) {
      $sql = "SELECT $campos FROM $this->tabela";
    } else {
      $sql = "SELECT $campos FROM $this->tabela WHERE $condicao";
    }
    $resultado = $conexao->query($sql);
    if ($resultado->rowCount() > 0) {
      while ($registros = $resultado->fetch(PDO::FETCH_ASSOC)) {
        $lista[] = $registros;
      }
      return $lista;
    } else {
      echo "Nenhum registro encontrado!";
      return false;
    }
  }
  public function insert($campos = NULL, $valores = NULL)
  {
    if (!$campos && !$valores) {
      echo "Campos e valores não informados!";
      return false;
    } else {
      $conexao = Transaction::get();
      $sql = "INSERT INTO $this->tabela ($campos) VALUES ($valores)";
      $resultado = $conexao->query($sql);
      if ($resultado->rowCount() > 0) {
        echo "Inserido com sucesso!";
        return true;
      } else {
        echo "Erro ao inserir!";
        return false;
      }
    }
  }
  public function update($valores = NULL, $condicao = NULL)
  {
    if (!$valores || !$condicao) {
      echo "Valores ou condição não informados!";
      return false;
    } else {
      $conexao = Transaction::get();
      $sql = "UPDATE $this->tabela SET $valores WHERE $condicao";
      $resultado = $conexao->query($sql);
      if ($resultado->rowCount() > 0) {
        echo "Atualizado com sucesso!";
        return true;
      } else {
        echo "Erro ao atualizar!";
        return false;
      }
    }
  }
  public function delete($condicao = NULL)
  {
    if (!$condicao) {
      echo "Condição não informada!";
      return false;
    } else {
      $conexao = Transaction::get();
      $sql = "DELETE FROM $this->tabela WHERE $condicao";
      $resultado = $conexao->query($sql);
      if ($resultado->rowCount() > 0) {
        echo "Excluído com sucesso!";
        return true;
      } else {
        echo "Erro ao excluir!";
        return false;
      }
    }
  }
}