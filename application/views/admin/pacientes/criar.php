<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-users me-2"></i>
                    Novo Paciente
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <?php if (!$clinica_selecionada): ?>
            <!-- ETAPA 1: Selecionar Clínica -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Etapa 1 de 2 - Selecione a Clínica</h3>
                </div>
                <div class="card-body">
                    <form method="get" action="<?= base_url('admin/pacientes/criar') ?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label class="form-label required">Clínica</label>
                                    <select class="form-select" name="clinica_id" required>
                                        <option value="">Selecione a clínica...</option>
                                        <?php foreach ($clinicas as $clinica): ?>
                                            <option value="<?= $clinica->id ?>">
                                                <?= $clinica->nome ?> - <?= $clinica->cidade ?> / <?= $clinica->estado ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-hint">Primeiro selecione a clínica para carregar os dentistas disponíveis</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-arrow-right me-2"></i>
                                    Próxima Etapa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <!-- ETAPA 2: Formulário Completo -->
            <form method="post" action="<?= base_url('admin/pacientes/salvar_paciente') ?>" enctype="multipart/form-data">

                <input type="hidden" name="clinica_id" value="<?= $clinica_selecionada ?>">

                <!-- Clínica Selecionada -->
                <div class="card mb-3">
                    <div class="card-header bg-primary-lt">
                        <h3 class="card-title">Etapa 2 de 2 - Dados do Paciente</h3>
                        <div class="card-actions">
                            <a href="<?= base_url('admin/pacientes/criar') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="ti ti-arrow-left me-1"></i>
                                Trocar Clínica
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Clínica Selecionada:</strong>
                                <?php
                                $clinica_info = null;
                                foreach ($clinicas as $c) {
                                    if ($c->id == $clinica_selecionada) {
                                        $clinica_info = $c;
                                        break;
                                    }
                                }
                                ?>
                                <div class="text-muted">
                                    <?= $clinica_info ? $clinica_info->nome . ' - ' . $clinica_info->cidade : 'Clínica não encontrada' ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong>Dentistas Disponíveis:</strong>
                                <div class="text-muted">
                                    <?= count($dentistas) ?> dentista(s) ativo(s) nesta clínica
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dados Pessoais -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Dados Pessoais</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Nome Completo</label>
                                    <input type="text" class="form-control" name="nome" id="nome" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label required">Data de Nascimento</label>
                                    <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label required">Gênero</label>
                                    <select class="form-select" name="genero" id="genero" required>
                                        <option value="">Selecione...</option>
                                        <option value="masculino">Masculino</option>
                                        <option value="feminino">Feminino</option>
                                        <option value="outro">Outro</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label required">CPF</label>
                                    <input type="text" class="form-control" name="cpf" id="cpf" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Telefone</label>
                                    <input type="text" class="form-control" name="telefone" id="telefone">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">E-mail</label>
                                    <input type="email" class="form-control" name="email" id="email">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dentista -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Dentista Responsável</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($dentistas)): ?>
                            <div class="alert alert-warning mb-0">
                                <i class="ti ti-alert-triangle me-2"></i>
                                Nenhum dentista ativo encontrado nesta clínica.
                                <a href="<?= base_url('admin/dentistas/criar') ?>" target="_blank">Cadastre um dentista</a>
                                ou <a href="<?= base_url('admin/pacientes/criar') ?>">escolha outra clínica</a>.
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label class="form-label required">Dentista</label>
                                <select class="form-select" name="dentista_id" id="dentista_id" required>
                                    <option value="">Selecione o dentista...</option>
                                    <?php foreach ($dentistas as $dentista): ?>
                                        <option value="<?= $dentista->id ?>">
                                            <?= $dentista->nome ?>
                                            <?php if ($dentista->cro): ?>
                                                - CRO: <?= $dentista->cro ?>
                                            <?php endif; ?>
                                            <?php if ($dentista->especialidade): ?>
                                                (<?= $dentista->especialidade ?>)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Foto -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Foto do Paciente</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" class="form-control" name="foto" accept="image/*">
                            <small class="form-hint">JPG ou PNG, máx 2MB</small>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Observações</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Observações Adicionais</label>
                            <textarea class="form-control" name="observacoes" rows="4"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="card">
                    <div class="card-footer text-end">
                        <div class="d-flex">
                            <a href="<?= base_url('admin/pacientes') ?>" class="btn btn-link">
                                Cancelar
                            </a>
                            <?php if (!empty($dentistas)): ?>
                                <button type="submit" class="btn btn-primary ms-auto">
                                    <i class="ti ti-device-floppy me-2"></i>
                                    Salvar Paciente
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </form>
        <?php endif; ?>

    </div>
</div>

<?php if ($clinica_selecionada): ?>
<?php ob_start(); ?>
<script>
// Máscaras
if (typeof $ !== 'undefined' && typeof $.fn.mask !== 'undefined') {
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-00009');
}
</script>
<?php $scripts = ob_get_clean(); ?>
<?php endif; ?>
