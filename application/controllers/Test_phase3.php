<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_phase3 extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT !== 'development') show_404();
        $this->load->database();
    }

    public function index()
    {
        $tests = array();
        
        $tests['companies_table'] = $this->db->table_exists('companies') ? '✅ Exists' : '❌ Missing';
        $tests['contacts_table'] = $this->db->table_exists('contacts') ? '✅ Exists' : '❌ Missing';
        
        $this->load->view('test/phase3_report', array('tests' => $tests));
    }
}