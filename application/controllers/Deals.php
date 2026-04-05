<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deals extends Auth_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Deal_model', 'Deal_stage_model'));
    }

    public function index()
    {
        if (!$this->permission->can('deals', 'view')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Deals';
        $data['deals'] = $this->Deal_model->get_all($this->data['user']['id']);
        $data['stages'] = $this->Deal_stage_model->get_with_deal_count($this->data['user']['id']);
        $data['pipeline_value'] = $this->Deal_model->get_pipeline_value($this->data['user']['id']);
        
        $this->load->view('deals/index', $data);
    }

    public function kanban()
    {
        if (!$this->permission->can('deals', 'view')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Deal Pipeline';
        $data['deals'] = $this->Deal_model->get_all($this->data['user']['id']);
        $data['stages'] = $this->Deal_stage_model->get_all();
        
        $this->load->view('deals/kanban', $data);
    }

    public function create()
    {
        if (!$this->permission->can('deals', 'create')) {
            show_error('Access Denied', 403);
        }

        $data['page_title'] = 'Add Deal';
        $data['stages'] = $this->Deal_stage_model->get_all();
        
        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('value', 'Value', 'numeric|trim');
        $this->form_validation->set_rules('probability', 'Probability', 'integer|trim|max_length[3]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('deals/create', $data);
        } else {
            $insert_data = array(
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'value' => $this->input->post('value', TRUE) ?: 0,
                'probability' => $this->input->post('probability', TRUE) ?: 50,
                'stage_id' => $this->input->post('stage_id', TRUE),
                'expected_close_date' => $this->input->post('expected_close_date', TRUE),
                'status' => 'open',
                'owner_id' => $this->data['user']['id']
            );

            $this->Deal_model->insert($insert_data);
            $this->session->set_flashdata('success', 'Deal created successfully.');
            redirect('deals');
        }
    }

    public function update_stage()
    {
        if (!$this->permission->can('deals', 'edit')) {
            show_error('Access Denied', 403);
        }

        $deal_id = $this->input->post('deal_id', TRUE);
        $stage_id = $this->input->post('stage_id', TRUE);

        if ($this->Deal_model->update_stage($deal_id, $stage_id)) {
            $this->output->set_status_header(200);
            $this->output->set_content_type('application/json');
            echo json_encode(array('success' => TRUE));
        } else {
            $this->output->set_status_header(500);
            echo json_encode(array('success' => FALSE, 'error' => 'Failed to update'));
        }
    }

    public function edit($id)
    {
        if (!$this->permission->can('deals', 'edit')) {
            show_error('Access Denied', 403);
        }

        $deal = $this->Deal_model->get_by_id($id);
        if (!$deal) {
            show_404();
        }

        $data['page_title'] = 'Edit Deal';
        $data['deal'] = $deal;
        $data['stages'] = $this->Deal_stage_model->get_all();

        $this->form_validation->set_rules('title', 'Title', 'required|trim|max_length[255]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('deals/edit', $data);
        } else {
            $update_data = array(
                'title' => $this->input->post('title', TRUE),
                'description' => $this->input->post('description', TRUE),
                'value' => $this->input->post('value', TRUE) ?: 0,
                'probability' => $this->input->post('probability', TRUE) ?: 50,
                'stage_id' => $this->input->post('stage_id', TRUE),
                'expected_close_date' => $this->input->post('expected_close_date', TRUE),
                'status' => $this->input->post('status', TRUE)
            );

            $this->Deal_model->update($id, $update_data);
            $this->session->set_flashdata('success', 'Deal updated successfully.');
            redirect('deals');
        }
    }

    public function delete($id)
    {
        if (!$this->permission->can('deals', 'delete')) {
            show_error('Access Denied', 403);
        }

        $this->Deal_model->delete($id);
        $this->session->set_flashdata('success', 'Deal deleted successfully.');
        redirect('deals');
    }
}