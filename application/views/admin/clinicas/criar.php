<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Gerenciar</div>
                <h2 class="page-title">
                    <i class="ti ti-building-hospital me-2"></i>
                    Nova Clínica
                </h2>
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
                                <input type="text" class="form-control" name="nome" id="nome" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">CNPJ</label>
                                <input type="text" class="form-control" name="cnpj" id="cnpj" required>
                                <small class="form-hint">Formato: 00.000.000/0000-00</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Responsável Técnico</label>
                                <input type="text" class="form-control" name="responsavel_tecnico" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">CRO do Responsável</label>
                                <input type="text" class="form-control" name="cro_responsavel" required>
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
                                <input type="text" class="form-control" name="cep" id="cep">
                                <small class="form-hint">Formato: 00000-000</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Logradouro</label>
                                <input type="text" class="form-control" name="logradouro" id="logradouro">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="numero" id="numero">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Complemento</label>
                                <input type="text" class="form-control" name="complemento" id="complemento">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control" name="bairro" id="bairro">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control" name="cidade" id="cidade">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="mb-3">
                                <label class="form-label">UF</label>
                                <input type="text" class="form-control" name="estado" id="estado" maxlength="2">
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
                                <input type="text" class="form-control" name="telefone" id="telefone">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" name="whatsapp" id="whatsapp">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" class="form-control" name="email" id="email">
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
                                <input type="file" class="form-control" name="logo" accept=".png">
                                <small class="form-hint">PNG, máx 5MB, recomendado 3210x3210px com fundo branco</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CNH do Responsável</label>
                                <input type="file" class="form-control" name="doc_cnh" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">RG do Responsável</label>
                                <input type="file" class="form-control" name="doc_rg" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CPF do Responsável</label>
                                <input type="file" class="form-control" name="doc_cpf" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">CRO do Responsável</label>
                                <input type="file" class="form-control" name="doc_cro" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="form-hint">PDF ou imagem, máx 5MB</small>
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
                        <textarea class="form-control" name="observacoes" rows="4"></textarea>
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
                            Salvar Clínica
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
});
</script>
