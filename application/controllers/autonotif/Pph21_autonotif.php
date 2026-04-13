<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pph21_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_pph21", "model");
    }

    // public function test()
    // {
    //     // 1733
    //     $data = $this->model->get_head();
    //     echo json_encode($data);
    // }

    public function test_autonotif()
    {
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => "6282319840635",
            "messageType" => "text",
            "body" => "🛰 Test Autonotif Penyerahan PPH 21 🛰

                Halo *Ade*,

                Kami ingin memberitahukan bahwa beberapa pengajuan development system telah masuk ke dalam sistem ticket kami. Berikut adalah daftar request yang sudah terdaftar di sistem ticket:

                Untuk mempercepat proses development, mohon lengkapi support data / konsep yang diperlukan untuk setiap pengajuan. Jika ada pengajuan lain yang perlu ditambahkan, silakan input melalui sistem ticket *sebelum tanggal 6 bulan ini*. Kami siap membantu memastikan semua permintaan dapat terdevelop dengan baik dan tepat waktu.
                
                Terima kasih!
                Business Improvement Dept",
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

        echo json_encode($result_text['wa_api']);
    }

    // Di kirim tanggal 5,6,7 ke mba Fafri
    public function autonotif_penyerahan()
    {
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => "6281120012145", // ganti no Comben 62 811-2001-2145
            "messageType" => "text",
            "body" => "🛰 *Reminder Penyerahan PPH 21* 🛰

Reminder untuk segera mengirimkan *Data PPh21* bulan ini ke divisi Finance paling lambat tanggal 5. Pastikan semua data telah diperiksa dan akurat untuk memudahkan proses pengolahan lebih lanjut.

Terima kasih atas kerjasamanya!",
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

        echo json_encode($result_text['wa_api']);
    }

    // Di kirim tanggal 8 ke bu Fani
    public function autonotif_verifikasi()
    {
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => "628112406986", // ganti no bu Fani 628112406986
            "messageType" => "text",
            "body" => "🛰 *Reminder Verifikasi PPH 21* 🛰

Mohon segera lakukan *Verifikasi File PPh21* yang telah diberikan divisi comben. Pastikan semua data sudah benar dan sesuai sebelum dilakukan pembayaran.
Batas waktu untuk verifikasi adalah tanggal 6.

Terima kasih atas perhatian dan kerjasamanya!",
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

        echo json_encode($result_text['wa_api']);
    }

    // Di kirim tanggal 9,10 ke mba Eka
    public function autonotif_pembayaran()
    {
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        $data_text = array(
            "channelID" => "2225082380",
            "phone" => "6285794994556", // no Eka 6285794994556
            "messageType" => "text",
            "body" => "🛰 *Reminder Pembayaran PPH 21* 🛰

Reminder untuk melakukan konfirmasi konsultan agar segera di buatkan ID billing dan pembayaran sebelum tanggal 10. Pastikan *ID billing Pph21* telah di bayarakan. 

Terima kasih atas kerjasamanya!",
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

        echo json_encode($result_text['wa_api']);
    }

    // dikirim Tanggal 2,4,6
    // function autonotif_ticket()
    // {
    //     $head = $this->model->get_head();

    //     foreach ($head as $h) {
    //         $ticket = $this->model->get_tickets($h->head_id);
    //         $no = 1;
    //         if ($ticket != null) {
    //             $items = '';
    //             foreach ($ticket as $t) {
    //                 $item = $no . '. *' . $t->task . '* - _' . $t->status . '_ - ' . $t->requester . '.';
    //                 $items = $items . "
    //                         " . $item;
    //                 $no++;
    //             }
    //         } else {
    //             $items = '_Belum ada request development_';
    //         }

    //         $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

    //         $data_text = array(
    //             "channelID" => "2225082380",
    //             "phone" => $h->contact_no,
    //             // "phone" => "6285640279721",
    //             "messageType" => "text",
    //             "body" => "🛰 Reminder Request Development System 🛰

    //             Halo *" . $h->head . "*,

    //             Kami ingin memberitahukan bahwa beberapa pengajuan development system telah masuk ke dalam sistem ticket kami. Berikut adalah daftar request yang sudah terdaftar di sistem ticket:
    //             " . $items . "

    //             Untuk mempercepat proses development, mohon lengkapi support data / konsep yang diperlukan untuk setiap pengajuan. Jika ada pengajuan lain yang perlu ditambahkan, silakan input melalui sistem ticket *sebelum tanggal 6 bulan ini*. Kami siap membantu memastikan semua permintaan dapat terdevelop dengan baik dan tepat waktu.

    //             Terima kasih!
    //             Business Improvement Dept",
    //             "withCase" => true
    //         );

    //         $options_text = array(
    //             'http' => array(
    //                 "method"  => 'POST',
    //                 "content" => json_encode($data_text),
    //                 "header" =>  "Content-Type: application/json\r\n" .
    //                     "Accept: application/json\r\n" .
    //                     "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //             )
    //         );

    //         $context_text   = stream_context_create($options_text);
    //         $result_text['wa_api']    = file_get_contents($url, false, $context_text);
    //     }

    //     echo json_encode($result_text['wa_api']);
    // }
}
