<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Base Customizado
 * 
 * Extende o CI_Controller com funcionalidades adicionais
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */

/**
 * Controller Base para Área Administrativa
 */
class Admin_Controller extends CI_Controller {

    protected $usuario;

    public function __construct() {
        parent::__construct();
        
        // Carregar biblioteca de autenticação
        $this->load->library('auth_check');
        
        // Verificar se está logado
        $this->auth_check->check_login();
        
        // Obter dados do usuário
        $this->usuario = $this->auth_check->get_usuario();
        
        // Disponibilizar para as views
        $this->load->vars(['usuario_logado' => $this->usuario]);
    }

    /**
     * Verificar permissão de admin
     */
    protected function require_admin() {
        if (!$this->auth_check->is_admin()) {
            $this->session->set_flashdata('erro', 'Você não tem permissão para acessar esta funcionalidade.');
            redirect('admin/dashboard');
        }
    }

    /**
     * Verificar permissão de gerente ou admin
     */
    protected function require_gerente() {
        if (!$this->auth_check->is_gerente_ou_admin()) {
            $this->session->set_flashdata('erro', 'Você não tem permissão para acessar esta funcionalidade.');
            redirect('admin/dashboard');
        }
    }

    /**
     * Registrar log de ação
     */
    protected function registrar_log($acao, $tabela, $registro_id, $dados_antigos = null, $dados_novos = null) {
        $data = [
            'usuario_id' => $this->usuario->id,
            'acao' => $acao,
            'tabela' => $tabela,
            'registro_id' => $registro_id,
            'dados_antigos' => $dados_antigos ? json_encode($dados_antigos) : null,
            'dados_novos' => $dados_novos ? json_encode($dados_novos) : null,
            'ip' => $this->input->ip_address(),
            'user_agent' => $this->input->user_agent(),
            'criado_em' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('logs', $data);
    }

    /**
     * Upload de arquivo
     */
    protected function upload_arquivo($campo, $pasta, $tipos_permitidos = 'jpg|jpeg|png|gif|webp') {
        $config['upload_path'] = './uploads/' . $pasta . '/';
        $config['allowed_types'] = $tipos_permitidos;
        $config['max_size'] = 5120; // 5MB
        $config['encrypt_name'] = true;

        // Criar pasta se não existir
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true);
        }

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($campo)) {
            return $this->upload->data('file_name');
        }

        return false;
    }

    /**
     * Deletar arquivo
     */
    protected function deletar_arquivo($caminho) {
        if (file_exists($caminho)) {
            return unlink($caminho);
        }
        return false;
    }

    /**
     * Resposta JSON
     */
    protected function json_response($data, $status = 200) {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    /**
     * Resposta de sucesso JSON
     */
    protected function json_success($message, $data = null) {
        $response = ['success' => true, 'message' => $message];
        if ($data) {
            $response['data'] = $data;
        }
        $this->json_response($response);
    }

    /**
     * Resposta de erro JSON
     */
    protected function json_error($message, $errors = null, $status = 400) {
        $response = ['success' => false, 'message' => $message];
        if ($errors) {
            $response['errors'] = $errors;
        }
        $this->json_response($response, $status);
    }
}

/**
 * Controller Base para Área Pública
 */
class Public_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // Configurações específicas para área pública
        $this->load->model('Configuracao_model');
        
        // Carregar configurações do site
        $configuracoes = $this->Configuracao_model->get_all_as_array();
        $this->load->vars(['configuracoes' => $configuracoes]);
    }

    /**
     * Resposta JSON
     */
    protected function json_response($data, $status = 200) {
        $this->output
            ->set_status_header($status)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    /**
     * Resposta de sucesso JSON
     */
    protected function json_success($message, $data = null) {
        $response = ['success' => true, 'message' => $message];
        if ($data) {
            $response['data'] = $data;
        }
        $this->json_response($response);
    }

    /**
     * Resposta de erro JSON
     */
    protected function json_error($message, $errors = null, $status = 400) {
        $response = ['success' => false, 'message' => $message];
        if ($errors) {
            $response['errors'] = $errors;
        }
        $this->json_response($response, $status);
    }
}
