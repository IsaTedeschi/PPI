<?php

require "../conexaoMysql.php";
require "produto.php";

// Recebe a marca de produto pela URL
$marca = $_GET['marca'] ?? '';

// Verifica se a marca foi fornecida
if (empty($marca)) {
  // Retorna uma mensagem de erro se a marca não foi fornecida
  echo json_encode(["error" => "Marca de produto não fornecida"]);
  exit;
}

// Conecta ao servidor do MySQL
$pdo = mysqlConnect();

// Busca os produtos da marca indicada no banco de dados
$arrayProdutos = Produto::GetByMarca($pdo, $marca);

// Verifica se há produtos da marca indicada
if (empty($arrayProdutos)) {
  // Retorna uma mensagem se não há produtos da marca indicada
  echo json_encode(["error" => "Nenhum produto encontrado para a marca indicada"]);
  exit;
}

// Formata os dados dos produtos para o formato JSON
$resultado = [];
foreach ($arrayProdutos as $produto) {
  $resultado[] = [
    "nome" => $produto->nome,
    "descricao" => $produto->descricao
  ];
}

// Retorna o resultado no formato JSON
echo json_encode($resultado);
