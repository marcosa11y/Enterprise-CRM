<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_permissions extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (ENVIRONMENT !== 'development') {
            show_404();
        }
        
        $this->load->database();
        $this->load->library('session');
        $this->load->library('permission');
        $this->load->model('Permission_model');
    }

    public function index()
    {
        $results = array(
            'database' => $this->_test_database(),
            'admin_permissions' => $this->_test_admin()
        );

        $this->load->view('test/permissions_report', array('results' => $results));
    }

    private function _test_database()
    {
        $tests = array();
        
        if ($this->db->table_exists('permissions')) {
            $tests['table'] = '✅ Permissions table exists';
            
            $count = $this->db->count_all('permissions');
            $tests['records'] = "✅ {$count} permission records";
            
            $admin_count = $this->db->where('role_id', 1)->count_all_results('permissions');
            $tests['admin_seed'] = "✅ Admin has {$admin_count} module permissions";
        } else {
            $tests['table'] = '❌ Permissions table missing';
            $tests['records'] = '❌ Run migration first';
        }
        
        return $tests;
    }

    private function _test_admin()
    {
        $tests = array();
        
        $this->session->set_userdata(array(
            'logged_in' => TRUE,
            'user_id' => 1,
            'role_id' => 1
        ));
        
        $this->permission = new Permission();
        
        $tests['view_users'] = $this->permission->can('users', 'view') 
            ? '✅ Admin can view users' : '❌ Failed';
        
        $tests['create_deals'] = $this->permission->can('deals', 'create') 
            ? '✅ Admin can create deals' : '❌ Failed';
        
        $tests['delete_settings'] = $this->permission->can('settings', 'delete') 
            ? '✅ Admin can delete settings' : '❌ Failed';
        
        return $tests;
    }
}