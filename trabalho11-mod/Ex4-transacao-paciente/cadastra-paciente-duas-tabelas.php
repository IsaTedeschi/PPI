<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

// Resgata os dados da pessoa
$nome = $_POST["nome"] ?? "";
$sexo  = $_POST["sexo"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";

// Resgata os dados do paciente
$peso = $_POST["peso"] ?? "";
$altura = $_POST["altura"] ?? "";
$tipo_sanguineo = $_POST["tipo_sanguineo"] ?? "";

// Resgata os dados do endereco do paciente
$cep = $_POST["cep"] ?? "";
$logradouro = $_POST["logradouro"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$estado = $_POST["estado"] ?? "";

// calcula um hash de senha seguro para armazenar no BD
$hashsenha = password_hash($senha, PASSWORD_DEFAULT);

$sql1 = <<<SQL
  INSERT INTO pessoa (nome, sexo, email, telefone, 
                       cep, logradouro, cidade, estado)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

$sql2 = <<<SQL
  INSERT INTO paciente 
    (peso, altura, tipo_sanguineo, codigo)
  VALUES (?, ?, ?, ?)
  SQL;

try {
  $pdo->beginTransaction();

  // Inserção na tabela pessoa
  // Neste caso utilize prepared statements para prevenir
  // inj. de S Q L, pois estamos inserindo dados 
  // fornecidos pelo usuário
  $stmt1 = $pdo->prepare($sql1);
  if (!$stmt1->execute([
    $nome, $sexo, $email, $telefone,
    $cep, $logradouro, $cidade, $estado
  ])) throw new Exception('Falha na primeira inserção (pessoa)');

  // Inserção na tabela pessoa
  // Precisamos do id da pessoa cadastrada, que
  // foi gerado automaticamente pelo MySQL
  // na operação acima (campo auto_increment), para
  // prover valor para o campo do tipo chave estrangeira
  $idNovaPessoa = $pdo->lastInsertId();
  $stmt2 = $pdo->prepare($sql2);
  if (!$stmt2->execute([
    $peso, $altura, $tipo_sanguineo, $idNovaPessoa
  ])) throw new Exception('Falha na segunda inserção (paciente)');

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
