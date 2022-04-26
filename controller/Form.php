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
        $times = new Crud('times');
        $nome = $conexao->quote($_POST['nome']);
        $titulos = $conexao->quote($_POST['titulos']);
        $estado = $conexao->quote($_POST['estado']);
        $resultado = $times->insert("nome,titulos,estado", "$nome,$titulos,$estado");
        Transaction::close();
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
