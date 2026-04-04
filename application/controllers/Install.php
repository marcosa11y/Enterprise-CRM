<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // Force load migration config
        $this->config->load('migration');
        
        // Debug: Show config values
        echo "<pre>";
        echo "Migration Enabled: " . ($this->config->item('migration_enabled') ? 'TRUE' : 'FALSE') . "\n";
        echo "Migration Path: " . $this->config->item('migration_path') . "\n";
        echo "Migration Table: " . $this->config->item('migration_table') . "\n";
        echo "Migration Format: " . $this->config->item('migration_filename_format') . "\n";
        echo "</pre>";
        
        // Check if migrations folder exists
        if (!is_dir(APPPATH . 'migrations/')) {
            show_error('Migrations folder does not exist: ' . APPPATH . 'migrations/');
        }
        
        // List migration files
        echo "<h3>Migration Files Found:</h3>";
        $files = scandir(APPPATH . 'migrations/');
        echo "<pre>";
        print_r($files);
        echo "</pre>";
        
        $this->load->library('migration');
    }

    public function index()
    {
        // Run migration to the latest version
        if ($this->migration->current() == FALSE)
        {
            // Show specific error if migration fails
            show_error($this->migration->error_string());
        }
        else
        {
            echo "<h1>✅ Installation Successful</h1>";
            echo "<p>Tables created in database.</p>";
            echo "<p><strong>Login:</strong> admin@crm.com / Admin@123</p>";
            echo "<p style='color:red;'><strong>IMPORTANT:</strong> Delete application/controllers/Install.php now!</p>";
        }
    }
}