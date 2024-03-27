<?php

class Contato
{
  public $nome;
  public $cpf;
  public $email;
  public $senha;
  public $cep;
  public $endereco;
  public $bairro;
  public $cidade;
  public $estado;

  function __construct($nome, $cpf, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado)
  {
    $this->nome = $nome;
    $this->cpf = $cpf;
    $this->email = $email;
    $this->senha = $senha;
    $this->cep = $cep;
    $this->endereco = $endereco;
    $this->bairro = $bairro;
    $this->cidade = $cidade;
    $this->estado = $estado
  }

  public function AddToFile($arquivo)
  {
    // Abre o arquivo de texto para escrita de conteúdo no final
    $arq = fopen($arquivo, "a");

    // Neste exemplo os dados são armazenados de maneira simplificada,
    // no formato textual com campos separados por ponto-e-vírgula.
    fwrite($arq, "\n{$this->nome};{$this->cpf};{$this->email};{$this->senha};{$this->cep};{$this->endereco};{$this->bairro};{$this->cidade};{$this->estado}");

    // Fecha o arquivo de texto.
    fclose($arq); 
  }
}

// Carrega as informações dos contatos do arquivo de texto
// e retorna um array de objetos correspondente
function carregaContatosDeArquivo()
{
  $arrayContatos = null;
  
  // Abre o arquivo contatos.txt para leitura
  $arq = fopen("contatos.txt", "r");
  if ( !$arq )
    return null;

  // Le os dados do arquivo, linha por linha, e armazena no vetor $contatos
  while (!feof($arq)) {
    // fgets lê uma linha de texto do arquivo
    $contato = fgets($arq); 
    
    // Separa dados na linha utilizando o ';' como separador
    list($nome, $cpf, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado) = array_pad(explode(';', $contato), 9, null);

    // Cria novo objeto representado o contato e adiciona no final do array
    $novoContato = new Contato($nome, $cpf, $email, $senha, $cep, $endereco, $bairro, $cidade, $estado);
    $arrayContatos[] = $novoContato;
  }
      
  // Fecha o arquivo
  fclose($arq);  
  return $arrayContatos;
}

?>