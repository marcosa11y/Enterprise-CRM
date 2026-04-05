<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leads extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Lead_model');
    }

    public function index()
    {
        if (!$this->permission->can('leads', 'view')) {
            show_error('Access Denied', 403);
        }

        $status = $this->input->get('status');
        $data['page_title'] = 'Leads';
        $data['leads'] = $this->Lead_model->get_all($this->data['user']['id'], $status);
        $data['current_status'] = $status;
        $data['stats'] = $this->Lead_model->get_stats($this->data['user']['id']);
        
        $this->load->view('leads/index', $data);
    }

    public function create()
    {
        if (!$this->permission->can('leads', 'create')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Add Lead';
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|max_length[100]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|max_length[20]');
        $this->form_validation->set_rules('value', 'Value', 'numeric|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('leads/create', $data);
        } else {
            $insert_data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'company' => $this->input->post('company', TRUE),
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'source' => $this->input->post('source', TRUE),
                'status' => 'new',
                'value' => $this->input->post('value', TRUE) ?: 0,
                'owner_id' => $this->data['user']['id']
            );

            $this->Lead_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Lead created successfully.');
            redirect('leads');
        }
    }

    public function edit($id)
    {
        if (!$this->permission->can('leads', 'edit')) {
            show_error('Access Denied', 403);
        }

        $lead = $this->Lead_model->get_by_id($id);
        if (!$lead) {
            show_404();
        }

        $data['page_title'] = 'Edit Lead';
        $data['lead'] = $lead;

        $this->form_validation->set_rules('name', 'Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|trim|max_length[100]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('leads/edit', $data);
        } else {
            $update_data = array(
                'name' => $this->input->post('name', TRUE),
                'email' => $this->input->post('email', TRUE),
                'phone' => $this->input->post('phone', TRUE),
                'company' => $this->input->post('company', TRUE),
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'source' => $this->input->post('source', TRUE),
                'status' => $this->input->post('status', TRUE),
                'value' => $this->input->post('value', TRUE) ?: 0
            );

            $this->Lead_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Lead updated successfully.');
            redirect('leads');
        }
    }

    public function convert($id)
    {
        if (!$this->permission->can('leads', 'edit')) {
            show_error('Access Denied', 403);
        }

        $contact_id = $this->Lead_model->convert_to_contact($id);
        if ($contact_id) {
            $this->session->set_flashdata('success', 'Lead converted to contact successfully.');
            redirect('contacts');
        } else {
            $this->session->set_flashdata('error', 'Failed to convert lead.');
            redirect('leads');
        }
    }

    public function delete($id)
    {
        if (!$this->permission->can('leads', 'delete')) {
            show_error('Access Denied', 403);
        }

        $this->Lead_model->delete($id);
        $this->session->set_flashdata('success', 'Lead deleted successfully.');
        redirect('leads');
    }
}