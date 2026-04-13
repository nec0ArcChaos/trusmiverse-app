<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Mockup extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function campaign()
    {
        $this->load->view('mockup/campaign');
    }

    public function event_activation_list_view()
    {
        $this->load->view('mockup/event_activation_list_view');
    }

    public function event_activation_board_view()
    {
        $this->load->view('mockup/event_activation_board_view');
    }

    public function event_activation_calendar_view()
    {
        $this->load->view('mockup/event_activation_calendar_view');
    }

    public function event_activation_archived()
    {
        $this->load->view('mockup/event_activation_archived');
    }
}