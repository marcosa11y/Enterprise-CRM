<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller 
{
    public function latest()
    {
        $this->load->library('migration');
        
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration successful!";
        }
    }
    
    public function version($version)
    {
        $this->load->library('migration');
        
        if ($this->migration->version($version) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo "Migration to version {$version} successful!";
        }
    }
}