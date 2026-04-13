<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_insert_chatbot_hr extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function simpan_chatbot_hr($data)
    {
        $success = $this->db->insert('t_chatbot_hr', $data);
        return $success;
    }

    public function update_chatbot_hr($id, $output, $updated_at)
    {
        $this->db->where('id', $id);
        $this->db->update('t_chatbot_hr', ['jawaban' => $output, 'updated_at' => $updated_at]);
    }


    // public function simpan_chatbot_hr($data)
    // {
    //     $this->db->insert('t_chatbot_hr', $data);
    //     return $this->db->insert_id();
    // }

    // public function update_output($id, $jawaban)
    // {
    //     $this->db->where('user_id', $id);
    //     $this->db->update('t_chatbot_hr', ['jawaban' => $jawaban]);
    // }


    
}
