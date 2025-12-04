<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Novo Pedido</div>
                <h2 class="page-title">
                    <i class="ti ti-file-plus me-2"></i>
                    Etapa 3 de 3 - Dados do Pedido
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <form method="post" action="<?= base_url('admin/pedidos/salvar_pedido') ?>" enctype="multipart/form-data">

            <input type="hidden" name="paciente_id" value="<?= $paciente->id ?>">
            <input type="hidden" name="tipo_pedido" value="<?= $tipo_pedido ?>">

            <!-- Progresso -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="steps steps-blue steps-counter">
                        <div class="step-item">
                            <div class="h4 m-0">Paciente</div>
                        </div>
                        <div class="step-item">
                            <div class="h4 m-0">Tipo de Pedido</div>
                        </div>
                        <div class="step-item active">
                            <div class="h4 m-0">Dados do Pedido</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumo -->
            <div class="card mb-3">
                <div class="card-header bg-primary-lt">
                    <h3 class="card-title">Resumo do Pedido</h3>
                    <div class="card-actions">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-arrow-left me-1"></i>
                            Trocar Tipo
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Paciente:</strong> <?= $paciente->nome ?><br>
                            <strong>CPF:</strong> <?= $paciente->cpf ?>
                        </div>
                        <div class="col-md-6">
                            <strong>Tipo de Pedido:</strong>
                            <span class="badge bg-primary"><?= $tipos_pedido[$tipo_pedido] ?></span><br>
                            <strong>Clínica:</strong> <?= $paciente->clinica_nome ?><br>
                            <strong>Dentista:</strong> <?= $paciente->dentista_nome ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Observações de Planejamento -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Observações de Planejamento</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Observações e Instruções Especiais</label>
                        <textarea class="form-control" name="observacoes_planejamento" rows="6" placeholder="Descreva detalhes importantes sobre o caso, objetivos do tratamento, restrições, etc."></textarea>
                        <small class="form-hint">Informações que ajudarão no planejamento e produção do pedido</small>
                    </div>
                </div>
            </div>

            <!-- Campos Específicos por Tipo -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Dados Clínicos - <?= $tipos_pedido[$tipo_pedido] ?></h3>
                </div>
                <div class="card-body">

                    <?php if ($tipo_pedido == 'complete'): ?>
                        <!-- Campos para Complete -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Classificação de Angle</label>
                                    <select class="form-select" name="dados_clinicos[classificacao_angle]">
                                        <option value="">Selecione...</option>
                                        <option value="classe_i">Classe I</option>
                                        <option value="classe_ii_div1">Classe II Divisão 1</option>
                                        <option value="classe_ii_div2">Classe II Divisão 2</option>
                                        <option value="classe_iii">Classe III</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Overjet (mm)</label>
                                    <input type="number" class="form-control" name="dados_clinicos[overjet]" step="0.1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Overbite (mm)</label>
                                    <input type="number" class="form-control" name="dados_clinicos[overbite]" step="0.1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Linha Média Superior (mm)</label>
                                    <input type="number" class="form-control" name="dados_clinicos[linha_media_superior]" step="0.1">
                                </div>
                            </div>
                        </div>

                    <?php elseif ($tipo_pedido == 'self_guard'): ?>
                        <!-- Campos para Self Guard -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Contenção</label>
                                    <select class="form-select" name="dados_clinicos[tipo_contencao]">
                                        <option value="">Selecione...</option>
                                        <option value="superior">Superior</option>
                                        <option value="inferior">Inferior</option>
                                        <option value="ambos">Ambos (Superior e Inferior)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Material</label>
                                    <select class="form-select" name="dados_clinicos[material]">
                                        <option value="">Selecione...</option>
                                        <option value="petg">PETG</option>
                                        <option value="eva">EVA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    <?php elseif ($tipo_pedido == 'you_plan'): ?>
                        <!-- Campos para You Plan -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Número de Alinhadores</label>
                                    <input type="number" class="form-control" name="dados_clinicos[numero_alinhadores]" min="1">
                                </div>
                            </div>
                        </div>

                    <?php elseif ($tipo_pedido == 'print_3d'): ?>
                        <!-- Campos para Print 3D -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Modelo</label>
                                    <select class="form-select" name="dados_clinicos[tipo_modelo]">
                                        <option value="">Selecione...</option>
                                        <option value="diagnostico">Diagnóstico</option>
                                        <option value="trabalho">Trabalho</option>
                                        <option value="setup">Setup</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Quantidade</label>
                                    <input type="number" class="form-control" name="dados_clinicos[quantidade]" min="1" value="1">
                                </div>
                            </div>
                        </div>

                    <?php else: ?>
                        <!-- Campos para Self Plan -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <i class="ti ti-info-circle me-2"></i>
                                    Você fará o planejamento. Anexe os arquivos necessários abaixo.
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Upload de Arquivos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Arquivos do Pedido</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Tipo de Arquivo</label>
                        <select class="form-select mb-2" id="tipo_arquivo">
                            <option value="escaneamento">Escaneamento Intraoral (STL)</option>
                            <option value="documento">Documento (PDF)</option>
                            <option value="imagem">Imagem (JPG/PNG)</option>
                            <option value="stl">Arquivo STL</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="arquivo_upload" multiple>
                        <small class="form-hint">Formatos aceitos: JPG, PNG, PDF, STL, OBJ, ZIP. Máximo 10MB por arquivo.</small>
                    </div>
                    <div id="lista_arquivos" class="mt-3"></div>
                </div>
            </div>

            <!-- Botões -->
            <div class="card">
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-link">
                            Cancelar
                        </a>
                        <button type="submit" name="status" value="rascunho" class="btn btn-secondary ms-auto me-2">
                            <i class="ti ti-file me-2"></i>
                            Salvar como Rascunho
                        </button>
                        <button type="submit" name="status" value="enviado" class="btn btn-primary">
                            <i class="ti ti-send me-2"></i>
                            Enviar Pedido
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<?php ob_start(); ?>
<script>
// Upload de arquivos (placeholder - implementar depois)
document.getElementById('arquivo_upload').addEventListener('change', function() {
    var arquivos = this.files;
    var lista = document.getElementById('lista_arquivos');

    if (arquivos.length > 0) {
        lista.innerHTML = '<div class="alert alert-info">Arquivos selecionados: ' + arquivos.length + '</div>';
    }
});
</script>
<?php $scripts = ob_get_clean(); ?>
