<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">
                    <a href="<?= base_url('admin/pedidos') ?>">Pedidos</a>
                </div>
                <h2 class="page-title">
                    Pedido #<?= $pedido->numero_pedido ?>
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <?php $status = $status_list[$pedido->status]; ?>
                    <span class="badge bg-<?= $status['color'] ?> badge-lg"><?= $status['label'] ?></span>
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

                <!-- Dados do Pedido -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Informações do Pedido</h3>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Número do Pedido:</strong><br>
                                #<?= $pedido->numero_pedido ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Tipo:</strong><br>
                                <span class="badge bg-azure"><?= $pedido->tipo_pedido ?></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Paciente:</strong><br>
                                <?= $pedido->paciente_nome ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Dentista:</strong><br>
                                <?= $pedido->dentista_nome ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Clínica:</strong><br>
                                <?= $pedido->clinica_nome ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Observações -->
                <?php if ($pedido->observacoes_planejamento): ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Observações de Planejamento</h3>
                    </div>
                    <div class="card-body">
                        <?= nl2br($pedido->observacoes_planejamento) ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Arquivos -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Arquivos</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($arquivos)): ?>
                            <p class="text-muted">Nenhum arquivo anexado</p>
                        <?php else: ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($arquivos as $arquivo): ?>
                                    <div class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <i class="ti ti-file fs-1"></i>
                                            </div>
                                            <div class="col">
                                                <strong><?= $arquivo->nome_original ?></strong><br>
                                                <small class="text-muted">
                                                    <?= $arquivo->tipo_arquivo ?> |
                                                    <?= number_format($arquivo->tamanho / 1024, 2) ?> KB |
                                                    Enviado em <?= date('d/m/Y H:i', strtotime($arquivo->enviado_em)) ?>
                                                </small>
                                            </div>
                                            <div class="col-auto">
                                                <a href="<?= base_url($arquivo->caminho) ?>" class="btn btn-sm btn-primary" download>
                                                    <i class="ti ti-download"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <!-- Coluna Lateral -->
            <div class="col-lg-4">

                <!-- Alterar Status -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="card-title">Alterar Status</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('admin/pedidos/atualizar_status/' . $pedido->id) ?>">
                            <div class="mb-3">
                                <label class="form-label">Novo Status</label>
                                <select class="form-select" name="status" required>
                                    <?php foreach ($status_list as $key => $st): ?>
                                        <option value="<?= $key ?>" <?= $pedido->status == $key ? 'selected' : '' ?>>
                                            <?= $st['label'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Observação</label>
                                <textarea class="form-control" name="descricao" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ti ti-check me-2"></i>
                                Atualizar Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Histórico</h3>
                    </div>
                    <div class="card-body">
                        <?php if (empty($timeline)): ?>
                            <p class="text-muted">Nenhum evento registrado</p>
                        <?php else: ?>
                            <ul class="timeline">
                                <?php foreach ($timeline as $evento): ?>
                                    <li class="timeline-event">
                                        <div class="timeline-event-icon bg-primary">
                                            <i class="ti ti-point"></i>
                                        </div>
                                        <div class="card timeline-event-card">
                                            <div class="card-body">
                                                <div class="text-muted small">
                                                    <?= date('d/m/Y H:i', strtotime($evento->criado_em)) ?>
                                                </div>
                                                <strong><?= $evento->titulo ?></strong>
                                                <?php if ($evento->descricao): ?>
                                                    <p class="text-muted mb-0"><?= $evento->descricao ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
