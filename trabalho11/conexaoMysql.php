<?php

function mysqlConnect()
{
  $db_host = "sql108.infinityfree.com";
  $db_username = "if0_35764487";
  $db_password = "2RXLHvu12KDa2k";
  $db_name = "if0_35764487_isabelli";

  $options = [
    PDO::ATTR_EMULATE_PREPARES => false, // desativa a execução emulada de prepared statements
  ];

  try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_username, $db_password, $options);
    return $pdo;
  } 
  catch (Exception $e) {
    exit('Ocorreu uma falha na conexão com o MySQL: ' . $e->getMessage());
  }
}
?>
