<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('tickets/model_main', 'model_main');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id_ticket = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'tickets/detail/view/' . $id_ticket,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    public function view($id_task)
    {
        $data['pageTitle'] = "Tickets";
        $data['id_task'] = $id_task;
        $this->load->view('tickets/detail', $data);
    }
}
