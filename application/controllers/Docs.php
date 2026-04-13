<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Docs extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }


    function index()
    {
        $data['title'] = 'Documentation';
        $data['content'] = 'docs/getting_started';
        $this->load->view('docs/main', $data);
    }

    function accordions()
    {
        $data['title'] = 'Documentation';
        $data['content'] = 'docs/components/accordions';
        $this->load->view('docs/main', $data);
    }
    function alerts()
    {
        $data['title'] = 'Documentation';
        $data['content'] = 'docs/components/alerts';
        $this->load->view('docs/main', $data);
    }
}