PRD Atualizado – Plataforma Digital Odontológica de Alinhadores

1. Visão Geral
A Plataforma Digital Odontológica de Alinhadores é uma plataforma web voltada para ortodontistas, clínicas odontológicas e laboratórios de alinhadores. A plataforma gerencia os fluxos essenciais para o processo de atendimento odontológico, incluindo cadastro de clínicas, dentistas e pacientes, gerenciamento de pedidos, upload de arquivos (modelos digitais), personalização de cases e o acompanhamento de cada etapa do processo clínico. Este PRD descreve a parte de desenvolvimento da funcionalidade que falta, com a base já implementada, incluindo a parte de front-end utilizando o template Tabler, já em funcionamento.

2. Objetivos do Projeto

Desenvolver CRUDs faltantes para o gerenciamento de clínicas, dentistas, pacientes e pedidos.

Utilizar a estrutura já existente do Tabler Dashboard para garantir consistência visual e de UX.

Garantir a integração contínua com a estrutura de login e gestão de usuários já implementada.

Criar a interface de pedidos, upload de arquivos, e outras funcionalidades essenciais.

3. Requisitos Funcionais

3.1. Cadastro de Usuários

Admin: Acesso total a todos os módulos, incluindo gestão de usuários, clínicas, dentistas e pacientes.

Dentista: Acesso para cadastrar pacientes e pedidos, além de acompanhar o andamento do pedido e interagir com a clínica.

Atendente: Acesso para realizar cadastros e acompanhar os status dos pedidos, sem permitir alterações nas configurações.

Obs: O sistema de autenticação e gerenciamento de perfis de usuário já está implementado, incluindo login, recuperação de senha e criação de novos usuários.

3.2. Cadastro de Pacientes

Campos obrigatórios:

Nome completo, data de nascimento, gênero, CPF, telefone, e-mail.

Foto (upload de imagem).

Clínica associada (select).

Dentista responsável (select).

Observações adicionais.

Funcionalidades:

Listagem de Pacientes: Filtros por nome, clínica, dentista.

Detalhamento do Paciente: Visualização de histórico de pedidos, foto, dados cadastrais completos, e opções de edição/exclusão.

3.3. Cadastro de Clínicas

Campos obrigatórios:

Nome da clínica, CNPJ, endereço completo, responsável técnico (nome, CRO).

Contatos: telefone, e-mail, WhatsApp.

Status de validação.

Upload de documentos obrigatórios (CNH, RG, CPF, CRO).

Upload de logo para personalização (PNG 3210x3210px, fundo branco).

Funcionalidades:

Listagem de Clínicas: Busca e filtro por nome, cidade, status.

Detalhamento de Clínica: Visualização dos dentistas e pacientes vinculados, documentos enviados.

3.4. Cadastro de Dentistas

Campos obrigatórios:

Nome completo, CRO, CPF, telefone, e-mail.

Clínicas associadas (multi-select).

Documentos obrigatórios (uploads).

Foto (opcional).

Funcionalidades:

Listagem de Dentistas: Filtros por nome, clínica.

Detalhamento de Dentista: Visualização dos pacientes e vínculo com clínicas.

3.5. Cadastro e Edição de Pedidos

Tipos de Pedido:

Complete, Self Guard, You Plan, Print 3D, Self Plan.

Campos de cada tipo de pedido:

Paciente, dentista, clínica, tipo de pedido.

Observações para planejamento (campo de texto).

Upload de arquivos de escaneamento (STL/imagens).

Campos clínicos dinâmicos conforme o tipo de pedido (linha média, arcadas, apinhamento, molar, diastemas, etc).

Funcionalidades:

Listagem de Pedidos: Filtros por status, paciente, dentista, clínica.

Detalhamento do Pedido: Visualização completa do pedido com status, histórico de interações e arquivos enviados.

3.6. Dashboard e Painel Administrativo

Funcionalidades:

Resumo de KPIs: Total de pacientes, pedidos em andamento, pedidos concluídos, pendências, etc.

Links rápidos para ações frequentes (ex: cadastro de paciente, novo pedido).

Visualização de todas as interações no sistema (ex: atualizações de status de pedidos, mensagens, interações).

3.7. Gestão Documental

Funcionalidades:

Upload de documentos obrigatórios por clínica/dentista.

Visualização e status dos documentos (pendente, aprovado, reprovado).

Possibilidade de download de documentos.

3.8. Timeline de Pedidos

Funcionalidades:

Registro de todas as interações:

Data e hora.

Autor (dentista, clínica, sistema).

Tipo de ação (envio, revisão, solicitação, pagamento).

Comentários, alterações ou observações enviadas.

Notificações automáticas conforme evento.

4. Requisitos Técnicos

Backend: PHP 7+ com CodeIgniter 3 (MVC)

Frontend: Utilização do template Tabler, já implementado, para garantir consistência e design responsivo.

Banco de Dados: MySQL/PostgreSQL.

Segurança:

Upload seguro de arquivos (STL, imagens, documentos).

Proteção contra acessos não autorizados.

Integrações:

Stripe para pagamentos (boleto, cartão).

API para notificações.

Logs e Auditoria:

Registro completo de todas as ações importantes no sistema (trilhas de auditoria).

Histórico de interações com detalhamento.

5. Fluxo de Desenvolvimento

Cadastro e Gestão de Clínicas, Dentistas e Pacientes

Desenvolvimento dos CRUDs faltantes para clínicas, dentistas e pacientes.

Funcionalidade de listagem, edição e exclusão.

Módulo de Pedidos

Criação do fluxo de pedidos com campos clínicos dinâmicos.

Implementação de upload de arquivos e gestão de status de pedidos.

Gestão de Documentos

Implementação de upload e status dos documentos obrigatórios.

Visualização e download de documentos.

Timeline e Notificações

Criação da timeline de pedidos para registrar interações e status.

Implementação de notificações automáticas e pop-ups no frontend.

Finalização e Testes

Ajustes finais no design e usabilidade, utilizando o template Tabler.

Testes de funcionalidade, segurança, responsividade e integração com Stripe.

6. Cronograma de Desenvolvimento

Fase 1: Levantamento de requisitos e planejamento – 1 semana.

Fase 2: Desenvolvimento dos CRUDs de Clínicas, Dentistas e Pacientes – 2 semanas.

Fase 3: Desenvolvimento do módulo de Pedidos e uploads – 3 semanas.

Fase 4: Implementação de Timeline e Notificações – 2 semanas.

Fase 5: Testes de usabilidade, segurança e integração – 2 semanas.

Fase 6: Ajustes finais e validações – 1 semana.

7. Notas Adicionais

O sistema utilizará os templates do Tabler já existentes, sem necessidade de alterações no front-end base.

O sistema de login, autenticação e criação de usuários já está implementado e não será alterado.

A timeline será central para o fluxo de trabalho do sistema, garantindo a transparência e a rastreabilidade de cada pedido e interação entre dentista e clínica.
