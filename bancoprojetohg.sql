-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2026 às 22:27
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `bancoprojetohg`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `ledhigor`
--

CREATE TABLE `ledhigor` (
  `idledhigor` int(10) UNSIGNED NOT NULL,
  `pinor` int(10) UNSIGNED DEFAULT NULL,
  `pinog` int(10) UNSIGNED DEFAULT NULL,
  `pinob` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ledhigor`
--

INSERT INTO `ledhigor` (`idledhigor`, `pinor`, `pinog`, `pinob`) VALUES
(1, 5, 6, 7),
(2, 10, 11, 12);

-- --------------------------------------------------------

--
-- Estrutura para tabela `machigor`
--

CREATE TABLE `machigor` (
  `idmachigor` varchar(17) NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `ativo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `machigor`
--

INSERT INTO `machigor` (`idmachigor`, `nome`, `ativo`) VALUES
('38:2B:78:03:A8:38', 'placa 1', 1),
('BC:DD:C2:56:8B:1D', 'placa 2', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `painelhigor`
--

CREATE TABLE `painelhigor` (
  `idpainelhigor` int(10) UNSIGNED NOT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `datainicio` datetime DEFAULT NULL,
  `datafim` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `painelhigor`
--

INSERT INTO `painelhigor` (`idpainelhigor`, `nome`, `datainicio`, `datafim`) VALUES
(1, 'Painel RGB 18/09', '2026-09-18 00:00:00', '2026-09-18 23:59:59'),
(2, 'Painel RGB 24/09', '2026-09-24 00:00:00', '2026-09-24 23:59:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `painelhigor_has_machigor`
--

CREATE TABLE `painelhigor_has_machigor` (
  `painelhigor_idpainelhigor` int(10) UNSIGNED NOT NULL,
  `machigor_idmachigor` varchar(17) NOT NULL,
  `ledhigor_idledhigor` int(10) UNSIGNED NOT NULL,
  `ledr` int(10) UNSIGNED DEFAULT NULL,
  `ledg` int(10) UNSIGNED DEFAULT NULL,
  `ledb` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `painelhigor_has_machigor`
--

INSERT INTO `painelhigor_has_machigor` (`painelhigor_idpainelhigor`, `machigor_idmachigor`, `ledhigor_idledhigor`, `ledr`, `ledg`, `ledb`) VALUES
(1, '38:2B:78:03:A8:38', 1, 255, 0, 0),
(1, 'BC:DD:C2:56:8B:1D', 1, 0, 255, 0),
(2, '38:2B:78:03:A8:38', 1, 0, 0, 255),
(2, 'BC:DD:C2:56:8B:1D', 1, 0, 0, 255);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `ledhigor`
--
ALTER TABLE `ledhigor`
  ADD PRIMARY KEY (`idledhigor`);

--
-- Índices de tabela `machigor`
--
ALTER TABLE `machigor`
  ADD PRIMARY KEY (`idmachigor`);

--
-- Índices de tabela `painelhigor`
--
ALTER TABLE `painelhigor`
  ADD PRIMARY KEY (`idpainelhigor`);

--
-- Índices de tabela `painelhigor_has_machigor`
--
ALTER TABLE `painelhigor_has_machigor`
  ADD PRIMARY KEY (`painelhigor_idpainelhigor`,`machigor_idmachigor`),
  ADD KEY `painelhigor_has_machigor_FKIndex1` (`painelhigor_idpainelhigor`),
  ADD KEY `painelhigor_has_machigor_FKIndex2` (`machigor_idmachigor`),
  ADD KEY `painelhigor_has_machigor_FKIndex3` (`ledhigor_idledhigor`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `ledhigor`
--
ALTER TABLE `ledhigor`
  MODIFY `idledhigor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `painelhigor`
--
ALTER TABLE `painelhigor`
  MODIFY `idpainelhigor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `painelhigor_has_machigor`
--
ALTER TABLE `painelhigor_has_machigor`
  ADD CONSTRAINT `painelhigor_has_machigor_ibfk_1` FOREIGN KEY (`painelhigor_idpainelhigor`) REFERENCES `painelhigor` (`idpainelhigor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `painelhigor_has_machigor_ibfk_2` FOREIGN KEY (`machigor_idmachigor`) REFERENCES `machigor` (`idmachigor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `painelhigor_has_machigor_ibfk_3` FOREIGN KEY (`ledhigor_idledhigor`) REFERENCES `ledhigor` (`idledhigor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
