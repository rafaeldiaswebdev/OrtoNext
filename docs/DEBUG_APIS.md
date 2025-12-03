# 🐛 Debug: APIs ReceitaWS e ViaCEP

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025

---

## 🔧 Correções Aplicadas

### 1. Ordem de Carregamento de Scripts
**Problema:** jQuery estava sendo carregado DEPOIS do Tabler
**Solução:** Reorganizado para:
```
1. jQuery 3.7.1
2. SweetAlert2
3. Tabler
4. jQuery Mask
5. Custom JS
```

### 2. SweetAlert2 Duplicado
**Problema:** SweetAlert2 estava sendo carregado 2 vezes
**Solução:** Removida duplicação, mantido apenas uma vez no início

### 3. Logs de Debug Adicionados
Agora o sistema mostra no console:
- ✅ "Script de clínicas carregado!"
- ✅ "Máscaras aplicadas!"
- ✅ "Campo CNPJ perdeu o foco"
- ✅ "CNPJ digitado: XXXXX"
- ✅ "Consultando ReceitaWS..."
- ✅ "Resposta da ReceitaWS: {...}"
- ✅ "Botão buscar CEP clicado"
- ✅ "Resposta ViaCEP: {...}"

---

## 🧪 Como Testar

### Passo 1: Limpar Cache
```
1. Abra o navegador
2. Pressione Ctrl + Shift + Delete
3. Limpe cache e cookies
4. OU pressione Ctrl + F5 na página
```

### Passo 2: Abrir Console do Navegador
```
1. Pressione F12
2. Vá na aba "Console"
3. Deixe aberto durante os testes
```

### Passo 3: Acessar Página de Cadastro
```
http://localhost/alinhadores/admin/clinicas/criar
```

### Passo 4: Verificar Carregamento
No console, deve aparecer:
```
✅ Script de clínicas carregado!
✅ Máscaras aplicadas!
```

**Se NÃO aparecer:**
- ❌ jQuery não está carregando
- ❌ Verifique se há erros no console
- ❌ Verifique se o caminho do arquivo está correto

---

## 🔍 Teste 1: Busca por CNPJ

### Passo a Passo:
1. Digite um CNPJ válido: `00.000.000/0001-91`
2. Clique fora do campo (Tab ou clique em outro campo)
3. Observe o console

### O que deve aparecer no console:
```
Campo CNPJ perdeu o foco
CNPJ digitado: 00000000000191
CNPJ válido, iniciando busca...
Validação OK, consultando ReceitaWS...
Resposta da ReceitaWS: {nome: "...", fantasia: "...", ...}
Dados encontrados! Preenchendo campos...
```

### O que deve acontecer na tela:
1. Aparece loading "Buscando dados..."
2. Campos são preenchidos automaticamente
3. Aparece mensagem de sucesso

### Se NÃO funcionar:

#### Erro: "SweetAlert2 não está carregado!"
**Solução:**
- Verifique se o CDN do SweetAlert2 está acessível
- Teste: `https://cdn.jsdelivr.net/npm/sweetalert2@11`
- Limpe o cache do navegador

#### Erro: "jQuery Mask não carregado!"
**Solução:**
- Verifique se o CDN do jQuery Mask está acessível
- Teste: `https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js`

#### Erro: "Erro na consulta ReceitaWS"
**Possíveis causas:**
1. **Limite de requisições** - ReceitaWS permite apenas 3 req/min
   - Aguarde 1 minuto e tente novamente
2. **CNPJ inválido** - Digite um CNPJ real
3. **API offline** - Teste manualmente: `https://www.receitaws.com.br/v1/cnpj/00000000000191`
4. **CORS bloqueado** - Improvável com JSONP, mas verifique console

---

## 🔍 Teste 2: Busca por CEP

### Passo a Passo:
1. Digite um CEP: `01310-100`
2. Clique no botão de buscar (ícone de lupa)
3. Observe o console

### O que deve aparecer no console:
```
Botão buscar CEP clicado
CEP digitado: 01310100
Consultando ViaCEP...
Resposta ViaCEP: {logradouro: "...", bairro: "...", ...}
CEP encontrado! Preenchendo campos...
```

### O que deve acontecer na tela:
1. Botão mostra spinner
2. Campos de endereço são preenchidos
3. Aparece mensagem de sucesso
4. Botão volta ao normal

### Se NÃO funcionar:

#### Botão não responde ao clique
**Verifique:**
```javascript
// No console, digite:
$('#buscar-cep').length
// Deve retornar: 1
```

**Se retornar 0:**
- O ID do botão está errado
- Verifique se o botão tem `id="buscar-cep"`

#### Erro: "CEP não encontrado"
- Digite um CEP válido
- Teste manualmente: `https://viacep.com.br/ws/01310100/json/`

---

## 🛠️ Testes Manuais de API

### Testar ReceitaWS diretamente:
```
https://www.receitaws.com.br/v1/cnpj/00000000000191
```

**Resposta esperada:**
```json
{
  "nome": "BANCO DO BRASIL S.A.",
  "fantasia": "BANCO DO BRASIL",
  "cnpj": "00.000.000/0001-91",
  "telefone": "(61) 3493-9002",
  "email": "ouvidoria@bb.com.br",
  "cep": "70040-912",
  "logradouro": "SBS Quadra 1 Bloco A",
  "numero": "S/N",
  "bairro": "Asa Sul",
  "municipio": "Brasília",
  "uf": "DF"
}
```

### Testar ViaCEP diretamente:
```
https://viacep.com.br/ws/01310100/json/
```

**Resposta esperada:**
```json
{
  "cep": "01310-100",
  "logradouro": "Avenida Paulista",
  "bairro": "Bela Vista",
  "localidade": "São Paulo",
  "uf": "SP"
}
```

---

## 🐛 Problemas Comuns e Soluções

### 1. "$ is not defined"
**Causa:** jQuery não carregou
**Solução:**
- Verifique conexão com internet
- Teste CDN: `https://code.jquery.com/jquery-3.7.1.min.js`
- Limpe cache do navegador

### 2. "Swal is not defined"
**Causa:** SweetAlert2 não carregou
**Solução:**
- Verifique se está no footer.php
- Teste CDN: `https://cdn.jsdelivr.net/npm/sweetalert2@11`
- Limpe cache

### 3. Máscaras não funcionam
**Causa:** jQuery Mask não carregou
**Solução:**
- Verifique se jQuery carregou primeiro
- Teste CDN: `https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js`

### 4. APIs não respondem
**Causa:** Limite de requisições ou API offline
**Solução:**
- ReceitaWS: Aguarde 1 minuto entre testes
- ViaCEP: Geralmente não tem limite
- Teste APIs manualmente no navegador

### 5. Campos não são preenchidos
**Causa:** Seletores jQuery incorretos
**Solução:**
```javascript
// No console, teste:
$('input[name="nome"]').length  // Deve ser 1
$('input[name="telefone"]').length  // Deve ser 1
$('input[name="cep"]').length  // Deve ser 1
```

---

## 📊 Checklist de Validação

### Carregamento de Scripts
- [ ] jQuery carrega primeiro
- [ ] SweetAlert2 carrega
- [ ] jQuery Mask carrega
- [ ] Console mostra "Script de clínicas carregado!"
- [ ] Console mostra "Máscaras aplicadas!"

### Busca por CNPJ
- [ ] Campo CNPJ aceita máscara
- [ ] Ao sair do campo, dispara busca
- [ ] Loading aparece
- [ ] Console mostra logs
- [ ] Campos são preenchidos
- [ ] Mensagem de sucesso aparece

### Busca por CEP
- [ ] Campo CEP aceita máscara
- [ ] Botão de buscar existe
- [ ] Ao clicar, dispara busca
- [ ] Spinner aparece no botão
- [ ] Console mostra logs
- [ ] Campos de endereço são preenchidos
- [ ] Mensagem de sucesso aparece

### Tratamento de Erros
- [ ] CNPJ inválido mostra erro
- [ ] CEP inválido mostra erro
- [ ] API offline mostra erro
- [ ] Erros aparecem no console

---

## 🎯 CNPJs para Teste

Use estes CNPJs válidos para testar:

| CNPJ | Empresa |
|------|---------|
| 00.000.000/0001-91 | Banco do Brasil |
| 33.000.167/0001-01 | Caixa Econômica Federal |
| 60.701.190/0001-04 | Bradesco |
| 60.746.948/0001-12 | Itaú Unibanco |
| 90.400.888/0001-42 | Santander |

---

## 🎯 CEPs para Teste

Use estes CEPs válidos para testar:

| CEP | Endereço |
|-----|----------|
| 01310-100 | Av. Paulista, São Paulo/SP |
| 20040-020 | Centro, Rio de Janeiro/RJ |
| 30130-000 | Centro, Belo Horizonte/MG |
| 70040-912 | Brasília/DF |
| 80010-000 | Centro, Curitiba/PR |

---

## 📝 Relatório de Teste

Preencha após testar:

```
Data do Teste: ___/___/2025
Navegador: _________________
Versão: ____________________

✅ Scripts carregaram corretamente
✅ Máscaras funcionam
✅ Busca por CNPJ funciona
✅ Busca por CEP funciona
✅ Tratamento de erros funciona

Observações:
_________________________________
_________________________________
_________________________________
```

---

**Documento criado em:** 03/12/2025
**Última atualização:** 03/12/2025
