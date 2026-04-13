<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timeline_onboarding_lutfi extends CI_Controller //Formulir Dokumen Karyawan
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_timeline_onboarding_lutfi', 'model');
        $this->load->library('FormatJson');
        $this->load->library('Whatsapp_lib');
    }

    function index()
    {

        $data['pageTitle'] = "Formulir Dokumen Karyawan";
        $data['css'] = "timeline_onboarding_lutfi/css";
        $data['js'] = "timeline_onboarding_lutfi/js";
        $data['content'] = "timeline_onboarding_lutfi/index";
        // $data['fdk']= $this->model_fdk->get_data();

        $user_id    = $this->session->userdata('user_id');

        $data['chats'] = $this->model->get_chat_history($user_id);

        $this->load->view('layout/main', $data);
    }

    function get_data()
    {
        $data['data'] = $this->model->get_data($start, $end);
        echo json_encode($data);
    }










    // Lutfiambar 17-8-25 chatbot hr

    public function chatbot_history()
    {
        $user_id = $this->session->userdata('user_id');

        // ambil semua riwayat chat user ini
        $data['chats'] = $this->model->get_chat_history($user_id);

        // $this->load->view('chat', $data);
    }

    // public function ask()
    // {
    //     $pertanyaan = $this->input->post('message');
    //     $user_id    = $this->session->userdata('user_id');
    //     $session_id = "chat_" . $user_id;

    //     $created_at = date('Y-m-d H:i:s');

    //     // simpan pertanyaan user
    //     $this->model->save_chat([
    //         'pertanyaan' => $pertanyaan,
    //         'jawaban'    => null,
    //         'created_by' => $user_id,
    //         'created_at' => $created_at,
    //         'session_id' => $session_id,
    //         'role'       => 'user',
    //         'message'    => $pertanyaan
    //     ]);

    //     // cari jawaban dari documents
    //     $jawaban = $this->model->get_answer($pertanyaan);
    //     if (!$jawaban) {
    //         $jawaban = "Maaf, saya belum menemukan jawaban untuk pertanyaan Anda.";
    //     }

    //     // simpan jawaban bot
    //     $this->model->save_chat([
    //         'pertanyaan' => $pertanyaan,
    //         'jawaban'    => $jawaban,
    //         'created_by' => 0,
    //         'created_at' => $created_at,
    //         'session_id' => $session_id,
    //         'role'       => 'bot',
    //         'message'    => $jawaban
    //     ]);

    //     echo json_encode([
    //         'status'    => 'success',
    //         'jawaban'   => $jawaban
    //     ]);
    // }



    // public function get_help()
    // {

    //     // If no session exists, create a new one
    //     if ($sessionId == '' || $sessionId == null) {
    //         $this->db->insert('t_chatbot_hr_sessions', [
    //             'user_id'       => $user_id,
    //             'session_name'  => "Chat - " . date('Y-m-d H:i'),
    //             'created_at'    => date('Y-m-d H:i:s')
    //         ]);
    //         $session_id = $this->db->insert_id();
    //     } else {
    //         $session_id = $sessionId;
    //     }

    //     // Store user question
    //     $this->db->insert('t_chatbot_hr', [
    //         'session_id'    => $session_id,
    //         'role'          => 'user',
    //         'message'       => $content,

    //         'file_url'      => $fileUrl,
    //         'kategori'      => $category,
    //         'pertanyaan'    => $content,
    //         'jawaban'       => $response_formatted,
    //         'created_by'    => $user_id,
    //         'created_at'    => date('Y-m-d H:i:s')
    //     ]);

    //     // Store AI response_formatted
    //     $this->db->insert('t_ai_assist', [
    //         'session_id'   => $session_id,
    //         'role'         => 'bot',
    //         'message'      => $response_formatted,

    //         'kategori'     => $category,
    //         'pertanyaan'   => $content,
    //         'jawaban'      => $response_formatted,
    //         'created_by'   => $user_id,
    //         'created_at'   => date('Y-m-d H:i:s')
    //     ]);


    //     if ($response) {
    //         $text = $response;
    //         echo $text;
    //     } else {
    //         echo "No response received.";
    //     }
    // }

    // public function get_chat_sessions()
    // {
    //     $user_id = $this->session->userdata('user_id');

    //     $sessions = $this->db->query("
    //         SELECT 
    //             s.id, 
    //             s.created_at, 
    //             s.session_name, 
    //             s.session_title,
    //             a.pertanyaan,
    //             a.jawaban AS last_message,
    //             a.created_at AS last_created_at
    //         FROM t_chatbot_hr_sessions s
    //         JOIN
    //             (
    //                 SELECT a1.session_id, a1.pertanyaan, a1.jawaban, a1.created_at
    //                 FROM t_chatbot_hr a1
    //                 WHERE a1.created_at = (SELECT MAX(a2.created_at)
    //                                         FROM t_chatbot_hr a2
    //                                         WHERE a2.session_id = a1.session_id
    //                                     )
    //             ) a ON a.session_id = s.id
    //         WHERE s.user_id = ?
    //         AND s.deleted_at IS NULL
    //         GROUP BY s.id
    //         ORDER BY last_created_at DESC
    //     ", [$user_id]
    //     )->result_array();

    //     if (empty($sessions)) {
    //         echo json_encode(["error" => "No chat sessions found"]);
    //         return;
    //     }

    //     echo json_encode($sessions);
    // }

    // public function get_chat_messages($session_id)
    // {
    //     $messages = $this->db->select('role, message, file_url, created_at')
    //         ->from('t_chatbot_hr')
    //         ->where('session_id', $session_id)
    //         ->order_by('created_at', 'ASC')
    //         ->get()
    //         ->result_array();

    //     echo json_encode($messages);
    // }

    // public function create_new_chat_session()
    // {
    //     $userId = $this->session->userdata('user_id');

    //     $data = [
    //         'user_id'       => $userId,
    //         'session_name'  => "Chat - " . date('Y-m-d H:i'),
    //         'created_at'    => date('Y-m-d H:i:s')
    //     ];

    //     $this->db->insert('t_chatbot_hr_sessions', $data);
    //     $sessionId = $this->db->insert_id();

    //     echo json_encode(['session_id' => $sessionId]);
    // }

    // public function delete_chat_session($chatId)
    // {
    //     $this->load->database();

    //     $session = $this->db->get_where('t_chatbot_hr_sessions', ['id' => $chatId])->row();
    //     if (!$session) {
    //         echo json_encode(['success' => false, 'message' => 'Session not found']);
    //         return;
    //     }

    //     $this->db->where('id', $chatId);
    //     $this->db->update('t_chatbot_hr_sessions', ['deleted_at' => date('Y-m-d H:i:s')]);

    //     echo json_encode(['success' => true, 'message' => 'Session deleted successfully']);
    // }

    // public function update_chat_title($chat_id)
    // {
    //     header('Content-Type: application/json');

    //     // Get JSON input
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     $new_title = isset($data['title']) ? trim($data['title']) : '';

    //     // Validate input
    //     if (empty($new_title)) {
    //         echo json_encode(["success" => false, "message" => "Title cannot be empty"]);
    //         return;
    //     }

    //     // Update in database
    //     $this->db->where('id', $chat_id);
    //     $update = $this->db->update('t_chatbot_hr_sessions', ['session_title' => $new_title]);

    //     if ($update) {
    //         echo json_encode(["success" => true, "message" => "Chat title updated successfully"]);
    //     } else {
    //         echo json_encode(["success" => false, "message" => "Failed to update title"]);
    //     }
    // }


    
}
