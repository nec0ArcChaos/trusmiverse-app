<?php
// $port = '8081';
// db_tour_leader
$servername = "192.168.23.195";
$username = "hris";
$password = "hrd2022";
$dbname = "hris";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query_notif = mysqli_query(
    $conn,
    "SELECT 
    t_fu.no_app, 
    `subject`,
    `description`,
    CONCAT( pic_approve_to.first_name, ' ', pic_approve_to.last_name ) AS approve_to,
    pic_approve_to.username AS approve_to_username,
    pic_approve_to.contact_no AS approve_to_contact,
    SUBSTR( trusmi_approval.created_at, 1, 10 ) AS requested_at,
    SUBSTR( trusmi_approval.created_at, 12, 5 ) AS requested_hour,
    CONCAT( pic_request.first_name, ' ', pic_request.last_name ) AS requested_by,
    trusmi_approval.`status` AS id_status,
    trusmi_m_status.`status`,
    SUBSTR( approve_at, 1, 10 ) AS approve_at,
    CONCAT( pic_approve_by.first_name, ' ', pic_approve_by.last_name ) AS approve_by,
    approve_note,
    CONCAT( leadtime, ' jam' ) AS leadtime, 
    ket_wa 
    FROM(
        SELECT 
        no_app,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) AS leadtime,
        IF(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) >= 3 ,'FU1','DONE') AS ket_wa
        FROM
        trusmi_approval
        WHERE trusmi_approval.`status` = 1

        UNION

        SELECT 
        no_app,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) AS leadtime,
        IF(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) >= 6 ,'FU2','DONE') AS ket_wa
        FROM
        trusmi_approval
        WHERE trusmi_approval.`status` = 4

        UNION

        SELECT 
        no_app,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) AS leadtime,
        IF(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) >= 9 ,'FU3','DONE') AS ket_wa
        FROM
        trusmi_approval
        WHERE trusmi_approval.`status` = 5

        UNION

        SELECT 
        no_app,
        TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) AS leadtime,
        IF(TIMESTAMPDIFF(HOUR, trusmi_approval.created_at,if(trusmi_approval.approve_at is NULL,CURRENT_TIMESTAMP(),trusmi_approval.approve_at)) >= 12 ,'End','DONE') AS ket_wa
        FROM
        trusmi_approval
        WHERE trusmi_approval.`status` = 6

    ) AS t_fu
    LEFT JOIN trusmi_approval ON trusmi_approval.no_app = t_fu.no_app
    LEFT JOIN xin_employees pic_request ON pic_request.user_id = trusmi_approval.created_by
    LEFT JOIN xin_employees pic_approve_to ON pic_approve_to.user_id = trusmi_approval.approve_to
    LEFT JOIN xin_employees pic_approve_by ON pic_approve_by.user_id = trusmi_approval.approve_by
    LEFT JOIN trusmi_m_status ON trusmi_m_status.id = trusmi_approval.status"
);

$v_notif = array();
while ($data = mysqli_fetch_array($query_notif)) {
    $v_notif[] = $data; //v_notif dijadikan array 
}


header('Access-Control-Allow-Origin: *');
foreach ($v_notif as $notif) {

    if ($notif['ket_wa'] == 'FU1') {
        $no_hp = $notif['approve_to_contact'];
        $filter_plus = str_replace('+', '', $no_hp);
        $filter_min  = str_replace('-', '', $filter_plus);
        $filter_nol  = ltrim($filter_min, '0');
        $approve_to_contact       = "62" . $filter_nol;
        $response['approve_to_contact'] = $filter_nol;
        // Send Wa FU1
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            // "channelID" => "2219204182", // channel BT
            "channelID" => "2225082380", // Channel RSP
            "phone" => $approve_to_contact,
            // "phone" => '6285324409384',
            "messageType" => "text",
            "body" => "Alert!!! 🚨
*1st follow-up ( " . $notif['ket_wa'] . " )*
📝 Approve To : " . $notif['approve_to'] . "
👤 Requested By : " . $notif['requested_by'] . "
🕐 Requested At : " . $notif['requested_at'] . " | " . $notif['requested_hour'] . "
⌛ Leadtime : " . $notif['leadtime'] . "

No. App : " . $notif['no_app'] . "
Subject : *" . $notif['subject'] . "*
Description : " . $notif['description'] . "
🌐 Link Approve :
http://trusmiverse.com/apps/login/verify?u=" . $notif['approve_to_username'] . "&id=" . $notif['no_app'] . "",
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
        echo json_encode($response);

        // update status ke 4 (FU1) di trusmi_m_status
        $no_app = $notif['no_app'];
        $data['update_fu1'] = mysqli_query(
            $conn,
            "UPDATE trusmi_approval SET `status` = 4 WHERE no_app ='$no_app'"
        );
        echo json_encode($data);
    } else if ($notif['ket_wa'] == 'FU2') {
        $no_hp = $notif['approve_to_contact'];
        $filter_plus = str_replace('+', '', $no_hp);
        $filter_min  = str_replace('-', '', $filter_plus);
        $filter_nol  = ltrim($filter_min, '0');
        $approve_to_contact       = "62" . $filter_nol;
        // Send Wa FU2
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            // "channelID" => "2219204182", // channel BT
            "channelID" => "2225082380", // Channel RSP
            "phone" => $approve_to_contact,
            // "phone" => '6285324409384',
            "messageType" => "text",
            "body" => "Alert!!! 🚨🚨
*2nd follow-up ( " . $notif['ket_wa'] . " )*
📝 Approve To : " . $notif['approve_to'] . "
👤 Requested By : " . $notif['requested_by'] . "
🕐 Requested At : " . $notif['requested_at'] . " | " . $notif['requested_hour'] . "
⌛ Leadtime : " . $notif['leadtime'] . "

No. App : " . $notif['no_app'] . "
Subject : *" . $notif['subject'] . "*
Description : " . $notif['description'] . "
🌐 Link Approve :
http://trusmiverse.com/apps/login/verify?u=" . $notif['approve_to_username'] . "&id=" . $notif['no_app'] . "",
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
        echo json_encode($response);

        // update status ke 5 (FU2) di trusmi_m_status
        $no_app = $notif['no_app'];
        $data['update_fu2'] = mysqli_query(
            $conn,
            "UPDATE trusmi_approval SET `status` = 5 WHERE no_app ='$no_app'"
        );
        echo json_encode($data);
    } else if ($notif['ket_wa'] == 'FU3') {
        $no_hp = $notif['approve_to_contact'];
        $filter_plus = str_replace('+', '', $no_hp);
        $filter_min  = str_replace('-', '', $filter_plus);
        $filter_nol  = ltrim($filter_min, '0');
        $approve_to_contact       = "62" . $filter_nol;
        // Send Wa FU3
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            // "channelID" => "2219204182", // channel BT
            "channelID" => "2225082380", // Channel RSP
            "phone" => $approve_to_contact,
            // "phone" => '6285324409384',
            "messageType" => "text",
            "body" => "Alert!!! 🚨🚨🚨
*3rd follow-up ( " . $notif['ket_wa'] . " )*
📝 Approve To : " . $notif['approve_to'] . "
👤 Requested By : " . $notif['requested_by'] . "
🕐 Requested At : " . $notif['requested_at'] . " | " . $notif['requested_hour'] . "
⌛ Leadtime : " . $notif['leadtime'] . "

No. App : " . $notif['no_app'] . "
Subject : *" . $notif['subject'] . "*
Description : " . $notif['description'] . "
🌐 Link Approve :
http://trusmiverse.com/apps/login/verify?u=" . $notif['approve_to_username'] . "&id=" . $notif['no_app'] . "",
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
        echo json_encode($response);
        // update status ke 6 (FU3) di trusmi_m_status
        $no_app = $notif['no_app'];
        $data['update_fu3'] = mysqli_query(
            $conn,
            "UPDATE trusmi_approval SET `status` = 6 WHERE no_app ='$no_app'"
        );
        echo json_encode($data);
    } else if ($notif['ket_wa'] == 'End') {
        $no_hp = $notif['approve_to_contact'];
        $filter_plus = str_replace('+', '', $no_hp);
        $filter_min  = str_replace('-', '', $filter_plus);
        $filter_nol  = ltrim($filter_min, '0');
        $approve_to_contact       = "62" . $filter_nol;
        // Send Wa End
        $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        $data_text = array(
            // "channelID" => "2219204182", // channel BT
            "channelID" => "2225082380", // Channel RSP
            "phone" => $approve_to_contact,
            // "phone" => '6285324409384',
            "messageType" => "text",
            "body" => "Alert!!! ❌❌❌
*Time's up, ( " . $notif['ket_wa'] . " )*
📝 Approve To : " . $notif['approve_to'] . "
👤 Requested By : " . $notif['requested_by'] . "
🕐 Requested At : " . $notif['requested_at'] . " | " . $notif['requested_hour'] . "
⌛ Leadtime : " . $notif['leadtime'] . "

No. App : " . $notif['no_app'] . "
Subject : *" . $notif['subject'] . "*
Description : " . $notif['description'] . "
",
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
        echo json_encode($response);
        $no_app = $notif['no_app'];
        $data['update_fu_end'] = mysqli_query(
            $conn,
            "UPDATE trusmi_approval SET `status` = 7 WHERE no_app ='$no_app'"
        );
        echo json_encode($data);
    }
}
