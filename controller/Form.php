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
    $form->set("nome", "");
    $form->set("titulos", "");
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
          $times->update("nome=$nomes, titulos=$titulos, estado=$estado", "id=$id");
        }
        $this->message = $times->getMessage();
        $this->error = $times->getError();
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
        $times = new Crud('times');
        $resultado = $times->select("*", "id=$id");
        if(!$times->getError()){
          $form = new Template("view/form.html");
          foreach ($resultado[0] as $cod => $valor) {
            $form->set($cod, $valor);
        }
        $this->message = $form->saida();
      } else {
        $this->message = $times->getMessage();
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
    if (is_string($this->error)){
      return $this->message;
    } else{
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