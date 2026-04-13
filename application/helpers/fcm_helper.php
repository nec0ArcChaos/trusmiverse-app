<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function send_fcm($token, $title, $body, $notif_id, $nama_menu, $trx_id = null, $fileUrl = null, $fileType = null) {

    $json = json_decode(file_get_contents(APPPATH.'libraries/serviceAccount.json'), true);

    if (!isset($json['private_key'])) {
        return ['error' => 'Invalid service account'];
    }

    $now = time();

    // JWT
    $header = base64url_encode(json_encode(['alg'=>'RS256','typ'=>'JWT']));
    $claim = base64url_encode(json_encode([
        'iss' => $json['client_email'],
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600
    ]));

    openssl_sign("$header.$claim", $signature, $json['private_key'], 'sha256');
    $jwt = "$header.$claim.".base64url_encode($signature);

    // OAuth token
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt
        ])
    ]);
    $res = json_decode(curl_exec($ch), true);
    curl_close($ch);

    if (!isset($res['access_token'])) return $res;

    // Send FCM
    // $payload = [
    //     'message' => [
    //         'token' => $token,
    //         'notification' => [
    //             'title' => $title,
    //             'body'  => $body
    //         ],
    //         'data' => [
    //             'notif_id'  => $notif_id,
    //             'file_url'  => $fileUrl ?? '',
    //             'file_type' => $fileType ?? ''
    //         ],
    //         'android' => [
    //             'priority' => 'HIGH'
    //         ]
    //     ]
    // ];

    $payload = [
        'message' => [
            'token' => $token,
            'data' => [
                // ⛔ SEMUA HARUS STRING (WAJIB FCM)
                'title'     => (string) $title,
                'body'      => (string) $body,
                'notif_id'  => (string) $notif_id,
                'file_url'  => (string) ($fileUrl ?? ''),
                'file_type' => (string) ($fileType ?? ''),
                'nama_menu' => (string) $nama_menu,
                'trx_id'    => (string) $trx_id,

            ],

            'android' => [
                'priority' => 'HIGH',
            ],
        ],
    ];


    // $payload = [
    //             'message' => [
    //                 'token' => $token,
    //                 'data' => [
    //                     'title' => $title,
    //                     'body'  => $body,
    //                     'notif_id' => $notif_id,
    //                     'file_url' => $fileUrl ?? '',
    //                     'file_type' => $fileType ?? '',
    //                     ],
    //                 'android' => [
    //                     'priority' => 'HIGH'
    //                 ]
    //             ]
    //         ];

   

    $ch = curl_init("https://fcm.googleapis.com/v1/projects/{$json['project_id']}/messages:send");
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer '.$res['access_token'],
            'Content-Type: application/json'
        ],
        CURLOPT_POSTFIELDS => json_encode($payload)
    ]);
    $result = curl_exec($ch);
    curl_close($ch);

    return json_decode($result, true);
}
