CREATE TABLE aluno
(
   nome varchar(50),
   telefone varchar(50)
) ENGINE=InnoDB;

CREATE TABLE cliente
(
   id int PRIMARY KEY auto_increment,
   nome varchar(50),
   cpf char(14) UNIQUE,
   email varchar(50),
   hash_senha varchar(255),
   data_nascimento date,
   estado_civil varchar(30),
   altura int
) ENGINE=InnoDB;

CREATE TABLE endereco_cliente
(
   id int PRIMARY KEY auto_increment,
   cep char(10),
   endereco varchar(100),
   bairro varchar(50),
   cidade varchar(50),
   id_cliente int not null,
   FOREIGN KEY (id_cliente) REFERENCES cliente(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE produto
(
   id int PRIMARY KEY auto_increment,  
   nome char(20),
   marca char(20),
   descricao char(50)
) ENGINE=InnoDB;


CREATE TABLE pessoa
(
   codigo int PRIMARY KEY auto_increment,
   nome varchar(50),
   cpf char(14),
   email varchar(50),
   telefone varchar(50),
   sexo varchar(50),
   cep char(10),
   logradouro varchar(100),
   estado varchar(50),
   cidade varchar(50)
) ENGINE=InnoDB;

CREATE TABLE base_endereco
(
   cep char(10),
   logradouro varchar(100),
   estado varchar(50),
   cidade varchar(50)
) ENGINE=InnoDB;


CREATE TABLE funcionario
(
   codigo int PRIMARY KEY not null,
   FOREIGN KEY (codigo) REFERENCES pessoa(codigo),
   data_contrato date,
   hash_senha varchar(255),
   salario float
) ENGINE=InnoDB;

CREATE TABLE paciente
(
   cod_pac int PRIMARY KEY not null,
   FOREIGN KEY (codigo) REFERENCES pessoa(codigo), 
   altura int,
   peso float,
   tipo_sang varchar(5)
) ENGINE=InnoDB;

CREATE TABLE medico
(
   codigo int PRIMARY KEY not null,
   FOREIGN KEY (codigo) REFERENCES funcionario(codigo), 
   especialidade varchar(100),
   crm varchar(50)
) ENGINE=InnoDB;


CREATE TABLE agenda
(
   codigo int PRIMARY KEY auto_increment,
   data_agenda date,
   horario_agenda time,
   nome varchar(50),
   sexo varchar(50),
   email varchar(50),
   cod_med int not null,
   FOREIGN KEY (cod_med) REFERENCES medico(codigo) 
) ENGINE=InnoDB;


INSERT INTO aluno VALUES ("Fulano", "123");
INSERT INTO aluno VALUES ("Ciclano", "456");
