<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    protected $CI;
    protected $layout = 'layouts/main';

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function load($layout, $view, $data = array(), $return = FALSE)
    {
        $data['content'] = $this->CI->load->view($view, $data, TRUE);
        
        if ($return) {
            return $this->CI->load->view($layout, $data, TRUE);
        }
        
        $this->CI->load->view($layout, $data);
    }
}