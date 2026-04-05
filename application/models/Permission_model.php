<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permission Model - Clean Version
 * Removed: Unused methods, redundant queries
 */
class Permission_model extends CI_Model {

    protected $table = 'permissions';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_role($role_id)
    {
        return $this->db->where('role_id', (int) $role_id)
                        ->get($this->table)
                        ->result();
    }

    public function update_permissions($role_id, $permissions)
    {
        $this->db->trans_start();
        
        foreach ($permissions as $module => $data) {
            $this->db->where('role_id', $role_id)
                     ->where('module', $module)
                     ->update($this->table, $data);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}