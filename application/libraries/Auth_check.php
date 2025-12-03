<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Biblioteca de Verificação de Autenticação
 * 
 * Middleware para proteger rotas administrativas
 * 
 * @author Rafael Dias - doisr.com.br
 * @date 13/11/2024
 */
class Auth_check {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    /**
     * Verificar se usuário está logado
     */
    public function check_login($redirect = true) {
        if (!$this->CI->session->userdata('usuario_logado')) {
            if ($redirect) {
                $current_url = current_url();
                $this->CI->session->set_flashdata('erro', 'Você precisa estar logado para acessar esta página.');
                redirect('login?redirect=' . urlencode($current_url));
            }
            return false;
        }
        return true;
    }

    /**
     * Verificar nível de acesso
     */
    public function check_nivel($niveis_permitidos = [], $redirect = true) {
        // Primeiro verificar se está logado
        if (!$this->check_login($redirect)) {
            return false;
        }

        $nivel_usuario = $this->CI->session->userdata('usuario_nivel');

        if (!in_array($nivel_usuario, $niveis_permitidos)) {
            if ($redirect) {
                $this->CI->session->set_flashdata('erro', 'Você não tem permissão para acessar esta página.');
                redirect('admin/dashboard');
            }
            return false;
        }

        return true;
    }

    /**
     * Verificar se é admin
     */
    public function is_admin() {
        return $this->CI->session->userdata('usuario_nivel') === 'admin';
    }

    /**
     * Verificar se é gerente ou admin
     */
    public function is_gerente_ou_admin() {
        $nivel = $this->CI->session->userdata('usuario_nivel');
        return in_array($nivel, ['admin', 'gerente']);
    }

    /**
     * Obter dados do usuário logado
     */
    public function get_usuario() {
        if (!$this->check_login(false)) {
            return null;
        }

        return (object) [
            'id' => $this->CI->session->userdata('usuario_id'),
            'nome' => $this->CI->session->userdata('usuario_nome'),
            'email' => $this->CI->session->userdata('usuario_email'),
            'nivel' => $this->CI->session->userdata('usuario_nivel'),
            'avatar' => $this->CI->session->userdata('usuario_avatar')
        ];
    }

    /**
     * Obter ID do usuário logado
     */
    public function get_usuario_id() {
        return $this->CI->session->userdata('usuario_id');
    }

    /**
     * Obter nome do usuário logado
     */
    public function get_usuario_nome() {
        return $this->CI->session->userdata('usuario_nome');
    }

    /**
     * Obter nível do usuário logado
     */
    public function get_usuario_nivel() {
        return $this->CI->session->userdata('usuario_nivel');
    }
}
