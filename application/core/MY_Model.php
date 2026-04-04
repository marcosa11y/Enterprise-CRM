<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    protected $table_name;
    protected $primary_key;
    protected $soft_deletes = FALSE;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get($id = NULL)
    {
        if ($id) {
            return $this->db->get_where($this->table_name, array($this->primary_key => $id))->row_array();
        }
        return $this->db->get($this->table_name)->result_array();
    }

    public function insert($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table_name, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where($this->primary_key, $id);
        return $this->db->update($this->table_name, $data);
    }

    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        return $this->db->delete($this->table_name);
    }
}