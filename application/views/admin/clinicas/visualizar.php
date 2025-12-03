<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Visualizar</div>
                <h2 class="page-title">
                    <i class="ti ti-building-hospital me-2"></i>
                    <?= $clinica->nome ?>
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/clinicas/editar/' . $clinica->id) ?>" class="btn btn-warning">
                        <i class="ti ti-edit me-2"></i>
                        Editar
                    </a>
                    <a href="<?= base_url('admin/clinicas') ?>" class="btn btn-secondary">
                        <i class="ti ti-arrow-left me-2"></i>
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <div class="row">
            <!-- Coluna Principal -->
            <div class="col-lg-8">

                <!-- Dados da Clínica -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Dados da Clínica</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-muted">Nome:</strong>
                                    <div><?= $clinica->nome ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-muted">CNPJ:</strong>
                                    <div><?= $this->Clinica_model->formatar_cnpj($clinica->cnpj) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-muted">Responsável Técnico:</strong>
                                    <div><?= $clinica->responsavel_tecnico ?></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong class="text-muted">CRO:</strong>
                                    <div><?= $clinica->cro_responsavel ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if ($clinica->logradouro): ?>
                        <div class="mb-3">
                            <strong class="text-muted">Endereço:</strong>
                            <div>
                                <?= $clinica->logradouro ?><?= $clinica->numero ? ', ' . $clinica->numero : '' ?><?= $clinica->complemento ? ' - ' . $clinica->complemento : '' ?>
                                <br>
                                <?= $clinica->bairro ?> - <?= $clinica->cidade ?>/<?= $clinica->estado ?>
                                <?php if ($clinica->cep): ?>
                                <br>CEP: <?= $clinica->cep ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="row">
                            <?php if ($clinica->telefone): ?>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong class="text-muted">Telefone:</strong>
                                    <div><i class="ti ti-phone"></i> <?= $clinica->telefone ?></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($clinica->whatsapp): ?>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong class="text-muted">WhatsApp:</strong>
                                    <div><i class="ti ti-brand-whatsapp"></i> <?= $clinica->whatsapp ?></div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($clinica->email): ?>
                            <div class="col-md-4">
                                <div class="mb-2">
                                    <strong class="text-muted">E-mail:</strong>
                                    <div><i class="ti ti-mail"></i> <?= $clinica->email ?></div>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php if ($clinica->observacoes): ?>
                        <div class="mt-3">
                            <strong class="text-muted">Observações:</strong>
                            <div class="text-secondary"><?= nl2br($clinica->observacoes) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Documentos -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Documentos</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php if ($clinica->doc_cnh): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-file-text" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <strong>CNH</strong>
                                        <div>
                                            <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cnh) ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i> Baixar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($clinica->doc_rg): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-file-text" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <strong>RG</strong>
                                        <div>
                                            <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_rg) ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i> Baixar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($clinica->doc_cpf): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-file-text" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <strong>CPF</strong>
                                        <div>
                                            <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cpf) ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i> Baixar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if ($clinica->doc_cro): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="me-3">
                                        <i class="ti ti-file-text" style="font-size: 2rem;"></i>
                                    </div>
                                    <div>
                                        <strong>CRO</strong>
                                        <div>
                                            <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cro) ?>" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="ti ti-download"></i> Baixar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!$clinica->doc_cnh && !$clinica->doc_rg && !$clinica->doc_cpf && !$clinica->doc_cro): ?>
                            <div class="col-12">
                                <div class="text-center text-muted py-3">
                                    <i class="ti ti-file-off" style="font-size: 3rem;"></i>
                                    <p class="mb-0">Nenhum documento enviado</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Dentistas Vinculados -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Dentistas Vinculados</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <?php if (empty($dentistas)): ?>
                        <div class="list-group-item text-center text-muted py-4">
                            <i class="ti ti-user-off" style="font-size: 3rem;"></i>
                            <p class="mb-0">Nenhum dentista vinculado</p>
                        </div>
                        <?php else: ?>
                        <?php foreach ($dentistas as $dentista): ?>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <?php if ($dentista->foto): ?>
                                    <span class="avatar" style="background-image: url(<?= base_url('uploads/dentistas/fotos/' . $dentista->foto) ?>)"></span>
                                    <?php else: ?>
                                    <span class="avatar bg-blue-lt">
                                        <i class="ti ti-user"></i>
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <div class="col">
                                    <div class="text-reset d-block"><?= $dentista->nome ?></div>
                                    <div class="text-secondary text-truncate mt-n1">
                                        CRO: <?= $dentista->cro ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <small class="text-muted">
                                        Vinculado em <?= date('d/m/Y', strtotime($dentista->vinculado_em)) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pacientes -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Pacientes</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th>Paciente</th>
                                    <th>Dentista</th>
                                    <th>Cadastrado em</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($pacientes)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="ti ti-users-off" style="font-size: 3rem;"></i>
                                        <p class="mb-0">Nenhum paciente cadastrado</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($pacientes as $paciente): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($paciente->foto): ?>
                                            <span class="avatar avatar-sm me-2" style="background-image: url(<?= base_url('uploads/pacientes/fotos/' . $paciente->foto) ?>)"></span>
                                            <?php else: ?>
                                            <span class="avatar avatar-sm me-2 bg-blue-lt">
                                                <i class="ti ti-user"></i>
                                            </span>
                                            <?php endif; ?>
                                            <div><?= $paciente->nome ?></div>
                                        </div>
                                    </td>
                                    <td><?= $paciente->dentista_nome ?></td>
                                    <td><?= date('d/m/Y', strtotime($paciente->criado_em)) ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">

                <!-- Logo -->
                <?php if ($clinica->logo): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Logo</h3>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= base_url('uploads/clinicas/logos/' . $clinica->logo) ?>" alt="Logo" class="img-fluid" style="max-height: 200px;">
                    </div>
                </div>
                <?php endif; ?>

                <!-- Status de Validação -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Status de Validação</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 text-center">
                            <?php if ($clinica->status_validacao == 'aprovado'): ?>
                            <span class="badge bg-success" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                <i class="ti ti-check me-1"></i>Aprovado
                            </span>
                            <?php elseif ($clinica->status_validacao == 'reprovado'): ?>
                            <span class="badge bg-danger" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                <i class="ti ti-x me-1"></i>Reprovado
                            </span>
                            <?php else: ?>
                            <span class="badge bg-warning" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                <i class="ti ti-clock me-1"></i>Pendente
                            </span>
                            <?php endif; ?>
                        </div>

                        <?php if ($this->session->userdata('usuario_nivel') == 'admin'): ?>
                        <form method="post" action="<?= base_url('admin/clinicas/validar/' . $clinica->id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Alterar Status</label>
                                <select name="status_validacao" class="form-select" required>
                                    <option value="pendente" <?= $clinica->status_validacao == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                                    <option value="aprovado" <?= $clinica->status_validacao == 'aprovado' ? 'selected' : '' ?>>Aprovado</option>
                                    <option value="reprovado" <?= $clinica->status_validacao == 'reprovado' ? 'selected' : '' ?>>Reprovado</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Observações</label>
                                <textarea name="observacoes" class="form-control" rows="3"><?= $clinica->observacoes ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-check me-2"></i>
                                Atualizar Status
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <div class="text-center">
                                    <div class="h1 mb-1"><?= $estatisticas['total_dentistas'] ?></div>
                                    <div class="text-muted">Dentistas</div>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="text-center">
                                    <div class="h1 mb-1"><?= $estatisticas['total_pacientes'] ?></div>
                                    <div class="text-muted">Pacientes</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h1 mb-1"><?= $estatisticas['total_pedidos'] ?></div>
                                    <div class="text-muted">Pedidos</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="h1 mb-1"><?= $estatisticas['pedidos_concluidos'] ?></div>
                                    <div class="text-muted">Concluídos</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informações do Sistema -->
                <div class="card">
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">Cadastrado em:</small>
                            <div><?= date('d/m/Y H:i', strtotime($clinica->criado_em)) ?></div>
                        </div>
                        <?php if ($clinica->atualizado_em): ?>
                        <div class="mb-2">
                            <small class="text-muted">Última atualização:</small>
                            <div><?= date('d/m/Y H:i', strtotime($clinica->atualizado_em)) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
