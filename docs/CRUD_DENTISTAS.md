# 🦷 CRUD de Dentistas - Guia Completo

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025
**Versão:** 1.0.0

---

## 📋 Visão Geral

Sistema completo de gerenciamento de dentistas com vínculo a múltiplas clínicas, upload de foto e documentos, e estatísticas detalhadas.

---

## 🗄️ Estrutura de Banco de Dados

### Tabela: `dentistas`

```sql
CREATE TABLE `dentistas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cro` varchar(20) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,
  `especialidade` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL,
  `atualizado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cro` (`cro`),
  UNIQUE KEY `cpf` (`cpf`)
) ENGINE=InnoDB;
```

### Tabela: `dentista_clinica` (Relacionamento N:N)

```sql
CREATE TABLE `dentista_clinica` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,
  `criado_em` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_vinculo` (`dentista_id`, `clinica_id`)
) ENGINE=InnoDB;
```

---

## 📁 Estrutura de Arquivos

```
application/
├── controllers/admin/
│   └── Dentistas.php          # Controller principal
├── models/
│   └── Dentista_model.php     # Model com todas as operações
└── views/admin/dentistas/
    ├── index.php              # Listagem
    ├── criar.php              # Formulário de criação
    ├── editar.php             # Formulário de edição
    └── visualizar.php         # Visualização detalhada

uploads/
└── dentistas/
    ├── fotos/                 # Fotos dos dentistas
    └── documentos/            # Documentos (CNH, RG, CPF, CRO)
        └── {dentista_id}/     # Pasta por dentista
```

---

## ✨ Funcionalidades Implementadas

### 1. Listagem de Dentistas

**URL:** `/admin/dentistas`

**Recursos:**
- ✅ Tabela responsiva com foto, nome, CRO, especialidade
- ✅ Filtros por nome, CRO, clínica, status
- ✅ Estatísticas: total, ativos, inativos
- ✅ Contadores de clínicas e pacientes vinculados
- ✅ Ações: visualizar, editar, excluir

**Filtros Disponíveis:**
- Nome (busca parcial)
- CRO (busca parcial)
- Clínica vinculada
- Status (ativo/inativo)

---

### 2. Cadastro de Dentista

**URL:** `/admin/dentistas/criar`

**Campos Obrigatórios:**
- Nome completo
- CRO (único)
- CPF (único, com máscara)
- E-mail

**Campos Opcionais:**
- Especialidade
- Telefone (com máscara)
- WhatsApp (com máscara)
- Foto (JPG/PNG, máx 5MB)
- Documentos (CNH, RG, CPF, CRO)
- Observações
- Status (ativo/inativo)

**Clínicas:**
- Seleção múltipla de clínicas
- Checkbox para cada clínica disponível
- Exibe nome e localização da clínica

**Validações:**
- CRO único no sistema
- CPF único no sistema
- E-mail válido
- Formato de CPF: 000.000.000-00
- Formato de telefone: (00) 00000-0000

---

### 3. Edição de Dentista

**URL:** `/admin/dentistas/editar/{id}`

**Recursos:**
- ✅ Formulário pré-preenchido
- ✅ Exibição da foto atual
- ✅ Opção de alterar foto
- ✅ Clínicas já vinculadas marcadas
- ✅ Sincronização automática de vínculos
- ✅ Upload de novos documentos

**Comportamento:**
- Remove foto antiga ao fazer upload de nova
- Mantém documentos existentes
- Sincroniza clínicas (remove antigas, adiciona novas)

---

### 4. Visualização Detalhada

**URL:** `/admin/dentistas/visualizar/{id}`

**Informações Exibidas:**

**Coluna Esquerda:**
- Foto do dentista
- Nome e especialidade
- Status (ativo/inativo)
- CRO, CPF, E-mail
- Telefone e WhatsApp (com links)
- Estatísticas:
  - Total de clínicas vinculadas
  - Total de pacientes
  - Total de pedidos

**Coluna Direita:**
- **Clínicas Vinculadas:**
  - Cards com logo e nome
  - Localização
  - Data de vínculo
  - Link para visualizar clínica

- **Pacientes Recentes:**
  - Lista dos últimos 10 pacientes
  - Foto e nome
  - Clínica do paciente
  - Link para visualizar paciente

- **Observações:**
  - Texto formatado com quebras de linha

- **Informações do Sistema:**
  - Data de cadastro
  - Última atualização

**Ações Disponíveis:**
- Editar dentista
- Excluir dentista

---

### 5. Exclusão de Dentista

**URL:** `/admin/dentistas/excluir/{id}`

**Validações:**
- ❌ Não permite excluir se tiver pacientes vinculados
- ❌ Não permite excluir se tiver pedidos vinculados
- ✅ Remove todos os vínculos com clínicas
- ✅ Remove foto do dentista
- ✅ Remove pasta de documentos
- ✅ Confirmação antes de excluir

**Mensagens de Erro:**
- "Dentista possui pacientes vinculados"
- "Dentista possui pedidos vinculados"

---

## 🔧 Métodos do Model

### Busca e Listagem

```php
get($id)                        // Busca dentista por ID
get_all($filtros)               // Lista todos com filtros
count_all($filtros)             // Conta total com filtros
```

### CRUD Básico

```php
insert($data)                   // Insere novo dentista
update($id, $data)              // Atualiza dentista
delete($id)                     // Exclui dentista
```

### Validações

```php
cro_existe($cro, $id_excluir)   // Verifica CRO duplicado
cpf_existe($cpf, $id_excluir)   // Verifica CPF duplicado
pode_excluir($id)               // Verifica se pode excluir
```

### Relacionamentos

```php
get_clinicas($dentista_id)                      // Busca clínicas vinculadas
vincular_clinica($dentista_id, $clinica_id)     // Vincula a uma clínica
desvincular_clinica($dentista_id, $clinica_id)  // Remove vínculo
remover_todos_vinculos($dentista_id)            // Remove todos os vínculos
sincronizar_clinicas($dentista_id, $clinicas)   // Sincroniza vínculos
```

### Dados Relacionados

```php
get_pacientes($dentista_id, $limit)  // Busca pacientes do dentista
get_estatisticas($dentista_id)       // Busca estatísticas
```

---

## 📤 Sistema de Upload

### Foto do Dentista

**Pasta:** `uploads/dentistas/fotos/`
**Formatos:** JPG, JPEG, PNG
**Tamanho Máximo:** 5MB
**Nome:** Criptografado automaticamente

**Comportamento:**
- Upload opcional
- Remove foto antiga ao fazer upload de nova
- Exibe preview na visualização
- Usa iniciais do nome se não tiver foto

### Documentos

**Pasta:** `uploads/dentistas/documentos/{dentista_id}/`
**Tipos:** CNH, RG, CPF, CRO
**Formatos:** PDF, JPG, JPEG, PNG
**Tamanho Máximo:** 5MB por arquivo

**Estrutura:**
```
uploads/dentistas/documentos/
└── 1/                          # ID do dentista
    ├── doc_cnh_1234567890.pdf
    ├── doc_rg_1234567891.pdf
    ├── doc_cpf_1234567892.pdf
    └── doc_cro_1234567893.pdf
```

---

## 🎨 Interface do Usuário

### Ícones Utilizados

- `ti-user-heart` - Ícone principal de dentistas
- `ti-building-hospital` - Clínicas
- `ti-users` - Pacientes
- `ti-shopping-cart` - Pedidos
- `ti-id` - CRO
- `ti-file-text` - CPF
- `ti-mail` - E-mail
- `ti-phone` - Telefone
- `ti-brand-whatsapp` - WhatsApp

### Badges e Status

- **Status Ativo:** Badge verde (`bg-success`)
- **Status Inativo:** Badge cinza (`bg-secondary`)
- **CRO:** Badge azul (`bg-blue-lt`)
- **Clínicas:** Badge roxo (`bg-purple-lt`)
- **Pacientes:** Badge ciano (`bg-cyan-lt`)

---

## 🔐 Segurança

### Validações Implementadas

1. **CRO Único:** Não permite CROs duplicados
2. **CPF Único:** Não permite CPFs duplicados
3. **E-mail Válido:** Validação de formato
4. **Campos Obrigatórios:** Nome, CRO, CPF, E-mail
5. **Exclusão Segura:** Verifica vínculos antes de excluir

### Upload Seguro

- Validação de extensão de arquivo
- Limite de tamanho (5MB)
- Nome criptografado
- Pasta protegida por .htaccess

### Auditoria

- Registro de quem criou o dentista
- Data de criação
- Data de última atualização
- Logs de todas as ações

---

## 📊 Estatísticas

### Por Dentista

- Total de clínicas vinculadas
- Total de pacientes
- Total de pedidos
- Pedidos por status

### Gerais

- Total de dentistas cadastrados
- Total de dentistas ativos
- Total de dentistas inativos

---

## 🧪 Testes Recomendados

### 1. Cadastro

- [ ] Cadastrar dentista com todos os campos
- [ ] Cadastrar dentista apenas com campos obrigatórios
- [ ] Tentar cadastrar com CRO duplicado
- [ ] Tentar cadastrar com CPF duplicado
- [ ] Upload de foto
- [ ] Upload de documentos
- [ ] Vincular múltiplas clínicas

### 2. Edição

- [ ] Editar dados básicos
- [ ] Alterar foto
- [ ] Adicionar/remover clínicas
- [ ] Ativar/desativar dentista
- [ ] Adicionar novos documentos

### 3. Visualização

- [ ] Ver dentista com foto
- [ ] Ver dentista sem foto
- [ ] Ver clínicas vinculadas
- [ ] Ver pacientes
- [ ] Ver estatísticas

### 4. Exclusão

- [ ] Excluir dentista sem vínculos
- [ ] Tentar excluir com pacientes
- [ ] Tentar excluir com pedidos
- [ ] Verificar remoção de arquivos

### 5. Filtros

- [ ] Filtrar por nome
- [ ] Filtrar por CRO
- [ ] Filtrar por clínica
- [ ] Filtrar por status
- [ ] Limpar filtros

---

## 🚀 Próximos Passos

Após validar o CRUD de Dentistas:

1. **CRUD de Pacientes** (Fase 4)
   - Vínculo com dentista e clínica
   - Upload de foto
   - Histórico de tratamentos

2. **Módulo de Pedidos** (Fase 5)
   - Criar pedidos vinculados a dentista
   - Timeline de acompanhamento
   - Upload de arquivos STL

---

## 📝 Notas Importantes

1. **Relacionamento N:N:** Um dentista pode atender em múltiplas clínicas
2. **Máscaras:** CPF e telefones têm máscaras automáticas via jQuery Mask
3. **WhatsApp:** Link direto para abrir conversa no WhatsApp Web
4. **Fotos:** Usa iniciais do nome como avatar padrão
5. **Documentos:** Organizados por ID do dentista

---

## 🐛 Troubleshooting

### Erro: "CRO já cadastrado"
- Verifique se o CRO já existe no banco
- CRO deve ser único no sistema

### Erro: "CPF já cadastrado"
- Verifique se o CPF já existe no banco
- CPF deve ser único no sistema

### Erro no Upload
- Verifique permissões da pasta `uploads/dentistas/`
- Tamanho máximo: 5MB
- Formatos permitidos: JPG, PNG, PDF

### Erro ao Excluir
- Verifique se há pacientes vinculados
- Verifique se há pedidos vinculados
- Remova os vínculos antes de excluir

---

**Desenvolvido por:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025
**Versão:** 1.0.0
