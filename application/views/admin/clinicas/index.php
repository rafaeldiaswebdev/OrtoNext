<!-- Cabeçalho da Página -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-building-hospital me-2"></i>
                    Clínicas
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/clinicas/criar') ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        Nova Clínica
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="get" action="<?= base_url('admin/clinicas') ?>" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Buscar</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="busca"
                                   value="<?= $filtros['busca'] ?>"
                                   placeholder="Nome ou CNPJ...">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cidade</label>
                        <select name="cidade" class="form-select" onchange="this.form.submit()">
                            <option value="">Todas</option>
                            <?php foreach ($cidades as $cidade): ?>
                            <option value="<?= $cidade ?>" <?= $filtros['cidade'] == $cidade ? 'selected' : '' ?>>
                                <?= $cidade ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status de Validação</label>
                        <select name="status_validacao" class="form-select" onchange="this.form.submit()">
                            <option value="">Todos</option>
                            <option value="pendente" <?= $filtros['status_validacao'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                            <option value="aprovado" <?= $filtros['status_validacao'] == 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
                            <option value="reprovado" <?= $filtros['status_validacao'] == 'reprovado' ? 'selected' : '' ?>>Reprovado</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <?php if ($filtros['busca'] || $filtros['cidade'] || $filtros['status_validacao']): ?>
                        <a href="<?= base_url('admin/clinicas') ?>" class="btn btn-outline-secondary w-100">
                            <i class="ti ti-x me-2"></i>Limpar
                        </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total de clínicas</div>
                            <div class="ms-auto lh-1">
                                <span class="badge bg-primary"><?= $total ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Clínicas -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Lista de Clínicas</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Clínica</th>
                            <th>Responsável Técnico</th>
                            <th>Cidade/UF</th>
                            <th>Status</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($clinicas)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="ti ti-building-hospital icon mb-2" style="font-size: 3rem;"></i>
                                <p class="mb-0">Nenhuma clínica encontrada.</p>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($clinicas as $clinica): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <?php if ($clinica->logo): ?>
                                    <div class="avatar avatar-sm me-2" style="background-image: url(<?= base_url('uploads/clinicas/logos/' . $clinica->logo) ?>)"></div>
                                    <?php else: ?>
                                    <div class="avatar avatar-sm me-2 bg-blue-lt">
                                        <i class="ti ti-building-hospital"></i>
                                    </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong><?= $clinica->nome ?></strong>
                                        <div class="small text-muted">CNPJ: <?= $this->Clinica_model->formatar_cnpj($clinica->cnpj) ?></div>
                                        <?php if ($clinica->telefone): ?>
                                        <div class="small text-muted"><i class="ti ti-phone"></i> <?= $clinica->telefone ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><?= $clinica->responsavel_tecnico ?></div>
                                <div class="small text-muted">CRO: <?= $clinica->cro_responsavel ?></div>
                            </td>
                            <td>
                                <?php if ($clinica->cidade && $clinica->estado): ?>
                                <span class="text-muted">
                                    <i class="ti ti-map-pin"></i> <?= $clinica->cidade ?>/<?= $clinica->estado ?>
                                </span>
                                <?php else: ?>
                                <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($clinica->status_validacao == 'aprovado'): ?>
                                <span class="badge bg-success">
                                    <i class="ti ti-check me-1"></i>Aprovado
                                </span>
                                <?php elseif ($clinica->status_validacao == 'reprovado'): ?>
                                <span class="badge bg-danger">
                                    <i class="ti ti-x me-1"></i>Reprovado
                                </span>
                                <?php else: ?>
                                <span class="badge bg-warning">
                                    <i class="ti ti-clock me-1"></i>Pendente
                                </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="btn-list flex-nowrap">
                                    <a href="<?= base_url('admin/clinicas/visualizar/' . $clinica->id) ?>"
                                       class="btn btn-sm btn-icon btn-info"
                                       title="Visualizar">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/clinicas/editar/' . $clinica->id) ?>"
                                       class="btn btn-sm btn-icon btn-warning"
                                       title="Editar">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/clinicas/excluir/' . $clinica->id) ?>"
                                       class="btn btn-sm btn-icon btn-danger"
                                       title="Excluir"
                                       onclick="return confirm('Tem certeza que deseja excluir esta clínica? Esta ação não pode ser desfeita.')">
                                        <i class="ti ti-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
