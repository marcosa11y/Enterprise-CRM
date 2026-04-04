<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission_model extends CI_Model 
{
    /**
     * Get all permissions for a specific role ID
     * Returns format: ['leads' => ['create', 'read'], ...]
     */
    public function get_permissions_by_role($role_id)
    {
        $this->db->select('resource, action');
        $this->db->where('role_id', $role_id);
        $query = $this->db->get('permissions');

        $permissions = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $permissions[$row['resource']][] = $row['action'];
            }
        }

        return $permissions;
    }
}