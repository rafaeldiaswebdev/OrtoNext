-- ============================================
-- SQL: Tabela de Pacientes
-- Autor: Rafael Dias - doisr.com.br
-- Data: 03/12/2025
-- ============================================

-- Tabela de Pacientes
CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `observacoes` text DEFAULT NULL,
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `idx_clinica` (`clinica_id`),
  KEY `idx_dentista` (`dentista_id`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_pacientes_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pacientes_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pacientes_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
