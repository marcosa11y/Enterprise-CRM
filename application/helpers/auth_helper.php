<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Check if user is logged in
 * @return bool
 */
if (!function_exists('logged_in')) {
    function logged_in()
    {
        $CI =& get_instance();
        return (bool) $CI->session->userdata('logged_in');
    }
}

/**
 * Alias for logged_in() - for consistency
 * @return bool
 */
if (!function_exists('is_logged_in')) {
    function is_logged_in()
    {
        return logged_in();
    }
}

/**
 * Get current authenticated user data
 * @return array|null
 */
if (!function_exists('current_user')) {
    function current_user()
    {
        static $cached = null;
        
        if ($cached === null) {
            $CI =& get_instance();
            $data = $CI->session->userdata('user_data');
            $cached = !empty($data) ? $data : null;
        }
        
        return $cached;
    }
}

/**
 * Get current user ID
 * @return int|null
 */
if (!function_exists('current_user_id')) {
    function current_user_id()
    {
        $user = current_user();
        return $user ? (int) $user['id'] : null;
    }
}

/**
 * Check if user has specific role
 * @param int $role_id
 * @return bool
 */
if (!function_exists('has_role')) {
    function has_role($role_id)
    {
        $user = current_user();
        return $user && isset($user['role_id']) && (int) $user['role_id'] === (int) $role_id;
    }
}

/**
 * Check if user is admin
 * @return bool
 */
if (!function_exists('is_admin')) {
    function is_admin()
    {
        return has_role(defined('ROLE_ADMIN') ? ROLE_ADMIN : 1);
    }
}

/**
 * Require login - redirect if not logged in
 */
if (!function_exists('require_login')) {
    function require_login()
    {
        if (!logged_in()) {
            redirect('auth/login');
        }
    }
}

/**
 * Require admin role - redirect if not admin
 */
if (!function_exists('require_admin')) {
    function require_admin()
    {
        require_login();
        if (!is_admin()) {
            show_error('Access denied. Admin privileges required.', 403);
        }
    }
}