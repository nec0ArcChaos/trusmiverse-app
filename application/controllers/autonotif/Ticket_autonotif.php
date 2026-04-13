<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticket_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("tickets/model_autonotif", "model");
    }

    public function test()
    {
        // 1733
        $data = $this->model->get_head();
        echo json_encode($data);
    }

    // dikirim Tanggal 2,4,6
    // ganti jadi 1,3,5
    function autonotif_ticket()
    {
        $head = $this->model->get_head();
        foreach ($head as $h) {
            $ticket = $this->model->get_tickets($h->head_id);
            $no = 1;
            if ($ticket != null) {
                $items = '';
                foreach ($ticket as $t) {
                    $item = $no . '. *' . $t->task . '* - _' . $t->status . '_ - ' . $t->requester . '.';
                    $items = $items . "
" . $item;
                    $no++;
                }
            } else {
                $items = '
_Belum ada request development_';
            }
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $h->contact_no,
                // "phone" => "6285640279721",
                "messageType" => "text",
                "body" => "🛰 Reminder Request Development System 🛰

Halo *" . $h->head . "*,

Kami ingin memberitahukan bahwa beberapa pengajuan development system telah masuk ke dalam sistem ticket kami. Berikut adalah daftar request yang sudah terdaftar di sistem ticket:
" . $items . "

Untuk mempercepat proses development, mohon lengkapi support data / konsep yang diperlukan untuk setiap pengajuan. Jika ada pengajuan lain yang perlu ditambahkan, silakan input melalui sistem ticket *sebelum tanggal 5 bulan ini*. Kami siap membantu memastikan semua permintaan dapat terdevelop dengan baik dan tepat waktu.

Terima kasih!
Business Improvement Dept",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);

            $image_text = array(
                "channelID" => "2225082380",
                "phone" => $h->contact_no,
                // "phone" => "6285640279721",
                "messageType" => "image",
                "mediaUrl" => "https://trusmiverse.com/hr/uploads/autonotif_ticket/autonotif_ticket.jpg",
                "fileName" => "flow_ticket.jpg",
                "body" => "https://trusmiverse.com/hr/uploads/autonotif_ticket/autonotif_ticket.jpg",  // Add the body field as required
                "withCase" => true
            );

            $options_image = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($image_text),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_image   = stream_context_create($options_image);
            $result_image['wa_api']    = file_get_contents($url, false, $context_image);
        }
        echo json_encode($result_text['wa_api']);
    }
}
