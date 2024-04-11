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
    esta_fechada BOOLEAN,
    criterio_selecao VARCHAR(40),
    data_fecho DATE,
    username VARCHAR(40),
    FOREIGN KEY(username) REFERENCES utilizador(username)
);

CREATE TABLE inscricao(
    username VARCHAR(40),
    estado VARCHAR(40),
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

INSERT INTO formacao (nome, num_maximo, esta_fechada, criterio_selecao, data_Fecho, username) VALUES
('Java', 50, false, "data_inscricao", "2025-01-01", 'docente'),
('PHP', 10, false, "data_inscricao", "2025-01-01", 'docente'),
('PHP2', 10, false, "data_inscricao", "2025-01-01", 'docente'),
('PHP3', 20, false, "data_inscricao", "2025-01-01", 'docente'),
('HTML', 20, false, "data_inscricao", "2025-01-01", 'docente');

INSERT INTO inscricao (username, estado, nome, data_inscricao) VALUES
('aluno', 'aceite','HTML', CURDATE()),
('utilizador1','aceite', 'HTML', CURDATE()),
('utilizador2','aceite', 'HTML', CURDATE()),
('utilizador3','aceite', 'HTML', CURDATE()),
('utilizador4','aceite', 'HTML', CURDATE()),
('utilizador5','aceite', 'HTML', CURDATE()),
('utilizador6','aceite', 'HTML', CURDATE()),
('aluno','aceite', 'Java', CURDATE()),
('utilizador1','aceite', 'Java', CURDATE()),
('utilizador2','aceite', 'Java', CURDATE()),
('utilizador3','aceite', 'Java', CURDATE()),
('utilizador4','aceite', 'Java', CURDATE()),
('utilizador5','aceite', 'Java', CURDATE()),
('aluno','aceite', 'PHP', CURDATE()),
('utilizador1','aceite', 'PHP', CURDATE()),
('utilizador2','aceite', 'PHP', CURDATE()),
('utilizador3','aceite', 'PHP', CURDATE()),
('utilizador4','aceite', 'PHP', CURDATE()),
('aluno','aceite', 'PHP2', CURDATE()),
('utilizador1','aceite', 'PHP2', CURDATE()),
('utilizador2','aceite', 'PHP2', CURDATE()),
('aluno','aceite', 'PHP3', CURDATE());