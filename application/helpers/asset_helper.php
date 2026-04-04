<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('load_css')) {
    /**
     * Load CSS file (CDN or local)
     *
     * @param string $file
     * @param bool $is_cdn
     * @return string
     */
    function load_css($file, $is_cdn = FALSE)
    {
        $CI =& get_instance();
        $version = $CI->config->item('version', 'assets') ?: time();
        
        if ($is_cdn) {
            $url = $file;
        } else {
            $base_path = $CI->config->item('local/css', 'assets');
            $url = base_url($base_path . $file . '.css?v=' . $version);
        }
        
        return '<link rel="stylesheet" href="' . $url . '" type="text/css" />' . PHP_EOL;
    }
}

if (!function_exists('load_js')) {
    /**
     * Load JavaScript file (CDN or local)
     *
     * @param string $file
     * @param bool $is_cdn
     * @return string
     */
    function load_js($file, $is_cdn = FALSE)
    {
        $CI =& get_instance();
        $version = $CI->config->item('version', 'assets') ?: time();
        
        if ($is_cdn) {
            $url = $file;
        } else {
            $base_path = $CI->config->item('local/js', 'assets');
            $url = base_url($base_path . $file . '.js?v=' . $version);
        }
        
        return '<script src="' . $url . '"></script>' . PHP_EOL;
    }
}

if (!function_exists('asset_url')) {
    /**
     * Get asset URL
     *
     * @param string $path
     * @param string $type (css|js|img)
     * @return string
     */
    function asset_url($path, $type = 'css')
    {
        $CI =& get_instance();
        $base_path = $CI->config->item('local/' . $type, 'assets');
        return base_url($base_path . $path);
    }
}