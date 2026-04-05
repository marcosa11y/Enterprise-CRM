<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Permission Library - Clean Version
 * Removed: Unnecessary helper dependencies, redundant checks
 */
class Permission {

    protected $CI;
    protected $permissions = array();
    protected $user_role_id = NULL;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('Permission_model');
        
        if ($this->CI->session->userdata('logged_in')) {
            $this->user_role_id = $this->CI->session->userdata('role_id');
            $this->_load_permissions();
        }
    }

    public function can($module, $action = 'view')
    {
        // Admin bypass - no database query needed
        if ($this->user_role_id === 1) {
            return TRUE;
        }

        // Load permissions once per request
        if (empty($this->permissions) && $this->user_role_id) {
            $this->_load_permissions();
        }

        // Deny if no permissions loaded
        if (empty($this->permissions)) {
            return FALSE;
        }

        // Check module exists
        if (!isset($this->permissions[$module])) {
            return FALSE;
        }

        // Map action to database field
        $field_map = array(
            'view'   => 'can_view',
            'create' => 'can_create',
            'edit'   => 'can_edit',
            'delete' => 'can_delete'
        );

        $field = isset($field_map[$action]) ? $field_map[$action] : 'can_view';
        
        return !empty($this->permissions[$module][$field]);
    }

    public function clear_cache()
    {
        $this->permissions = array();
    }

    protected function _load_permissions()
    {
        if (!$this->user_role_id || $this->user_role_id === 1) {
            return;
        }

        $permissions = $this->CI->Permission_model->get_by_role($this->user_role_id);

        foreach ($permissions as $perm) {
            $this->permissions[$perm->module] = array(
                'can_view'   => (bool) $perm->can_view,
                'can_create' => (bool) $perm->can_create,
                'can_edit'   => (bool) $perm->can_edit,
                'can_delete' => (bool) $perm->can_delete
            );
        }
    }
}