<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_approval extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_trusmi_approval', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/js";
        $data['content']          = "trusmi_approval/index";
        // $data['approve_to']       = $this->get_approve_to_php();
        $this->load->view('layout/main', $data);
    }

    // public function cron()
    // {
    //     $this->load->view('trusmi_approval/cront_job_follow_up_trusmi_approval.php');
    // }

    public function dt_trusmi_approval()
    {
        $id_status = $this->input->post('id_status');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $data['data'] = $this->model->dt_trusmi_approval($id_status, $start, $end)->result();
        echo json_encode($data);
        // $department_id = $this->session->userdata('department_id');
        // $user_id = $this->session->userdata('user_id');
        // $user_role_id = $this->session->userdata('user_role_id');
        // echo ($department_id);
        // echo '<br>';
        // echo ($user_id);
        // echo '<br>';
        // echo ($user_role_id);
    }

    public function get_trusmi_approval_by_no_app()
    {
        $no_app = $this->input->post('no_app');
        $data = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        echo json_encode($data);
    }

    public function upload_file()
    {
        $string = $_POST['string'];
        define('UPLOAD_DIR', './uploads/trusmi_approval/temp/');

        $string     = explode(',', $string);
        $img        = str_replace(' ', '+', $string[1]);
        $data       = base64_decode($img);
        $name       = uniqid() . '.' . $string[0];
        $file       = UPLOAD_DIR . $name;
        $success    = file_put_contents($file, $data);

        echo $name;
    }

    public function save()
    {
        // Kelola Image / File
        if ($_POST['string_file_1'] == '') {
            $file_1 = NULL;
        } else {
            $file_1 = $_POST['string_file_1'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_1'], 'uploads/trusmi_approval/' . $_POST['string_file_1']);
        }
        if ($_POST['string_file_2'] == '') {
            $file_2 = NULL;
        } else {
            $file_2 = $_POST['string_file_2'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_2'], 'uploads/trusmi_approval/' . $_POST['string_file_2']);
        }

        $no_app = $this->model->no_app();

        $request = array(
            'no_app'            => $no_app,
            'subject'           => $_POST['subject'],
            'description'       => $_POST['description'],
            'approve_to'        => $_POST['approve_to'],
            'kategori'          => $_POST['kategori'],
            'nominal'           => $_POST['nominal'],
            'file_1'            => $file_1,
            'file_2'            => $file_2,
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->userdata('user_id')
        );

        $result['request_approval'] = $this->model->save($request);
        $this->send_notif_approval($no_app);
        // $query_data = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        // $result['no_app'] = $no_app;
        // $result['user_id_approve_to'] = $query_data->user_id_approve_to;
        // $result['approve_to'] = $query_data->approve_to;
        // $result['kategori'] = $query_data->kategori;
        // $result['nominal'] = $query_data->nominal;
        // $result['created_by'] = $query_data->created_by;
        // $result['created_at'] = $query_data->created_at;
        // $result['created_hour'] = $query_data->created_hour;
        // $result['leadtime'] = $query_data->leadtime;
        // $result['subject'] = $query_data->subject;
        // $result['description'] = $query_data->description;

        echo json_encode($result);
    }


    public function reject()
    {
        $no_app = $this->input->post('no_app');
        if ($no_app) {
            $data = array(
                'status'            => 3,
                'approve_note'      => $_POST['approve_note'],
                'approve_at'        => date('Y-m-d H:i:s'),
                'approve_by'        => $this->session->userdata('user_id')
            );
            $result['request_approval'] = $this->db->where('no_app', $no_app)->update('trusmi_approval', $data);
            $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            $result['no_app'] = $request->no_app;
            $result['subject'] = $request->subject;
            $result['user_id_approve_to'] = $request->user_id_approve_to;
            $result['description'] = $request->description;
            $result['created_by_contact'] = $request->created_by_contact;
            $result['created_by'] = $request->created_by;
            $result['created_at'] = $request->created_at;
            $result['created_hour'] = $request->created_hour;
            $result['approve_to'] = $request->approve_to;
            $result['kategori'] = $request->kategori;
            $result['nominal'] = $request->nominal;
            $result['approve_note'] = $_POST['approve_note'];
        } else {
            $result['approve_note'] = '';
            $result['request_approval'] = false;
        }
        echo json_encode($result);
    }

    public function approve()
    {
        $no_app = $this->input->post('no_app');
        if ($no_app) {
            $data = array(
                'status'            => 2,
                'approve_note'      => $_POST['approve_note'],
                'approve_at'        => date('Y-m-d H:i:s'),
                'approve_by'        => $this->session->userdata('user_id')
            );
            $result['request_approval'] = $this->db->where('no_app', $no_app)->update('trusmi_approval', $data);
            $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            $result['no_app'] = $request->no_app;
            $result['subject'] = $request->subject;
            $result['description'] = $request->description;
            $result['created_by_contact'] = $request->created_by_contact;
            $result['created_by'] = $request->created_by;
            $result['created_at'] = $request->created_at;
            $result['created_hour'] = $request->created_hour;
            $result['approve_to'] = $request->approve_to;
            $result['kategori'] = $request->kategori;
            $result['nominal'] = $request->nominal;
            $result['approve_note'] = $_POST['approve_note'];
        } else {
            $result['approve_note'] = '';
            $result['request_approval'] = false;
        }
        echo json_encode($result);
    }

    function get_approve_to_php()
    {
        $data = $this->db->query("SELECT
        CONCAT(
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ),
            ' | ',
            xin_companies.alias 
        ) AS full_name,
        xin_employees.user_id AS `user_id` 
    FROM
        xin_employees
        JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id 
    WHERE
        xin_employees.is_active = 1 
        AND xin_employees.user_role_id IN (1,2,3,4,5,10,11,12)")->result();

        return $data;
    }

    function get_approve_to()
    {
        $data = $this->db->query("SELECT
        CONCAT(
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ),
            ' | ',
            xin_companies.alias,
            ' | ',
            xin_departments.department_name 
        ) AS full_name,
        xin_employees.user_id AS `user_id`,
        xin_employees.contact_no,
        xin_employees.username
    FROM
        xin_employees
        JOIN xin_companies ON xin_employees.company_id = xin_companies.company_id
        JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id 
    WHERE
        xin_employees.is_active = 1 AND xin_employees.user_id != 1
        AND (xin_employees.user_role_id IN (1,2,3,4,5,6,10,11,12) OR xin_employees.department_id = 68 OR xin_employees.user_id = 1287)")->result();

        echo json_encode($data);
    }

    function verify_approval()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/verify_approval_js";
        $data['content']          = "trusmi_approval/verify_approval";
        $this->load->view('layout/main', $data);
    }

    function verify_approval_dev()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/verify_approval_dev_js";
        $data['content']          = "trusmi_approval/verify_approval_dev";
        $this->load->view('layout/main', $data);
    }

    function eaf_approval()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/eaf_approval_js";
        $data['content']          = "trusmi_approval/eaf_approval";

        $data['pengaju'] 		=  $this->model->get_pengaju_eaf()->result();
		$data['kategori'] 		=  $this->model->get_kategori_eaf()->result();
		$data['jenis_biaya'] 	=  $this->model->jenis_biaya_eaf()->result();
		$data['tipe'] 			=  1;
		$data['project'] 		=  $this->model->get_project_eaf();
        $data['id_hr'] 		    =  $this->session->userdata('user_id');
        $this->load->view('layout/main', $data);
    }

    function resend_wa()
    {
        $no_app = $this->input->post("no_app");
        $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
        $result['no_app'] = $request->no_app;
        $result['subject'] = $request->subject;
        $result['description'] = $request->description;
        $result['created_by_contact'] = $request->created_by_contact;
        $result['created_by'] = $request->created_by;
        $result['created_at'] = $request->created_at;
        $result['created_hour'] = $request->created_hour;
        $result['approve_to_user_id'] = $request->approve_to_user_id;
        $result['approve_to'] = $request->approve_to;
        $result['kategori'] = $request->kategori;
        $result['nominal'] = $request->nominal;
        $result['approve_to_contact'] = $request->approve_to_contact;
        $result['approve_to_username'] = $request->approve_to_username;
        $result['id_status'] = $request->id_status;
        $result['keterangan'] = $request->keterangan;
        $result['leadtime'] = $request->leadtime;
        echo json_encode($result);
    }
    function resubmit()
    {
        $old_no_app = $this->input->post('old_no_app');
        $subject = $this->input->post('subject');
        $tipe = $this->input->post('tipe');
        $description = $this->input->post('description');
        $approve_to = $this->input->post('id_approve_to');
        $kategori = $this->input->post('kategori');
        $nominal = $this->input->post('nominal');
        // Kelola Image / File
        if ($_POST['string_file_1'] == '') {
            $file_1 = NULL;
        } else {
            $file_1 = $_POST['string_file_1'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_1'], 'uploads/trusmi_approval/' . $_POST['string_file_1']);
        }
        if ($_POST['string_file_2'] == '') {
            $file_2 = NULL;
        } else {
            $file_2 = $_POST['string_file_2'];
            rename('uploads/trusmi_approval/temp/' . $_POST['string_file_2'], 'uploads/trusmi_approval/' . $_POST['string_file_2']);
        }
        $no_app = $this->model->no_app();

        $request = array(
            'no_app'            => $no_app,
            'subject'           => '('.$tipe.') '.$subject,
            'description'       => $description,
            'approve_to'        => $approve_to,
            'kategori'          => $kategori,
            'nominal'           => $nominal ?? 0,
            'file_1'            => $file_1,
            'file_2'            => $file_2,
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => $this->session->userdata('user_id'),
            'old_no_app'=>$old_no_app
        );

        $result['request_approval'] = $this->model->save($request);
        $data = $this->model->get_trusmi_approval_by_no_app($no_app)->row_object();
        echo json_encode($data);
    }

    function get_blok_new_eaf()
	{
		$id 	= @$_POST['id_project'];
		$type 	= @$_POST['type'];
		$jenis 	= $_POST['id_jenis'];
		$blok 	= $_POST['blok'];

		$data = $this->model->get_blok_eaf(@$id, @$type, $jenis);
		// echo json_encode($data);

		echo '<option data-placeholder="true" disabled>- Pilih Blok -</option>';
        if (is_array($data) && count(@$data) > 0) {
            foreach ($data as $row) {
                echo '<option value="' . $row->blok . '">' . $row->blok . '</option>';
            }
        }

		if (is_array($blok) && isset($blok) || $blok != "") {
            for ($i = 0; $i < count(@$blok); $i++) {
                echo '<option value="' . $blok[$i] . '">' . $blok[$i] . '</option>';
            }
        }
	}

    function cek_dlk_new_eaf($id_hr)
	{
		$cek = $this->model->cek_dlk_new_eaf($id_hr);

		if ($cek->num_rows() > 0) {
			$dlk = $cek->result();

			foreach ($dlk as $row) {
				$jenis_biaya = $this->model->jenis_biaya_dlk_new($row->department_id)->row_array();
				if (!empty($jenis_biaya)) {
					echo '<option value="' . $jenis_biaya['id_jenis'] . '|' . $jenis_biaya['id_biaya'] . '|' . $jenis_biaya['jenis'] . '|' . $jenis_biaya['id_user_approval'] . '|' . $jenis_biaya['id_tipe_biaya'] . '|' . $jenis_biaya['budget'] . '|' . $jenis_biaya['project'] . '|' . $jenis_biaya['blok'] . '|' . $jenis_biaya['id_user_verified'] . '|' . $row->leave_id . '-' . $row->total_eaf . '-' . $row->reason . '" class="dlk_makan">' . $jenis_biaya['jenis'] .  ' (' . $row->total_makan . 'x makan di ' . $row->kota . ' dari ' . $row->from_date . ' ' . substr($row->start_time, 0, 5) . ' sampai ' . $row->to_date . ' ' . substr($row->end_time, 0, 5) . ') (' . $jenis_biaya['employee'] . ')' . '</option>';
				}
			}
		} else {
			echo "tidak ada";
		}
	}

    function pengajuan_eaf()
    {
        $data = "";
        foreach ($_POST as $key => $value) {
            $data .= $key . "=" . $value . "&";
        }
        $signature = md5($data . "eaf_trusmiverse_rsp");
        
        $arr_data = array();
        foreach ($_POST as $key => $value) {
            $arr_data[$key] = $value;
        }
        $arr_data['signature'] = $signature;
        
        $url = "https://trusmicorp.com/rspproject/eaf/pengajuan_api/insert_pengajuan";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response, true);

        $this->db->where('no_app', $_POST['no_app'])->update('trusmi_approval', array(
            'id_eaf' => $res['id_pengajuan']['id_pengajuan']
        ));

        echo $response;
    }

    // addnew integrate Memo ke RSP
    function integrate_approval()
    {
        if (isset($_GET['id'])) {
            $no_app = $_GET['id'];
            $query = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
            if ($query) {
                $data['data'] = $query;
            }
        }
        $data['pageTitle']        = "T-Approval";
        $data['css']              = "trusmi_approval/css";
        $data['js']               = "trusmi_approval/integrate_approval_js";
        $data['content']          = "trusmi_approval/integrate_approval";

        $data['companies'] = $this->db->query("SELECT * FROM xin_companies")->result();
        $data['roles'] = $this->db->query("SELECT * FROM xin_user_roles")->result();
        $this->load->view('layout/main', $data);
    }

    function get_divisi()
    {
        $query = "SELECT * FROM rsp_project_live.m_divisi";

        $data['divisi'] = $this->db->query($query)->result();

        echo json_encode($data);
    }

    function get_jabatan()
    {
        $data['jabatan'] = $this->db->query("SELECT * FROM xin_user_roles")->result();
        echo json_encode($data);
    }

    function send_wa($phone, $msg, $user_id = '')
    {
        try {
            $this->load->library('WAJS');
            return $this->wajs->send_wajs_notif($phone, $msg, 'text', 'trusmiverse', $user_id);
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }

    function send_notif_approval($no_app)
    {
        try {
            $request = $this->model->get_trusmi_approval_by_no_app($no_app)->row();
 
            if (!$request || empty($request->approve_to_contact)) {
                return;
            }
 
            // // Format nomor HP ke 62xxx
            // $filter_plus = str_replace('+', '', $request->approve_to_contact);
            // $filter_min  = str_replace('-', '', $filter_plus);
            // $filter_nol  = ltrim($filter_min, '0');
            // $phone       = "62" . $filter_nol;
            $phone = $request->approve_to_contact;
            $msg = "📣 Alert!!!
*There is New Request Approval*\n\n"
                 . "📝 Approve To   : *{$request->approve_to}*\n"
                 . "👤 Requested By : *{$request->created_by}*\n"
                 . "🕐 Requested At : *{$request->created_at} | {$request->created_hour}*\n\n"
                 . "No. App     : *{$request->no_app}*\n"
                 . "Subject     : *{$request->subject}*\n"
                 . "Description : {$request->description}\n\n"
                 . "🌐 Link Approve :\n"
                 . "https://trusmiverse.com/apps/login/verify?u={$request->approve_to_user_id}&id={$request->no_app}";
            $response = $this->send_wa($phone, $msg, $request->approve_to_user_id);
            // echo $response;
            //this->send_wa($phone, $msg, $request->approve_to_user_id);
            
            
 
        } catch (\Throwable $th) {
            // Notifikasi gagal tidak memblokir proses utama
        }
    }

    function cron_follow_up()
    {
        $v_notif = $this->model->get_follow_up_notif();
        // print_r($v_notif);die();
        $results = [];
 
        // Konfigurasi tiap tahap FU: emoji, label teks, dan status DB berikutnya
        $fu_config = [
            'FU1' => ['emoji' => '🚨',     'label' => '1st follow-up', 'next_status' => 4],
            'FU2' => ['emoji' => '🚨🚨',   'label' => '2nd follow-up', 'next_status' => 5],
            'FU3' => ['emoji' => '🚨🚨🚨', 'label' => '3rd follow-up', 'next_status' => 6],
            'End' => ['emoji' => '❌❌❌', 'label' => "Time's up",     'next_status' => 7],
        ];
 
        foreach ($v_notif as $notif) {
 
            // Lewati jika belum waktunya follow-up
            if ($notif['ket_wa'] === 'DONE') {
                continue;
            }
 
            // // Format nomor HP ke 62xxx
            // $filter_plus = str_replace('+', '', $notif['approve_to_contact']);
            // $filter_min  = str_replace('-', '', $filter_plus);
            // $filter_nol  = ltrim($filter_min, '0');
            $phone       = $notif['approve_to_contact'];
 
            $cfg = $fu_config[$notif['ket_wa']];
 
            // Susun isi pesan WA (End berbeda karena arahkan ke resubmit)
            if ($notif['ket_wa'] === 'End') {
                $msg = "Alert!!! {$cfg['emoji']}\n"
                     . "*{$cfg['label']} ( {$notif['ket_wa']} )*\n"
                     . "📝 Approve To   : {$notif['approve_to']}\n"
                     . "👤 Requested By : {$notif['requested_by']}\n"
                     . "🕐 Requested At : {$notif['requested_at']} | {$notif['requested_hour']}\n"
                     . "⌛ Leadtime      : {$notif['leadtime']}\n\n"
                     . "No. App     : {$notif['no_app']}\n"
                     . "Subject     : *{$notif['subject']}*\n"
                     . "Description : {$notif['description']}\n\n"
                     . "🌐 Anda Bisa Melakukan Pengajuan Ulang melalui link:\n"
                     . "https://trusmiverse.com/apps/login/verify?u={$notif['approve_to_userid']}&id={$notif['no_app']}";
            } else {
                $msg = "Alert!!! {$cfg['emoji']}\n"
                     . "*{$cfg['label']} ( {$notif['ket_wa']} )*\n"
                     . "📝 Approve To   : {$notif['approve_to']}\n"
                     . "👤 Requested By : {$notif['requested_by']}\n"
                     . "🕐 Requested At : {$notif['requested_at']} | {$notif['requested_hour']}\n"
                     . "⌛ Leadtime      : {$notif['leadtime']}\n\n"
                     . "No. App     : {$notif['no_app']}\n"
                     . "Subject     : *{$notif['subject']}*\n"
                     . "Description : {$notif['description']}\n"
                     . "🌐 Link Approve :\n"
                     . "https://trusmiverse.com/apps/login/verify?u={$notif['approve_to_userid']}&id={$notif['no_app']}";
            }
 
            // Kirim WA via library WAJS
            $wa_result = $this->send_wa($phone, $msg, $notif['approve_to_userid']);
 
            // Update status di DB ke tahap berikutnya
            $this->db->where('no_app', $notif['no_app'])
                     ->update('trusmi_approval', ['status' => $cfg['next_status']]);
 
            $results[] = [
                'no_app'      => $notif['no_app'],
                'ket_wa'      => $notif['ket_wa'],
                'phone'       => $phone,
                'next_status' => $cfg['next_status'],
                'wa'          => $wa_result,
            ];
        }
 
        header('Content-Type: application/json');
        echo json_encode(['processed' => count($results), 'detail' => $results]);
    }
}
