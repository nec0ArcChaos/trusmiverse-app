<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Ai_counseling extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->model('Model_ai_counseling', 'model');
        $this->load->model('Model_co_co', 'model_co_co');


        $api_key = $this->input->get_request_header('x-api-key', TRUE);
        if ($this->session->userdata('user_id') != "" || $api_key == 'n8nAgenticCounseling$123') {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content']           = "co_co/ai_counseling/index";
        $data['pageTitle']         = "Coaching & Counseling";
        $data['css']               = "co_co/ai_counseling/css";
        $data['js']                = "co_co/ai_counseling/js";
        $this->load->view("layout/main", $data);
    }

    function mobile()
    {
        $data['content']           = "co_co/ai_counseling/mobile/index";
        $data['pageTitle']         = "Coaching & Counseling";
        $data['css']               = "co_co/ai_counseling/mobile/css";
        $data['js']                = "co_co/ai_counseling/mobile/js";
        $this->load->view("layout/main", $data);
    }

    function session($id_counselling)
    {
        $data['id_counselling']    = $id_counselling;
        $data['counselling']       = $this->model->detail_counselling($id_counselling);
        $data['content']           = "co_co/ai_counseling/chat";
        $data['pageTitle']         = "Coaching & Counseling";
        $data['css']               = "co_co/ai_counseling/chat_css";
        $data['js']                = "co_co/ai_counseling/chat_js";
        $this->load->view("layout/main", $data);
    }

    function result($id_counselling)
    {
        $data['id_counselling']    = $id_counselling;
        $data['counselling']       = $this->model->detail_counselling($id_counselling);
        $session_counselling       = $this->model->get_session_counselling($id_counselling);
        $data['grow_summary']      = $session_counselling['grow_summary'];
        $data['analysis']          = $session_counselling['analysis'];
        $data['strategic_recommendations'] = $session_counselling['strategic_recommendations'];
        $data['action_plan']       = $session_counselling['action_plan'];
        $data['recommended_resources'] = $session_counselling['recommended_resources'];
        $data['disclaimer']        = $session_counselling['disclaimer'];
        // $data['pageTitle']         = "Coaching & Counseling";
        // $data['css']               = "co_co/ai_counseling/chat_css";
        // $data['js']                = "co_co/ai_counseling/chat_js";
        $this->load->view("co_co/ai_counseling/result", $data);
    }

    public function start_session()
    {
        $topic = $this->input->post('topic');
        $create_session = $this->model->start_session($topic);
        if (!$create_session) {
            echo json_encode(array('status' => 'failed', 'message' => 'Gagal membuat sesi'));
            return;
        }

        if ($create_session != null || $create_session != '') {
            $id_coaching = $create_session;
            // $generate_session_objective = $this->generate_session_objective($id_coaching);
            $generate_session_greeting = $this->generate_greetings($id_coaching, "self");
        }

        echo json_encode(array('status' => 'success', 'message' => 'Sesi berhasil dibuat', 'id_coaching' => $create_session));
    }

    public function save_coaching()
    {
        $id                = $this->model->generate_id_coaching();
        $karyawan        = $_POST['karyawan'];
        $tempat            = $_POST['tempat'];
        $tanggal        = $_POST['tanggal'];
        $atasan            = $_POST['atasan'];
        $review            = $_POST['review'];
        $goals            = $_POST['goals'] ?? '';
        $reality        = $_POST['reality'] ?? '';
        $option            = $_POST['option'] ?? '';
        $will            = $_POST['will'] ?? '';
        $komitmen        = $_POST['komitmen'] ?? '';
        $link_video        = $_POST['link_video'] ?? '';
        $created_at        = date("Y-m-d H:i:s");
        $created_by        = $_SESSION['user_id'];
        $id_project = $_POST['id_project'] ?? '';
        $id_pekerjaan = $_POST['id_pekerjaan'] ?? '';
        $id_sub_pekerjaan = $_POST['id_sub_pekerjaan'] ?? '';
        $id_detail_pekerjaan = $_POST['id_detail_pekerjaan'] ?? '';

        $det = $this->model_co_co->get_detail_user($karyawan);

        $company_id        = $det['company_id'];
        $department_id    = @$_SESSION['department_id'] ?? $det['department_id'];
        $designation_id    = $det['designation_id'];
        $role_id        = $det['role_id'];

        if (!empty($_FILES['foto']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/coaching/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('foto')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

        $data = array(
            "id_coaching"        => $id,
            "karyawan"             => $karyawan,
            "tempat"             => $tempat,
            "tanggal"             => $tanggal,
            "atasan"             => $atasan,
            "review"             => $review,
            "goals"             => $goals,
            "reality"             => $reality,
            "option"             => $option,
            "will"                 => $will,
            "komitmen"             => $komitmen,
            "foto"                 => $file_name,
            "company_id"         => $company_id,
            "department_id"     => $department_id,
            "designation_id"     => $designation_id,
            "role_id"             => $role_id,
            "created_at"         => $created_at,
            "created_by"         => $created_by,
            "link_video"         => $link_video,
            "id_project"         => $id_project,
            "id_pekerjaan"        => $id_pekerjaan,
            "id_sub_pekerjaan"    => $id_sub_pekerjaan,
            "id_detail_pekerjaan"    => $id_detail_pekerjaan
        );

        $result['insert_coaching'] = $this->db->insert("coaching", $data);

        if ($result['insert_coaching']) {
            $id_coaching = $id;
            // $generate_session_objective = $this->generate_session_objective($id_coaching);
            $generate_session_greeting = $this->generate_greetings($id_coaching, "superior");
        }

        echo json_encode($result);
    }

    public function get_kpi()
    {
        $periode = $this->input->post('periode');
        $user_id = $this->input->post('user_id');
        $kpi = $this->model->get_kpi($periode, $user_id);
        echo json_encode($kpi);
    }
    public function get_last_activity()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $kpi = $this->model->get_last_activity($start, $end);
        echo json_encode($kpi);
    }
    public function get_sesi_konsultasi()
    {
        $kpi = $this->model->get_sesi_konsultasi();
        echo json_encode($kpi);
    }

    public function generate_session_objective($id_counselling)
    {
        $counselling = $this->model->detail_counselling($id_counselling);
        $session_metadata = array(
            "session_id" => $counselling['id_coaching'],
            "date" => $counselling['tanggal'],
            "topic" => $counselling['review'],
        );

        $employee = array(
            "name" => $counselling['karyawan'],
            "umur" => $counselling['umur'],
            "gender" => $counselling['gender'],
            "company" => $counselling['company_name'],
            "department" => $counselling['department_name'],
            "position" => $counselling['designation_name'],
            "tenure" => $counselling['masa_kerja'],
        );
        $data_post = array(
            "session_metadata" => $session_metadata,
            "employee" => $employee
        );
        $url = 'https://n8n.trustcore.id/webhook/ai-counselling-objective-afdf-449a-92ea-f34ce5658d7f';
        // $url = 'https://n8n.trustcore.id/webhook-test/ai-counselling-objective-afdf-449a-92ea-f34ce5658d7f';
        $data = array('session' => $data_post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-key: n8nAiCounseling$123'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            // echo json_encode(array('code' => curl_errno($ch), 'status' => 'failed', 'message' => 'Curl error: ' . curl_error($ch)), curl_errno($ch));
            curl_close($ch);
            return curl_error($ch);
        }

        $response_decode = json_decode($response);
        curl_close($ch);

        if ($response_decode) {
            $response = json_decode($response);
            // insert session
            // $insert_session_objective = $this->model->insert_session_objective($id_counselling, $session_metadata, $employee, $response);
            // if (!$insert_session_objective) {
            //     // echo json_encode(array('status' => 'failed', 'message' => 'Gagal membuat sesi'));
            //     return array('status' => 'failed', 'message' => 'Gagal membuat sesi');
            // }
            // echo json_encode(array('status' => 'success', 'message' => 'Sesi berhasil dibuat', 'id_coaching' => $id_counselling));
            return array('status' => 'success', 'message' => 'Sesi berhasil dibuat', 'id_coaching' => $id_counselling);
        }
    }

    public function generate_greetings($id_counselling, $initiated_by)
    {
        $counselling = $this->model->detail_counselling($id_counselling);
        $session_metadata = array(
            "session_id" => $counselling['id_coaching'],
            "date" => $counselling['tanggal'],
            "topic" => $counselling['review'],
            "user_profile" => array(
                "nama" => $counselling['karyawan'],
                "jabatan" => $counselling['designation_name'],
                "gender" => $counselling['gender'] == "Male" ? "Laki-laki" : "Perempuan",
                "usia" => $counselling['umur'],
            ),
            "initiated_by" => $initiated_by
        );

        $insert_session_coaching = $this->model->insert_session_coaching($id_counselling, $session_metadata);

        $data_post = array(
            "session_id" => $counselling['id_coaching'],
            "date" => $counselling['tanggal'],
            "topic" => $counselling['review'],
            "user_profile" => array(
                "nama" => $counselling['karyawan'],
                "jabatan" => $counselling['designation_name'],
                "gender" => $counselling['gender'] == "Male" ? "Laki-laki" : "Perempuan",
                "usia" => $counselling['umur'],
            ),
            "initiated_by" => $initiated_by
        );

        $url = 'https://n8n.trustcore.id/webhook/ai-counselling-greeting-d1bb-4b1e-a5e9-61be0e59a1e9';
        // $url = 'https://n8n.trustcore.id/webhook-test/ai-counselling-greeting-d1bb-4b1e-a5e9-61be0e59a1e9';
        $data = array('session' => $data_post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-key: n8nAiCounseling$123'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        $response_decode = json_decode($response);
        curl_close($ch);

        // var_dump($response_decode);
        // return;
        // echo json_encode($response_decode);
        // echo json_encode($response_decode->message);
        // echo json_encode($response_decode['message']);
        // echo json_encode($response_decode[0]->message);

        $data_ai_response = array(
            "id_coaching" => $id_counselling,
            "sender" => "assistant",
            "message" => $response_decode[0]->message,
            "reason" => $response_decode[0]->reason,
            "created_at" => date('Y-m-d H:i:s')
        );

        // insert ai response
        $insert_ai_response = $this->model->insert_conversation($data_ai_response);
        if (!$insert_ai_response) {
            return array('status' => 'failed', 'message' => 'Gagal membuat sesi');
        }

        return array('status' => 'success', 'message' => $response_decode[0]->message);
    }

    function get_coversation()
    {
        $id_coaching = $this->input->post('id_coaching');
        $conversation = $this->model->get_conversation($id_coaching);
        if (!$conversation) {
            echo json_encode(array('status' => 'failed', 'message' => 'Conversation Not Found'));
            return;
        }
        echo json_encode(array('status' => 'success', 'message' => 'Conversation Found', 'data' => $conversation));
        return;
    }

    public function curl_ai_counseling()
    {
        $id_counselling = $this->input->post('id_counselling');
        $message = $this->input->post('message');

        if ($message != null) {
            $message_from_user = array(
                "id_coaching" => $id_counselling,
                "sender" => "user",
                "message" => $message,
                "reason" => "",
                "created_at" => date('Y-m-d H:i:s')
            );
            $insert_conversation = $this->model->insert_conversation($message_from_user);
        }

        $counselling = $this->model->get_session_counselling($id_counselling);
        $conversation = $this->model->get_conversation($id_counselling);

        $data_conversation = array();

        if ($conversation) {
            foreach ($conversation as $conv) {
                $data_conversation[] = array(
                    "role" => $conv['sender'],
                    "content" => $conv['message'],
                    "send_at" => $conv['created_at'],
                );
            }
        }

        $session_metadata = json_decode($counselling['session_metadata']);
        $data_post = array(
            "session_context" => array(
                "session_id" => $session_metadata->session_id,
                "date" => $session_metadata->date,
                "topic" => $session_metadata->topic,
                "user_profile" => array(
                    "nama" => $session_metadata->user_profile->nama,
                    "jabatan" => $session_metadata->user_profile->jabatan,
                    "gender" => $session_metadata->user_profile->gender,
                    "usia" => $session_metadata->user_profile->usia
                ),
                "conversation_history" => $data_conversation
            )
        );

        $url = 'https://n8n.trustcore.id/webhook/ai-counselling-4f06-aa79-4a8c17d9d922';
        // $url = 'https://n8n.trustcore.id/webhook-test/ai-counselling-4f06-aa79-4a8c17d9d922';
        $data = array('counselling' => $data_post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-key: n8nAiCounseling$123'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo json_encode(array('code' => curl_errno($ch), 'status' => 'failed', 'message' => 'Curl error: ' . curl_error($ch)), curl_errno($ch));
            curl_close($ch);
            return;
        }

        $response_decode = json_decode($response);
        curl_close($ch);

        // var_dump($response_decode);
        // return;
        // echo json_encode($response_decode);
        // echo json_encode($response_decode->message);
        // echo json_encode($response_decode['message']);
        // echo json_encode($response_decode[0]->message);

        $data_ai_response = array(
            "id_coaching" => $id_counselling,
            "sender" => "ai_counseling",
            "message" => $response_decode[0]->message,
            "reason" => $response_decode[0]->reason,
            "created_at" => date('Y-m-d H:i:s')
        );

        // insert ai response
        $insert_ai_response = $this->model->insert_conversation($data_ai_response);
        if (!$insert_ai_response) {
            echo json_encode(array('status' => 'failed', 'message' => 'Gagal membuat sesi'));
        }

        echo json_encode(array('status' => 'success', 'message' => $response_decode[0]->message));
    }

    public function curl_ai_resumer($id_counselling)
    {
        // $id_counselling = $this->input->post('id_counselling');

        $counselling = $this->model->get_session_counselling($id_counselling);
        $conversation = $this->model->get_conversation($id_counselling);

        $data_conversation = array();

        if ($conversation) {
            foreach ($conversation as $conv) {
                $data_conversation[] = array(
                    "role" => $conv['sender'],
                    "content" => $conv['message'],
                    "send_at" => $conv['created_at'],
                );
            }
        }

        $session_metadata = json_decode($counselling['session_metadata']);
        $data_post = array(
            "session_context" => array(
                "session_id" => $session_metadata->session_id,
                "date" => $session_metadata->date,
                "topic" => $session_metadata->topic,
                "user_profile" => array(
                    "nama" => $session_metadata->user_profile->nama,
                    "jabatan" => $session_metadata->user_profile->jabatan,
                    "gender" => $session_metadata->user_profile->gender,
                    "usia" => $session_metadata->user_profile->usia
                ),
                "conversation_history" => $data_conversation
            )
        );

        // echo json_encode($data_post);
        // return;
        $url = 'https://n8n.trustcore.id/webhook/ai-counseling-resumer-7bd4-455d-bec1-8ca3f22c98fc';
        // $url = 'https://n8n.trustcore.id/webhook-test/ai-counseling-resumer-7bd4-455d-bec1-8ca3f22c98fc';
        $data = array('counselling' => $data_post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-key: n8nAiCounseling$123'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
            // echo json_encode(array('code' => curl_errno($ch), 'status' => 'failed', 'message' => 'Curl error: ' . curl_error($ch)), curl_errno($ch));
            curl_close($ch);
            return;
        }

        $response_decode = json_decode($response);
        curl_close($ch);

        // echo json_encode($response);
        return $response_decode;
    }

    public function curl_ai_action_plan($id_counselling)
    {
        // $id_counselling = $this->input->post('id_counselling');

        $counselling = $this->model->get_session_counselling($id_counselling);
        $conversation = $this->model->get_conversation($id_counselling);

        $data_conversation = array();

        if ($conversation) {
            foreach ($conversation as $conv) {
                $data_conversation[] = array(
                    "id" => $conv['id'],
                    "role" => $conv['sender'],
                    "message" => $conv['message'],
                    "created_at" => $conv['created_at'],
                );
            }
        }

        $session_metadata = json_decode($counselling['session_metadata']);
        $data_post = array(
            "session_metadata" => json_decode($counselling['session_metadata']),
            "grow_summary" => json_decode($counselling['grow_summary']),
            "analysis" => json_decode($counselling['analysis']),
        );

        // echo json_encode($data_post);
        // return;
        $url = 'https://n8n.trustcore.id/webhook/ai-counseling-action-plan-15d3-4ffa-af3c-82000c223e80';
        $url = 'https://n8n.trustcore.id/webhook-test/ai-counseling-action-plan-15d3-4ffa-af3c-82000c223e80';
        $data = array('counselling' => $data_post);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'x-api-key: n8nAiCounseling$123'
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
            // echo json_encode(array('code' => curl_errno($ch), 'status' => 'failed', 'message' => 'Curl error: ' . curl_error($ch)), curl_errno($ch));
            curl_close($ch);
            return;
        }

        $response_decode = json_decode($response);
        curl_close($ch);

        // echo json_encode($response);
        return $response_decode;
    }

    function akhiri_sesi()
    {
        $id_coaching = $this->input->post('id_coaching');
        $akhiri_sesi = $this->model->akhiri_sesi($id_coaching);
        if (!$akhiri_sesi) {
            echo json_encode(array('status' => 'failed', 'message' => 'Gagal mengakhiri sesi'));
            return;
        }

        $curl_ai_resumer = $this->curl_ai_resumer($id_coaching);

        echo json_encode(array('status' => 'success', 'message' => 'Sesi berhasil diakhiri', 'id_coaching' => $id_coaching));
        return;
    }

    function insert_evaluation()
    {
        $api_key = $this->input->get_request_header('x-api-key', TRUE);
        if ($api_key !== 'n8nAgenticCounseling$123') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        // Ambil raw input JSON
        $json = file_get_contents('php://input');

        // Decode ke array
        $data = json_decode($json, true);
        // [
        //     {
        //         "session_metadata": {
        //         "session_id": "AC2511280006",
        //         "session_date": "28 Nov 2025",
        //         "employee_name": "Aris Setiana",
        //         "role": "IT Programmer Officer",
        //         "department": "Innovation & System Development",
        //         "review_problem": "Work-Life Balance"
        //         },
        //         "grow_summary": {
        //         "goal": "Mengelola waktu lebih baik dan membangun alur kerja yang lebih terstruktur agar tidak keteteran saat user meminta revisi cepat dalam 2–4 minggu ke depan.",
        //         "reality": "Workload internal sedang tinggi. Requirement user sering berubah dan muncul permintaan revisi mendadak sehingga terjadi frequent task switching (dari modul A ke modul B yang dianggap urgent). Upaya membuat task list harian belum konsisten dipakai karena sering terinterupsi oleh request baru. Tantangan utama: manajemen waktu dan prioritas yang belum disepakati lintas user.",
        //         "options": "- Menyepakati sistem prioritas tugas dengan user dan atasan.\n- Meminta waktu minimum/buffer sebelum revisi dilakukan agar task berjalan bisa diselesaikan.\n- Membuat dashboard task yang dapat diakses user dan atasan untuk transparansi status dan antrian pekerjaan.",
        //         "will_action_plan": "- Mulai besok, mengusulkan aturan prioritas yang jelas di grup tim.\n- Meminta user mengikuti alur prioritas yang disepakati.\n- Menjelaskan dampak bila ada permintaan cepat di luar alur agar hasil lebih konsisten.",
        //         "commitment": "- Akan memulai implementasi besok.\n- Berkomitmen menyosialisasikan aturan prioritas ke user dan atasan.\n- Siap mengedukasi user tentang dampak permintaan mendadak.\n- Tingkat keyakinan untuk menjalankan rencana: 8/10."
        //         },
        //         "analysis": {
        //         "key_takeaways": "- Pentingnya prioritas bersama lintas user dan atasan.\n- Perlunya komunikasi yang lebih jelas terkait alur dan dampak permintaan mendadak.\n- Rencana konkret untuk mulai besok dengan usulan aturan prioritas.\n- Transparansi pekerjaan (mis. dashboard) dinilai membantu sebagai solusi jangka menengah.",
        //         "main_issue_highlight": "Frequent task switching akibat permintaan mendadak dan requirement yang berubah-ubah membuat manajemen waktu tidak efektif.",
        //         "burnout_risk_indicators": [
        //             "Menyebut workload cukup tinggi",
        //             "Sering switching task karena permintaan mendadak/urgent",
        //             "Kesulitan menjaga konsistensi rencana harian karena interupsi",
        //             "Tekanan untuk cepat melakukan revisi"
        //         ],
        //         "root_cause_hypothesis": "Akar masalah kemungkinan terkait belum adanya kesepakatan prioritas dan alur permintaan dengan user, ditambah perubahan requirement yang sering, yang memicu task switching dan mengganggu struktur kerja serta manajemen waktu."
        //         }
        //     }
        //     ]

        $session_id = $data['data']['session_metadata']['session_id'];
        $grow_summary = $data['data']['grow_summary'];
        $analysis = $data['data']['analysis'];

        $this->model->insert_session_coaching_evaluation($session_id, $grow_summary, $analysis);

        if ($session_id) {
            $review_problem = $data['data']['session_metadata']['review_problem'];
            $goal = $data['data']['grow_summary']['goal'];
            $reality = $data['data']['grow_summary']['reality'];
            $options = $data['data']['grow_summary']['options'];
            $option_list = '<ul>';
            foreach ($options as $option) {
                $option_list .= '<li>' . $option . '</li>';
            }
            $option_list .= '</ul>';
            $will_action_plan = $data['data']['grow_summary']['will_action_plan'];
            $will_list = '<ul>';
            foreach ($will_action_plan as $will) {
                $will_list .= '<li>' . $will . '</li>';
            }
            $will_list .= '</ul>';
            $commitment = $data['data']['grow_summary']['commitment'];
            $komitmen_list = '<ul>';
            foreach ($commitment as $komitmen) {
                $komitmen_list .= '<li>' . $komitmen . '</li>';
            }
            $komitmen_list .= '</ul>';
            $key_takeaways = $data['data']['analysis']['key_takeaways'];
            $note_list = '<ul>';
            foreach ($key_takeaways as $note) {
                $note_list .= '<li>' . $note . '</li>';
            }
            $note_list .= '</ul>';
            $main_issue_highlight = $data['data']['analysis']['main_issue_highlight'];
            $percentage_burnout = $data['data']['analysis']['rasio_potensi_burnout'];
            $reasoning = $data['data']['analysis']['burnout_risk_indicators'];
            $reasoning_list = '<ul>';
            foreach ($reasoning as $reason) {
                $reasoning_list .= '<li>' . $reason . '</li>';
            }
            $reasoning_list .= '</ul>';
            $root_cause_hypothesis = $data['data']['analysis']['root_cause_hypothesis'];

            $data_update = array(
                'review_problem' => $review_problem,
                'goals' => $goal,
                'reality' => $reality,
                'option' => $option_list,
                'will' => $will_list,
                'komitmen' => $komitmen_list,
                'key_takeaways' => $note_list,
                'main_issue_highlight' => $main_issue_highlight,
                'percentage_burnout' => $percentage_burnout,
                'reasoning_burnout' => $reasoning_list,
                'root_cause_hypothesis' => $root_cause_hypothesis,
                'status' => 1
            );

            $update = $this->model->update_counselling($session_id, $data_update);
            if (!$update) {
                echo json_encode(array('status' => 'failed', 'message' => 'Gagal mengakhiri sesi'));
                return;
            }
        }

        echo json_encode($data['data']);
    }


    function update_evaluation_manual()
    {
        // $api_key = $this->input->get_request_header('x-api-key', TRUE);
        // if ($api_key !== 'n8nAgenticCounseling$123') {
        //     echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
        //     return;
        // }

        // Ambil raw input JSON
        $json = file_get_contents('php://input');

        // Decode ke array
        $data = json_decode($json, true);
        // [
        //     {
        //         "session_metadata": {
        //         "session_id": "AC2511280006",
        //         "session_date": "28 Nov 2025",
        //         "employee_name": "Aris Setiana",
        //         "role": "IT Programmer Officer",
        //         "department": "Innovation & System Development",
        //         "review_problem": "Work-Life Balance"
        //         },
        //         "grow_summary": {
        //         "goal": "Mengelola waktu lebih baik dan membangun alur kerja yang lebih terstruktur agar tidak keteteran saat user meminta revisi cepat dalam 2–4 minggu ke depan.",
        //         "reality": "Workload internal sedang tinggi. Requirement user sering berubah dan muncul permintaan revisi mendadak sehingga terjadi frequent task switching (dari modul A ke modul B yang dianggap urgent). Upaya membuat task list harian belum konsisten dipakai karena sering terinterupsi oleh request baru. Tantangan utama: manajemen waktu dan prioritas yang belum disepakati lintas user.",
        //         "options": "- Menyepakati sistem prioritas tugas dengan user dan atasan.\n- Meminta waktu minimum/buffer sebelum revisi dilakukan agar task berjalan bisa diselesaikan.\n- Membuat dashboard task yang dapat diakses user dan atasan untuk transparansi status dan antrian pekerjaan.",
        //         "will_action_plan": "- Mulai besok, mengusulkan aturan prioritas yang jelas di grup tim.\n- Meminta user mengikuti alur prioritas yang disepakati.\n- Menjelaskan dampak bila ada permintaan cepat di luar alur agar hasil lebih konsisten.",
        //         "commitment": "- Akan memulai implementasi besok.\n- Berkomitmen menyosialisasikan aturan prioritas ke user dan atasan.\n- Siap mengedukasi user tentang dampak permintaan mendadak.\n- Tingkat keyakinan untuk menjalankan rencana: 8/10."
        //         },
        //         "analysis": {
        //         "key_takeaways": "- Pentingnya prioritas bersama lintas user dan atasan.\n- Perlunya komunikasi yang lebih jelas terkait alur dan dampak permintaan mendadak.\n- Rencana konkret untuk mulai besok dengan usulan aturan prioritas.\n- Transparansi pekerjaan (mis. dashboard) dinilai membantu sebagai solusi jangka menengah.",
        //         "main_issue_highlight": "Frequent task switching akibat permintaan mendadak dan requirement yang berubah-ubah membuat manajemen waktu tidak efektif.",
        //         "burnout_risk_indicators": [
        //             "Menyebut workload cukup tinggi",
        //             "Sering switching task karena permintaan mendadak/urgent",
        //             "Kesulitan menjaga konsistensi rencana harian karena interupsi",
        //             "Tekanan untuk cepat melakukan revisi"
        //         ],
        //         "root_cause_hypothesis": "Akar masalah kemungkinan terkait belum adanya kesepakatan prioritas dan alur permintaan dengan user, ditambah perubahan requirement yang sering, yang memicu task switching dan mengganggu struktur kerja serta manajemen waktu."
        //         }
        //     }
        //     ]

        $data = $this->db->query("SELECT * FROM coaching_session WHERE id_coaching='CC2601190003'")->row_array();

        $session = json_decode($data['session_metadata'], true);
        $session_id = $session['session_id'];
        $grow_summary = json_decode($data['grow_summary'], true);
        $analysis = json_decode($data['analysis'], true);

        if ($session_id) {
            $review_problem = $session['review_problem'];
            $goal = $grow_summary['goal'];
            $reality = $grow_summary['reality'];
            $options = $grow_summary['options'];
            $option_list = '<ul>';
            foreach ($options as $option) {
                $option_list .= '<li>' . $option . '</li>';
            }
            $option_list .= '</ul>';
            $will_action_plan = $grow_summary['will_action_plan'];
            $will_list = '<ul>';
            foreach ($will_action_plan as $will) {
                $will_list .= '<li>' . $will . '</li>';
            }
            $will_list .= '</ul>';
            $commitment = $grow_summary['commitment'];
            $komitmen_list = '<ul>';
            foreach ($commitment as $komitmen) {
                $komitmen_list .= '<li>' . $komitmen . '</li>';
            }
            $komitmen_list .= '</ul>';
            $key_takeaways = $analysis['key_takeaways'];
            $note_list = '<ul>';
            foreach ($key_takeaways as $note) {
                $note_list .= '<li>' . $note . '</li>';
            }
            $note_list .= '</ul>';
            $main_issue_highlight = $analysis['main_issue_highlight'];
            $percentage_burnout = $analysis['rasio_potensi_burnout'];
            $reasoning = $analysis['burnout_risk_indicators'];
            $reasoning_list = '<ul>';
            foreach ($reasoning as $reason) {
                $reasoning_list .= '<li>' . $reason . '</li>';
            }
            $reasoning_list .= '</ul>';
            $root_cause_hypothesis = $analysis['root_cause_hypothesis'];

            $data_update = array(
                'review_problem' => $review_problem,
                'goals' => $goal,
                'reality' => $reality,
                'option' => $option_list,
                'will' => $will_list,
                'komitmen' => $komitmen_list,
                'key_takeaways' => $note_list,
                'main_issue_highlight' => $main_issue_highlight,
                'percentage_burnout' => $percentage_burnout,
                'reasoning_burnout' => $reasoning_list,
                'root_cause_hypothesis' => $root_cause_hypothesis,
                'status' => 1
            );

            echo json_encode([
                'session_id' => $session_id,
                'data' => $data_update,
            ]);
            return;

            // $update = $this->model->update_counselling($session_id, $data_update);
            if (!$update) {
                echo json_encode(array('status' => 'failed', 'message' => 'Gagal mengakhiri sesi'));
                return;
            }
        }

        echo json_encode($data['data']);
    }


    function insert_advisor()
    {
        $api_key = $this->input->get_request_header('x-api-key', TRUE);
        if ($api_key !== 'n8nAgenticCounseling$123') {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            return;
        }

        // Ambil raw input JSON
        $json = file_get_contents('php://input');

        // Decode ke array
        $data = json_decode($json, true);

        $session_id = $data['session']['session_metadata']['session_id'];
        $strategic_recommendations = $data['data']['strategic_recommendations'];
        $action_plan = $data['data']['action_plan'];
        $recommended_resources = $data['data']['recommended_resources'];
        $disclaimer = $data['data']['disclaimer'];

        $insert_advisor = $this->model->insert_session_coaching_advisor($session_id, $strategic_recommendations, $action_plan, $recommended_resources, $disclaimer);
        if (!$insert_advisor) {
            echo json_encode(array('status' => 'failed', 'message' => 'Gagal menyimpan advisor'));
            return;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Advisor berhasil disimpan'));
        return;
    }
}
