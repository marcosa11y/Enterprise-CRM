<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends MY_Controller {

    public function __construct()
    {
        parent::__construct();

        // Load essentials manually (in case autoload isn't set)
        $this->load->database();
        $this->load->library('session');

        // Only allow in development
        if (ENVIRONMENT !== 'development') {
            show_404();
        }
    }

    public function visual_check()
    {
        // Prepare data for view
        $data = array();

        // Check DB connection properly for CI3
        $data['db_connected'] = ($this->db->conn_id !== FALSE && $this->db->conn_id !== NULL);
        
        // List tables
        $data['tables'] = $this->db->list_tables();
        
        // Check session safely
        $data['session_started'] = ($this->session->userdata('session_id') !== NULL);
        $data['logged_in'] = $this->session->userdata('logged_in');
        $data['user_data'] = $this->session->userdata('user_data');

        $this->load->view('debug/visual_check', $data);
    }
}