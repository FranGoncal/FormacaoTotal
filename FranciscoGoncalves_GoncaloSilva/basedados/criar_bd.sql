--Codigo criação da BD
DROP DATABASE IF EXISTS FORMACAO_TOTAL;
CREATE DATABASE FORMACAO_TOTAL;
USE FORMACAO_TOTAL;

CREATE TABLE utilizador(
    username VARCHAR(40) PRIMARY KEY,
    nome VARCHAR(40),
    data_nasc DATE,
    palavra_passe VARCHAR(40),
    nivel   VARCHAR(40)
);

CREATE TABLE formacao(
    nome VARCHAR(40) PRIMARY KEY,
    num_maximo INT,
    username VARCHAR(40),
    FOREIGN KEY(username) REFERENCES utilizador(username)
);

CREATE TABLE inscricao(
    username VARCHAR(40),
    nome VARCHAR(40),
    data_inscricao DATE,
    FOREIGN KEY(username) REFERENCES utilizador(username),
    FOREIGN KEY(nome) REFERENCES formacao(nome)
);


ALTER TABLE inscricao ADD CONSTRAINT PK_inscricao PRIMARY KEY(username, nome);



