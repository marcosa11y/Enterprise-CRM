<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller
 * 
 * All controllers extend this class
 */
class MY_Controller extends CI_Controller {

    /**
     * @var array Data passed to views
     */
    protected $data = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load configuration
        $this->config->load('assets');
        
        // Load helpers
        $this->load->helper(['url', 'form', 'asset', 'auth', 'text']);
        
        // Load libraries
        $this->load->library(['session', 'form_validation']);
        $this->load->library('permission');
        
        // Load database
        $this->load->database();
        
        // Global data for views
        $this->data['site_name'] = 'Enterprise CRM';
        $this->data['current_page'] = $this->router->class;
        $this->data['current_user'] = current_user();
        
        // Security headers
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');
        $this->output->set_header('X-Frame-Options: SAMEORIGIN');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');
    }
}

/**
 * Authenticated Controller
 * 
 * Requires user to be logged in
 */
class Auth_Controller extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check authentication
        if (!is_logged_in()) {
            $this->session->set_flashdata('error', 'Please login to continue.');
            redirect('auth/login', 'refresh');
        }
        
        // Update last activity
        $this->session->set_userdata('last_activity', time());
    }
}

/**
 * Admin Controller
 * 
 * Requires admin role
 */
class Admin_Controller extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        
        // Check admin role
        if (!is_admin()) {
            show_error('Access Denied: Administrator privileges required.', 403);
        }
    }
}