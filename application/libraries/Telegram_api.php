<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram_api
{

    protected $CI;
    protected $url = "https://trusmicorp.com/rspproject/api/notifikasi/telegram";

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    /**
     * Kirim notifikasi ke API Telegram
     *
     * @param string $contact_no  Nomor kontak penerima
     * @param string $message     Pesan yang akan dikirim
     * @param string|int $type    Tipe pesan (misal: 1 = text, 2 = photo)
     * @return mixed              Array jika JSON, string kalau bukan JSON
     */
    public function send($contact_no, $message, $type = 1)
    {
        $payload = array(
            "contact_no" => $contact_no,
            "message"    => $message,
            "type"       => $type
        );

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        // jangan pakai JSON header, cukup default form-data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return array("status" => false, "error" => $error_msg);
        }

        curl_close($ch);

        $decoded = json_decode($response, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $response;
    }
}
