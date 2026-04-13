<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_rating_form extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('tickets/Model_review_rating_form', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'rr-frm/' . $id,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    public function view($id)
    {
        $data['pageTitle']          = "Review and Rating - Form";
        $data['id']                 = $id;
        $data['impact']             = $this->model->get_impact();

        $this->load->view('tickets/review_rating_form/detail', $data);
    }

    public function get_detail_feedback()
    {
        $id = $_POST['id'];

        $result = $this->model->get_detail_feedback($id);
        echo json_encode($result);
    }

    public function save_feedback()
    {
        $id_task                = $_POST['id_task'];
        $ekspektasi             = $_POST['ekspektasi'];
        $rating_kesesuaian      = $_POST['rating_kesesuaian'];
        $rating_uiux            = $_POST['rating_uiux'];
        $saran                  = $_POST['saran'];
        $kelengkapan_fitur      = $_POST['kelengkapan_fitur'];
        $kecepatan_akses        = $_POST['kecepatan_akses'];
        $impact                 = $_POST['list_impact'];

        $review = array(
            'id_task'               => $id_task,
            'ekspektasi'            => $ekspektasi,
            'rating_kesesuaian'     => $rating_kesesuaian,
            'rating_uiux'           => $rating_uiux,
            'saran'                 => $saran,
            'kelengkapan_fitur'     => $kelengkapan_fitur,
            'kecepatan_akses'       => $kecepatan_akses,
            'impact'                => $impact,
            'created_at'            => date('Y-m-d H:i:s'),
            'created_by'            => $_SESSION['user_id']
        );


        $result['insert'] = $this->db->insert("ticket_review", $review);

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
