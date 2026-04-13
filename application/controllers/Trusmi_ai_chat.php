<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_ai_chat extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        if ($this->session->userdata('user_id') != "") { } else {
            redirect('login', 'refresh');
        }
        $this->load->model('Model_push_notif', 'model');
    }

    public function index()
    {
        $data['pageTitle']        = "Trusmi AI";
        $data['js']               = "trusmi_ai_chat/js";
        $data['content']          = "trusmi_ai_chat/index";
        $data['css']          = "trusmi_ai_chat/css";

        $this->load->view('layout/main', $data);
    }


    function save_chat()
    {
        $user_id = $this->session->userdata('user_id');
        $session_tema = $this->session->userdata('session_tema');

        $tema = $_POST['tema'];
        $prompt = $_POST['prompt'];
        $answer = $_POST['answer'];
        
        if ($session_tema == null || $session_tema == '') { // jika belum ada session_tema

            $id_chat = $this->generate_id_chat($user_id);
            
            // insert ai_chat
            $data['insert_ai_chat'] = $this->insert_ai_chat($id_chat, $user_id, $tema);

            // insert ai_chat_history
            $data['insert_chat_history'] = $this->insert_chat_history($id_chat, $prompt, $answer);
            
            // set session id_chat
            $this->session->set_userdata('session_id_chat', $id_chat);

            // set session_tema
            $this->session->set_userdata('session_tema', $tema);

        }else{ // jika sudah ada session_tema, insert ai_chat_history

            if ($session_tema != $tema) { // jika session_tema berbeda dari tema
                
                // generate id_chat
                $id_chat = $this->generate_id_chat($user_id);
            
                // insert ai_chat
                $data['insert_ai_chat'] = $this->insert_ai_chat($id_chat, $user_id, $tema);

                // set session id_chat
                $this->session->set_userdata('session_id_chat', $id_chat);
                
            }else{
                
                // get id_chat
                $id_chat = $this->session->userdata('session_id_chat');

            }

            $id_chat = $this->session->userdata('session_id_chat');
            $data['insert_chat_history'] = $this->insert_chat_history($id_chat, $prompt, $answer);

        }

        // set session_tema
        $this->session->set_userdata('session_tema', $tema);

        $data['user_id'] = $user_id;
        $data['session_tema'] = $this->session->userdata('session_tema');
        $data['session_id_chat'] = $this->session->userdata('session_id_chat');

        echo json_encode($data);        

        
    }

    function insert_ai_chat($id_chat, $user_id, $tema){
        $chat = array(
            'id_chat' => $id_chat,
            'user_id' => $user_id,
            'tema' => $tema,
            'created_at' => date('Y-m-d H:i:s'),
        );
        return $this->db->insert('ai_chat', $chat);
    }
    
    function insert_chat_history($id_chat, $prompt, $answer){
        $chat_history = array(
            'id_chat' => $id_chat,
            'prompt' => $prompt,
            'answer' => $answer,
            'created_at' => date('Y-m-d H:i:s'),
        );
        return $this->db->insert('ai_chat_history', $chat_history);
    }

    function generate_id_chat($user_id){
        $q = $this->db->query("SELECT
            MAX( RIGHT ( ai_chat.id_chat, 4 ) ) AS kd_max 
            FROM
            ai_chat 
            WHERE
            SUBSTR( ai_chat.created_at, 1, 10 ) = CURDATE()");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }
        return 'CHAT' . date('ymd') . $user_id . $kd;
    }


}
