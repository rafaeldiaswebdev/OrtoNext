# 📋 Instruções de Instalação - CRUD de Clínicas

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025

---

## ✅ Arquivos Criados

### Models
- ✅ `application/models/Clinica_model.php`

### Controllers
- ✅ `application/controllers/admin/Clinicas.php`

### Views
- ✅ `application/views/admin/clinicas/index.php`
- ✅ `application/views/admin/clinicas/criar.php`
- ✅ `application/views/admin/clinicas/editar.php`
- ✅ `application/views/admin/clinicas/visualizar.php`

### Atualizações
- ✅ `application/views/admin/layout/header.php` - Adicionado menu Clínicas
- ✅ `application/views/admin/layout/footer.php` - Adicionado jQuery Mask

---

## 📁 Estrutura de Pastas para Upload

Você precisa criar as seguintes pastas dentro de `uploads/`:

```
uploads/
├── clinicas/
│   ├── logos/
│   └── documentos/
├── dentistas/
│   ├── fotos/
│   └── documentos/
├── pacientes/
│   └── fotos/
└── pedidos/
    ├── escaneamentos/
    ├── stl/
    └── documentos/
```

### Comandos para criar as pastas (Windows PowerShell):

```powershell
# Navegue até a pasta do projeto
cd c:\xampp\htdocs\alinhadores\uploads

# Crie as pastas
mkdir clinicas\logos
mkdir clinicas\documentos
mkdir dentistas\fotos
mkdir dentistas\documentos
mkdir pacientes\fotos
mkdir pedidos\escaneamentos
mkdir pedidos\stl
mkdir pedidos\documentos
```

### Ou crie manualmente:

1. Acesse `c:\xampp\htdocs\alinhadores\uploads\`
2. Crie a pasta `clinicas`
3. Dentro de `clinicas`, crie as pastas `logos` e `documentos`
4. Repita para as demais estruturas

---

## 🔒 Segurança dos Uploads

Crie um arquivo `.htaccess` dentro da pasta `uploads/` com o seguinte conteúdo:

```apache
# Proteção de arquivos
<FilesMatch "\.(php|php3|php4|php5|phtml|pl|py|jsp|asp|sh|cgi)$">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Permitir acesso apenas a arquivos específicos
<FilesMatch "\.(jpg|jpeg|png|gif|pdf|stl|zip)$">
    Order Allow,Deny
    Allow from all
</FilesMatch>

# Desabilitar listagem de diretórios
Options -Indexes

# Desabilitar execução de scripts
php_flag engine off
```

---

## 🗄️ Banco de Dados

O banco de dados já deve estar criado com as tabelas do roadmap. Verifique se a tabela `clinicas` existe:

```sql
SHOW TABLES LIKE 'clinicas';
```

Se não existir, execute o script SQL do roadmap.

---

## 🧪 Testando o CRUD

### 1. Acesse o sistema
```
http://localhost/alinhadores/admin/clinicas
```

### 2. Teste a listagem
- Deve aparecer a página com filtros
- Mensagem "Nenhuma clínica encontrada" se não houver registros

### 3. Teste o cadastro
- Clique em "Nova Clínica"
- Preencha os campos obrigatórios:
  - Nome da Clínica
  - CNPJ (com validação)
  - Responsável Técnico
  - CRO do Responsável
- Teste a busca de CEP
- Faça upload de logo (PNG)
- Faça upload de documentos (PDF ou imagem)
- Salve

### 4. Teste a edição
- Clique em editar uma clínica
- Altere alguns dados
- Faça upload de novos arquivos (opcional)
- Salve

### 5. Teste a visualização
- Clique em visualizar uma clínica
- Verifique se todos os dados aparecem
- Teste o download de documentos
- Verifique as estatísticas

### 6. Teste a validação (Admin)
- Na visualização, altere o status de validação
- Adicione observações
- Salve

### 7. Teste a exclusão
- Tente excluir uma clínica sem vínculos
- Deve excluir com sucesso
- Tente excluir uma clínica com vínculos (quando houver)
- Deve mostrar erro

---

## 🐛 Possíveis Problemas e Soluções

### Erro: "Unable to create directory"
**Solução:** Verifique as permissões da pasta `uploads/`
```powershell
# No Windows, não é necessário alterar permissões geralmente
# Mas certifique-se que o Apache tem permissão de escrita
```

### Erro: "The upload path does not appear to be valid"
**Solução:** Verifique se as pastas foram criadas corretamente
```
uploads/clinicas/logos/
uploads/clinicas/documentos/
```

### Erro: "The filetype you are attempting to upload is not allowed"
**Solução:** Verifique as extensões permitidas no controller:
- Logo: apenas PNG
- Documentos: PDF, JPG, JPEG, PNG

### Erro ao buscar CEP
**Solução:** Verifique se o CURL está habilitado no PHP
```ini
; No php.ini, certifique-se que está descomentado:
extension=curl
```

### Máscaras não funcionam
**Solução:** Verifique se o jQuery Mask foi carregado no footer
```html
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
```

### Menu Clínicas não aparece
**Solução:** Limpe o cache do navegador (Ctrl + F5)

---

## ✅ Checklist de Validação

- [ ] Banco de dados criado com tabela `clinicas`
- [ ] Pastas de upload criadas
- [ ] Arquivo .htaccess criado em `uploads/`
- [ ] Menu "Clínicas" aparece no header
- [ ] Listagem funciona
- [ ] Cadastro funciona
- [ ] Upload de logo funciona
- [ ] Upload de documentos funciona
- [ ] Busca de CEP funciona
- [ ] Máscaras de CNPJ, CEP, telefone funcionam
- [ ] Edição funciona
- [ ] Visualização funciona
- [ ] Validação de documentos funciona (admin)
- [ ] Exclusão funciona
- [ ] Logs são registrados

---

## 📝 Funcionalidades Implementadas

### ✅ Listagem
- Tabela responsiva com dados principais
- Filtros por nome/CNPJ, cidade e status de validação
- Busca em tempo real
- Badges coloridos por status
- Botões de ação (visualizar, editar, excluir)

### ✅ Cadastro
- Formulário completo com validação
- Validação de CNPJ (algoritmo completo)
- Busca de CEP via API ViaCEP
- Upload de logo (PNG, máx 5MB)
- Upload de 4 documentos (PDF/imagem, máx 5MB cada)
- Máscaras de input (CNPJ, CEP, telefone)
- Feedback visual com SweetAlert2

### ✅ Edição
- Formulário pré-preenchido
- Manutenção de arquivos existentes
- Substituição opcional de arquivos
- Visualização de documentos atuais
- Validações completas

### ✅ Visualização
- Layout em 2 colunas (principal + sidebar)
- Exibição de logo
- Dados completos da clínica
- Lista de documentos com download
- Lista de dentistas vinculados
- Lista de pacientes
- Estatísticas (dentistas, pacientes, pedidos)
- Sistema de validação (admin)
- Informações de auditoria

### ✅ Validação
- Sistema de aprovação de documentos
- 3 status: Pendente, Aprovado, Reprovado
- Campo de observações
- Restrito a administradores
- Registro em logs

### ✅ Exclusão
- Verificação de vínculos (dentistas e pacientes)
- Remoção de arquivos físicos
- Confirmação antes de excluir
- Registro em logs

---

## 🚀 Próximos Passos

Após validar que o CRUD de Clínicas está funcionando perfeitamente:

1. **CRUD de Dentistas** (Fase 3)
   - Vínculo com múltiplas clínicas
   - Upload de foto e documentos

2. **CRUD de Pacientes** (Fase 4)
   - Vínculo com clínica e dentista
   - Upload de foto

3. **Módulo de Pedidos** (Fase 5)
   - Campos dinâmicos por tipo
   - Upload de arquivos STL
   - Sistema de status

---

## 📞 Suporte

Se encontrar algum problema:

1. Verifique os logs do PHP: `application/logs/`
2. Verifique os logs do Apache
3. Verifique o console do navegador (F12)
4. Revise este documento de instruções

---

**Documento criado em:** 03/12/2025
**Última atualização:** 03/12/2025
