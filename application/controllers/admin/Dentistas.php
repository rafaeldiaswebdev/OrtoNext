<?php
/**
 * Controller: Dentistas
 *
 * Gerencia CRUD de dentistas
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dentistas extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dentista_model');
        $this->load->model('Clinica_model');
        $this->load->helper('file');
    }

    /**
     * Listagem de dentistas
     */
    public function index() {
        // Filtros
        $filtros = [
            'nome' => $this->input->get('nome'),
            'cro' => $this->input->get('cro'),
            'clinica_id' => $this->input->get('clinica_id'),
            'status' => $this->input->get('status')
        ];

        // Busca dentistas
        $data['dentistas'] = $this->Dentista_model->get_all($filtros);
        $data['total'] = $this->Dentista_model->count_all($filtros);

        // Busca clínicas para filtro
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);

        // Filtros aplicados
        $data['filtros'] = $filtros;

        // Estatísticas
        $data['stats'] = [
            'total_dentistas' => $this->Dentista_model->count_all(),
            'ativos' => $this->Dentista_model->count_all(['status' => 'ativo']),
            'inativos' => $this->Dentista_model->count_all(['status' => 'inativo'])
        ];

        // Menu ativo
        $data['menu_ativo'] = 'dentistas';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dentistas/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Formulário de criação
     */
    public function criar() {
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['menu_ativo'] = 'dentistas';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dentistas/criar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Formulário de edição
     */
    public function editar($id) {
        $data['dentista'] = $this->Dentista_model->get($id);

        if (!$data['dentista']) {
            $this->session->set_flashdata('erro', 'Dentista não encontrado');
            redirect('admin/dentistas');
        }

        // Busca clínicas vinculadas
        $data['clinicas_vinculadas'] = $this->Dentista_model->get_clinicas($id);
        $clinicas_ids = array_column($data['clinicas_vinculadas'], 'id');
        $data['clinicas_vinculadas_ids'] = $clinicas_ids;

        // Busca todas as clínicas
        $data['clinicas'] = $this->Clinica_model->get_all(['status' => 1]);
        $data['menu_ativo'] = 'dentistas';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dentistas/editar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Visualização detalhada
     */
    public function visualizar($id) {
        $data['dentista'] = $this->Dentista_model->get($id);

        if (!$data['dentista']) {
            $this->session->set_flashdata('erro', 'Dentista não encontrado');
            redirect('admin/dentistas');
        }

        // Busca clínicas vinculadas
        $data['clinicas'] = $this->Dentista_model->get_clinicas($id);

        // Busca pacientes
        $data['pacientes'] = $this->Dentista_model->get_pacientes($id, 10);

        // Estatísticas
        $data['stats'] = $this->Dentista_model->get_estatisticas($id);
        $data['menu_ativo'] = 'dentistas';

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/dentistas/visualizar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Salva dentista (criar ou editar)
     */
    public function salvar_dentista() {
        $id = $this->input->post('id');

        // Validação
        $this->form_validation->set_rules('nome', 'Nome', 'required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('cro', 'CRO', 'required|max_length[20]');
        $this->form_validation->set_rules('cpf', 'CPF', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|max_length[100]');
        $this->form_validation->set_rules('telefone', 'Telefone', 'max_length[20]');
        $this->form_validation->set_rules('especialidade', 'Especialidade', 'max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('erro', validation_errors());
            redirect($id ? 'admin/dentistas/editar/' . $id : 'admin/dentistas/criar');
            return;
        }

        // Valida CPF após remover máscara
        $cpf_limpo = preg_replace('/[^0-9]/', '', $this->input->post('cpf'));
        if (strlen($cpf_limpo) != 11) {
            $this->session->set_flashdata('erro', 'CPF inválido');
            redirect($id ? 'admin/dentistas/editar/' . $id : 'admin/dentistas/criar');
            return;
        }

        // Verifica CRO duplicado
        $cro = $this->input->post('cro');
        if ($this->Dentista_model->cro_existe($cro, $id)) {
            $this->session->set_flashdata('erro', 'CRO já cadastrado no sistema');
            redirect($id ? 'admin/dentistas/editar/' . $id : 'admin/dentistas/criar');
            return;
        }

        // Verifica CPF duplicado (usa a variável já limpa)
        if ($this->Dentista_model->cpf_existe($cpf_limpo, $id)) {
            $this->session->set_flashdata('erro', 'CPF já cadastrado no sistema');
            redirect($id ? 'admin/dentistas/editar/' . $id : 'admin/dentistas/criar');
            return;
        }

        // Prepara dados
        $status_values = $this->input->post('status');

        // Debug: Log do valor recebido
        log_message('debug', 'Status recebido: ' . print_r($status_values, true));

        // Determina o status baseado no valor recebido
        if (is_array($status_values)) {
            // Se for array, verifica se tem o valor '1'
            $status = in_array('1', $status_values) ? 'ativo' : 'inativo';
        } else {
            // Se for string, verifica se é '1'
            $status = ($status_values == '1') ? 'ativo' : 'inativo';
        }

        // Debug: Log do status final
        log_message('debug', 'Status final: ' . $status);

        $data = [
            'nome' => $this->input->post('nome'),
            'cro' => $this->input->post('cro'),
            'cpf' => $cpf_limpo,
            'email' => $this->input->post('email'),
            'telefone' => $this->input->post('telefone'),
            'whatsapp' => $this->input->post('whatsapp'),
            'especialidade' => $this->input->post('especialidade'),
            'observacoes' => $this->input->post('observacoes'),
            'status' => $status
        ];

        // Upload de foto
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->upload_foto($id);
            if ($foto['success']) {
                $data['foto'] = $foto['file_name'];

                // Remove foto antiga se estiver editando
                if ($id) {
                    $dentista = $this->Dentista_model->get($id);
                    if ($dentista && $dentista->foto) {
                        $caminho_antigo = FCPATH . 'uploads/dentistas/fotos/' . $dentista->foto;
                        if (file_exists($caminho_antigo)) {
                            unlink($caminho_antigo);
                        }
                    }
                }
            } else {
                $this->session->set_flashdata('erro', $foto['error']);
                redirect($id ? 'admin/dentistas/editar/' . $id : 'admin/dentistas/criar');
                return;
            }
        }

        // Salva
        if ($id) {
            // Debug: Log dos dados antes de salvar
            log_message('debug', 'Dados para atualizar: ' . print_r($data, true));

            // Atualização
            if ($this->Dentista_model->update($id, $data)) {
                // Sincroniza clínicas
                $clinicas = $this->input->post('clinicas');
                $this->Dentista_model->sincronizar_clinicas($id, $clinicas ? $clinicas : []);

                // Upload de documentos
                $this->processar_documentos($id);

                // Debug: Verifica o que foi salvo
                $dentista_salvo = $this->Dentista_model->get($id);
                log_message('debug', 'Status salvo no banco: ' . $dentista_salvo->status);

                $this->registrar_log('dentistas', 'update', $id, 'Dentista atualizado: ' . $data['nome']);
                $this->session->set_flashdata('sucesso', 'Dentista atualizado com sucesso!');
                redirect('admin/dentistas/visualizar/' . $id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao atualizar dentista');
                redirect('admin/dentistas/editar/' . $id);
            }
        } else {
            // Criação
            $data['criado_por'] = $this->session->userdata('usuario_id');

            $dentista_id = $this->Dentista_model->insert($data);

            if ($dentista_id) {
                // Sincroniza clínicas
                $clinicas = $this->input->post('clinicas');
                $this->Dentista_model->sincronizar_clinicas($dentista_id, $clinicas ? $clinicas : []);

                // Upload de documentos
                $this->processar_documentos($dentista_id);

                $this->registrar_log('dentistas', 'insert', $dentista_id, 'Dentista criado: ' . $data['nome']);
                $this->session->set_flashdata('sucesso', 'Dentista cadastrado com sucesso!');
                redirect('admin/dentistas/visualizar/' . $dentista_id);
            } else {
                $this->session->set_flashdata('erro', 'Erro ao cadastrar dentista');
                redirect('admin/dentistas/criar');
            }
        }
    }

    /**
     * Exclui dentista
     */
    public function excluir($id) {
        $dentista = $this->Dentista_model->get($id);

        if (!$dentista) {
            $this->session->set_flashdata('erro', 'Dentista não encontrado');
            redirect('admin/dentistas');
            return;
        }

        // Verifica se pode excluir
        $pode_excluir = $this->Dentista_model->pode_excluir($id);

        if (!$pode_excluir['pode']) {
            $this->session->set_flashdata('erro', $pode_excluir['motivo']);
            redirect('admin/dentistas/visualizar/' . $id);
            return;
        }

        // Remove vínculos
        $this->Dentista_model->remover_todos_vinculos($id);

        // Remove arquivos
        if ($dentista->foto) {
            $caminho_foto = FCPATH . 'uploads/dentistas/fotos/' . $dentista->foto;
            if (file_exists($caminho_foto)) {
                unlink($caminho_foto);
            }
        }

        // Remove pasta de documentos
        $pasta_docs = FCPATH . 'uploads/dentistas/documentos/' . $id;
        if (is_dir($pasta_docs)) {
            $this->deletar_pasta($pasta_docs);
        }

        // Exclui dentista
        if ($this->Dentista_model->delete($id)) {
            $this->registrar_log('dentistas', 'delete', $id, 'Dentista excluído: ' . $dentista->nome);
            $this->session->set_flashdata('sucesso', 'Dentista excluído com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Erro ao excluir dentista');
        }

        redirect('admin/dentistas');
    }

    /**
     * Upload de foto
     */
    private function upload_foto($dentista_id = null) {
        $pasta = FCPATH . 'uploads/dentistas/fotos/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        $config['upload_path'] = $pasta;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
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
     * Processa upload de documentos
     */
    private function processar_documentos($dentista_id) {
        $pasta = FCPATH . 'uploads/dentistas/documentos/' . $dentista_id . '/';

        if (!is_dir($pasta)) {
            mkdir($pasta, 0755, true);
        }

        $documentos = ['doc_cnh', 'doc_rg', 'doc_cpf', 'doc_cro'];

        foreach ($documentos as $doc) {
            if (!empty($_FILES[$doc]['name'])) {
                $config['upload_path'] = $pasta;
                $config['allowed_types'] = 'pdf|jpg|jpeg|png';
                $config['max_size'] = 5120;
                $config['file_name'] = $doc . '_' . time();

                $this->upload->initialize($config);

                if ($this->upload->do_upload($doc)) {
                    // Sucesso - arquivo salvo
                } else {
                    // Erro no upload - pode logar ou ignorar
                }
            }
        }
    }

    /**
     * Deleta pasta recursivamente
     */
    private function deletar_pasta($pasta) {
        if (!is_dir($pasta)) {
            return;
        }

        $arquivos = array_diff(scandir($pasta), ['.', '..']);

        foreach ($arquivos as $arquivo) {
            $caminho = $pasta . '/' . $arquivo;
            is_dir($caminho) ? $this->deletar_pasta($caminho) : unlink($caminho);
        }

        rmdir($pasta);
    }
}
