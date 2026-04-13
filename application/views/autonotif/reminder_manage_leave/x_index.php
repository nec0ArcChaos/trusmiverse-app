<?php header('Access-Control-Allow-Origin: *');

// if (fmod((date('d')), 3) == 0) {
    $api_url = 'http://192.168.23.195/rspproject/api/hr/list_autonotif_manage_leave';

    // Read JSON file
    $json_data = file_get_contents($api_url);

    // Decode JSON data into PHP array
    $response_data = json_decode($json_data);

    foreach ($response_data->data as $index => $value) {

        // ubah nomor jadi awalan 62
        if ($value->contact_no[0] == '0') {
            $contact_head = ltrim($value->contact_no, $value->contact_no[0]);
            $contact_head = str_replace('+', '', str_replace('-', '', str_replace(' ', '', $contact_head)));
            $contact_head = "62" . $contact_head;
        } else {
            $contact_head = $value->contact_no;
        }

        $list_phone = [
            '628993036965',
            // '6281214926060',
        ];

        $new_detail = "";
        foreach ($value->detail as $index => $key) {
            $detail = rtrim($key->employee_name);
            $new_detail .= "\n" . $detail . "";
            foreach ($key->izin as $index => $key) {
                $detail2 = $key->izin;
                $new_detail .= "\n" . $detail2 . "";
            };
        };

        $msg = "🚨 *Reminder Manage Leave* 🚨 

*" . rtrim($value->head_name) . "*
Head of (". $value->department_name .")

*List Manage Leave*
" . $new_detail;
        // var_dump($msg);
        generate_wa($list_phone, $msg);
    }

function generate_wa($list_phone, $msg)
{
    foreach ($list_phone as $index => $value) {
        send_wa($value, $msg);
    }
}

function send_wa($phone, $msg)
{
    // SEND WA
    $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    $data_text = array(
        "channelID" => "2225082380",
        "phone" => $phone,
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
    $context_text       = stream_context_create($options_text);
    $result_text        = file_get_contents($url, false, $context_text);
    $response['text']   = json_decode($result_text);
    echo json_encode($response);
}
