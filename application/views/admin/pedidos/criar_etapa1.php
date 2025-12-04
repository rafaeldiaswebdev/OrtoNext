<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Novo Pedido</div>
                <h2 class="page-title">
                    <i class="ti ti-file-plus me-2"></i>
                    Etapa 1 de 3 - Selecionar Paciente
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
                    <div class="step-item active">
                        <div class="h4 m-0">Paciente</div>
                    </div>
                    <div class="step-item">
                        <div class="h4 m-0">Tipo de Pedido</div>
                    </div>
                    <div class="step-item">
                        <div class="h4 m-0">Dados do Pedido</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Busca de Paciente -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Buscar Paciente</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control mb-3" id="busca_paciente" placeholder="Digite o nome ou CPF do paciente...">
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Pacientes -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Selecione o Paciente</h3>
                <div class="card-actions">
                    <span class="text-muted"><?= count($pacientes) ?> paciente(s) encontrado(s)</span>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover" id="tabela_pacientes">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Idade</th>
                            <th>Clínica</th>
                            <th>Dentista</th>
                            <th class="w-1">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pacientes)): ?>
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="ti ti-users-off fs-1 mb-2"></i>
                                    <p>Nenhum paciente cadastrado</p>
                                    <a href="<?= base_url('admin/pacientes/criar') ?>" class="btn btn-primary">
                                        <i class="ti ti-plus me-2"></i>
                                        Cadastrar Primeiro Paciente
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pacientes as $paciente): ?>
                                <tr class="paciente-row">
                                    <td>
                                        <?php if ($paciente->foto): ?>
                                            <span class="avatar" style="background-image: url(<?= base_url($paciente->foto) ?>)"></span>
                                        <?php else: ?>
                                            <span class="avatar">
                                                <?= strtoupper(substr($paciente->nome, 0, 2)) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="paciente-nome">
                                        <div class="text-reset"><?= $paciente->nome ?></div>
                                    </td>
                                    <td class="paciente-cpf">
                                        <span class="text-muted"><?= $paciente->cpf ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $idade = floor((time() - strtotime($paciente->data_nascimento)) / 31556926);
                                        echo $idade . ' anos';
                                        ?>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?= $paciente->clinica_nome ?></span>
                                    </td>
                                    <td>
                                        <span class="text-muted"><?= $paciente->dentista_nome ?></span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/pedidos/criar?paciente_id=' . $paciente->id) ?>" class="btn btn-primary btn-sm">
                                            <i class="ti ti-arrow-right me-1"></i>
                                            Selecionar
                                        </a>
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
// Busca de pacientes
document.getElementById('busca_paciente').addEventListener('keyup', function() {
    var busca = this.value.toLowerCase();
    var linhas = document.querySelectorAll('.paciente-row');

    linhas.forEach(function(linha) {
        var nome = linha.querySelector('.paciente-nome').textContent.toLowerCase();
        var cpf = linha.querySelector('.paciente-cpf').textContent.toLowerCase();

        if (nome.includes(busca) || cpf.includes(busca)) {
            linha.style.display = '';
        } else {
            linha.style.display = 'none';
        }
    });
});
</script>
<?php $scripts = ob_get_clean(); ?>
