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
    Transaction::get();
    $times = new Crud("times");
    $resultado = $times->select();
    $tabela = new Template("view/Tabela.html");
    if (is_array($resultado)){
      $tabela->set("linha", $resultado);
      $this->message = $tabela->saida();
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