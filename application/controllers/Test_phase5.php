<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_phase5 extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (ENVIRONMENT !== 'development') show_404();
        $this->load->database();
    }

    public function index() {
        $tests = array();
        $tests['deal_stages_table'] = $this->db->table_exists('deal_stages') ? '✅ Exists' : '❌ Missing';
        $tests['deals_table'] = $this->db->table_exists('deals') ? '✅ Exists' : '❌ Missing';
        
        if ($this->db->table_exists('deal_stages')) {
            $count = $this->db->count_all('deal_stages');
            $tests['stages_seeded'] = $count > 0 ? "✅ {$count} stages seeded" : '❌ No stages';
        }
        
        $this->load->view('test/phase5_report', array('tests' => $tests));
    }
}