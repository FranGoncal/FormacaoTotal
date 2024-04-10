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
    estaFechada BOOLEAN,      --Fechada/aberta
    dataFecho DATE,      --Data em que o docente pode fechar a formacao
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



INSERT INTO utilizador (username, nome, data_nasc, palavra_passe, nivel) VALUES
('aluno', 'aluno', '1990-01-01', 'ca0cd09a12abade3bf0777574d9f987f ', 'cliente'),
('docente', 'docente', '1992-02-02', 'ac99fecf6fcb8c25d18788d14a5384ee ', 'docente'),
('admin', 'admin', '1995-03-03', '21232f297a57a5a743894a0e4a801fc3 ', 'admin'),
('utilizador1', 'Utilizador 1', '1988-04-04', 'password1', 'cliente'),
('utilizador2', 'Utilizador 3', '1988-04-02', 'password2', 'cliente'),
('utilizador3', 'Utilizador 2', '1988-04-03', 'password3', 'cliente'),
('utilizador4', 'Utilizador 4', '1988-04-04', 'password4', 'cliente'),
('utilizador5', 'Utilizador 5', '1985-05-05', 'password5', 'cliente'),
('utilizador6', 'Utilizador 6', '1982-06-06', 'password6', 'cliente');

-- Insert para a formação HTML
INSERT INTO formacao (nome, num_maximo, username) VALUES
('Java', 50, 'docente'),
('PHP', 10, 'docente'),
('PHP2', 10, 'docente'),
('PHP3', 20, 'docente'),
('HTML', 20, 'docente');

-- Insert para a inscrição na formação HTML
INSERT INTO inscricao (username, nome, data_inscricao) VALUES
('aluno', 'HTML', CURDATE()),
('utilizador1', 'HTML', CURDATE()),
('utilizador2', 'HTML', CURDATE()),
('utilizador3', 'HTML', CURDATE()),
('utilizador4', 'HTML', CURDATE()),
('utilizador5', 'HTML', CURDATE()),
('utilizador6', 'HTML', CURDATE()),
('aluno', 'Java', CURDATE()),
('utilizador1', 'Java', CURDATE()),
('utilizador2', 'Java', CURDATE()),
('utilizador3', 'Java', CURDATE()),
('utilizador4', 'Java', CURDATE()),
('utilizador5', 'Java', CURDATE()),
('aluno', 'PHP', CURDATE()),
('utilizador1', 'PHP', CURDATE()),
('utilizador2', 'PHP', CURDATE()),
('utilizador3', 'PHP', CURDATE()),
('utilizador4', 'PHP', CURDATE()),
('aluno', 'PHP2', CURDATE()),
('utilizador1', 'PHP2', CURDATE()),
('utilizador2', 'PHP2', CURDATE()),
('aluno', 'PHP3', CURDATE());


