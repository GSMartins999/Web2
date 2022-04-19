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
    if (isset($_POST['times']) && isset($_POST['titulos']) && isset($_POST['estado'])){
      try{
        $conexao = Transaction::get();
        $tabela = new Crud('tabela');
        $times = $conexao->quote($_POST['times']);
        $estado = $conexao->quote($_POST['estado']);
        $titulos = $conexao->quote($_POST['titulos']);
        $resultado = $tabela->insert("times,titulos,estado", "$times,$titulos,$estado");
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
