<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_mind_map extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
}
