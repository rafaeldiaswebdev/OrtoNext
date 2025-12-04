<?php
/**
 * Controller: Pedidos
 *
 * Gerencia CRUD de pedidos
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedidos extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pedido_model');
        $this->load->model('Paciente_model');
        $this->load->model('Clinica_model');
        $this->load->model('Dentista_model');
        $this->load->helper('file');
    }

    /**
     * Listagem de pedidos
     */
    public function index() {
        // Filtros
        $filtros = [
            'numero_pedido' => $this->input->get('numero_pedido'),
            'paciente_id' => $this->input->get('paciente_id'),
            'clinica_id' => $this->input->get('clinica_id'),
            'status' => $this->input->get('status'),
            'tipo_pedido' => $this->input->get('tipo_pedido')
        ];

        // Busca pedidos
        $data['pedidos'] = $this->Pedido_model->get_all($filtros);
        $data['total'] = $this->Pedido_model->count_all($filtros);

        // Dados para filtros
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['tipos_pedido'] = $this->Pedido_model->get_tipos_pedido();
        $data['status_list'] = $this->Pedido_model->get_status_list();

        // Filtros aplicados
        $data['filtros'] = $filtros;

        // Estatísticas
        $data['stats'] = $this->Pedido_model->get_estatisticas();

        // Menu ativo
        $data['menu_ativo'] = 'pedidos';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pedidos/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Formulário de criação - Etapa 1: Selecionar Paciente
     */
    public function criar() {
        $data['menu_ativo'] = 'pedidos';

        // Etapa 1: Selecionar Paciente
        $paciente_id = $this->input->get('paciente_id');

        if (!$paciente_id) {
            // Mostra lista de pacientes
            $data['pacientes'] = $this->Paciente_model->get_all();
            $data['etapa'] = 1;

            $this->load->view('admin/layout/header', $data);
            $this->load->view('admin/pedidos/criar_etapa1', $data);
            $this->load->view('admin/layout/footer', $data);
            return;
        }

        // Etapa 2: Selecionar Tipo de Pedido
        $tipo_pedido = $this->input->get('tipo_pedido');

        if (!$tipo_pedido) {
            $data['paciente'] = $this->Paciente_model->get($paciente_id);

            if (!$data['paciente']) {
                $this->session->set_flashdata('erro', 'Paciente não encontrado');
                redirect('admin/pedidos/criar');
                return;
            }

            $data['tipos_pedido'] = $this->Pedido_model->get_tipos_pedido();
            $data['etapa'] = 2;

            $this->load->view('admin/layout/header', $data);
            $this->load->view('admin/pedidos/criar_etapa2', $data);
            $this->load->view('admin/layout/footer', $data);
            return;
        }

        // Etapa 3: Formulário completo
        $data['paciente'] = $this->Paciente_model->get($paciente_id);
        $data['tipo_pedido'] = $tipo_pedido;
        $data['tipos_pedido'] = $this->Pedido_model->get_tipos_pedido();
        $data['etapa'] = 3;

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pedidos/criar_etapa3', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Salva pedido
     */
    public function salvar_pedido() {
        $id = $this->input->post('id');

        // Validação básica
        $this->form_validation->set_rules('paciente_id', 'Paciente', 'required');
        $this->form_validation->set_rules('tipo_pedido', 'Tipo de Pedido', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('erro', validation_errors());
            redirect($id ? 'admin/pedidos/editar/' . $id : 'admin/pedidos/criar');
            return;
        }

        // Busca dados do paciente
        $paciente = $this->Paciente_model->get($this->input->post('paciente_id'));

        if (!$paciente) {
            $this->session->set_flashdata('erro', 'Paciente não encontrado');
            redirect('admin/pedidos/criar');
            return;
        }

        // Prepara dados
        $data = [
            'paciente_id' => $paciente->id,
            'dentista_id' => $paciente->dentista_id,
            'clinica_id' => $paciente->clinica_id,
            'tipo_pedido' => $this->input->post('tipo_pedido'),
            'status' => $this->input->post('status') ?: 'rascunho',
            'observacoes_planejamento' => $this->input->post('observacoes_planejamento')
        ];

        // Dados clínicos (JSON)
        $dados_clinicos = $this->input->post('dados_clinicos');
        if ($dados_clinicos) {
            $data['dados_clinicos'] = json_encode($dados_clinicos);
        }

        // Salva
        if ($id) {
            // Atualização
            if ($this->Pedido_model->update($id, $data)) {
                $this->Pedido_model->adicionar_timeline([
                    'pedido_id' => $id,
                    'tipo_evento' => 'alteracao',
                    'titulo' => 'Pedido atualizado',
                    'usuario_id' => $this->session->userdata('usuario_id'),
                    'autor_tipo' => 'usuario'
                ]);

                $this->registrar_log('pedidos', 'update', $id, 'Pedido atualizado');
                $this->session->set_flashdata('sucesso', 'Pedido atualizado com sucesso!');
                redirect('admin/pedidos/visualizar/' . $id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao atualizar pedido');
                redirect('admin/pedidos/editar/' . $id);
            }
        } else {
            // Criação
            $data['criado_por'] = $this->session->userdata('usuario_id');

            $pedido_id = $this->Pedido_model->insert($data);

            if ($pedido_id) {
                // Adiciona evento de criação na timeline
                $this->Pedido_model->adicionar_timeline([
                    'pedido_id' => $pedido_id,
                    'tipo_evento' => 'criacao',
                    'titulo' => 'Pedido criado',
                    'descricao' => 'Pedido criado no sistema',
                    'usuario_id' => $this->session->userdata('usuario_id'),
                    'autor_tipo' => 'usuario'
                ]);

                $this->registrar_log('pedidos', 'insert', $pedido_id, 'Pedido criado');
                $this->session->set_flashdata('sucesso', 'Pedido criado com sucesso!');
                redirect('admin/pedidos/visualizar/' . $pedido_id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao criar pedido');
                redirect('admin/pedidos/criar');
            }
        }
    }

    /**
     * Visualização detalhada
     */
    public function visualizar($id) {
        $data['pedido'] = $this->Pedido_model->get($id);

        if (!$data['pedido']) {
            $this->session->set_flashdata('erro', 'Pedido não encontrado');
            redirect('admin/pedidos');
        }

        // Arquivos
        $data['arquivos'] = $this->Pedido_model->get_arquivos($id);

        // Timeline
        $data['timeline'] = $this->Pedido_model->get_timeline($id);

        // Status
        $data['status_list'] = $this->Pedido_model->get_status_list();
        $data['menu_ativo'] = 'pedidos';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pedidos/visualizar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Exclui pedido
     */
    public function excluir($id) {
        $pedido = $this->Pedido_model->get($id);

        if (!$pedido) {
            $this->session->set_flashdata('erro', 'Pedido não encontrado');
            redirect('admin/pedidos');
            return;
        }

        // Verifica se pode excluir
        $pode_excluir = $this->Pedido_model->pode_excluir($id);

        if (!$pode_excluir['pode']) {
            $this->session->set_flashdata('erro', $pode_excluir['motivo']);
            redirect('admin/pedidos/visualizar/' . $id);
            return;
        }

        // Exclui pedido
        if ($this->Pedido_model->delete($id)) {
            $this->registrar_log('pedidos', 'delete', $id, 'Pedido excluído: ' . $pedido->numero_pedido);
            $this->session->set_flashdata('sucesso', 'Pedido excluído com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao excluir pedido');
        }

        redirect('admin/pedidos');
    }

    /**
     * Atualiza status do pedido
     */
    public function atualizar_status($id) {
        $novo_status = $this->input->post('status');
        $descricao = $this->input->post('descricao');

        if (!$novo_status) {
            $this->session->set_flashdata('erro', 'Status não informado');
            redirect('admin/pedidos/visualizar/' . $id);
            return;
        }

        $usuario_id = $this->session->userdata('usuario_id');

        if ($this->Pedido_model->atualizar_status($id, $novo_status, $usuario_id, $descricao)) {
            $this->session->set_flashdata('sucesso', 'Status atualizado com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao atualizar status');
        }

        redirect('admin/pedidos/visualizar/' . $id);
    }

    /**
     * Upload de arquivo do pedido
     */
    public function upload_arquivo_pedido($pedido_id) {
        if (empty($_FILES['arquivo']['name'])) {
            echo json_encode(['success' => false, 'error' => 'Nenhum arquivo selecionado']);
            return;
        }

        $pasta = FCPATH . 'uploads/pedidos/' . $pedido_id . '/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        $config['upload_path'] = $pasta;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|stl|obj|zip';
        $config['max_size'] = 10240; // 10MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('arquivo')) {
            $file_data = $this->upload->data();

            $data = [
                'pedido_id' => $pedido_id,
                'tipo_arquivo' => $this->input->post('tipo_arquivo') ?: 'outro',
                'nome_original' => $file_data['orig_name'],
                'nome_arquivo' => $file_data['file_name'],
                'caminho' => 'uploads/pedidos/' . $pedido_id . '/' . $file_data['file_name'],
                'tamanho' => $file_data['file_size'] * 1024,
                'mime_type' => $file_data['file_type'],
                'enviado_por' => $this->session->userdata('usuario_id')
            ];

            if ($this->Pedido_model->adicionar_arquivo($data)) {
                echo json_encode(['success' => true, 'file' => $data]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erro ao salvar arquivo no banco']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => $this->upload->display_errors('', '')]);
        }
    }
}
