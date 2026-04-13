<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insert_chatbot_hr extends CI_Controller{

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model('Model_insert_chatbot_hr', 'model');
    }


    // 23-8-25
    public function save_chatbot_hr()
    {
        $data = [
            'pertanyaan' => $this->input->post('message'),
            'jawaban'    => '', // kosongkan dulu
            'created_by' => $this->input->post('user_id'),
            'session_id' => $this->input->post('session_id') ?? session_id(),
            'role'       => $this->input->post('role') ?? 'user',
            'created_at' => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $insert_id = $this->model->simpan_chatbot_hr($data);

        // Kirim ke n8n
        $payload = [
            'message'   => $data['pertanyaan'],
            'user_id'   => $data['created_by'],
            'record_id' => $insert_id,
            'session_id' => $data['session_id']
        ];

        $ch = curl_init("https://n8n.trustcore.id/webhook/chatbot_hr");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // var_dump($response); // Debug: tampilkan response mentah

        // Default jawaban
        $jawaban = 'Error: Tidak dapat terhubung ke layanan AI.';

        if ($http_code === 200 && $response) {
            $responseData = json_decode($response, true);
            if (!empty($responseData['output'])) {
                $jawaban = $responseData['output'];
            } elseif (!empty($responseData['response'])) {
                $jawaban = $responseData['response'];
            } elseif (!empty($responseData['answer'])) {
                $jawaban = $responseData['answer'];
            }
        }

        $updated_at = date("Y-m-d H:i:s");

        // Update jawaban ke record yg sama
        $id = $this->db->insert_id(); // ambil ID pertanyaan terakhir yang disimpan

        if (!empty($responseData['output'])) {
            $this->model->update_chatbot_hr($id, $responseData['output'], $updated_at);
        }

        // $this->model->update_chatbot_hr($insert_id, $jawaban);

        echo json_encode([
            'status'        => 'success',
            'id'            => $insert_id,
            'pertanyaan'    => $data['pertanyaan'],
            'jawaban'       => $jawaban,
            'updated_at'    => $updated_at,
            'created_at'    => $data['created_at']
        ]);
    }

    

}