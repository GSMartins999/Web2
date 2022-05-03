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
    $form->set("id" , "");
    $form->set("nomes" , "");
    $form->set("titulos" , "");
    $form->set("estado" , "");
    $this->message = $form->saida();
  }
  public function salvar()
  {
    if (isset($_POST['nomes']) && isset($_POST['titulos']) && isset($_POST['estado'])){
      try{
        $conexao = Transaction::get();
        $times = new Crud('times');
        $nomes = $conexao->quote($_POST['nomes']);
        $titulos = $conexao->quote($_POST['titulos']);
        $estado = $conexao->quote($_POST['estado']);
        if(empty($_POST['id'])) {
          $times->insert("nome,titulos,estado", "$nomes, $titulos, $estado");
        }else{
          $id = $conexao->quote($_POST['id']);
          $times->update("nome=$nome, titulos=$titulos, estado=$estado", "id=$id");
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
        $times = new Crud('times');
        $resultado = $times->select("*", "id=$id");
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
