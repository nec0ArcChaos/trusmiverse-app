<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Model_ai_assist extends CI_Model{

    function __construct(){
		parent::__construct();
		$this->load->database();
    }

    function get_help()
    {
        return $this->db->get('m_ai_assist');
    }

    function get_help_category($category, $content)
    {
        $query = "SELECT id, kategori, REPLACE(perintah, '[content]', '$content') AS perintah FROM `m_ai_assist` WHERE id = $category";

        return $this->db->query($query)->row_array();
    }


}