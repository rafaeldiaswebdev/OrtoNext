<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="<?= base_url('admin/dentistas') ?>">Dentistas</a>
                </div>
                <h2 class="page-title">
                    <i class="ti ti-user-heart me-2"></i>
                    <?= $dentista->nome ?>
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/dentistas/editar/' . $dentista->id) ?>" class="btn btn-primary">
                        <i class="ti ti-edit me-2"></i>
                        Editar
                    </a>
                    <a href="<?= base_url('admin/dentistas/excluir/' . $dentista->id) ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este dentista?')">
                        <i class="ti ti-trash me-2"></i>
                        Excluir
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <!-- Mensagens Flash -->
        <?php if ($this->session->flashdata('sucesso')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-check icon alert-icon"></i></div>
                    <div><?= $this->session->flashdata('sucesso') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('erro')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex">
                    <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
                    <div><?= $this->session->flashdata('erro') ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Coluna Esquerda -->
            <div class="col-lg-4">

                <!-- Card com Foto e Info Básica -->
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <?php if ($dentista->foto): ?>
                            <img src="<?= base_url('uploads/dentistas/fotos/' . $dentista->foto) ?>"
                                 alt="Foto"
                                 class="avatar avatar-xl mb-3">
                        <?php else: ?>
                            <span class="avatar avatar-xl mb-3">
                                <?= strtoupper(substr($dentista->nome, 0, 2)) ?>
                            </span>
                        <?php endif; ?>

                        <h3 class="m-0 mb-1"><?= $dentista->nome ?></h3>
                        <div class="text-muted mb-3"><?= $dentista->especialidade ?: 'Dentista' ?></div>

                        <?php if ($dentista->status == 'ativo'): ?>
                            <span class="badge bg-success mb-3">Ativo</span>
                        <?php else: ?>
                            <span class="badge bg-secondary mb-3">Inativo</span>
                        <?php endif; ?>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-id text-muted"></i>
                                </div>
                                <div class="col text-truncate">
                                    <div class="text-reset d-block">CRO</div>
                                    <div class="text-muted"><?= $dentista->cro ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-file-text text-muted"></i>
                                </div>
                                <div class="col text-truncate">
                                    <div class="text-reset d-block">CPF</div>
                                    <div class="text-muted"><?= $dentista->cpf ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-mail text-muted"></i>
                                </div>
                                <div class="col text-truncate">
                                    <div class="text-reset d-block">E-mail</div>
                                    <div class="text-muted">
                                        <a href="mailto:<?= $dentista->email ?>"><?= $dentista->email ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($dentista->telefone): ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="ti ti-phone text-muted"></i>
                                    </div>
                                    <div class="col text-truncate">
                                        <div class="text-reset d-block">Telefone</div>
                                        <div class="text-muted">
                                            <a href="tel:<?= $dentista->telefone ?>"><?= $dentista->telefone ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($dentista->whatsapp): ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="ti ti-brand-whatsapp text-muted"></i>
                                    </div>
                                    <div class="col text-truncate">
                                        <div class="text-reset d-block">WhatsApp</div>
                                        <div class="text-muted">
                                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $dentista->whatsapp) ?>" target="_blank">
                                                <?= $dentista->whatsapp ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Estatísticas -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-building-hospital text-purple"></i>
                                </div>
                                <div class="col">
                                    <div class="text-truncate">
                                        <strong><?= $stats['total_clinicas'] ?></strong> Clínica(s)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-users text-cyan"></i>
                                </div>
                                <div class="col">
                                    <div class="text-truncate">
                                        <strong><?= $stats['total_pacientes'] ?></strong> Paciente(s)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-shopping-cart text-blue"></i>
                                </div>
                                <div class="col">
                                    <div class="text-truncate">
                                        <strong><?= $stats['total_pedidos'] ?></strong> Pedido(s)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Coluna Direita -->
            <div class="col-lg-8">

                <!-- Clínicas Vinculadas -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Clínicas Vinculadas</h3>
                        <div class="card-actions">
                            <span class="badge bg-purple"><?= count($clinicas) ?> clínica(s)</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($clinicas)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="ti ti-building-hospital-off icon mb-2" style="font-size: 2rem;"></i>
                                <p>Nenhuma clínica vinculada</p>
                                <a href="<?= base_url('admin/dentistas/editar/' . $dentista->id) ?>" class="btn btn-sm btn-primary">
                                    Vincular Clínicas
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="row">
                                <?php foreach ($clinicas as $clinica): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card card-sm">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <?php if ($clinica->logo): ?>
                                                            <span class="avatar" style="background-image: url(<?= base_url('uploads/clinicas/logos/' . $clinica->logo) ?>)"></span>
                                                        <?php else: ?>
                                                            <span class="avatar">
                                                                <?= strtoupper(substr($clinica->nome, 0, 2)) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium">
                                                            <a href="<?= base_url('admin/clinicas/visualizar/' . $clinica->id) ?>">
                                                                <?= $clinica->nome ?>
                                                            </a>
                                                        </div>
                                                        <div class="text-muted">
                                                            <small><?= $clinica->cidade ?> - <?= $clinica->estado ?></small>
                                                        </div>
                                                        <div class="text-muted">
                                                            <small>Vinculado em <?= date('d/m/Y', strtotime($clinica->vinculado_em)) ?></small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Pacientes Recentes -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Pacientes Recentes</h3>
                        <div class="card-actions">
                            <span class="badge bg-cyan"><?= count($pacientes) ?> paciente(s)</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($pacientes)): ?>
                            <div class="text-center text-muted py-4">
                                <i class="ti ti-user-off icon mb-2" style="font-size: 2rem;"></i>
                                <p>Nenhum paciente cadastrado</p>
                            </div>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($pacientes as $paciente): ?>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <?php if ($paciente->foto): ?>
                                                    <span class="avatar" style="background-image: url(<?= base_url('uploads/pacientes/fotos/' . $paciente->foto) ?>)"></span>
                                                <?php else: ?>
                                                    <span class="avatar">
                                                        <?= strtoupper(substr($paciente->nome, 0, 2)) ?>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="<?= base_url('admin/pacientes/visualizar/' . $paciente->id) ?>" class="text-reset d-block">
                                                    <?= $paciente->nome ?>
                                                </a>
                                                <div class="text-muted text-truncate mt-n1">
                                                    <?= $paciente->clinica_nome ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Observações -->
                <?php if ($dentista->observacoes): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Observações</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0"><?= nl2br($dentista->observacoes) ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Informações do Sistema -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações do Sistema</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Cadastrado em:</strong><br>
                                    <?= date('d/m/Y H:i', strtotime($dentista->criado_em)) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Última atualização:</strong><br>
                                    <?= date('d/m/Y H:i', strtotime($dentista->atualizado_em)) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
