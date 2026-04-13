<?php
defined('BASEPATH') or exit('No direct script access allowed');

class WAJS
{
    // public function channel_id($company)
    // {
    //     if ($company == 'rsp') {
    //         $channel_id_rsp = '2225082380';
    //         return $channel_id_rsp;
    //     } else if ($company == 'mom') {
    //         $channel_id_rsp = '2507194023';
    //         return $channel_id_rsp;
    //     } else if ($company == 'eaf') {
    //         $channel_id_rsp = '2308388562';
    //         return $channel_id_rsp;
    //     } else if ($company == 'hr') {
    //         $channel_id_rsp = '2507194023';
    //         return $channel_id_rsp;
    //     }
    //     return;
    // }
    protected $CI;

    public function __construct()
    {
        // Get CI instance
        $this->CI = &get_instance();
        // Load model

        $this->CI->load->model('Model_wajs_notif', 'model_wajs_notif_library');
        $this->CI->load->model('Model_wajs_notif_eksternal', 'model_wajs_notif_eksternal_library');
        $this->CI->load->model('Model_wajs_notif_bt', 'model_wajs_notif_bt_library');
        $this->CI->load->model('Model_wajs_notif_tkb', 'model_wajs_notif_tkb_library');
    }


    // notif internal
    public function send_wajs_notif($contact_number = '', $msg = '', $type = '', $domain = '', $user_id = '', $url_image = '')
    {
        $contact_number = $this->change_format_contact($contact_number);
        if (!$contact_number || (!$msg && $type == 'text')  || !$type || !$user_id || !$domain) {
            return "parameter empty";
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

        // untuk case yang hit dari api eksternal biar dapet asal linknya
        // contoh pengguanaan https://trusmi.co.id/api/send_wa_eksternal?url_from=https%3A%2F%2Ftrusmi.co.id%2Forder%2Fdetail%2F12345
        // gunakan urlencode pada url_from

        $url_from = $_GET['url_from'] ?? '';
        $url_from = $url_from != '' ? urldecode($url_from) : $fromLink;
        $data = [
            'tipe_notif' => $type,
            'fromLink'    => $url_from,
            'domain'    => $domain, // kosongkan dulu
            'sendTo' => $user_id,
            'phone' => $contact_number,
            'message'       => $msg,
            'imageUrl'       => $url_image,
            'status'       => 'pending',
            'created_at' => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $id_log = $this->CI->model_wajs_notif_library->insert_log($data);
        $mpm = $this->CI->model_wajs_notif_library->check_mpm();

        $url = "https://n8n.trustcore.id/webhook/send-wajs-notif";
        $data_text = array(
            // "channelID" => $channel_id, // Channel Trusmi Group
            "id_log" => $id_log,
            "check_mpm" => $mpm->total,
            'fromLink'    => $fromLink,
            "domain" => $domain,
            "user_id" => $user_id,
            "phone" => $contact_number,
            "type" => $type,
            "imageUrl" => $url_image,
            "message" => $msg,
            // "withCase" => true
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

    // 7-10-25 lutfiambar notif eksternal
    public function send_wajs_notif_eksternal($contact_number = '', $msg = '', $type = '', $domain = '', $user_id = '', $url_image = '')
    {
        $contact_number = $this->change_format_contact($contact_number);
        if (!$contact_number || (!$msg && $type == 'text')  || !$type || !$user_id || !$domain) {
            return "parameter empty";
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

        // untuk case yang hit dari api eksternal biar dapet asal linknya
        // contoh pengguanaan https://trusmi.co.id/api/send_wa_eksternal?url_from=https%3A%2F%2Ftrusmi.co.id%2Forder%2Fdetail%2F12345
        // gunakan urlencode pada url_from

        $url_from = $_GET['url_from'] ?? '';
        $url_from = $url_from != '' ? urldecode($url_from) : $fromLink;
        $data = [
            'tipe_notif'    => $type,
            'domain'        => $domain, // kosongkan dulu
            'fromLink'      => $url_from,
            'sendTo'        => $user_id,
            'phone'         => $contact_number,
            'message'       => $msg,
            'imageUrl'      => $url_image,
            'status'        => 'pending',
            'created_at'    => date("Y-m-d H:i:s")
        ];

        // Insert dulu → ambil id row baru
        $id_log = $this->CI->model_wajs_notif_eksternal_library->insert_log($data);
        $mpm    = $this->CI->model_wajs_notif_eksternal_library->check_mpm();

        $url = "https://n8n.trustcore.id/webhook/send-wajs-notif-eksternal";
        $data_text = array(
            // "channelID" => $channel_id, // Channel Trusmi Group
            "id_log"    => $id_log,
            "check_mpm" => $mpm->total,
            'fromLink'  => $fromLink,
            "domain"    => $domain,
            "user_id"   => $user_id,
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

    // // 7-10-25 lutfiambar notif bt
    // public function send_wajs_notif_bt($contact_number = '', $msg = '', $type = '', $domain = '', $user_id = '', $url_image = '')
    // {
    //     $contact_number = $this->change_format_contact($contact_number);
    //     if (!$contact_number || (!$msg && $type == 'text')  || !$type || !$user_id || !$domain) {
    //         return "parameter empty";
    //     }

    //     if (!ctype_digit($contact_number)) {
    //         return "contact number contains non-numbers. example format : 6285324409384";
    //     }

    //     // $channel_id = $this->channel_id($company);

    //     // if (!$channel_id) {
    //     //     return;
    //     // }

    //     $data = [
    //         'tipe_notif'    => $type,
    //         'domain'        => $domain, // kosongkan dulu
    //         'sendTo'        => $user_id,
    //         'phone'         => $contact_number,
    //         'message'       => $msg,
    //         'imageUrl'      => $url_image,
    //         'status'        => 'pending',
    //         'created_at'    => date("Y-m-d H:i:s")
    //     ];

    //     // Insert dulu → ambil id row baru
    //     $id_log = $this->CI->model_wajs_notif_bt_library->insert_log_bt($data);
    //     $mpm    = $this->CI->model_wajs_notif_bt_library->check_mpm();

    //     $url = "https://n8n.trustcore.id/webhook/send-wajs-notif-bt";
    //     $data_text = array(
    //         // "channelID" => $channel_id, // Channel Trusmi Group
    //         "id_log"    => $id_log,
    //         "check_mpm" => $mpm->total,
    //         "domain"    => $domain,
    //         "user_id"   => $user_id,
    //         "phone"     => $contact_number,
    //         "type"      => $type,
    //         "imageUrl"  => $url_image,
    //         "message"   => $msg,
    //         // "withCase" => true
    //     );

    //     $options_text = array(
    //         'http' => array(
    //             "method"    => 'POST',
    //             "content"   => json_encode($data_text),
    //             "header"    =>  "Content-Type: application/json\r\n" .
    //                 "Accept: application/json\r\n" .
    //                 "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //         )
    //     );
    //     $context_text  = stream_context_create($options_text);
    //     $error = null;
    //     set_error_handler(function ($severity, $message, $file, $line) use (&$error) {
    //         $error = $message;   // store the warning message
    //         return true;         // don't let PHP output it
    //     });

    //     $result_text = file_get_contents($url, false, $context_text);

    //     restore_error_handler(); // restore default
    //     // $result_text = @file_get_contents($url, false, $context_text);

    //     if ($result_text === false) {
    //         // return error message instead of crashing
    //         return [
    //             "status"  => "failed",
    //             "message" => $error
    //         ];
    //     }
    //     return json_decode($result_text);
    // }

    // // 7-10-25 lutfiambar notif tkb
    // public function send_wajs_notif_tkb($contact_number = '', $msg = '', $type = '', $domain = '', $user_id = '', $url_image = '')
    // {
    //     $contact_number = $this->change_format_contact($contact_number);
    //     if (!$contact_number || (!$msg && $type == 'text')  || !$type || !$user_id || !$domain) {
    //         return "parameter empty";
    //     }

    //     if (!ctype_digit($contact_number)) {
    //         return "contact number contains non-numbers. example format : 6285324409384";
    //     }

    //     // $channel_id = $this->channel_id($company);

    //     // if (!$channel_id) {
    //     //     return;
    //     // }

    //     $data = [
    //         'tipe_notif'    => $type,
    //         'domain'        => $domain, // kosongkan dulu
    //         'sendTo'        => $user_id,
    //         'phone'         => $contact_number,
    //         'message'       => $msg,
    //         'imageUrl'      => $url_image,
    //         'status'        => 'pending',
    //         'created_at'    => date("Y-m-d H:i:s")
    //     ];

    //     // Insert dulu → ambil id row baru
    //     $id_log = $this->CI->model_wajs_notif_tkb_library->insert_log($data);
    //     $mpm    = $this->CI->model_wajs_notif_tkb_library->check_mpm();

    //     $url = "https://n8n.trustcore.id/webhook/send-wajs-notif-tkb";
    //     $data_text = array(
    //         // "channelID" => $channel_id, // Channel Trusmi Group
    //         "id_log"    => $id_log,
    //         "check_mpm" => $mpm->total,
    //         "domain"    => $domain,
    //         "user_id"   => $user_id,
    //         "phone"     => $contact_number,
    //         "type"      => $type,
    //         "imageUrl"  => $url_image,
    //         "message"   => $msg,
    //         // "withCase" => true
    //     );

    //     $options_text = array(
    //         'http' => array(
    //             "method"    => 'POST',
    //             "content"   => json_encode($data_text),
    //             "header"    =>  "Content-Type: application/json\r\n" .
    //                 "Accept: application/json\r\n" .
    //                 "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //         )
    //     );
    //     $context_text  = stream_context_create($options_text);
    //     $error = null;
    //     set_error_handler(function ($severity, $message, $file, $line) use (&$error) {
    //         $error = $message;   // store the warning message
    //         return true;         // don't let PHP output it
    //     });

    //     $result_text = file_get_contents($url, false, $context_text);

    //     restore_error_handler(); // restore default
    //     // $result_text = @file_get_contents($url, false, $context_text);

    //     if ($result_text === false) {
    //         // return error message instead of crashing
    //         return [
    //             "status"  => "failed",
    //             "message" => $error
    //         ];
    //     }
    //     return json_decode($result_text);
    // }


    public function send_single_image_caption($company = '', $contact_number = '', $msg = '', $url_image = '')
    {
        $contact_number = $this->change_format_contact($contact_number);
        if (!$company || !$contact_number || !$msg || !$url_image) {
            return "parameter empty";
        }

        if (!ctype_digit($contact_number)) {
            return "contact number contains non-numbers. example format : 6285324409384";
        }

        $channel_id = $this->channel_id($company);

        if (!$channel_id) {
            return;
        }


        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            "channelID" => $channel_id, // Channel Trusmi Group
            "phone" => $contact_number,
            "messageType" => "image",
            "body" => $url_image,
            "filename" => "my-photo.jpg",
            "caption" => $msg,
            "withCase" => true,
            "topicID" => 1
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
        return json_decode($result_text);
    }

    public function send_single_image($company = '', $contact_number = '',  $url_image = '')
    {
        // Ubah format nomor kontak
        $contact_number = $this->change_format_contact($contact_number);

        // Validasi parameter
        if (!$company || !$contact_number || !$url_image) {
            return "parameter empty";
        }

        if (!ctype_digit($contact_number)) {
            return "contact number contains non-numbers. example format : 6285324409384";
        }

        $channel_id = $this->channel_id($company);
        if (!$channel_id) {
            return "channel ID not found";
        }

        // Endpoint API untuk mengirim pesan WhatsApp
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        // Payload untuk pesan dengan attachment (tipe media)
        $data_media = array(
            "channelID"   => $channel_id,
            "phone"       => $contact_number,
            "messageType" => "image",  // tipe media untuk mengirimkan file/image
            "body"        => $url_image,
            "filename"       => $url_image,
            "withCase"    => true
        );

        // Konfigurasi options untuk context HTTP POST
        $options_media = array(
            'http' => array(
                "method"  => 'POST',
                "content" => json_encode($data_media),
                "header"  => "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "API-Key: 1f9e6f3af40521c4f3f7bf5eaaf9a1cd85e0dc00998b739d1db9560043c49349"
            )
        );

        $context_media = stream_context_create($options_media);
        $result_media = file_get_contents($url, false, $context_media);
        if ($result_media === false) {
            $error = error_get_last();
            return (object)[
                "error" => isset($error['message']) ? $error['message'] : "Unknown error occurred during file_get_contents."
            ];
        }

        $decoded = json_decode($result_media);

        // Tangani error pada JSON decode
        if (json_last_error() !== JSON_ERROR_NONE) {
            return (object)[
                "error" => "Error decoding JSON: " . json_last_error_msg()
            ];
        }

        return $decoded;
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
