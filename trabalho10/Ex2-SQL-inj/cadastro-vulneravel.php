<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$telefone = $_POST["telefone"] ?? "";

//try {

  // NÃO FAÇA ISSO! Exemplo de código vulnerável a inj. de S-Q-L


  //insere na tabela criada o nome e telefone criados
  //qualquer coisa que o usuário colocar nos campos vão ser considerados, sem serem tratatos
  //se o usuário fazer o ataque, pode levar as consequencias mostradas
//  $sql = <<<SQL
//  INSERT INTO aluno (nome, telefone)
//  VALUES ('$nome', '$telefone');
//  SQL;  

  // Experimente fazer o cadastro de um novo aluno preenchendo 
  // o campo telefone utilizando o texto disponibilizado pelo professor
  // nos slides de aula

  //Deveria usuar 'prepare statement'
//  $pdo->exec($sql);
//  header("location: mostra-alunos.php");
//  exit();
//}
try {

  // NÃO FAÇA ISSO! Exemplo de código vulnerável a inj. de S-Q-L


  //insere na tabela criada o nome e telefone criados
  //qualquer coisa que o usuário colocar nos campos vão ser considerados, sem serem tratatos
  //se o usuário fazer o ataque, pode levar as consequencias mostradas
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES (?, ?);
  SQL;  

  // Experimente fazer o cadastro de um novo aluno preenchendo 
  // o campo telefone utilizando o texto disponibilizado pelo professor
  // nos slides de aula

  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $telefone]);
  header("location: mostra-alunos.php");
  exit();
}  
catch (Exception $e) {  
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
