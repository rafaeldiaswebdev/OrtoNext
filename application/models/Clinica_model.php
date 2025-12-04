<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model de Clínicas
 *
 * Gerencia operações relacionadas às clínicas do sistema
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
class Clinica_model extends CI_Model {

    protected $table = 'clinicas';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Buscar clínica por ID
     */
    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    /**
     * Buscar clínica por CNPJ
     */
    public function get_by_cnpj($cnpj) {
        return $this->db->get_where($this->table, ['cnpj' => $cnpj])->row();
    }

    /**
     * Listar todas as clínicas
     */
    public function get_all($filtros = []) {
        // Busca por nome ou CNPJ
        if (isset($filtros['busca']) && $filtros['busca']) {
            $this->db->group_start();
            $this->db->like('nome', $filtros['busca']);
            $this->db->or_like('cnpj', $filtros['busca']);
            $this->db->group_end();
        }

        // Filtro por cidade
        if (isset($filtros['cidade']) && $filtros['cidade']) {
            $this->db->where('cidade', $filtros['cidade']);
        }

        // Filtro por status de validação
        if (isset($filtros['status_validacao']) && $filtros['status_validacao']) {
            $this->db->where('status_validacao', $filtros['status_validacao']);
        }

        $this->db->order_by('nome', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /**
     * Inserir nova clínica
     */
    public function insert($data) {
        $data['criado_por'] = $this->session->userdata('usuario_id');
        $data['criado_em'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Atualizar clínica
     */
    public function update($id, $data) {
        $data['atualizado_em'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Deletar clínica
     */
    public function delete($id) {
        // Verificar se tem dentistas vinculados
        $this->db->where('clinica_id', $id);
        $tem_dentistas = $this->db->count_all_results('dentista_clinica') > 0;

        if ($tem_dentistas) {
            return false; // Não pode excluir se tiver dentistas vinculados
        }

        // Verificar se tem pacientes
        $this->db->where('clinica_id', $id);
        $tem_pacientes = $this->db->count_all_results('pacientes') > 0;

        if ($tem_pacientes) {
            return false; // Não pode excluir se tiver pacientes
        }

        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    /**
     * Contar clínicas
     */
    public function count($filtros = []) {
        if (isset($filtros['status_validacao'])) {
            $this->db->where('status_validacao', $filtros['status_validacao']);
        }

        return $this->db->count_all_results($this->table);
    }

    /**
     * Buscar cidades únicas para filtro
     */
    public function get_cidades() {
        $this->db->select('cidade');
        $this->db->distinct();
        $this->db->where('cidade IS NOT NULL');
        $this->db->where('cidade !=', '');
        $this->db->order_by('cidade', 'ASC');

        $result = $this->db->get($this->table)->result();

        $cidades = [];
        foreach ($result as $row) {
            $cidades[] = $row->cidade;
        }

        return $cidades;
    }

    /**
     * Buscar dentistas vinculados à clínica
     */
    public function get_dentistas($clinica_id) {
        $this->db->select('dentistas.*, dentista_clinica.criado_em as vinculado_em');
        $this->db->from('dentistas');
        $this->db->join('dentista_clinica', 'dentista_clinica.dentista_id = dentistas.id');
        $this->db->where('dentista_clinica.clinica_id', $clinica_id);
        $this->db->order_by('dentistas.nome', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Buscar pacientes da clínica
     */
    public function get_pacientes($clinica_id) {
        $this->db->select('pacientes.*, dentistas.nome as dentista_nome');
        $this->db->from('pacientes');
        $this->db->join('dentistas', 'dentistas.id = pacientes.dentista_id');
        $this->db->where('pacientes.clinica_id', $clinica_id);
        $this->db->order_by('pacientes.nome', 'ASC');

        return $this->db->get()->result();
    }

    /**
     * Buscar estatísticas da clínica
     */
    public function get_estatisticas($clinica_id) {
        $stats = [];

        // Total de dentistas
        $this->db->where('clinica_id', $clinica_id);
        $stats['total_dentistas'] = $this->db->count_all_results('dentista_clinica');

        // Total de pacientes
        $this->db->where('clinica_id', $clinica_id);
        $stats['total_pacientes'] = $this->db->count_all_results('pacientes');

        // Total de pedidos
        $this->db->where('clinica_id', $clinica_id);
        $stats['total_pedidos'] = $this->db->count_all_results('pedidos');

        // Pedidos em andamento
        $this->db->where('clinica_id', $clinica_id);
        $this->db->where_in('status', ['enviado', 'em_analise', 'em_producao']);
        $stats['pedidos_andamento'] = $this->db->count_all_results('pedidos');

        // Pedidos concluídos
        $this->db->where('clinica_id', $clinica_id);
        $this->db->where('status', 'concluido');
        $stats['pedidos_concluidos'] = $this->db->count_all_results('pedidos');

        return $stats;
    }

    /**
     * Atualizar status de validação
     */
    public function atualizar_validacao($id, $status, $observacoes = null) {
        $data = [
            'status_validacao' => $status,
            'observacoes' => $observacoes,
            'atualizado_em' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    /**
     * Validar CNPJ
     */
    public function validar_cnpj($cnpj) {
        // Remove caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        // Verifica se tem 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        // Validação do primeiro dígito verificador
        $soma = 0;
        $multiplicador = 5;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[12] != $digito1) {
            return false;
        }

        // Validação do segundo dígito verificador
        $soma = 0;
        $multiplicador = 6;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cnpj[13] != $digito2) {
            return false;
        }

        return true;
    }

    /**
     * Formatar CNPJ
     */
    public function formatar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $cnpj);
    }
}
