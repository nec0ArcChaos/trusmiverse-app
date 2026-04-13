<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mom_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('FormatJson');
        $this->load->library('WAJS');

        $this->load->model("model_mom", "model");
    }

    public function test()
    {
        $data = $this->model->mom_autonotif();
        echo json_encode($data);
    }

    // dikirim H-1 dari Deadline
    public function autonotif_mom()
{
    $items = $this->model->mom_autonotif();

    if (empty($items)) {
        return "Tidak ada data MOM untuk dikirim.";
    }

    foreach ($items as $data) {

        $msg = "📑 *Minutes of Meeting*

🚨 Reminder H-1 deadline

💡 Judul : " . $data['judul'] . "
📍 Tempat : " . $data['tempat'] . "
📆 Tanggal : " . $data['tgl'] . "
🕗 Waktu : " . $data['waktu'] . "
📚 Agenda : " . $data['agenda'] . "
👥 Peserta : " . $data['peserta'] . "
📝 Pembahasan : " . strip_tags($data['pembahasan']) . "
🔖 Closing Statement : " . strip_tags($data['closing_statement']) . "

🔗 Detail : " . $data['link'];

        // kirim WA
        $this->send_wa($data['kontak_pic'], $msg, $data['user_id']);
    }

    return "Done kirim semua notifikasi MOM.";
}



    // dikirim H dari Deadline
    public function autonotif_mom_deadline()
    {
        $data = $this->model->mom_autonotif_deadline();
        $response['text'] = "";

        foreach ($data as $mom) {
            $msg = "📑 *Minutes of Meeting*

🚨 Reminder deadline " . $mom['deadline'] . "
			
💡 Judul : " . $mom['judul'] . "
📍 Tempat : " . $mom['tempat'] . "
📆 Tanggal : " . $mom['tgl'] . "
🕗 Waktu : " . $mom['waktu'] . "
📚 Agenda : " . $mom['agenda'] . "
👥 Peserta : " . $mom['peserta'] . "
📝 Pembahasan : " . strip_tags($mom['pembahasan']) . "
🔖 Closing Statement : " . strip_tags($mom['closing_statement']) . "

🔗 Detail : " . $mom['link'] . "";
            // echo $msg;

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                // "channelID" => "2219204182", // channel BT
                // "channelID" => "2319536345", // Channel Trusmi Group
                "channelID" => "2225082380", // Channel RSP
                // "phone" => "628986997966",
                "phone" => $mom['kontak_pic'],
                "messageType" => "text",
                "body" => $msg,
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method" => 'POST',
                    "content" => json_encode($data_text),
                    "header" => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );
            $context_text = stream_context_create($options_text);
            $result_text = file_get_contents($url, false, $context_text);
            $response['text'] = json_decode($result_text);
        }

        echo json_encode($response);
    }

    function send_wa($phone, $msg, $user_id = '')
    {
        try {
            // $this->load->library('WAJS');
            return $this->wajs->send_wajs_notif($phone, $msg, 'text', 'trusmiverse', $user_id);
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }
}
