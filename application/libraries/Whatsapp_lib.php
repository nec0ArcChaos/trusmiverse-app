<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp_lib
{
    public function channel_id($company)
    {
        if ($company == 'rsp') {
            $channel_id_rsp = '2225082380';
            return $channel_id_rsp;
        } else if ($company == 'mom') {
            $channel_id_rsp = '2507194023';
            return $channel_id_rsp;
        } else if ($company == 'eaf') {
            $channel_id_rsp = '2308388562';
            return $channel_id_rsp;
        } else if ($company == 'hr') {
            $channel_id_rsp = '2507194023';
            return $channel_id_rsp;
        }
        return;
    }

    public function send_single_msg($company = '', $contact_number = '', $msg = '')
    {
        $contact_number = $this->change_format_contact($contact_number);
        if (!$company || !$contact_number || !$msg) {
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
        return json_decode($result_text);
    }

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
