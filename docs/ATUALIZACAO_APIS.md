# 🔄 Atualização: Integração com APIs ReceitaWS e ViaCEP

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025

---

## 📊 Decisão de Implementação

Após análise dos modelos fornecidos, optamos pela **melhor solução**:

### ✅ Solução Implementada: APIs Combinadas

1. **ReceitaWS** - Busca automática de dados da clínica pelo CNPJ
2. **ViaCEP** - Busca manual de endereço (fallback)

---

## 🎯 Por que esta solução?

### Vantagens da ReceitaWS
- ✅ **Uma única consulta** preenche múltiplos campos
- ✅ **Dados oficiais** da Receita Federal
- ✅ **Melhor UX** - usuário só digita o CNPJ
- ✅ **Menos requisições** ao servidor
- ✅ Retorna: nome, fantasia, telefone, email, endereço completo

### Vantagens de manter ViaCEP
- ✅ **Fallback** caso ReceitaWS não retorne endereço
- ✅ **Flexibilidade** para correção manual de endereço
- ✅ **Confiabilidade** - API estável e rápida

---

## 🔧 Alterações Realizadas

### 1. Controller: `Clinicas.php`
**Removido:**
- ❌ Método `buscar_cep()` (não é mais necessário)

**Motivo:** A busca agora é feita via JavaScript no frontend usando JSONP, sem necessidade de proxy no backend.

---

### 2. View: `criar.php`

**Adicionado:**

#### Busca por CNPJ (ReceitaWS)
```javascript
$('#cnpj').blur(function() {
    // Quando usuário sai do campo CNPJ
    // Valida CNPJ (14 dígitos)
    // Consulta ReceitaWS via JSONP
    // Preenche automaticamente:
    //   - Nome da clínica
    //   - Telefone
    //   - Email
    //   - CEP
    //   - Logradouro
    //   - Número
    //   - Complemento
    //   - Bairro
    //   - Cidade
    //   - Estado
});
```

#### Busca por CEP (ViaCEP)
```javascript
$('#buscar-cep').click(function() {
    // Quando usuário clica no botão de buscar CEP
    // Valida CEP (8 dígitos)
    // Consulta ViaCEP via JSONP
    // Preenche:
    //   - Logradouro
    //   - Bairro
    //   - Cidade
    //   - Estado
});
```

---

### 3. View: `editar.php`

**Adicionado:**

#### Busca por CNPJ com Confirmação
```javascript
$('#cnpj').blur(function() {
    // Pergunta se deseja sobrescrever dados
    // Se sim, busca na ReceitaWS
    // Atualiza todos os campos
});
```

**Diferença:** Na edição, pede confirmação antes de sobrescrever os dados existentes.

---

## 📋 Campos Preenchidos Automaticamente

### Via ReceitaWS (CNPJ)
| Campo | API Field | Observação |
|-------|-----------|------------|
| Nome da Clínica | `dados.fantasia` ou `dados.nome` | Prioriza nome fantasia |
| Telefone | `dados.telefone` | Valida mínimo 10 dígitos |
| Email | `dados.email` | - |
| CEP | `dados.cep` | Remove formatação |
| Logradouro | `dados.logradouro` | - |
| Número | `dados.numero` | - |
| Complemento | `dados.complemento` | - |
| Bairro | `dados.bairro` | - |
| Cidade | `dados.municipio` | - |
| Estado | `dados.uf` | - |

### Via ViaCEP (CEP)
| Campo | API Field |
|-------|-----------|
| Logradouro | `dados.logradouro` |
| Bairro | `dados.bairro` |
| Cidade | `dados.localidade` |
| Estado | `dados.uf` |

---

## 🎨 Experiência do Usuário

### Cadastro de Nova Clínica

1. **Usuário digita o CNPJ**
2. **Ao sair do campo** (blur):
   - Mostra loading "Buscando dados..."
   - Consulta ReceitaWS
   - Preenche todos os campos automaticamente
   - Mostra mensagem de sucesso
3. **Usuário revisa** e completa informações faltantes
4. **Se necessário**, pode buscar CEP manualmente

### Edição de Clínica

1. **Usuário altera o CNPJ**
2. **Ao sair do campo**:
   - Pergunta: "Buscar dados do CNPJ?"
   - "Isso irá sobrescrever os dados atuais"
3. **Se confirmar**:
   - Busca e atualiza dados
4. **Se cancelar**:
   - Mantém dados atuais

---

## 🔐 Segurança e Validação

### Frontend
- ✅ Validação de formato CNPJ (14 dígitos)
- ✅ Validação de formato CEP (8 dígitos)
- ✅ Tratamento de erros de API
- ✅ Loading states
- ✅ Mensagens de feedback

### Backend
- ✅ Validação de CNPJ (algoritmo completo)
- ✅ Validação de unicidade de CNPJ
- ✅ Sanitização de inputs
- ✅ Logs de auditoria

---

## 🌐 APIs Utilizadas

### ReceitaWS
- **URL:** `https://www.receitaws.com.br/v1/cnpj/{cnpj}/?callback=?`
- **Método:** JSONP (GET)
- **Limite:** 3 requisições por minuto (free)
- **Documentação:** https://receitaws.com.br/api

### ViaCEP
- **URL:** `https://viacep.com.br/ws/{cep}/json/?callback=?`
- **Método:** JSONP (GET)
- **Limite:** Sem limite (free)
- **Documentação:** https://viacep.com.br/

---

## ⚠️ Limitações e Considerações

### ReceitaWS
- ⚠️ Limite de 3 requisições/minuto no plano free
- ⚠️ Pode estar offline ocasionalmente
- ⚠️ Dados podem estar desatualizados
- ✅ **Solução:** Usuário pode preencher manualmente

### ViaCEP
- ⚠️ Depende de conexão com internet
- ⚠️ Alguns CEPs podem não existir
- ✅ **Solução:** Preenchimento manual sempre disponível

---

## 🧪 Como Testar

### Teste 1: Busca por CNPJ (Cadastro)
1. Acesse: `http://localhost/alinhadores/admin/clinicas/criar`
2. Digite um CNPJ válido: `00.000.000/0001-91` (Banco do Brasil)
3. Clique fora do campo
4. Aguarde o loading
5. Verifique se os campos foram preenchidos

### Teste 2: Busca por CNPJ (Edição)
1. Edite uma clínica existente
2. Altere o CNPJ
3. Clique fora do campo
4. Confirme a busca
5. Verifique se os dados foram atualizados

### Teste 3: Busca por CEP
1. No formulário, preencha um CEP: `01310-100`
2. Clique no botão de buscar CEP
3. Verifique se o endereço foi preenchido

### Teste 4: Tratamento de Erros
1. Digite um CNPJ inválido
2. Verifique mensagem de erro
3. Digite um CEP inexistente
4. Verifique mensagem de erro

---

## 📊 Comparação: Antes vs Depois

### ❌ Antes (CURL no Backend)
```
Usuário → Preenche CEP → Clica buscar →
Request PHP → CURL → ViaCEP → Response →
Preenche campos
```
**Problemas:**
- Dependia do servidor PHP
- Mais lento (2 requests)
- Não buscava dados da empresa

### ✅ Depois (JSONP no Frontend)
```
Usuário → Preenche CNPJ → Blur →
JavaScript → ReceitaWS → Preenche TUDO

OU

Usuário → Preenche CEP → Clica buscar →
JavaScript → ViaCEP → Preenche endereço
```
**Vantagens:**
- Mais rápido (direto do browser)
- Preenche mais campos
- Melhor UX

---

## 🎯 Próximos Passos

Após validar que as APIs estão funcionando:

1. ✅ Testar cadastro completo de clínica
2. ✅ Testar edição de clínica
3. ✅ Validar dados preenchidos
4. ✅ Prosseguir para CRUD de Dentistas

---

## 📝 Observações Importantes

1. **Responsável Técnico e CRO** não são preenchidos automaticamente (não vêm da API)
2. **Logo e documentos** sempre precisam ser enviados manualmente
3. **Validação final** sempre no backend (nunca confiar só no frontend)
4. **Dados da API** são apenas sugestões, usuário pode alterar

---

**Documento criado em:** 03/12/2025
**Última atualização:** 03/12/2025
