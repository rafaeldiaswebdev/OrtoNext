# 🗺️ Roadmap de Desenvolvimento - Sistema de Alinhadores Ortodônticos

**Autor:** Rafael Dias - doisr.com.br
**Data:** 03/12/2025 15:30
**Versão:** 1.0

---

## 📋 Visão Geral do Projeto

Sistema web para gerenciamento completo de alinhadores ortodônticos, incluindo cadastro de clínicas, dentistas, pacientes e pedidos com acompanhamento detalhado através de timeline.

### 🎯 Objetivos Principais

- Desenvolver CRUDs completos para todas as entidades do sistema
- Utilizar template Tabler já implementado mantendo consistência visual
- Integrar com estrutura de autenticação existente
- Implementar sistema robusto de upload de arquivos
- Criar timeline para rastreamento de pedidos

---

## 🏗️ Arquitetura Atual

### Stack Tecnológica
- **Backend:** PHP 7+ com CodeIgniter 3 (MVC)
- **Frontend:** Tabler Dashboard (CDN)
- **Banco de Dados:** MySQL/MariaDB
- **Bibliotecas:** jQuery, SweetAlert2

### Estrutura Existente
```
✅ Sistema de autenticação completo
✅ Recuperação de senha
✅ Gerenciamento de usuários com permissões
✅ Sistema de logs e auditoria
✅ Sistema de notificações
✅ Configurações dinâmicas (SMTP, geral)
✅ Layout Tabler responsivo implementado
```

### Padrões de Código Identificados

#### Controllers
- Herdam de `Admin_Controller`
- Validação com `form_validation`
- Flash messages para feedback
- Registro de logs para auditoria
- Separação clara entre GET e POST

#### Models
- Métodos CRUD padrão: `get()`, `get_all()`, `insert()`, `update()`, `delete()`
- Tratamento automático de senhas (hash)
- Timestamps automáticos
- Suporte a filtros e buscas

#### Views
- Header e Footer separados em `layout/`
- Estrutura de página Tabler:
  - `page-header` com título e ações
  - `page-body` com conteúdo
  - Cards para organização
  - Tabelas responsivas
  - Ícones Tabler Icons
  - Badges para status

---

## 📊 Estrutura de Banco de Dados

### Tabelas Existentes
- `usuarios` - Usuários do sistema
- `configuracoes` - Configurações dinâmicas
- `logs` - Auditoria de ações
- `notificacoes` - Sistema de notificações

### Novas Tabelas Necessárias

#### 1. Clínicas
```sql
CREATE TABLE `clinicas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `cnpj` varchar(18) NOT NULL,
  `responsavel_tecnico` varchar(100) NOT NULL,
  `cro_responsavel` varchar(20) NOT NULL,

  -- Endereço
  `cep` varchar(9) DEFAULT NULL,
  `logradouro` varchar(200) DEFAULT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(2) DEFAULT NULL,

  -- Contatos
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `whatsapp` varchar(20) DEFAULT NULL,

  -- Documentos e Logo
  `logo` varchar(255) DEFAULT NULL COMMENT 'PNG 3210x3210px fundo branco',
  `doc_cnh` varchar(255) DEFAULT NULL,
  `doc_rg` varchar(255) DEFAULT NULL,
  `doc_cpf` varchar(255) DEFAULT NULL,
  `doc_cro` varchar(255) DEFAULT NULL,

  -- Status
  `status_validacao` enum('pendente','aprovado','reprovado') DEFAULT 'pendente',
  `observacoes` text DEFAULT NULL,

  -- Auditoria
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `cnpj` (`cnpj`),
  KEY `idx_status` (`status_validacao`),
  KEY `idx_cidade` (`cidade`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_clinicas_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 2. Dentistas
```sql
CREATE TABLE `dentistas` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cro` varchar(20) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,

  -- Documentos
  `doc_cro` varchar(255) DEFAULT NULL,
  `doc_cpf` varchar(255) DEFAULT NULL,
  `doc_rg` varchar(255) DEFAULT NULL,

  -- Status
  `status` enum('ativo','inativo') DEFAULT 'ativo',

  -- Auditoria
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `cro` (`cro`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `idx_status` (`status`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_dentistas_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 3. Dentistas x Clínicas (Relacionamento N:N)
```sql
CREATE TABLE `dentista_clinica` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,
  `vinculado_em` datetime NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_vinculo` (`dentista_id`, `clinica_id`),
  KEY `fk_dentista` (`dentista_id`),
  KEY `fk_clinica` (`clinica_id`),
  CONSTRAINT `fk_dc_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_dc_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 4. Pacientes
```sql
CREATE TABLE `pacientes` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `genero` enum('masculino','feminino','outro') NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,

  -- Vínculos
  `clinica_id` int(11) UNSIGNED NOT NULL,
  `dentista_id` int(11) UNSIGNED NOT NULL,

  -- Observações
  `observacoes` text DEFAULT NULL,

  -- Auditoria
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  KEY `idx_clinica` (`clinica_id`),
  KEY `idx_dentista` (`dentista_id`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_pacientes_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pacientes_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pacientes_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 5. Pedidos
```sql
CREATE TABLE `pedidos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `numero_pedido` varchar(20) NOT NULL COMMENT 'Gerado automaticamente',

  -- Vínculos
  `paciente_id` int(11) UNSIGNED NOT NULL,
  `dentista_id` int(11) UNSIGNED NOT NULL,
  `clinica_id` int(11) UNSIGNED NOT NULL,

  -- Tipo de Pedido
  `tipo_pedido` enum('complete','self_guard','you_plan','print_3d','self_plan') NOT NULL,

  -- Status
  `status` enum('rascunho','enviado','em_analise','em_producao','concluido','cancelado') DEFAULT 'rascunho',

  -- Observações
  `observacoes_planejamento` text DEFAULT NULL,

  -- Campos Clínicos (JSON para flexibilidade)
  `dados_clinicos` text DEFAULT NULL COMMENT 'JSON com campos dinâmicos por tipo',

  -- Auditoria
  `criado_por` int(11) UNSIGNED DEFAULT NULL,
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` datetime DEFAULT NULL ON UPDATE current_timestamp(),

  PRIMARY KEY (`id`),
  UNIQUE KEY `numero_pedido` (`numero_pedido`),
  KEY `idx_paciente` (`paciente_id`),
  KEY `idx_dentista` (`dentista_id`),
  KEY `idx_clinica` (`clinica_id`),
  KEY `idx_status` (`status`),
  KEY `idx_tipo` (`tipo_pedido`),
  KEY `fk_criado_por` (`criado_por`),
  CONSTRAINT `fk_pedidos_paciente` FOREIGN KEY (`paciente_id`) REFERENCES `pacientes` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_dentista` FOREIGN KEY (`dentista_id`) REFERENCES `dentistas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_clinica` FOREIGN KEY (`clinica_id`) REFERENCES `clinicas` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `fk_pedidos_usuario` FOREIGN KEY (`criado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 6. Arquivos de Pedidos
```sql
CREATE TABLE `pedido_arquivos` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) UNSIGNED NOT NULL,
  `tipo_arquivo` enum('escaneamento','documento','imagem','stl','outro') NOT NULL,
  `nome_original` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `caminho` varchar(500) NOT NULL,
  `tamanho` int(11) DEFAULT NULL COMMENT 'Tamanho em bytes',
  `mime_type` varchar(100) DEFAULT NULL,

  -- Auditoria
  `enviado_por` int(11) UNSIGNED DEFAULT NULL,
  `enviado_em` datetime NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `fk_enviado_por` (`enviado_por`),
  CONSTRAINT `fk_arquivos_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_arquivos_usuario` FOREIGN KEY (`enviado_por`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

#### 7. Timeline de Pedidos
```sql
CREATE TABLE `pedido_timeline` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) UNSIGNED NOT NULL,
  `tipo_evento` enum('criacao','envio','revisao','aprovacao','producao','entrega','comentario','alteracao','cancelamento') NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text DEFAULT NULL,
  `dados_adicionais` text DEFAULT NULL COMMENT 'JSON com dados extras',

  -- Autor
  `usuario_id` int(11) UNSIGNED DEFAULT NULL,
  `autor_tipo` enum('sistema','usuario','dentista','clinica') DEFAULT 'usuario',

  -- Data
  `criado_em` datetime NOT NULL DEFAULT current_timestamp(),

  PRIMARY KEY (`id`),
  KEY `idx_pedido` (`pedido_id`),
  KEY `idx_usuario` (`usuario_id`),
  KEY `idx_tipo` (`tipo_evento`),
  KEY `idx_data` (`criado_em`),
  CONSTRAINT `fk_timeline_pedido` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_timeline_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 🎯 Fases de Desenvolvimento

### FASE 1: Estrutura de Banco de Dados ⏱️ 1 dia
**Status:** Pendente

#### Tarefas:
- [ ] Criar script SQL com todas as tabelas
- [ ] Adicionar índices para otimização
- [ ] Configurar foreign keys e constraints
- [ ] Criar triggers se necessário
- [ ] Documentar relacionamentos
- [ ] Executar e testar no banco de desenvolvimento

#### Entregáveis:
- `docs/database_schema.sql` - Script completo do banco
- `docs/database_diagram.md` - Diagrama de relacionamentos

---

### FASE 2: CRUD de Clínicas ⏱️ 3 dias
**Status:** Pendente

#### Estrutura de Arquivos:
```
application/
├── controllers/admin/
│   └── Clinicas.php
├── models/
│   └── Clinica_model.php
└── views/admin/clinicas/
    ├── index.php (listagem)
    ├── criar.php (formulário criação)
    ├── editar.php (formulário edição)
    └── visualizar.php (detalhes)
```

#### Funcionalidades:
- [ ] **Listagem de Clínicas**
  - Tabela responsiva com dados principais
  - Filtros: nome, cidade, status de validação
  - Busca por nome/CNPJ
  - Badges para status de validação
  - Ações: visualizar, editar, excluir

- [ ] **Cadastro de Clínica**
  - Formulário com validação
  - Campos de endereço com busca por CEP (ViaCEP API)
  - Upload de logo (PNG 3210x3210px)
  - Upload de documentos (CNH, RG, CPF, CRO)
  - Validação de CNPJ
  - Preview de imagens

- [ ] **Edição de Clínica**
  - Mesmo formulário do cadastro
  - Manter arquivos existentes
  - Permitir substituição de documentos
  - Histórico de alterações

- [ ] **Visualização de Clínica**
  - Card com informações completas
  - Galeria de documentos
  - Lista de dentistas vinculados
  - Lista de pacientes
  - Estatísticas (total de pedidos, etc)

- [ ] **Validação de Documentos**
  - Aprovar/Reprovar documentos
  - Campo de observações
  - Notificação por email

#### Validações:
- CNPJ único e válido
- Email válido
- Telefone/WhatsApp no formato correto
- Logo: PNG, máx 5MB, dimensões 3210x3210px
- Documentos: PDF ou imagem, máx 5MB cada

---

### FASE 3: CRUD de Dentistas ⏱️ 3 dias
**Status:** Pendente

#### Estrutura de Arquivos:
```
application/
├── controllers/admin/
│   └── Dentistas.php
├── models/
│   └── Dentista_model.php
└── views/admin/dentistas/
    ├── index.php
    ├── criar.php
    ├── editar.php
    └── visualizar.php
```

#### Funcionalidades:
- [ ] **Listagem de Dentistas**
  - Tabela com foto, nome, CRO
  - Filtros: nome, clínica, status
  - Busca por nome/CRO/CPF
  - Badges para status
  - Indicador de clínicas vinculadas

- [ ] **Cadastro de Dentista**
  - Formulário com validação
  - Upload de foto (opcional)
  - Upload de documentos (CRO, CPF, RG)
  - Multi-select de clínicas
  - Validação de CRO e CPF

- [ ] **Edição de Dentista**
  - Atualizar dados
  - Gerenciar vínculos com clínicas
  - Substituir documentos

- [ ] **Visualização de Dentista**
  - Informações completas
  - Lista de clínicas vinculadas
  - Lista de pacientes
  - Estatísticas de pedidos

#### Validações:
- CRO único e válido
- CPF único e válido
- Email válido (se fornecido)
- Foto: JPG/PNG, máx 2MB
- Documentos: PDF ou imagem, máx 5MB

---

### FASE 4: CRUD de Pacientes ⏱️ 2 dias
**Status:** Pendente

#### Estrutura de Arquivos:
```
application/
├── controllers/admin/
│   └── Pacientes.php
├── models/
│   └── Paciente_model.php
└── views/admin/pacientes/
    ├── index.php
    ├── criar.php
    ├── editar.php
    └── visualizar.php
```

#### Funcionalidades:
- [ ] **Listagem de Pacientes**
  - Tabela com foto, nome, idade
  - Filtros: nome, clínica, dentista
  - Busca por nome/CPF
  - Informações de clínica e dentista

- [ ] **Cadastro de Paciente**
  - Formulário completo
  - Upload de foto
  - Select de clínica
  - Select de dentista (filtrado por clínica)
  - Validação de CPF e idade

- [ ] **Edição de Paciente**
  - Atualizar dados
  - Trocar foto
  - Alterar vínculos

- [ ] **Visualização de Paciente**
  - Ficha completa
  - Histórico de pedidos
  - Timeline de atendimentos

#### Validações:
- CPF único e válido
- Data de nascimento válida
- Email válido (se fornecido)
- Foto: JPG/PNG, máx 2MB
- Clínica e dentista obrigatórios

---

### FASE 5: Módulo de Pedidos ⏱️ 5 dias
**Status:** Pendente

#### Estrutura de Arquivos:
```
application/
├── controllers/admin/
│   └── Pedidos.php
├── models/
│   ├── Pedido_model.php
│   └── Pedido_arquivo_model.php
└── views/admin/pedidos/
    ├── index.php
    ├── criar.php
    ├── editar.php
    ├── visualizar.php
    └── _campos_dinamicos/ (partials por tipo)
        ├── complete.php
        ├── self_guard.php
        ├── you_plan.php
        ├── print_3d.php
        └── self_plan.php
```

#### Tipos de Pedido e Campos Dinâmicos:

**1. Complete**
- Linha média superior/inferior
- Arcada superior/inferior
- Apinhamento (leve/moderado/severo)
- Classe molar (I/II/III)
- Diastemas
- Sobressaliência
- Sobremordida

**2. Self Guard**
- Tipo de proteção
- Arcada
- Espessura

**3. You Plan**
- Número de alinhadores
- Arcada
- Observações de planejamento

**4. Print 3D**
- Tipo de modelo
- Quantidade
- Material

**5. Self Plan**
- Arquivo de planejamento
- Software utilizado
- Número de etapas

#### Funcionalidades:
- [ ] **Listagem de Pedidos**
  - Tabela com número, paciente, tipo, status
  - Filtros avançados
  - Busca por número/paciente
  - Badges coloridos por status
  - Indicadores visuais de urgência

- [ ] **Criação de Pedido**
  - Wizard multi-step:
    1. Seleção de paciente/dentista/clínica
    2. Tipo de pedido
    3. Campos clínicos dinâmicos
    4. Upload de arquivos
    5. Revisão e confirmação
  - Validação em cada etapa
  - Salvamento como rascunho
  - Geração automática de número

- [ ] **Edição de Pedido**
  - Apenas rascunhos podem ser editados completamente
  - Pedidos enviados: apenas observações
  - Controle de permissões

- [ ] **Visualização de Pedido**
  - Todas as informações
  - Galeria de arquivos
  - Timeline completa
  - Ações por status
  - Botões de ação contextuais

- [ ] **Gestão de Status**
  - Fluxo: rascunho → enviado → em_analise → em_producao → concluido
  - Possibilidade de cancelamento
  - Registro automático na timeline
  - Notificações

#### Validações:
- Número de pedido único
- Vínculos válidos (paciente, dentista, clínica)
- Campos obrigatórios por tipo
- Arquivos: STL (máx 50MB), imagens (máx 10MB)

---

### FASE 6: Sistema de Upload de Arquivos ⏱️ 2 dias
**Status:** Pendente

#### Estrutura:
```
application/
├── libraries/
│   └── Upload_handler.php
└── helpers/
    └── upload_helper.php

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

#### Funcionalidades:
- [ ] **Library de Upload**
  - Validação de tipo MIME
  - Validação de tamanho
  - Geração de nomes únicos
  - Organização por pastas
  - Redimensionamento de imagens
  - Geração de thumbnails

- [ ] **Segurança**
  - Validação de extensões
  - Verificação de conteúdo
  - Proteção contra directory traversal
  - Limite de tamanho por tipo
  - Quarentena de arquivos suspeitos

- [ ] **Gestão de Arquivos**
  - Listagem de arquivos
  - Download seguro
  - Exclusão com confirmação
  - Visualização inline (imagens/PDFs)

#### Tipos de Arquivo Suportados:
- **Imagens:** JPG, PNG, GIF (máx 10MB)
- **Documentos:** PDF (máx 5MB)
- **STL:** STL (máx 50MB)
- **Outros:** ZIP (máx 100MB)

---

### FASE 7: Sistema de Timeline ⏱️ 2 dias
**Status:** Pendente

#### Estrutura:
```
application/
├── models/
│   └── Timeline_model.php
└── views/admin/
    └── _partials/
        └── timeline.php
```

#### Funcionalidades:
- [ ] **Registro Automático de Eventos**
  - Criação de pedido
  - Mudança de status
  - Upload de arquivo
  - Comentários
  - Alterações de dados

- [ ] **Visualização de Timeline**
  - Linha do tempo vertical
  - Ícones por tipo de evento
  - Cores por categoria
  - Autor e data/hora
  - Detalhes expansíveis

- [ ] **Interações**
  - Adicionar comentários
  - Anexar arquivos
  - Mencionar usuários
  - Marcar como importante

#### Tipos de Eventos:
- 🆕 Criação
- 📤 Envio
- 🔍 Revisão
- ✅ Aprovação
- 🏭 Produção
- 📦 Entrega
- 💬 Comentário
- ✏️ Alteração
- ❌ Cancelamento

---

### FASE 8: Dashboard e KPIs ⏱️ 2 dias
**Status:** Pendente

#### Funcionalidades:
- [ ] **Cards de Estatísticas**
  - Total de clínicas
  - Total de dentistas
  - Total de pacientes
  - Pedidos em andamento
  - Pedidos concluídos este mês
  - Pedidos pendentes de aprovação

- [ ] **Gráficos**
  - Pedidos por tipo (pizza)
  - Pedidos por mês (linha)
  - Status dos pedidos (barras)
  - Clínicas mais ativas (ranking)

- [ ] **Listas Rápidas**
  - Últimos pedidos
  - Pedidos urgentes
  - Documentos pendentes de validação
  - Atividades recentes

- [ ] **Ações Rápidas**
  - Novo pedido
  - Novo paciente
  - Nova clínica
  - Relatórios

---

### FASE 9: Ajustes e Melhorias ⏱️ 2 dias
**Status:** Pendente

#### Tarefas:
- [ ] **Responsividade**
  - Testar em mobile
  - Testar em tablet
  - Ajustar tabelas
  - Otimizar formulários

- [ ] **Performance**
  - Otimizar queries
  - Adicionar cache
  - Lazy loading de imagens
  - Paginação eficiente

- [ ] **UX/UI**
  - Feedback visual
  - Loading states
  - Mensagens de erro claras
  - Tooltips informativos

- [ ] **Segurança**
  - Validação de inputs
  - Proteção CSRF
  - Sanitização de dados
  - Controle de permissões

---

### FASE 10: Testes e Documentação ⏱️ 2 dias
**Status:** Pendente

#### Testes:
- [ ] Testes de CRUD completo
- [ ] Testes de upload de arquivos
- [ ] Testes de permissões
- [ ] Testes de validação
- [ ] Testes de integração
- [ ] Testes de responsividade

#### Documentação:
- [ ] Manual do usuário
- [ ] Documentação técnica
- [ ] Guia de instalação
- [ ] Changelog
- [ ] README atualizado

---

## 📝 Convenções e Padrões

### Nomenclatura
- **Controllers:** PascalCase, plural (ex: `Clinicas.php`)
- **Models:** PascalCase, singular + `_model` (ex: `Clinica_model.php`)
- **Views:** snake_case (ex: `criar.php`, `editar.php`)
- **Métodos:** snake_case (ex: `get_all()`, `salvar_clinica()`)
- **Variáveis:** snake_case (ex: `$dados_clinica`, `$total_pedidos`)

### Estrutura de Controllers
```php
class Entidade extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Entidade_model');
    }

    public function index() {
        // Listagem
    }

    public function criar() {
        // Formulário criação
    }

    public function editar($id) {
        // Formulário edição
    }

    public function visualizar($id) {
        // Detalhes
    }

    public function excluir($id) {
        // Exclusão
    }

    private function salvar_entidade($id = null) {
        // Lógica de salvamento
    }
}
```

### Estrutura de Models
```php
class Entidade_model extends CI_Model {
    protected $table = 'tabela';

    public function get($id) {}
    public function get_all($filtros = []) {}
    public function insert($dados) {}
    public function update($id, $dados) {}
    public function delete($id) {}
    public function count($filtros = []) {}
}
```

### Estrutura de Views
```php
<!-- Cabeçalho -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Categoria</div>
                <h2 class="page-title">
                    <i class="ti ti-icon me-2"></i>
                    Título da Página
                </h2>
            </div>
            <div class="col-auto ms-auto d-print-none">
                <!-- Botões de ação -->
            </div>
        </div>
    </div>
</div>

<!-- Corpo -->
<div class="page-body">
    <div class="container-xl">
        <!-- Conteúdo -->
    </div>
</div>
```

---

## 🎨 Componentes Tabler Utilizados

### Cards
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Título</h3>
    </div>
    <div class="card-body">
        Conteúdo
    </div>
</div>
```

### Tabelas
```html
<div class="table-responsive">
    <table class="table table-vcenter card-table table-striped">
        <thead>
            <tr>
                <th>Coluna</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Dado</td>
            </tr>
        </tbody>
    </table>
</div>
```

### Formulários
```html
<div class="mb-3">
    <label class="form-label">Label</label>
    <input type="text" class="form-control" name="campo">
</div>
```

### Badges
```html
<span class="badge bg-success">Ativo</span>
<span class="badge bg-danger">Inativo</span>
<span class="badge bg-warning">Pendente</span>
<span class="badge bg-info">Em Análise</span>
```

### Botões
```html
<a href="#" class="btn btn-primary">
    <i class="ti ti-plus me-2"></i>
    Novo
</a>
```

---

## 📦 Bibliotecas e Dependências

### Frontend (CDN)
- Tabler Core 1.0.0-beta17
- Tabler Icons (latest)
- jQuery 3.7.1
- SweetAlert2 11
- Inter Font

### Backend
- CodeIgniter 3
- PHP 7+
- MySQL/MariaDB

### APIs Externas
- ViaCEP (consulta de CEP)
- Stripe (pagamentos - fase futura)

---

## 🔐 Segurança

### Implementações Necessárias
- [ ] Validação de inputs em todos os formulários
- [ ] Proteção CSRF em formulários
- [ ] Sanitização de dados antes de salvar
- [ ] Validação de tipos de arquivo
- [ ] Verificação de tamanho de upload
- [ ] Proteção contra SQL Injection (usar Query Builder)
- [ ] Proteção contra XSS
- [ ] Controle de permissões por módulo
- [ ] Logs de auditoria para ações críticas
- [ ] Backup automático de arquivos

---

## 📊 Métricas de Sucesso

### Performance
- Tempo de carregamento < 2s
- Upload de arquivos < 30s (50MB)
- Queries otimizadas < 100ms

### Usabilidade
- Interface intuitiva
- Feedback visual em todas as ações
- Responsivo em todos os dispositivos
- Acessibilidade WCAG 2.1 AA

### Qualidade
- Zero bugs críticos
- Cobertura de testes > 80%
- Código documentado
- Padrões seguidos

---

## 📅 Cronograma Estimado

| Fase | Descrição | Duração | Início | Fim |
|------|-----------|---------|--------|-----|
| 1 | Banco de Dados | 1 dia | - | - |
| 2 | CRUD Clínicas | 3 dias | - | - |
| 3 | CRUD Dentistas | 3 dias | - | - |
| 4 | CRUD Pacientes | 2 dias | - | - |
| 5 | Módulo Pedidos | 5 dias | - | - |
| 6 | Sistema Upload | 2 dias | - | - |
| 7 | Timeline | 2 dias | - | - |
| 8 | Dashboard | 2 dias | - | - |
| 9 | Ajustes | 2 dias | - | - |
| 10 | Testes | 2 dias | - | - |
| **TOTAL** | | **24 dias** | | |

---

## 📞 Próximos Passos

1. ✅ Análise completa do PRD e estrutura atual
2. ⏳ Aprovação do roadmap
3. ⏳ Criação da estrutura de banco de dados
4. ⏳ Início do desenvolvimento do CRUD de Clínicas

---

## 📝 Notas Importantes

- **Integração Stripe:** Será implementada como última tarefa do projeto
- **Template Tabler:** Manter fidelidade total ao design existente
- **Autoria:** Todos os arquivos devem conter cabeçalho com autoria (Rafael Dias - doisr.com.br) e data
- **Documentação:** Manter pasta `docs/` atualizada com todas as instruções e SQLs
- **Git:** Commits apenas quando solicitado
- **Cache:** Limpar cache após atualizações importantes
- **Arquivos desnecessários:** Não criar .md ou .bat desnecessários

---

**Documento vivo - será atualizado conforme o projeto evolui**
