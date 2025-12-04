<?php
/**
 * Model: Pedido_model
 *
 * Gerencia operações CRUD de pedidos
 *
 * @author Rafael Dias - doisr.com.br
 * @date 03/12/2025
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Pedido_model extends CI_Model {

    private $table = 'pedidos';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca pedido por ID
     */
    public function get($id) {
        $this->db->select('p.*,
            pac.nome as paciente_nome,
            pac.cpf as paciente_cpf,
            d.nome as dentista_nome,
            c.nome as clinica_nome,
            u.nome as criado_por_nome'
        );
        $this->db->from($this->table . ' p');
        $this->db->join('pacientes pac', 'pac.id = p.paciente_id', 'left');
        $this->db->join('dentistas d', 'd.id = p.dentista_id', 'left');
        $this->db->join('clinicas c', 'c.id = p.clinica_id', 'left');
        $this->db->join('usuarios u', 'u.id = p.criado_por', 'left');
        $this->db->where('p.id', $id);

        return $this->db->get()->row();
    }

    /**
     * Lista todos os pedidos com filtros
     */
    public function get_all($filtros = []) {
        $this->db->select('p.*,
            pac.nome as paciente_nome,
            d.nome as dentista_nome,
            c.nome as clinica_nome,
            u.nome as criado_por_nome'
        );
        $this->db->from($this->table . ' p');
        $this->db->join('pacientes pac', 'pac.id = p.paciente_id', 'left');
        $this->db->join('dentistas d', 'd.id = p.dentista_id', 'left');
        $this->db->join('clinicas c', 'c.id = p.clinica_id', 'left');
        $this->db->join('usuarios u', 'u.id = p.criado_por', 'left');

        // Filtro por número do pedido
        if (!empty($filtros['numero_pedido'])) {
            $this->db->like('p.numero_pedido', $filtros['numero_pedido']);
        }

        // Filtro por paciente
        if (!empty($filtros['paciente_id'])) {
            $this->db->where('p.paciente_id', $filtros['paciente_id']);
        }

        // Filtro por clínica
        if (!empty($filtros['clinica_id'])) {
            $this->db->where('p.clinica_id', $filtros['clinica_id']);
        }

        // Filtro por dentista
        if (!empty($filtros['dentista_id'])) {
            $this->db->where('p.dentista_id', $filtros['dentista_id']);
        }

        // Filtro por status
        if (!empty($filtros['status'])) {
            $this->db->where('p.status', $filtros['status']);
        }

        // Filtro por tipo
        if (!empty($filtros['tipo_pedido'])) {
            $this->db->where('p.tipo_pedido', $filtros['tipo_pedido']);
        }

        // Ordenação
        $order_by = !empty($filtros['order_by']) ? $filtros['order_by'] : 'p.criado_em';
        $order_dir = !empty($filtros['order_dir']) ? $filtros['order_dir'] : 'DESC';
        $this->db->order_by($order_by, $order_dir);

        // Paginação
        if (!empty($filtros['limit'])) {
            $offset = !empty($filtros['offset']) ? $filtros['offset'] : 0;
            $this->db->limit($filtros['limit'], $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Conta total de pedidos com filtros
     */
    public function count_all($filtros = []) {
        $this->db->from($this->table . ' p');

        if (!empty($filtros['numero_pedido'])) {
            $this->db->like('p.numero_pedido', $filtros['numero_pedido']);
        }

        if (!empty($filtros['paciente_id'])) {
            $this->db->where('p.paciente_id', $filtros['paciente_id']);
        }

        if (!empty($filtros['clinica_id'])) {
            $this->db->where('p.clinica_id', $filtros['clinica_id']);
        }

        if (!empty($filtros['dentista_id'])) {
            $this->db->where('p.dentista_id', $filtros['dentista_id']);
        }

        if (!empty($filtros['status'])) {
            $this->db->where('p.status', $filtros['status']);
        }

        if (!empty($filtros['tipo_pedido'])) {
            $this->db->where('p.tipo_pedido', $filtros['tipo_pedido']);
        }

        return $this->db->count_all_results();
    }

    /**
     * Insere novo pedido
     */
    public function insert($data) {
        // Gera número do pedido
        if (empty($data['numero_pedido'])) {
            $data['numero_pedido'] = $this->gerar_numero_pedido();
        }

        $data['criado_em'] = date('Y-m-d H:i:s');

        if ($this->db->insert($this->table, $data)) {
            return $this->db->insert_id();
        }

        return false;
    }

    /**
     * Atualiza pedido
     */
    public function update($id, $data) {
        $data['atualizado_em'] = date('Y-m-d H:i:s');

        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    /**
     * Exclui pedido
     */
    public function delete($id) {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    /**
     * Gera número único do pedido
     */
    public function gerar_numero_pedido() {
        $ano = date('Y');
        $mes = date('m');

        // Busca último número do mês
        $this->db->select('numero_pedido');
        $this->db->from($this->table);
        $this->db->like('numero_pedido', $ano . $mes, 'after');
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $ultimo = $this->db->get()->row();

        if ($ultimo) {
            // Extrai o número sequencial
            $sequencial = (int) substr($ultimo->numero_pedido, -4);
            $novo_sequencial = $sequencial + 1;
        } else {
            $novo_sequencial = 1;
        }

        // Formato: YYYYMM0001
        return $ano . $mes . str_pad($novo_sequencial, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Busca arquivos do pedido
     */
    public function get_arquivos($pedido_id) {
        $this->db->select('pa.*, u.nome as enviado_por_nome');
        $this->db->from('pedido_arquivos pa');
        $this->db->join('usuarios u', 'u.id = pa.enviado_por', 'left');
        $this->db->where('pa.pedido_id', $pedido_id);
        $this->db->order_by('pa.enviado_em', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Adiciona arquivo ao pedido
     */
    public function adicionar_arquivo($data) {
        $data['enviado_em'] = date('Y-m-d H:i:s');

        return $this->db->insert('pedido_arquivos', $data);
    }

    /**
     * Remove arquivo do pedido
     */
    public function remover_arquivo($id) {
        return $this->db
            ->where('id', $id)
            ->delete('pedido_arquivos');
    }

    /**
     * Busca timeline do pedido
     */
    public function get_timeline($pedido_id) {
        $this->db->select('pt.*, u.nome as usuario_nome');
        $this->db->from('pedido_timeline pt');
        $this->db->join('usuarios u', 'u.id = pt.usuario_id', 'left');
        $this->db->where('pt.pedido_id', $pedido_id);
        $this->db->order_by('pt.criado_em', 'DESC');

        return $this->db->get()->result();
    }

    /**
     * Adiciona evento na timeline
     */
    public function adicionar_timeline($data) {
        $data['criado_em'] = date('Y-m-d H:i:s');

        return $this->db->insert('pedido_timeline', $data);
    }

    /**
     * Atualiza status do pedido e registra na timeline
     */
    public function atualizar_status($pedido_id, $novo_status, $usuario_id, $descricao = null) {
        // Atualiza status
        $this->update($pedido_id, ['status' => $novo_status]);

        // Registra na timeline
        $titulos = [
            'rascunho' => 'Pedido em rascunho',
            'enviado' => 'Pedido enviado',
            'em_analise' => 'Pedido em análise',
            'em_producao' => 'Pedido em produção',
            'concluido' => 'Pedido concluído',
            'cancelado' => 'Pedido cancelado'
        ];

        $this->adicionar_timeline([
            'pedido_id' => $pedido_id,
            'tipo_evento' => 'alteracao',
            'titulo' => $titulos[$novo_status] ?? 'Status alterado',
            'descricao' => $descricao,
            'usuario_id' => $usuario_id,
            'autor_tipo' => 'usuario'
        ]);

        return true;
    }

    /**
     * Estatísticas de pedidos
     */
    public function get_estatisticas($filtros = []) {
        $stats = [
            'total' => 0,
            'rascunho' => 0,
            'enviado' => 0,
            'em_analise' => 0,
            'em_producao' => 0,
            'concluido' => 0,
            'cancelado' => 0
        ];

        // Total
        $stats['total'] = $this->count_all($filtros);

        // Por status
        $status_list = ['rascunho', 'enviado', 'em_analise', 'em_producao', 'concluido', 'cancelado'];
        foreach ($status_list as $status) {
            $filtros['status'] = $status;
            $stats[$status] = $this->count_all($filtros);
        }

        return $stats;
    }

    /**
     * Verifica se pode excluir pedido
     */
    public function pode_excluir($id) {
        $pedido = $this->get($id);

        if (!$pedido) {
            return [
                'pode' => false,
                'motivo' => 'Pedido não encontrado'
            ];
        }

        // Não pode excluir se já foi enviado
        if ($pedido->status != 'rascunho') {
            return [
                'pode' => false,
                'motivo' => 'Apenas pedidos em rascunho podem ser excluídos'
            ];
        }

        return ['pode' => true];
    }

    /**
     * Tipos de pedido com labels
     */
    public function get_tipos_pedido() {
        return [
            'complete' => 'Complete',
            'self_guard' => 'Self Guard',
            'you_plan' => 'You Plan',
            'print_3d' => 'Print 3D',
            'self_plan' => 'Self Plan'
        ];
    }

    /**
     * Status com labels e cores
     */
    public function get_status_list() {
        return [
            'rascunho' => ['label' => 'Rascunho', 'color' => 'secondary'],
            'enviado' => ['label' => 'Enviado', 'color' => 'info'],
            'em_analise' => ['label' => 'Em Análise', 'color' => 'warning'],
            'em_producao' => ['label' => 'Em Produção', 'color' => 'primary'],
            'concluido' => ['label' => 'Concluído', 'color' => 'success'],
            'cancelado' => ['label' => 'Cancelado', 'color' => 'danger']
        ];
    }
}
