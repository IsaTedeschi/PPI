<?php

require "../conexaoMysql.php";

class RequestResponse
{
  public $success;
  public $detail;

  function __construct($success, $detail)
  {
    $this->success = $success;
    $this->detail = $detail;
  }
}

function checkUserCredentials($pdo, $email, $senha)
{
  $sql = <<<SQL
    SELECT hash_senha
    FROM cliente
    WHERE email = ?
    SQL;

  try {
    // Neste caso utilize prepared statements para prevenir
    // ataques do tipo SQL Injection, pois precisamos
    // inserir dados fornecidos pelo usuário na 
    // consulta SQL (o email do usuário)
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $senhaHash = $stmt->fetchColumn();

    if (!$senhaHash) 
      return false; // a consulta não retornou nenhum resultado (email não encontrado)

    if (!password_verify($senha, $senhaHash))
      return false; // senha incorreta
      
    // email e senha corretos
    return true;
  } 
  catch (Exception $e) {
    exit('Falha inesperada: ' . $e->getMessage());
  }
}

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

$pdo = mysqlConnect();
if (checkUserCredentials($pdo, $email, $senha)) {
  // Define o parâmetro 'httponly' para o cookie de sessão, para que o cookie
  // possa ser acessado apenas pelo navegador nas requisições http (e não por código JavaScript).
  // Aumenta a segurança evitando que o cookie de sessão seja roubado por eventual
  // código JavaScript proveniente de ataques XSS.
  $cookieParams = session_get_cookie_params();
  $cookieParams['httponly'] = true;
  session_set_cookie_params($cookieParams);

  // cria uma nova sessão para o usuário
  session_start();
  $_SESSION['loggedIn'] = true;
  $_SESSION['user'] = $email;
  $response = new RequestResponse(true, 'home.php');
} 
else
  $response = new RequestResponse(false, ''); 

echo json_encode($response);