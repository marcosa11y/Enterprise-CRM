<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Permissions extends CI_Migration 
{
    public function up()
    {
        // Create permissions table
        $this->dbforge->add_field([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'role_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'resource' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => FALSE
            ],
            'action' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => TRUE
            ]
        ]);

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key(['role_id', 'resource', 'action'], TRUE);
        $this->dbforge->create_table('permissions', TRUE);

        // Add foreign key using raw SQL (CI3 doesn't have add_foreign_key method)
        $sql = "ALTER TABLE `permissions` 
                ADD CONSTRAINT `fk_permissions_role` 
                FOREIGN KEY (`role_id`) 
                REFERENCES `roles`(`id`) 
                ON DELETE CASCADE ON UPDATE RESTRICT";
        $this->db->query($sql);

        // Seed admin permissions
        $this->_seed_admin_permissions();
    }

    public function down()
    {
        // Drop foreign key first
        $this->db->query("ALTER TABLE `permissions` DROP FOREIGN KEY `fk_permissions_role`");
        $this->dbforge->drop_table('permissions');
    }

    private function _seed_admin_permissions()
    {
        $admin_role_id = ROLE_ADMIN;
        $modules = ['leads', 'contacts', 'companies', 'deals', 'reports', 'settings'];
        $actions = ['create', 'read', 'update', 'delete'];
        
        $data = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $data[] = [
                    'role_id' => $admin_role_id,
                    'resource' => $module,
                    'action' => $action,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }
        }
        
        if (!empty($data)) {
            $this->db->insert_batch('permissions', $data);
        }
    }
}