<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-user-heart me-2"></i>
                    Novo Dentista
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <form method="post" action="<?= base_url('admin/dentistas/salvar_dentista') ?>" enctype="multipart/form-data">

            <!-- Dados Principais -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Dados Pessoais</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label required">Nome Completo</label>
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">CRO</label>
                                <input type="text" class="form-control" name="cro" id="cro" required>
                                <small class="form-hint">Ex: CRO-SP 12345</small>
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
                                <label class="form-label required">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Especialidade</label>
                                <input type="text" class="form-control" name="especialidade" id="especialidade">
                                <small class="form-hint">Ex: Ortodontia, Implantodontia</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" name="telefone" id="telefone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Clínicas Vinculadas -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Clínicas Vinculadas</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Selecione as clínicas</label>
                        <small class="form-hint">O dentista poderá atender pacientes dessas clínicas</small>

                        <?php if (empty($clinicas)): ?>
                            <div class="alert alert-warning">
                                <i class="ti ti-alert-circle me-2"></i>
                                Nenhuma clínica cadastrada. <a href="<?= base_url('admin/clinicas/criar') ?>">Cadastrar clínica</a>
                            </div>
                        <?php else: ?>
                            <div class="row mt-3">
                                <?php foreach ($clinicas as $clinica): ?>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-check">
                                            <input type="checkbox" class="form-check-input" name="clinicas[]" value="<?= $clinica->id ?>">
                                            <span class="form-check-label">
                                                <strong><?= $clinica->nome ?></strong>
                                                <br>
                                                <small class="text-muted"><?= $clinica->cidade ?> - <?= $clinica->estado ?></small>
                                            </span>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Foto e Documentos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Foto e Documentos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Foto do Dentista</label>
                                <input type="file" class="form-control" name="foto" accept="image/*">
                                <small class="form-hint">JPG ou PNG, máx 5MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CNH</label>
                                <input type="file" class="form-control" name="doc_cnh" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">RG</label>
                                <input type="file" class="form-control" name="doc_rg" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF</label>
                                <input type="file" class="form-control" name="doc_cpf" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CRO</label>
                                <input type="file" class="form-control" name="doc_cro" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
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

                    <div class="mb-3">
                        <label class="form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" class="form-check-input" name="status" value="1" checked>
                            <span class="form-check-label">Dentista ativo</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="card">
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="<?= base_url('admin/dentistas') ?>" class="btn btn-link">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="ti ti-device-floppy me-2"></i>
                            Salvar Dentista
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
$(document).ready(function() {
    // Máscaras
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-00009');
    $('#whatsapp').mask('(00) 0000-00009');
});
</script>
