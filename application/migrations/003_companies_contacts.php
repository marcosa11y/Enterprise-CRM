<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Companies_contacts extends CI_Migration {

    public function up()
    {
        // Companies Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
            'email' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'phone' => array('type' => 'VARCHAR', 'constraint' => '20'),
            'website' => array('type' => 'VARCHAR', 'constraint' => '255'),
            'address' => array('type' => 'TEXT'),
            'city' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'state' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'country' => array('type' => 'VARCHAR', 'constraint' => '100', 'default' => 'USA'),
            'postal_code' => array('type' => 'VARCHAR', 'constraint' => '20'),
            'owner_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'status' => array('type' => 'ENUM', 'constraint' => array('active', 'inactive'), 'default' => 'active'),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'deleted_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('owner_id');
        $this->dbforge->create_table('companies', TRUE, array('ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4'));

        // Add foreign key for companies.owner_id using raw SQL
        $this->db->query("
            ALTER TABLE `companies`
            ADD CONSTRAINT `fk_companies_owner_id`
            FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ");

        // Contacts Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'company_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'first_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'last_name' => array('type' => 'VARCHAR', 'constraint' => '100', 'null' => FALSE),
            'email' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'phone' => array('type' => 'VARCHAR', 'constraint' => '20'),
            'position' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'department' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'owner_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'null' => TRUE),
            'status' => array('type' => 'ENUM', 'constraint' => array('active', 'inactive'), 'default' => 'active'),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'deleted_at' => array('type' => 'DATETIME', 'null' => TRUE)
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('company_id');
        $this->dbforge->add_key('owner_id');
        $this->dbforge->create_table('contacts', TRUE, array('ENGINE' => 'InnoDB', 'CHARSET' => 'utf8mb4'));

        // Add foreign keys for contacts using raw SQL
        $this->db->query("
            ALTER TABLE `contacts`
            ADD CONSTRAINT `fk_contacts_company_id`
            FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
            ON DELETE CASCADE ON UPDATE CASCADE
        ");

        $this->db->query("
            ALTER TABLE `contacts`
            ADD CONSTRAINT `fk_contacts_owner_id`
            FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
            ON DELETE SET NULL ON UPDATE CASCADE
        ");

        log_message('info', 'Migration 003: Companies and Contacts tables created');
    }

    public function down()
    {
        // Drop foreign keys first
        $this->db->query("ALTER TABLE `contacts` DROP FOREIGN KEY `fk_contacts_company_id`");
        $this->db->query("ALTER TABLE `contacts` DROP FOREIGN KEY `fk_contacts_owner_id`");
        $this->db->query("ALTER TABLE `companies` DROP FOREIGN KEY `fk_companies_owner_id`");
        
        // Then drop tables
        $this->dbforge->drop_table('contacts');
        $this->dbforge->drop_table('companies');
        
        log_message('info', 'Migration 003: Tables dropped');
    }
}