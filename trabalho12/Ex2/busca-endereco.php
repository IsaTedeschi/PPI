<?php

class Endereco
{
  public $rua;
  public $bairro;
  public $cidade;

  function __construct($rua, $bairro, $cidade)
  {
    $this->rua = $rua;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
  }
}

// carrega a string JSON da requisição
// php://input retorna todos os dados que vem depois
// das linhas de cabeçalho HTTP da requisição, 
// independentemente do tipo do conteúdo
$stringJSON = file_get_contents('php://input');

// converte a string JSON em objeto PHP
$dados = json_decode($stringJSON);
$cep = $dados->cep;

//quando for dado o cep específico, é colocado como endereço (rua, bairro e cidade) os dados já informados
if ($cep == '38400-100')
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
else if ($cep == '38400-200')
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else
  $endereco = new Endereco('', '', '');
  
header('Content-type: application/json');
echo json_encode($endereco);


// Diferênça entre o código do exercício 3 (recebendo JSON) e do exercício 5 (enviando JSON)

/*
  No código do exercício 3, é feita uma requisição GET, onde o CEP é enviado como um parâmetro na URL. 
  Já no código do exercício 5, é realizada uma requisição POST, e os dados são enviados no corpo da requisição como um objeto JSON. 
  Essa abordagem é útil quando se necessita enviar uma grande quantidade de dados ou informações sensíveis, como senhas, que não devem ser expostas na URL.
  
  Além disso, no código do exercício 5, é definido o cabeçalho Content-Type como application/json, indicando que o corpo da requisição está no formato JSON. 
  Os dados são enviados utilizando JSON.stringify(objetoJS), que converte o objeto JavaScript objetoJS em uma string JSON antes de enviá-lo.
    */
