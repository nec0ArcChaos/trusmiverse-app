<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reminder_meeting_owner_autonotif extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        // $this->load->model("model_mom", "model");
    }

    // public function test()
    // {
    //     $data = $this->model->mom_autonotif();
    //     echo json_encode($data);
    // }

    function data_autonotif()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $query = "SELECT
            momi.id_mom,
            md5(momi.id_mom) AS id_mom_en,
            momi.id_issue,
            momi.id AS id_item_issue,
            momi.id_task,
            momi.id_sub_task,
            mom.meeting,
            moms.topik,
            moms.issue,
            momi.action AS strategy,
            momk.kategori,
            moml.`level`,
            GROUP_CONCAT(
                TRIM(CONCAT(emp.first_name, ' ', emp.last_name))
            ) AS pic,

            -- addnew
            -- emp.contact_no AS pic_contact,
            CASE    
                WHEN emp.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( emp.contact_no, 2 )) ELSE emp.contact_no 
            END AS pic_contact,

            momi.deadline,
            momi.ekspektasi,
            mtask.evaluasi,
            mtask.file,
            mtask.link,
            IF(momi.verified_status = 1, 'Oke', 'Not Oke') AS pdca_status,
            momi.verified_note AS pdca_note,
            DATE(momi.verified_at) AS pdca_at,
            CONCAT(crt.first_name, ' ', crt.last_name) AS created_by,
            CONCAT(pby.first_name, ' ', pby.last_name) AS pdca_by,
            momi.owner_verified_status AS id_owner_verified_status,
            CASE 
            WHEN momi.owner_verified_status = 1 THEN 'Oke Result'
            WHEN momi.owner_verified_status = 2 THEN 'Not Oke'
            WHEN momi.owner_verified_status = 3 THEN 'Oke Meeting / Diskusi'
            END AS owner_verified_status,
            momi.owner_verified_note,
            momi.owner_meeting -- addnew

        FROM mom_issue_item AS momi
            LEFT JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
            LEFT JOIN mom_issue AS moms ON moms.id_mom = momi.id_mom AND moms.id_issue = momi.id_issue
            LEFT JOIN mom_kategori AS momk ON momk.id = momi.kategori
            LEFT JOIN mom_level AS moml ON moml.id = momi.`level`
            LEFT JOIN xin_employees crt ON crt.user_id = mom.created_by
            LEFT JOIN xin_employees AS emp ON FIND_IN_SET(emp.user_id, momi.pic)
            LEFT JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
            LEFT JOIN (
                SELECT
                    max_task.id,
                    max_task.id_sub_task AS idx,
                    max_task.evaluasi,
                    max_task.file,
                    max_task.link
                FROM td_sub_task_history AS max_task
                JOIN (
                    SELECT id_sub_task, MAX(id) AS max_id
                    FROM td_sub_task_history
                    GROUP BY id_sub_task
                ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task
                    AND max_task.id = subquery_max.max_id
            ) AS mtask ON mtask.idx = momi.id_sub_task
            LEFT JOIN xin_employees pby ON pby.user_id = momi.verified_by
        WHERE
        mom.meeting = 'Owner' 
            -- AND momi.owner_meeting BETWEEN '$start' AND '$end'
            AND momi.owner_meeting = DATE_ADD(CURDATE(),INTERVAL 1 Day)
            -- AND momi.owner_meeting = '2025-04-30'

        GROUP BY momi.id_sub_task";

        return $this->db->query($query)->result();
    }

    // dikirim H-1 dari tanggal meeting
    // lakukan cronjob setiap hari jam 6 pagi

    public function reminder_meeting_owner()
    {
        $data_autonotif = $this->data_autonotif();
        $response['text'] = "";

        // Kirim notif ke setiap PIC
        foreach ($data_autonotif as $row) {

            $lampiran = ($row->file == "" || $row->file == NULL) ? "" : "https://trusmiverse.com/apps/uploads/monday/history_sub_task/".$row->file;

            $msg = "📢 *Reminder Meeting Owner Tasklist IBR PRO (MOM)* 📢

Tasklist *IBR PRO* telah diverifikasi oleh Owner :
🏆 Goals / Issue : *". $row->issue ."*
💡 Strategi : *". $row->strategy ."*
👤 PIC : *". $row->pic ."*
🌐 Lampiran : ". $lampiran ." 
🔗 Link : ". $row->link ."

📑 Status : *". $row->owner_verified_status ."*
🗓️ Jadwal : *". $row->owner_verified_note ."*
📝 Verify by : *". $row->pdca_by ."*
📌 Verify at : *". $row->pdca_at ."*";

            // echo $msg;

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380", // Channel RSP 2507194023
                // "phone" => "6282319840635",
                "phone" => $row->pic_contact,
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
            $response['text'] = json_decode($result_text);
        }

        // Kirim notif ke Pak Ibnu
        foreach ($data_autonotif as $row) {

            $lampiran = ($row->file == "" || $row->file == NULL) ? "" : "https://trusmiverse.com/apps/uploads/monday/history_sub_task/".$row->file;

            $msg = "📢 *Reminder Meeting Owner Tasklist IBR PRO (MOM)* 📢

Tasklist *IBR PRO* telah diverifikasi oleh Owner :
🏆 Goals / Issue : *". $row->issue ."*
💡 Strategi : *". $row->strategy ."*
👤 PIC : *". $row->pic ."*
🌐 Lampiran : ". $lampiran ." 
🔗 Link : ". $row->link ." 

📑 Status : *". $row->owner_verified_status ."*
💬 Note : *". $row->owner_verified_note ."*
🗓️ Date : *". $row->owner_meeting ."*
📝 Verify by : *". $row->pdca_by ."*
📌 Verify at : *". $row->pdca_at ."*";

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380", // Channel RSP 2507194023
                "phone" => "6282217202247", // no pak ibnu
                // "phone" => $row->pic_contact,
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
            $response['text'] = json_decode($result_text);
        }
    
        echo json_encode($response);
    }

    // dikirim H-1 dari Deadline
//     public function autonotif_mom()
//     {
//         $data = $this->model->mom_autonotif();
//         $response['text'] = "";

//         foreach ($data as $mom) {
//             $msg = "📑 *Minutes of Meeting*

// 🚨 Reminder H-1 deadline
			
// 💡 Judul : " . $mom['judul'] . "
// 📍 Tempat : " . $mom['tempat'] . "
// 📆 Tanggal : " . $mom['tgl'] . "
// 🕗 Waktu : " . $mom['waktu'] . "
// 📚 Agenda : " . $mom['agenda'] . "
// 👥 Peserta : " . $mom['peserta'] . "
// 📝 Pembahasan : " . strip_tags($mom['pembahasan']) . "
// 🔖 Closing Statement : " . strip_tags($mom['closing_statement']) . "

// 🔗 Detail : " . $mom['link'] . "";
//             // echo $msg;

//             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

//             $data_text = array(
//                 // "channelID" => "2219204182", // channel BT
//                 // "channelID" => "2319536345", // Channel Trusmi Group
//                 "channelID" => "2225082380", // Channel RSP 2507194023
//                 // "phone" => "628993036965",
//                 "phone" => $mom['kontak_pic'],
//                 "messageType" => "text",
//                 "body" => $msg,
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
//     }

//     // dikirim H dari Deadline
//     public function autonotif_mom_deadline()
//     {
//         $data = $this->model->mom_autonotif_deadline();
//         $response['text'] = "";

//         foreach ($data as $mom) {
//             $msg = "📑 *Minutes of Meeting*

// 🚨 Reminder deadline " . $mom['deadline'] . "
			
// 💡 Judul : " . $mom['judul'] . "
// 📍 Tempat : " . $mom['tempat'] . "
// 📆 Tanggal : " . $mom['tgl'] . "
// 🕗 Waktu : " . $mom['waktu'] . "
// 📚 Agenda : " . $mom['agenda'] . "
// 👥 Peserta : " . $mom['peserta'] . "
// 📝 Pembahasan : " . strip_tags($mom['pembahasan']) . "
// 🔖 Closing Statement : " . strip_tags($mom['closing_statement']) . "

// 🔗 Detail : " . $mom['link'] . "";
//             // echo $msg;

//             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

//             $data_text = array(
//                 // "channelID" => "2219204182", // channel BT
//                 // "channelID" => "2319536345", // Channel Trusmi Group
//                 "channelID" => "2225082380", // Channel RSP
//                 // "phone" => "628986997966",
//                 "phone" => $mom['kontak_pic'],
//                 "messageType" => "text",
//                 "body" => $msg,
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
//     }
}
