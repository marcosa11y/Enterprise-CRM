<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_phase4 extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (ENVIRONMENT !== 'development') show_404();
        $this->load->database();
    }

    public function index() {
        $tests = array();
        $tests['leads_table'] = $this->db->table_exists('leads') ? '✅ Exists' : '❌ Missing';
        $this->load->view('test/phase4_report', array('tests' => $tests));
    }
}