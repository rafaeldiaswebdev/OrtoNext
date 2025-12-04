<?php
/**
 * Controller: Pacientes
 *
 * Gerencia CRUD de pacientes
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pacientes extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Paciente_model');
        $this->load->model('Clinica_model');
        $this->load->model('Dentista_model');
        $this->load->helper('file');
    }

    /**
     * Listagem de pacientes
     */
    public function index() {
        // Filtros
        $filtros = [
            'nome' => $this->input->get('nome'),
            'cpf' => $this->input->get('cpf'),
            'clinica_id' => $this->input->get('clinica_id'),
            'dentista_id' => $this->input->get('dentista_id'),
            'genero' => $this->input->get('genero')
        ];

        // Busca pacientes
        $data['pacientes'] = $this->Paciente_model->get_all($filtros);
        $data['total'] = $this->Paciente_model->count_all($filtros);

        // Busca clínicas e dentistas para filtros
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['dentistas'] = $this->Dentista_model->get_all(['status' => 'ativo']);

        // Filtros aplicados
        $data['filtros'] = $filtros;

        // Estatísticas
        $data['stats'] = [
            'total_pacientes' => $this->Paciente_model->count_all(),
            'masculino' => $this->Paciente_model->count_all(['genero' => 'masculino']),
            'feminino' => $this->Paciente_model->count_all(['genero' => 'feminino'])
        ];

        // Menu ativo
        $data['menu_ativo'] = 'pacientes';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pacientes/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Formulário de criação
     */
    public function criar() {
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['menu_ativo'] = 'pacientes';

        // Se já selecionou a clínica, carrega os dentistas
        $clinica_selecionada = $this->input->get('clinica_id');
        if ($clinica_selecionada) {
            $data['clinica_selecionada'] = $clinica_selecionada;
            $data['dentistas'] = $this->Paciente_model->get_dentistas_por_clinica($clinica_selecionada);
        } else {
            $data['clinica_selecionada'] = null;
            $data['dentistas'] = [];
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pacientes/criar', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Formulário de edição
     */
    public function editar($id) {
        $data['paciente'] = $this->Paciente_model->get($id);

        if (!$data['paciente']) {
            $this->session->set_flashdata('erro', 'Paciente não encontrado');
            redirect('admin/pacientes');
        }

        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['dentistas'] = $this->Paciente_model->get_dentistas_por_clinica($data['paciente']->clinica_id);
        $data['menu_ativo'] = 'pacientes';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pacientes/editar', $data);
        $this->load->view('admin/layout/footer', $data);
    }

    /**
     * Visualização detalhada
     */
    public function visualizar($id) {
        $data['paciente'] = $this->Paciente_model->get($id);

        if (!$data['paciente']) {
            $this->session->set_flashdata('erro', 'Paciente não encontrado');
            redirect('admin/pacientes');
        }

        // Calcula idade
        $data['idade'] = $this->Paciente_model->calcular_idade($data['paciente']->data_nascimento);

        // Busca pedidos
        $data['pedidos'] = $this->Paciente_model->get_pedidos($id, 10);

        // Estatísticas
        $data['stats'] = $this->Paciente_model->get_estatisticas($id);
        $data['menu_ativo'] = 'pacientes';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/pacientes/visualizar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Salva paciente (criar ou editar)
     */
    public function salvar_paciente() {
        $id = $this->input->post('id');

        // Validação
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('data_nascimento', 'Data de Nascimento', 'required');
        $this->form_validation->set_rules('genero', 'Gênero', 'required');
        $this->form_validation->set_rules('cpf', 'CPF', 'required');
        $this->form_validation->set_rules('clinica_id', 'Clínica', 'required');
        $this->form_validation->set_rules('dentista_id', 'Dentista', 'required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'max_length[20]');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('erro', validation_errors());
            redirect($id ? 'admin/pacientes/editar/' . $id : 'admin/pacientes/criar');
            return;
        }

        // Valida CPF após remover máscara
        $cpf_limpo = preg_replace('/[^0-9]/', '', $this->input->post('cpf'));
        if (strlen($cpf_limpo) != 11) {
            $this->session->set_flashdata('erro', 'CPF inválido');
            redirect($id ? 'admin/pacientes/editar/' . $id : 'admin/pacientes/criar');
            return;
        }

        // Verifica CPF duplicado
        if ($this->Paciente_model->cpf_existe($cpf_limpo, $id)) {
            $this->session->set_flashdata('erro', 'CPF já cadastrado no sistema');
            redirect($id ? 'admin/pacientes/editar/' . $id : 'admin/pacientes/criar');
            return;
        }

        // Prepara dados
        $data = [
            'nome' => $this->input->post('nome'),
            'data_nascimento' => $this->input->post('data_nascimento'),
            'genero' => $this->input->post('genero'),
            'cpf' => $cpf_limpo,
            'telefone' => $this->input->post('telefone'),
            'email' => $this->input->post('email'),
            'clinica_id' => $this->input->post('clinica_id'),
            'dentista_id' => $this->input->post('dentista_id'),
            'observacoes' => $this->input->post('observacoes')
        ];

        // Upload de foto
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->upload_foto($id);
            if ($foto['success']) {
                $data['foto'] = $foto['file_name'];

                // Remove foto antiga se estiver editando
                if ($id) {
                    $paciente = $this->Paciente_model->get($id);
                    if ($paciente && $paciente->foto) {
                        $caminho_antigo = FCPATH . 'uploads/pacientes/fotos/' . $paciente->foto;
                        if (file_exists($caminho_antigo)) {
                            unlink($caminho_antigo);
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('erro', $foto['error']);
                redirect($id ? 'admin/pacientes/editar/' . $id : 'admin/pacientes/criar');
                return;
            }
        }

        // Salva
        if ($id) {
            // Atualização
            if ($this->Paciente_model->update($id, $data)) {
                $this->registrar_log('pacientes', 'update', $id, 'Paciente atualizado: ' . $data['nome']);
                $this->session->set_flashdata('sucesso', 'Paciente atualizado com sucesso!');
                redirect('admin/pacientes/visualizar/' . $id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao atualizar paciente');
                redirect('admin/pacientes/editar/' . $id);
            }
        } else {
            // Criação
            $data['criado_por'] = $this->session->userdata('usuario_id');

            $paciente_id = $this->Paciente_model->insert($data);

            if ($paciente_id) {
                $this->registrar_log('pacientes', 'insert', $paciente_id, 'Paciente criado: ' . $data['nome']);
                $this->session->set_flashdata('sucesso', 'Paciente cadastrado com sucesso!');
                redirect('admin/pacientes/visualizar/' . $paciente_id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao cadastrar paciente');
                redirect('admin/pacientes/criar');
            }
        }
    }

    /**
     * Exclui paciente
     */
    public function excluir($id) {
        $paciente = $this->Paciente_model->get($id);

        if (!$paciente) {
            $this->session->set_flashdata('erro', 'Paciente não encontrado');
            redirect('admin/pacientes');
            return;
        }

        // Verifica se pode excluir
        $pode_excluir = $this->Paciente_model->pode_excluir($id);

        if (!$pode_excluir['pode']) {
            $this->session->set_flashdata('erro', $pode_excluir['motivo']);
            redirect('admin/pacientes/visualizar/' . $id);
            return;
        }

        // Remove foto
        if ($paciente->foto) {
            $caminho_foto = FCPATH . 'uploads/pacientes/fotos/' . $paciente->foto;
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto);
            }
        }

        // Exclui paciente
        if ($this->Paciente_model->delete($id)) {
            $this->registrar_log('pacientes', 'delete', $id, 'Paciente excluído: ' . $paciente->nome);
            $this->session->set_flashdata('sucesso', 'Paciente excluído com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao excluir paciente');
        }

        redirect('admin/pacientes');
    }

    /**
     * Upload de foto
     */
    private function upload_foto($paciente_id = null) {
        $pasta = FCPATH . 'uploads/pacientes/fotos/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        $config['upload_path'] = $pasta;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('foto')) {
            return [
                'success' => true,
                'file_name' => $this->upload->data('file_name')
            ];
        } else {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        }
    }

    /**
     * Página de debug
     */
    public function debug() {
        $this->load->view('admin/pacientes/debug');
    }

    /**
     * AJAX: Busca dentistas por clínica
     */
    public function get_dentistas_por_clinica() {
        $clinica_id = $this->input->post('clinica_id');

        log_message('debug', 'Buscando dentistas para clínica: ' . $clinica_id);

        if (!$clinica_id) {
            echo json_encode([]);
            return;
        }

        $dentistas = $this->Paciente_model->get_dentistas_por_clinica($clinica_id);

        log_message('debug', 'Dentistas encontrados: ' . count($dentistas));

        echo json_encode($dentistas);
    }
}
