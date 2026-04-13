<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Webhook extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_whatsapp_message');
        $this->load->helper('file');
    }

    public function whatsapp()
    {
        $json = file_get_contents("php://input");
        write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " RAW: " . $json . PHP_EOL, 'a+');

        $data = json_decode($json, true);

        if ($data['dataType'] == 'message_create') {

            if (!$data) {
                write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " ERROR: Invalid JSON" . PHP_EOL, 'a+');
                show_error("Invalid JSON", 400);
                return;
            }

            // ambil struktur sesuai payload
            $sessionId = $data['sessionId'] ?? null;
            write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " DATA MESSAGE : " . (json_encode($sessionId)) . PHP_EOL, 'a+');

            $message   = $data['data']['message'] ?? [];
            write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " DATA MESSAGE : " . (json_encode($message)) . PHP_EOL, 'a+');

            $insertData = [
                'session_id' => $sessionId,
                'message_id' => $message['id']['id'] ?? null,
                'sender'     => $message['from'] ?? null,
                'receiver'   => $message['to'] ?? null,
                'body'       => $message['body'] ?? null,
                'type'       => $message['type'] ?? null,
                'timestamp'  => $message['timestamp'] ?? time(),
                'direction'  => isset($message['fromMe']) && $message['fromMe'] ? 'outgoing' : 'incoming'
            ];

            write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " DATA INSERT : " . (json_encode($insertData)) . PHP_EOL, 'a+');
            // simpan DB
            $saved = $this->Model_whatsapp_message->insert_message($insertData);

            write_file(APPPATH . 'logs/webhook_raw.log', date('Y-m-d H:i:s') . " DB INSERT: " . ($saved ? 'SUCCESS' : 'FAILED') . PHP_EOL, 'a+');

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'ok']));
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'ok']));
    }
}
