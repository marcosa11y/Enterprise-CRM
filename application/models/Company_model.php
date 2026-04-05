<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_model extends CI_Model {

    protected $table = 'companies';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($user_id = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        return $this->db->order_by('name', 'ASC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->where('deleted_at', NULL)->get($this->table)->row_array();
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
}