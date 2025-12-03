/**
 * Scripts Customizados - Painel Administrativo
 * Sistema de Orçamento Le Cortine
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */

(function($) {
    'use strict';

    // Inicialização
    $(document).ready(function() {
        initTooltips();
        initPopovers();
        initConfirmDelete();
        initFormValidation();
        initMasks();
        initAutoRefresh();
    });

    /**
     * Inicializar tooltips
     */
    function initTooltips() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    /**
     * Inicializar popovers
     */
    function initPopovers() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    }

    /**
     * Confirmação de exclusão
     */
    function initConfirmDelete() {
        $(document).on('click', '.btn-delete, .delete-item', function(e) {
            e.preventDefault();
            
            const url = $(this).attr('href') || $(this).data('url');
            const title = $(this).data('title') || 'Tem certeza?';
            const text = $(this).data('text') || 'Esta ação não poderá ser desfeita!';
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    }

    /**
     * Validação de formulários
     */
    function initFormValidation() {
        // Validação HTML5
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }

    /**
     * Máscaras de input
     */
    function initMasks() {
        // Telefone
        $('input[type="tel"], .mask-phone').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
            } else {
                value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
            }
            $(this).val(value);
        });

        // CPF
        $('.mask-cpf').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{0,2}).*/, '$1.$2.$3-$4');
            $(this).val(value);
        });

        // CNPJ
        $('.mask-cnpj').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2}).*/, '$1.$2.$3/$4-$5');
            $(this).val(value);
        });

        // CEP
        $('.mask-cep').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            value = value.replace(/^(\d{5})(\d{0,3}).*/, '$1-$2');
            $(this).val(value);
        });

        // Moeda
        $('.mask-money').on('input', function() {
            let value = $(this).val().replace(/\D/g, '');
            value = (parseFloat(value) / 100).toFixed(2);
            value = value.replace('.', ',');
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
            $(this).val('R$ ' + value);
        });
    }

    /**
     * Auto-refresh de dados
     */
    function initAutoRefresh() {
        // Atualizar notificações a cada 30 segundos
        if ($('.nav-item.dropdown .badge').length > 0) {
            setInterval(function() {
                // Implementar chamada AJAX para atualizar notificações
            }, 30000);
        }
    }

    /**
     * Loading overlay
     */
    window.showLoading = function(message = 'Carregando...') {
        const overlay = $('<div class="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">' + message + '</span></div></div>');
        $('body').append(overlay);
    };

    window.hideLoading = function() {
        $('.loading-overlay').remove();
    };

    /**
     * Upload de imagem com preview
     */
    window.initImageUpload = function(inputSelector, previewSelector) {
        $(inputSelector).on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(previewSelector).html('<img src="' + e.target.result + '" class="img-fluid rounded">');
                };
                reader.readAsDataURL(file);
            }
        });
    };

    /**
     * Copiar para clipboard
     */
    window.copyToClipboard = function(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copiado!',
                text: 'Texto copiado para a área de transferência',
                timer: 2000,
                showConfirmButton: false
            });
        });
    };

    /**
     * Formatar moeda
     */
    window.formatMoney = function(value) {
        return 'R$ ' + parseFloat(value).toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    };

    /**
     * Debounce function
     */
    window.debounce = function(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

})(jQuery);
