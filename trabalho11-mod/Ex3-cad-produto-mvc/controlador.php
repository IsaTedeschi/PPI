<?php

require "../conexaoMysql.php";
require "produto.php";

// resgata a ação a ser executada
$acao = $_GET['acao'];

// conecta ao servidor do MySQL
$pdo = mysqlConnect();

switch ($acao) {
  
  case "adicionarProduto":
    // recupera os dados do formulário
    $nome = $_POST["nome"] ?? "";
    $marca = $_POST["marca"] ?? "";
    $descricao = $_POST["descricao"] ?? "";

    $novoProduto = new Produto(
      $nome, $marca, $descricao
    );

    // adiciona o produto na tabela do banco de dados
    $novoProduto->AddToDatabase($pdo);
    header("location: controlador.php?acao=listarProdutos");
    break;

  //-----------------------------------------------------------------
  case "excluirProduto":
    $nome = $_GET["nome"] ?? "";
    $pdo = mysqlConnect();
    Produto::RemoveByNome($pdo, $nome);
    header("location: controlador.php?acao=listarProdutos");
    break;

  //-----------------------------------------------------------------
  case "listarProdutos":
    $arrayProdutos = Produto::GetFirst30($pdo);
    
    // O script mostra-produtos.php produzirá uma página dinâmica
    // utilizando os dados do array acima ($arrayProdutos)
    include "mostra-produtos.php";
    break;

  //-----------------------------------------------------------------
  default:
    exit("Ação não disponível");
}
