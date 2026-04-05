<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Deals_stages extends CI_Migration {

    public function up()
    {
        // Deal Stages Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'order' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
            'color' => array('type' => 'VARCHAR', 'constraint' => '20', 'default' => 'primary'),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('deal_stages', TRUE, array('ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4'));

        // Deals Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'stage_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'company_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'contact_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'title' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
            'description' => array('type' => 'TEXT'),
            'value' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
            'probability' => array('type' => 'INT', 'constraint' => 3, 'default' => 50),
            'expected_close_date' => array('type' => 'DATE', 'null' => TRUE),
            'actual_close_date' => array('type' => 'DATE', 'null' => TRUE),
            'status' => array('type' => 'ENUM', 'constraint' => array('open', 'won', 'lost'), 'default' => 'open'),
            'owner_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'deleted_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('stage_id');
        $this->dbforge->add_key('owner_id');
        $this->dbforge->create_table('deals', TRUE, array('ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4'));

        // Add foreign keys using raw SQL (CI3 compatible)
        $this->db->query("
            ALTER TABLE `deals`
            ADD CONSTRAINT `fk_deals_stage_id`
            FOREIGN KEY (`stage_id`) REFERENCES `deal_stages` (`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ");

        $this->db->query("
            ALTER TABLE `deals`
            ADD CONSTRAINT `fk_deals_owner_id`
            FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ");

        // Seed default deal stages
        $stages = array(
            array('name' => 'Prospecting', 'order' => 1, 'color' => 'info', 'created_at' => date('Y-m-d H:i:s')),
            array('name' => 'Qualification', 'order' => 2, 'color' => 'warning', 'created_at' => date('Y-m-d H:i:s')),
            array('name' => 'Proposal', 'order' => 3, 'color' => 'primary', 'created_at' => date('Y-m-d H:i:s')),
            array('name' => 'Negotiation', 'order' => 4, 'color' => 'danger', 'created_at' => date('Y-m-d H:i:s')),
            array('name' => 'Closed Won', 'order' => 5, 'color' => 'success', 'created_at' => date('Y-m-d H:i:s')),
            array('name' => 'Closed Lost', 'order' => 6, 'color' => 'secondary', 'created_at' => date('Y-m-d H:i:s'))
        );
        $this->db->insert_batch('deal_stages', $stages);

        log_message('info', 'Migration 005: Deals and Deal Stages tables created');
    }

    public function down()
    {
        $this->db->query("ALTER TABLE `deals` DROP FOREIGN KEY `fk_deals_stage_id`");
        $this->db->query("ALTER TABLE `deals` DROP FOREIGN KEY `fk_deals_owner_id`");
        $this->dbforge->drop_table('deals');
        $this->dbforge->drop_table('deal_stages');
        log_message('info', 'Migration 005: Tables dropped');
    }
}