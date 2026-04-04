<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Test Controller: Permissions System
 * 
 * Development-only controller to verify Phase 2 functionality
 * DELETE THIS FILE AFTER TESTING
 * 
 * @package     Enterprise CRM
 * @subpackage  Controllers/Test
 */
class Test_permissions extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Only allow in development environment
        if (ENVIRONMENT !== 'development') {
            show_404();
        }
        
        $this->load->library('permission');
        $this->load->model('Permission_model');
    }

    /**
     * Run all permission tests
     */
    public function index()
    {
        $results = array(
            'database' => $this->_test_database(),
            'library' => $this->_test_library(),
            'admin_bypass' => $this->_test_admin_bypass(),
            'permission_check' => $this->_test_permission_check()
        );

        $this->load->view('test/permissions_report', array('results' => $results));
    }

    /**
     * Test database tables exist
     */
    private function _test_database()
    {
        $tests = array();
        
        $tests['permissions_table'] = $this->db->table_exists('permissions') 
            ? '✅ Exists' : '❌ Missing';
        
        if ($this->db->table_exists('permissions')) {
            $count = $this->db->count_all('permissions');
            $tests['permissions_count'] = "✅ {$count} records";
            
            // Check admin seed data
            $admin_perms = $this->db->where('role_id', 1)->count_all_results('permissions');
            $tests['admin_seed'] = $admin_perms > 0 
                ? "✅ {$admin_perms} modules seeded" 
                : '❌ No seed data';
        }
        
        return $tests;
    }

    /**
     * Test Permission library methods
     */
    private function _test_library()
    {
        $tests = array();
        
        // Test can() method exists
        $tests['method_exists'] = method_exists($this->permission, 'can')
            ? '✅ can() method exists' : '❌ Method missing';
        
        // Test has_any() method
        $tests['has_any'] = method_exists($this->permission, 'has_any')
            ? '✅ has_any() method exists' : '❌ Method missing';
        
        // Test all() method
        $tests['all_method'] = method_exists($this->permission, 'all')
            ? '✅ all() method exists' : '❌ Method missing';
        
        return $tests;
    }

    /**
     * Test admin role bypass
     */
    private function _test_admin_bypass()
    {
        $tests = array();
        
        // Simulate admin session
        $this->session->set_userdata(array(
            'logged_in' => TRUE,
            'user_id' => 1,
            'role_id' => 1 // Administrator
        ));
        
        // Admin should have all permissions without database check
        $tests['admin_view'] = $this->permission->can('users', 'view') ? '✅ Allowed' : '❌ Denied';
        $tests['admin_create'] = $this->permission->can('deals', 'create') ? '✅ Allowed' : '❌ Denied';
        $tests['admin_delete'] = $this->permission->can('settings', 'delete') ? '✅ Allowed' : '❌ Denied';
        
        return $tests;
    }

    /**
     * Test permission checking logic
     */
    private function _test_permission_check()
    {
        $tests = array();
        
        // Test with non-admin role (simulate role_id = 2)
        $this->session->set_userdata('role_id', 2);
        $this->permission->clear_cache(); // Force reload from DB
        
        // These should fail if role 2 has no permissions
        $tests['restricted_view'] = !$this->permission->can('users', 'view') 
            ? '✅ Correctly denied' : '⚠️ Unexpectedly allowed';
        
        $tests['restricted_create'] = !$this->permission->can('companies', 'create')
            ? '✅ Correctly denied' : '⚠️ Unexpectedly allowed';
        
        // Restore admin session for other tests
        $this->session->set_userdata('role_id', 1);
        $this->permission->clear_cache();
        
        return $tests;
    }
}