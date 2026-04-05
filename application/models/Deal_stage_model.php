<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deal_stage_model extends CI_Model {

    protected $table = 'deal_stages';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        return $this->db->order_by('order', 'ASC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function get_with_deal_count($user_id = NULL)
    {
        $this->db->select('deal_stages.*, COUNT(deals.id) as deal_count');
        $this->db->select_sum('deals.value', 'total_value');
        $this->db->from('deal_stages');
        $this->db->join('deals', 'deals.stage_id = deal_stages.id AND deals.deleted_at IS NULL', 'left');
        if ($user_id) {
            $this->db->where('deals.owner_id', $user_id);
        }
        $this->db->group_by('deal_stages.id');
        $this->db->order_by('deal_stages.order', 'ASC');
        return $this->db->get()->result_array();
    }
}