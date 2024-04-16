<?php

require "../conexaoMysql.php";
$pdo = mysqlConnect();

try {

  $sql = <<<SQL
  SELECT codigo, nome, peso, altura, tipo_sang
  FROM pessoa INNER JOIN paciente ON codigo = codigo
  SQL;

  // Neste exemplo não é necessário utilizar prepared statements
  // porque não há possibilidade de inj. de S Q L, 
  // pois nenhum parâmetro é utilizado na query SQL
  $stmt = $pdo->query($sql);
} 
catch (Exception $e) {
  exit('Ocorreu uma falha: ' . $e->getMessage());
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <!-- 1: Tag de responsividade -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de clientes</title>

  <!-- 2: Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

  <style>
    body {
      padding-top: 2rem;
    }
  </style>
</head>

<body>

  <div class="container">
    <h3>Pacientes e suas informações</h3>
    <table class="table table-striped table-hover">
      <tr>
        <th>Código</th>
        <th>Paciente</th>
        <th>Peso</th>
        <th>Altura</th>
        <th>Tipo Sanguínio</th>
      </tr>

      <?php
      while ($row = $stmt->fetch()) {

        // Limpa os dados produzidos pelo usuário
        // com possibilidade de X S S
        $codigo = htmlspecialchars($row['codigo']);
        $nome = htmlspecialchars($row['nome']);
        $peso = htmlspecialchars($row['peso']);
        $altura = htmlspecialchars($row['altura']);
        $tipo_sang = htmlspecialchars($row['tipo_sang']);

        echo <<<HTML
          <tr>
            <td>$codigo</td>
            <td>$nome</td> 
            <td>$peso</td>
            <td>$altura</td>
            <td>$tipo_sang</td>
          </tr>      
        HTML;
      }
      ?>

    </table>
    <a href="../index.html">Menu de opções</a>
  </div>

</body>

</html>