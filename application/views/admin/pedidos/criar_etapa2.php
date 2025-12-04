<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Novo Pedido</div>
                <h2 class="page-title">
                    <i class="ti ti-file-plus me-2"></i>
                    Etapa 2 de 3 - Tipo de Pedido
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <!-- Progresso -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="steps steps-blue steps-counter">
                    <div class="step-item">
                        <div class="h4 m-0">Paciente</div>
                    </div>
                    <div class="step-item active">
                        <div class="h4 m-0">Tipo de Pedido</div>
                    </div>
                    <div class="step-item">
                        <div class="h4 m-0">Dados do Pedido</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Paciente Selecionado -->
        <div class="card mb-3">
            <div class="card-header bg-primary-lt">
                <h3 class="card-title">Paciente Selecionado</h3>
                <div class="card-actions">
                    <a href="<?= base_url('admin/pedidos/criar') ?>" class="btn btn-sm btn-outline-primary">
                        <i class="ti ti-arrow-left me-1"></i>
                        Trocar Paciente
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <?php if ($paciente->foto): ?>
                            <span class="avatar avatar-lg" style="background-image: url(<?= base_url($paciente->foto) ?>)"></span>
                        <?php else: ?>
                            <span class="avatar avatar-lg">
                                <?= strtoupper(substr($paciente->nome, 0, 2)) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <h3 class="mb-1"><?= $paciente->nome ?></h3>
                        <div class="text-muted">
                            <strong>CPF:</strong> <?= $paciente->cpf ?> |
                            <strong>Clínica:</strong> <?= $paciente->clinica_nome ?> |
                            <strong>Dentista:</strong> <?= $paciente->dentista_nome ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tipos de Pedido -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Selecione o Tipo de Pedido</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <!-- Complete -->
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id . '&tipo_pedido=complete') ?>" class="card card-link card-link-pop">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-lg bg-primary text-white">
                                            <i class="ti ti-checkup-list fs-1"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1">Complete</h3>
                                        <p class="text-muted mb-0">
                                            Planejamento completo com análise detalhada e produção de alinhadores
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Self Guard -->
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id . '&tipo_pedido=self_guard') ?>" class="card card-link card-link-pop">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-lg bg-success text-white">
                                            <i class="ti ti-shield-check fs-1"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1">Self Guard</h3>
                                        <p class="text-muted mb-0">
                                            Contenção personalizada para manutenção do tratamento
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- You Plan -->
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id . '&tipo_pedido=you_plan') ?>" class="card card-link card-link-pop">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-lg bg-warning text-white">
                                            <i class="ti ti-pencil fs-1"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1">You Plan</h3>
                                        <p class="text-muted mb-0">
                                            Você faz o planejamento, nós produzimos os alinhadores
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Print 3D -->
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id . '&tipo_pedido=print_3d') ?>" class="card card-link card-link-pop">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-lg bg-info text-white">
                                            <i class="ti ti-printer fs-1"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1">Print 3D</h3>
                                        <p class="text-muted mb-0">
                                            Impressão 3D de modelos para planejamento e produção
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Self Plan -->
                    <div class="col-md-6">
                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id . '&tipo_pedido=self_plan') ?>" class="card card-link card-link-pop">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="avatar avatar-lg bg-purple text-white">
                                            <i class="ti ti-chart-line fs-1"></i>
                                        </span>
                                    </div>
                                    <div class="col">
                                        <h3 class="mb-1">Self Plan</h3>
                                        <p class="text-muted mb-0">
                                            Planejamento independente com suporte técnico
                                        </p>
                                    </div>
                                    <div class="col-auto">
                                        <i class="ti ti-chevron-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
