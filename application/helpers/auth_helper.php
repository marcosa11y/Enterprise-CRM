<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if( !function_exists('logged_in')) {
    function logged_in() {
        $CI =& get_instance();
        return $CI->session->userdata('logged_in');
    }
}

if( !function_exists('user_data')) {
    function user_data($key = NULL) {
        $CI =& get_instance();
        $user = $CI->session->userdata('user_data');
        if ($key) {
            return isset($user[$key]) ? $user[$key] : NULL;
        }
        return $user;
    }
}

if (!function_exists('has_role')) {
    function has_role($role_id) {
        return user_data('role_id') == $role_id;
    }
}