-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Maio-2020 às 17:56
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
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`) VALUES
(1, 'israel italo bernardo cabral silva', 'israelitalo2012@gmail.com', '$2y$10$00aRgOrhT2kHIrvOJdUSvu.e21q9ls0i6sQN4iA4g/AXpjDANmDA6'),
(2, 'nataly costa mendes', 'natalymendes@gmail.com', '$2y$10$fhWSc0UtN.DOCaetMHlCJe8XSBPWj8NYdmYG7zHR9jCQDOt7ufygq'),
(3, 'fatima cabral', 'fatimacabral@gmail.com', '$2y$10$eWbfRl5dBHo0QtWGci2cxOPsg8c.7KIHu/pkoobkq6uY4tL3kKT6W'),
(4, 'isaias joaquim', 'isaiasjoaquim@gmail.com', '$2y$10$QgEMQ27CujSZPwdT8z5iwOXZhSkfxYxYk0o0k2OI2oWo1BULc4Haq'),
(7, 'teste excluir', 'testeexcluir@gmail.com', '$2y$10$WFYtXidkeHwC0tLkBeXO0uQm.faY7dTHc3EiVzKcb7c440Ed6LHSy');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
