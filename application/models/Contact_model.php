<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends CI_Model {

    protected $table = 'contacts';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($company_id = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($company_id) {
            $this->db->where('company_id', $company_id);
        }
        $this->db->join('companies', 'companies.id = contacts.company_id', 'left');
        $this->db->select('contacts.*, companies.name as company_name');
        return $this->db->order_by('last_name', 'ASC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('contacts.id', $id)->where('contacts.deleted_at', NULL);
        $this->db->join('companies', 'companies.id = contacts.company_id', 'left');
        $this->db->select('contacts.*, companies.name as company_name');
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

    public function delete($id)
    {
        $data = array('deleted_at' => date('Y-m-d H:i:s'));
        $this->db->where($this->primary_key, $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function get_by_company($company_id)
    {
        return $this->db->where('company_id', $company_id)->where('deleted_at', NULL)->get($this->table)->result_array();
    }
}