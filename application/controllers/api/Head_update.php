<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Head_update extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        // $this->load->library('FormatJson');

        $this->load->model('api/Model_head_division', 'model');
    }

    public function update_bobot($id_event)
    {
        $result = $this->model->update_bobot($id_event);

        echo json_encode($result);
    }
}