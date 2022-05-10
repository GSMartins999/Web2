<?php
class Tabela
{
  private $message = "";
  public function __construct()
  {
    Transaction::open();
  }
  public function controller()
  {
    try{
    Transaction::get();
    $times = new Crud("times");
    $resultado = $times->select();
    $tabela = new Template("view/Tabela.html");
    if (is_array($resultado)){
      $tabela->set("linha", $resultado);
      $this->message = $tabela->saida();
    } else{
      $this->message = $times->getMessage();
      $this->error = $times->getError();
    }
  } catch (Exception $e) {
    $this->message = $times->getMessage();
    $this->error = true;
  }
}
  public function remover()
  {
    if (isset($_GET["id"])) {
      try {
        $conexao = Transaction::get();
        $id = $conexao->quote($_GET["id"]);
        $times = new Crud('times');
        $times->delete("id=$id");
        $this->message = $times->getMessage();
        $this->error = $computador->getError();
      } catch (Exception $e) {
        $this->message = $times->getMessage();
        $this->error = true;
    }
  } else {
    $this->message = "Faltando parâmetro!";
    $this->error = true;
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
