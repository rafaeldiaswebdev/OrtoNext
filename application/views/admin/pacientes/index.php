<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-users me-2"></i>
                    Pacientes
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <a href="<?= base_url('admin/pacientes/criar') ?>" class="btn btn-primary">
                        <i class="ti ti-plus me-2"></i>
                        Novo Paciente
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
                            <div class="subheader">Total de Pacientes</div>
                        </div>
                        <div class="h1 mb-0"><?= $stats['total_pacientes'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Masculino</div>
                        </div>
                        <div class="h1 mb-0 text-blue"><?= $stats['masculino'] ?></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="subheader">Feminino</div>
                        </div>
                        <div class="h1 mb-0 text-pink"><?= $stats['feminino'] ?></div>
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
                <form method="get" action="<?= base_url('admin/pacientes') ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" value="<?= $filtros['nome'] ?>" placeholder="Buscar por nome">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" class="form-control" name="cpf" value="<?= $filtros['cpf'] ?>" placeholder="CPF">
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
                                <label class="form-label">Gênero</label>
                                <select class="form-select" name="genero">
                                    <option value="">Todos</option>
                                    <option value="masculino" <?= $filtros['genero'] === 'masculino' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="feminino" <?= $filtros['genero'] === 'feminino' ? 'selected' : '' ?>>Feminino</option>
                                    <option value="outro" <?= $filtros['genero'] === 'outro' ? 'selected' : '' ?>>Outro</option>
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
                                <a href="<?= base_url('admin/pacientes') ?>" class="btn btn-link">
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
                    <?= $total ?> paciente(s) encontrado(s)
                </h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-striped">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>Idade</th>
                            <th>Gênero</th>
                            <th>Clínica</th>
                            <th>Dentista</th>
                            <th>Pedidos</th>
                            <th class="w-1">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pacientes)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">
                                    <i class="ti ti-user-off icon mb-2" style="font-size: 3rem;"></i>
                                    <p>Nenhum paciente encontrado</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pacientes as $paciente): ?>
                                <?php
                                    $nascimento = new DateTime($paciente->data_nascimento);
                                    $hoje = new DateTime();
                                    $idade = $hoje->diff($nascimento)->y;
                                ?>
                                <tr>
                                    <td>
                                        <?php if ($paciente->foto): ?>
                                            <span class="avatar avatar-sm" style="background-image: url(<?= base_url('uploads/pacientes/fotos/' . $paciente->foto) ?>)"></span>
                                        <?php else: ?>
                                            <span class="avatar avatar-sm">
                                                <?= strtoupper(substr($paciente->nome, 0, 2)) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 200px;">
                                            <strong><?= $paciente->nome ?></strong>
                                        </div>
                                        <div class="text-muted">
                                            <small><?= $paciente->email ?: 'Sem e-mail' ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <?= $idade ?> anos
                                    </td>
                                    <td>
                                        <?php if ($paciente->genero == 'masculino'): ?>
                                            <span class="badge bg-blue-lt">Masculino</span>
                                        <?php elseif ($paciente->genero == 'feminino'): ?>
                                            <span class="badge bg-pink-lt">Feminino</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-lt">Outro</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;">
                                            <?= $paciente->clinica_nome ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-truncate" style="max-width: 150px;">
                                            <?= $paciente->dentista_nome ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-cyan-lt">
                                            <?= $paciente->total_pedidos ?> pedido(s)
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-list flex-nowrap">
                                            <a href="<?= base_url('admin/pacientes/visualizar/' . $paciente->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-primary"
                                               title="Visualizar">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pacientes/editar/' . $paciente->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-info"
                                               title="Editar">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/pacientes/excluir/' . $paciente->id) ?>"
                                               class="btn btn-sm btn-icon btn-ghost-danger"
                                               title="Excluir"
                                               onclick="return confirm('Tem certeza que deseja excluir este paciente?')">
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
