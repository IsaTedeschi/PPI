<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$sql = <<<SQL
  SELECT *
  FROM aluno
SQL;

try {
  $stmt = $pdo->query($sql);
  // faz uma busca sql de todos os alunos da tabela aluno 
  $alunos = $stmt->fetchAll(PDO::FETCH_OBJ);
  // coloca no cabeçalho da requisição http o tipo do conteudo,
  // no caso é uma requisição no formato json com conjunto de caracteres utf-8
  header('Content-Type: application/json; charset=utf-8');
  // codifica o array alunos que a busca sql retornou em formato de json e faz um
  // echo para colocar como conteudo da requisicao http
  echo json_encode($alunos);
} 
catch (Exception $e) {
  exit('Falha inesperada: ' . $e->getMessage());
}
