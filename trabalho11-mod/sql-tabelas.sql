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
   email varchar(50) UNIQUE,
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
   nome varchar(50),
   marca varchar(50),
   descricao varchar(100)
) ENGINE=InnoDB;

DROP TABLE IF EXISTS agenda;
DROP TABLE IF EXISTS paciente;
DROP TABLE IF EXISTS medico;
DROP TABLE IF EXISTS funcionario;
DROP TABLE IF EXISTS pessoa;

CREATE TABLE pessoa
(
   codigo int PRIMARY KEY auto_increment,
   nome varchar(50),
   sexo varchar(50),
   email varchar(50) UNIQUE,
   telefone varchar(50),
   cep char(10),
   logradouro varchar(100),
   cidade varchar(50),
   estado varchar(50)
) ENGINE=InnoDB;

CREATE TABLE funcionario
(
   data_contrato date,
   salario DECIMAL(10, 2),
   senha_hash varchar(50),
   codigo int NOT NULL,
   FOREIGN KEY(codigo) REFERENCES pessoa(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE medico
(
   especialidade varchar(50),
   crm varchar(50) UNIQUE,
   codigo int NOT NULL,
   FOREIGN KEY(codigo) REFERENCES funcionario(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE paciente
(
   peso DECIMAL(5, 2),
   altura int,
   tipo_sanguineo varchar(5),
   codigo int NOT NULL,
   FOREIGN KEY(codigo) REFERENCES pessoa(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE agenda
(
   codigo int PRIMARY KEY,
   data_agendamento date,
   horario time,
   nome varchar(50),
   sexo varchar(50),
   email varchar(100),
   codigo_medico int NOT NULL,
   FOREIGN KEY(codigo_medico) REFERENCES medico(codigo) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO aluno VALUES ("Fulano", "123");
INSERT INTO aluno VALUES ("Ciclano", "456");
