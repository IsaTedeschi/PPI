<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

// Resgata os dados do cliente
$codigo = $_POST["codigo"] ?? "";
$nome = $_POST["nome"] ?? "";
$sexo  = $_POST["sexo"] ?? "";
$email = $_POST["email"] ?? "";
$telefone = $_POST["telefone"] ?? "";

$peso = $_POST["peso"] ?? "";
$altura = $_POST["altura"] ?? "";
$tipo_sang = $_POST["tipo_sang"] ?? "";

//----------------------
$cpf  = $_POST["cpf"] ?? "";
$senha = $_POST["senha"] ?? "";
$estadocivil = $_POST["estadocivil"] ?? "";
$datanascimento = $_POST["datanascimento"] ?? "";
$endereco = $_POST["endereco"] ?? "";
$bairro = $_POST["bairro"] ?? "";
//----------------------

// Resgata os dados do endereço do cliente
$cep = $_POST["cep"] ?? "";
$logradouro = $_POST["logradouro"] ?? "";
$estado = $_POST["estado"] ?? "";
$cidade = $_POST["cidade"] ?? "";

// calcula um hash de senha seguro para armazenar no BD
$hashsenha = password_hash($senha, PASSWORD_DEFAULT);

$sql1 = <<<SQL
  INSERT INTO cliente (nome, cpf, email, hash_senha, data_nascimento, estado_civil, altura)
  VALUES (?, ?, ?, ?, ?, ?, ?)
  SQL;

$sql2 = <<<SQL
  INSERT INTO endereco_cliente 
    (cep, endereco, bairro, cidade, id_cliente)
  VALUES (?, ?, ?, ?, ?)
  SQL;


$sql3 = <<<SQL
  INSERT INTO pessoa 
    (nome, cpf, email, telefone, sexo, cep, logradouro, estado, cidade)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

$sql4 = <<<SQL
  INSERT INTO paciente
    (altura, peso, tipo_sang, codigo)
  VALUES (?, ?, ?, ?)
  SQL;



try {
  $pdo->beginTransaction();

  // Inserção na tabela cliente
  // Neste caso utilize prepared statements para prevenir
  // inj. de S Q L, pois estamos inserindo dados 
  // fornecidos pelo usuário
  $stmt1 = $pdo->prepare($sql1);
  if (!$stmt1->execute([
    $nome, $cpf, $email, $hashsenha,
    $datanascimento, $estadocivil, $altura
  ])) throw new Exception('Falha na primeira inserção');

  // Inserção na tabela endereco_cliente
  // Precisamos do id do cliente cadastrado, que
  // foi gerado automaticamente pelo MySQL
  // na operação acima (campo auto_increment), para
  // prover valor para o campo do tipo chave estrangeira
  $idNovoCliente = $pdo->lastInsertId();
  $stmt2 = $pdo->prepare($sql2);
  if (!$stmt2->execute([
    $cep, $endereco, $bairro, $cidade, $idNovoCliente
  ])) throw new Exception('Falha na segunda inserção');


  $stmt3 = $pdo->prepare($sql3);
  if (!$stmt3->execute([
    $nome, $cpf, $email, $telefone, $sexo, $cep, $logradouro, $estado, $cidade
  ])) throw new Exception('Falha na segunda inserção');


  
  $stmt4 = $pdo->prepare($sql4);
  if (!$stmt4->execute([
    $altura, $peso, $tipo_sang, $idNovoCliente
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
