<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Leads extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
            'email' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'phone' => array('type' => 'VARCHAR', 'constraint' => '20'),
            'company' => array('type' => 'VARCHAR', 'constraint' => '255'),
            'title' => array('type' => 'VARCHAR', 'constraint' => '255'),
            'description' => array('type' => 'TEXT'),
            'source' => array('type' => 'ENUM', 'constraint' => array('website', 'referral', 'social_media', 'advertising', 'cold_call', 'other'), 'default' => 'website'),
            'status' => array('type' => 'ENUM', 'constraint' => array('new', 'contacted', 'qualified', 'unqualified', 'converted'), 'default' => 'new'),
            'value' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
            'owner_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'converted_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'deleted_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('status');
        $this->dbforge->add_key('owner_id');
        $this->dbforge->add_key('source');
        $this->dbforge->create_table('leads', TRUE, array('ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4'));

        // Add foreign key
        $this->db->query("
            ALTER TABLE `leads`
            ADD CONSTRAINT `fk_leads_owner_id`
            FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ");

        log_message('info', 'Migration 004: Leads table created');
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `leads` DROP FOREIGN KEY `fk_leads_owner_id`");
        $this->dbforge->drop_table('leads');
        log_message('info', 'Migration 004: Leads table dropped');
    }
}