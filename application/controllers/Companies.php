<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Companies extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Company_model');
    }

    public function index()
    {
        if (!$this->permission->can('companies', 'view')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Companies';
        $data['companies'] = $this->Company_model->get_all();
        $data['total'] = $this->Company_model->get_count();
        
        $this->load->view('layouts/main', $data);
        $this->load->view('companies/index', $data);
    }

    public function create()
    {
        if (!$this->permission->can('companies', 'create')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Add Company';
        
        $this->form_validation->set_rules('name', 'Company Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|max_length[100]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[20]');
        $this->form_validation->set_rules('website', 'Website', 'trim|max_length[255]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/main', $data);
            $this->load->view('companies/create', $data);
        } else {
            $insert_data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'website' => $this->input->post('website', TRUE),
                'address' => $this->input->post('address', TRUE),
                'city' => $this->input->post('city', TRUE),
                'state' => $this->input->post('state', TRUE),
                'country' => $this->input->post('country', TRUE),
                'postal_code' => $this->input->post('postal_code', TRUE),
                'owner_id' => $this->data['user']['id'],
                'status' => 'active'
            );

            $id = $this->Company_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Company created successfully.');
            redirect('companies');
        }
    }

    public function edit($id)
    {
        if (!$this->permission->can('companies', 'edit')) {
            show_error('Access Denied', 403);
        }

        $company = $this->Company_model->get_by_id($id);
        if (!$company) {
            show_404();
        }

        $data['page_title'] = 'Edit Company';
        $data['company'] = $company;

        $this->form_validation->set_rules('name', 'Company Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/main', $data);
            $this->load->view('companies/edit', $data);
        } else {
            $update_data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'website' => $this->input->post('website', TRUE),
                'address' => $this->input->post('address', TRUE),
                'city' => $this->input->post('city', TRUE),
                'state' => $this->input->post('state', TRUE),
                'country' => $this->input->post('country', TRUE),
                'postal_code' => $this->input->post('postal_code', TRUE),
                'status' => $this->input->post('status', TRUE)
            );

            $this->Company_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Company updated successfully.');
            redirect('companies');
        }
    }

    public function delete($id)
    {
        if (!$this->permission->can('companies', 'delete')) {
            show_error('Access Denied', 403);
        }

        $this->Company_model->delete($id);
        $this->session->set_flashdata('success', 'Company deleted successfully.');
        redirect('companies');
    }
}