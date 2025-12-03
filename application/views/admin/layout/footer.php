            <!-- Footer -->
            <footer class="footer footer-transparent d-print-none">
                <div class="container-xl">
                    <div class="row text-center align-items-center flex-row-reverse">
                        <div class="col-lg-auto ms-lg-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a href="<?= base_url() ?>" target="_blank" class="link-secondary">
                                        <i class="ti ti-world me-1"></i> Ver Site
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="<?= base_url('admin/ajuda') ?>" class="link-secondary">
                                        <i class="ti ti-help me-1"></i> Ajuda
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    Copyright &copy; <?= date('Y') ?>
                                    <a href="https://lecortine.com.br" class="link-secondary">Le Cortine</a>.
                                    Todos os direitos reservados.
                                </li>
                                <li class="list-inline-item">
                                    Desenvolvido por <a href="https://doisr.com.br" target="_blank" class="link-secondary">Rafael Dias - doisr.com.br</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- jQuery (DEVE vir ANTES de tudo) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Libs JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>

    <!-- jQuery Mask Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- Custom JS -->
    <script src="<?= base_url('assets/js/admin.js') ?>"></script>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('sucesso')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: '<?= $this->session->flashdata('sucesso') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('erro')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'error',
                title: 'Erro!',
                text: '<?= $this->session->flashdata('erro') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('aviso')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'warning',
                title: 'Atenção!',
                text: '<?= $this->session->flashdata('aviso') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('info')): ?>
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: 'info',
                title: 'Informação',
                text: '<?= $this->session->flashdata('info') ?>',
                timer: 3000,
                showConfirmButton: false
            });
        });
    </script>
    <?php endif; ?>

    <!-- Scripts adicionais da página -->
    <?php if (isset($scripts)): ?>
        <?= $scripts ?>
    <?php endif; ?>
</body>
</html>
