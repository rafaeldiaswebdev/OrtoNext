-- ============================================
-- SQL: Seed para Teste de Pacientes
-- Autor: Rafael Dias - doisr.com.br
-- Data: 03/12/2025
-- ============================================

-- Limpar dados de teste anteriores (CUIDADO!)
-- DELETE FROM dentista_clinica WHERE clinica_id = 3;

-- Inserir vínculo entre dentista e clínica
-- Assumindo que existe dentista com ID 4 e clínica com ID 3
INSERT INTO `dentista_clinica` (`dentista_id`, `clinica_id`, `criado_em`)
VALUES
(4, 3, NOW())
ON DUPLICATE KEY UPDATE criado_em = NOW();

-- Verificar vínculos
SELECT
    d.id,
    d.nome as dentista_nome,
    d.status,
    c.id as clinica_id,
    c.nome as clinica_nome,
    dc.criado_em as vinculado_em
FROM dentistas d
JOIN dentista_clinica dc ON dc.dentista_id = d.id
JOIN clinicas c ON c.id = dc.clinica_id
WHERE c.id = 3;
