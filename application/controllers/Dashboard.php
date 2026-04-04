<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller 
{
    public function __construct()
    {
        parent::__construct();
        // Ensure admin-only access (handled by Admin_Controller, but explicit is safe)
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $this->data['page_title'] = 'Dashboard';
        $this->data['current_user'] = current_user();
        
        // Load view directly or via Template library
        $this->load->view('dashboard/index', $this->data);
    }
}