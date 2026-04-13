<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WAJS_hr
{
    protected $CI;

    public function __construct()
    {
        // Get CI instance
        $this->CI = &get_instance();
        // Load model
        $this->CI->load->model('Model_wajs_notif_hr', 'model_wajs_notif_library_hr');
    }


    // 7-10-25 lutfiambar
    public function send_wajs_notif_hr($contact_number = '', $msg = '', $type = '', $domain = '', $url_image = '')
    {
        $contact_number = $this->change_format_contact($contact_number);
        if (!$contact_number || (!$msg && $type == 'text')  || !$type || !$domain) {
            return json_encode(["status" => "failed", "message" => "parameter empty", "contact_number" => $contact_number, "msg" => $msg, "type" => $type, "domain" => $domain]);
        }

        if (!ctype_digit($contact_number)) {
            return "contact number contains non-numbers. example format : 6285324409384";
        }

        // $channel_id = $this->channel_id($company);

        // if (!$channel_id) {
        //     return;
        // }

        $httpHost = $_SERVER['HTTP_HOST'] ?? '';
        $requestURI = $_SERVER['REQUEST_URI'] ?? '';
        // untuk case normal yang hit dari controller
        $fromLink = "https://$httpHost$requestURI";

        // untuk case yang hit dari api hr biar dapet asal linknya
        // contoh pengguanaan https://trusmi.co.id/api/send_wa_hr?url_from=https%3A%2F%2Ftrusmi.co.id%2Forder%2Fdetail%2F12345
        // gunakan urlencode pada url_from

        $url_from = $_GET['url_from'] ?? '';
        $url_from = $url_from != '' ? urldecode($url_from) : $fromLink;
        $data = [
            'tipe_notif'    => $type,
            'domain'        => $domain, // kosongkan dulu
            'fromLink'      => $url_from,
            'phone'         => $contact_number,
            'message'       => $msg,
            'imageUrl'      => $url_image,
            'status'        => 'pending',
            'created_at'    => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $id_log = $this->CI->model_wajs_notif_library_hr->insert_log($data);
        $mpm    = $this->CI->model_wajs_notif_library_hr->check_mpm();

        $url = "https://n8n.trustcore.id/webhook/wajs-notif-hr";
        $data_text = array(
            // "channelID" => $channel_id, // Channel Trusmi Group
            "id_log"    => $id_log,
            "check_mpm" => $mpm->total,
            "domain"    => $domain,
            'fromLink'  => $url_from,
            "phone"     => $contact_number,
            "type"      => $type,
            "imageUrl"  => $url_image,
            "message"   => $msg,
            // "withCase" => true
        );

        $options_text = array(
            'http' => array(
                "method"    => 'POST',
                "content"   => json_encode($data_text),
                "header"    =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
            )
        );
        $context_text  = stream_context_create($options_text);
        $error = null;
        set_error_handler(function ($severity, $message, $file, $line) use (&$error) {
            $error = $message;   // store the warning message
            return true;         // don't let PHP output it
        });

        $result_text = file_get_contents($url, false, $context_text);

        restore_error_handler(); // restore default
        // $result_text = @file_get_contents($url, false, $context_text);

        if ($result_text === false) {
            // return error message instead of crashing
            return [
                "status"  => "failed",
                "message" => $error
            ];
        }
        return json_decode($result_text);
    }


    function change_format_contact($nomorhp)
    {
        //Terlebih dahulu kita trim dl
        $nomorhp = trim($nomorhp);
        //bersihkan dari karakter yang tidak perlu
        $nomorhp = strip_tags($nomorhp);
        // Berishkan dari spasi
        $nomorhp = str_replace(" ", "", $nomorhp);
        // bersihkan dari bentuk seperti  (022) 66677788
        $nomorhp = str_replace("(", "", $nomorhp);
        // bersihkan dari format yang ada titik seperti 0811.222.333.4
        $nomorhp = str_replace(".", "", $nomorhp);

        //cek apakah mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nomorhp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nomorhp), 0, 3) == '62') {
                $nomorhp = trim($nomorhp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr($nomorhp, 0, 1) == '0') {
                $nomorhp = '62' . substr($nomorhp, 1);
            }
        }
        return $nomorhp;
    }
}
