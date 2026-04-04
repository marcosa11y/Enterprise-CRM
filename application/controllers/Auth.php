<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->library('form_validation');
        $this->load->model('Auth_model');
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $data['page_title'] = 'Login';

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Auth_model->get_by_email($email);

            if ($user && password_verify($password, $user['password'])) {
                
                if ($user['is_active'] != STATUS_ACTIVE) {
                    $this->session->set_flashdata('error', 'Account is disabled. Contact Support.');
                    redirect('auth/login');
                }

                // Security: Regenerate Session ID to prevent fixation
                $this->session->sess_regenerate(TRUE);

                $sess_data = array(
                    'logged_in' => TRUE,
                    'user_data' => array(
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    )
                );
                $this->session->set_userdata($sess_data);

                // Log Login Activity (Professional Touch)
                log_message('info', "User {$user['email']} logged in.");

                redirect('dashboard');
            } else {
                log_message('error', "Failed login attempt for {$email}");
                $this->session->set_flashdata('error', 'Invalid Credentials');
                redirect('auth/login');
            }
        }
    }

    public function logout()
    {
        log_message('info', "User {$this->session->userdata('user_data')['email']} logged out.");
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}