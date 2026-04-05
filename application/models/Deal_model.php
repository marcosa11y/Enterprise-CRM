<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deal_model extends CI_Model {

    protected $table = 'deals';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($user_id = NULL, $stage_id = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        if ($stage_id) {
            $this->db->where('stage_id', $stage_id);
        }
        $this->db->join('deal_stages', 'deal_stages.id = deals.stage_id', 'left');
        $this->db->select('deals.*, deal_stages.name as stage_name, deal_stages.color as stage_color');
        return $this->db->order_by('deals.created_at', 'DESC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('deals.id', $id)->where('deleted_at', NULL);
        $this->db->join('deal_stages', 'deal_stages.id = deals.stage_id', 'left');
        $this->db->select('deals.*, deal_stages.name as stage_name');
        return $this->db->get($this->table)->row_array();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function update_stage($id, $stage_id)
    {
        $data = array(
            'stage_id' => $stage_id,
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->where($this->primary_key, $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        $this->db->where($this->primary_key, $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function get_count($user_id = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_pipeline_value($user_id = NULL)
    {
        $this->db->select_sum('value', 'total');
        $this->db->where('deleted_at', NULL);
        $this->db->where('status', 'open');
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        $result = $this->db->get($this->table)->row();
        return $result->total ?: 0;
    }
}