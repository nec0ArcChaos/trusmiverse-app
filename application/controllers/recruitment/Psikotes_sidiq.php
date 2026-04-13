<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Psikotes_sidiq extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_psikotes', 'model');
        $this->load->model('recruitment/Model_psikotes_sidiq', 'model_dev');
        $this->load->model("model_profile");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Interview HR DEV";
        $data['css']              = "recruitment/psikotes_sidiq/css";
        $data['js']               = "recruitment/psikotes_sidiq/js";
        $data['content']          = "recruitment/psikotes_sidiq/index";

        $data['alasan']          = $this->model->get_alasan('Interview');

        $this->load->view('layout/main', $data);
    }
    function get_candidates()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $id = $_POST['id'];
        $tipe = $_POST['tipe'];
        $data['data'] = $this->model->get_candidates($start, $end, $id,$tipe);
        echo json_encode($data);
    }
    function detail_psikotes()
    {
        $id = $_POST['id'];
        $data['psikotes'] = $this->model->detail_psikotes($id);
        echo json_encode($data);
    }
    function get_loker()
    {
        $data['loker'] = $this->model->get_loker();
        echo json_encode($data);
    }
    function get_psikotes()
    {
        $id = $_POST['id'];
        $data['psikotes'] = $this->model->get_psikotes($id);
        echo json_encode($data);
    }
    function reset_tiu()
    {
        $id = $_POST['id'];
        $this->db->where('application_id', $id);
        $result['job_app'] = $this->db->update('xin_job_applications', array('status_tiu' => NULL));
        $result['tiu'] = [];
        if ($result) {
            $data = $this->model->get_tiu($id);
            foreach ($data as $row) {
                $id_tiu = $row->id_tiu;
                $this->db->where('id_tiu', $id_tiu);
                $result['tiu'] = $this->db->delete(array('trusmi_tiu_trx', 'trusmi_tiu_trx_detail'));
            }
            // $this->reset_tiu_talent_pool($id_user);
        }
        echo json_encode($result);
    }
    function save_status()
    {
        $psikotes = [
            'application_id'         => $_POST['app_id'],
            'application_status'     => $_POST['status'],
            'iq'                     => $_POST['score'],
            'disc1'                 => $_POST['disc1'],
            'disc2'                 => $_POST['disc2'],
            'disc3'                 => $_POST['disc3'],
            'keterangan'             => $_POST['keterangan'],
            'created_by'             => $this->session->userdata('user_id'),
            'created_at'             => date('Y-m-d H:i:s')
        ];

        $query = $this->db->get_where('trusmi_psikotes', array('application_id' => $_POST['app_id']));
        $result['psikotes'] = '';
        if ($query->num_rows() > 0) {
            $this->db->where('application_id', $_POST['app_id']);
            $result['psikotes'] = $this->db->update('trusmi_psikotes', $psikotes);
        } else {
            $result['psikotes'] = $this->db->insert('trusmi_psikotes', $psikotes);
        }        

        if ($_POST['status'] == 4) {
            $alasan = $_POST['select_alasan'];
        } else {
            $alasan = null;
        }

        // addnew
        $user_interview = $this->model->get_data_interview($_POST['app_id'])->num_rows();
        $id_user_interview = '';
        if ($user_interview) {
            $dt_user_interview = $this->model->get_data_interview($_POST['app_id'])->row_array();
            $id_user_interview = $dt_user_interview['user_id'];
        }

        $psikotes2 = [
            'application_status'     => $_POST['status'],
            'alasan_gagal_join'      => $alasan,
            'job_id'                 => $_POST['loker'],
            'job_id_before'          => $_POST['job_id_before'],
            // addnew
            'deadline_feedback'     => date('Y-m-d', strtotime('+1 day')), // h+1 dari update status psikotes
            'user_interview'        => $id_user_interview
        ];

        $this->db->where('application_id', $_POST['app_id']);
        $result['update'] = $this->db->update('xin_job_applications', $psikotes2);
        $result['wa'] = false;
        if ($_POST['status'] == 3) {
            $this->send_wa_interview($_POST['app_id']);

            // addnew
            // $user_interview = $this->model->get_data_interview($_POST['app_id'])->num_rows();
            // if ($user_interview) {
            //     $dt_user_interview = $this->model->get_data_interview($_POST['app_id'])->row_array();

            //     $update_psikotes = [
            //         'deadline_feedback' => date('Y-m-d', strtotime('+1 day')), // h+1 dari update status psikotes
            //         'user_interview' => $dt_user_interview['user_id']
            //     ];
            //     $this->db->where('application_id', $_POST['app_id']);
            //     $this->db->update('trusmi_psikotes', $update_psikotes);
            // }
        }
        echo json_encode($result);
    }
    function send_wa_interview($id)
    {
        $interview = $this->model->get_data_interview($id)->num_rows();
        if ($interview > 0) {
            $data_msg = $this->model->get_data_interview($id)->row_array();
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2507194023",
                "phone" => $data_msg['contact_no'],
                // "phone" => "6282316041423",
                "messageType" => "text",
                "body" => "👤Alert!!! 

*Konfirmasi Interview Kandidat*

📍Posisi : *" . $data_msg['job_title'] . "*
👤Kandidat : " . $data_msg['full_name'] . "
📅Tanggal Tutup : " . $data_msg['tgl'] . "
👨‍🎓Pendidikan : " . $data_msg['pendidikan'] . "
⌛Pengalaman : " . $data_msg['masa_kerja_terakhir'] . "
🧠Psikotes : " . $data_msg['iq'] . "
🤔DISC : " . $data_msg['disc'] . "
📑Keterangan : " . $data_msg['keterangan'] . "
📝Detail Kandidat : https://trusmiverse.com/apps/recruitment/interview/detail/" . $data_msg['application_id'] . "#step-1

Terdapat pengajuan rekomendasi interview user dengan : 

👤User : " . $data_msg['user'] . "

*Note : Wajib melakukan feedback H+1 dari notifikasi ini, jika tidak maka akan ter lock absen*",
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

            $context_text   = stream_context_create($options_text);
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);
        }
    }
    public function reset_tiu_talent_pool($id_user){
            $user = $this->db->query("SELECT * FROM talent_pool.t_tiu WHERE id_user = '$id_user'")->row_object();
            if($user != null){
                $query = "DELETE FROM talent_pool.t_tiu WHERE id_tiu = '$user->id_tiu';";
                $query2 = "DELETE FROM talent_pool.t_tiu_detail WHERE id_tiu = '$user->id_tiu'";
                $this->db->query($query,$query2);
            }
        }
}
