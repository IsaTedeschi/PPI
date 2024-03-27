<?php

require "contatos.php";

// coleta os dados do formulário
$nome = $_POST["nome"] ?? "";
$cpf = $_POST["cpf"] ?? "";
$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";
$cep = $_POST["cep"] ?? "";
$endereco = $_POST["endereco"] ?? "";
$bairro = $_POST["bairro"] ?? "";
$cidade = $_POST["cidade"] ?? "";
$estado = $_POST["estado"] ?? "";


// cria um novo contato e acrescenta no arquivo de texto
$novoContato = new Contato($nome, $cpf, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado);
$novoContato->AddToFile("contatos.txt");

// redireciona o navegador para a página de listagem de contatos
header("location: listaContatos.php");

?>