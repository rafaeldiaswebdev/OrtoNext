<?php
/**
 * Script temporário para gerar hash de senha
 * Executar via navegador: http://localhost/orcamento/gerar_hash.php
 * DELETAR APÓS USO!
 */

$senha = 'admin123';
$hash = password_hash($senha, PASSWORD_DEFAULT);

echo "<h2>Gerador de Hash de Senha</h2>";
echo "<p><strong>Senha:</strong> {$senha}</p>";
echo "<p><strong>Hash:</strong> {$hash}</p>";
echo "<hr>";
echo "<h3>SQL para atualizar:</h3>";
echo "<pre>";
echo "UPDATE usuarios SET senha = '{$hash}' WHERE email = 'admin@lecortine.com.br';";
echo "</pre>";
echo "<hr>";
echo "<p style='color: red;'><strong>IMPORTANTE:</strong> Delete este arquivo após usar!</p>";
?>
