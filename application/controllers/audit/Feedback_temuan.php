<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Feedback_temuan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_audit_temuan', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'fdbk-audit/' . $id,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    public function view($id)
    {
        // die();
        $data['pageTitle']          = "Feedback - Temuan Audit";
        $data['id']                 = $id;
        $data['status_feedback']    = $this->model->get_status_feedback();
        $data['status_corrective']  = $this->model->get_status_corrective();
        $data['status_preventive']  = $this->model->get_status_preventive();

        $this->load->view('audit_temuan/feedback/detail', $data);
    }

    public function get_detail_feedback()
    {
        $id = $_POST['id'];

        $result = $this->model->get_detail_feedback($id);
        echo json_encode($result);
    }

    public function save_feedback()
    {
        $id_temuan  = $_POST['id_temuan'];

        $feedback               = $_POST['feedback'];
        $status_feedback        = $_POST['status_feedback'];
        $attachment_feedback    = $_POST['attachment_feedback'];

        if ($status_feedback == 6) { // Banding
            $temuan = array(
                'feedback'              => $feedback,
                'status'                => $status_feedback,
                'lampiran_feedback'     => $attachment_feedback,
                'tanggal_tanggapan'     => date('Y-m-d H:i:s')
            );
        } else {

            $status_corrective      = $_POST['status_corrective'];
            $action_corrective      = $_POST['action_corrective'];
            $deadline_corrective    = $_POST['deadline_corrective'];
            $attachment_corrective  = $_POST['attachment_corrective'];

            $status_preventive      = $_POST['status_preventive'];
            $action_preventive      = $_POST['action_preventive'];
            $deadline_preventive    = $_POST['deadline_preventive'];
            $attachment_preventive  = $_POST['attachment_preventive'];

            $temuan = array(
                'feedback'              => $feedback,
                'status'                => $status_feedback,
                'lampiran_feedback'     => $attachment_feedback,
                'status_corrective'     => $status_corrective,
                'corrective'            => $action_corrective,
                'deadline_corrective'   => $deadline_corrective,
                'lampiran_corrective'   => $attachment_corrective,
                'status_preventif'      => $status_preventive,
                'preventif'             => $action_preventive,
                'deadline_preventif'    => $deadline_preventive,
                'lampiran_preventif'     => $attachment_preventive,
                'tanggal_tanggapan'     => date('Y-m-d H:i:s')
            );
        }


        $this->db->where("id_temuan", $id_temuan);
        $result['update'] = $this->db->update("audit_temuan", $temuan);

        echo json_encode($result);
    }

    function file_upload()
	{
		if (!defined('UPLOAD_DIR')) define('UPLOAD_DIR', './uploads/audit_temuan/');
		$string		= $_POST['file'];

		$string     = explode(',', $string);
		$img        = str_replace(' ', '+', $string[1]);
		$data       = base64_decode($img);
		$name       = uniqid() . '.' . $string[0];
		$file       = UPLOAD_DIR . $name;
		$success    = file_put_contents($file, $data);

		$files['file'] = $name;
		echo json_encode($files);
	}

}
