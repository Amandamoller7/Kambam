create database KAMBAM;
use KAMBAM;

CREATE TABLE usuarios(
    id int PRIMARY KEY AUTO_INCREMENT,
    nome varchar(125) not null,
    email varchar (225) not null
    );
    
Create table tarefas(
    id int PRIMARY KEY AUTO_INCREMENT,
    descricao_tarefa varchar(550) not null,
    setor varchar(20) not null,
    prioridade varchar(5) not null,
    data_cadastro date not null,
    status_atividde varchar(20) not null,
    id_usuario int ,
    FOREIGN KEY (id_usuario)
    REFERENCES usuarios (id)
    );