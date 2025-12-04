<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-users me-2"></i>
                    Editar Paciente
                </h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <form method="post" action="<?= base_url('admin/pacientes/salvar_paciente') ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $paciente->id ?>">

            <!-- Dados Pessoais -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Dados Pessoais</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Nome Completo</label>
                                <input type="text" class="form-control" name="nome" id="nome" value="<?= $paciente->nome ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label required">Data de Nascimento</label>
                                <input type="date" class="form-control" name="data_nascimento" id="data_nascimento" value="<?= $paciente->data_nascimento ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label required">Gênero</label>
                                <select class="form-select" name="genero" id="genero" required>
                                    <option value="">Selecione...</option>
                                    <option value="masculino" <?= $paciente->genero == 'masculino' ? 'selected' : '' ?>>Masculino</option>
                                    <option value="feminino" <?= $paciente->genero == 'feminino' ? 'selected' : '' ?>>Feminino</option>
                                    <option value="outro" <?= $paciente->genero == 'outro' ? 'selected' : '' ?>>Outro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">CPF</label>
                                <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $paciente->cpf ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" name="telefone" id="telefone" value="<?= $paciente->telefone ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?= $paciente->email ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vínculos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Clínica e Dentista</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Clínica</label>
                                <select class="form-select" name="clinica_id" id="clinica_id" required>
                                    <option value="">Selecione a clínica...</option>
                                    <?php foreach ($clinicas as $clinica): ?>
                                        <option value="<?= $clinica->id ?>" <?= $paciente->clinica_id == $clinica->id ? 'selected' : '' ?>>
                                            <?= $clinica->nome ?> - <?= $clinica->cidade ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Dentista</label>
                                <select class="form-select" name="dentista_id" id="dentista_id" required>
                                    <?php foreach ($dentistas as $dentista): ?>
                                        <option value="<?= $dentista->id ?>" <?= $paciente->dentista_id == $dentista->id ? 'selected' : '' ?>>
                                            <?= $dentista->nome ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="form-hint">Selecione uma clínica para carregar os dentistas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Foto do Paciente</h3>
                </div>
                <div class="card-body">
                    <?php if ($paciente->foto): ?>
                        <div class="mb-3">
                            <label class="form-label">Foto Atual</label>
                            <div>
                                <img src="<?= base_url('uploads/pacientes/fotos/' . $paciente->foto) ?>"
                                     alt="Foto"
                                     class="img-thumbnail"
                                     style="max-width: 200px;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">
                            <?= $paciente->foto ? 'Alterar Foto' : 'Foto' ?>
                        </label>
                        <input type="file" class="form-control" name="foto" accept="image/*">
                        <small class="form-hint">JPG ou PNG, máx 2MB</small>
                    </div>
                </div>
            </div>

            <!-- Observações -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Observações</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Observações Adicionais</label>
                        <textarea class="form-control" name="observacoes" rows="4"><?= $paciente->observacoes ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="card">
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="<?= base_url('admin/pacientes') ?>" class="btn btn-link">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="ti ti-device-floppy me-2"></i>
                            Salvar Paciente
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<?php ob_start(); ?>
<script>
$(document).ready(function() {
    // Máscaras
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-00009');

    // Carrega dentistas quando seleciona clínica
    $('#clinica_id').on('change', function() {
        var clinica_id = $(this).val();
        var $dentista_select = $('#dentista_id');

        if (clinica_id) {
            $dentista_select.prop('disabled', true).html('<option value="">Carregando...</option>');

            $.ajax({
                url: BASE_URL + 'admin/pacientes/get_dentistas_por_clinica',
                type: 'POST',
                data: { clinica_id: clinica_id },
                dataType: 'json',
                success: function(dentistas) {
                    $dentista_select.html('<option value="">Selecione o dentista...</option>');

                    if (dentistas.length > 0) {
                        $.each(dentistas, function(i, dentista) {
                            $dentista_select.append(
                                $('<option></option>').val(dentista.id).text(dentista.nome)
                            );
                        });
                        $dentista_select.prop('disabled', false);
                    } else {
                        $dentista_select.html('<option value="">Nenhum dentista encontrado</option>');
                    }
                },
                error: function() {
                    $dentista_select.html('<option value="">Erro ao carregar dentistas</option>');
                }
            });
        } else {
            $dentista_select.prop('disabled', true).html('<option value="">Selecione a clínica primeiro...</option>');
        }
    });
});
</script>
<?php $scripts = ob_get_clean(); ?>
