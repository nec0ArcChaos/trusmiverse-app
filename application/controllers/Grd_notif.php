<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Grd_notif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('autonotif/model_grd_autonotif', 'model');
    }

    public function index()
    {
        $data['data'] = $this->model->get_resume_task();
        header('Content-Type: application/json');
        echo json_encode($data['data']);
    }

    public function auto_notif()
    {
        $data = $this->model->get_resume_task();
        $response = ['text' => '', 'error' => ''];

        if (!empty($data)) {
            foreach ($data as $item) {
                $msg = "*🔥 Pemberitahuan Tasklist GRD Milestone! 🔥*\n\n";
                $msg .= "Hai, Pejuang Produktivitas! 🚀 Kami ingin mengingatkan bahwa ada tasklist yang perlu kamu selesaikan. Jangan sampai terlewat ya!\n\n";

                // Daily Tasks
                if ($item->total_daily > 0 && !empty($item->daily)) {
                    // $msg .= "*Daily ( " . $item->total_daily . "X ):*\n";
                    $msg .= "*✅ Daily :*\n";
                    $daily_tasks = explode('|', $item->daily); // Memecah task berdasarkan |
                    foreach ($daily_tasks as $index => $task) {
                        $msg .= ($index + 1) . ". " . trim($task) . "\n"; // Menambahkan nomor dan task
                    }
                    $msg .= "\n";
                }

                // Weekly Tasks
                if ($item->total_weekly > 0 && !empty($item->weekly)) {
                    // $msg .= "*Weekly ( " . $item->total_weekly . "X ):*\n";
                    $msg .= "*📅 Weekly:*\n";
                    $weekly_tasks = explode('|', $item->weekly); // Memecah task berdasarkan |
                    foreach ($weekly_tasks as $index => $task) {
                        $msg .= ($index + 1) . ". " . trim($task) . "\n"; // Menambahkan nomor dan task
                    }
                    $msg .= "\n";
                }

                // Monthly Tasks
                if ($item->total_monthly > 0 && !empty($item->monthly)) {
                    // $msg .= "*Monthly ( " . $item->total_monthly . "X ):*\n";
                    $msg .= "*📅 Monthly:*\n";
                    $monthly_tasks = explode('|', $item->monthly); // Memecah task berdasarkan |
                    foreach ($monthly_tasks as $index => $task) {
                        $msg .= ($index + 1) . ". " . trim($task) . "\n"; // Menambahkan nomor dan task
                    }
                    $msg .= "\n";
                }

                $msg .= "_✨ Ayo update tasklist kamu sekarang di Trusmiverse menu GRD Milestone! ✨_";

                // Kirim pesan via API
                $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

                $data_text = [
                    "channelID" => "2225082380", // Channel RSP
                    // "phone" => "6285860428016", //nomor mas lutfi
                    // "phone" => "6281214926060", //nomor mas anggi
                    // "phone" => "628986997966", //nomor khael
                    "phone" => $item->contact_no,
                    "messageType" => "text",
                    "body" => $msg,
                    "withCase" => true
                ];

                $options_text = [
                    'http' => [
                        "method"  => 'POST',
                        "content" => json_encode($data_text),
                        "header" =>  "Content-Type: application/json\r\n" .
                            "Accept: application/json\r\n" .
                            "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                    ]
                ];

                $context_text = stream_context_create($options_text);
                $result_text = @file_get_contents($url, false, $context_text);

                if ($result_text === FALSE) {
                    $response['error'] = "Gagal mengirim pesan ke API WhatsApp.";
                } else {
                    $response['text'] = json_decode($result_text);
                }
            }
        } else {
            $response['error'] = "Tidak ada data tasklist yang ditemukan.";
        }

        echo json_encode($response);
    }
}
