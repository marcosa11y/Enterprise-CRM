<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends MY_Model {
    protected $table_name = 'users';
    protected $primary_key = 'id';

    public function get_by_email($email)
    {
        return $this->db->get_where($this->table_name, array('email' => $email))->row_array();
    }
}