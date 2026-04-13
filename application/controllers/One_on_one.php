<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class One_on_one extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_one_on_one', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 		= "one_on_one/index";
		$data['pageTitle'] 		= "One on One";
		$data['css'] 			= "one_on_one/css";
		$data['js'] 			= "one_on_one/js";
		$data['karyawan']		= $this->model->get_karyawan();
		$data['atasan']			= $this->model->get_atasan();
		$data['project']            = $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();
		// $data['project']      = $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project")->result();
		$this->load->view("layout/main", $data);
	}


	function save_one()
	{
		// $id				= $this->model->generate_id_coaching();
		$id				= $_POST['id_one_header'];
		$karyawan		= $_POST['karyawan'];
		$tempat			= $_POST['tempat'];
		$tanggal		= $_POST['tanggal'];
		$atasan			= $_POST['atasan'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$det = $this->model->get_detail_user($karyawan);

		$company_id		= $det['company_id'];
		$department_id	= $det['department_id'];
		$designation_id	= $det['designation_id'];
		$role_id		= $det['role_id'];

		if (!empty($_FILES['foto']['name'])) {
			// Proses unggah file
			$config['upload_path']   = './uploads/one_on_one/';
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
		$project = $this->input->post('project') ?? '';
        $pekerjaan = $this->input->post('pekerjaan') ?? '';
        $sub_pekerjaan = $this->input->post('sub_pekerjaan') ?? '';
        $detail_pekerjaan = $this->input->post('detail_pekerjaan');
        if (!isset($detail_pekerjaan) || empty($detail_pekerjaan)) {
            $detail_pekerjaan = null;
        } else {
            $detail_pekerjaan = implode(",", $detail_pekerjaan);
        }

		$data = array(
			"karyawan" 			=> $karyawan,
			"tempat" 			=> $tempat,
			"tanggal" 			=> $tanggal,
			"atasan" 			=> $atasan,
			"foto" 				=> $file_name,
			"company_id" 		=> $company_id,
			"department_id" 	=> $department_id,
			"designation_id" 	=> $designation_id,
			"role_id" 			=> $role_id,
			"created_at" 		=> $created_at,
			"created_by" 		=> $created_by,
			'divisi' => $project,
            'so' => $pekerjaan,
            'si' => $sub_pekerjaan,
            'tasklist' => $detail_pekerjaan,
		);

		$this->db->where("id_one", $id);
		$result['update_one'] = $this->db->update("one_header", $data);

		// Empat adalah jumlah Master
		for ($i=1; $i <= 4; $i++) {
			// Update Target dan Actual
			$cki = $this->model->check_indikator($id,$i);
			if ($cki < 1) {
				$indikator = [
					'id_one' => $id,
					'indikator' => $i,
					'target' => $_POST['target_'. $i],
					'actual' => $_POST['actual_'. $i],
					'created_at' => $created_at,
					'created_by' => $created_by
				];
				$result['insert_indikator'] = $this->db->insert('one_indikator', $indikator);
			} else {
				$indikator = [
					'target' => $_POST['target_'. $i],
					'actual' => $_POST['actual_'. $i],
					'created_at' => $created_at,
					'created_by' => $created_by
				];
				$this->db->where("id_one", $id);
				$this->db->where("indikator", $i);
				$result['update_indikator'] = $this->db->update('one_indikator', $indikator);
			}
		}

		echo json_encode($result);
	}

	function list_one()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$dt = $this->model->list_one($start, $end);

		foreach ($dt as $key => $val) {
			$hasil = "";
			// Mode New
			for ($x=1; $x <= 4; $x++) {
				$ind = $this->model->get_list_indikator($val->id_one,$x);
				// Kondisi 3:FU, 4:Ceklok
				if (in_array($x, [3,4])) {
					$hasil .= $x .". <b>". $ind['indikator'] . "</b> (" . $ind['actual']. "%/" .$ind['target'] ."%)<br>";
				} else {
					$hasil .= $x .". <b>". $ind['indikator'] . "</b> (" . $ind['actual']. "/" .$ind['target'] .")<br>";
				}

				// $itm = $this->model->get_list_indikator_item($val->id_one,$x);
				// $no = 1;
				// foreach ($itm as $row) {
				// 	$hasil .= "Identifikasi : ". $row->identifikasi ."<br> Solusi : ". $row->solusi ."<br> Target : ". $row->target_solusi ."<br> Deadline : ". $row->deadline_solusi ."<br> Komitmen : ". $row->komitmen ."<br><br>";
				// 	$no++;
				// }
			}
			
			$dt[$key]->indikator = $hasil;
		}

		$result['data'] = $dt;
		echo json_encode($result);
	}

	function test_list_one()
	{
		// $start 	= $_POST['start'];
		// $end 	= $_POST['end'];
		$dt = $this->model->list_one('2024-12-01', '2024-12-06');

		foreach ($dt as $key => $val) {
			$hasil = "";
			// Mode New
			for ($x=1; $x <= 4; $x++) {
				$ind = $this->model->get_list_indikator($val->id_one,$x);
				$hasil .= $x .". ". $ind['indikator'] . " (" . $ind['actual']. "/" .$ind['target'] .")\n";

				$itm = $this->model->get_list_indikator_item($val->id_one,$x);
				$no = 1;
				foreach ($itm as $row) {
					$hasil .= $no .". Identifikasi : ". $row->identifikasi ."\n Solusi : ". $row->solusi ."\n Target : ". $row->target_solusi ."\n Deadline : ". $row->deadline_solusi ."\n Komitmen : ". $row->komitmen;
					$no++;
				}
			}
			
			$dt[$key]->indikator = $hasil;
		}
		echo json_encode($dt);

		// $result['data'] = $dt;
		// echo json_encode($result);
	}

	// function get_atasan($dep_id)
	// {
	// 	$atasan = $this->model->get_atasan($dep_id);
	// 	$result = "";

	// 	$result = '<option value="#">-Choose Employee-</option>';
	// 	foreach ($atasan as $up) {
	// 		$result .= '<option value="'. $up->user_id .'">'. $up->employee_name .'</option>';
	// 	}

	// 	echo json_encode($result);
	// }

	function get_detail_mkt_rsp($id_hr)
	{
		$rsp 	= $this->model->get_id_rsp($id_hr);
		$id_rsp = $rsp['id_user'];

		$result = $this->model->get_detail_mkt_rsp($id_rsp);
		echo json_encode($result);
	}

	function save_indikator()
	{
		$id_indikator = $_POST['indikator_feedback'];
		$total_feedback = $_POST['total_feedback'];
		$created_at = date('Y-m-d H:i:s');
		$created_by = $_SESSION['user_id'];

		if ($_POST['id_one_feedback'] != '') {
			$id_one = $_POST['id_one_feedback'];
			$mode = 'update';
		} else {
			$id_one = $this->model->generate_id_one();
			$mode = 'insert';
		}

		$ckh = $this->model->check_header($id_one);
		if ($ckh < 1) {
			$header = [
				'id_one' => $id_one,
				'created_at' => $created_at,
				'created_by' => $created_by
			];
			$result['header'] = $this->db->insert('one_header', $header);
		}

		$cki = $this->model->check_indikator($id_one,$id_indikator);
		if ($cki < 1) {
			$indikator = [
				'id_one' => $id_one,
				'indikator' => $id_indikator,
				'target' => $_POST['target_indikator'],
				'actual' => $_POST['actual_indikator'],
				'created_at' => $created_at,
				'created_by' => $created_by
			];
			$result['indikator'] = $this->db->insert('one_indikator', $indikator);
		}

		$list_item = [];
		for ($i=0; $i < $total_feedback; $i++) { 
			$item = [
				'id_one' => $id_one,
				'indikator' => $id_indikator,
				'identifikasi' => $_POST['identifikasi'][$i],
				'solusi' => $_POST['solusi'][$i],
				'target_solusi' => $_POST['target_solusi'][$i],
				'deadline_solusi' => $_POST['deadline_solusi'][$i],
				'komitmen' => $_POST['komitmen'][$i],
				'created_at' => $created_at,
				'created_by' => $created_by
			];
			$list_item[] = $item;
		}
		$result['item'] = $this->db->insert_batch('one_indikator_item', $list_item);

		$result['id_one'] = $id_one;
		$result['id_indikator'] = $id_indikator;

		echo json_encode($result);
	}

	function get_list_feedback()
	{
		$id_one = $_POST['id_one'];
		$id_indikator = $_POST['id_indikator'];

		$data = $this->model->get_list_feedback($id_one, $id_indikator);
		echo json_encode($data);
	}

	function get_indikator_sales()
	{
		$user_id = $_POST['user_id'];
		$id_user = $_POST['id_user'];
		$designation_id = $_POST['designation_id'];

		$data = $this->model->get_indikator_sales($user_id, $designation_id, $id_user);
		echo json_encode($data);
	}

	function cancel_one()
	{
		$id_one = $_POST['id_one'];

		$this->db->where('id_one', $id_one);
		$result['delete_header'] = $this->db->delete('one_header');

		$this->db->where('id_one', $id_one);
		$result['delete_indikator'] = $this->db->delete('one_indikator');

		$this->db->where('id_one', $id_one);
		$result['delete_indikator_item'] = $this->db->delete('one_indikator_item');
		
		echo json_encode($result);
	}
	
	function get_resume()
	{
		$start = $_POST['start'];
		$end = $_POST['end'];

		$result['data'] = $this->model->get_resume($start, $end);
		echo json_encode($result);
	}
	
	function get_resume_sales()
	{
		$start = $_POST['start'];
		$end = $_POST['end'];

		$result['data'] = $this->model->get_resume_sales($start, $end);
		echo json_encode($result);
	}

	function get_pekerjaan($divisi)
    {
        // $data = $this->db->get_where('grd_m_so')->result();
        $divisi = urldecode($divisi);
        $query = "SELECT
            grd_m_so.id_so AS id,
            grd_m_so.so AS pekerjaan,
            CONCAT(' | ',grd_m_goal.nama_goal, ' | ',DATE_FORMAT( grd_m_so.created_at, '%b %Y' )) AS periode
        FROM
            `grd_m_so` 
            JOIN grd_m_goal ON grd_m_so.id_goal = grd_m_goal.id_goal
        WHERE
            grd_m_so.divisi = '$divisi'";
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }

	function get_sub_pekerjaan($pekerjaan)
    {
        $query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $pekerjaan";
        // $data = $this->db->get_where('m_sub_pekerjaan', ['id_pekerjaan' => $pekerjaan])->result();
        $data = $this->db->query($query)->result();
        echo json_encode($data);
    }
    function get_det_pekerjaan($id_sub_pekerjaan)
    {
        $query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
        $data = $this->db->query($query)->result();
        // $data = $this->db->query('t_detail_pekerjaan', ['id_sub_pekerjaan' => $id_sub_pekerjaan])->result();

        echo json_encode($data);
    }

}
