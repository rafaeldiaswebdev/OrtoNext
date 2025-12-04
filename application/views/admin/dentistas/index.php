<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-user-heart me-2"></i>
                    Dentistas
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/dentistas/criar') ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        Novo Dentista
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

        <!-- Estatísticas -->
        <div class="row row-cards mb-3">
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Total de Dentistas</div>
                        </div>
                        <div class="h1 mb-0"><?= $stats['total_dentistas'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Ativos</div>
                        </div>
                        <div class="h1 mb-0 text-success"><?= $stats['ativos'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Inativos</div>
                        </div>
                        <div class="h1 mb-0 text-muted"><?= $stats['inativos'] ?></div>
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
                <form method="get" action="<?= base_url('admin/dentistas') ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" value="<?= $filtros['nome'] ?>" placeholder="Buscar por nome">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">CRO</label>
                                <input type="text" class="form-control" name="cro" value="<?= $filtros['cro'] ?>" placeholder="CRO">
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
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Todos</option>
                                    <option value="ativo" <?= $filtros['status'] === 'ativo' ? 'selected' : '' ?>>Ativo</option>
                                    <option value="inativo" <?= $filtros['status'] === 'inativo' ? 'selected' : '' ?>>Inativo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="ti ti-search me-2"></i>
                                    Filtrar
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty(array_filter($filtros))): ?>
                        <div class="row">
                            <div class="col-12">
                                <a href="<?= base_url('admin/dentistas') ?>" class="btn btn-link">
                                    <i class="ti ti-x me-2"></i>
                                    Limpar Filtros
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Tabela -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <?= $total ?> dentista(s) encontrado(s)
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>CRO</th>
                            <th>Especialidade</th>
                            <th>Clínicas</th>
                            <th>Pacientes</th>
                            <th>Status</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($dentistas)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="ti ti-user-off icon mb-2" style="font-size: 3rem;"></i>
                                    <p>Nenhum dentista encontrado</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($dentistas as $dentista): ?>
                                <tr>
                                    <td>
                                        <?php if ($dentista->foto): ?>
                                            <span class="avatar avatar-sm" style="background-image: url(<?= base_url('uploads/dentistas/fotos/' . $dentista->foto) ?>)"></span>
                                        <?php else: ?>
                                            <span class="avatar avatar-sm">
                                                <?= strtoupper(substr($dentista->nome, 0, 2)) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            <strong><?= $dentista->nome ?></strong>
                                        </div>
                                        <div class="text-muted">
                                            <small><?= $dentista->email ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-blue-lt"><?= $dentista->cro ?></span>
                                    </td>
                                    <td>
                                        <?= $dentista->especialidade ?: '<span class="text-muted">-</span>' ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-purple-lt">
                                            <?= $dentista->total_clinicas ?> clínica(s)
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-cyan-lt">
                                            <?= $dentista->total_pacientes ?> paciente(s)
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($dentista->status == 'ativo'): ?>
                                            <span class="badge bg-success">Ativo</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="<?= base_url('admin/dentistas/visualizar/' . $dentista->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-primary"
                                               title="Visualizar">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/dentistas/editar/' . $dentista->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-info"
                                               title="Editar">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/dentistas/excluir/' . $dentista->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-danger"
                                               title="Excluir"
                                               onclick="return confirm('Tem certeza que deseja excluir este dentista?')">
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
