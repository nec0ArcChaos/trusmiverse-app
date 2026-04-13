<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('complaints/model_main', 'model_main');
        $this->load->helper('hashids');
        $this->load->helper('security_helper');
    }

    public function index()
    {
        redirect('login', 'refresh');
    }

    public function view($id_task)
    {
        $data['pageTitle'] = "Complaints";
        $data['id_task'] = $id_task;
        // $is_konsumen = $this->model_main->is_konsumen($id_task);
        // if ($is_konsumen == 1) {
        // $this->session->set_userdata('user_id', '5428');
        // $this->load->view('complaints/detail_timeline', $data);
        // } else {
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id_complaints = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'complaints/detail/view/' . $id_complaints,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
        $this->load->view('complaints/detail', $data);
        // }
    }

    public function view_customer($id_task)
    {
        $data['pageTitle'] = "Complaints";
        $data['id_task'] = $id_task;
        $id_task = hashids_decode($id_task);
        // check existing complaints
        $check_complaints = $this->db->get_where('cm_task', ['id_task' => $id_task])->row();
        if (!$check_complaints) {
            redirect('forbidden_access', 'refresh');
        }

        $is_konsumen = $this->model_main->is_konsumen($id_task);
        if ($is_konsumen == 1) {
            // $this->session->set_userdata('user_id', '5428');
            $this->load->view('complaints/detail_timeline', $data);
        } else {
            $this->load->view('complaints/detail_timeline', $data);
        }
    }


    public function get_detail_task()
    {
        $id_task = $this->input->post('id_task') ?? "";
        $response['detail'] = "";
        $response['status'] = false;
        if ($id_task != "") {
            $id_task = hashids_decode($id_task);
            $response['detail'] = $this->model_main->get_detail_task($id_task);
            $response['status'] = true;
        }
        echo json_encode($response);
    }

    function get_attachment()
    {
        $id_task = $_POST['id_task'];
        $id_task = hashids_decode($id_task);
        $response['attachment'] = $this->model_main->get_attachment($id_task);
        echo json_encode($response);
    }


    public function view_customer_dev($id_task)
    {
        $data['pageTitle'] = "Complaints";
        $data['id_task'] = $id_task;
        $is_konsumen = $this->model_main->is_konsumen($id_task);
        if ($is_konsumen == 1) {
            // $this->session->set_userdata('user_id', '5428');
            $this->load->view('complaints/detail_timeline_dev', $data);
        } else {
            $this->load->view('complaints/detail_timeline_dev', $data);
        }
    }

    function send_feedback()
    {

        $raw_input = $this->input->post();

        $is_xss = false;
        foreach ($raw_input as $key => $value) {
            if (is_xss_attempt($value)) {
                $is_xss = true;
                // echo "XSS detected in field: " . $key;
                // return;
                break;
            }
        }


        if ($is_xss) {
            $ip = $this->input->ip_address();
            $user_agent = $this->input->user_agent();
            $client_ip = $_SERVER['REMOTE_ADDR'];
            $uri = uri_string();
            $payload = json_encode($raw_input);

            // Path untuk menyimpan log
            $logPath = APPPATH . 'logs/xss_log/';
            // Nama file log
            $filePath = $logPath . 'xss_attack_log-' . date('Y-m-d') . '.log';
            // Format pesan log
            $formattedMessage = '[' . date('Y-m-d H:i:s') . '] XSS Attempt from IP: ' . $ip . ' | Client IP: ' . $client_ip . ' | UA: ' . $user_agent . ' | URI: ' . $uri . ' | PAYLOAD: ' . $payload . PHP_EOL;
            // Simpan log ke file
            file_put_contents($filePath, $formattedMessage, FILE_APPEND);
            echo json_encode([
                'status' => false,
                'message' => 'Malicious input detected. Your action has been logged.'
            ]);
            exit;
        }

        $id_task = $this->input->post('id_task');
        $id_task = hashids_decode($id_task);
        // check existing complaints
        $check_complaints = $this->db->get_where('cm_task', ['id_task' => $id_task])->row();
        if (!$check_complaints) {
            $response['status'] = false;
            $response['message'] = "Complaints not found.";
            echo json_encode($response);
            return;
        }

        $respons = $this->input->post('respons');
        // $pelayanan = $this->input->post('pelayanan');
        $kualitas = $this->input->post('kualitas');
        $rekomendasi = $this->input->post('rekomendasi');
        $feedback = $this->input->post('feedback');

        $data = [
            'id_task' => $id_task,
            'respons' => strip_tags($respons),
            // 'pelayanan' => $pelayanan,
            'kualitas' => strip_tags($kualitas),
            'rekomendasi' => strip_tags($rekomendasi),
            'feedback' => strip_tags($feedback),
            'avg_rating' => ROUND(($respons + $rekomendasi + $kualitas) / 3, 1),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $check_rating = $this->db->get_where('cm_rating', ['id_task' => $id_task])->row();
        if ($check_rating) {
            $this->db->where('id_task', $id_task)->update('cm_rating', $data);
        } else {
            $this->db->insert('cm_rating', $data);
        }
        $result = $this->db->affected_rows();
        $response = [];
        if ($result) {
            $response['status'] = true;
            $response['message'] = "Feedback sent successfully!";
        } else {
            $response['status'] = false;
            $response['message'] = "Failed to send feedback.";
        }

        echo json_encode($response);
    }


    function get_log_history_timeline()
    {
        $id_task = $_POST['id_task'];
        $id_task = hashids_decode($id_task);
        $response['log'] = $this->model_main->get_log_history_timeline($id_task);
        echo json_encode($response);
    }
}
