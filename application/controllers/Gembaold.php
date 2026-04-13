<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Gemba extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("url");
		$this->load->library("session");
		$this->load->model('Model_gemba', 'model');
        if ($this->session->userdata('user_id') != "") { } else {
			redirect('login', 'refresh');
        }
	}

	function index()
	{
		$data['content'] 			= "gemba/index";
		$data['pageTitle'] 			= "Genba";
		$data['css'] 				= "gemba/css";
		$data['js'] 				= "gemba/js";
		$data['tipe']				= $this->model->get_tipe();
		$data['status_strategy']	= $this->model->get_status_strategy();

		$this->load->view("layout/main", $data);
	}

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
}
