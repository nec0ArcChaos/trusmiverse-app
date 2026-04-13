<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_timeline_onboarding_lutfi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data($start, $end)
    {
        $query = "
        ";
        return $this->db->query($query)->result();
    }



    // lutfiambar 18-8-25 chatbot hr
    public function get_chat_history($user_id)
    {
        return $this->db
                    ->where('created_by', $user_id)
                    ->order_by('created_at', 'ASC')
                    ->get('t_chatbot_hr')
                    ->result();
    }


    // // Simpan log chat
    // public function save_chat($data)
    // {
    //     return $this->db->insert('t_chatbot_hr', $data);
    // }

    // // Cari jawaban dari knowledge base
    // public function get_answer($question)
    // {
    //     $this->db->like('content', $question);
    //     $query = $this->db->get('t_chatbot_hr_rag')->row();
    //     return $query ? $query->content : null;
    // }

    // // Ambil semua chat berdasarkan session_id
    // public function get_chat_history($session_id)
    // {
    //     $this->db->where('created_by', $session_id);
    //     $this->db->order_by('created_at', 'ASC');
    //     return $this->db->get('t_chatbot_hr')->result();
    // }



}
