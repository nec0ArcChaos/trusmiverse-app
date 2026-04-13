<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('compas/model_settings', 'model_settings');
        $this->load->database();
    }

    public function get_brands()
    {
        header('Content-Type: application/json');
        $brands = $this->model_settings->get_brands();
        echo json_encode(['data' => $brands]);
    }

    public function get_company()
    {
        header('Content-Type: application/json');
        $company = $this->model_settings->get_company();
        echo json_encode(['data' => $company]);
    }

    public function save_brand()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {

            $brand_id = $this->input->post('brand_id');
            $brand_desc = $this->input->post('brand_desc');

            $company_id = $this->input->post('company_id');
            $company_id_str = $company_id ? implode(',', $company_id) : '';

            $data = [
                'brand_name' => $this->input->post('brand_name'),
                'brand_desc' => $brand_desc,
                'company_id' => $company_id_str,
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id') ?? 1,
            ];

            if ($brand_id) {
                // Update
                if ($this->model_settings->update_brand($brand_id, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Brand updated successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update brand.']);
                }
            } else {
                // Insert
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id') ?? 1;
                if ($this->model_settings->insert_brand($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Brand added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add brand.']);
                }
            }
        } else {
            show_404();
        }
    }

    public function delete_brand()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $brand_id = $this->input->post('brand_id');
            if (empty($brand_id)) {
                echo json_encode(['status' => 'error', 'message' => 'Brand ID is required.']);
                return;
            }
            if ($this->model_settings->delete_brand($brand_id)) {
                echo json_encode(['status' => 'success', 'message' => 'Brand deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete brand.']);
            }
        } else {
            show_404();
        }
    }

    // --- Content Pillar ---
    public function get_content_pillars()
    {
        header('Content-Type: application/json');
        echo json_encode(['data' => $this->model_settings->get_content_pillars()]);
    }

    public function save_content_pillar()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cp_id');
            $brand_ids = $this->input->post('brand_id');
            $data = [
                'cp_name' => $this->input->post('cp_name'),
                'cp_desc' => $this->input->post('cp_desc'),
                'brand_id' => $brand_ids ? implode(',', $brand_ids) : '',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id') ?? 1,
            ];

            if ($id) {
                if ($this->model_settings->update_content_pillar($id, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Content Pillar updated successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update Content Pillar.']);
                }
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id') ?? 1;
                if ($this->model_settings->insert_content_pillar($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Content Pillar added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add Content Pillar.']);
                }
            }
        } else {
            show_404();
        }
    }

    public function delete_content_pillar()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cp_id');
            if ($this->model_settings->delete_content_pillar($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Content Pillar deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Content Pillar.']);
            }
        } else {
            show_404();
        }
    }

    // --- Objective ---
    public function get_objectives()
    {
        header('Content-Type: application/json');
        echo json_encode(['data' => $this->model_settings->get_objectives()]);
    }

    public function save_objective()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('objective_id');
            $brand_ids = $this->input->post('brand_id');
            $data = [
                'objective_name' => $this->input->post('objective_name'),
                'objective_desc' => $this->input->post('objective_desc'),
                'brand_id' => $brand_ids ? implode(',', $brand_ids) : '',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id') ?? 1,
            ];

            if ($id) {
                if ($this->model_settings->update_objective($id, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Objective updated successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update Objective.']);
                }
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id') ?? 1;
                if ($this->model_settings->insert_objective($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Objective added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add Objective.']);
                }
            }
        } else {
            show_404();
        }
    }

    public function delete_objective()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('objective_id');
            if ($this->model_settings->delete_objective($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Objective deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Objective.']);
            }
        } else {
            show_404();
        }
    }

    // --- Generated Content ---
    public function get_generated_contents()
    {
        header('Content-Type: application/json');
        echo json_encode(['data' => $this->model_settings->get_generated_contents()]);
    }

    public function save_generated_content()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cg_id');
            $brand_ids = $this->input->post('brand_id');
            $data = [
                'cg_name' => $this->input->post('cg_name'),
                'cg_desc' => $this->input->post('cg_desc'),
                'brand_id' => $brand_ids ? implode(',', $brand_ids) : '',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id') ?? 1,
            ];

            if ($id) {
                if ($this->model_settings->update_generated_content($id, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Generated Content updated successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update Generated Content.']);
                }
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id') ?? 1;
                if ($this->model_settings->insert_generated_content($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Generated Content added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add Generated Content.']);
                }
            }
        } else {
            show_404();
        }
    }

    public function delete_generated_content()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cg_id');
            if ($this->model_settings->delete_generated_content($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Generated Content deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Generated Content.']);
            }
        } else {
            show_404();
        }
    }

    // --- Content Format ---
    public function get_content_formats()
    {
        header('Content-Type: application/json');
        echo json_encode(['data' => $this->model_settings->get_content_formats()]);
    }

    public function save_content_format()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cf_id');
            $brand_ids = $this->input->post('brand_id');
            $data = [
                'cf_name' => $this->input->post('cf_name'),
                'cf_desc' => $this->input->post('cf_desc'),
                'brand_id' => $brand_ids ? implode(',', $brand_ids) : '',
                'is_active' => $this->input->post('is_active') ? 1 : 0,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('user_id') ?? 1,
            ];

            if ($id) {
                if ($this->model_settings->update_content_format($id, $data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Content Format updated successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update Content Format.']);
                }
            } else {
                $data['created_at'] = date('Y-m-d H:i:s');
                $data['created_by'] = $this->session->userdata('user_id') ?? 1;
                if ($this->model_settings->insert_content_format($data)) {
                    echo json_encode(['status' => 'success', 'message' => 'Content Format added successfully!']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add Content Format.']);
                }
            }
        } else {
            show_404();
        }
    }

    public function delete_content_format()
    {
        header('Content-Type: application/json');
        if ($this->input->SERVER('REQUEST_METHOD') === 'POST') {
            $id = $this->input->post('cf_id');
            if ($this->model_settings->delete_content_format($id)) {
                echo json_encode(['status' => 'success', 'message' => 'Content Format deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete Content Format.']);
            }
        } else {
            show_404();
        }
    }
}