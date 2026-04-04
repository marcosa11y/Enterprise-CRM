<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permission 
{
    protected $CI;
    protected $user_permissions = [];
    protected $is_loaded = FALSE;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('permission_model');
    }

    /**
     * Load permissions for the current user once per request
     */
    protected function load_user_permissions()
    {
        if ($this->is_loaded) return;

        $user = current_user();
        if ($user && isset($user['role_id'])) {
            $this->user_permissions = $this->CI->permission_model->get_permissions_by_role($user['role_id']);
        }
        
        $this->is_loaded = TRUE;
    }

    /**
     * Check if current user can perform an action on a resource
     * Usage: $this->permission->can('leads', 'create')
     */
    public function can($resource, $action)
    {
        $this->load_user_permissions();

        // Admin bypass (Safety net)
        if (is_admin()) return TRUE;

        // Check permission matrix
        if (isset($this->user_permissions[$resource]) && 
            in_array($action, $this->user_permissions[$resource])) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Enforce permission - Throws 403 if not allowed
     */
    public function require($resource, $action)
    {
        if (!$this->can($resource, $action)) {
            show_error('You do not have permission to access this resource.', 403);
            // Or redirect: redirect('dashboard');
        }
    }
}