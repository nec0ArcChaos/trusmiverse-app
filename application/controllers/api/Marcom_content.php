<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marcom_content extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_marcom', 'model');
    }

    public function get_campaign()
    {
        $id = $this->input->post('id');
        $campaign = $this->model->get_campaign_by_id($id);
        if (!$campaign) {
            $response = [
                'status' => 'error',
                'message' => 'Campaign tidak ditemukan.',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
        $response = [
            'status' => 'success',
            'message' => "Campaign ditemukan.",
            'data' => $campaign
        ];
        echo json_encode($response);
    }

    

}