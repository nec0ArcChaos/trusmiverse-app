<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Marcom extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('upload');
        $this->load->helper('file_upload');
        $this->load->database();
        $this->load->model('Model_marcom', 'model');

        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    private function _do_upload_temp()
    {
        $result = do_upload_file([
            'file_input'    => 'file',
            'upload_path'   => FCPATH . 'uploads/marcom/_temp/',
            'allowed_types' => '*',
            'max_size'      => 10240 // 10MB
        ]);

        // Jika upload gagal
        if (!$result['status']) {
            echo json_encode([
                "status" => false,
                "error"  => $result['message']
            ]);
            exit;
        }

        // Jika upload berhasil
        echo json_encode([
            "status"   => true,
            "filename" => $result['data']['file_name'],
            "path"     => $result['data']['relative_path']
        ]);
    }

    public function upload_temp_files()
    {
        $this->_do_upload_temp();
    }
    public function upload_riset_temp_files()
    {
        $this->_do_upload_temp();
    }
    public function upload_riset_kol_temp()
    {
        $this->_do_upload_temp();
    }

    private function _get_kol_data($kol_id)
    {
        $kol_ref = [];

        if (!empty($kol_id)) {

            $kol_ids = array_filter(explode(',', (string) $kol_id));

            if (!empty($kol_ids)) {

                $this->db->select('id, nama, kategory, ratecard');
                $this->db->where_in('id', $kol_ids);
                $kols = $this->db->get('m_kol_marcom')->result();

                foreach ($kols as $i) {
                    $kol_ref[] = [
                        'id'                    => $i->id,
                        'nama'                  => $i->nama,
                        'placement'             => $i->kategory,
                        'budget'                => $i->ratecard
                    ];
                }
            }
        }
        // return $kol_ref;
        return $kol_ref;
    }

    // ==========================================
    // 2. HELPER MOVE FILE (Pindah dari Temp ke Permanen)
    // ==========================================
    private function _move_file_from_temp($filename, $target_folder)
    {
        $source = FCPATH . "uploads/marcom/_temp/" . $filename;
        $dest   = $target_folder . $filename;

        // Buat folder jika belum ada (Recursive)
        if (!is_dir($target_folder)) {
            mkdir($target_folder, 0775, true);
        }

        if (file_exists($source)) {
            rename($source, $dest);
            return true;
        } elseif (file_exists($dest)) {
            return true; // File sudah ada di tujuan (kasus edit)
        }
        return false;
    }

    public function index($type = 1)
    {
        $data['pageTitle']        = "Marcom Pra Produksi";
        $data['css']              = "marcom/css";
        $data['js']               = "marcom/js";
        $data['content']          = "marcom/index";
        if ($type == 2) {
            // --- TAMPILAN URI 2 (Produksi) ---
            $data['pageTitle']       = "Marcom Produksi";
            $data['show_campaign']   = false; // Sembunyikan tab Campaign utama
            // List menu untuk loop
            $data['menu_tabs']       = [
                5 => 'Shooting',
                6 => 'Editing'
            ];
            $data['akun'] = $this->model->get_akun();
        } else {
            // --- TAMPILAN URI 1 / DEFAULT (Pra Produksi) ---
            $data['pageTitle']       = "Marcom Pra Produksi";
            $data['show_campaign']   = true; // Tampilkan tab Campaign utama
            // List menu untuk loop
            $data['menu_tabs']       = [
                1 => 'Riset Campaign',
                2 => 'Content Script',
                3 => 'Riset KOL',
                4 => 'Budgeting'
            ];
        }

        $this->db->where_in('company_id', [2, 3, 5]);
        $data['companies'] = $this->db->get('xin_companies')->result();
        $this->load->view('layout/main', $data);
    }

    public function get_campaigns()
    {
        $user_id = $this->session->userdata('user_id');
        $status = $this->input->post('status');

        // Ambil parameter filter dari POST
        $filters = [
            'start_date' => $this->input->post('start_date'),
            'end_date'   => $this->input->post('end_date'),
            'keyword'    => $this->input->post('keyword')
        ];

        // UBAH DISINI: Gunakan get_campaigns_by_user agar filter PIC berjalan
        $result = $this->model->get_campaigns_by_user($user_id, $filters, $status);

        echo json_encode([
            "status" => true,
            "message" => "Success",
            "data" => $result
        ]);
    }

    public function update_progress()
    {
        $user_id = $this->session->userdata('user_id');

        $id = $this->input->post('id'); // Campaign ID
        $status = $this->input->post('status'); // Tab ID
        $status_progres = $this->input->post('status_progres'); // Target Status
        $oldStatusProgres = $this->input->post('oldStatusProgres');

        if (!$id || !$status || !$status_progres) {
            echo json_encode(["status" => false, "message" => "Parameter tidak lengkap"]);
            return;
        }

        // --- VALIDASI DATA SEBELUM PINDAH KE REVIEW ---
        // Status Review: 3 (Riset), 7 (Script), 11 (KOL), 15 (Budget)
        if (in_array($status_progres, [3, 7, 11, 15])) {
            $valid = true;
            $msg = '';

            // 1. Validasi Tab Riset SPV
            if ($status == 1) {
                $check = $this->db->get_where('t_riset_spv_marcom', ['campaign_id' => $id])->row();
                // Cek apakah report/trend sudah diisi (strip_tags untuk handle summernote empty tags <p><br></p>)
                if (!$check || empty(trim(strip_tags($check->riset_report))) || empty(trim(strip_tags($check->trend_analysis)))) {
                    $valid = false;
                    $msg = 'Data Riset belum lengkap. Mohon isi <b>Riset Report</b> & <b>Trend Analysis</b> terlebih dahulu di tahap In Progress.';
                }
            }
            // 2. Validasi Tab Content Script
            elseif ($status == 2) {
                $check = $this->db->get_where('t_script_marcom', ['campaign_id' => $id])->row();
                // Cek apakah naskah 1 sudah diisi
                if (!$check || empty(trim(strip_tags($check->naskah)))) {
                    $valid = false;
                    $msg = 'Content Script belum diisi. Mohon lengkapi <b>Naskah Utama</b>.';
                }
            }
            // 3. Validasi Tab Riset KOL
            elseif ($status == 3) {
                $checkHeader = $this->db->get_where('t_riset_kol_marcom', ['campaign_id' => $id])->row();
                $count = 0;
                if ($checkHeader) {
                    // Cek apakah ada item KOL di tabel detail
                    $count = $this->db->where('riset_kol_id', $checkHeader->id)->count_all_results('t_riset_kol_items_marcom');
                }
                if ($count == 0) {
                    $valid = false;
                    $msg = 'Belum ada data KOL yang diinput. Mohon tambahkan minimal satu KOL.';
                }
            }
            // 4. Validasi Tab Budgeting
            elseif ($status == 4) {
                $check = $this->db->get_where('t_budgeting_marcom', ['campaign_id' => $id])->row();
                // Cek nominal dan penerima
                if (!$check || $check->total_budget <= 0 || empty($check->nama_penerima)) {
                    $valid = false;
                    $msg = 'Data Budgeting belum lengkap. Mohon isi <b>Form Pengajuan</b> dengan benar.';
                }
            }

            // Jika Validasi Gagal, Kembalikan Error
            if (!$valid) {
                echo json_encode(["status" => false, "message" => $msg]);
                return; // Stop proses update
            }
        }
        // ----------------------------------------------

        // $data_h = [
        //     'id_campaign'   => $id,
        //     'tab'           => $status,
        //     'status_lama'   => $oldStatusProgres,
        //     'status_baru'   => $status_progres,
        //     'created_by'    => $user_id,
        //     'created_at'    => date('Y-m-d H:i:s'),
        // ];
        // $this->db->insert('marcom_h_status', $data_h);

        $result = $this->model->update_progress($id, $status, $status_progres);

        echo json_encode([
            "status" => $result,
            "message" => $result ? "Update berhasil" : "Gagal update"
        ]);
    }

    public function get_campaign_list()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            echo json_encode(['status' => false, 'message' => 'Unauthorized']);
            return;
        }

        // Ambil Filter Params
        $filters = [
            'start_date' => $this->input->post('start_date'),
            'end_date'   => $this->input->post('end_date'),
            'company_id' => $this->input->post('company_id'),
            'pic_id'     => $this->input->post('pic_id'),
            'keyword'    => $this->input->post('keyword')
        ];

        // Kirim $filters ke Model
        $data = $this->model->get_campaigns_by_user($user_id, $filters);

        echo json_encode([
            'status'  => true,
            'message' => 'Success',
            'data'    => $data
        ]);
    }

    // Helper untuk dropdown filter PIC (Ambil semua karyawan dept Marcom)
    public function get_all_marcom_employees()
    {
        // Asumsi dept_id marcom = 137 (sesuai kode get_pic_by_company Anda)
        $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, designation_name");
        $this->db->join('xin_designations', 'xin_designations.designation_id = xin_employees.designation_id', 'left');
        $this->db->where_in('xin_employees.department_id', [137, 169]);
        $this->db->where('is_active', 1);
        $this->db->order_by('first_name', 'ASC');
        $data = $this->db->get('xin_employees')->result();

        echo json_encode($data);
    }

    public function get_pic_by_company()
    {
        $company_id = $this->input->post('company_id');

        if ($company_id == 2) {
            $department_id = 137;
        } elseif ($company_id == 3) {
            $department_id = 169;
        }

        $result = $this->db->query("
        SELECT 
            user_id,
            CONCAT(first_name,' ',last_name) AS full_name,
            designation_name
        FROM xin_employees
        LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
        WHERE xin_employees.company_id = ?
        AND xin_employees.department_id = ?
        AND xin_employees.is_active = 1
        ORDER BY first_name ASC
    ", [$company_id, $department_id])->result();

        echo json_encode($result);
    }

    public function create_campaign()
    {
        $new_id = $this->model->generate_id_campaign();

        // 1. Ambil & Filter File Upload (Lakukan Sekali Saja di Awal)
        $rawFiles = $this->input->post('uploaded_files');
        $refFiles = [];

        if (is_array($rawFiles)) {
            // Filter empty & re-index
            $refFiles = array_values(array_filter($rawFiles, function ($v) {
                return !empty(trim($v));
            }));
        }

        // 2. Ambil Input Lainnya
        $ref_url = $this->input->post('reference_url');
        $ref1 = $ref_url[0] ?? null;
        $ref2 = $ref_url[1] ?? null;
        $ref3 = $ref_url[2] ?? null;

        // $influencer_budget = preg_replace('/[^0-9]/', '', $this->input->post('influencer_budget'));
        // $mediagram_budget = preg_replace('/[^0-9]/', '', $this->input->post('mediagram_budget'));
        $kol_budget = preg_replace('/[^0-9]/', '', $this->input->post('kol_budget'));

        // 4. Mulai Transaksi Database (PENTING)
        $this->db->trans_start();

        $data = [
            'id'             => $new_id,
            'campaign_name'    => $this->input->post('campaign_name'),
            'goals'            => $this->input->post('goals'),
            'big_idea'         => $this->input->post('big_idea'),
            'description'      => $this->input->post('description'),
            'priority'         => $this->input->post('priority'),
            'placement'        => $this->input->post('placement'),
            'start_date'       => $this->input->post('start_date'),
            'end_date'         => $this->input->post('end_date'),
            'company_id'       => $this->input->post('company_id'),
            'pic'              => $this->input->post('pic'),
            // 'influencer_id'    => $this->input->post('influencer_id'),
            // 'influencer_budget' => $influencer_budget,
            // 'mediagram_id'     => $this->input->post('mediagram_id'),
            // 'mediagram_budget' => $mediagram_budget,
            'kol_id'           => $this->input->post('kol_id'),
            'kol_budget'       => $kol_budget,

            'reference_link'   => $ref1,
            'reference_link_2' => $ref2,
            'reference_link_3' => $ref3,
            // Gunakan array yang sudah difilter di atas
            'reference_file'   => $refFiles[0] ?? null,
            'reference_file_2' => $refFiles[1] ?? null,
            'reference_file_3' => $refFiles[2] ?? null,

            'status'           => 1,
            'status_progres'   => 1,
            'created_by'       => $this->session->userdata('user_id'),
            'created_at'       => date('Y-m-d H:i:s'),
        ];

        // 5. Insert Database
        $this->db->insert('t_campaign_marcom', $data);
        $insert_id = $new_id;

        // 6. Pindahkan File (Validasi Keberhasilan)
        $move_success = true; // Flag status

        if (!empty($refFiles)) {
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $insert_id . "/brief/";

            foreach ($refFiles as $f) {
                // Cek apakah file berhasil dipindah
                if (!$this->_move_file_from_temp($f, $targetDir)) {
                    $move_success = false;
                    // Opsional: Break loop atau catat error spesifik
                }
            }
        }

        // 7. Commit atau Rollback
        $this->db->trans_complete();

        // Cek status transaksi DB DAN status pindah file
        if ($this->db->trans_status() === FALSE || !$move_success) {
            // Jika file gagal dipindah, batalkan semua (rollback manual mungkin diperlukan jika trans_complete sudah commit, 
            // tapi biasanya trans_start menghandle db error. Untuk file error, kita kirim status false)

            // Note: CodeIgniter trans_complete otomatis commit jika query DB sukses. 
            // Jika Anda ingin membatalkan insert karena file gagal, Anda harus manual rollback atau delete row yang baru dibuat.

            if (!$move_success) {
                // Hapus data yang baru masuk karena file gagal
                $this->db->delete('t_campaign_marcom', ['id' => $insert_id]);
                echo json_encode(['status' => false, 'message' => 'Gagal memindahkan file lampiran. Silakan coba lagi.']);
            } else {
                echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data ke database.']);
            }
        } else {
            echo json_encode(['status' => true]);
        }
    }

    public function get_kol_list()
    {
        $category = $this->input->post('kategory');

        $data = $this->db->where_in('kategory', explode(',', $category))
            ->get('m_kol_marcom')->result();

        echo json_encode(["data" => $data]);
    }

    public function create_riset_spv_if_not_exist()
    {
        $cid = $this->input->post('campaign_id');

        // cek existing
        $existing = $this->db->get_where('t_riset_spv_marcom', ['campaign_id' => $cid])->row();
        if ($existing) {
            echo json_encode(['status' => true, 'exists' => true]);
            return;
        }

        $data = [
            'campaign_id' => $cid,
            'created_by'  => $this->session->userdata('user_id'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->db->insert('t_riset_spv_marcom', $data);

        echo json_encode(['status' => true]);
    }

    // Tambahkan method ini di dalam class Marcom



    public function save_riset_spv()
    {
        $cid = $this->input->post('campaign_id');

        if (empty($cid)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID is required']);
            return;
        }

        // 1. Handle Links (UBAH DISINI: json_encode -> implode)
        $links = $this->input->post('riset_link');
        // Menggunakan implode agar format di DB: "link1,link2"
        $links_str = !empty($links) ? implode(',', $links) : null;

        // 2. Handle Files
        $uploaded_files = $this->input->post('uploaded_riset_files');
        $final_files = [];

        if (!empty($uploaded_files)) {
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $cid . "/riset_spv/";

            foreach ($uploaded_files as $f) {
                if ($this->_move_file_from_temp($f, $targetDir)) {
                    $final_files[] = $f;
                }
            }
        }

        $files_str = !empty($final_files) ? implode(',', $final_files) : null;

        // 3. Prepare Data
        $dataRiset = [
            'riset_report'   => $this->input->post('riset_report'),
            'trend_analysis' => $this->input->post('trend_analysis'),
            'riset_link'     => $links_str, // Sekarang string dipisah koma
            'riset_file'     => $files_str,
            'updated_by'     => $this->session->userdata('user_id'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $exists = $this->db->get_where('t_riset_spv_marcom', ['campaign_id' => $cid])->num_rows();

        if ($exists > 0) {
            $this->db->where('campaign_id', $cid);
            $this->db->update('t_riset_spv_marcom', $dataRiset);
        } else {
            $dataRiset['campaign_id'] = $cid;
            $dataRiset['created_by']  = $this->session->userdata('user_id');
            $dataRiset['created_at']  = date('Y-m-d H:i:s');
            $this->db->insert('t_riset_spv_marcom', $dataRiset);
        }

        // 4. Update Status Campaign ke Review (3)
        $this->model->update_progress($cid, 1, 3);

        //get pic from riset spv
        $listPic = $this->db->where('id', $cid)->get('t_campaign_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($cid, $listPic);

        echo json_encode(['status' => true, 'message' => 'Data saved & Moved to Review']);
    }

    public function get_riset_spv_detail()
    {
        $id = $this->input->post('campaign_id');

        // 1. Ambil Data Campaign
        $this->db->select('
        c.*');
        $this->db->from('t_campaign_marcom c');
        $this->db->where('c.id', $id);
        $campaign = $this->db->get()->row();

        if (!$campaign) {
            echo json_encode(['status' => false, 'message' => 'Campaign not found']);
            return;
        }

        $deadline = date('Y-m-d', strtotime($campaign->start_date . ' +7 days'));

        // 2. Ambil Data PIC (Convert ID "1,4" menjadi Nama "Budi, Andi")
        $pic_data = [];
        if (!empty($campaign->pic)) {
            $pic_ids = array_filter(explode(',', $campaign->pic));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();
                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        $influencer_ref = $this->_get_kol_data($campaign->kol_id);

        // 3. Ambil Data Riset SPV (dari tabel baru)
        $riset = $this->db->get_where('t_riset_spv_marcom', ['campaign_id' => $id])->row();

        // 4. Siapkan Link Campaign (Array) untuk ditampilkan di modal
        $links = [];
        if (!empty($campaign->reference_link)) $links[] = $campaign->reference_link;
        if (!empty($campaign->reference_link_2)) $links[] = $campaign->reference_link_2;
        if (!empty($campaign->reference_link_3)) $links[] = $campaign->reference_link_3;

        // 5. Siapkan File Campaign (Array Object)
        $files = [];
        $base_url_file = base_url('uploads/marcom/campaigns/' . $id . '/brief/');

        if (!empty($campaign->reference_file))
            $files[] = ["name" => $campaign->reference_file, "url" => $base_url_file . $campaign->reference_file];
        if (!empty($campaign->reference_file_2))
            $files[] = ["name" => $campaign->reference_file_2, "url" => $base_url_file . $campaign->reference_file_2];
        if (!empty($campaign->reference_file_3))
            $files[] = ["name" => $campaign->reference_file_3, "url" => $base_url_file . $campaign->reference_file_3];

        // 6. Return JSON
        echo json_encode([
            "campaign" => $campaign,
            "influencer_ref" => $influencer_ref,
            "pics"     => $pic_data,
            "links"    => $links,
            "files"    => $files,
            "riset"    => $riset,
            "deadline" => $deadline
        ]);
    }

    // --- TAMBAHKAN DI DALAM CLASS Marcom ---

    public function get_review_riset_detail()
    {
        $id = $this->input->post('campaign_id');

        $this->db->select('
            c.id, c.campaign_name, c.start_date, c.end_date, c.priority, c.placement, c.description, c.pic,
            c.goals, c.big_idea, 
            c.reference_link, c.reference_link_2, c.reference_link_3,
            c.reference_file, c.reference_file_2, c.reference_file_3, 
            c.company_id,
            c.kol_id, c.kol_budget,
            
            r.id as riset_id, r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, r.riset_note, DATE(DATE_ADD(r.updated_at, INTERVAL 2 DAY)) as deadline
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }


        $pic_data = [];
        if (!empty($data->pic)) {
            $pic_ids = array_filter(explode(',', $data->pic));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();
                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        // Parsing File & Link Riset
        $data->riset_files_arr = !empty($data->riset_file) ? explode(',', $data->riset_file) : [];
        $data->riset_links_arr = !empty($data->riset_link) ? explode(',', $data->riset_link) : [];

        echo json_encode([
            'status' => true,
            'data' => $data,
            'pics' => $pic_data,
            'influencer_ref' => $influencer_ref
        ]);
    }

    // --- TAMBAHKAN DI DALAM CLASS Marcom ---


    public function approve_riset_spv()
    {
        $campaign_id = $this->input->post('campaign_id');
        $riset_id    = $this->input->post('riset_id');
        $note        = $this->input->post('note');
        $user_id     = $this->session->userdata('user_id');
        $pic       = $this->input->post('pic');

        if (!$campaign_id || !$riset_id) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            return;
        }

        // Gunakan Transaction agar semua query berhasil atau gagal bersamaan
        $this->db->trans_start();

        // 1. Update t_riset_spv_marcom (Simpan Note & Set Status = 4)
        $this->db->where('id', $riset_id);
        $this->db->update('t_riset_spv_marcom', [
            'riset_note'       => $note,
            'status'     => 4, // Completed/Approved
            'updated_by' => $user_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 2. Update t_campaign_marcom (Status Progres = 4)
        $this->db->where('id', $campaign_id);
        $this->db->update('t_campaign_marcom', [
            'status_progres' => 4, // Completed di kolom Riset
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        // 3. Insert ke t_script_marcom (Prepare next stage)
        // Cek dulu apakah sudah ada script untuk campaign ini agar tidak duplikat
        $check_script = $this->db->get_where('t_script_marcom', ['campaign_id' => $campaign_id])->row();

        if (!$check_script) {
            $dataScript = [
                'campaign_id' => $campaign_id,
                'status'      => 5,
                'pic'         => $pic,
                'created_by'  => $user_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'deadline'    => $this->input->post('deadline_naskah')
            ];
            $this->db->insert('t_script_marcom', $dataScript);
        }

        $this->model->update_progress($campaign_id, 2, 5);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Approval failed']);
        } else {
            echo json_encode(['status' => true, 'message' => 'Riset Approved & Moved to Script']);
        }
    }

    // logika content script

    public function get_script_detail()
    {
        $id = $this->input->post('campaign_id');

        // Join 3 Tabel: Campaign + Script + Riset (untuk history)
        $this->db->select('
            c.*, 
            s.id as script_id,
            s.naskah,
            s.naskah_2,
            s.naskah_3,
            s.naskah_ai,
            r.riset_report,
            r.trend_analysis,
            r.riset_link,
            r.riset_file,
            s.pic as pics,
            r.riset_note, 
            r.updated_at as riset_date,
            s.deadline
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);

        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        $pic_data = [];
        if (!empty($data->pics)) {
            $pic_ids = array_filter(explode(',', $data->pics));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();

                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');

                    $pic_data[] = [
                        'name' => $e->full_name,
                        'avatar' => $avatar
                    ];
                }
            }
        }

        echo json_encode([
            'status' => true,
            'data'   => $data,
            'influencer_ref' => $influencer_ref,
            'pics'   => $pic_data
        ]);
    }

    public function generate_script()
    {
        // 1. Ambil Campaign ID (Wajib)
        $cid = $this->input->post('campaign_id');

        if (empty($cid)) {
            echo json_encode(['status' => false, 'message' => 'Campaign ID required']);
            return;
        }
        $ch = curl_init();


        $postFields = [
            'id' => $cid,
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://n8n.trustcore.id/webhook/marcom-content-copywriting',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            // DO NOT manually set multipart content-type here
        ]);

        $response = curl_exec($ch);
        if ($response === false) {
            // Capture error as the "data"
            $data = [
                'curl_error' => curl_error($ch),
                'curl_errno' => curl_errno($ch)
            ];
        } else {
            $data = json_decode($response, true);
        }

        curl_close($ch);
        // 2. Ambil Data Input
        // $name = $this->input->post('campaign_name');
        // $goals = $this->input->post('goals');
        // $idea = $this->input->post('big_idea');

        // // 3. Generate Content
        // $dummy_text = "<b>[AI Generated Script]</b><br>";
        // $dummy_text .= "<b>Campaign:</b> $name<br>";
        // $dummy_text .= "<b>Concept:</b> $idea<br>";
        // $dummy_text .= "---------------------------------<br>";
        // $dummy_text .= "<b>Scene 1:</b> Opening yang menarik perhatian audiens sesuai dengan goals '$goals'.<br>";
        // $dummy_text .= "<b>Scene 2:</b> Penjelasan produk/jasa dengan gaya bahasa santai.<br>";
        // $dummy_text .= "<b>Scene 3:</b> Call to Action yang kuat.";

        // 4. Update Database (Simpan ke naskah_ai)
        // Asumsi: Row sudah dibuat oleh 'create_script_if_not_exist' saat geser kartu
        $this->db->where('campaign_id', $cid);
        $this->db->update('t_script_marcom', [
            'naskah_ai'  => $data["finalHtml"]
        ]);
        $naskahList = explode("<br>---------------------------------<br><br>", $data['finalHtml']);
        // var_dump($naskahList);


        // // 5. Return JSON (Kirim text balik untuk ditampilkan di Summernote)
        echo json_encode([
            'status' => true,
            'data' => $data["finalHtml"],
            'naskahList' => $naskahList,
            'dataAll' => $data["data"],
            'message' => 'Success generating script by AI'
        ]);
    }

    public function save_script()
    {
        $cid = $this->input->post('campaign_id');

        // Simpan 3 variasi naskah
        $data = [
            'naskah'     => $this->input->post('naskah'),
            'naskah_2'   => $this->input->post('naskah_2'),
            'naskah_3'   => $this->input->post('naskah_3'),
            'updated_by' => $this->session->userdata('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->trans_start();

        // Cek apakah data sudah ada
        $exists = $this->db->get_where('t_script_marcom', ['campaign_id' => $cid])->num_rows();

        if ($exists > 0) {
            $data['status'] = 7; // Set ke In Review saat disimpan
            $this->db->where('campaign_id', $cid);
            $this->db->update('t_script_marcom', $data);
        } else {
            $data['campaign_id'] = $cid;
            $data['created_at'] = date('Y-m-d H:i:s');
            $data['status'] = 5; // Default pending
            $this->db->insert('t_script_marcom', $data);
        }

        // 2. Update t_campaign_marcom (Status Progres = 4)
        $this->db->where('id', $cid);
        $this->db->update('t_campaign_marcom', [
            'status_progres' => 7, // Completed di kolom Riset
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();

        //get pic from t_script_marcom
        $listPic = $this->db->where('campaign_id', $cid)->get('t_script_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($cid, $listPic);

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Save failed']);
        } else {
            echo json_encode(['status' => true, 'message' => 'Script saved successfully']);
        }
    }

    // --- TAMBAHKAN DI DALAM CLASS Marcom ---

    public function get_review_script_detail()
    {
        $id = $this->input->post('campaign_id');

        $this->db->select('
            c.id, c.campaign_name, c.start_date, c.end_date, c.priority, c.placement, c.description,
            c.goals, c.big_idea, 
            c.reference_link, c.reference_link_2, c.reference_link_3,
            c.reference_file, c.reference_file_2, c.reference_file_3,
            c.kol_id, c.kol_budget, c.company_id,
            s.id as script_id, s.naskah, s.naskah_2, s.naskah_3, s.naskah_ai, s.naskah_final, s.note as note_approve, s.pic as pics,
            r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, r.riset_note, DATE(DATE_ADD(s.updated_at, INTERVAL 3 DAY)) as deadline,s.deadline as deadline_script
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // Ambil Data PIC (Helper visual)
        $pic_data = [];
        if (!empty($data->pics)) {
            $pic_ids = array_filter(explode(',', $data->pics));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();

                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        echo json_encode([
            'status' => true,
            'data' => $data,
            'pics' => $pic_data,
            'influencer_ref' => $influencer_ref
        ]);
    }

    public function approve_script()
    {
        $campaign_id  = $this->input->post('campaign_id');
        $script_id    = $this->input->post('script_id');
        $naskah_final = $this->input->post('naskah_final'); // Isi text naskah yang dipilih
        $note         = $this->input->post('note');
        $pic          = $this->input->post('pic'); // Next PIC
        $user_id      = $this->session->userdata('user_id');

        if (!$campaign_id || !$script_id) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            return;
        }

        if (empty($naskah_final)) {
            echo json_encode(['status' => false, 'message' => 'Anda harus memilih salah satu naskah sebagai final!']);
            return;
        }

        $this->db->trans_start();

        // 1. Update t_script_marcom (Status Completed = 8)
        $this->db->where('id', $script_id);
        $this->db->update('t_script_marcom', [
            'naskah_final' => $naskah_final,
            'note'         => $note,
            'status'       => 8, // Completed Tab 2
            'updated_by'   => $user_id,
            'updated_at'   => date('Y-m-d H:i:s')
        ]);

        // 2. Update t_campaign_marcom (Status Progres = 8)
        $this->db->where('id', $campaign_id);
        $this->db->update('t_campaign_marcom', [
            'status_progres' => 8, // Completed visually
            'updated_at'     => date('Y-m-d H:i:s')
        ]);

        // 3. Insert ke Next Task (Riset KOL / Tab 3)
        // -------------------------------------------------------------
        // Cek existing agar tidak duplikat
        $check_next = $this->db->get_where('t_riset_kol_marcom', ['campaign_id' => $campaign_id])->row();

        if (!$check_next) {
            $dataNext = [
                'campaign_id' => $campaign_id,
                'status'      => 9, // Status 9 = Pending di Riset KOL
                'pic'         => $pic, // PIC yang dipilih user di modal
                'created_by'  => $user_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'deadline'    => $this->input->post('deadline_kol')
            ];
            $this->db->insert('t_riset_kol_marcom', $dataNext);
        }
        // -------------------------------------------------------------

        // Update main table to point to Tab 3 (id=3), Status Pending (9)
        $this->model->update_progress($campaign_id, 3, 9);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Approval failed']);
        } else {
            echo json_encode(['status' => true, 'message' => 'Script Approved & Moved to Riset KOL']);
        }
    }

    // --- LOGIC RISET KOL (TAB 3) ---

    public function create_riset_kol_if_not_exist()
    {
        $cid = $this->input->post('campaign_id');

        $existing = $this->db->get_where('t_riset_kol_marcom', ['campaign_id' => $cid])->row();

        if ($existing) {
            echo json_encode(['status' => true, 'exists' => true]);
            return;
        }

        // Insert Data Awal
        $data = [
            'campaign_id' => $cid,
            'status'      => 9, // Pending Riset KOL
            'created_by'  => $this->session->userdata('user_id'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->db->insert('t_riset_kol_marcom', $data);
        echo json_encode(['status' => true]);
    }

    // --- LOGIC RISET KOL (TAB 3) - UPDATED MULTIPLE KOL ---

    public function get_riset_kol_detail()
    {
        $id = $this->input->post('campaign_id');

        // 1. Ambil Header (Campaign + Riset KOL Header + Script Final)
        $this->db->select('
        c.*,
        rk.id as riset_kol_id, rk.pic as pic_riset, rk.files, rk.note, rk.deadline,
        s.naskah_final, s.note as script_note,
        r.*');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);
        $header = $this->db->get()->row();

        if (!$header) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // 2. Ambil Items (Detail Multiple KOL)
        $items = [];
        if ($header->riset_kol_id) {
            $items = $this->db->get_where('t_riset_kol_items_marcom', ['riset_kol_id' => $header->riset_kol_id])->result();
        }

        $influencer_ref = $this->_get_kol_data($header->kol_id);

        // 3. Process PIC (Sama seperti sebelumnya)
        $pic_data = [];
        if (!empty($header->pic_riset)) {
            $pic_ids = array_filter(explode(',', $header->pic_riset));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();
                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        // 4. Master KOL List (Untuk Dropdown)
        $kols = $this->db->select('id, nama, kategory')->get('m_kol_marcom')->result();

        // 5. Files (Global)
        $files_arr = [];
        if (!empty($header->files)) {
            $files_raw = explode(',', $header->files); // Disimpan koma separated
            foreach ($files_raw as $f) {
                // Gunakan struktur folder baru: campaigns/{id}/riset_kol/
                $files_arr[] = [
                    'name' => $f,
                    'url'  => base_url('uploads/marcom/campaigns/' . $id . '/riset_kol/' . $f)
                ];
            }
        }

        echo json_encode([
            'status' => true,
            'data'   => $header,
            'items'  => $items,
            'kols'   => $kols,
            'files'  => $files_arr,
            'pics'   => $pic_data,
            'influencer_ref' => $influencer_ref
        ]);
    }

    public function save_riset_kol()
    {
        $cid = $this->input->post('campaign_id');

        // 1. Handle Files (Global) - Multiple Files
        $uploaded_files = $this->input->post('uploaded_files'); // Array
        $final_files = [];

        if (!empty($uploaded_files)) {
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $cid . "/riset_kol/";
            foreach ($uploaded_files as $f) {
                if ($this->_move_file_from_temp($f, $targetDir)) {
                    $final_files[] = $f;
                }
            }
        }
        $files_str = !empty($final_files) ? implode(',', $final_files) : null;

        // 2. Update Header
        $headerData = [
            'files'      => $files_str,
            'updated_by' => $this->session->userdata('user_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->db->where('campaign_id', $cid);
        $this->db->update('t_riset_kol_marcom', $headerData);

        // Ambil ID Header
        $header = $this->db->get_where('t_riset_kol_marcom', ['campaign_id' => $cid])->row();
        $riset_kol_id = $header->id;

        // 3. Handle Items (Detail KOL) - Delete Insert Strategy
        // Hapus items lama
        $this->db->delete('t_riset_kol_items_marcom', ['riset_kol_id' => $riset_kol_id]);

        // Ambil array data dari form
        $kol_ids = $this->input->post('kol_id'); // Array

        if (!empty($kol_ids) && is_array($kol_ids)) {
            foreach ($kol_ids as $index => $k_id) {
                if (empty($k_id)) continue;

                $itemData = [
                    'riset_kol_id' => $riset_kol_id,
                    'kol_id'       => $k_id,
                    'follower_ig'  => $_POST['follower_ig'][$index] ?? 0,
                    'follower_tt'  => $_POST['follower_tt'][$index] ?? 0,
                    'rate_card_ig' => $_POST['rate_card_ig'][$index] ?? 0,
                    'rate_card_tt' => $_POST['rate_card_tt'][$index] ?? 0,
                    'konten_1_ig'  => $_POST['konten_1_ig'][$index] ?? 0,
                    'konten_2_ig'  => $_POST['konten_2_ig'][$index] ?? 0,
                    'konten_3_ig'  => $_POST['konten_3_ig'][$index] ?? 0,
                    'konten_4_ig'  => $_POST['konten_4_ig'][$index] ?? 0,
                    'konten_5_ig'  => $_POST['konten_5_ig'][$index] ?? 0,
                    'konten_1_tt'  => $_POST['konten_1_tt'][$index] ?? 0,
                    'konten_2_tt'  => $_POST['konten_2_tt'][$index] ?? 0,
                    'konten_3_tt'  => $_POST['konten_3_tt'][$index] ?? 0,
                    'konten_4_tt'  => $_POST['konten_4_tt'][$index] ?? 0,
                    'konten_5_tt'  => $_POST['konten_5_tt'][$index] ?? 0,
                ];
                $this->db->insert('t_riset_kol_items_marcom', $itemData);

                // Update Master KOL (m_kol_marcom)
                $data_master = [
                    'follower_ig'       => $itemData['follower_ig'],
                    'follower_tt'       => $itemData['follower_tt'],
                    'last_rate_card_ig' => $itemData['rate_card_ig'],
                    'last_rate_card_tt' => $itemData['rate_card_tt'],
                    'last_konten_1_ig'  => $itemData['konten_1_ig'],
                    'last_konten_2_ig'  => $itemData['konten_2_ig'],
                    'last_konten_3_ig'  => $itemData['konten_3_ig'],
                    'last_konten_4_ig'  => $itemData['konten_4_ig'],
                    'last_konten_5_ig'  => $itemData['konten_5_ig'],
                    'last_konten_1_tt'  => $itemData['konten_1_tt'],
                    'last_konten_2_tt'  => $itemData['konten_2_tt'],
                    'last_konten_3_tt'  => $itemData['konten_3_tt'],
                    'last_konten_4_tt'  => $itemData['konten_4_tt'],
                    'last_konten_5_tt'  => $itemData['konten_5_tt']
                ];
                $this->db->where('id', $k_id);
                $this->db->update('m_kol_marcom', $data_master);
            }
        }

        $this->model->update_progress($cid, 3, 11);

        $listPic = $this->db->where('campaign_id', $cid)->get('t_riset_kol_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($cid, $listPic);
        echo json_encode(['status' => true, 'message' => 'Data saved!']);
    }

    public function get_review_riset_kol_detail()
    {
        $id = $this->input->post('campaign_id');

        $this->db->select('
            c.*,
            rk.id as riset_kol_id, rk.files, rk.note as note_approve, rk.pic as pic_riset,  
            s.naskah_final, s.note as script_note,
            r.riset_report, r.trend_analysis, r.riset_link as r_link, r.riset_file as r_file, r.riset_note,
            DATE(DATE_ADD(rk.updated_at, INTERVAL 2 DAY)) as  deadline,
            rk.deadline as deadline_riset
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);
        $header = $this->db->get()->row();

        if (!$header) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // Ambil Items
        $this->db->select('i.*, k.nama as kol_nama, k.username_ig as kol_akun');
        $this->db->from('t_riset_kol_items_marcom i');
        $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
        $this->db->where('i.riset_kol_id', $header->riset_kol_id);
        $items = $this->db->get()->result();

        // Process PIC
        $pic_data = [];
        if (!empty($header->pic_riset)) {
            $pic_ids = array_filter(explode(',', $header->pic_riset));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();
                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        $influencer_ref = $this->_get_kol_data($header->kol_id);
        // Files Global
        $files_arr = [];
        if (!empty($header->files)) {
            $files_raw = explode(',', $header->files);
            foreach ($files_raw as $f) {
                $files_arr[] = ['name' => $f, 'url'  => base_url('uploads/marcom/campaigns/' . $id . '/riset_kol/' . $f)];
            }
        }

        echo json_encode([
            'status' => true,
            'data'   => $header,
            'items'  => $items,
            'files'  => $files_arr,
            'pics'   => $pic_data,
            'influencer_ref' => $influencer_ref
        ]);
    }

    public function approve_riset_kol()
    {
        $campaign_id = $this->input->post('campaign_id');
        $riset_id    = $this->input->post('riset_id'); // ID dari t_riset_kol_marcom
        $note        = $this->input->post('note');
        $pic         = $this->input->post('pic'); // Next PIC untuk Budgeting
        $user_id     = $this->session->userdata('user_id');

        if (!$campaign_id || !$riset_id) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            return;
        }

        $this->db->trans_start();

        // 1. Update t_riset_kol_marcom (Status Completed = 12)
        // Status Flow Tab 3: 9(Pending) -> 10(InProg) -> 11(Review) -> 12(Completed)
        $this->db->where('id', $riset_id);
        $this->db->update('t_riset_kol_marcom', [
            'note'       => $note,
            'status'     => 12
        ]);

        // 2. Update t_campaign_marcom (Status Progres = 12)
        $this->db->where('id', $campaign_id);
        $this->db->update('t_campaign_marcom', [
            'status_progres' => 12
        ]);

        // 3. Insert ke Next Task (Budgeting / Tab 4)
        // Table: t_budgeting_marcom
        // Status awal tab 4 adalah 13 (Pending)
        $check_next = $this->db->get_where('t_budgeting_marcom', ['campaign_id' => $campaign_id])->row();

        if (!$check_next) {
            $dataNext = [
                'campaign_id' => $campaign_id,
                'status'      => 13,
                'pic'         => $pic,
                'created_by'  => $user_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'deadline' => $this->input->post('deadline_budgeting')
            ];
            $this->db->insert('t_budgeting_marcom', $dataNext);
        }

        // 4. Update Main Status ke Tab 4 (Budgeting)
        $this->model->update_progress($campaign_id, 4, 13);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Approval failed']);
        } else {
            echo json_encode(['status' => true, 'message' => 'Riset KOL Approved & Moved to Budgeting']);
        }
    }

    public function create_budgeting_if_not_exist()
    {
        $cid = $this->input->post('campaign_id');
        $existing = $this->db->get_where('t_budgeting_marcom', ['campaign_id' => $cid])->row();

        if (!$existing) {
            $data = [
                'campaign_id' => $cid,
                'status'      => 13, // Pending Budgeting
                'created_by'  => $this->session->userdata('user_id'),
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $this->db->insert('t_budgeting_marcom', $data);
        }
        echo json_encode(['status' => true]);
    }

    public function get_budgeting_detail()
    {
        $id = $this->input->post('campaign_id');
        $this->db->select('
            c.campaign_name, c.start_date, c.end_date, c.priority, c.placement, c.description, c.goals, c.big_idea, c.reference_link, c.reference_link_2, c.reference_link_3, c.reference_file, c.reference_file_2, c.reference_file_3, 
            c.kol_id,c.kol_budget,
            r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, r.riset_note,
            s.naskah_final,s.note as script_note,
            b.*, 
            rk.id as riset_kol_id, rk.files as files_kol, rk.note as kol_note,
            b.pic as pic_budget
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false]);
            return;
        }

        // 2. Ambil Items Riset KOL (Approved Reference - Untuk Contekan)
        $kol_items = [];
        if ($data->riset_kol_id) {
            $this->db->select('i.*, k.nama as kol_nama');
            $this->db->from('t_riset_kol_items_marcom i');
            $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
            $this->db->where('i.riset_kol_id', $data->riset_kol_id);
            $kol_items = $this->db->get()->result();
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        $pic_data = [];
        if (!empty($data->pic_budget)) {
            $pic_ids = array_filter(explode(',', $data->pic_budget));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();

                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        // 3. File Lampiran URL
        $file_url = $data->file_lampiran ? base_url('uploads/marcom/campaigns/' . $id . '/budgeting/' . $data->file_lampiran) : null;

        echo json_encode([
            'status'    => true,
            'data'      => $data,
            'kol_items' => $kol_items,
            'file_url'  => $file_url,
            'pics'      => $pic_data,
            'influencer_ref' => $influencer_ref
        ]);
    }

    public function get_eaf_budget_list()
    {
        $company_id = $this->input->post('company_id');
        $data = $this->model->get_eaf_jenis_biaya($company_id);
        echo json_encode($data);
    }

    // --- API HELPER UNTUK DROPDOWN BUDGETING ---

    public function get_master_eaf_data()
    {
        $data = [
            'pengaju'   => $this->model->get_eaf_pengaju(),
            'kategori'  => $this->model->get_eaf_kategori(),
            'company'   => $this->model->get_eaf_company(),
            'project'   => $this->model->get_project()
        ];
        echo json_encode($data);
    }

    public function get_jenis_biaya_eaf()
    {
        $company_id = $this->input->post('company_id');
        // Bersihkan nominal dari format Rp/Titik
        $nominal    = preg_replace('/[^0-9]/', '', $this->input->post('nominal'));

        $data = $this->model->get_jenis_biaya_by_company($company_id, $nominal);
        echo json_encode($data);
    }

    public function upload_budgeting_temp()
    {
        $this->_do_upload_temp();
    }

    public function save_budgeting()
    {
        $cid = $this->input->post('campaign_id');
        $temp_file = $this->input->post('uploaded_file_budget');

        // 1. Handle File Upload (Cek Existing & Move New)
        $file_name = null;
        $existing = $this->db->get_where('t_budgeting_marcom', ['campaign_id' => $cid])->row();

        if ($existing && !empty($existing->file_lampiran)) {
            $file_name = $existing->file_lampiran;
        }

        if (!empty($temp_file)) {
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $cid . "/budgeting/";
            if (!is_dir($targetDir)) mkdir($targetDir, 0775, true);

            if ($this->_move_file_from_temp($temp_file, $targetDir)) {
                $file_name = $temp_file;
            }
        }

        // 2. Cleaning Data
        // Hapus karakter non-digit (Rp, titik, spasi)
        $nominal_clean = preg_replace('/[^0-9]/', '', $this->input->post('total_budget'));

        // 3. Parsing Data EAF dari Dropdown
        // Format value: id_jenis|id_biaya|nama_jenis|user_approval|tipe_biaya|budget|project|blok|id_user_verified|ba
        $raw_keperluan = $this->input->post('nama_keperluan');
        $eaf_meta = explode('|', $raw_keperluan);

        // 4. Ambil Project ID (Jika Company = 2)
        $id_project = null;
        if ($this->input->post('company_id') == 2) {
            $id_project = $this->input->post('project_id');
        }

        $data = [
            'nama_penerima'   => $this->input->post('nama_penerima'),
            'yang_mengajukan' => $this->input->post('yang_mengajukan'),
            'kategori_id'     => $this->input->post('kategori_id'),
            'tipe_pembayaran' => $this->input->post('tipe_pembayaran'),
            'nama_bank'       => $this->input->post('nama_bank'),
            'nomor_rekening'  => $this->input->post('nomor_rekening'),

            'total_budget'    => $nominal_clean,
            'company_id'      => $this->input->post('company_id'),
            'id_project'      => $id_project,
            'note'            => $this->input->post('note'),
            'file_lampiran'   => $file_name,

            // SIMPAN METADATA EAF (PENTING UNTUK INTEGRASI)
            'eaf_id_jenis'      => $eaf_meta[0] ?? null,
            'eaf_id_biaya'      => $eaf_meta[1] ?? null,
            'nama_keperluan'    => $eaf_meta[2] ?? null, // Simpan Nama Text-nya
            'eaf_user_approval' => $eaf_meta[3] ?? null,
            'eaf_id_tipe_biaya' => $eaf_meta[4] ?? null,
            'eaf_user_verified' => $eaf_meta[8] ?? null, // Index 8 adalah user_verified sesuai format get_jenis_biaya
            'updated_at'        => date('Y-m-d H:i:s'),
            'updated_by'        => $this->session->userdata('user_id')
        ];

        // Update ke Tabel Budgeting
        $this->db->where('campaign_id', $cid);
        $this->db->update('t_budgeting_marcom', $data);

        // 4. Update Status ke Review (15)
        // Agar Task pindah ke kolom Review dan tombol Approve muncul
        $this->model->update_progress($cid, 4, 15);

        $listPic = $this->db->where('campaign_id', $cid)->get('t_budgeting_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($cid, $listPic);

        echo json_encode(['status' => true, 'message' => 'Pengajuan Budget Disimpan!']);
    }

    // --- REVIEW & APPROVAL BUDGETING (EAF INTEGRATION) ---

    public function get_review_budget_detail()
    {
        $id = $this->input->post('campaign_id');
        $this->db->select('
            c.campaign_name, c.start_date, c.end_date, c.priority, c.placement, c.description, c.goals, c.big_idea, c.reference_link, c.reference_link_2, c.reference_link_3, c.reference_file, c.reference_file_2, c.reference_file_3, 
            c.kol_id,c.kol_budget, c.company_id,
            r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, r.riset_note,
            s.naskah_final,s.note as script_note,
            b.*, DATE(DATE_ADD(b.updated_at, INTERVAL 7 DAY)) as deadline_shooting,
            rk.id as riset_kol_id, rk.files as files_kol, rk.note as kol_note,
            b.pic as pic_budget,
            comp.name as company_name,
            proj.project as project_name
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('xin_companies comp', 'comp.company_id = c.company_id', 'left');

        // Join Project (Left Join karena id_project bisa null)
        // Sesuaikan nama tabel project jika beda (rsp_project_live.m_project)
        $this->db->join('rsp_project_live.m_project proj', 'proj.id_project = b.id_project', 'left');

        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // Ambil Nama Pengaju
        $nama_pengaju = '-';
        if ($data->yang_mengajukan) {
            $emp = $this->db->select("CONCAT(first_name,' ',last_name) as full_name")->where('user_id', $data->yang_mengajukan)->get('xin_employees')->row();
            if ($emp) $nama_pengaju = $emp->full_name;
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        $pic_data = [];
        if (!empty($data->pic_budget)) {
            $pic_ids = array_filter(explode(',', $data->pic_budget));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();

                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        // Ambil Detail KOL Approved
        $kol_items = [];
        if ($data->riset_kol_id) {
            $this->db->select('i.*, k.nama as kol_nama');
            $this->db->from('t_riset_kol_items_marcom i');
            $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
            $this->db->where('i.riset_kol_id', $data->riset_kol_id);
            $kol_items = $this->db->get()->result();
        }

        // LOGIC NAMA APPROVER
        $nama_approver = '-';
        $approved_at = '-';

        // Cek jika status Completed (16)
        if ($data->status == 16) {
            $approver_id = $data->updated_by; // User yang klik Approve
            if ($approver_id) {
                $emp = $this->db->select("CONCAT(first_name,' ',last_name) as full_name")->where('user_id', $approver_id)->get('xin_employees')->row();
                if ($emp) $nama_approver = $emp->full_name;
            }
            $approved_at = date('d M Y H:i', strtotime($data->updated_at));
        }

        $file_url = $data->file_lampiran ? base_url('uploads/marcom/campaigns/' . $id . '/budgeting/' . $data->file_lampiran) : null;

        echo json_encode([
            'status'       => true,
            'data'         => $data,
            'kol_items'    => $kol_items,
            'file_url'     => $file_url,
            'nama_pengaju' => $nama_pengaju,
            'nama_approver' => $nama_approver,
            'approved_at'   => $approved_at,
            'influencer_ref' => $influencer_ref,
            'pics'     => $pic_data
        ]);
    }

    public function approve_budget()
    {
        // 1. Ambil Data Inputan dari POST
        $campaign_id  = $this->input->post('campaign_id');
        $budget_id    = $this->input->post('budget_id');
        $note_approve = $this->input->post('note');
        $user_id      = $this->session->userdata('user_id');
        $pic         = $this->input->post('pic');

        // 2. Validasi ID tidak boleh kosong
        if (!$campaign_id || !$budget_id) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            return;
        }

        // 3. Ambil Data Budgeting dari Database Marcom
        $budgetData = $this->db->get_where('t_budgeting_marcom', ['id' => $budget_id])->row();

        // 4. Validasi Kelengkapan Data EAF
        if (!$budgetData || empty($budgetData->eaf_id_jenis)) {
            echo json_encode(['status' => false, 'message' => 'Data EAF tidak lengkap (Keperluan/Kategori belum dipilih). Silakan revisi inputan.']);
            return;
        }

        // --- MULAI TRANSAKSI DATABASE ---
        $this->db->trans_start();

        // 5. Tentukan Prefix Database & Generate ID
        $db_prefix = ($budgetData->company_id == 2) ? 'rsp_project_live.' : 'e_eaf.';
        $id_pengajuan_eaf = $this->model->generate_id_eaf($budgetData->company_id);
        $date_now = date('Y-m-d H:i:s');

        // ============================================================
        // LOGIC KHUSUS COMPANY ID 2 (RSP - BENCHMARK LOGIC)
        // ============================================================
        if ($budgetData->company_id == 2) {

            // A. Ambil Batas Minimal Approve (UPDATED LOGIC)
            // Join e_jenis_biaya dengan e_biaya berdasarkan bulan & tahun berjalan
            $current_month = date('m');
            $current_year  = date('Y');

            $this->db->select('b.minimal_approve');
            $this->db->from('rsp_project_live.e_jenis_biaya j');
            $this->db->join('rsp_project_live.e_biaya b', 'j.id_budget = b.id_budget');
            $this->db->where('j.id_jenis', $budgetData->eaf_id_jenis);
            $this->db->where('b.bulan', $current_month);
            $this->db->where('b.tahun_budget', $current_year);

            $result_minimal = $this->db->get()->row();
            $minimal_approve = $result_minimal ? $result_minimal->minimal_approve : 0;

            // B. Tentukan Status Awal & User Approval
            // Logic: Cek User Verified
            $status_eaf = 1;
            $user_approval_eaf = $budgetData->eaf_user_approval;

            if (!empty($budgetData->eaf_user_verified)) {
                $status_eaf = 10;
                $user_approval_eaf = $budgetData->eaf_user_verified;
            }

            // C. Insert Header (e_pengajuan)
            $eaf_pengajuan = [
                'id_pengajuan'  => $id_pengajuan_eaf,
                'tgl_input'     => $date_now,
                'nama_penerima' => $budgetData->nama_penerima,
                'pengaju'       => $budgetData->yang_mengajukan,
                'id_kategori'   => $budgetData->kategori_id,
                'status'        => $status_eaf,
                'id_divisi'     => 1, // Default Marcom
                'id_user'       => $user_id,
                'flag'          => 'Pengajuan',
                'jenis'         => $budgetData->eaf_id_jenis,
                'budget'        => $budgetData->eaf_id_biaya,
                'leave_id'      => 0
            ];
            $this->db->insert('rsp_project_live.e_pengajuan', $eaf_pengajuan);

            // D. Insert Tipe Pembayaran
            $tipe_str = 'Tunai';
            if ($budgetData->tipe_pembayaran == 2) $tipe_str = 'Transfer Bank';
            if ($budgetData->tipe_pembayaran == 3) $tipe_str = 'Giro';

            $eaf_pembayaran = [
                'id_pengajuan' => $id_pengajuan_eaf,
                'nama_tipe'    => $tipe_str,
                'nama_bank'    => $budgetData->nama_bank,
                'no_rek'       => $budgetData->nomor_rekening
            ];
            $this->db->insert('rsp_project_live.e_tipe_pembayaran', $eaf_pembayaran);

            // E. LOGIC AUTO APPROVE BY SYSTEM (Jika Nominal <= Minimal Approve)
            if ($budgetData->total_budget <= $minimal_approve && $minimal_approve > 0) {

                // 1. Insert Approval Log (Auto Approved)
                $eaf_approval = [
                    'id_pengajuan'      => $id_pengajuan_eaf,
                    'id_user_approval'  => $user_approval_eaf,
                    'level'             => $status_eaf,
                    'flag'              => 'Pengajuan',
                    'status'            => 'Approve',
                    'update_approve'    => $date_now,
                    'note_approve'      => 'Approved By Sistem (Marcom)',
                    'id_user'           => $user_approval_eaf
                ];
                $this->db->insert('rsp_project_live.e_approval', $eaf_approval);

                // 2. Insert Next Approval (Finance - ID 737)
                $approval_finance = [
                    'id_pengajuan'      => $id_pengajuan_eaf,
                    'id_user_approval'  => 737, // Finance RSP
                    'flag'              => 'Pengajuan'
                ];
                $this->db->insert('rsp_project_live.e_approval', $approval_finance);

                // 3. Update Status Pengajuan ke 2 (Sedang Proses)
                $this->db->where('id_pengajuan', $id_pengajuan_eaf);
                $this->db->update('rsp_project_live.e_pengajuan', ['status' => 2]);
            } else {
                // F. Manual Approval (Standard Flow)
                $eaf_approval = [
                    'id_pengajuan'     => $id_pengajuan_eaf,
                    'id_user_approval' => $user_approval_eaf,
                    'level'            => $status_eaf,
                    'flag'             => 'Pengajuan'
                ];
                $this->db->insert('rsp_project_live.e_approval', $eaf_approval);
            }

            // G. Insert Detail Keperluan
            // $note_combined = $budgetData->note . " [Source: Marcom - CampID: $campaign_id]";
            $note_combined = $budgetData->note;
            $eaf_detail = [
                'id_pengajuan'   => $id_pengajuan_eaf,
                'nama_keperluan' => $budgetData->nama_keperluan,
                'nominal_uang'   => $budgetData->total_budget,
                'note'           => $note_combined,
                'id_project'     => $budgetData->id_project,
                'tgl_nota'       => date('Y-m-d')
            ];
            $this->db->insert('rsp_project_live.e_detail_keperluan', $eaf_detail);
        }

        // ============================================================
        // LOGIC STANDARD (COMPANY LAIN / SELAIN ID 2)
        // ============================================================
        else {

            // A. Status Awal
            $status_eaf = 1;
            $user_approval_eaf = $budgetData->eaf_user_approval;
            if (!empty($budgetData->eaf_user_verified)) {
                $status_eaf = 10;
                $user_approval_eaf = $budgetData->eaf_user_verified;
            }

            // B. Insert Header
            $eaf_pengajuan = [
                'id_pengajuan'  => $id_pengajuan_eaf,
                'tgl_input'     => $date_now,
                'nama_penerima' => $budgetData->nama_penerima,
                'pengaju'       => $budgetData->yang_mengajukan,
                'id_kategori'   => $budgetData->kategori_id,
                'status'        => $status_eaf,
                'id_divisi'     => 1,
                'id_user'       => $user_id,
                'flag'          => 'Pengajuan',
                'jenis'         => $budgetData->eaf_id_jenis,
                'budget'        => $budgetData->eaf_id_biaya,
                'leave_id'      => 0
            ];
            $this->db->insert('e_eaf.e_pengajuan', $eaf_pengajuan);

            // C. Insert Pembayaran
            $tipe_str = 'Tunai';
            if ($budgetData->tipe_pembayaran == 2) $tipe_str = 'Transfer Bank';
            if ($budgetData->tipe_pembayaran == 3) $tipe_str = 'Giro';

            $eaf_pembayaran = [
                'id_pengajuan' => $id_pengajuan_eaf,
                'nama_tipe'    => $tipe_str,
                'nama_bank'    => $budgetData->nama_bank,
                'no_rek'       => $budgetData->nomor_rekening
            ];
            $this->db->insert('e_eaf.e_tipe_pembayaran', $eaf_pembayaran);

            // D. Insert Detail
            // $note_combined = $budgetData->note . " [Source: Marcom - CampID: $campaign_id]";
            $note_combined = $budgetData->note;
            $eaf_detail = [
                'id_pengajuan'   => $id_pengajuan_eaf,
                'nama_keperluan' => $budgetData->nama_keperluan,
                'nominal_uang'   => $budgetData->total_budget,
                'note'           => $note_combined,
                'tgl_nota'       => date('Y-m-d')
            ];
            $this->db->insert('e_eaf.e_detail_keperluan', $eaf_detail);

            // E. Insert Log Approval (Standard Pending)
            $eaf_approval = [
                'id_pengajuan'     => $id_pengajuan_eaf,
                'id_user_approval' => $user_approval_eaf,
                'level'            => $status_eaf,
                'flag'             => 'Pengajuan'
            ];
            $this->db->insert('e_eaf.e_approval', $eaf_approval);
        }

        if (!empty($budgetData->file_lampiran)) {
            $src_path = FCPATH . "uploads/marcom/campaigns/" . $campaign_id . "/budgeting/" . $budgetData->file_lampiran;

            if (file_exists($src_path)) {
                $ext = pathinfo($budgetData->file_lampiran, PATHINFO_EXTENSION);
                $new_name = uniqid() . '_marcom_' . time() . '.' . $ext;
                $upload_success = false;

                if ($budgetData->company_id == 2) {
                    // API Upload for RSP
                    $api_url = 'https://trusmicorp.com/rspproject/api/Update_foto_eaf';
                    $cfile = new CURLFile($src_path, mime_content_type($src_path), $new_name);

                    $post_data = [
                        'file' => $cfile,
                        'file_name' => $new_name
                    ];

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $api_url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    $res_json = json_decode($response, true);
                    if ($http_code == 200 && isset($res_json['status']) && $res_json['status'] == true) {
                        $upload_success = true;
                    }
                } else {
                    // Local Copy for others
                    $dest_dir = FCPATH . "uploads/eaf/";
                    if (!is_dir($dest_dir)) @mkdir($dest_dir, 0777, true);
                    if (copy($src_path, $dest_dir . $new_name)) {
                        $upload_success = true;
                    }
                }

                if ($upload_success) {
                    $this->db->insert($db_prefix . 'e_photo_acc', [
                        'id_pengajuan' => $id_pengajuan_eaf,
                        'photo_acc'    => $new_name,
                        'flag'         => 'BUKTI_NOTA'
                    ]);
                }
            }
        }

        // ============================================================
        // B. UPDATE STATUS MARCOM -> COMPLETED
        // ============================================================

        // 1. Update t_budgeting_marcom
        $this->db->where('id', $budget_id);
        $this->db->update('t_budgeting_marcom', [
            'note_approve'  => $note_approve,
            'eaf_ref_no'    => $id_pengajuan_eaf,
            'status'        => 16, // Completed
            'updated_by'    => $user_id,
            'updated_at'    => $date_now
        ]);

        // 2. Update t_campaign_marcom
        $this->db->where('id', $campaign_id);
        $this->db->update('t_campaign_marcom', [
            'status_progres' => 16,
            'updated_at'     => $date_now
        ]);

        $check_next = $this->db->get_where('t_shooting_marcom', ['campaign_id' => $campaign_id])->row();

        if (!$check_next) {
            $dataNext = [
                'campaign_id' => $campaign_id,
                'status'      => 17,
                'pic'         => $pic,
                'created_by'  => $user_id,
                'created_at'  => date('Y-m-d H:i:s'),
                'deadline' => $this->input->post('deadline_shooting')
            ];
            $this->db->insert('t_shooting_marcom', $dataNext);
        }

        // 4. Update Main Status ke Tab 5 (Shooting)
        $this->model->update_progress($campaign_id, 5, 17);

        // --- SELESAI TRANSAKSI ---
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => false, 'message' => 'Integrasi EAF Gagal. Silakan coba lagi.']);
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'Budget Approved! Data berhasil dikirim ke Pengajuan EAF (No: ' . $id_pengajuan_eaf . ')'
            ]);
        }
    }

    // --- GET FULL DETAIL CAMPAIGN (HISTORY) ---
    public function get_full_campaign_detail()
    {
        $id = $this->input->post('campaign_id');

        // 1. Data Utama & Join Semua Tabel Satelit
        $this->db->select('
        c.*,
        r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, 
        r.riset_note, c.pic as pic_riset_ids, r.updated_at as riset_date,
        s.naskah_final, s.naskah_ai, s.note as script_note, 
        s.pic as pic_script_ids,
        rk.id as riset_kol_id, rk.note as kol_note, rk.files as kol_files, 
        rk.pic as pic_kol_ids,
        b.id as budgeting_id, b.total_budget, b.nama_keperluan, b.nama_penerima, 
        b.status as status_budget, b.pic as pic_budget_ids,
        b.eaf_ref_no, com.name as company_name, mp.project, b.note_approve as budget_note,
        sh.id as shooting_id, sh.status as shooting_status, sh.pic as pic_shooting_ids,
        sh.lokasi, sh.keterangan as shooting_keterangan, sh.link as shooting_link, sh.file as shooting_file, sh.note as shooting_note, sh.output as shooting_output,
        ed.id as editing_id, ed.status as editing_status, ed.pic as pic_editing_ids,ed.keterangan as editing_keterangan, ed.link as editing_link, ed.thumbnail as editing_file, ed.note_approve as editing_note

    ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_shooting_marcom sh', 'sh.campaign_id = c.id', 'left');
        $this->db->join('t_editing_marcom ed', 'ed.campaign_id = c.id', 'left');
        $this->db->join('xin_companies com', 'com.company_id = b.company_id', 'left');
        $this->db->join('rsp_project_live.m_project mp', 'mp.id_project = b.id_project', 'left');

        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // 2. Ambil Detail KOL Items (Tab 3)
        $kol_items = [];
        if ($data->riset_kol_id) {
            $this->db->select('i.*, k.nama as kol_nama');
            $this->db->from('t_riset_kol_items_marcom i');
            $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
            $this->db->where('i.riset_kol_id', $data->riset_kol_id);
            $kol_items = $this->db->get()->result();
        }

        // 3. Helper Function untuk Fetch PIC Details
        // Kita gunakan Closure/Anonymous function lokal agar tidak perlu ubah struktur class
        $get_pics = function ($ids_str) {
            if (empty($ids_str)) return [];
            $ids = array_filter(explode(',', $ids_str));
            if (empty($ids)) return [];

            $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
            $this->db->where_in('user_id', $ids);
            $employees = $this->db->get('xin_employees')->result();

            $results = [];
            foreach ($employees as $e) {
                $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                $results[] = ['name' => $e->full_name, 'avatar' => $avatar];
            }
            return $results;
        };

        $output_nama = '-';
        if (!empty($data->shooting_output)) {
            $q_out = $this->db->query("SELECT GROUP_CONCAT(CONCAT(username,' (',type,')') SEPARATOR ', ') as nama 
                                       FROM m_akun_marcom WHERE id IN (" . $data->shooting_output . ")");
            $row_out = $q_out->row();
            if ($row_out) $output_nama = $row_out->nama;
        }


        // 4. Proses PIC untuk setiap tahap
        $pics_main   = $get_pics($data->pic);
        $pics_riset  = $get_pics($data->pic_riset_ids);
        $pics_script = $get_pics($data->pic_script_ids);
        $pics_kol    = $get_pics($data->pic_kol_ids);
        $pics_budget = $get_pics($data->pic_budget_ids);
        $pics_shooting = $get_pics($data->pic_shooting_ids);
        $pics_editing = $get_pics($data->pic_editing_ids);

        // 5. File Links
        $file_brief = [];

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        // Cek kolom satu per satu
        if (!empty($data->reference_file)) {
            $file_brief[] = $data->reference_file;
        }
        if (!empty($data->reference_file_2)) {
            $file_brief[] = $data->reference_file_2;
        }
        if (!empty($data->reference_file_3)) {
            $file_brief[] = $data->reference_file_3;
        }
        $file_budget = (!empty($data->budgeting_id) && !empty($data->file_lampiran)) ? base_url('uploads/marcom/campaigns/' . $id . '/budgeting/' . $data->file_lampiran) : null;

        echo json_encode([
            'status' => true,
            'data'   => $data,
            'pics_main'   => $pics_main,
            'pics_riset'  => $pics_riset,
            'pics_script' => $pics_script,
            'pics_kol'    => $pics_kol,
            'kol_items' => $kol_items,
            'influencer_ref' => $influencer_ref,
            'file_brief' => $file_brief,
            'file_budget' => $file_budget,
            'pics_budget' => $pics_budget,
            'pics_shooting' => $pics_shooting,
            'shooting_output_nama' => $output_nama,
            'pics_editing' => $pics_editing
        ]);
    }

    // --- DELETE FUNCTION (DATA & FILES) ---
    public function delete_campaign($id)
    {
        // $id = $this->input->post('id'); // ID Campaign (misal: CMP251209001)

        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'Invalid ID']);
            return;
        }

        // 1. Ambil Info EAF & Company sebelum data dihapus
        // Kita butuh ini untuk tahu apakah harus menghapus data di tabel EAF juga
        $budget = $this->db->get_where('t_budgeting_marcom', ['campaign_id' => $id])->row();

        $this->db->trans_start(); // Mulai Transaksi Database

        // ---------------------------------------------------------
        // A. HAPUS DATA EAF (JIKA ADA)
        // ---------------------------------------------------------
        if ($budget && !empty($budget->eaf_ref_no)) {
            $eaf_no = $budget->eaf_ref_no;

            // Tentukan Prefix DB EAF (Sesuai Logic Approve)
            $prefix = ($budget->company_id == 2) ? 'rsp_project_live.' : 'e_eaf.';

            // Query Multi-Delete untuk tabel-tabel EAF
            // Menghapus: Pengajuan, Detail, Tipe Bayar, Approval Log, dan Foto Bukti
            $sql_eaf = "DELETE p, d, t, a, f 
                        FROM {$prefix}e_pengajuan p
                        LEFT JOIN {$prefix}e_detail_keperluan d ON d.id_pengajuan = p.id_pengajuan
                        LEFT JOIN {$prefix}e_tipe_pembayaran t ON t.id_pengajuan = p.id_pengajuan
                        LEFT JOIN {$prefix}e_approval a ON a.id_pengajuan = p.id_pengajuan
                        LEFT JOIN {$prefix}e_photo_acc f ON f.id_pengajuan = p.id_pengajuan
                        WHERE p.id_pengajuan = ?";

            $this->db->query($sql_eaf, [$eaf_no]);
        }

        // ---------------------------------------------------------
        // B. HAPUS DATA MARCOM (MULTI-TABLE DELETE)
        // ---------------------------------------------------------
        // Menghapus data dari 7 tabel sekaligus menggunakan Left Join
        $sql_marcom = "DELETE main, r_spv, script, r_kol, kol_items, budget, history
                       FROM t_campaign_marcom AS main
                       LEFT JOIN t_riset_spv_marcom AS r_spv ON r_spv.campaign_id = main.id
                       LEFT JOIN t_script_marcom AS script ON script.campaign_id = main.id
                       LEFT JOIN t_riset_kol_marcom AS r_kol ON r_kol.campaign_id = main.id
                       LEFT JOIN t_riset_kol_items_marcom AS kol_items ON kol_items.riset_kol_id = r_kol.id
                       LEFT JOIN t_budgeting_marcom AS budget ON budget.campaign_id = main.id
                       LEFT JOIN marcom_h_status AS history ON history.id_campaign = main.id
                       WHERE main.id = ?";

        $this->db->query($sql_marcom, [$id]);

        $this->db->trans_complete(); // Selesai Transaksi

        // ---------------------------------------------------------
        // C. HAPUS FOLDER & FILE FISIK
        // ---------------------------------------------------------
        if ($this->db->trans_status() === TRUE) {

            // Path folder: uploads/marcom/campaigns/{ID}/
            $path = FCPATH . "uploads/marcom/campaigns/" . $id;

            // Panggil fungsi helper recursive delete
            if (is_dir($path)) {
                $this->_delete_folder_recursive($path);
            }

            echo json_encode(['status' => true, 'message' => 'Campaign & Data Terkait Berhasil Dihapus']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menghapus data database.']);
        }
    }

    // --- HELPER: RECURSIVE DELETE FOLDER ---
    // Fungsi ini menghapus semua file di dalam folder, lalu menghapus foldernya
    private function _delete_folder_recursive($dir)
    {
        if (!is_dir($dir)) return;

        $files = array_diff(scandir($dir), array('.', '..'));

        foreach ($files as $file) {
            $currentPath = "$dir/$file";
            if (is_dir($currentPath)) {
                $this->_delete_folder_recursive($currentPath); // Panggil diri sendiri untuk sub-folder
            } else {
                unlink($currentPath); // Hapus file
            }
        }

        return rmdir($dir); // Hapus folder kosong
    }

    public function delete_folder_by_name($folder_name)
    {
        // 1. Ambil Nama Folder dari POST
        // $folder_name = $this->input->post('folder_name');

        // 2. Validasi Input Kosong
        if ($folder_name === null || strlen(trim($folder_name)) === 0) {
            echo json_encode(['status' => false, 'message' => 'Nama folder wajib diisi.']);
            return;
        }

        // 3. SECURITY CHECK (SANGAT PENTING!)
        // Mencegah input seperti "../" atau ".." yang bisa menghapus folder di luar target
        if (strpos($folder_name, '..') !== false || strpos($folder_name, '/') !== false || strpos($folder_name, '\\') !== false) {
            echo json_encode(['status' => false, 'message' => 'Nama folder tidak valid (Dilarang menggunakan karakter path).']);
            return;
        }

        // 4. Tentukan Base Path Target
        // Asumsi folder yang mau dihapus ada di dalam: uploads/marcom/campaigns/
        // Silakan sesuaikan path ini jika targetnya di folder lain (misal uploads/marcom/_temp/)
        $base_path = FCPATH . "uploads/marcom/campaigns/";
        $target_dir = $base_path . $folder_name;

        // 5. Cek Apakah Folder Ada
        if (!is_dir($target_dir)) {
            echo json_encode(['status' => false, 'message' => 'Folder tidak ditemukan.']);
            return;
        }

        // 6. Eksekusi Hapus Recursive
        // Menggunakan helper _delete_folder_recursive yang sudah dibuat sebelumnya
        if ($this->_delete_folder_recursive($target_dir)) {
            echo json_encode(['status' => true, 'message' => 'Folder "' . $folder_name . '" berhasil dihapus.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menghapus folder. Cek permission server.']);
        }
    }

    public function insert_master_kol()
    {
        // 1. Ambil semua input
        $post = $this->input->post();

        // 2. Daftar field yang WAJIB berupa angka (Integer) di Database
        // Pastikan nama-nama ini sesuai dengan kolom di database Anda
        $numeric_fields = [
            'follower_ig',
            'last_rate_card_ig',
            'follower_tt',
            'last_rate_card_tt',
            'ratecard',
            // Loop konten IG
            'last_konten_1_ig',
            'last_konten_2_ig',
            'last_konten_3_ig',
            'last_konten_4_ig',
            'last_konten_5_ig',
            // Loop konten TT
            'last_konten_1_tt',
            'last_konten_2_tt',
            'last_konten_3_tt',
            'last_konten_4_tt',
            'last_konten_5_tt'
        ];

        // 3. Loop dan bersihkan karakter non-angka
        foreach ($numeric_fields as $field) {
            if (isset($post[$field])) {
                // Hapus titik, koma, Rp, huruf, spasi
                $clean_val = preg_replace('/[^0-9]/', '', $post[$field]);

                // Jika hasil kosong (misal user tidak isi), set jadi 0 atau NULL agar aman buat Integer
                $post[$field] = ($clean_val === '') ? 0 : $clean_val;
            }
        }

        // 4. Susun array $data secara manual (Best Practice)
        // Ini mencegah error "Unknown Column" jika ada input liar dari form
        $data = [
            'kategory'          => $post['kategory'],
            'nama'              => $post['nama'],
            'area'              => $post['area'],
            'nomor_wa'             => $post['no_wa'],
            'email'             => $post['email'],
            'niche'             => $post['niche'],

            // IG Data
            'username_ig'       => $post['username_ig'],
            'link_ig'           => $post['link_ig'],
            'follower_ig'       => $post['follower_ig'], // Sudah bersih
            'last_rate_card_ig' => $post['last_rate_card_ig'], // Sudah bersih
            'last_konten_1_ig'  => $post['last_konten_1_ig'],
            'last_konten_2_ig'  => $post['last_konten_2_ig'],
            'last_konten_3_ig'  => $post['last_konten_3_ig'],
            'last_konten_4_ig'  => $post['last_konten_4_ig'],
            'last_konten_5_ig'  => $post['last_konten_5_ig'],

            // TT Data
            'username_tt'       => $post['username_tt'],
            'link_tt'           => $post['link_tt'],
            'follower_tt'       => $post['follower_tt'],
            'last_rate_card_tt' => $post['last_rate_card_tt'],
            'last_konten_1_tt'  => $post['last_konten_1_tt'],
            'last_konten_2_tt'  => $post['last_konten_2_tt'],
            'last_konten_3_tt'  => $post['last_konten_3_tt'],
            'last_konten_4_tt'  => $post['last_konten_4_tt'],
            'last_konten_5_tt'  => $post['last_konten_5_tt'],

            // General
            'ratecard'          => $post['ratecard'],
            'created_by'        => $this->session->userdata('user_id'),
            'created_at'        => date('Y-m-d H:i:s')
        ];

        // 5. Eksekusi Insert
        $insert = $this->db->insert('m_kol_marcom', $data);

        if ($insert) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil disimpan']);
        } else {
            // Debugging: Jika gagal, lihat error database (hapus saat production)
            // echo json_encode(['status' => false, 'message' => $this->db->error()]);
            echo json_encode(['status' => false, 'message' => $insert]);
        }
    }

    public function get_all_master_kol()
    {
        // 1. Menggunakan kutip ganda (") untuk pembungkus string PHP
        //    agar bisa menggunakan kutip satu (') untuk string SQL.
        // 2. Menambahkan parameter FALSE agar CodeIgniter tidak mengacak-acak query CASE.

        $this->db->select("
        *,
        CASE 
            WHEN kategory = 1 THEN 'Instagram'
            WHEN kategory = 2 THEN 'TikTok'
            WHEN kategory = 3 THEN 'Influencer'
            WHEN kategory = 4 THEN 'Mediagram'
            ELSE 'Lainnya'  
        END as kategory_name
    ", FALSE);

        $data = $this->db->get('m_kol_marcom')->result();

        // 3. Set Header agar dikenali sebagai JSON valid
        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'data' => $data]);
    }

    public function delete_master_kol()
    {
        $id = $this->input->post('id');
        $this->db->delete('m_kol_marcom', ['id' => $id]);
        echo json_encode(['status' => true]);
    }

    // --- REVIEW & DETAIL SHOOTING (TAB 5) ---
    public function get_shooting_detail()
    {
        $id = $this->input->post('campaign_id');
        $this->db->select('
            c.campaign_name,
            c.start_date,
            c.end_date,
            c.priority,
            c.placement,
            c.description,
            c.goals,
            c.big_idea,
            c.reference_link,
            c.reference_link_2,
            c.reference_link_3,
            c.reference_file,
            c.reference_file_2,
            c.reference_file_3,
            c.kol_id,
            c.kol_budget,
            c.company_id AS company_id_campaign,
            r.riset_report,
            r.trend_analysis,
            r.riset_link,
            r.riset_file,
            r.riset_note,
            s.naskah_final,
            s.note AS script_note,
            b.*,
            DATE(DATE_ADD(b.updated_at, INTERVAL 7 DAY)) AS deadline_shooting,
            rk.id AS riset_kol_id,
            rk.files AS files_kol,
            rk.note AS kol_note,
            b.pic AS pic_budget,
            comp.name AS company_name,
            proj.project AS project_name,
            sh.id AS shooting_id,
            sh.lokasi AS shooting_lokasi,
            sh.output AS shooting_output,
            sh.keterangan AS shooting_keterangan,
            sh.link AS shooting_link,
            sh.file AS shooting_files,
            sh.created_at AS shooting_created_at,
            sh.updated_at AS shooting_updated_at,
            sh.note AS shooting_note_approve,
            sh.pic AS pic_shooting,
            DATE(DATE_ADD(sh.updated_at, INTERVAL 3 DAY)) as deadline_editing
        ');
        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('xin_companies comp', 'comp.company_id = c.company_id', 'left');
        $this->db->join('rsp_project_live.m_project proj', 'proj.id_project = b.id_project', 'left');
        $this->db->join('t_shooting_marcom sh', 'sh.campaign_id = c.id', 'left');

        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        $output_nama = '-';
        if (!empty($data->shooting_output)) {
            $q_out = $this->db->query("SELECT GROUP_CONCAT(CONCAT(username,' (',type,')') SEPARATOR ', ') as nama 
                                       FROM m_akun_marcom WHERE id IN (" . $data->shooting_output . ")");
            $row_out = $q_out->row();
            if ($row_out) $output_nama = $row_out->nama;
        }

        // Ambil Nama Pengaju
        $nama_pengaju = '-';
        if ($data->yang_mengajukan) {
            $emp = $this->db->select("CONCAT(first_name,' ',last_name) as full_name")->where('user_id', $data->yang_mengajukan)->get('xin_employees')->row();
            if ($emp) $nama_pengaju = $emp->full_name;
        }

        $influencer_ref = $this->_get_kol_data($data->kol_id);

        $pic_data = [];
        if (!empty($data->pic_shooting)) {
            $pic_ids = array_filter(explode(',', $data->pic_shooting));
            if (!empty($pic_ids)) {
                $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
                $this->db->where_in('user_id', $pic_ids);
                $employees = $this->db->get('xin_employees')->result();
                foreach ($employees as $e) {
                    $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                    $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
                }
            }
        }

        // Ambil Detail KOL Approved
        $kol_items = [];
        if ($data->riset_kol_id) {
            $this->db->select('i.*, k.nama as kol_nama');
            $this->db->from('t_riset_kol_items_marcom i');
            $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
            $this->db->where('i.riset_kol_id', $data->riset_kol_id);
            $kol_items = $this->db->get()->result();
        }

        // LOGIC NAMA APPROVER BUDGETING
        $nama_approver_budget = '-';
        $approved_at_budget = '-';
        if ($data->status == 16) {
            $approver_id = $data->updated_by; // User yang klik Approve
            if ($approver_id) {
                $emp = $this->db->select("CONCAT(first_name,' ',last_name) as full_name")->where('user_id', $approver_id)->get('xin_employees')->row();
                if ($emp) $nama_approver_budget = $emp->full_name;
            }
            $approved_at_budget = date('d M Y H:i', strtotime($data->updated_at));
        }

        // File Lampiran Budgeting
        $file_url_budget = $data->file_lampiran ? base_url('uploads/marcom/campaigns/' . $id . '/budgeting/' . $data->file_lampiran) : null;
        // File Lampiran Shooting
        $file_url_shooting = [];

        if (!empty($data->shooting_files)) {
            $files = array_filter(explode(',', $data->shooting_files));
            foreach ($files as $f) {
                $file_url_shooting[] = [
                    'name' => $f,
                    'url'  => base_url('uploads/marcom/campaigns/' . $id . '/shooting/' . $f)
                ];
            }
        }


        echo json_encode([
            'status'       => true,
            'data'         => $data,
            'output_nama'  => $output_nama,
            'kol_items'    => $kol_items,
            'file_url_budget' => $file_url_budget,
            'file_url_shooting' => $file_url_shooting,
            'nama_pengaju' => $nama_pengaju,
            'nama_approver_budget' => $nama_approver_budget,
            'approved_at_budget'   => $approved_at_budget,
            'influencer_ref' => $influencer_ref,
            'pics'     => $pic_data
        ]);
    }

    public function save_shooting()
    {
        $campaign_id = $this->input->post('campaign_id');
        $lokasi      = $this->input->post('lokasi');
        $keterangan  = $this->input->post('keterangan');

        // Handle Array Input (Output & Links)
        $output_arr  = $this->input->post('output'); // Select multiple
        $link_arr    = $this->input->post('shooting_link'); // Dynamic inputs

        $output_str  = (!empty($output_arr) && is_array($output_arr)) ? implode(',', $output_arr) : '';
        $link_str    = (!empty($link_arr) && is_array($link_arr)) ? implode(',', array_filter($link_arr)) : '';

        // Handle File Uploads (Dari Dropzone)
        $uploaded_files = $this->input->post('uploaded_files');
        $files_str = '';

        // Cek data lama untuk merge file (jika edit)
        $old_data = $this->db->get_where('t_shooting_marcom', ['campaign_id' => $campaign_id])->row();
        $existing_files = ($old_data && !empty($old_data->files)) ? explode(',', $old_data->files) : [];

        // Proses file baru
        if (!empty($uploaded_files) && is_array($uploaded_files)) {
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $campaign_id . "/shooting/";

            foreach ($uploaded_files as $f) {
                if (!empty(trim($f))) {
                    // Pindahkan file dari _temp ke folder shooting
                    if ($this->_move_file_from_temp($f, $targetDir)) {
                        $existing_files[] = $f;
                    }
                }
            }
        }
        // Gabungkan file lama dan baru
        $files_str = implode(',', array_unique($existing_files));

        $data = [
            'campaign_id' => $campaign_id,
            'lokasi'      => $lokasi,
            'output'      => $output_str,
            'keterangan'  => $keterangan,
            'link'        => $link_str,
            'file'       => $files_str,
            'updated_by'  => $this->session->userdata('user_id'),
            'updated_at'  => date('Y-m-d H:i:s'),
            'status'      => 19
        ];

        $this->db->trans_start();

        // Cek apakah data sudah ada (Update/Insert)
        if ($old_data) {
            $this->db->where('id', $old_data->id);
            $this->db->update('t_shooting_marcom', $data);
        } else {
            // Data baru
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert('t_shooting_marcom', $data);
        }

        // Opsional: Update status progres campaign jika diperlukan
        $this->model->update_progress($campaign_id, 5, 19);

        $this->db->trans_complete();

        $listPic = $this->db->where('campaign_id', $campaign_id)->get('t_shooting_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($campaign_id, $listPic);

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(['status' => true, 'message' => 'Data Shooting berhasil disimpan']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data']);
        }
    }

    public function approve_shooting()
    {
        $campaign_id   = $this->input->post('campaign_id');
        $note          = $this->input->post('note');
        $pic_next      = $this->input->post('pic_next'); // Array or String
        $deadline_next = $this->input->post('deadline_next');
        $user_id       = $this->session->userdata('user_id');

        // Konversi PIC array ke string comma-separated
        $pic_str = (is_array($pic_next)) ? implode(',', $pic_next) : $pic_next;

        $this->db->trans_start();

        // A. Update Table Shooting (Selesai)
        $this->db->where('campaign_id', $campaign_id);
        $this->db->update('t_shooting_marcom', [
            'note' => $note,
            'status'       => 20, // Status Done Shooting
            'updated_by'   => $user_id,
            'updated_at'   => date('Y-m-d H:i:s')
        ]);

        // B. Buat/Update Table Editing (Next Phase)
        // Asumsi nama tabel: t_editing_marcom (Buat jika belum ada di DB)
        // Status awal editing: 21 (Pending/Assignment)

        $cek_edit = $this->db->get_where('t_editing_marcom', ['campaign_id' => $campaign_id])->row();

        $data_editing = [
            'campaign_id' => $campaign_id,
            'pic'         => $pic_str,
            'deadline'    => $deadline_next,
            'status'      => 21, // 21: To Do / Assigned
            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => $user_id
        ];

        if ($cek_edit) {
            $this->db->where('id', $cek_edit->id);
            $this->db->update('t_editing_marcom', $data_editing);
        } else {
            $this->db->insert('t_editing_marcom', $data_editing);
        }

        // C. Update Main Campaign Status & History
        // Status Progres: 20 (Done Shooting) -> 21 (Start Editing)
        $this->model->update_progress($campaign_id, 6, 21);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(['status' => true, 'message' => 'Shooting Approved. Lanjut Editing.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal approve data.']);
        }
    }

    public function get_editing_detail()
    {
        $id = $this->input->post('campaign_id');

        // 1. SELECT DATA LENGKAP
        $this->db->select('
            c.campaign_name, c.start_date, c.end_date, c.priority, c.placement, c.id AS campaign_id,
            c.description, c.goals, c.big_idea, 
            c.reference_link, c.reference_link_2, c.reference_link_3, 
            c.reference_file, c.reference_file_2, c.reference_file_3, 
            c.kol_id, c.kol_budget, c.company_id,
            
            r.riset_report, r.trend_analysis, r.riset_link, r.riset_file, r.riset_note,
            
            s.naskah_final, s.note AS script_note,
            
            b.total_budget, b.nama_keperluan, b.file_lampiran as budget_file, b.status as budget_status,
            
            rk.id AS riset_kol_id, rk.files AS files_kol, rk.note AS kol_note,
            
            sh.id AS shooting_id, sh.lokasi AS shooting_lokasi, sh.output AS shooting_output, 
            sh.keterangan AS shooting_keterangan, sh.link AS shooting_link, sh.file AS shooting_files, 
            sh.note AS shooting_note_approve,
            
            e.id as editing_id, e.link as editing_link, e.thumbnail as editing_files, 
            e.note_approve as editing_keterangan, e.deadline as deadline_editing, e.pic as pic_editing, e.keterangan, DATE(DATE_ADD(e.updated_at, INTERVAL 3 DAY)) as deadline
        ');

        $this->db->from('t_campaign_marcom c');
        $this->db->join('t_riset_spv_marcom r', 'r.campaign_id = c.id', 'left');
        $this->db->join('t_script_marcom s', 's.campaign_id = c.id', 'left');
        $this->db->join('t_budgeting_marcom b', 'b.campaign_id = c.id', 'left');
        $this->db->join('t_riset_kol_marcom rk', 'rk.campaign_id = c.id', 'left');
        $this->db->join('t_shooting_marcom sh', 'sh.campaign_id = c.id', 'left');
        $this->db->join('t_editing_marcom e', 'e.campaign_id = c.id', 'left');

        $this->db->where('c.id', $id);
        $data = $this->db->get()->row();

        if (!$data) {
            echo json_encode(['status' => false, 'message' => 'Data not found']);
            return;
        }

        // 2. PROSES NAMA OUTPUT (Dari ID ke Nama Akun)
        $output_nama = '-';
        if (!empty($data->shooting_output)) {
            $q_out = $this->db->query("SELECT GROUP_CONCAT(CONCAT(username,' (',type,')') SEPARATOR ', ') as nama 
                                       FROM m_akun_marcom WHERE id IN (" . $data->shooting_output . ")");
            $row_out = $q_out->row();
            if ($row_out) $output_nama = $row_out->nama;
        }

        // 3. PROSES DATA KOL ITEMS
        $kol_items = [];
        if ($data->riset_kol_id) {
            $this->db->select('i.*, k.nama as kol_nama');
            $this->db->from('t_riset_kol_items_marcom i');
            $this->db->join('m_kol_marcom k', 'k.id = i.kol_id', 'left');
            $this->db->where('i.riset_kol_id', $data->riset_kol_id);
            $kol_items = $this->db->get()->result();
        }

        // 4. PROSES INFLUENCER REF
        $influencer_ref = $this->_get_kol_data($data->kol_id);

        // 5. PROSES PIC (Editing)
        // Jika data editing belum ada, ambil PIC dari campaign/shooting atau kosongkan
        $pic_ids_str = !empty($data->pic_editing) ? $data->pic_editing : '';
        $pic_data = [];
        if (!empty($pic_ids_str)) {
            $pic_ids = explode(',', $pic_ids_str);
            $this->db->select("user_id, CONCAT(first_name,' ',last_name) as full_name, profile_picture, gender");
            $this->db->where_in('user_id', $pic_ids);
            $employees = $this->db->get('xin_employees')->result();
            foreach ($employees as $e) {
                $avatar = $e->profile_picture ? 'https://trusmiverse.com/hr/uploads/profile/' . $e->profile_picture : ($e->gender == 'Female' ? 'https://trusmiverse.com/hr/uploads/profile/default_female.jpg' : 'https://trusmiverse.com/hr/uploads/profile/default_male.jpg');
                $pic_data[] = ['name' => $e->full_name, 'avatar' => $avatar];
            }
        }

        // 6. PROSES URL FILES (Shooting & Editing)
        $file_url_shooting = [];
        if (!empty($data->shooting_files)) {
            $files = explode(',', $data->shooting_files);
            foreach ($files as $f) {
                if (trim($f)) {
                    $file_url_shooting[] = [
                        'name' => $f,
                        'url'  => base_url('uploads/marcom/campaigns/' . $id . '/shooting/' . $f)
                    ];
                }
            }
        }

        $file_url_editing = []; // Untuk MockFile Dropzone Editing
        if (!empty($data->editing_files)) {
            $files = explode(',', $data->editing_files);
            foreach ($files as $f) {
                if (trim($f)) {
                    $file_url_editing[] = [
                        'name' => $f,
                        'url'  => base_url('uploads/marcom/campaigns/' . $id . '/editing/' . $f) // Asumsi folder editing
                    ];
                }
            }
        }

        echo json_encode([
            'status'            => true,
            'data'              => $data,
            'output_nama'       => $output_nama,
            'kol_items'         => $kol_items,
            'influencer_ref'    => $influencer_ref,
            'file_url_shooting' => $file_url_shooting,
            'file_url_editing'  => $file_url_editing,
            'pics'              => $pic_data
        ]);
    }

    public function save_editing()
    {
        // 1. Ambil Input
        $campaign_id = $this->input->post('campaign_id');
        $keterangan  = $this->input->post('keterangan'); // Masuk ke kolom 'keterangan'

        // 2. Handle Links (Array to String)
        $link_arr = $this->input->post('editing_link');
        $link_str = (!empty($link_arr) && is_array($link_arr)) ? implode(',', array_filter($link_arr)) : '';

        // 3. Handle File Uploads (Thumbnail/Evidence)
        $uploaded_files = $this->input->post('uploaded_files'); // Dari Dropzone
        $files_str = '';

        // Cek data lama untuk merge file (agar file lama tidak hilang saat edit)
        $old_data = $this->db->get_where('t_editing_marcom', ['campaign_id' => $campaign_id])->row();
        $existing_files = ($old_data && !empty($old_data->thumbnail)) ? explode(',', $old_data->thumbnail) : [];

        // Proses Pemindahan File
        if (!empty($uploaded_files) && is_array($uploaded_files)) {
            // Folder target: uploads/marcom/campaigns/{id}/editing/
            $targetDir = FCPATH . "uploads/marcom/campaigns/" . $campaign_id . "/editing/";

            // Pastikan folder tersedia
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            foreach ($uploaded_files as $f) {
                if (!empty(trim($f))) {
                    // Pindahkan file dari temp ke folder editing
                    if ($this->_move_file_from_temp($f, $targetDir)) {
                        $existing_files[] = $f;
                    }
                }
            }
        }
        // Gabungkan file lama dan baru (Unique)
        $files_str = implode(',', array_unique($existing_files));

        // 4. Siapkan Data Array
        $data = [
            'campaign_id' => $campaign_id,
            'link'        => $link_str,
            'keterangan'  => $keterangan, // Kolom baru sesuai struktur table
            'thumbnail'   => $files_str,  // Kolom thumbnail menyimpan nama file
            'updated_by'  => $this->session->userdata('user_id'),
            'updated_at'  => date('Y-m-d H:i:s'),
            'status'      => 23
        ];

        $this->db->trans_start();

        // Cek Insert atau Update
        if ($old_data) {
            $this->db->where('id', $old_data->id);
            $this->db->update('t_editing_marcom', $data);
        } else {
            // Data baru
            $data['created_by'] = $this->session->userdata('user_id');
            $data['created_at'] = date('Y-m-d H:i:s');
            // Pastikan deadline & pic terisi (biasanya dari fase approval shooting sebelumnya)
            // Jika logic insert terjadi disini, status 22
            $this->db->insert('t_editing_marcom', $data);
        }

        // Update Progress Campaign Utama (Tab 6: Editing -> Status 22: Review)
        $this->model->update_progress($campaign_id, 6, 23);

        $this->db->trans_complete();

        $listPic = $this->db->where('campaign_id', $campaign_id)->get('t_editing_marcom')->row()->pic;
        $listPic = explode(',', $listPic);

        //send notif
        $this->sendNotifReview($campaign_id, $listPic);

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(['status' => true, 'message' => 'Data Editing berhasil disimpan']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal menyimpan data']);
        }
    }

    public function approve_editing()
    {
        $campaign_id   = $this->input->post('campaign_id');
        $note          = $this->input->post('note');
        $pic_next      = $this->input->post('pic_next'); // Array or String
        $deadline_next = $this->input->post('deadline_next');
        $company_id    = $this->input->post('company_id');
        $user_id       = $this->session->userdata('user_id');

        // Konversi PIC array ke string comma-separated
        $pic_str = (is_array($pic_next)) ? implode(',', $pic_next) : $pic_next;

        $this->db->trans_start();

        // A. Update Table Editing (Selesai/Approved)
        // Status 23 = Done Editing
        $this->db->where('campaign_id', $campaign_id);
        $this->db->update('t_editing_marcom', [
            'note_approve' => $note, // Catatan dari Approver
            'status'       => 24,    // Status Done
            'updated_by'   => $user_id,
            'updated_at'   => date('Y-m-d H:i:s')
        ]);

        // B. Buat/Update Table Next Phase (Posting/Review) - DIKOMENTARI SEMENTARA
        /*
        // Asumsi tabel selanjutnya: t_posting_marcom
        $cek_next = $this->db->get_where('t_posting_marcom', ['campaign_id' => $campaign_id])->row();

        $data_next = [
            'campaign_id' => $campaign_id,
            'pic'         => $pic_str,
            'deadline'    => $deadline_next,
            'status'      => 24, // Status awal Posting (misal)
            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => $user_id
        ];

        if ($cek_next) {
            $this->db->where('id', $cek_next->id);
            $this->db->update('t_posting_marcom', $data_next);
        } else {
            $this->db->insert('t_posting_marcom', $data_next);
        }
        */

        // C. Update Main Campaign Status & History
        // Status Progres: 23 (Done Editing) -> 24 (Start Posting/Next)
        // Tab 7 (Asumsi tab selanjutnya) atau tetap di 6 tapi status Done
        $this->model->update_progress($campaign_id, 6, 24);

        // Simpan History Log Status
        $this->db->insert('marcom_h_status', [
            'id_campaign' => $campaign_id,
            'tab'         => 6, // Tab Editing
            'status_lama' => 23, // Review
            'status_baru' => 24, // Done
            'created_by'  => $user_id,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === TRUE) {
            echo json_encode(['status' => true, 'message' => 'Editing Approved.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal approve data.']);
        }
    }

    public function get_master_kol_by_id()
    {
        $id = $this->input->get('id');
        if (empty($id)) {
            echo json_encode(['status' => false, 'message' => 'ID tidak ditemukan']);
            return;
        }

        $this->db->select("*, 
            CASE 
                WHEN kategory = 1 THEN 'Instagram'
                WHEN kategory = 2 THEN 'TikTok'
                WHEN kategory = 3 THEN 'Influencer'
                WHEN kategory = 4 THEN 'Mediagram'
                ELSE 'Lainnya'  
            END as kategory_name
        ", FALSE);
        $data = $this->db->get_where('m_kol_marcom', ['id' => $id])->row();

        if ($data) {
            echo json_encode(['status' => true, 'data' => $data]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Data tidak ditemukan']);
        }
    }

    // --- UPDATE MASTER KOL ---
    public function update_master_kol()
    {
        $post = $this->input->post();

        if (empty($post['id'])) {
            echo json_encode(['status' => false, 'message' => 'ID KOL tidak ditemukan']);
            return;
        }

        // Numeric fields (sama seperti insert)
        $numeric_fields = [
            'follower_ig',
            'last_rate_card_ig',
            'follower_tt',
            'last_rate_card_tt',
            'ratecard',
            'last_konten_1_ig',
            'last_konten_2_ig',
            'last_konten_3_ig',
            'last_konten_4_ig',
            'last_konten_5_ig',
            'last_konten_1_tt',
            'last_konten_2_tt',
            'last_konten_3_tt',
            'last_konten_4_tt',
            'last_konten_5_tt'
        ];

        foreach ($numeric_fields as $field) {
            if (isset($post[$field])) {
                $clean_val = preg_replace('/[^0-9]/', '', $post[$field]);
                $post[$field] = ($clean_val === '') ? 0 : $clean_val;
            }
        }

        $data = [
            'kategory'          => $post['kategory'],
            'nama'              => $post['nama'],
            'area'              => $post['area'],
            'nomor_wa'          => $post['no_wa'],
            'email'             => $post['email'],
            'niche'             => $post['niche'],
            'username_ig'       => $post['username_ig'],
            'link_ig'           => $post['link_ig'],
            'follower_ig'       => $post['follower_ig'],
            'last_rate_card_ig' => $post['last_rate_card_ig'],
            'last_konten_1_ig'  => $post['last_konten_1_ig'],
            'last_konten_2_ig'  => $post['last_konten_2_ig'],
            'last_konten_3_ig'  => $post['last_konten_3_ig'],
            'last_konten_4_ig'  => $post['last_konten_4_ig'],
            'last_konten_5_ig'  => $post['last_konten_5_ig'],
            'username_tt'       => $post['username_tt'],
            'link_tt'           => $post['link_tt'],
            'follower_tt'       => $post['follower_tt'],
            'last_rate_card_tt' => $post['last_rate_card_tt'],
            'last_konten_1_tt'  => $post['last_konten_1_tt'],
            'last_konten_2_tt'  => $post['last_konten_2_tt'],
            'last_konten_3_tt'  => $post['last_konten_3_tt'],
            'last_konten_4_tt'  => $post['last_konten_4_tt'],
            'last_konten_5_tt'  => $post['last_konten_5_tt'],
            'ratecard'          => $post['ratecard'],
            'updated_by'        => $this->session->userdata('user_id'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $post['id']);
        $update = $this->db->update('m_kol_marcom', $data);

        if ($update) {
            echo json_encode(['status' => true, 'message' => 'Data berhasil diupdate']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Gagal update data']);
        }
    }

    function sendNotifReview($campaign_id, $pic_id)
    {
        $query = "SELECT
                    cm.id,
                    cm.campaign_name,
                    comp.`name` AS company,
                    CASE
                        WHEN cm.priority = 1 THEN
                        'Low'
                        WHEN cm.priority = 2 THEN
                        'Medium'
                        ELSE
                        'High'
                    END AS priority,
                    cm.start_date,
                    cm.end_date,
                    cm.`status`,
                    s.`status` AS fase,
                    p.progres,
                    CASE
                        WHEN em.contact_no LIKE '08%' THEN
                        CONCAT('628', SUBSTRING(em.contact_no, 3))
                        WHEN em.contact_no LIKE '628%' THEN
                        em.contact_no
                        ELSE
                        em.contact_no
                    END AS contact_no,
                    cm.created_by,
                    DATE(cm.created_at) AS created_at,
                    DATE_ADD(DATE(cm.updated_at), INTERVAL 2 DAY) AS deadline
                    FROM
                    `t_campaign_marcom` cm
                    LEFT JOIN xin_companies comp ON comp.company_id = cm.company_id
                    LEFT JOIN m_status_marcom s ON s.id = cm.`status`
                    LEFT JOIN m_status_progres_marcom p ON p.id = cm.status_progres
                    LEFT JOIN xin_employees em ON em.user_id = cm.created_by
                    WHERE
                    cm.id = '$campaign_id'";

        $row = $this->db->query($query)->row();

        $this->db->where_in('user_id', $pic_id);
        $pic = $this->db->get('xin_employees')->result();
        $listPic = [];

        foreach ($pic as $p) {
            $listPic[] = $p->first_name . ' ' . $p->last_name;
        }
        $listPic = implode(', ', $listPic);
        $linkType = ($row->status > 4) ? 2 : 1;

        $message = "🚨 *Campaign Review Notification*

Hai, ada campaign marcom yang perlu segera direview.

🔑 Campaign ID : *" . trim(ucwords($row->id)) . "*
🏷️ Campaign : *" . trim(ucwords($row->campaign_name)) . "*
🏢 Company : *" . trim(ucwords($row->company)) . "*
💣 Priority : *" . trim(ucwords($row->priority)) . "*
📌 Fase : *" . trim(ucwords($row->fase)) . "*
📊 Progres : *" . trim($row->progres) . "*
📱 PIC : *" . $listPic . "*
⏳ Deadline : *" . $row->deadline . "*

Silakan cek dan lakukan review segera.

🔗 Link Review :
https://trusmiverse.com/apps/marcom/index/" . $linkType . "

⏰ Created :
" . $row->created_at;

        // $contact_no = '628986997966';
        $contact_no = $row->contact_no;
        // $user_id = 7651;
        $user_id = $row->created_by;

        try {
            $this->load->library('WAJS');
            $response['wa'][] = $this->wajs->send_wajs_notif($contact_no, $message, 'text', 'trusmiverse', $user_id);
        } catch (\Throwable $th) {
            $response['wa'][] = "Error : " . $th;
        }

        return $response;
    }


    function sendNotifReject($campaign_id, $status)
    {
        // $campaign_id = $this->input->post('campaign_id');
        // $status = $this->input->post('status');
        $response = [];

        // Mapping tabel
        switch ($status) {
            case 1:
                $table_satelit = 't_campaign_marcom';
                $id_field = 'id';
                break;

            case 2:
                $table_satelit = 't_script_marcom';
                $id_field = 'campaign_id';
                break;

            case 3:
                $table_satelit = 't_riset_kol_marcom';
                $id_field = 'campaign_id';
                break;

            case 4:
                $table_satelit = 't_budgeting_marcom';
                $id_field = 'campaign_id';
                break;

            case 5:
                $table_satelit = 't_shooting_marcom';
                $id_field = 'campaign_id';
                break;

            case 6:
                $table_satelit = 't_editing_marcom';
                $id_field = 'campaign_id';
                break;

            default:
                return ['error' => 'Invalid status'];
        }

        /* ===========================
       Ambil PIC dari tabel satelit
    =========================== */

        $this->db->where($id_field, $campaign_id);
        $data = $this->db->get($table_satelit)->row();

        if (!$data || empty($data->pic)) {
            return ['error' => 'PIC tidak ditemukan'];
        }

        // "11084,7651,1" → array
        $pic_id = explode(',', $data->pic);


        /* ===========================
       Ambil Data Campaign
    =========================== */

        $query = "
        SELECT
            cm.id,
            cm.campaign_name,
            comp.`name` AS company,
            CASE
                WHEN cm.priority = 1 THEN 'Low'
                WHEN cm.priority = 2 THEN 'Medium'
                ELSE 'High'
            END AS priority,
            cm.`status`,
            s.`status` AS fase,
            p.progres,
            DATE(cm.created_at) AS created_at,
            DATE_ADD(DATE(cm.updated_at), INTERVAL 2 DAY) AS deadline
        FROM t_campaign_marcom cm
        LEFT JOIN xin_companies comp ON comp.company_id = cm.company_id
        LEFT JOIN m_status_marcom s ON s.id = cm.`status`
        LEFT JOIN m_status_progres_marcom p ON p.id = cm.status_progres
        WHERE cm.id = ?
    ";

        $row = $this->db->query($query, [$campaign_id])->row();

        if (!$row) {
            return ['error' => 'Campaign tidak ditemukan'];
        }


        /* ===========================
       Ambil Nama + Nomor PIC
    =========================== */

        if (!$pic_id) {
            return ['error' => 'Data PIC kosong'];
        }

        $this->db->where_in('user_id', ['']);
        $pics = $this->db->get('xin_employees')->result();
        // var_dump($pics);
        // die();

        if (!$pics) {
            return ['error' => 'Data PIC kosong'];
        }

        $picNames = [];
        $picList  = [];

        foreach ($pics as $p) {

            // Normalisasi nomor
            $phone = $p->contact_no;

            if (substr($phone, 0, 2) == '08') {
                $phone = '628' . substr($phone, 2);
            }

            $name = trim($p->first_name . ' ' . $p->last_name);

            // Untuk ditampilkan di pesan
            $picNames[] = $name;

            // Untuk looping kirim WA
            $picList[] = [
                'id'    => $p->user_id,
                'name'  => $name,
                'phone' => $phone
            ];
        }

        // Gabung nama PIC
        $listPicName = implode(', ', $picNames);

        // var_dump($pics);
        // die();


        /* ===========================
       Buat Message (1 Template)
    =========================== */

        $linkType = ($row->status > 4) ? 2 : 1;

        $message = "🚨 *Campaign Revisi Notification*

Hai, ada campaign marcom yang perlu segera direvisi.

🔑 Campaign ID : *{$row->id}*
🏷️ Campaign : *{$row->campaign_name}*
🏢 Company : *{$row->company}*
💣 Priority : *{$row->priority}*
📌 Fase : *{$row->fase}*
📊 Progres : *{$row->progres}*
📱 PIC : *{$listPicName}*
⏳ Deadline : *{$row->deadline}*

Silakan cek dan lakukan review segera.

🔗 Link :
https://trusmiverse.com/apps/marcom/index/{$linkType}

⏰ Created :
{$row->created_at}";


        /* ===========================
       Kirim ke Semua PIC
    =========================== */

        $this->load->library('WAJS');

        foreach ($picList as $p) {

            try {

                $send = $this->wajs->send_wajs_notif(
                    // '628986997966',     // kirim ke masing-masing PIC
                    $p['phone'],     // kirim ke masing-masing PIC
                    $message,        // pesan sama
                    'text',
                    'trusmiverse',
                    $p['id']
                );

                $response['wa'][] = [
                    'user'   => $p['name'],
                    'phone'  => $p['phone'],
                    'status' => 'success',
                    'result' => $send
                ];
            } catch (\Throwable $th) {

                $response['wa'][] = [
                    'user'   => $p['name'],
                    'phone'  => $p['phone'],
                    'status' => 'failed',
                    'error'  => $th->getMessage()
                ];
            }
        }

        echo json_encode($response);
    }


    function sendNotifApprove()
    {
        $campaign_id = $this->input->post('campaign_id');
        $status = $this->input->post('status');
        $response = [];

        // Mapping tabel
        switch ($status) {
            case 1:
                $table_satelit = 't_campaign_marcom';
                $id_field = 'id';
                break;

            case 2:
                $table_satelit = 't_script_marcom';
                $id_field = 'campaign_id';
                break;

            case 3:
                $table_satelit = 't_riset_kol_marcom';
                $id_field = 'campaign_id';
                break;

            case 4:
                $table_satelit = 't_budgeting_marcom';
                $id_field = 'campaign_id';
                break;

            case 5:
                $table_satelit = 't_shooting_marcom';
                $id_field = 'campaign_id';
                break;

            case 6:
                $table_satelit = 't_editing_marcom';
                $id_field = 'campaign_id';
                break;

            default:
                return ['error' => 'Invalid status'];
        }

        /* ===========================
       Ambil PIC dari tabel satelit
    =========================== */

        $this->db->where($id_field, $campaign_id);
        $data = $this->db->get($table_satelit)->row();

        if (!$data || empty($data->pic)) {
            return ['error' => 'PIC tidak ditemukan'];
        }

        // "11084,7651,1" → array
        $pic_id = explode(',', $data->pic);
        $deadline = $data->deadline;


        /* ===========================
       Ambil Data Campaign
    =========================== */

        $query = "
        SELECT
            cm.id,
            cm.campaign_name,
            comp.`name` AS company,
            CASE
                WHEN cm.priority = 1 THEN 'Low'
                WHEN cm.priority = 2 THEN 'Medium'
                ELSE 'High'
            END AS priority,
            cm.`status`,
            s.`status` AS fase,
            p.progres,
            DATE(cm.created_at) AS created_at,
            DATE_ADD(DATE(cm.updated_at), INTERVAL 2 DAY) AS deadline
        FROM t_campaign_marcom cm
        LEFT JOIN xin_companies comp ON comp.company_id = cm.company_id
        LEFT JOIN m_status_marcom s ON s.id = cm.`status`
        LEFT JOIN m_status_progres_marcom p ON p.id = cm.status_progres
        WHERE cm.id = ?
    ";

        $row = $this->db->query($query, [$campaign_id])->row();

        if (!$row) {
            return ['error' => 'Campaign tidak ditemukan'];
        }


        /* ===========================
       Ambil Nama + Nomor PIC
    =========================== */

        $this->db->where_in('user_id', $pic_id);
        $pics = $this->db->get('xin_employees')->result();

        if (!$pics) {
            return ['error' => 'Data PIC kosong'];
        }

        $picNames = [];
        $picList  = [];

        foreach ($pics as $p) {

            // Normalisasi nomor
            $phone = $p->contact_no;

            if (substr($phone, 0, 2) == '08') {
                $phone = '628' . substr($phone, 2);
            }

            $name = trim($p->first_name . ' ' . $p->last_name);

            // Untuk ditampilkan di pesan
            $picNames[] = $name;

            // Untuk looping kirim WA
            $picList[] = [
                'id'    => $p->user_id,
                'name'  => $name,
                'phone' => $phone
            ];
        }

        // Gabung nama PIC
        $listPicName = implode(', ', $picNames);


        /* ===========================
       Buat Message (1 Template)
    =========================== */

        $linkType = ($row->status > 4) ? 2 : 1;

        $message = "🚨 *Campaign Approved Notification*

Hai, ada campaign marcom yang ditugaskan ke kamu.

🔑 Campaign ID : *{$row->id}*
🏷️ Campaign : *{$row->campaign_name}*
🏢 Company : *{$row->company}*
💣 Priority : *{$row->priority}*
📌 Fase : *{$row->fase}*
📊 Progres : *{$row->progres}*
📱 PIC : *{$listPicName}*
⏳ Deadline : *{$deadline}*

Silakan cek dan lakukan review segera.

🔗 Link :
https://trusmiverse.com/apps/marcom/index/{$linkType}

⏰ Created :
{$row->created_at}";


        /* ===========================
       Kirim ke Semua PIC
    =========================== */

        $this->load->library('WAJS');

        foreach ($picList as $p) {

            try {

                $send = $this->wajs->send_wajs_notif(
                    // '628986997966',     // kirim ke masing-masing PIC
                    $p['phone'],     // kirim ke masing-masing PIC
                    $message,        // pesan sama
                    'text',
                    'trusmiverse',
                    $p['id']
                );

                $response['wa'][] = [
                    'user'   => $p['name'],
                    'phone'  => $p['phone'],
                    'status' => 'success',
                    'result' => $send
                ];
            } catch (\Throwable $th) {

                $response['wa'][] = [
                    'user'   => $p['name'],
                    'phone'  => $p['phone'],
                    'status' => 'failed',
                    'error'  => $th->getMessage()
                ];
            }
        }

        echo json_encode($response);
    }
}
