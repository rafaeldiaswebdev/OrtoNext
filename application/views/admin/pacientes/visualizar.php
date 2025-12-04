<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="<?= base_url('admin/pacientes') ?>">Pacientes</a>
                </div>
                <h2 class="page-title">
                    <i class="ti ti-users me-2"></i>
                    <?= $paciente->nome ?>
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/pacientes/editar/' . $paciente->id) ?>" class="btn btn-primary">
                        <i class="ti ti-edit me-2"></i>
                        Editar
                    </a>
                    <a href="<?= base_url('admin/pacientes/excluir/' . $paciente->id) ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Tem certeza que deseja excluir este paciente?')">
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
            <div class="col-lg-4">

                <div class="card mb-3">
                    <div class="card-body text-center">
                        <?php if ($paciente->foto): ?>
                            <img src="<?= base_url('uploads/pacientes/fotos/' . $paciente->foto) ?>"
                                 alt="Foto"
                                 class="avatar avatar-xl mb-3">
                        <?php else: ?>
                            <span class="avatar avatar-xl mb-3">
                                <?= strtoupper(substr($paciente->nome, 0, 2)) ?>
                            </span>
                        <?php endif; ?>

                        <h3 class="m-0 mb-1"><?= $paciente->nome ?></h3>
                        <div class="text-muted mb-3"><?= $idade ?> anos</div>

                        <?php if ($paciente->genero == 'masculino'): ?>
                            <span class="badge bg-blue mb-3">Masculino</span>
                        <?php elseif ($paciente->genero == 'feminino'): ?>
                            <span class="badge bg-pink mb-3">Feminino</span>
                        <?php else: ?>
                            <span class="badge bg-secondary mb-3">Outro</span>
                        <?php endif; ?>
                    </div>

                    <div class="list-group list-group-flush">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-file-text text-muted"></i>
                                </div>
                                <div class="col text-truncate">
                                    <div class="text-reset d-block">CPF</div>
                                    <div class="text-muted"><?= $paciente->cpf ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <i class="ti ti-calendar text-muted"></i>
                                </div>
                                <div class="col text-truncate">
                                    <div class="text-reset d-block">Nascimento</div>
                                    <div class="text-muted"><?= date('d/m/Y', strtotime($paciente->data_nascimento)) ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if ($paciente->telefone): ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="ti ti-phone text-muted"></i>
                                    </div>
                                    <div class="col text-truncate">
                                        <div class="text-reset d-block">Telefone</div>
                                        <div class="text-muted">
                                            <a href="tel:<?= $paciente->telefone ?>"><?= $paciente->telefone ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($paciente->email): ?>
                            <div class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="ti ti-mail text-muted"></i>
                                    </div>
                                    <div class="col text-truncate">
                                        <div class="text-reset d-block">E-mail</div>
                                        <div class="text-muted">
                                            <a href="mailto:<?= $paciente->email ?>"><?= $paciente->email ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Estatísticas</h3>
                    </div>
                    <div class="list-group list-group-flush">
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

            <div class="col-lg-8">

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Clínica e Dentista</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Clínica</label>
                                    <div>
                                        <a href="<?= base_url('admin/clinicas/visualizar/' . $paciente->clinica_id) ?>">
                                            <strong><?= $paciente->clinica_nome ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Dentista</label>
                                    <div>
                                        <a href="<?= base_url('admin/dentistas/visualizar/' . $paciente->dentista_id) ?>">
                                            <strong><?= $paciente->dentista_nome ?></strong>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (!empty($pedidos)): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Pedidos Recentes</h3>
                            <div class="card-actions">
                                <span class="badge bg-cyan"><?= count($pedidos) ?> pedido(s)</span>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php foreach ($pedidos as $pedido): ?>
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <i class="ti ti-shopping-cart"></i>
                                        </div>
                                        <div class="col text-truncate">
                                            <a href="<?= base_url('admin/pedidos/visualizar/' . $pedido->id) ?>" class="text-reset d-block">
                                                Pedido #<?= $pedido->numero_pedido ?>
                                            </a>
                                            <div class="text-muted text-truncate mt-n1">
                                                <?= date('d/m/Y', strtotime($pedido->criado_em)) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($paciente->observacoes): ?>
                    <div class="card mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Observações</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-0"><?= nl2br($paciente->observacoes) ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informações do Sistema</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Cadastrado em:</strong><br>
                                    <?= date('d/m/Y H:i', strtotime($paciente->criado_em)) ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Última atualização:</strong><br>
                                    <?= $paciente->atualizado_em ? date('d/m/Y H:i', strtotime($paciente->atualizado_em)) : 'Nunca' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
