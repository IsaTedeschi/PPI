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

$cep = $_GET['cep'] ?? '';

//quando for dado o cep específico, é colocado como endereço (rua, bairro e cidade) os dados já informados
if ($cep == '38400-100')
  $endereco = new Endereco('Av Floriano', 'Centro', 'Uberlândia');
else if ($cep == '38400-200')
  $endereco = new Endereco('Rua Tiradentes', 'Fundinho', 'Uberlândia');
else { //se não for nenhum dos ceps já cadastrados, o endereço não é adicionado nada
  $endereco = new Endereco('', '', '');
}

// a requisição feita é para application/json
header('Content-type: application/json');
// é retornado um json do endereço
echo json_encode($endereco);
