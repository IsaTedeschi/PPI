<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

// Resgata os dados do paciente
$codigo = $_POST["codigo"] ?? "";
$nome = $_POST["nome"] ?? "";
$sexo  = $_POST["sexo"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";

$peso = $_POST["peso"] ?? "";
$altura = $_POST["altura"] ?? "";
$tipo_sang = $_POST["tipo_sang"] ?? "";

// Resgata os dados do endereço do paciente
$cep = $_POST["cep"] ?? "";
$logradouro = $_POST["logradouro"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$estado = $_POST["estado"] ?? "";


$sql1 = <<<SQL
  INSERT INTO paciente (codigo, nome, sexo, email, telefone, cep, logradouro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

$sql2 = <<<SQL
  INSERT INTO paciente 
    (peso, altura, tipo_sang, codigo)
  VALUES (?, ?, ?, ?)
  SQL;

try {
  $pdo->beginTransaction();

  // Inserção na tabela cliente
  // Neste caso utilize prepared statements para prevenir
  // inj. de S Q L, pois estamos inserindo dados 
  // fornecidos pelo usuário
  $codigo = $pdo->lastInsertId();
  $stmt1 = $pdo->prepare($sql1);
  if (!$stmt1->execute([
    $codigo, $nome, $sexo, $email, $telefone, $cep, $logradouro, $cidade, $estado
  ])) throw new Exception('Falha na primeira inserção');

  // Inserção na tabela endereco_cliente
  // Precisamos do id do cliente cadastrado, que
  // foi gerado automaticamente pelo MySQL
  // na operação acima (campo auto_increment), para
  // prover valor para o campo do tipo chave estrangeira

  $stmt2 = $pdo->prepare($sql2);
  if (!$stmt2->execute([
    $peso, $altura, $tipo_sang  
  ])) throw new Exception('Falha na segunda inserção');

  // Efetiva as operações
  $pdo->commit();

  header("location: ../index.html");
  exit();
} 
catch (Exception $e) {
  $pdo->rollBack();
  if ($stmt1->errorInfo()[1] === 1062)
    exit('Dados duplicados: ' . $e->getMessage());
  else
    exit('Falha ao cadastrar os dados: ' . $e->getMessage());
}
