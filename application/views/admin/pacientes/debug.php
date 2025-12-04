<!DOCTYPE html>
<html>
<head>
    <title>Debug - Carregar Dentistas</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <h1>Debug - Carregar Dentistas por Clínica</h1>

    <div>
        <label>Clínica ID:</label>
        <input type="number" id="clinica_id" value="3">
        <button id="testar">Testar</button>
    </div>

    <div style="margin-top: 20px;">
        <h3>Resultado:</h3>
        <pre id="resultado"></pre>
    </div>

    <script>
        var BASE_URL = '<?= base_url() ?>';

        $('#testar').click(function() {
            var clinica_id = $('#clinica_id').val();

            $('#resultado').html('Carregando...');

            $.ajax({
                url: BASE_URL + 'admin/pacientes/get_dentistas_por_clinica',
                type: 'POST',
                data: { clinica_id: clinica_id },
                dataType: 'json',
                success: function(dentistas) {
                    $('#resultado').html(JSON.stringify(dentistas, null, 2));
                },
                error: function(xhr, status, error) {
                    $('#resultado').html('ERRO:\n' + xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
