-- ============================================
-- SQL: Tabelas de Pedidos
-- Autor: Rafael Dias - doisr.com.br
-- Data: 03/12/2025
-- ============================================

-- Tabela de Pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(20) NOT NULL COMMENT 'Gerado automaticamente',

  -- Vínculos
  `paciente_id` int(11) UNSIGNED NOT NULL,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,

  -- Tipo de Pedido
  `tipo_pedido` enum('complete','self_guard','you_plan','print_3d','self_plan') NOT NULL,

  -- Status
  `status` enum('rascunho','enviado','em_analise','em_producao','concluido','cancelado') DEFAULT 'rascunho',

  -- Observações
  `observacoes_planejamento` text DEFAULT NULL,

  -- Campos Clínicos (JSON para flexibilidade)
  `dados_clinicos` text DEFAULT NULL COMMENT 'JSON com campos dinâmicos por tipo',

  -- Auditoria
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_pedido` (`numero_pedido`),
  KEY `idx_paciente` (`paciente_id`),
  KEY `idx_dentista` (`dentista_id`),
  KEY `idx_clinica` (`clinica_id`),
  KEY `idx_status` (`status`),
  KEY `idx_tipo` (`tipo_pedido`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_pedidos_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Arquivos de Pedidos
CREATE TABLE IF NOT EXISTS `pedido_arquivos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) UNSIGNED NOT NULL,
  `tipo_arquivo` enum('escaneamento','documento','imagem','stl','outro') NOT NULL,
  `nome_original` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `caminho` varchar(500) NOT NULL,
  `tamanho` int(11) DEFAULT NULL COMMENT 'Tamanho em bytes',
  `mime_type` varchar(100) DEFAULT NULL,

  -- Auditoria
  `enviado_por` int(11) UNSIGNED DEFAULT NULL,
  `enviado_em` datetime NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `fk_enviado_por` (`enviado_por`),
  CONSTRAINT `fk_arquivos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_arquivos_usuario` FOREIGN KEY (`enviado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Timeline de Pedidos
CREATE TABLE IF NOT EXISTS `pedido_timeline` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) UNSIGNED NOT NULL,
  `tipo_evento` enum('criacao','envio','revisao','aprovacao','producao','entrega','comentario','alteracao','cancelamento') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `dados_adicionais` text DEFAULT NULL COMMENT 'JSON com dados extras',

  -- Autor
  `usuario_id` int(11) UNSIGNED DEFAULT NULL,
  `autor_tipo` enum('sistema','usuario','dentista','clinica') DEFAULT 'usuario',

  -- Data
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_tipo` (`tipo_evento`),
  KEY `idx_data` (`criado_em`),
  CONSTRAINT `fk_timeline_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timeline_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
