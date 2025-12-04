<?php
/**
 * Model: Dentista
 *
 * Gerencia operações relacionadas aos dentistas
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Dentista_model extends CI_Model {

    private $table = 'dentistas';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca dentista por ID
     */
    public function get($id) {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    /**
     * Lista todos os dentistas com filtros
     */
    public function get_all($filtros = []) {
        $this->db->select('d.*,
            (SELECT COUNT(*) FROM dentista_clinica dc WHERE dc.dentista_id = d.id) as total_clinicas,
            (SELECT COUNT(*) FROM pacientes p WHERE p.dentista_id = d.id) as total_pacientes,
            u.nome as criado_por_nome'
        );
        $this->db->from($this->table . ' d');
        $this->db->join('usuarios u', 'u.id = d.criado_por', 'left');

        // Filtro por nome
        if (!empty($filtros['nome'])) {
            $this->db->like('d.nome', $filtros['nome']);
        }

        // Filtro por CRO
        if (!empty($filtros['cro'])) {
            $this->db->like('d.cro', $filtros['cro']);
        }

        // Filtro por CPF
        if (!empty($filtros['cpf'])) {
            $this->db->where('d.cpf', $filtros['cpf']);
        }

        // Filtro por clínica
        if (!empty($filtros['clinica_id'])) {
            $this->db->join('dentista_clinica dc', 'dc.dentista_id = d.id', 'inner');
            $this->db->where('dc.clinica_id', $filtros['clinica_id']);
        }

        // Filtro por status
        if (isset($filtros['status']) && $filtros['status'] !== '') {
            $this->db->where('d.status', $filtros['status']);
        }

        // Ordenação
        $order_by = !empty($filtros['order_by']) ? $filtros['order_by'] : 'd.nome';
        $order_dir = !empty($filtros['order_dir']) ? $filtros['order_dir'] : 'ASC';
        $this->db->order_by($order_by, $order_dir);

        // Paginação
        if (!empty($filtros['limit'])) {
            $offset = !empty($filtros['offset']) ? $filtros['offset'] : 0;
            $this->db->limit($filtros['limit'], $offset);
        }

        $dentistas = $this->db->get()->result();

        return $dentistas;
    }

    /**
     * Conta total de dentistas com filtros
     */
    public function count_all($filtros = []) {
        $this->db->from($this->table . ' d');

        if (!empty($filtros['nome'])) {
            $this->db->like('d.nome', $filtros['nome']);
        }

        if (!empty($filtros['cro'])) {
            $this->db->like('d.cro', $filtros['cro']);
        }

        if (!empty($filtros['cpf'])) {
            $this->db->where('d.cpf', $filtros['cpf']);
        }

        if (!empty($filtros['clinica_id'])) {
            $this->db->join('dentista_clinica dc', 'dc.dentista_id = d.id', 'inner');
            $this->db->where('dc.clinica_id', $filtros['clinica_id']);
        }

        if (isset($filtros['status']) && $filtros['status'] !== '') {
            $this->db->where('d.status', $filtros['status']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Insere novo dentista
     */
    public function insert($data) {
        $data['criado_em'] = date('Y-m-d H:i:s');
        $data['atualizado_em'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Atualiza dentista
     */
    public function update($id, $data) {
        $data['atualizado_em'] = date('Y-m-d H:i:s');

        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    /**
     * Exclui dentista
     */
    public function delete($id) {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    /**
     * Verifica se CRO já existe
     */
    public function cro_existe($cro, $id_excluir = null) {
        $this->db->where('cro', $cro);

        if ($id_excluir) {
            $this->db->where('id !=', $id_excluir);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Verifica se CPF já existe
     */
    public function cpf_existe($cpf, $id_excluir = null) {
        $this->db->where('cpf', $cpf);

        if ($id_excluir) {
            $this->db->where('id !=', $id_excluir);
        }

        return $this->db->count_all_results($this->table) > 0;
    }

    /**
     * Busca clínicas vinculadas ao dentista
     */
    public function get_clinicas($dentista_id) {
        return $this->db
            ->select('c.*, dc.criado_em as vinculado_em')
            ->from('clinicas c')
            ->join('dentista_clinica dc', 'dc.clinica_id = c.id')
            ->where('dc.dentista_id', $dentista_id)
            ->order_by('c.nome', 'ASC')
            ->get()
            ->result();
    }

    /**
     * Vincula dentista a uma clínica
     */
    public function vincular_clinica($dentista_id, $clinica_id) {
        // Verifica se já existe o vínculo
        $existe = $this->db
            ->where('dentista_id', $dentista_id)
            ->where('clinica_id', $clinica_id)
            ->count_all_results('dentista_clinica');

        if ($existe > 0) {
            return true; // Já está vinculado
        }

        $data = [
            'dentista_id' => $dentista_id,
            'clinica_id' => $clinica_id,
            'criado_em' => date('Y-m-d H:i:s')
        ];

        return $this->db->insert('dentista_clinica', $data);
    }

    /**
     * Remove vínculo de dentista com clínica
     */
    public function desvincular_clinica($dentista_id, $clinica_id) {
        return $this->db
            ->where('dentista_id', $dentista_id)
            ->where('clinica_id', $clinica_id)
            ->delete('dentista_clinica');
    }

    /**
     * Remove todos os vínculos do dentista
     */
    public function remover_todos_vinculos($dentista_id) {
        return $this->db
            ->where('dentista_id', $dentista_id)
            ->delete('dentista_clinica');
    }

    /**
     * Sincroniza clínicas vinculadas
     */
    public function sincronizar_clinicas($dentista_id, $clinicas_ids) {
        // Remove vínculos atuais
        $this->remover_todos_vinculos($dentista_id);

        // Adiciona novos vínculos
        if (!empty($clinicas_ids)) {
            foreach ($clinicas_ids as $clinica_id) {
                $this->vincular_clinica($dentista_id, $clinica_id);
            }
        }

        return true;
    }

    /**
     * Busca pacientes do dentista
     */
    public function get_pacientes($dentista_id, $limit = null) {
        $this->db->select('p.*, c.nome as clinica_nome');
        $this->db->from('pacientes p');
        $this->db->join('clinicas c', 'c.id = p.clinica_id', 'left');
        $this->db->where('p.dentista_id', $dentista_id);
        $this->db->order_by('p.nome', 'ASC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result();
    }

    /**
     * Busca estatísticas do dentista
     */
    public function get_estatisticas($dentista_id) {
        $stats = [];

        // Total de clínicas vinculadas
        $stats['total_clinicas'] = $this->db
            ->where('dentista_id', $dentista_id)
            ->count_all_results('dentista_clinica');

        // Total de pacientes
        $stats['total_pacientes'] = $this->db
            ->where('dentista_id', $dentista_id)
            ->count_all_results('pacientes');

        // Total de pedidos
        $stats['total_pedidos'] = $this->db
            ->where('dentista_id', $dentista_id)
            ->count_all_results('pedidos');

        // Pedidos por status
        $pedidos_status = $this->db
            ->select('status, COUNT(*) as total')
            ->where('dentista_id', $dentista_id)
            ->group_by('status')
            ->get('pedidos')
            ->result();

        $stats['pedidos_por_status'] = [];
        foreach ($pedidos_status as $ps) {
            $stats['pedidos_por_status'][$ps->status] = $ps->total;
        }

        return $stats;
    }

    /**
     * Verifica se dentista pode ser excluído
     */
    public function pode_excluir($id) {
        // Verifica se tem pacientes vinculados
        $tem_pacientes = $this->db
            ->where('dentista_id', $id)
            ->count_all_results('pacientes') > 0;

        if ($tem_pacientes) {
            return [
                'pode' => false,
                'motivo' => 'Dentista possui pacientes vinculados'
            ];
        }

        // Verifica se tem pedidos
        $tem_pedidos = $this->db
            ->where('dentista_id', $id)
            ->count_all_results('pedidos') > 0;

        if ($tem_pedidos) {
            return [
                'pode' => false,
                'motivo' => 'Dentista possui pedidos vinculados'
            ];
        }

        return ['pode' => true];
    }
}
