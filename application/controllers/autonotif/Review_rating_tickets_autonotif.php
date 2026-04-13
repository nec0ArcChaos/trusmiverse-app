<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_rating_tickets_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("tickets/Model_review_rating_form","model");
    }

    // dikirim H-1 dari Deadline
    public function autonotif_review_rating()
    {
        $data = $this->model->get_reminder_review();
        $response['text'] = "";
        
        foreach ($data as $dt) {
            $msg = "🛰 Reminder Review and Rating System 🛰 
        
Halo *". rtrim($dt->name," ") ."*,
    
Anda telah menyelesaikan User Acceptance Testing (UAT) untuk tiket pengembangan sistem dengan nomor ". $dt->id ." pada tanggal ". $dt->tgl_uat .". Berikut adalah hasil dari UAT yang telah dilakukan:
    
*Detail Ticket*
Nomor Ticket : ". $dt->id ."
Task : ". $dt->task ."
Deskripsi : ". $dt->description ."
    
*Hasil UAT*
Status : ". $dt->status_uat ."
Deskripsi : ". $dt->note_uat ."
    
Terima kasih telah mencoba layanan kami! Apakah Anda puas dengan layanan kami? Berikan rating dan ulasan untuk membantu kami meningkatkan kualitas.
". $dt->link;
			// echo $msg;

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                // "channelID" => "2219204182", // channel BT
                // "channelID" => "2319536345", // Channel Trusmi Group
                "channelID" => "2225082380", // Channel RSP
                // "phone" => "628993036965",
                "phone" => $dt->kontak,
                "messageType" => "text",
                "body" => $msg,
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
            $context_text  = stream_context_create($options_text);
            $result_text = file_get_contents($url, false, $context_text);
            $response['text'] = json_decode($result_text);
        }

        echo json_encode($response);
    }
}
