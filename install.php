<?php
/**
 * Script de Instalação - Sistema de Orçamento Le Cortine
 * 
 * IMPORTANTE: DELETE ESTE ARQUIVO APÓS A INSTALAÇÃO!
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */

// Configurações do banco de dados
$db_config = [
    'host' => '177.136.251.242',
    'user' => 'cecriativocom_orc_lecortine',
    'pass' => 'c$uZaCQh{%Dh7kc=2025',
    'name' => 'cecriativocom_lecortine_orc'
];

// Credenciais do admin
$admin = [
    'nome' => 'Administrador',
    'email' => 'admin@lecortine.com.br',
    'senha' => 'admin123',
    'telefone' => '(11) 99999-9999'
];

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - Le Cortine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; }
        .install-card { max-width: 600px; margin: 50px auto; }
        .step { display: none; }
        .step.active { display: block; }
        .log { background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto; font-family: monospace; font-size: 12px; }
        .log-success { color: #28a745; }
        .log-error { color: #dc3545; }
        .log-info { color: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <div class="install-card">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">🚀 Instalação - Sistema Le Cortine</h3>
                </div>
                <div class="card-body">
                    
                    <!-- Passo 1: Bem-vindo -->
                    <div class="step active" id="step1">
                        <h4>Bem-vindo à Instalação</h4>
                        <p>Este assistente irá configurar o sistema automaticamente.</p>
                        <div class="alert alert-info">
                            <strong>O que será feito:</strong>
                            <ul>
                                <li>Verificar conexão com banco de dados</li>
                                <li>Criar tabelas necessárias</li>
                                <li>Criar usuário administrador</li>
                                <li>Inserir dados iniciais</li>
                            </ul>
                        </div>
                        <div class="alert alert-warning">
                            <strong>⚠️ IMPORTANTE:</strong> Delete este arquivo (install.php) após a instalação!
                        </div>
                        <button class="btn btn-primary" onclick="nextStep(2)">Iniciar Instalação</button>
                    </div>
                    
                    <!-- Passo 2: Instalação -->
                    <div class="step" id="step2">
                        <h4>Instalando...</h4>
                        <div class="log" id="log"></div>
                        <div class="mt-3">
                            <button class="btn btn-success" id="btnConcluir" style="display:none;" onclick="nextStep(3)">
                                Concluir Instalação
                            </button>
                        </div>
                    </div>
                    
                    <!-- Passo 3: Concluído -->
                    <div class="step" id="step3">
                        <div class="text-center">
                            <h2 class="text-success">✅ Instalação Concluída!</h2>
                            <p class="lead">O sistema está pronto para uso.</p>
                            
                            <div class="alert alert-success">
                                <h5>Credenciais de Acesso:</h5>
                                <p class="mb-0">
                                    <strong>Email:</strong> <?= $admin['email'] ?><br>
                                    <strong>Senha:</strong> <?= $admin['senha'] ?>
                                </p>
                            </div>
                            
                            <div class="alert alert-danger">
                                <strong>🔒 SEGURANÇA:</strong><br>
                                1. Delete o arquivo <code>install.php</code><br>
                                2. Delete o arquivo <code>gerar_hash.php</code><br>
                                3. Altere a senha do admin após o primeiro login
                            </div>
                            
                            <a href="login" class="btn btn-primary btn-lg">
                                Acessar Sistema
                            </a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
        function nextStep(step) {
            document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));
            document.getElementById('step' + step).classList.add('active');
            
            if (step === 2) {
                runInstallation();
            }
        }
        
        function log(message, type = 'info') {
            const logEl = document.getElementById('log');
            const className = 'log-' + type;
            logEl.innerHTML += `<div class="${className}">${message}</div>`;
            logEl.scrollTop = logEl.scrollHeight;
        }
        
        function runInstallation() {
            log('🚀 Iniciando instalação...', 'info');
            
            // Fazer requisição AJAX para instalar
            fetch('install.php?action=install')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.logs.forEach(logItem => {
                            log(logItem.message, logItem.type);
                        });
                        document.getElementById('btnConcluir').style.display = 'block';
                    } else {
                        log('❌ Erro na instalação: ' + data.error, 'error');
                    }
                })
                .catch(error => {
                    log('❌ Erro: ' + error.message, 'error');
                });
        }
    </script>
</body>
</html>

<?php
// Processar instalação via AJAX
if (isset($_GET['action']) && $_GET['action'] === 'install') {
    header('Content-Type: application/json');
    
    $logs = [];
    $success = true;
    
    try {
        // Conectar ao banco
        $logs[] = ['message' => '📡 Conectando ao banco de dados...', 'type' => 'info'];
        $conn = new mysqli($db_config['host'], $db_config['user'], $db_config['pass'], $db_config['name']);
        
        if ($conn->connect_error) {
            throw new Exception('Erro de conexão: ' . $conn->connect_error);
        }
        $logs[] = ['message' => '✅ Conectado ao banco de dados', 'type' => 'success'];
        
        // Ler e executar SQL
        $logs[] = ['message' => '📄 Lendo arquivo SQL...', 'type' => 'info'];
        $sql_file = __DIR__ . '/docs/EXECUTAR_ESTE.sql';
        
        if (!file_exists($sql_file)) {
            throw new Exception('Arquivo SQL não encontrado: ' . $sql_file);
        }
        
        $sql = file_get_contents($sql_file);
        $logs[] = ['message' => '✅ Arquivo SQL carregado', 'type' => 'success'];
        
        // Executar SQL
        $logs[] = ['message' => '⚙️ Executando SQL...', 'type' => 'info'];
        
        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        }
        
        if ($conn->error) {
            throw new Exception('Erro ao executar SQL: ' . $conn->error);
        }
        
        $logs[] = ['message' => '✅ Tabelas criadas com sucesso', 'type' => 'success'];
        
        // Criar usuário admin com hash correto
        $logs[] = ['message' => '👤 Criando usuário administrador...', 'type' => 'info'];
        
        $senha_hash = password_hash($admin['senha'], PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $admin['email']);
        $stmt->execute();
        
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, telefone, nivel, status, criado_em) VALUES (?, ?, ?, ?, 'admin', 'ativo', NOW())");
        $stmt->bind_param("ssss", $admin['nome'], $admin['email'], $senha_hash, $admin['telefone']);
        
        if (!$stmt->execute()) {
            throw new Exception('Erro ao criar usuário: ' . $stmt->error);
        }
        
        $logs[] = ['message' => '✅ Usuário administrador criado', 'type' => 'success'];
        $logs[] = ['message' => '📧 Email: ' . $admin['email'], 'type' => 'info'];
        $logs[] = ['message' => '🔑 Senha: ' . $admin['senha'], 'type' => 'info'];
        
        $conn->close();
        
        $logs[] = ['message' => '🎉 Instalação concluída com sucesso!', 'type' => 'success'];
        
    } catch (Exception $e) {
        $success = false;
        $logs[] = ['message' => '❌ ERRO: ' . $e->getMessage(), 'type' => 'error'];
    }
    
    echo json_encode([
        'success' => $success,
        'logs' => $logs
    ]);
    exit;
}
?>
