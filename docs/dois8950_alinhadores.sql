-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 03/12/2025 às 15:21
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
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id` int(11) UNSIGNED NOT NULL,
  `chave` varchar(100) NOT NULL,
  `valor` text DEFAULT NULL,
  `tipo` enum('texto','numero','booleano','json','arquivo') DEFAULT 'texto',
  `grupo` varchar(50) DEFAULT 'geral' COMMENT 'Agrupa configurações (geral, smtp, notificacoes)',
  `descricao` varchar(255) DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`id`, `chave`, `valor`, `tipo`, `grupo`, `descricao`, `criado_em`, `atualizado_em`) VALUES
(1, 'sistema_nome', 'OrtoNext', 'texto', 'geral', 'Nome do sistema', '2025-11-17 01:23:44', '2025-11-17 01:23:45'),
(2, 'sistema_email', 'contato@sistema.com.br', 'texto', 'geral', 'E-mail principal do sistema', '2025-11-17 01:23:44', NULL),
(3, 'sistema_telefone', '', 'texto', 'geral', 'Telefone de contato', '2025-11-17 01:23:44', NULL),
(4, 'sistema_endereco', '', 'texto', 'geral', 'Endereço completo', '2025-11-17 01:23:44', NULL),
(5, 'sistema_logo', '', 'arquivo', 'geral', 'Logo do sistema', '2025-11-17 01:23:44', NULL),
(6, 'sistema_favicon', '', 'arquivo', 'geral', 'Favicon do sistema', '2025-11-17 01:23:44', NULL),
(7, 'smtp_ativo', '0', 'booleano', 'smtp', 'Ativar envio de e-mails via SMTP', '2025-11-17 01:23:44', NULL),
(8, 'smtp_host', '', 'texto', 'smtp', 'Servidor SMTP (ex: smtp.gmail.com)', '2025-11-17 01:23:44', NULL),
(9, 'smtp_porta', '587', 'numero', 'smtp', 'Porta SMTP (587 para TLS, 465 para SSL)', '2025-11-17 01:23:44', NULL),
(10, 'smtp_usuario', '', 'texto', 'smtp', 'Usuário SMTP (e-mail)', '2025-11-17 01:23:44', NULL),
(11, 'smtp_senha', '', 'texto', 'smtp', 'Senha SMTP', '2025-11-17 01:23:44', NULL),
(12, 'smtp_seguranca', 'tls', 'texto', 'smtp', 'Tipo de segurança (tls ou ssl)', '2025-11-17 01:23:44', NULL),
(13, 'smtp_remetente_email', '', 'texto', 'smtp', 'E-mail do remetente', '2025-11-17 01:23:44', NULL),
(14, 'smtp_remetente_nome', '', 'texto', 'smtp', 'Nome do remetente', '2025-11-17 01:23:44', NULL),
(15, 'notif_email_ativo', '1', 'booleano', 'notificacoes', 'Enviar notificações por e-mail', '2025-11-17 01:23:44', NULL),
(16, 'notif_email_destinatario', '', 'texto', 'notificacoes', 'E-mail para receber notificações do sistema', '2025-11-17 01:23:44', NULL),
(17, 'notif_sistema_som', '1', 'booleano', 'notificacoes', 'Ativar som nas notificações do sistema', '2025-11-17 01:23:44', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED DEFAULT NULL,
  `acao` varchar(100) NOT NULL COMMENT 'Tipo de ação (login, logout, criar, editar, excluir)',
  `tabela` varchar(50) DEFAULT NULL COMMENT 'Tabela afetada pela ação',
  `registro_id` int(11) DEFAULT NULL COMMENT 'ID do registro afetado',
  `dados_antigos` text DEFAULT NULL COMMENT 'JSON com dados antes da alteração',
  `dados_novos` text DEFAULT NULL COMMENT 'JSON com dados após a alteração',
  `ip` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `logs`
--

INSERT INTO `logs` (`id`, `usuario_id`, `acao`, `tabela`, `registro_id`, `dados_antigos`, `dados_novos`, `ip`, `user_agent`, `criado_em`) VALUES
(1, 2, 'login', 'usuarios', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 22:24:59'),
(2, 2, 'logout', 'usuarios', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-11-16 22:44:32'),
(3, 2, 'login', 'usuarios', 2, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', '2025-12-03 14:47:30');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacoes`
--

CREATE TABLE `notificacoes` (
  `id` int(11) UNSIGNED NOT NULL,
  `usuario_id` int(11) UNSIGNED DEFAULT NULL COMMENT 'NULL = notificação para todos',
  `tipo` enum('info','sucesso','aviso','erro') DEFAULT 'info',
  `titulo` varchar(255) NOT NULL,
  `mensagem` text NOT NULL,
  `link` varchar(255) DEFAULT NULL COMMENT 'Link para ação relacionada',
  `lida` tinyint(1) DEFAULT 0,
  `data_leitura` datetime DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `nivel` enum('admin','usuario') DEFAULT 'usuario' COMMENT 'Nível de acesso do usuário',
  `status` enum('ativo','inativo') DEFAULT 'ativo',
  `ultimo_acesso` datetime DEFAULT NULL,
  `token_recuperacao` varchar(100) DEFAULT NULL COMMENT 'Token para recuperação de senha',
  `token_expiracao` datetime DEFAULT NULL COMMENT 'Data de expiração do token',
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `avatar`, `nivel`, `status`, `ultimo_acesso`, `token_recuperacao`, `token_expiracao`, `criado_em`, `atualizado_em`) VALUES
(2, 'Rafael de Andrade Dias', 'rafaeldiaswebdev@gmail.com', '$2y$10$45WDJ/hGu4NmT5dKQEr.2Ohrec1f4gzz2dmcNkG7.UWy9ezMcob5m', NULL, NULL, 'admin', 'ativo', '2025-12-03 14:47:30', NULL, NULL, '2025-11-17 01:23:44', '2025-12-03 14:47:29');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `chave` (`chave`),
  ADD KEY `idx_grupo` (`grupo`);

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`usuario_id`),
  ADD KEY `idx_acao` (`acao`),
  ADD KEY `idx_tabela` (`tabela`),
  ADD KEY `idx_criado_em` (`criado_em`);

--
-- Índices de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario` (`usuario_id`),
  ADD KEY `idx_lida` (`lida`),
  ADD KEY `idx_criado_em` (`criado_em`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_nivel` (`nivel`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `notificacoes`
--
ALTER TABLE `notificacoes`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `fk_logs_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `notificacoes`
--
ALTER TABLE `notificacoes`
  ADD CONSTRAINT `fk_notificacoes_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
