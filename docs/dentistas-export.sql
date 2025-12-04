-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 03/12/2025 às 21:21
-- Versão do servidor: 10.11.14-MariaDB-cll-lve
-- Versão do PHP: 8.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dois8950_alinhadores`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `dentistas`
--

CREATE TABLE `dentistas` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cro` varchar(20) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(10) DEFAULT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `doc_cro` varchar(255) DEFAULT NULL,
  `doc_cpf` varchar(255) DEFAULT NULL,
  `doc_rg` varchar(255) DEFAULT NULL,
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `dentistas`
--

INSERT INTO `dentistas` (`id`, `nome`, `cro`, `cpf`, `telefone`, `whatsapp`, `especialidade`, `email`, `foto`, `observacoes`, `doc_cro`, `doc_cpf`, `doc_rg`, `status`, `criado_por`, `criado_em`, `atualizado_em`) VALUES
(3, 'Rafael de Andrade Dias', '12345654', '04459612526', '75988890006', '', '', 'rafaeldiaswebdev@gmail.com', NULL, '', NULL, NULL, NULL, 'ativo', 2, '2025-12-03 21:20:30', '2025-12-03 21:20:30');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `dentistas`
--
ALTER TABLE `dentistas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cro` (`cro`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `fk_criado_por` (`criado_por`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `dentistas`
--
ALTER TABLE `dentistas`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `dentistas`
--
ALTER TABLE `dentistas`
  ADD CONSTRAINT `fk_dentistas_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
