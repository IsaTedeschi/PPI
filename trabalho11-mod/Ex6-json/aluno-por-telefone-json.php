<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

// pega da requisição http pelo metodo get o telefone (no url)
$telefone = $_GET['telefone'] ?? '';

// seleciona os alunos com o telefone especificado
$sql = <<<SQL
  SELECT *
  FROM aluno
  WHERE telefone = ?
SQL;

try {
  // faz a selecao sql
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$telefone]);
  $aluno = $stmt->fetch(PDO::FETCH_OBJ);

  // faz o mesmo que o todos-alunos-json.php que é colocar no cabeçalho + codificar em json o resultado
  header('Content-Type: application/json; charset=utf-8');
  echo json_encode($aluno);
} 
catch (Exception $e) {
  exit('Falha inesperada: ' . $e->getMessage());
}
