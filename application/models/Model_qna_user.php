<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_qna_user extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_kategori()
    {
        $query = "SELECT * FROM `qna_m_category` LIMIT 4";
        return $this->db->query($query)->result();
    }

    function get_pilihan_opsi(){
        return $this->db->select('id_type, a_1, a_2, a_3, a_4, a_5')
                    ->from('qna_m_type')
                    ->get()
                    ->result_array();
    }

    function data_a($list_tipe1){
        $this->db->select('id_type, a_1, a_2, a_3, a_4, a_5, b_1, b_2, b_3, b_4, b_5');
        $this->db->from('qna_m_type');
        $this->db->where_in('id_type', $list_tipe1);
        return $this->db->get()->result();
    }
    
}