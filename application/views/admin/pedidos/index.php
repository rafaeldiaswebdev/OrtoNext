<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-file-text me-2"></i>
                    Pedidos
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="<?= base_url('admin/pedidos/criar') ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        Novo Pedido
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <!-- Estatísticas -->
        <div class="row row-cards mb-3">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total de Pedidos</div>
                        </div>
                        <div class="h1 mb-0"><?= $stats['total'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Em Produção</div>
                        </div>
                        <div class="h1 mb-0 text-primary"><?= $stats['em_producao'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Em Análise</div>
                        </div>
                        <div class="h1 mb-0 text-warning"><?= $stats['em_analise'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Concluídos</div>
                        </div>
                        <div class="h1 mb-0 text-success"><?= $stats['concluido'] ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Filtros</h3>
            </div>
            <div class="card-body">
                <form method="get" action="<?= base_url('admin/pedidos') ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Número do Pedido</label>
                                <input type="text" class="form-control" name="numero_pedido" value="<?= $filtros['numero_pedido'] ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Clínica</label>
                                <select class="form-select" name="clinica_id">
                                    <option value="">Todas</option>
                                    <?php foreach ($clinicas as $clinica): ?>
                                        <option value="<?= $clinica->id ?>" <?= $filtros['clinica_id'] == $clinica->id ? 'selected' : '' ?>>
                                            <?= $clinica->nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Todos</option>
                                    <?php foreach ($status_list as $key => $status): ?>
                                        <option value="<?= $key ?>" <?= $filtros['status'] == $key ? 'selected' : '' ?>>
                                            <?= $status['label'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select class="form-select" name="tipo_pedido">
                                    <option value="">Todos</option>
                                    <?php foreach ($tipos_pedido as $key => $tipo): ?>
                                        <option value="<?= $key ?>" <?= $filtros['tipo_pedido'] == $key ? 'selected' : '' ?>>
                                            <?= $tipo ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-search me-2"></i>
                                Filtrar
                            </button>
                            <a href="<?= base_url('admin/pedidos') ?>" class="btn btn-link">
                                Limpar Filtros
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Lista de Pedidos -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pedidos Cadastrados</h3>
                <div class="card-actions">
                    <span class="text-muted"><?= $total ?> pedido(s) encontrado(s)</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Número</th>
                            <th>Paciente</th>
                            <th>Tipo</th>
                            <th>Clínica</th>
                            <th>Status</th>
                            <th>Criado em</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pedidos)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="ti ti-file-off fs-1 mb-2"></i>
                                    <p>Nenhum pedido encontrado</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td>
                                        <a href="<?= base_url('admin/pedidos/visualizar/' . $pedido->id) ?>" class="text-reset">
                                            <strong>#<?= $pedido->numero_pedido ?></strong>
                                        </a>
                                    </td>
                                    <td>
                                        <div><?= $pedido->paciente_nome ?></div>
                                        <div class="text-muted small"><?= $pedido->dentista_nome ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-azure"><?= $tipos_pedido[$pedido->tipo_pedido] ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?= $pedido->clinica_nome ?></span>
                                    </td>
                                    <td>
                                        <?php $status = $status_list[$pedido->status]; ?>
                                        <span class="badge bg-<?= $status['color'] ?>"><?= $status['label'] ?></span>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($pedido->criado_em)) ?>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="<?= base_url('admin/pedidos/visualizar/' . $pedido->id) ?>" class="btn btn-sm btn-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <?php if ($pedido->status == 'rascunho'): ?>
                                                <a href="#" onclick="confirmarExclusao(<?= $pedido->id ?>, '<?= $pedido->numero_pedido ?>')" class="btn btn-sm btn-danger">
                                                    <i class="ti ti-trash"></i>
                                                </a>
                                            <?php endif; ?>
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

<?php ob_start(); ?>
<script>
function confirmarExclusao(id, numero) {
    Swal.fire({
        title: 'Confirmar Exclusão',
        text: 'Deseja realmente excluir o pedido #' + numero + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d63939',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = BASE_URL + 'admin/pedidos/excluir/' + id;
        }
    });
}
</script>
<?php $scripts = ob_get_clean(); ?>
