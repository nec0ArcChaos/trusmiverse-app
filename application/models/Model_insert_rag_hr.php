<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_insert_rag_hr extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function simpan_rag_hr($data)
    {
        foreach ($data as $key => $value) {
            $datas = [
                "content" => $value,
                "created_at" => date("Y-m-d H:i:s")
            ];
            // $query = "INSERT INTO `hris`.`t_chatbot_hr_rag` (`content`, `created_at`) VALUES (\"$value\", CURRENT_TIMESTAMP)";
            $success = $this->db->insert('t_chatbot_hr_rag', $datas);
        }

        return $success;
    }


    
}
