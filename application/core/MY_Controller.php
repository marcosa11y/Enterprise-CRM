<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public $data = array();

    public function __construct()
    {
        parent::__construct();
        
        // Load Global Libraries
        $this->load->library('session');
        $this->load->library('template'); // Custom library (created below)
        $this->load->helper('url');
        $this->load->helper('auth'); // Custom helper (created below)
        
        // Global Data for Views
        $this->data['base_url'] = base_url();
        $this->data['site_name'] = 'Enterprise CRM';
        $this->data['current_page'] = $this->router->class;
        
        // Security Header
        header("X-Frame-Options: SAMEORIGIN"); // Prevent Clickjacking
    }

    // Helper to render views with layout
    protected function render($view, $data = array(), $return = FALSE)
    {
        $this->data = array_merge($this->data, $data);
        return $this->template->load('layouts/main', $view, $this->data, $return);
    }
}

// Protected Controller (Requires Login)
class Auth_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        
        if (!$this->session->userdata('logged_in')) {
            // Check if AJAX request
            if ($this->input->is_ajax_request()) {
                show_error('Session expired', 401);
            }
            redirect('auth/login');
        }

        // Load User Data for every protected request
        $this->data['user'] = $this->session->userdata('user_data');
        
        // Update Last Activity
        $this->db->where('id', $this->data['user']['id'])
                 ->update('users', array('last_login' => date('Y-m-d H:i:s')));
    }
}

// Admin Only Controller
class Admin_Controller extends Auth_Controller {
    public function __construct() {
        parent::__construct();
        if ($this->data['user']['role_id'] != ROLE_ADMIN) {
            show_error('Access Denied: Administrators Only', 403);
        }
    }
}