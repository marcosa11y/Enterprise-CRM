<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Init_crm extends CI_Migration {

    public function up()
    {
        // 1. Roles Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'slug' => array('type' => 'VARCHAR', 'constraint' => '50'),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles');

        // 2. Users Table
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'role_id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE),
            'username' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'email' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'password' => array('type' => 'VARCHAR', 'constraint' => '255'),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
            'last_login' => array('type' => 'DATETIME', 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('email');
        $this->dbforge->create_table('users');
        
        // Add foreign key manually (CI 3.1.13 doesn't have add_foreign_key method)
        $this->db->query("ALTER TABLE users ADD CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE ON UPDATE CASCADE");

        // 3. Sessions Table - FIXED: Composite key for sess_match_ip = TRUE
        $this->dbforge->add_field(array(
            'id' => array('type' => 'VARCHAR', 'constraint' => 128),
            'ip_address' => array('type' => 'VARCHAR', 'constraint' => 45),
            'timestamp' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'default' => 0),
            'data' => array('type' => 'BLOB')
        ));
        $this->dbforge->add_key(array('id', 'ip_address'), TRUE); // COMPOSITE PRIMARY KEY
        $this->dbforge->add_key('timestamp');
        $this->dbforge->create_table('ci_sessions');

        // Seed Data
        $this->db->insert('roles', array('id' => 1, 'name' => 'Administrator', 'slug' => 'admin', 'created_at' => date('Y-m-d H:i:s')));
        
        $hashed_password = password_hash('Admin@123', PASSWORD_DEFAULT);
        $this->db->insert('users', array(
            'id' => 1, 'role_id' => 1, 'username' => 'admin', 'email' => 'admin@crm.com',
            'password' => $hashed_password, 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')
        ));

        return TRUE; // IMPORTANT: Return TRUE on success
    }

    public function down()
    {
        $this->dbforge->drop_table('ci_sessions');
        $this->dbforge->drop_table('users');
        $this->dbforge->drop_table('roles');
    }
}