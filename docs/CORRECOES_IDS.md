# 🔧 Correções: IDs dos Campos

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025

---

## ❌ Problema Identificado

Alguns campos do formulário **não tinham ID**, apenas `name`, o que impedia o JavaScript de preencher os valores corretamente.

---

## ✅ Correções Aplicadas

### Campos que receberam ID:

| Campo | Name | ID Adicionado | Arquivo |
|-------|------|---------------|---------|
| Nome da Clínica | `nome` | `id="nome"` | criar.php |
| Email | `email` | `id="email"` | criar.php |
| Número | `numero` | `id="numero"` | criar.php |
| Complemento | `complemento` | `id="complemento"` | criar.php |

### Campos que JÁ tinham ID:

| Campo | ID |
|-------|----|
| CNPJ | `id="cnpj"` |
| CEP | `id="cep"` |
| Logradouro | `id="logradouro"` |
| Bairro | `id="bairro"` |
| Cidade | `id="cidade"` |
| Estado | `id="estado"` |
| Telefone | `id="telefone"` |
| WhatsApp | `id="whatsapp"` |

---

## 🔄 Mudanças no JavaScript

### ❌ Antes (Seletores por name):
```javascript
$('input[name="nome"]').val(dados.nome);
$('input[name="email"]').val(dados.email);
$('input[name="numero"]').val(dados.numero);
```

**Problemas:**
- Mais lento
- Menos específico
- Pode pegar campos errados se houver duplicação

### ✅ Depois (Seletores por ID):
```javascript
$('#nome').val(dados.nome);
$('#email').val(dados.email);
$('#numero').val(dados.numero);
```

**Vantagens:**
- Mais rápido (ID é único)
- Mais específico
- Melhor prática

---

## 📄 Página de Teste Criada

### Arquivo: `teste_apis.html`

**Localização:** `c:\xampp\htdocs\alinhadores\teste_apis.html`

**Acesso:** `http://localhost/alinhadores/teste_apis.html`

### Funcionalidades:

✅ **Teste isolado de ReceitaWS**
- Console visual com logs
- Campos separados para visualização
- Mensagens de erro detalhadas

✅ **Teste isolado de ViaCEP**
- Console visual com logs
- Campos separados para visualização
- Mensagens de erro detalhadas

✅ **CNPJs e CEPs de teste**
- Lista de CNPJs válidos
- Lista de CEPs válidos

✅ **Debug visual**
- Logs coloridos (sucesso, erro, warning, info)
- Timestamp em cada log
- Scroll automático

---

## 🧪 Como Testar

### 1. Teste a Página Isolada

```
http://localhost/alinhadores/teste_apis.html
```

**Teste ReceitaWS:**
1. Digite CNPJ: `00.000.000/0001-91`
2. Clique em "Buscar CNPJ"
3. Veja os logs no console visual
4. Campos devem ser preenchidos

**Teste ViaCEP:**
1. Digite CEP: `01310-100`
2. Clique em "Buscar CEP"
3. Veja os logs no console visual
4. Campos devem ser preenchidos

### 2. Teste no Formulário Real

```
http://localhost/alinhadores/admin/clinicas/criar
```

**Teste CNPJ:**
1. Digite CNPJ: `00.000.000/0001-91`
2. Clique fora do campo (Tab)
3. Abra o console (F12)
4. Veja os logs
5. Campos devem ser preenchidos

**Teste CEP:**
1. Digite CEP: `01310-100`
2. Clique no botão de buscar
3. Veja os logs no console
4. Campos de endereço devem ser preenchidos

---

## 📊 Mapeamento Completo: API → Campos

### ReceitaWS → Formulário

| Campo API | Campo Formulário | ID |
|-----------|------------------|-----|
| `dados.nome` | Nome da Clínica | `#nome` |
| `dados.fantasia` | Nome da Clínica | `#nome` (sobrescreve) |
| `dados.telefone` | Telefone | `#telefone` |
| `dados.email` | Email | `#email` |
| `dados.cep` | CEP | `#cep` |
| `dados.logradouro` | Logradouro | `#logradouro` |
| `dados.numero` | Número | `#numero` |
| `dados.complemento` | Complemento | `#complemento` |
| `dados.bairro` | Bairro | `#bairro` |
| `dados.municipio` | Cidade | `#cidade` |
| `dados.uf` | Estado | `#estado` |

### ViaCEP → Formulário

| Campo API | Campo Formulário | ID |
|-----------|------------------|-----|
| `dados.logradouro` | Logradouro | `#logradouro` |
| `dados.bairro` | Bairro | `#bairro` |
| `dados.localidade` | Cidade | `#cidade` |
| `dados.uf` | Estado | `#estado` |

---

## ✅ Checklist de Validação

### IDs dos Campos
- [x] `#cnpj` - CNPJ
- [x] `#nome` - Nome da Clínica
- [x] `#telefone` - Telefone
- [x] `#email` - Email
- [x] `#cep` - CEP
- [x] `#logradouro` - Logradouro
- [x] `#numero` - Número
- [x] `#complemento` - Complemento
- [x] `#bairro` - Bairro
- [x] `#cidade` - Cidade
- [x] `#estado` - Estado
- [x] `#whatsapp` - WhatsApp

### JavaScript
- [x] Seletores usando ID (#)
- [x] Logs de debug adicionados
- [x] Tratamento de erros
- [x] Fallback sem SweetAlert

### Página de Teste
- [x] Console visual criado
- [x] Logs coloridos
- [x] CNPJs de teste listados
- [x] CEPs de teste listados
- [x] Campos readonly para visualização

---

## 🎯 Próximos Passos

1. **Testar página isolada** (`teste_apis.html`)
   - Se funcionar → APIs estão OK
   - Se não funcionar → Problema de rede/CORS

2. **Testar formulário real** (`admin/clinicas/criar`)
   - Se funcionar → Tudo OK!
   - Se não funcionar → Verificar console

3. **Aplicar mesmas correções** em `editar.php`

---

## 📝 Observações Importantes

### Campos NÃO preenchidos pela API:
- ❌ Responsável Técnico (não vem da ReceitaWS)
- ❌ CRO do Responsável (não vem da ReceitaWS)
- ❌ WhatsApp (não vem da ReceitaWS)
- ❌ Logo (sempre upload manual)
- ❌ Documentos (sempre upload manual)

### Prioridade de Preenchimento:
1. Se `dados.fantasia` existe → usa no campo `nome`
2. Se não → usa `dados.nome`
3. Isso garante que o nome mais usado aparece primeiro

---

**Documento criado em:** 03/12/2025
**Última atualização:** 03/12/2025
