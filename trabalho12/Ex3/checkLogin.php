<?php
// primeiro é declarado as variaveis que vão ser usadas 
// e depois feito um construtor para criar os elementos
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


$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Validação simplificada para fins didáticos. Não faça isso!
if ($email == 'teste@mail.com' && $senha == '123456')
  $response = new RequestResponse(true, 'home.html');
else
  $response = new RequestResponse(false, '');

header('Content-type: application/json');
echo json_encode($response);


// RESPOSTAS DAS QUESTÕES
// O formulário foi enviado da forma tradicional? 
//    Não, ele foi enviado via XMLHttpRequest, AJAX. Nesse caso o onsubmit foi interceptado e tratado antes de enviar os dados, o que normalmente não acontece na forma tradicional 

// Houve redirecionamento?
//    Houve redirecionamento, se a resposta do AJAX indica sucesso, tem o redirecionamento, isso só acontece com o login feito corretamente. Isso é feito pelo window.location.