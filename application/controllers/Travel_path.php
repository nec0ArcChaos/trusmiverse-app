<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Travel_path extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_travel_path', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	// New
	function index()
	{
		$data['content'] 			= "travel_path/index";
		$data['pageTitle'] 			= "Travel Path";
		$data['css'] 				= "travel_path/css";
		$data['js'] 				= "travel_path/js";

		$this->load->view("layout/main", $data);
	}

	function list_path()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_path($start,$end);
		echo json_encode($result);
	}
	
	function get_result_path()
	{
		$id_path 	= $_POST['id_path'];

		$result['data'] = $this->model->get_result_path($id_path);
		echo json_encode($result);
	}

	function get_detail_travel_path()
	{
		$tp_id 		= $_POST['tp_id'];
		$path_id 	= $_POST['path_id'];

		$result = $this->model->get_detail_travel_path($tp_id,$path_id);
		echo json_encode($result);
	}

	function get_detail_path($id)
	{
		$detail_path = $this->model->get_detail_path($id);

		$data 		= "";
		$sts 		= [];
		$fix_sts 	= [];
		$no			= 1;
		$path_id	= 0;
		foreach ($detail_path as $det) {
			array_push($sts, $det->sts);
			$no_last = $no-1;
			for ($i=$no_last; $i < $no; $i++) {

				if ($i != 0) {
					$old = $i - 1;
				}

				if ($i == 0) {
					if ($sts[$i] == "") {
						$class_sts = 'class="stop"';
						$class_color = 'danger';
						$class_pointer = 'style="cursor:pointer;"';
						$path_id 	= $det->path_id;
						$tp_id 		= $det->tp_id;
						$status		= "stop";
					} else {
						$class_sts 		= 'class="completed"';
						$class_color 	= 'success';
						$class_pointer 	= 'style="cursor:pointer;"';
						$status			= "completed";
					}
				} else if (!isset($det->sts)) { // Jika Kondisi Terakhir maka masuk ke sini
					$class_sts 		= 'class="completed"';
					$class_color 	= 'success';
					$class_pointer 	= 'style="cursor:pointer;"';
					$status			= "completed";
				} else if ($det->sts == "completed") {
					$class_sts 		= 'class="completed"';
					$class_color 	= 'success';
					$class_pointer 	= 'style="cursor:pointer;"';
					$status			= "completed";
				} else if ($det->sts == "" && $sts[$old] == "completed") {
					$class_sts 		= 'class="stop"';
					$class_color 	= 'danger';
					$class_pointer 	= 'style="cursor:pointer;"';
					$path_id 		= $det->path_id;
					$tp_id 			= $det->tp_id;
					$status			= "stop";
				} else {
					$class_sts 		= '';
					$class_color 	= 'secondary';
					$class_pointer 	= 'style="cursor:pointer;"';
					$status			= '';
				}
			}
			array_push($fix_sts, $status);
			$data .= '<li style="min-width:110px;" '. $class_sts .' onclick="show_form(&apos;'.$det->path_id.'&apos;,&apos;'.$det->tp_id.'&apos;,&apos;'.$status.'&apos;)">
						<span class="badge bg-'.$class_color.' text-white" '.$class_pointer.'>Poin '. $no .'</span>
						<br>
						<span class="mt-0 badge bg-'.$class_color.' text-white" '.$class_pointer.'>'. $det->start .'-'. $det->end .'</span>
					</li>';
					$no++;
		}

		$result['data'] 	= $data;
		$result['path_id'] 	= $path_id;
		$result['tp_id'] 	= $tp_id;
		$result['status'] 	= $fix_sts;
		echo json_encode($result);
	}

	function save_travel_path()
	{		
		$tp_id			= $_POST['tp_id'];
		$path_id		= $_POST['path_id'];
		$status			= $_POST['status'];
		$tipe			= $_POST['tipe'];
		$evaluasi		= $_POST['evaluasi'];
		$note			= $_POST['note'];

		$updated_at		= date("Y-m-d H:i:s");
		$updated_by		= $_SESSION['user_id'];	

		if (!empty($_FILES['evidence']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/travel_path/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $tp_id . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('evidence')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

		$keputusan = null;
		if ($tipe == "Keputusan") {
			$keputusan = $note;
		}

		$regulasi = null;
		if ($tipe == "Regulasi") {
			$regulasi = $note;
		}

		$data = array (
			"status" 		=> $status,
			"foto" 			=> $file_name,
			"evaluasi" 		=> $evaluasi,
			"keputusan" 	=> $keputusan,
			"regulasi" 		=> $regulasi,
			"updated_at" 	=> $updated_at,
			"updated_by" 	=> $updated_by
		);

		$this->db->where("tp_id", $tp_id);
		$this->db->where("path_id", $path_id);
		$result['update_tp_travel_path_item'] = $this->db->update("tp_travel_path_item", $data);		
		echo json_encode($result);
	}

	function insert_path()
	{
		$path_id = $_POST['path_id'];
		$check_path = $this->model->check_travel_path();

		if ($check_path < 1) 
		{
			$id_tp			= $this->model->generate_id_travel_path();
			$data_path		= $this->model->get_master_path($path_id);
			
			$created_at		= date("Y-m-d H:i:s");
			$created_by		= $_SESSION['user_id'];	
	
			$path = array (
				"id_tp"			=> $id_tp,
				"point_id" 		=> $path_id,
				"created_at" 	=> $created_at,
				"created_by" 	=> $created_by
			);
			$result['insert_path'] = $this->db->insert("tp_travel_path", $path);
	
			foreach ($data_path as $key => $dt) {
				$item = array (
					"tp_id"				=> $id_tp,
					"path_id"			=> $dt->id_path,
					"travel_path"		=> $dt->travel_path
				);	
				$result['insert_path_item'] = $this->db->insert("tp_travel_path_item", $item);
			}
			$result['status'] = "insert";
		} else {
			$result['status'] = "update";
		}
		echo json_encode($result);
	}
	// End New

	function save_gemba()
	{
		$id				= $this->model->generate_id_gemba();
		$tgl_plan		= $_POST['tgl_plan'];
		$tipe_gemba		= $_POST['tipe_gemba'];
		$lokasi			= $_POST['lokasi'];
		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];		

		$ceklis 		= $this->model->get_ceklis($tipe_gemba)->result();
		$jml_ceklis		= $this->model->get_ceklis($tipe_gemba)->num_rows();

		if ($jml_ceklis < 1) {
			$result['warning'] = "List data Ceklis Jenis Genba yang anda pilih masih Kosong!!";
		} else {
			$data = array (
				"id_gemba"		=> $id,
				"tgl_plan" 		=> $tgl_plan,
				"tipe_gemba" 	=> $tipe_gemba,
				"lokasi" 		=> $lokasi,
				"created_at" 	=> $created_at,
				"created_by" 	=> $created_by
			);
	
			$result['insert_gemba'] = $this->db->insert("gemba", $data);
	
			foreach ($ceklis as $row) {
				$item = array (
					"id_gemba"			=> $id,
					"id_gemba_ceklis"	=> $row->id,
					"created_at" 		=> $created_at,
					"created_by" 		=> $created_by
				);
		
				$result['insert_gemba_item'] = $this->db->insert("gemba_item", $item);
			}
			$result['warning'] = "";
		}
		
		echo json_encode($result);
	}

	function list_proses()
	{
		$result['data'] = $this->model->list_proses();
		echo json_encode($result);
	}

	function get_detail_gemba($id_gemba)
	{
		$detail_gemba = $this->model->get_detail_gemba($id_gemba);

		$data = "";
		foreach ($detail_gemba as $det) {
			$data .= '<div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4 mb-2">
						<div class="card border-0 mb-4 status-start border-card-status border-'. $det->warna .' w-100">
							<div class="card-header">
								<div class="row gx-2 align-items-center">
									<div class="col-auto">
										<i class="bi bi-ui-checks-grid h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
									</div>
									<div class="col">
										<h6 class="fw-medium mb-0">'. $det->concern .'</h6>
										<p class="text-secondary small">'. $det->monitoring .'</p>
									</div>
								</div>
							</div>
							<div class="card-body">
								<form id="form_detail_gemba_'. $det->id_gemba_ceklis .'">
									<input type="hidden" id="id_gemba_'. $det->id_gemba_ceklis .'" name="id_gemba_'. $det->id_gemba_ceklis .'" value="'. $det->id_gemba .'">
									<input type="hidden" id="id_gemba_ceklis_'. $det->id_gemba_ceklis .'" name="id_gemba_ceklis_'. $det->id_gemba_ceklis .'" value="'. $det->id_gemba .'">
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
												<div class="form-floating">
													<select name="status_item_'. $det->id_gemba_ceklis .'" id="status_item_'. $det->id_gemba_ceklis .'" class="form-control">
														<option value="#" selected disabled>-- Choose Status --</option>
														<option value="ya">Ya</option>
														<option value="tidak">Tidak</option>
													</select>
													<label>Status <i class="text-danger">*</i></label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-folder-check"></i></span>
												<div class="form-floating">
													<input type="file" class="form-control border-start-0" id="file_item_'. $det->id_gemba_ceklis .'" name="file_item_'. $det->id_gemba_ceklis .'" autocomplete="off" accept="*">
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-link"></i></span>
												<div class="form-floating">
													<input type="text" class="form-control border-start-0" id="link_item_'. $det->id_gemba_ceklis .'" name="link_item_'. $det->id_gemba_ceklis .'" placeholder="Link">
													<label>Link <i class="text-danger">*</i></label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-journal-text"></i></span>
												<div class="form-floating">
													<textarea name="note_item_'. $det->id_gemba_ceklis .'" id="note_item_'. $det->id_gemba_ceklis .'" cols="30" rows="10" class="form-control border-start-0" placeholder="Note"></textarea>
													<label>Note <i class="text-danger">*</i></label>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-md btn-outline-theme" id="btn_save_proses_gemba_'. $det->id_gemba_ceklis .'" onclick="save_proses_gemba('. $det->id_gemba_ceklis .')">Save</button>
							</div>
						</div>
					</div>';
		}

		$result = $data;
		echo json_encode($result);
	}

	function get_detail_evaluasi($id_gemba)
	{
		$result = $this->model->get_detail_evaluasi($id_gemba);
		echo json_encode($result);
	}

	function save_proses_gemba()
	{		
		$id_gemba			= $_POST['id_gemba'];
		$id_gemba_ceklis	= $_POST['id_gemba_ceklis'];
		$status				= $_POST['status'];
		$link				= $_POST['link'];
		$note				= $_POST['note'];

		$updated_at			= date("Y-m-d H:i:s");
		$updated_by			= $_SESSION['user_id'];	

		if (!empty($_FILES['file_item']['name'])) {
            // Proses unggah file
            $config['upload_path']   = './uploads/gemba/';
            // $config['allowed_types'] = 'gif|jpg|png|jpeg|png|pdf';
            $config['allowed_types'] = '*';
            $new_name = $id_gemba . '_' . time();
            $config['file_name']     = $new_name;
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_item')) {
                $response['error'] = array('error' => $this->upload->display_errors());
            } else {
                $data = array('upload_data' => $this->upload->data());
                $file_name = $data['upload_data']['file_name'];
            }
        } else {
            $file_name = "";
        }

		$data = array (
			"status" 		=> $status,
			"file" 			=> $file_name,
			"link" 			=> $link,
			"note" 			=> $note,
			"updated_at" 	=> $updated_at,
			"updated_by" 	=> $updated_by
		);

		$this->db->where("id_gemba", $id_gemba);
		$this->db->where("id_gemba_ceklis", $id_gemba_ceklis);
		$result['update_gemba_item'] = $this->db->update("gemba_item", $data);		
		echo json_encode($result);
	}

	function save_proses_evaluasi()
	{
		$id_gemba		= $_POST['id_gemba'];
		$peserta		= $_POST['peserta'];
		$evaluasi		= $_POST['evaluasi'];
		$status			= $_POST['status_akhir'];

		$updated_at		= date("Y-m-d H:i:s");
		$updated_by		= $_SESSION['user_id'];	

		$data = array (
			"peserta" 		=> $peserta,
			"evaluasi" 		=> $evaluasi,
			"status" 		=> $status,
			"updated_at" 	=> $updated_at,
			"updated_by" 	=> $updated_by
		);

		$this->db->where("id_gemba", $id_gemba);
		$result['update_gemba'] = $this->db->update("gemba", $data);
		
		echo json_encode($result);
	}
	
	function list_gemba()
	{
		$start 	= $_POST['start'];
		$end 	= $_POST['end'];

		$result['data'] = $this->model->list_gemba($start,$end);
		echo json_encode($result);
	}
	
	function get_result_gemba()
	{
		$id_gemba 	= $_POST['id_gemba'];

		$result['data'] = $this->model->get_result_gemba($id_gemba);
		echo json_encode($result);
	}

	public function generate_head_resume_v3()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");
        $data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
        $response['data'] = $data->result();

        $body_resume = $this->generate_body_resume_v3($start, $end, $data->num_rows());
        $response['body_resume'] = $body_resume;
        $response['jumlah_week'] = $data->num_rows();
        echo json_encode($response);
    }

    public function generate_body_resume_v3($start, $end, $jumlah_week)
    {
        $select = "";
        $week = 1;
        for ($i = 0; $i < $jumlah_week; $i++) {
            $select .= " COUNT(IF(xx.input >= 3 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
            $select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
            $week++;
        }

		$user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
		$kondisi = "";
		} else if ($user_id == 1161 || $user_id == 70  ) { // fuji
		$kondisi = "";
		} else {
		$kondisi = "WHERE xx.user_id = $user_id ";
		}

        $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                      WHERE (user_id IN (118,637,116,998,4201) OR user_id IN (2108,2733,1294,1733,1369,2127,1844)) AND a.is_active = 1
                      ) tm
                      LEFT JOIN mom_plan b ON FIND_IN_SET(tm.user_id, b.created_by)
                      LEFT JOIN (
                                          SELECT
                                              @rank := @rank + 1 AS w,
                                              calendar_week.* 
                                          FROM (
                                              SELECT
                                                  start_date AS `tgl_awal`,
                                                  (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                              FROM 
                                              (
                                                  SELECT 
                                                      ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                  FROM
                                                      (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                      (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                      (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                      (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                      (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                              ) v
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(b.created_at,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx $kondisi GROUP BY xx.user_id";
        return $this->db->query($query)->result();
    }
}
