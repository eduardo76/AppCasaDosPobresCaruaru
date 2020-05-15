-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Maio-2020 às 00:27
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `casadospobres`
--
CREATE DATABASE IF NOT EXISTS `casadospobres` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `casadospobres`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento_doacao`
--

CREATE TABLE `agendamento_doacao` (
  `id_agendamento` int(11) NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `id_doador` int(11) NOT NULL,
  `quantidade` int(5) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `hora` varchar(10) DEFAULT NULL,
  `lugar` varchar(255) DEFAULT NULL,
  `id_tipo_doacao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONAMENTOS PARA TABELAS `agendamento_doacao`:
--   `id_tipo_doacao`
--       `tipo_da_doacao` -> `id_tipo_doacao`
--   `id_doador`
--       `doador` -> `id`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `doacao_financeira`
--

CREATE TABLE `doacao_financeira` (
  `id_financeiro` int(11) NOT NULL,
  `id_tipo_doacao` int(11) DEFAULT NULL,
  `id_transacao` int(11) DEFAULT NULL,
  `id_doador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONAMENTOS PARA TABELAS `doacao_financeira`:
--   `id_tipo_doacao`
--       `tipo_da_doacao` -> `id_tipo_doacao`
--   `id_transacao`
--       `tipo_transacao` -> `id_transacao`
--   `id_doador`
--       `doador` -> `id`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `doador`
--

CREATE TABLE `doador` (
  `id` int(11) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONAMENTOS PARA TABELAS `doador`:
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_da_doacao`
--

CREATE TABLE `tipo_da_doacao` (
  `id_tipo_doacao` int(11) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONAMENTOS PARA TABELAS `tipo_da_doacao`:
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_transacao`
--

CREATE TABLE `tipo_transacao` (
  `id_transacao` int(11) NOT NULL,
  `descricao` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELACIONAMENTOS PARA TABELAS `tipo_transacao`:
--

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `agendamento_doacao`
--
ALTER TABLE `agendamento_doacao`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `FK_Agendamento_Tipo_da_doacao` (`id_tipo_doacao`),
  ADD KEY `fk_id_doador_doador_agendamento` (`id_doador`);

--
-- Índices para tabela `doacao_financeira`
--
ALTER TABLE `doacao_financeira`
  ADD PRIMARY KEY (`id_financeiro`),
  ADD KEY `FK_Financeiro_Tipo_da_doacao` (`id_tipo_doacao`),
  ADD KEY `FK_Financeiro_Transacao` (`id_transacao`),
  ADD KEY `fk_id_doador_financeiro` (`id_doador`);

--
-- Índices para tabela `doador`
--
ALTER TABLE `doador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `tipo_da_doacao`
--
ALTER TABLE `tipo_da_doacao`
  ADD PRIMARY KEY (`id_tipo_doacao`);

--
-- Índices para tabela `tipo_transacao`
--
ALTER TABLE `tipo_transacao`
  ADD PRIMARY KEY (`id_transacao`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamento_doacao`
--
ALTER TABLE `agendamento_doacao`
  MODIFY `id_agendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `doacao_financeira`
--
ALTER TABLE `doacao_financeira`
  MODIFY `id_financeiro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `doador`
--
ALTER TABLE `doador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_da_doacao`
--
ALTER TABLE `tipo_da_doacao`
  MODIFY `id_tipo_doacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tipo_transacao`
--
ALTER TABLE `tipo_transacao`
  MODIFY `id_transacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `agendamento_doacao`
--
ALTER TABLE `agendamento_doacao`
  ADD CONSTRAINT `FK_Agendamento_Tipo_da_doacao` FOREIGN KEY (`id_tipo_doacao`) REFERENCES `tipo_da_doacao` (`id_tipo_doacao`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_doador_doador_agendamento` FOREIGN KEY (`id_doador`) REFERENCES `doador` (`id`) ON UPDATE CASCADE;

--
-- Limitadores para a tabela `doacao_financeira`
--
ALTER TABLE `doacao_financeira`
  ADD CONSTRAINT `FK_Financeiro_Tipo_da_doacao` FOREIGN KEY (`id_tipo_doacao`) REFERENCES `tipo_da_doacao` (`id_tipo_doacao`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_Financeiro_Transacao` FOREIGN KEY (`id_transacao`) REFERENCES `tipo_transacao` (`id_transacao`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id_doador_financeiro` FOREIGN KEY (`id_doador`) REFERENCES `doador` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
