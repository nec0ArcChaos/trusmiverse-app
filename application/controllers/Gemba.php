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
		$this->load->model('Model_gemba_dev', 'model');
		if ($this->session->userdata('user_id') != "") {
		} else {
			redirect('login', 'refresh');
		}
	}

	function index()
	{
		$data['content'] 			= "gemba/index_devv";
		$data['pageTitle'] 			= "Genba";
		$data['css'] 				= "gemba/css";
		$data['js'] 				= "gemba/js_devv";
		$data['tipe']				= $this->model->get_tipe();
		$data['project']                = $this->db->query("SELECT divisi AS project, divisi AS id_project FROM `grd_m_so` GROUP BY divisi")->result();
		$data['status_strategy']	= $this->model->get_status_strategy();
		$data['project_location'] = $this->model->get_project_location();
		    $data['cek_jam'] = $this->db
        ->select('cek_jam')
        ->where('id_gemba', $id)
        ->get('gemba')
        ->row()
        ->cek_jam;

		$this->load->view("layout/main", $data);
	}
	function print($id)
	{
		$data = [
			'header' => $this->model->data_header($id),
			'ceklis' => $this->model->data_ceklis($id)
		];
		// var_dump($data);die();
		$this->load->view("gemba/print", $data);
	}
	function get_employee()
	{
		$tipe = $this->input->post('tipe');
		$data = $this->model->get_employee($tipe);
		echo json_encode($data);
	}
	function get_dokumen()
	{
		$department_id = $this->input->post('department_id');
		$data = $this->model->get_dokumen($department_id);
		echo json_encode($data);
	}

	// addnew
	function get_pekerjaan_by_project()
	{
		$id_project = $this->input->post('id_project');

		// $query = "SELECT id_so AS id, so AS pekerjaan,DATE_FORMAT(created_at, '%b %Y') AS periode FROM `grd_m_so` WHERE divisi = '$id_project'";
		$query = "SELECT
		grd_m_so.id_so AS id,
		grd_m_so.so AS pekerjaan,
		CONCAT(' | ',grd_m_goal.nama_goal, ' | ',DATE_FORMAT( grd_m_so.created_at, '%b %Y' )) AS periode
	FROM
		`grd_m_so` 
		JOIN grd_m_goal ON grd_m_so.id_goal = grd_m_goal.id_goal
	WHERE
		grd_m_so.divisi = '$id_project'";
		$data = $this->db->query($query)->result();
		// $data = $this->db->query("SELECT 
		//                             id, `pekerjaan` 
		//                         FROM m_pekerjaan 
		//                         ORDER BY pekerjaan")
		// 	->result();
		// $data = $this->db->query("SELECT 
		//                             id, `pekerjaan` 
		//                         FROM m_pekerjaan 
		//                         WHERE `id_project` = '$id_project'
		//                         ORDER BY pekerjaan")
		//     ->result();
		echo json_encode($data);
	}

	// addnew
	function get_sub_pekerjaan_by_pekerjaan()
	{
		$id_pekerjaan = $this->input->post('id_pekerjaan');

		// $data = $this->db->query("SELECT 
		//                             id, `sub_pekerjaan` 
		//                         FROM m_sub_pekerjaan 
		//                         WHERE `id_pekerjaan` = '$id_pekerjaan'
		//                         ORDER BY sub_pekerjaan")
		// 	->result();
		$query = "SELECT id_si AS id, si AS sub_pekerjaan FROM `grd_t_si` WHERE id_so =  $id_pekerjaan";
		$data = $this->db->query($query)->result();
		echo json_encode($data);
	}

	// addnew
	function get_detail_pekerjaan_by_sub_pekerjaan()
	{
		$id_sub_pekerjaan = $this->input->post('id_sub_pekerjaan');
		$query = "SELECT id_tasklist AS id, detail FROM `grd_t_tasklist` WHERE id_si = $id_sub_pekerjaan";
		$data = $this->db->query($query)->result();
		// $data = $this->db->query("SELECT 
		//                             id, `detail` 
		//                         FROM t_detail_pekerjaan 
		//                         WHERE `id_sub_pekerjaan` = '$id_sub_pekerjaan'
		//                         ORDER BY detail")
		// 	->result();
		echo json_encode($data);
	}

	function save_gemba()
	{
		$id				= $this->model->generate_id_gemba();
		$tgl_plan		= $_POST['tgl_plan'];
		$tipe_gemba		= $_POST['tipe_gemba'];
		// $lokasi			= $_POST['lokasi'];
		$lokasi = $this->input->post('lokasi');

		$latitude_user   = $this->input->post('latitude');
		$longitude_user  = $this->input->post('longitude');

		$project_name = $this->input->post('lokasi');

		$project_data = $this->db
			->where('project', $project_name)
			->get('rsp_project_live.m_project')
			->row();

		$latitude_project  = $project_data ? $project_data->latitude : null;
		$longitude_project = $project_data ? $project_data->longitude : null;


		if (!$lokasi) {
			$lokasi = $this->input->post('lokasi_text');
		}

		$created_at		= date("Y-m-d H:i:s");
		$created_by		= $_SESSION['user_id'];

		$ceklis 		= $this->model->get_ceklis($tipe_gemba)->result();
		$jml_ceklis		= $this->model->get_ceklis($tipe_gemba)->num_rows();

		// $latitude   = isset($_POST['latitude']) ? $_POST['latitude'] : null;
		// $longitude  = isset($_POST['longitude']) ? $_POST['longitude'] : null;


		if ($jml_ceklis < 1) {
			$result['warning'] = "List data Ceklis Jenis Genba yang anda pilih masih Kosong!!";
		} else {

			// addnew by Ade
			// $check_addition = (isset($_POST['addition'])) ? $_POST['addition'] : '';
			// echo json_encode(array(
			//     'check_addition' => $check_addition
			// ));
			// return;

			if (isset($_POST['addition'])) {
				// echo json_encode([
				//     'detail' => $_POST['id_detail_pekerjaan']
				// ]);
				// die;
				$data = array(
					"id_gemba"        => $id,
					"tgl_plan"         => $tgl_plan,
					"tipe_gemba"     => $tipe_gemba,
					"lokasi"         => $lokasi,
					"created_at"     => $created_at,
					"created_by"     => $created_by,
					// addnew by Ade
					"divisi"         => $_POST['id_project'],
					"so"				=> isset($_POST['id_pekerjaan']) ? $_POST['id_pekerjaan'] : '',
					"si"                => isset($_POST['id_sub_pekerjaan']) ? $_POST['id_sub_pekerjaan'] : '',
					"tasklist"     => implode(",", isset($_POST['id_detail_pekerjaan']) ? $_POST['id_detail_pekerjaan'] : '')
					// "id_project"     => $_POST['id_project'],
					// "id_pekerjaan"     => isset($_POST['id_pekerjaan']) ? $_POST['id_pekerjaan'] : '',
					// "id_sub_pekerjaan"     => isset($_POST['id_sub_pekerjaan']) ? $_POST['id_sub_pekerjaan'] : '',
					// "id_detail_pekerjaan"     => implode(",", isset($_POST['id_detail_pekerjaan']) ? $_POST['id_detail_pekerjaan'] : '')
				);
			} else {
				$data = array(
					"id_gemba"        => $id,
					"tgl_plan"        => $tgl_plan,
					"tipe_gemba"      => $tipe_gemba,
					"lokasi"          => $lokasi,

					// KOORDINAT PROJECT
					"latitude"        => $latitude_project,
					"longitude"       => $longitude_project,

					// KOORDINAT USER
					"latitude_user"   => $latitude_user,
					"longitude_user"  => $longitude_user,

					"created_at"      => $created_at,
					"created_by"      => $created_by,
					"no_dokumen"      => $this->input->post('dokumen')
				);
			}

			// $data = array(
			//     "id_gemba"        => $id,
			//     "tgl_plan"         => $tgl_plan,
			//     "tipe_gemba"     => $tipe_gemba,
			//     "lokasi"         => $lokasi,
			//     "created_at"     => $created_at,
			//     "created_by"     => $created_by
			// );
			$result['insert_gemba'] = $this->db->insert("gemba", $data);

			foreach ($ceklis as $row) {
				$item = array(
					"id_gemba"            => $id,
					"id_gemba_ceklis"    => $row->id,
					"created_at"         => $created_at,
					"created_by"         => $created_by
				);

				$result['insert_gemba_item'] = $this->db->insert("gemba_item", $item);
			}
			$result['warning'] = "";
			$result['id_gemba'] = $id;
		}

		echo json_encode($result);
	}

	function list_proses()
	{
		$result['data'] = $this->model->list_proses();
		echo json_encode($result);
	}

	function list_perbaikan()
	{
		$result['data'] = $this->model->list_perbaikan();
		echo json_encode($result);
	}

	function list_deadline()
	{
		$result['data'] = $this->model->list_deadline();
		echo json_encode($result);
	}

	function list_verifikasi()
	{
		$result['data'] = $this->model->list_verifikasi();
		echo json_encode($result);
	}

	public function detail_perbaikan()
	{
		$id_gemba = $this->input->post('id_gemba');
		$data = $this->model->detail_perbaikan($id_gemba);

		if ($data) {
			echo json_encode([
				'status' => true,
				'data' => $data
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak ditemukan'
			]);
		}
	}

	public function detail_deadline()
	{
		$id_gemba = $this->input->post('id_gemba');
		$data = $this->model->detail_deadline($id_gemba);

		if ($data) {
			echo json_encode([
				'status' => true,
				'data' => $data
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak ditemukan'
			]);
		}
	}

	public function detail_verifikasi()
	{
		$id_gemba = $this->input->post('id_gemba');
		$data = $this->model->detail_verifikasi($id_gemba);

		if ($data) {
			echo json_encode([
				'status' => true,
				'data' => $data
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak ditemukan'
			]);
		}
	}


	public function save_deadline()
	{
		$id_gemba  = $this->input->post('id_gemba');
		$deadline  = $this->input->post('deadline');
		$user_id   = $_SESSION['id_user'];
		$now       = date('Y-m-d H:i:s');

		// ambil item yang perlu diupdate
		$items = $this->db->query("
        SELECT
            id_gemba_ceklis,
            deadline,
            deadline_baru,
            verifikasi_at,
            status_verifikasi
        FROM gemba_item
        WHERE id_gemba = ?
        AND status = 'tidak'
        AND (
            deadline IS NULL
            OR deadline_baru IS NULL
        )
    ", [$id_gemba])->result();

		foreach ($items as $item) {

			// CASE 1: deadline pertama
			if ($item->deadline === null) {

				$this->db->where('id_gemba', $id_gemba);
				$this->db->where('id_gemba_ceklis', $item->id_gemba_ceklis);
				$this->db->update('gemba_item', [
					'deadline'   => $deadline,
					'updated_at' => $now,
					'updated_by' => $user_id
				]);
			}
			// CASE 2: deadline baru setelah verifikasi tidak oke
			else if (
				$item->verifikasi_at !== null &&
				$item->status_verifikasi === 'tidak oke'
			) {

				$this->db->where('id_gemba', $id_gemba);
				$this->db->where('id_gemba_ceklis', $item->id_gemba_ceklis);
				$this->db->update('gemba_item', [
					'deadline_baru' => $deadline,
					'updated_at'    => $now,
					'updated_by'    => $user_id
				]);
			}
		}

		echo json_encode([
			'status'  => true,
			'message' => 'Deadline updated'
		]);
	}

	function get_detail_gemba($id_gemba)
	{
		$detail_gemba = $this->model->get_detail_gemba($id_gemba);
		$employee = $this->model->get_employee($detail_gemba[0]->tipe_gemba);

		$opt_employee = "<option value='' selected disabled>-- Choose --</option>";

		foreach ($employee as $item) {
			$opt_employee .= "<option value=" . $item->user_id . ">" . $item->nama . "</option>";
		}

		$project = $this->model->get_project_location();

		$opt_project = "<option value='' selected disabled>-- Choose Lokasi --</option>";

		foreach ($project as $p) {
			$opt_project .= "<option value='" . $p->id_project . "'>" . $p->project . "</option>";
		}

		$cek = $this->db
    ->select('cek_jam')
    ->where('id_gemba', $id_gemba)
    ->get('gemba')
    ->row();

$cek_jam = $cek ? $cek->cek_jam : '';

$data = '<input type="hidden" id="cek_jam_gemba" value="'.$cek_jam.'">';


		// $data = "";
		foreach ($detail_gemba as $det) {

			$accept_attr = 'accept="image/*" capture="environment"';
			if (in_array($det->id_gemba_ceklis, [13, 14, 15])) {
				$accept_attr = 'accept="*"';
			}

			$data .= '<div class="col-12 col-md-6 col-lg-6 col-xl-4 col-xxl-4 mb-2 card-item"

            id="card_' . $det->id_gemba_ceklis . '">
						<div class="card border-0 mb-4 status-start border-card-status border-' . $det->warna . ' w-100">
							<div class="card-header">
								<div class="row gx-2 align-items-center">
									<div class="col-auto">
										<i class="bi bi-ui-checks-grid h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
									</div>
									<div class="col">
										<h6 class="fw-medium mb-0">' . $det->concern . '</h6>
										<p class="text-secondary small">' . $det->monitoring . '</p>
									</div>
								</div>
							</div>
							<div class="card-body">
								<form id="form_detail_gemba_' . $det->id_gemba_ceklis . '" enctype="multipart/form-data">

									<input type="hidden" id="id_gemba_' . $det->id_gemba_ceklis . '" name="id_gemba_' . $det->id_gemba_ceklis . '" value="' . $det->id_gemba . '">
									<input type="hidden" 
id="id_gemba_ceklis_' . $det->id_gemba_ceklis . '" 
name="id_gemba_ceklis_' . $det->id_gemba_ceklis . '" 
value="' . $det->id_gemba_ceklis . '">

									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-check-square"></i></span>
												<div class="form-floating">
													<select name="status_item_' . $det->id_gemba_ceklis . '" id="status_item_' . $det->id_gemba_ceklis . '" class="form-control">
														<option value="#" selected disabled>-- Choose Status --</option>
														<option value="ya">Sesuai</option>
														<option value="tidak">Tidak Sesuai</option>
													</select>
													<label>Status <i class="text-danger">*</i></label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">

											<div id="evidence_container_' . $det->id_gemba_ceklis . '">

												<div class="input-group input-group-lg mb-2">
													<span class="input-group-text text-theme bg-white border-end-0">
														<i class="bi bi-folder-check"></i>
													</span>

													<div class="form-floating">
														<input type="file"
														class="form-control border-start-0"
														name="file_item_' . $det->id_gemba_ceklis . '[]"
														' . $accept_attr . '>
													</div>
												</div>

											</div>

											<button type="button"
												class="btn btn-sm btn-outline-theme mt-1"
												onclick="addEvidence(' . $det->id_gemba_ceklis . ', ' . (in_array($det->id_gemba_ceklis, [13, 14, 15]) ? 0 : 1) . ')">
												<i class="bi bi-plus"></i> Tambah Evidence
											</button>

										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
											<span class="input-group-text text-theme bg-white border-end-0">
												<i class="bi bi-geo-alt"></i>
											</span>
											<div class="form-floating">
												<input type="text"
												class="form-control border-start-0"
												id="lokasi_temuan_item_' . $det->id_gemba_ceklis . '"
												name="lokasi_temuan_item_' . $det->id_gemba_ceklis . '"
												placeholder="Lokasi Temuan"
												required>
												<label>Lokasi Temuan <i class="text-danger">*</i></label>
											</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
											<span class="input-group-text text-theme bg-white border-end-0">
												<i class="bi bi-calendar-check"></i>
											</span>
											<div class="form-floating">
												<input type="text"
												class="form-control border-start-0"
												id="ekspetasi_penyelesaian_item_' . $det->id_gemba_ceklis . '"
												name="ekspetasi_penyelesaian_item_' . $det->id_gemba_ceklis . '"
												placeholder="Ekspektasi Penyelesaian"
												required>
												<label>Ekspektasi Penyelesaian <i class="text-danger">*</i></label>
											</div>
											</div>
										</div>
										</div>

										
									</div>
									<div class="col-12 col-md-12 mb-2">
										<div class="form-group mb-3 position-relative check-valid">
											<div class="input-group input-group-lg">
												<span class="input-group-text text-theme bg-white border-end-0"><i class="bi bi-people"></i></span>
												<div class="form-floating">
													<select name="pic_item_' . $det->id_gemba_ceklis . '" id="pic_item_' . $det->id_gemba_ceklis . '" class="form-control border-start-0 employee">
													' . $opt_employee . '
													</select>
													<label>Pic</label>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
							<div class="card-footer">
								<button type="button" class="btn btn-md btn-outline-theme" id="btn_save_proses_gemba_' . $det->id_gemba_ceklis . '" onclick="save_proses_gemba(' . $det->id_gemba_ceklis . ')">Save</button>
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

	public function save_proses_gemba()
	{
		header('Content-Type: application/json');

		$id_gemba        = $_POST['id_gemba'];
		$id_gemba_ceklis = $_POST['id_gemba_ceklis'];
		$status          = $_POST['status'];
		$link            = $_POST['link'] ?? '';
		$deadline        = $_POST['deadline'] ?? '';
		$lokasi_temuan   = $_POST['lokasi_temuan'] ?? '';
		$ekspetasi       = $_POST['ekspetasi_penyelesaian'] ?? '';
		$note            = $_POST['note'] ?? '';
		$pic             = $_POST['pic'] ?? '';
		$updated_by      = $_SESSION['user_id'];
		$updated_at      = date('Y-m-d H:i:s');

		//berdasarkan updated_at gemba
		// $gemba = $this->db->get_where('gemba', [
		// 	'id_gemba'        => $id_gemba,
		// ])->row();

		// $current_time = time();

		// if (empty($gemba->updated_at)) {

		// 	$this->db->where('id_gemba', $id_gemba);
		// 	$this->db->update('gemba', [
		// 		'updated_at' => date('Y-m-d H:i:s')
		// 	]);

		// 	echo json_encode([
		// 		"warning" => "Timer dimulai. Tunggu 10 menit."
		// 	]);
		// 	return;
		// }

		// $start_time = strtotime($gemba->updated_at);

		// if (($current_time - $start_time) < 600) {
		// 	echo json_encode([
		// 		"warning" => "Inspeksi terlalu cepat!"
		// 	]);
		// 	return;
		// }

		$current_time = time();

		// Cek apakah sudah ada item yg pernah diupdate
		$last_item = $this->db->select('updated_at')
			->from('gemba_item')
			->where('id_gemba', $id_gemba)
			->where('updated_at IS NOT NULL', null, false)
			->order_by('updated_at', 'DESC')
			->limit(1)
			->get()
			->row();

		if ($last_item) {
			// SAVE kedua dan seterusnya
			$start_time = strtotime($last_item->updated_at);
		} else {
			// SAVE pertama
			$gemba = $this->db->get_where('gemba', [
				'id_gemba' => $id_gemba
			])->row();

			if (!empty($gemba->updated_at)) {
				$start_time = strtotime($gemba->updated_at);
			} else {
				// belum pernah sama sekali → mulai timer
				$this->db->where('id_gemba', $id_gemba);
				$this->db->update('gemba', [
					'updated_at' => date('Y-m-d H:i:s')
				]);

				// echo json_encode([
				// 	"warning" => "Timer dimulai. Tunggu 10 menit."
				// ]);
				return;
			}
		}

		// Cek 10 menit HANYA kalau status = tidak
		// if (trim(strtolower($status)) == 'tidak') {

		// 	if (($current_time - $start_time) < 600) {
		// 		echo json_encode([
		// 			"warning" => "Inspeksi terlalu cepat!"
		// 		]);
		// 		return;
		// 	}

		// }

		// =========================
		// UPLOAD MULTIPLE FILE
		// =========================
		// =========================
// UPLOAD + COMPRESS IMAGE
// =========================
$file_names = [];
$file_link  = [];

if (!empty($_FILES['file_item']['name'][0])) {

    $files = $_FILES['file_item'];
    $count = count($files['name']);

    for ($i = 0; $i < $count; $i++) {

        $_FILES['temp_file']['name']     = $files['name'][$i];
        $_FILES['temp_file']['type']     = $files['type'][$i];
        $_FILES['temp_file']['tmp_name'] = $files['tmp_name'][$i];
        $_FILES['temp_file']['error']    = $files['error'][$i];
        $_FILES['temp_file']['size']     = $files['size'][$i];

        $config['upload_path']   = './uploads/gemba/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf|xls|xlsx';
        $config['file_name']     = $id_gemba . '_' . time() . '_' . $i;
        $config['overwrite']     = true;
        $config['max_size']      = 10240; // 10MB

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('temp_file')) {

            $uploaded = $this->upload->data();
            $ext      = strtolower($uploaded['file_ext']);

            // =========================
            // KOMPRES JIKA GAMBAR
            // =========================
            if (in_array($ext, ['.jpg', '.jpeg', '.png'])) {

                $config_resize['image_library']  = 'gd2';
                $config_resize['source_image']   = $uploaded['full_path'];
                $config_resize['maintain_ratio'] = TRUE;
                $config_resize['quality']        = '60%';
                $config_resize['width']          = 1280;
                $config_resize['height']         = 1280;

                $this->load->library('image_lib', $config_resize);
                $this->image_lib->resize();
                $this->image_lib->clear();
            }

            // PDF & Excel cuma di-limit size aja (gak bisa dikompres bawaan CI)

            $file_names[] = $uploaded['file_name'];
            $file_link[]  = base_url('uploads/gemba/' . $uploaded['file_name']);
        }
    }
}

		// =========================
		// UPDATE GEMBA ITEM
		// =========================
		$data = [
			'status'        => $status,
			'lokasi_temuan' => $lokasi_temuan,
			'ekspetasi'     => $ekspetasi,
			// 'note'          => $note,
			'pic'           => $pic,
			'updated_at'    => $updated_at,
			'updated_by'    => $updated_by
		];

		$this->db->where('id_gemba', $id_gemba);
		$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
		$update = $this->db->update('gemba_item', $data);

		// =========================
		// SIMPAN FOTO KE TABLE GEMBA_FOTO
		// =========================
		if ($update) {

			// 🔥 Kalau mau REPLACE foto lama, hapus dulu
			$this->db->where('id_gemba', $id_gemba);
			$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
			$this->db->delete('gemba_foto');

			// Insert foto baru
			foreach ($file_names as $file) {

				$this->db->insert('gemba_foto', [
					'id_gemba'        => $id_gemba,
					'id_gemba_ceklis' => $id_gemba_ceklis,
					'file'            => $file,
					'created_at'      => $updated_at,
					'created_by'      => $updated_by
				]);
			}
		}

		// =========================
		// DEFAULT WA RESPONSE
		// =========================
		$wa_status   = false;
		$wa_result   = null;
		$wa_to       = null;
		$pic_user_id = null;

		// =========================
		// KIRIM WA JIKA STATUS TIDAK SESUAI
		// =========================
		if ($update && trim(strtolower($status)) != 'ya') {

			$employee = $this->db->query("
            SELECT emp.user_id, emp.contact_no
            FROM gemba_item gi
            JOIN xin_employees emp ON gi.pic = emp.user_id
            WHERE gi.id_gemba = ?
            AND gi.id_gemba_ceklis = ?
            AND emp.is_active = 1
            LIMIT 1
        ", [$id_gemba, $id_gemba_ceklis])->row();

			if ($employee && !empty($employee->contact_no)) {

				$pic_user_id = $employee->user_id;

				$phone = preg_replace('/[^0-9]/', '', trim($employee->contact_no));

				if (substr($phone, 0, 1) === '0') {
					$phone = '62' . substr($phone, 1);
				}

				if (substr($phone, 0, 2) === '62') {

					$msg = "🚨 *Pemberitahuan Temuan Gemba*\n\n"
						. "📍 *Lokasi:* {$lokasi_temuan}\n"
						. "🎯 *Ekspektasi:* {$ekspetasi}\n"
						. "📝 *Catatan:* {$note}\n"
						. "📎 *Evidence:* \n";

					foreach ($file_link as $link_file) {
						$msg .= $link_file . "\n";
					}

					$wa_result = $this->send_wa($phone, $msg, $pic_user_id);
					$wa_status = true;
					$wa_to     = $phone;
				} else {
					$wa_result = 'Format nomor WA tidak valid';
				}
			} else {
				$wa_result = 'Data PIC / nomor WA tidak ditemukan';
			}
		}

		// =========================
		// JSON RESPONSE
		// =========================
		echo json_encode([
			'status'      => true,
			'msg'         => 'Data berhasil disimpan',
			'wa_sent'     => $wa_status,
			'wa_to'       => $wa_to,
			'pic_user_id' => $pic_user_id,
			'wa_result'   => $wa_result
		]);
	}

	public function update_cek_gemba()
{
    // ambil data POST
    $id_gemba = $this->input->post('id_gemba');
    $cek = $this->input->post('cek');

    if (!$id_gemba) {
        echo json_encode(['status' => false, 'msg' => 'ID gemba tidak ditemukan']);
        return;
    }

    // update kolom cek di tabel gemba
    $this->db->where('id_gemba', $id_gemba);
    $update = $this->db->update('gemba', ['cek' => $cek]);

    if ($update) {
        echo json_encode(['status' => true, 'msg' => 'Kolom cek berhasil diupdate']);
    } else {
        echo json_encode(['status' => false, 'msg' => 'Gagal update kolom cek']);
    }
}



	public function simpan_perbaikan()
	{
		$user_id			= $_SESSION['user_id'];
		header('Content-Type: application/json');

		$id_gemba = $this->input->post('id_gemba');
		$note     = $this->input->post('note');
		$link     = $this->input->post('link');

		// =========================
		// UPLOAD EVIDENCE
		// =========================
		$file_name = null;

		if (!empty($_FILES['evidence']['name'])) {

			$config['upload_path']   = './uploads/gemba/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf';
			$config['max_size']      = 2048;
			$config['file_name']     = 'perbaikan_' . time();

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('evidence')) {
				echo json_encode([
					'status'  => false,
					'message' => $this->upload->display_errors('', '')
				]);
				return;
			}

			$file_name = $this->upload->data('file_name');
		}

		// =========================
		// UPDATE DATABASE (LANGSUNG)
		// =========================
		$data_update = [
			'id_gemba'   => $id_gemba,
			'file_perbaikan'       => $file_name,
			'note_perbaikan'       => $note,
			'link_perbaikan'       => $link,
			'perbaikan_at' => date('Y-m-d H:i:s'),
			'perbaikan_by' => $user_id
		];

		$this->db->where('id_gemba', $id_gemba);
		$this->db->where('status', 'tidak');
		$update = $this->db->update('gemba_item', $data_update);

		if ($update) {
			echo json_encode([
				'status'  => true,
				'message' => 'Data perbaikan berhasil disimpan'
			]);
		} else {
			echo json_encode([
				'status'  => false,
				'message' => 'Gagal menyimpan data'
			]);
		}
	}

	public function simpan_verifikasi()
	{
		header('Content-Type: application/json');
		$user_id = $_SESSION['user_id'];

		$id_gemba_list        = $this->input->post('id_gemba');
		$id_gemba_ceklis_list = $this->input->post('id_gemba_ceklis');

		if (!$id_gemba_list || !$id_gemba_ceklis_list) {
			echo json_encode([
				'status' => false,
				'message' => 'Data kosong'
			]);
			return;
		}

		foreach ($id_gemba_list as $i => $id_gemba) {

			$id_gemba_ceklis = $id_gemba_ceklis_list[$i];

			$key = $id_gemba . '_' . $id_gemba_ceklis;

			$status   = $this->input->post('status_' . $key);
			$alasan   = $this->input->post('alasan_verifikasi_' . $key);
			$deadline = $this->input->post('deadline_baru_' . $key);

			if (!$status) continue;

			$data_update = [
				'status_verifikasi' => $status,
				'alasan_verifikasi' => $alasan,
				'deadline_baru'     => $deadline,
				'verifikasi_at'     => date('Y-m-d H:i:s'),
				'verifikasi_by'     => $user_id
			];

			$this->db->where('id_gemba', $id_gemba);
			$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
			$this->db->update('gemba_item', $data_update);
		}

		echo json_encode([
			'status' => true,
			'message' => 'Verifikasi berhasil disimpan'
		]);
	}

	public function simpan_verifikasi_item()
	{
		header('Content-Type: application/json');
		$user_id = $_SESSION['user_id'];

		$id_gemba        = $this->input->post('id_gemba');
		$id_gemba_ceklis = $this->input->post('id_gemba_ceklis');
		$status          = $this->input->post('status');
		$alasan          = $this->input->post('alasan');
		$deadline        = $this->input->post('deadline_baru');

		if (!$id_gemba || !$id_gemba_ceklis || !$status) {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak lengkap'
			]);
			return;
		}

		$data_update = [
			'status_verifikasi' => $status,
			'verifikasi_at'     => date('Y-m-d H:i:s'),
			'verifikasi_by'     => $user_id
		];

		// 🔥 HANYA JIKA TIDAK OKE → update alasan & deadline
		if (trim(strtolower($status)) != 'oke') {
			$data_update['alasan_verifikasi'] = $alasan;
			// $data_update['deadline_baru']     = $deadline;
		}


		// UPDATE gemba_item (LOGIKA ASLI)
		$this->db->where('id_gemba', $id_gemba);
		$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
		$update = $this->db->update('gemba_item', $data_update);

		if ($this->db->affected_rows() > 0) {

			// INSERT HISTORY (LOGIKA ASLI)
			$data_history = [
				'id_gemba'           => $id_gemba,
				'id_gemba_ceklis'    => $id_gemba_ceklis,
				'status_verifikasi' => $status,
				'alasan_verifikasi' => $alasan,
				'verifikasi_by'     => $user_id,
				'verifikasi_at'     => date('Y-m-d H:i:s')
			];
			$this->db->insert('gemba_item_history', $data_history);

			/* =====================================================
           TAMBAHAN NOTIF WA (KODE LU — TIDAK DIUBAH)
        ===================================================== */
			if ($update && trim(strtolower($status)) != 'oke') {

				$employee = $this->db->query("
                SELECT
				emp.user_id,
				emp.contact_no,
				gi.lokasi_temuan,
				gi.ekspetasi,
				gi.note,
				gi.link_perbaikan,
				gi.file_perbaikan,
				gi.deadline
				FROM
				gemba_item gi
				JOIN xin_employees emp ON gi.pic = emp.user_id
				WHERE
				gi.id_gemba = ?
				AND gi.id_gemba_ceklis = ?
				AND emp.is_active = 1
				LIMIT 1
            ", [$id_gemba, $id_gemba_ceklis])->row();

				if ($employee && !empty($employee->contact_no)) {

					$pic_user_id = $employee->user_id;
					$verifikasi_at = date('d-m-Y H:i');

					$file_url = '-';
					if (!empty($employee->file_perbaikan)) {
						$file_url = 'https://trusmiverse.com/apps/uploads/gemba/' . $employee->file_perbaikan;
					}


					// normalisasi nomor WA
					$phone = preg_replace('/[^0-9]/', '', trim($employee->contact_no));
					if (substr($phone, 0, 1) === '0') {
						$phone = '62' . substr($phone, 1);
					}

					if (substr($phone, 0, 2) !== '62') {
						$wa_result = 'Format nomor WA PIC tidak valid';
					} else {

						$msg = "🚨 *Notifikasi Verifikasi Gemba* 🚨\n\n"
							. "Hasil verifikasi menyatakan perbaikan *TIDAK OKE*.\n\n"
							. "📍 Lokasi Temuan: {$employee->lokasi_temuan}\n"
							. "🎯 Ekspektasi Perbaikan: {$employee->ekspetasi}\n"
							. "🔗 Link Perbaikan: " . (!empty($employee->link_perbaikan) ? $employee->link_perbaikan : '-') . "\n"
							. "📎 File Perbaikan: {$file_url}\n"
							. "🗒️ Catatan PIC: " . (!empty($employee->note) ? $employee->note : '-') . "\n"
							. "⏰ Deadline Lama: {$employee->deadline}\n"
							. "📝 Catatan Verifikator: {$alasan}\n"
							// . "⏰ Deadline Baru: " . (!empty($deadline) ? $deadline : '-') . "\n"
							. "🕒 Diverifikasi pada: {$verifikasi_at}";





						$wa_result = $this->send_wa($phone, $msg, $pic_user_id);
						$wa_status = true;
						$wa_to     = $phone;
					}
				} else {
					$wa_result = 'Data PIC / nomor WA tidak ditemukan';
				}
			}
			/* ===================================================== */

			echo json_encode([
				'status' => true,
				'message' => 'Verifikasi item berhasil disimpan'
			]);
		} else {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak berubah atau tidak ditemukan'
			]);
		}
	}



	public function simpan_perbaikan_item()
	{
		header('Content-Type: application/json');

		$id_gemba        = $this->input->post('id_gemba');
		$id_gemba_ceklis = $this->input->post('id_gemba_ceklis');
		$note            = $this->input->post('note');
		$link            = $this->input->post('link');

		if (!$id_gemba || !$id_gemba_ceklis || !$note) {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak lengkap'
			]);
			return;
		}

		$file_name = '';
		$file_link = '';

		// =========================
		// UPLOAD FILE
		// =========================
		if (!empty($_FILES['evidence']['name'])) {

			$config['upload_path']   = './uploads/gemba/';
			$config['allowed_types'] = 'jpg|jpeg|png|pdf|xls|xlsx';
			$config['encrypt_name']  = true;

			$this->load->library('upload', $config);

			if (!$this->upload->do_upload('evidence')) {
				echo json_encode([
					'status' => false,
					'message' => $this->upload->display_errors('', '')
				]);
				return;
			}

			$file_name = $this->upload->data('file_name');
			$file_link = "https://trusmiverse.com/apps/uploads/gemba/" . $file_name;
		}

		// =========================
		// UPDATE GEMBA ITEM
		// =========================
		$data_update = [
			'note_perbaikan' => $note,
			'link_perbaikan' => $link,
			'file_perbaikan' => $file_name,
			'perbaikan_at'   => date('Y-m-d H:i:s'),
			'perbaikan_by'   => $_SESSION['user_id']
		];

		$this->db->where('id_gemba', $id_gemba);
		$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
		$update = $this->db->update('gemba_item', $data_update);

		// =========================
		// DEFAULT WA RESPONSE
		// =========================
		$wa_status   = false;
		$wa_result   = null;
		$wa_to       = null;
		$pic_user_id = null;

		// =========================
		// AMBIL PIC UNTUK KIRIM WA
		// =========================
		if ($update) {

			$employee = $this->db->query("
            SELECT emp.user_id, emp.contact_no
            FROM gemba_item gi
            JOIN xin_employees emp ON gi.created_by = emp.user_id
            WHERE gi.id_gemba = ?
            AND gi.id_gemba_ceklis = ?
            AND emp.is_active = 1
            LIMIT 1
        ", [$id_gemba, $id_gemba_ceklis])->row();

			if ($employee && !empty($employee->contact_no)) {

				$pic_user_id = $employee->user_id;

				// normalisasi nomor
				$phone = preg_replace('/[^0-9]/', '', trim($employee->contact_no));
				if (substr($phone, 0, 1) === '0') {
					$phone = '62' . substr($phone, 1);
				}

				if (substr($phone, 0, 2) !== '62') {
					$wa_result = 'Format nomor WA PIC tidak valid';
				} else {

					$msg = "🔧 *Update Perbaikan Gemba*\n\n"
						. "📝 *Catatan Perbaikan:* {$note}\n"
						. "📎 *File Evidence:* " . ($file_link ? $file_link : 'Tidak ada file') . "\n"
						. "🔗 *Link:* " . ($link ? $link : '-');

					$wa_result = $this->send_wa($phone, $msg, $pic_user_id);
					$wa_status = true;
					$wa_to     = $phone;
				}
			} else {
				$wa_result = 'Data PIC / nomor WA tidak ditemukan';
			}
		}

		// =========================
		// RESPONSE
		// =========================
		echo json_encode([
			'status'      => true,
			'message'     => 'Perbaikan berhasil disimpan',
			'wa_sent'     => $wa_status,
			'wa_to'       => $wa_to,
			'pic_user_id' => $pic_user_id,
			'wa_result'   => $wa_result
		]);
	}


	public function simpan_deadline()
	{
		header('Content-Type: application/json');

		$id_gemba        = $this->input->post('id_gemba');
		$id_gemba_ceklis = $this->input->post('id_gemba_ceklis');
		$deadline        = $this->input->post('deadline');

		$user_id = $_SESSION['user_id'] ?? null;

		if (!$id_gemba || !$id_gemba_ceklis || !$deadline) {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak lengkap'
			]);
			return;
		}

		// 🔎 Ambil deadline & deadline_baru
		$row = $this->db
			->select('deadline, deadline_baru')
			->from('gemba_item')
			->where('id_gemba', $id_gemba)
			->where('id_gemba_ceklis', $id_gemba_ceklis)
			->get()
			->row();

		if (!$row) {
			echo json_encode([
				'status' => false,
				'message' => 'Data tidak ditemukan'
			]);
			return;
		}

		$now = date('Y-m-d H:i:s');
		$insert_history = false;

		// 🎯 Tentukan update
		if ($row->deadline === null) {
			// Deadline pertama
			$data_update = [
				'deadline'   => $deadline,
				'updated_at' => $now
			];
		} else {
			// Deadline revisi
			$data_update = [
				'deadline_baru' => $deadline,
				'updated_at'    => $now
			];
			$insert_history = true;
		}

		$this->db->where('id_gemba', $id_gemba);
		$this->db->where('id_gemba_ceklis', $id_gemba_ceklis);
		$this->db->update('gemba_item', $data_update);

		// 📝 INSERT HISTORY hanya jika deadline_baru
		if ($this->db->affected_rows() > 0 && $insert_history === true) {

			$data_history = [
				'id_gemba'        => $id_gemba,
				'id_gemba_ceklis' => $id_gemba_ceklis,
				'deadline_baru'   => $deadline,
				// 'created_by'      => $user_id,
				// 'created_at'      => $now
			];

			$this->db->insert('gemba_item_history', $data_history);
		}

		echo json_encode([
			'status' => true,
			'message' => 'Deadline berhasil disimpan'
		]);
	}

	function save_proses_evaluasi()
	{
		$id_gemba		= $_POST['id_gemba'];
		$peserta		= $_POST['peserta'];
		$evaluasi		= $_POST['evaluasi'];
		$status			= $_POST['status_akhir'];

		$updated_at		= date("Y-m-d H:i:s");
		$updated_by		= $_SESSION['user_id'];

		$data = array(
			// "peserta" 		=> $peserta,
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

		$result['data'] = $this->model->list_gemba($start, $end);
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
		} else if ($user_id == 1161 || $user_id == 70 || $user_id == 4498 || $user_id == 10127) { // fuji
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

	public function update_user_location()
{
    $id  = $this->input->post('id_gemba');
    $lat = $this->input->post('latitude_user');
    $lng = $this->input->post('longitude_user');

    $this->db->where('id_gemba', $id);
    $this->db->update('gemba', [
        'latitude_user'  => $lat,
        'longitude_user' => $lng,
        'cek_jam'        => date('Y-m-d H:i:s') // jam sekarang
    ]);
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
}
