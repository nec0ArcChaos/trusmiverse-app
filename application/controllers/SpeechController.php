<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SpeechController extends CI_Controller
{

    public function upload()
    {
        // Allow from any origin (CORS)
        header("Access-Control-Allow-Origin: *");

        if (!isset($_FILES['audio'])) {
            echo json_encode(['error' => 'No audio file uploaded.']);
            return;
        }

        $filePath = $_FILES['audio']['tmp_name'];
        $fileName = $_FILES['audio']['name'];

        $apiKey = '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';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/audio/transcriptions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);

        $postFields = [
            'file' => new CURLFile($filePath, 'audio/webm', $fileName),
            'model' => 'whisper-1',
            'language' => 'id' // 🔒 Kunci ke Bahasa Indonesia
        ];

        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode(['error' => curl_error($ch)]);
        } else {
            echo $response;
        }

        curl_close($ch);
    }
}
