<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller - Clean Version
 * Removed: Duplicate loading, unused properties
 */
class MY_Controller extends CI_Controller {

    protected $data = array();

    public function __construct()
    {
        parent::__construct();
        
        // Load once, use everywhere
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        
        // Global view data
        $this->data['site_name'] = 'Enterprise CRM';
        $this->data['current_page'] = $this->router->class;
        
        // Security headers
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('X-Content-Type-Options: nosniff');
    }
}

class Auth_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        
        // Load permission library only for authenticated users
        $this->load->library('permission');
        $this->data['user'] = array(
            'id'       => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'role_id'  => $this->session->userdata('role_id')
        );
    }
}

class Admin_Controller extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if ($this->data['user']['role_id'] !== 1) {
            show_error('Access Denied: Administrator privileges required.', 403);
        }
    }
}