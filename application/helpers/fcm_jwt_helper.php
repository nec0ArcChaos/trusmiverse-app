<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_fcm_jwt')) {
    function send_fcm_jwt($deviceToken, $title, $body) {
        $jsonFile = APPPATH . 'libraries/serviceAccount.json';
        $json = json_decode(file_get_contents($jsonFile), true);

        $projectId = $json['project_id'];
        $clientEmail = $json['client_email'];
        $privateKey = $json['private_key'];

        // HEADER JWT
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $headerEncoded = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');

        // CLAIM
        $now = time();
        $claim = [
            "iss" => $clientEmail,
            "scope" => "https://www.googleapis.com/auth/firebase.messaging",
            "aud" => "https://oauth2.googleapis.com/token",
            "iat" => $now,
            "exp" => $now + 3600
        ];
        $claimEncoded = rtrim(strtr(base64_encode(json_encode($claim)), '+/', '-_'), '=');

        $signatureInput = $headerEncoded . "." . $claimEncoded;

        openssl_sign($signatureInput, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        $signatureEncoded = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

        $jwt = $signatureInput . "." . $signatureEncoded;

        // Ambil access token
        $postData = [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ];

        $ch = curl_init('https://oauth2.googleapis.com/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        $res = curl_exec($ch);
        curl_close($ch);

        $resArr = json_decode($res, true);
        if (!isset($resArr['access_token'])) return false;
        $accessToken = $resArr['access_token'];

        // Kirim FCM HTTP v1
        $fcmUrl = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body" => $body
                ],
                "android" => [
                    "priority" => "HIGH",
                    "notification" => [
                        "channel_id" => "high_importance_channel"
                    ]
                ]
            ]
        ];

        $ch = curl_init($fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer {$accessToken}",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }
}
