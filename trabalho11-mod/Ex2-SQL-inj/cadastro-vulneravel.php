<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$nome = $_POST["nome"] ?? "";
$telefone = $_POST["telefone"] ?? "";

// try {

//   // NÃO FAÇA ISSO! Exemplo de código vulnerável a inj. de S-Q-L
//   $sql = <<<SQL
//   INSERT INTO aluno (nome, telefone)
//   VALUES ('$nome', '$telefone');
//   SQL;  

//   // Experimente fazer o cadastro de um novo aluno preenchendo 
//   // o campo telefone utilizando o texto disponibilizado pelo professor
//   // nos slides de aula
//   // problema estah aqui ele nao utiliza prepared statement para executar esse comando sql (deveria pois utiliza input do usuario no comando), assim o usuario consegue concatenar o drop table como outro comando utilizando a string $telefone
//   $pdo->exec($sql);
//   header("location: mostra-alunos.php");
//   exit();
// }

try {
  $sql = <<<SQL
  INSERT INTO aluno (nome, telefone)
  VALUES (?, ?);
  SQL;  

  // Experimente fazer o cadastro de um novo aluno preenchendo 
  // o campo telefone utilizando o texto disponibilizado pelo professor
  // nos slides de aula
  // agora ele utiliza prepared statement
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$nome, $telefone]);
  header("location: mostra-alunos.php");
  exit();
} 
catch (Exception $e) {  
  exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
