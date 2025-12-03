<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller de Clínicas
 *
 * Gerencia o CRUD de clínicas do sistema
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
class Clinicas extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Clinica_model');
        $this->load->helper('file');
    }

    /**
     * Listagem de clínicas
     */
    public function index() {
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Pragma: no-cache');

        $data['titulo'] = 'Clínicas';
        $data['menu_ativo'] = 'clinicas';

        // Filtros
        $filtros = [
            'busca' => $this->input->get('busca'),
            'cidade' => $this->input->get('cidade'),
            'status_validacao' => $this->input->get('status_validacao')
        ];

        // Buscar clínicas
        $data['clinicas'] = $this->Clinica_model->get_all($filtros);
        $data['total'] = count($data['clinicas']);
        $data['filtros'] = $filtros;

        // Buscar cidades para o filtro
        $data['cidades'] = $this->Clinica_model->get_cidades();

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/clinicas/index', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Criar nova clínica
     */
    public function criar() {
        $data['titulo'] = 'Nova Clínica';
        $data['menu_ativo'] = 'clinicas';

        if ($this->input->method() === 'post') {
            $this->salvar_clinica();
            return;
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/clinicas/criar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Editar clínica
     */
    public function editar($id) {
        $data['titulo'] = 'Editar Clínica';
        $data['menu_ativo'] = 'clinicas';

        $data['clinica'] = $this->Clinica_model->get($id);

        if (!$data['clinica']) {
            $this->session->set_flashdata('erro', 'Clínica não encontrada.');
            redirect('admin/clinicas');
        }

        if ($this->input->method() === 'post') {
            $this->salvar_clinica($id);
            return;
        }

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/clinicas/editar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Visualizar clínica
     */
    public function visualizar($id) {
        $data['titulo'] = 'Detalhes da Clínica';
        $data['menu_ativo'] = 'clinicas';

        $data['clinica'] = $this->Clinica_model->get($id);

        if (!$data['clinica']) {
            $this->session->set_flashdata('erro', 'Clínica não encontrada.');
            redirect('admin/clinicas');
        }

        // Buscar dados relacionados
        $data['dentistas'] = $this->Clinica_model->get_dentistas($id);
        $data['pacientes'] = $this->Clinica_model->get_pacientes($id);
        $data['estatisticas'] = $this->Clinica_model->get_estatisticas($id);

        $this->load->view('admin/layout/header', $data);
        $this->load->view('admin/clinicas/visualizar', $data);
        $this->load->view('admin/layout/footer');
    }

    /**
     * Salvar clínica (criar ou editar)
     */
    private function salvar_clinica($id = null) {
        $this->load->library('form_validation');

        // Regras de validação
        $this->form_validation->set_rules('nome', 'Nome da Clínica', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('responsavel_tecnico', 'Responsável Técnico', 'required|max_length[100]');
        $this->form_validation->set_rules('cro_responsavel', 'CRO do Responsável', 'required|max_length[20]');
        $this->form_validation->set_rules('email', 'E-mail', 'valid_email|max_length[100]');
        $this->form_validation->set_rules('telefone', 'Telefone', 'max_length[20]');
        $this->form_validation->set_rules('whatsapp', 'WhatsApp', 'max_length[20]');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('erro', validation_errors());
            if ($id) {
                redirect('admin/clinicas/editar/' . $id);
            } else {
                redirect('admin/clinicas/criar');
            }
            return;
        }

        // Validar CNPJ
        $cnpj = preg_replace('/[^0-9]/', '', $this->input->post('cnpj'));
        if (!$this->Clinica_model->validar_cnpj($cnpj)) {
            $this->session->set_flashdata('erro', 'CNPJ inválido.');
            if ($id) {
                redirect('admin/clinicas/editar/' . $id);
            } else {
                redirect('admin/clinicas/criar');
            }
            return;
        }

        // Verificar se CNPJ já existe (exceto a própria clínica)
        $cnpj_existe = $this->Clinica_model->get_by_cnpj($cnpj);
        if ($cnpj_existe && (!$id || $cnpj_existe->id != $id)) {
            $this->session->set_flashdata('erro', 'Este CNPJ já está cadastrado.');
            if ($id) {
                redirect('admin/clinicas/editar/' . $id);
            } else {
                redirect('admin/clinicas/criar');
            }
            return;
        }

        // Preparar dados
        $dados = [
            'nome' => $this->input->post('nome'),
            'cnpj' => $cnpj,
            'responsavel_tecnico' => $this->input->post('responsavel_tecnico'),
            'cro_responsavel' => $this->input->post('cro_responsavel'),
            'cep' => $this->input->post('cep'),
            'logradouro' => $this->input->post('logradouro'),
            'numero' => $this->input->post('numero'),
            'complemento' => $this->input->post('complemento'),
            'bairro' => $this->input->post('bairro'),
            'cidade' => $this->input->post('cidade'),
            'estado' => $this->input->post('estado'),
            'telefone' => $this->input->post('telefone'),
            'email' => $this->input->post('email'),
            'whatsapp' => $this->input->post('whatsapp'),
            'observacoes' => $this->input->post('observacoes')
        ];

        // Upload de logo
        if (!empty($_FILES['logo']['name'])) {
            $upload_logo = $this->upload_logo();
            if ($upload_logo['success']) {
                $dados['logo'] = $upload_logo['file_name'];

                // Remover logo antigo se estiver editando
                if ($id) {
                    $clinica_antiga = $this->Clinica_model->get($id);
                    if ($clinica_antiga->logo && file_exists('./uploads/clinicas/logos/' . $clinica_antiga->logo)) {
                        unlink('./uploads/clinicas/logos/' . $clinica_antiga->logo);
                    }
                }
            } else {
                $this->session->set_flashdata('erro', $upload_logo['error']);
                if ($id) {
                    redirect('admin/clinicas/editar/' . $id);
                } else {
                    redirect('admin/clinicas/criar');
                }
                return;
            }
        }

        // Upload de documentos
        $documentos = ['doc_cnh', 'doc_rg', 'doc_cpf', 'doc_cro'];
        foreach ($documentos as $doc) {
            if (!empty($_FILES[$doc]['name'])) {
                $upload_doc = $this->upload_documento($doc);
                if ($upload_doc['success']) {
                    $dados[$doc] = $upload_doc['file_name'];

                    // Remover documento antigo se estiver editando
                    if ($id) {
                        $clinica_antiga = $this->Clinica_model->get($id);
                        if ($clinica_antiga->$doc && file_exists('./uploads/clinicas/documentos/' . $clinica_antiga->$doc)) {
                            unlink('./uploads/clinicas/documentos/' . $clinica_antiga->$doc);
                        }
                    }
                } else {
                    $this->session->set_flashdata('erro', $upload_doc['error']);
                    if ($id) {
                        redirect('admin/clinicas/editar/' . $id);
                    } else {
                        redirect('admin/clinicas/criar');
                    }
                    return;
                }
            }
        }

        if ($id) {
            // Buscar dados antigos
            $dados_antigos = $this->Clinica_model->get($id);

            // Atualizar
            if ($this->Clinica_model->update($id, $dados)) {
                // Registrar log
                $this->registrar_log('editar', 'clinicas', $id, $dados_antigos, $dados);

                $this->session->set_flashdata('sucesso', 'Clínica atualizada com sucesso!');
            } else {
                $this->session->set_flashdata('erro', 'Erro ao atualizar clínica.');
            }
            redirect('admin/clinicas');
        } else {
            // Criar
            $novo_id = $this->Clinica_model->insert($dados);
            if ($novo_id) {
                // Registrar log
                $this->registrar_log('criar', 'clinicas', $novo_id, null, $dados);

                $this->session->set_flashdata('sucesso', 'Clínica criada com sucesso!');
                redirect('admin/clinicas');
            } else {
                $this->session->set_flashdata('erro', 'Erro ao criar clínica.');
                redirect('admin/clinicas/criar');
            }
        }
    }

    /**
     * Excluir clínica
     */
    public function excluir($id) {
        $clinica = $this->Clinica_model->get($id);

        if (!$clinica) {
            $this->session->set_flashdata('erro', 'Clínica não encontrada.');
            redirect('admin/clinicas');
        }

        if ($this->Clinica_model->delete($id)) {
            // Remover arquivos
            if ($clinica->logo && file_exists('./uploads/clinicas/logos/' . $clinica->logo)) {
                unlink('./uploads/clinicas/logos/' . $clinica->logo);
            }

            $documentos = ['doc_cnh', 'doc_rg', 'doc_cpf', 'doc_cro'];
            foreach ($documentos as $doc) {
                if ($clinica->$doc && file_exists('./uploads/clinicas/documentos/' . $clinica->$doc)) {
                    unlink('./uploads/clinicas/documentos/' . $clinica->$doc);
                }
            }

            // Registrar log
            $this->registrar_log('deletar', 'clinicas', $id, $clinica);

            $this->session->set_flashdata('sucesso', 'Clínica excluída com sucesso!');
        } else {
            $this->session->set_flashdata('erro', 'Não é possível excluir esta clínica. Ela possui dentistas ou pacientes vinculados.');
        }

        redirect('admin/clinicas');
    }

    /**
     * Validar documentos da clínica
     */
    public function validar($id) {
        $clinica = $this->Clinica_model->get($id);

        if (!$clinica) {
            $this->session->set_flashdata('erro', 'Clínica não encontrada.');
            redirect('admin/clinicas');
        }

        if ($this->input->method() === 'post') {
            $status = $this->input->post('status_validacao');
            $observacoes = $this->input->post('observacoes');

            if ($this->Clinica_model->atualizar_validacao($id, $status, $observacoes)) {
                // Registrar log
                $this->registrar_log('validar_clinica', 'clinicas', $id, $clinica, ['status_validacao' => $status, 'observacoes' => $observacoes]);

                $this->session->set_flashdata('sucesso', 'Status de validação atualizado!');
            } else {
                $this->session->set_flashdata('erro', 'Erro ao atualizar status.');
            }

            redirect('admin/clinicas/visualizar/' . $id);
        }
    }

    /**
     * Upload de logo
     */
    private function upload_logo() {
        // Criar diretório se não existir
        if (!is_dir('./uploads/clinicas/logos')) {
            mkdir('./uploads/clinicas/logos', 0755, true);
        }

        $config['upload_path'] = './uploads/clinicas/logos/';
        $config['allowed_types'] = 'png';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = 'logo_' . time() . '_' . uniqid();
        $config['encrypt_name'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('logo')) {
            $upload_data = $this->upload->data();

            // Verificar dimensões (opcional - pode redimensionar se necessário)
            // Por enquanto, apenas aceita o upload

            return [
                'success' => true,
                'file_name' => $upload_data['file_name']
            ];
        } else {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        }
    }

    /**
     * Upload de documento
     */
    private function upload_documento($field_name) {
        // Criar diretório se não existir
        if (!is_dir('./uploads/clinicas/documentos')) {
            mkdir('./uploads/clinicas/documentos', 0755, true);
        }

        $config['upload_path'] = './uploads/clinicas/documentos/';
        $config['allowed_types'] = 'pdf|jpg|jpeg|png';
        $config['max_size'] = 5120; // 5MB
        $config['file_name'] = $field_name . '_' . time() . '_' . uniqid();
        $config['encrypt_name'] = FALSE;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($field_name)) {
            $upload_data = $this->upload->data();

            return [
                'success' => true,
                'file_name' => $upload_data['file_name']
            ];
        } else {
            return [
                'success' => false,
                'error' => $this->upload->display_errors('', '')
            ];
        }
    }

}
