<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$telefone = $_POST["telefone"] ?? "";

try {

  // NÃO FAÇA ISSO! Exemplo de código vulnerável a injeção de SQL
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES ('$nome', '$telefone');
  SQL;  

  // Experimente fazer o cadastro de um novo aluno preenchendo 
  // o campo telefone utilizando o texto disponibilizado no arquivo
  // exemplo-injecao.txt 
  $pdo->exec($sql);
  header("location: mostra-alunos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
