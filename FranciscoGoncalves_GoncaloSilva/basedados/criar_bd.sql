-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06-Maio-2024 às 14:57
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `formacao_total`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `formacao`
--
CREATE DATABASE formacao_total;
USE formacao_total;

CREATE TABLE `formacao` (
  `nome` varchar(40) NOT NULL,
  `num_maximo` int(11) DEFAULT NULL,
  `esta_fechada` tinyint(1) DEFAULT NULL,
  `criterio_selecao` varchar(40) DEFAULT NULL,
  `data_fecho` date DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  `descricao` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `formacao`
--

INSERT INTO `formacao` (`nome`, `num_maximo`, `esta_fechada`, `criterio_selecao`, `data_fecho`, `username`, `descricao`) VALUES
('Agricultura A', 3, 0, 'Ordem Alfabética', '2025-01-01', 'admin', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!'),
('HTML', 20, 0, 'Maior Idade', '2025-01-01', 'docente', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!'),
('Java', 10, 0, 'Data Inscrição', '2020-01-01', 'docente', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!'),
('PHP', 10, 0, 'Data Inscrição', '2022-01-01', 'docente', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!'),
('PHP2', 6, 0, 'Ordem Alfabética', '2023-01-01', 'docente', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!'),
('PHP3', 6, 0, 'Menor Idade', '2024-12-12', 'docente', 'Esta formação meramente para fins académicos destina-se aos alunos que tenham curiosidade na área da informática e que gostam deste estilo de conteudos. Considere a sua inscrição!');

-- --------------------------------------------------------

--
-- Estrutura da tabela `inscricao`
--

CREATE TABLE `inscricao` (
  `username` varchar(40) NOT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `nome` varchar(40) NOT NULL,
  `data_inscricao` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `inscricao`
--

INSERT INTO `inscricao` (`username`, `estado`, `nome`, `data_inscricao`) VALUES
('aluno', 'pendente', 'Agricultura A', '2024-05-06'),
('aluno', 'pendente', 'HTML', '2024-05-06'),
('aluno', 'pendente', 'Java', '2024-05-06'),
('aluno', 'pendente', 'PHP', '2024-05-06'),
('aluno', 'pendente', 'PHP2', '2024-05-06'),
('aluno', 'pendente', 'PHP3', '2024-05-06'),
('utilizador1', 'pendente', 'Agricultura A', '1999-05-10'),
('utilizador1', 'pendente', 'HTML', '1999-05-10'),
('utilizador1', 'pendente', 'Java', '2024-05-06'),
('utilizador1', 'pendente', 'PHP', '2024-05-06'),
('utilizador1', 'pendente', 'PHP2', '2024-05-06'),
('utilizador2', 'pendente', 'HTML', '2022-05-10'),
('utilizador2', 'pendente', 'Java', '2024-05-06'),
('utilizador2', 'pendente', 'PHP', '2024-05-06'),
('utilizador2', 'pendente', 'PHP2', '2024-05-06'),
('utilizador3', 'pendente', 'HTML', '2021-01-12'),
('utilizador3', 'pendente', 'Java', '2024-05-06'),
('utilizador3', 'pendente', 'PHP', '2024-05-06'),
('utilizador4', 'pendente', 'HTML', '2024-05-06'),
('utilizador4', 'pendente', 'Java', '2024-05-06'),
('utilizador4', 'pendente', 'PHP', '2024-05-06'),
('utilizador5', 'pendente', 'Agricultura A', '2001-02-12'),
('utilizador5', 'pendente', 'HTML', '2001-02-12'),
('utilizador5', 'pendente', 'Java', '2024-05-06'),
('utilizador6', 'pendente', 'Agricultura A', '2024-05-06'),
('utilizador6', 'pendente', 'HTML', '2001-01-12');

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `username` varchar(40) NOT NULL,
  `nome` varchar(40) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `palavra_passe` varchar(40) DEFAULT NULL,
  `nivel` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`username`, `nome`, `data_nasc`, `palavra_passe`, `nivel`) VALUES
('admin', 'admin', '1995-03-03', '21232f297a57a5a743894a0e4a801fc3 ', 'admin'),
('aluno', 'aluno', '1990-01-01', 'ca0cd09a12abade3bf0777574d9f987f ', 'aluno'),
('docente', 'docente', '1992-02-02', 'ac99fecf6fcb8c25d18788d14a5384ee ', 'docente'),
('utilizador1', 'Utilizador 1', '1988-04-04', 'password1', 'aluno'),
('utilizador2', 'Utilizador 2', '1988-04-02', 'password2', 'aluno'),
('utilizador3', 'Utilizador 3', '1988-04-03', 'password3', 'aluno'),
('utilizador4', 'Utilizador 4', '1988-04-04', 'password4', 'aluno'),
('utilizador5', 'Utilizador 5', '1985-05-05', 'password5', 'aluno'),
('utilizador6', 'Utilizador 6', '1982-06-06', 'password6', 'aluno');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `formacao`
--
ALTER TABLE `formacao`
  ADD PRIMARY KEY (`nome`),
  ADD KEY `username` (`username`);

--
-- Índices para tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD PRIMARY KEY (`username`,`nome`),
  ADD KEY `nome` (`nome`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`username`);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `formacao`
--
ALTER TABLE `formacao`
  ADD CONSTRAINT `formacao_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utilizador` (`username`);

--
-- Limitadores para a tabela `inscricao`
--
ALTER TABLE `inscricao`
  ADD CONSTRAINT `inscricao_ibfk_1` FOREIGN KEY (`username`) REFERENCES `utilizador` (`username`),
  ADD CONSTRAINT `inscricao_ibfk_2` FOREIGN KEY (`nome`) REFERENCES `formacao` (`nome`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
