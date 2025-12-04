<?php
/**
 * Model: Paciente_model
 *
 * Gerencia operações CRUD de pacientes
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Paciente_model extends CI_Model {

    private $table = 'pacientes';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca paciente por ID
     */
    public function get($id) {
        $this->db->select('p.*,
            c.nome as clinica_nome,
            d.nome as dentista_nome,
            u.nome as criado_por_nome'
        );
        $this->db->from($this->table . ' p');
        $this->db->join('clinicas c', 'c.id = p.clinica_id', 'left');
        $this->db->join('dentistas d', 'd.id = p.dentista_id', 'left');
        $this->db->join('usuarios u', 'u.id = p.criado_por', 'left');
        $this->db->where('p.id', $id);

        return $this->db->get()->row();
    }

    /**
     * Lista todos os pacientes com filtros
     */
    public function get_all($filtros = []) {
        $this->db->select('p.*,
            c.nome as clinica_nome,
            d.nome as dentista_nome,
            (SELECT COUNT(*) FROM pedidos pd WHERE pd.paciente_id = p.id) as total_pedidos,
            u.nome as criado_por_nome'
        );
        $this->db->from($this->table . ' p');
        $this->db->join('clinicas c', 'c.id = p.clinica_id', 'left');
        $this->db->join('dentistas d', 'd.id = p.dentista_id', 'left');
        $this->db->join('usuarios u', 'u.id = p.criado_por', 'left');

        // Filtro por nome
        if (!empty($filtros['nome'])) {
            $this->db->like('p.nome', $filtros['nome']);
        }

        // Filtro por CPF
        if (!empty($filtros['cpf'])) {
            $this->db->where('p.cpf', $filtros['cpf']);
        }

        // Filtro por clínica
        if (!empty($filtros['clinica_id'])) {
            $this->db->where('p.clinica_id', $filtros['clinica_id']);
        }

        // Filtro por dentista
        if (!empty($filtros['dentista_id'])) {
            $this->db->where('p.dentista_id', $filtros['dentista_id']);
        }

        // Filtro por gênero
        if (!empty($filtros['genero'])) {
            $this->db->where('p.genero', $filtros['genero']);
        }

        // Ordenação
        $order_by = !empty($filtros['order_by']) ? $filtros['order_by'] : 'p.nome';
        $order_dir = !empty($filtros['order_dir']) ? $filtros['order_dir'] : 'ASC';
        $this->db->order_by($order_by, $order_dir);

        // Paginação
        if (!empty($filtros['limit'])) {
            $offset = !empty($filtros['offset']) ? $filtros['offset'] : 0;
            $this->db->limit($filtros['limit'], $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Conta total de pacientes com filtros
     */
    public function count_all($filtros = []) {
        $this->db->from($this->table . ' p');

        if (!empty($filtros['nome'])) {
            $this->db->like('p.nome', $filtros['nome']);
        }

        if (!empty($filtros['cpf'])) {
            $this->db->where('p.cpf', $filtros['cpf']);
        }

        if (!empty($filtros['clinica_id'])) {
            $this->db->where('p.clinica_id', $filtros['clinica_id']);
        }

        if (!empty($filtros['dentista_id'])) {
            $this->db->where('p.dentista_id', $filtros['dentista_id']);
        }

        if (!empty($filtros['genero'])) {
            $this->db->where('p.genero', $filtros['genero']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Insere novo paciente
     */
    public function insert($data) {
        $data['criado_em'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Atualiza paciente
     */
    public function update($id, $data) {
        $data['atualizado_em'] = date('Y-m-d H:i:s');

        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    /**
     * Exclui paciente
     */
    public function delete($id) {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
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
     * Busca pedidos do paciente
     */
    public function get_pedidos($paciente_id, $limit = null) {
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->where('paciente_id', $paciente_id);
        $this->db->order_by('criado_em', 'DESC');

        if ($limit) {
            $this->db->limit($limit);
        }

        return $this->db->get()->result();
    }

    /**
     * Busca estatísticas do paciente
     */
    public function get_estatisticas($paciente_id) {
        $stats = [
            'total_pedidos' => 0,
            'pedidos_em_andamento' => 0,
            'pedidos_concluidos' => 0,
            'pedidos_cancelados' => 0
        ];

        // Total de pedidos
        $this->db->where('paciente_id', $paciente_id);
        $stats['total_pedidos'] = $this->db->count_all_results('pedidos');

        // Pedidos por status (quando a tabela pedidos existir)
        // $this->db->where('paciente_id', $paciente_id);
        // $this->db->where('status', 'em_andamento');
        // $stats['pedidos_em_andamento'] = $this->db->count_all_results('pedidos');

        return $stats;
    }

    /**
     * Verifica se pode excluir paciente
     */
    public function pode_excluir($id) {
        // Verifica se tem pedidos
        $this->db->where('paciente_id', $id);
        $total_pedidos = $this->db->count_all_results('pedidos');

        if ($total_pedidos > 0) {
            return [
                'pode' => false,
                'motivo' => 'Paciente possui ' . $total_pedidos . ' pedido(s) vinculado(s)'
            ];
        }

        return ['pode' => true];
    }

    /**
     * Calcula idade do paciente
     */
    public function calcular_idade($data_nascimento) {
        $nascimento = new DateTime($data_nascimento);
        $hoje = new DateTime();
        $idade = $hoje->diff($nascimento);

        return $idade->y;
    }

    /**
     * Busca dentistas da clínica
     */
    public function get_dentistas_por_clinica($clinica_id) {
        $this->db->select('d.id, d.nome, d.cro, d.especialidade, d.status');
        $this->db->from('dentistas d');
        $this->db->join('dentista_clinica dc', 'dc.dentista_id = d.id');
        $this->db->where('dc.clinica_id', $clinica_id);
        $this->db->where('d.status', 'ativo');
        $this->db->order_by('d.nome', 'ASC');

        return $this->db->get()->result();
    }
}
