<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-building-hospital me-2"></i>
                    Editar Clínica
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <a href="<?= base_url('admin/clinicas/visualizar/' . $clinica->id) ?>" class="btn btn-info">
                    <i class="ti ti-eye me-2"></i>
                    Visualizar
                </a>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">

        <form method="post" enctype="multipart/form-data">

            <!-- Dados Principais -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Dados da Clínica</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label required">Nome da Clínica</label>
                                <input type="text" class="form-control" name="nome" value="<?= $clinica->nome ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">CNPJ</label>
                                <input type="text" class="form-control" name="cnpj" id="cnpj" value="<?= $this->Clinica_model->formatar_cnpj($clinica->cnpj) ?>" required>
                                <small class="form-hint">Formato: 00.000.000/0000-00</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Responsável Técnico</label>
                                <input type="text" class="form-control" name="responsavel_tecnico" value="<?= $clinica->responsavel_tecnico ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">CRO do Responsável</label>
                                <input type="text" class="form-control" name="cro_responsavel" value="<?= $clinica->cro_responsavel ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Endereço -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Endereço</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">CEP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cep" id="cep" value="<?= $clinica->cep ?>">
                                    <button type="button" class="btn btn-primary" id="buscar-cep">
                                        <i class="ti ti-search"></i>
                                    </button>
                                </div>
                                <small class="form-hint">Formato: 00000-000</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Logradouro</label>
                                <input type="text" class="form-control" name="logradouro" id="logradouro" value="<?= $clinica->logradouro ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="numero" value="<?= $clinica->numero ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Complemento</label>
                                <input type="text" class="form-control" name="complemento" value="<?= $clinica->complemento ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control" name="bairro" id="bairro" value="<?= $clinica->bairro ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" name="cidade" id="cidade" value="<?= $clinica->cidade ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <label class="form-label">UF</label>
                                <input type="text" class="form-control" name="estado" id="estado" value="<?= $clinica->estado ?>" maxlength="2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contatos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Contatos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="text" class="form-control" name="telefone" id="telefone" value="<?= $clinica->telefone ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" value="<?= $clinica->whatsapp ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" value="<?= $clinica->email ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logo e Documentos -->
            <div class="card mb-3">
                <div class="card-header">
                    <h3 class="card-title">Logo e Documentos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Logo da Clínica</label>
                                <?php if ($clinica->logo): ?>
                                <div class="mb-2">
                                    <img src="<?= base_url('uploads/clinicas/logos/' . $clinica->logo) ?>" alt="Logo" style="max-height: 100px;">
                                    <div class="small text-muted">Logo atual</div>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="logo" accept=".png">
                                <small class="form-hint">PNG, máx 5MB, recomendado 3210x3210px com fundo branco. Deixe em branco para manter o atual.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CNH do Responsável</label>
                                <?php if ($clinica->doc_cnh): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cnh) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file"></i> Ver documento atual
                                    </a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="doc_cnh" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB. Deixe em branco para manter o atual.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">RG do Responsável</label>
                                <?php if ($clinica->doc_rg): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_rg) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file"></i> Ver documento atual
                                    </a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="doc_rg" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB. Deixe em branco para manter o atual.</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF do Responsável</label>
                                <?php if ($clinica->doc_cpf): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cpf) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file"></i> Ver documento atual
                                    </a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="doc_cpf" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB. Deixe em branco para manter o atual.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CRO do Responsável</label>
                                <?php if ($clinica->doc_cro): ?>
                                <div class="mb-2">
                                    <a href="<?= base_url('uploads/clinicas/documentos/' . $clinica->doc_cro) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file"></i> Ver documento atual
                                    </a>
                                </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" name="doc_cro" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB. Deixe em branco para manter o atual.</small>
                            </div>
                        </div>
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
                        <textarea class="form-control" name="observacoes" rows="4"><?= $clinica->observacoes ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Botões -->
            <div class="card">
                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="<?= base_url('admin/clinicas') ?>" class="btn btn-link">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="ti ti-device-floppy me-2"></i>
                            Atualizar Clínica
                        </button>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>

<script>
$(document).ready(function() {
    // Máscaras
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cep').mask('00000-000');
    $('#telefone').mask('(00) 0000-00009');
    $('#whatsapp').mask('(00) 0000-00009');

    // Buscar dados da clínica por CNPJ via ReceitaWS
    $('#cnpj').blur(function() {
        var cnpj_consultado = $(this).val().replace(/\D/g, '');

        if (cnpj_consultado != '' && cnpj_consultado.length == 14) {
            // Validação básica de CNPJ
            var validacnpj = /^[0-9]{14}$/;

            if (validacnpj.test(cnpj_consultado)) {
                // Confirma se deseja buscar novos dados
                Swal.fire({
                    title: 'Buscar dados do CNPJ?',
                    text: 'Isso irá sobrescrever os dados atuais com as informações da Receita Federal.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim, buscar',
                    cancelButtonText: 'Não'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostra loading
                        Swal.fire({
                            title: 'Buscando dados...',
                            text: 'Consultando CNPJ na Receita Federal',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Consulta ReceitaWS
                        $.getJSON('https://www.receitaws.com.br/v1/cnpj/' + cnpj_consultado + '/?callback=?', function(dados) {
                            Swal.close();

                            if (!('erro' in dados)) {
                                // Preenche os campos com os dados retornados
                                if (dados.nome) {
                                    $('input[name="nome"]').val(dados.nome);
                                }

                                if (dados.fantasia && dados.fantasia != '') {
                                    $('input[name="nome"]').val(dados.fantasia);
                                }

                                if (dados.telefone) {
                                    var tel = dados.telefone.replace(/\D/g, '');
                                    if (tel.length >= 10) {
                                        $('input[name="telefone"]').val(dados.telefone);
                                    }
                                }

                                if (dados.email) {
                                    $('input[name="email"]').val(dados.email);
                                }

                                // Preenche endereço
                                if (dados.cep) {
                                    $('input[name="cep"]').val(dados.cep.replace(/\D/g, ''));
                                }

                                if (dados.logradouro) {
                                    $('input[name="logradouro"]').val(dados.logradouro);
                                }

                                if (dados.numero) {
                                    $('input[name="numero"]').val(dados.numero);
                                }

                                if (dados.complemento) {
                                    $('input[name="complemento"]').val(dados.complemento);
                                }

                                if (dados.bairro) {
                                    $('input[name="bairro"]').val(dados.bairro);
                                }

                                if (dados.municipio) {
                                    $('input[name="cidade"]').val(dados.municipio);
                                }

                                if (dados.uf) {
                                    $('input[name="estado"]').val(dados.uf);
                                }

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Dados atualizados!',
                                    text: 'Os campos foram preenchidos com os dados da Receita Federal.',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'CNPJ não encontrado',
                                    text: 'Não foi possível encontrar dados para este CNPJ.',
                                    timer: 3000,
                                    showConfirmButton: false
                                });
                            }
                        }).fail(function() {
                            Swal.close();
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro na consulta',
                                text: 'Não foi possível consultar o CNPJ. Tente novamente.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        });
                    }
                });
            }
        }
    });

    // Buscar CEP via ViaCEP (fallback manual)
    $('#buscar-cep').click(function() {
        var cep = $('#cep').val().replace(/\D/g, '');

        if (cep.length != 8) {
            Swal.fire('Atenção', 'CEP inválido', 'warning');
            return;
        }

        $(this).html('<span class="spinner-border spinner-border-sm"></span>');
        $(this).prop('disabled', true);

        // Consulta ViaCEP
        $.getJSON('https://viacep.com.br/ws/' + cep + '/json/?callback=?', function(dados) {
            if (!('erro' in dados)) {
                $('#logradouro').val(dados.logradouro);
                $('#bairro').val(dados.bairro);
                $('#cidade').val(dados.localidade);
                $('#estado').val(dados.uf);

                Swal.fire({
                    icon: 'success',
                    title: 'CEP encontrado!',
                    text: 'Endereço preenchido automaticamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Erro', 'CEP não encontrado', 'error');
            }
        }).fail(function() {
            Swal.fire('Erro', 'Erro ao buscar CEP', 'error');
        }).always(function() {
            $('#buscar-cep').html('<i class="ti ti-search"></i>');
            $('#buscar-cep').prop('disabled', false);
        });
    });
});
</script>
