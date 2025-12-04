-- ============================================
-- SQL: Tabelas de Dentistas
-- Autor: Rafael Dias - doisr.com.br
-- Data: 03/12/2025
-- ============================================

-- Tabela de Dentistas
CREATE TABLE IF NOT EXISTS `dentistas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cro` varchar(20) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=Ativo, 0=Inativo',
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL,
  `atualizado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cro` (`cro`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `idx_status` (`status`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_dentistas_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Relacionamento Dentista x Clínica (N:N)
CREATE TABLE IF NOT EXISTS `dentista_clinica` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,
  `criado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_vinculo` (`dentista_id`, `clinica_id`),
  KEY `fk_dentista` (`dentista_id`),
  KEY `fk_clinica` (`clinica_id`),
  CONSTRAINT `fk_dc_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_dc_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
