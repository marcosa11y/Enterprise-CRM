<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_model extends CI_Model {

    protected $table = 'leads';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($user_id = NULL, $status = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->order_by('created_at', 'DESC')->get($this->table)->result_array();
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

    public function get_count($user_id = NULL, $status = NULL)
    {
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        if ($status) {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }

    public function get_stats($user_id = NULL)
    {
        $this->db->select('status, COUNT(*) as count');
        $this->db->where('deleted_at', NULL);
        if ($user_id) {
            $this->db->where('owner_id', $user_id);
        }
        $this->db->group_by('status');
        return $this->db->get($this->table)->result_array();
    }

    public function convert_to_contact($lead_id)
    {
        $lead = $this->get_by_id($lead_id);
        if (!$lead) {
            return FALSE;
        }

        $this->db->trans_start();

        // Create contact
        $contact_data = array(
            'company_id' => NULL,
            'first_name' => $lead['name'],
            'last_name' => '',
            'email' => $lead['email'],
            'phone' => $lead['phone'],
            'position' => $lead['title'],
            'owner_id' => $lead['owner_id'],
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
        $this->db->insert('contacts', $contact_data);
        $contact_id = $this->db->insert_id();

        // Update lead status
        $this->update($lead_id, array(
            'status' => 'converted',
            'converted_at' => date('Y-m-d H:i:s')
        ));

        $this->db->trans_complete();
        return $this->db->trans_status() ? $contact_id : FALSE;
    }
}