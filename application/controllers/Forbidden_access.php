<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forbidden_access extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index()
    {
        $data['pageTitle']        = "Forbidden Access";
        $data['pageDescription']  = "Anda tidak punya hak akses untuk mengakses halaman ini.";
        $this->load->view('layout/forbidden_access', $data);
    }
}
