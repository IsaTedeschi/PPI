<?php

// pega o cep da requisicao http
$cep = $_GET['cep'] ?? '';

// se opcoes validas retorna no corpo da requisicao essas cidades
if ($cep == '38400-100'
  echo 'Uberlândia';
else if ($cep == '38700-000')
  echo 'Patos de Minas';
else {
  // caso contrario (erro = 404) coloca no corpo da requisicao essa frase de erro
  http_response_code(404);
  echo "$cep is not available";
}