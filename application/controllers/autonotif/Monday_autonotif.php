<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monday_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("autonotif/model_monday_autonotif");
    }

    public function autonotif_kokatto_daily()
    {
        $data = $this->model_monday_autonotif->autonotif_kokatto_daily();

        $liste = [];
        foreach ($data as $value) {
            array_push($liste, $value->id_task);
            $autocall_kokatto[] = $this->kokatto_autocall($value->contact_no);
        }
        // $data_notify['autocall_kokatto'] = $autocall_kokatto;
        $liste = array_unique($liste);
        $in_id_task = implode("','", $liste);
        $data_sub = $this->db->query("SELECT id_task, id_sub_task, notify_date, notify_count FROM td_sub_task WHERE id_task IN ('$in_id_task') GROUP BY id_task")->result();
        foreach ($data_sub as $row) {
            $notify_date = $row->notify_date ?? date("Y-m-d");
            if ($notify_date < date("Y-m-d")) {
                $data_notify['notify_date'] =  date("Y-m-d");
                $data_notify['notify_count'] = 1;
            } else {
                $data_notify['notify_date'] =  date("Y-m-d");
                $data_notify['notify_count'] = $row->notify_count + 1;
            }
            $id_task = $row->id_task;
            $data_notify['id_task'] = $id_task;
            $this->db->where('id_task', $id_task)->update('td_sub_task', $data_notify);
            $data[] = ($data_notify);
        }
        echo json_encode($data);
    }

    function kokatto_get_token()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/identity/auth/login',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "username": "8435api@kokatto.com",
                "password": "Trusmi2023"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $responseGetToken = curl_exec($curl);
        curl_close($curl);
        $myJSON = json_decode($responseGetToken);
        return $myJSON->token ?? "";
    }

    function kokatto_autocall($contact_no)
    {
        $token = $this->kokatto_get_token();
        // Create Single Transactional Notification
        $notificationData = array(
            "code" => "daily_ibrpro"
        );
        $POSTFIELDS = array(
            "clientIdCampaignName" => "8435|VR2",
            "notificationData" => json_encode($notificationData),
            "receiver" => $contact_no,
            "isTransactional" => true,
            "hasChat" => false
        );
        $stringPOSTFIELDS = json_encode($POSTFIELDS);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://portal.kokatto.com/api/v1/livenotification/notifications/followup',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $stringPOSTFIELDS,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        ));
        $responseCreateSingleTransactionalNotification = curl_exec($curl);
        curl_close($curl);
        return $responseCreateSingleTransactionalNotification;
    }

    public function autonotif_daily()
    {
//         // $data = $this->model_monday_autonotif->autonotif_daily();
//         $data = $this->model_monday_autonotif->autonotif_all();
//         $response['text'] = "";

//         $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
//         foreach ($data as $row) {
//             // $notify_date = $row->notify_date ?? date("Y-m-d");
//             // if ($notify_date < date("Y-m-d")) {
//             //     $data_notify['notify_date'] =  date("Y-m-d");
//             //     $data_notify['notify_count'] = 0;
//             // } else {
//             //     $data_notify['notify_date'] =  date("Y-m-d");
//             //     $data_notify['notify_count'] = $row->notify_count + 1;
//             // }
//             // $id_sub_task = $row->id_sub_task;
//             // $this->db->where('id_sub_task', $id_sub_task)->update('td_sub_task', $data_notify);
//             $data_text = array(
//                 // "channelID" => "2219204182", // channel BT
//                 // "channelID" => "2225082380", // Channel Trusmi Group 2507194023
//                 "channelID" => "2225082380", // Channel RSP
//                 // "phone" => '6285324409384',
//                 "phone" => $row->contact_no,
//                 "messageType" => "text",
//                 "body" => "🏅 Reminder *" . trim($row->sub_type) . "* Target Konsistensi  🏅

// ‐----------‐-----------------------------------------------
// 🏆 Goal : *" . $row->task . "*
// 💡 Stategi : *" . trim($row->sub_task) . "*

// 🎖️ Konsistensi : *" . $row->p_consistency . "*% 
// 🎯 Target : *" . $row->target_progress . "*
// ✅ Actual : *" . $row->actual . "*
// ⏳ Progres : *" . $row->p_progress . "%*

// ‐----------‐-----------------------------------------------
// 📝 link : https://trusmiverse.com/apps/ibr_update?id=" . $row->id_sub_task . "&u=" . $row->user_id . "
// ‐----------‐-----------------------------------------------
                
// 🔍 Evaluasi terakhir :
// " . $row->evaluasi . "",
//                 "withCase" => true
//             );

//             $options_text = array(
//                 'http' => array(
//                     "method"  => 'POST',
//                     "content" => json_encode($data_text),
//                     "header" =>  "Content-Type: application/json\r\n" .
//                         "Accept: application/json\r\n" .
//                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
//                 )
//             );
//             $context_text  = stream_context_create($options_text);
//             $result_text = file_get_contents($url, false, $context_text);
//             $response['text'] = json_decode($result_text);
//         }

//         $liste = [];
//         foreach ($data as $value) {
//             array_push($liste, $value->id_sub_task);
//         }
//         $liste = array_unique($liste);
//         $in_id_sub_task = implode("','", $liste);
//         $data_sub = $this->db->query("SELECT id_sub_task, notify_date, notify_count FROM td_sub_task WHERE id_sub_task IN ('$in_id_sub_task')")->result();
//         foreach ($data_sub as $row) {
//             $notify_date = $row->notify_date ?? date("Y-m-d");
//             if ($notify_date < date("Y-m-d")) {
//                 $data_notify['notify_date'] =  date("Y-m-d");
//                 $data_notify['notify_count'] = 0;
//             } else {
//                 $data_notify['notify_date'] =  date("Y-m-d");
//                 $data_notify['notify_count'] = $row->notify_count + 1;
//             }
//             $id_sub_task = $row->id_sub_task;
//             $this->db->where('id_sub_task', $id_sub_task)->update('td_sub_task', $data_notify);
//         }


//         echo json_encode($response);
    }


    public function autonotif_weekly()
    {
        //         $data = $this->model_monday_autonotif->autonotif_weekly();
        //         $response['text'] = "";

        //         $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        //         foreach ($data as $row) {
        //             $data_text = array(
        //                 // "channelID" => "2219204182", // channel BT
        //                 "channelID" => "2225082380", // Channel Trusmi Group 2507194023 
        //                 "phone" => '6285324409384',
        //                 // "phone" => $row->contact_no,
        //                 "messageType" => "text",
        //                 "body" => "🏅 Reminder *" . trim($row->sub_type) . "* Target Konsistensi  🏅

        // ‐----------‐-----------------------------------------------
        // 🏆 Goal : *" . $row->task . "*
        // 💡 Stategi : *" . trim($row->sub_task) . "*

        // 🎖️ Konsistensi : *" . $row->p_consistency . "*% 
        // 🎯 Target : *" . $row->target_progress . "*
        // ✅ Actual : *" . $row->actual . "*
        // ⏳ Progres : *" . $row->p_progress . "%*

        // ‐----------‐-----------------------------------------------
        // 📝 link : https://trusmiverse.com/apps/ibr_update?id=" . $row->id_sub_task . "&u=" . $row->user_id . "
        // ‐----------‐-----------------------------------------------

        // 🔍 Evaluasi terakhir :
        // " . $row->evaluasi . "",
        //                 "withCase" => true
        //             );

        //             $options_text = array(
        //                 'http' => array(
        //                     "method"  => 'POST',
        //                     "content" => json_encode($data_text),
        //                     "header" =>  "Content-Type: application/json\r\n" .
        //                         "Accept: application/json\r\n" .
        //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
        //                 )
        //             );
        //             $context_text  = stream_context_create($options_text);
        //             $result_text = file_get_contents($url, false, $context_text);
        //             $response['text'] = json_decode($result_text);
        //         }


        //         echo json_encode($response);
    }


    public function autonotif_monthly()
    {
        //         $data = $this->model_monday_autonotif->autonotif_monthly();
        //         $response['text'] = "";

        //         $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
        //         foreach ($data as $row) {
        //             $data_text = array(
        //                 // "channelID" => "2219204182", // channel BT
        //                 "channelID" => "2225082380", // Channel Trusmi Group
        //                 "phone" => '6285324409384',
        //                 // "phone" => $row->contact_no,
        //                 "messageType" => "text",
        //                 "body" => "🏅 Reminder *" . trim($row->sub_type) . "* Target Konsistensi  🏅

        // ‐----------‐-----------------------------------------------
        // 🏆 Goal : *" . $row->task . "*
        // 💡 Stategi : *" . trim($row->sub_task) . "*

        // 🎖️ Konsistensi : *" . $row->p_consistency . "*% 
        // 🎯 Target : *" . $row->target_progress . "*
        // ✅ Actual : *" . $row->actual . "*
        // ⏳ Progres : *" . $row->p_progress . "%*

        // ‐----------‐-----------------------------------------------
        // 📝 link : https://trusmiverse.com/apps/ibr_update?id=" . $row->id_sub_task . "&u=" . $row->user_id . "
        // ‐----------‐-----------------------------------------------

        // 🔍 Evaluasi terakhir :
        // " . $row->evaluasi . "",
        //                 "withCase" => true
        //             );

        //             $options_text = array(
        //                 'http' => array(
        //                     "method"  => 'POST',
        //                     "content" => json_encode($data_text),
        //                     "header" =>  "Content-Type: application/json\r\n" .
        //                         "Accept: application/json\r\n" .
        //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
        //                 )
        //             );
        //             $context_text  = stream_context_create($options_text);
        //             $result_text = file_get_contents($url, false, $context_text);
        //             $response['text'] = json_decode($result_text);
        //         }


        // echo json_encode($response);
    }
}
