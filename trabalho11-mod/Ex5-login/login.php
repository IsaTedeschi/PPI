<?php

// Dado um pdo, um possível email e uma possível senha,
// retorna true se, e só, se email e senha existem no pdo
// Observação: a senha é verificado por password_verify, uma
// vez que ela está como um hash criptográfico na tabela
function checkLogin($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT hash_senha
    FROM cliente
    WHERE email = ?
    SQL;

  try {
    // Neste caso utilize prepared statements para prevenir
    // inj. de S Q L, pois precisamos inserir dados fornecidos
    // pelo usuário na consulta SQL (o email do usuário)
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $row = $stmt->fetch();
    if (!$row) return false; // nenhum resultado (email não encontrado)

    return password_verify($senha, $row['hash_senha']);
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

require "../conexaoMysql.php";
$pdo = mysqlConnect();

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";

// Se checkLogin ok, muda o cabeçalho da requisição http para localização home.html,
// caso contrário, faz nada (mantem no mesmo lugar)
if (checkLogin($pdo, $email, $senha))
  header("location: home.html");
else
  header("location: index.html");
