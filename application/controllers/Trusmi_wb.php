<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_wb extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_trusmi_wb", "model");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    public function index()
    {
        $data['pageTitle']        = "Whistleblower";
        $data['js']               = "trusmi_wb/js";
        $data['css']              = "trusmi_wb/css";
        $data['content']          = "trusmi_wb/index";
        $data['company']          = $this->model->getCompany();
        $data['wb_aktivitas']     = $this->model->getWbAktivitas();
        $data['wb_pertanyaan']    = $this->model->getWbPertanyaan();
        $data['department']       = $this->model->getDepartmentActive();

        // WBDEV
        $data['wb_status'] = $this->model->getWbStatus(); 
        $data['wb_status_fu'] = $this->model->getWbStatusFu(); 
        $data['wb_kategori_aduan'] = $this->model->getWbKategoriAduan(); 
        // revnew
        $data['wb_alasan_reject'] = $this->model->getWbAlasanReject();

        $arr_wb_pic = [];
        $get_pic_eskalasi = $this->db->query("SELECT user_id FROM xin_employees WHERE ctm_posisi IN ('Head','Manager','Direktur') AND is_active = 1 AND user_id != 1")->result();
        foreach ($get_pic_eskalasi as $row) {
            $arr_wb_pic[] = $row->user_id;
        }
        $data['wb_pic_eskalasi'] = $arr_wb_pic;

        $this->load->view('layout/main', $data);
    }

    public function getWbPertanyaan()
    {
        $data = $this->model->getWbPertanyaan();
        $this->output
            ->set_content_type('application/json') // Set header Content-Type
            ->set_output(json_encode($data)); // Encode data ke JSON
    }

    public function getEmployee()
    {
        $id = $this->input->post('department_id');
        $data = $this->model->getEmployee($id);
        echo json_encode($data);
    }

    function generate_id_wb()
    {
        $q = $this->db->query("SELECT
	MAX( RIGHT ( trusmi_t_wb.id_wb, 3 ) ) AS kd_max 
FROM
	trusmi_t_wb 
WHERE
	DATE ( trusmi_t_wb.created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }

        return 'WB' . date('ymd') . $kd;
    }

    public function add_wb()
    {
        $id = $this->input->post('id_wb');
        $id_wb = $this->generate_id_wb();
        // var_dump($id);
        // die();
        if ($id == "") {
            $data = array(
                'id_wb' => $id_wb,
                'laporan' => $this->input->post('laporan'),
                'department_id' => $this->input->post('department_id'),
                'employee_id' => $this->input->post('employee_id'),
                'tgl_temuan' => $this->input->post('tgl_temuan'),
                'id_aktivitas' => $this->input->post('id_aktivitas'),
                'note_other' => $this->input->post('note_other'),
                'kronologi' => $this->input->post('kronologi'),
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'status' => 1,
                'start_lock_at' => date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d'))))
            );
            $response['status'] = $this->db->insert('trusmi_t_wb', $data);
            $response['message'] = "Success add data";
            $response['id_wb'] = $id_wb;
        } else {
            $data = array(
                'id_wb' => $id,
                'laporan' => $this->input->post('laporan'),
                'department_id' => $this->input->post('department_id'),
                'employee_id' => $this->input->post('employee_id'),
                'tgl_temuan' => $this->input->post('tgl_temuan'),
                'id_aktivitas' => $this->input->post('id_aktivitas'),
                'note_other' => $this->input->post('note_other'),
                'kronologi' => $this->input->post('kronologi'),
                'status' => 1,
                'start_lock_at' => date('Y-m-d', strtotime('+2 days', strtotime(date('Y-m-d'))))
            );

            $this->db->where('id_wb', $id);
            $response['status'] = $this->db->update('trusmi_t_wb', $data);
            $response['message'] = "Success add data";
            $response['id_wb'] = $id;
        }
        echo json_encode($response);
    }

    public function add_wb_2()
    {
        $id = $this->input->post('id_wb');
        $hubungan = $this->input->post('hubungan');
        $file_name = "";

        if (!is_dir('./uploads/wb_files/')) {
            mkdir('./uploads/wb_files/', 0775, true);
        }

        // Cek jika ada file yang diunggah
        if (!empty($_FILES['bukti']['name'])) {
            // Konfigurasi unggah file
            $config['upload_path']   = './uploads/wb_files/';
            $config['allowed_types'] = '*'; // Anda dapat membatasi jenis file, contoh: 'gif|jpg|png|jpeg|pdf'
            $config['file_name']     = $id . '_' . time(); // Format nama file
            // $config['max_size']      = 2048; // Maksimum ukuran file dalam KB (opsional)

            // Load library upload dengan konfigurasi
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('bukti')) {
                // Jika upload gagal, kembalikan pesan error
                $response = [
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ];
                echo json_encode($response);
                return;
            } else {
                // Jika upload berhasil, ambil nama file
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            }
        }
        if ($hubungan == 1) {
            $data = array(
                'lokasi' => $this->input->post('lokasi'),
                'kota' => $this->input->post('kota'),
                'hubungan' => $hubungan,
                'company_terkait' => $this->input->post('company_terkait'),
                'department_terkait' => $this->input->post('department_terkait'),
                'informasi' => $this->input->post('informasi'),
                'bukti' => $file_name,
                'ekspektasi_akhir' => $this->input->post('ekspektasi_akhir'), // revnew
                'keterkaitan_dampak' => $this->input->post('keterkaitan_dampak'),
            );
        } else {
            $data = array(
                'lokasi' => $this->input->post('lokasi'),
                'kota' => $this->input->post('kota'),
                'hubungan' => $hubungan,
                'informasi' => $this->input->post('informasi'),
                'bukti' => $file_name,
                'ekspektasi_akhir' => $this->input->post('ekspektasi_akhir'), // revnew
                'keterkaitan_dampak' => $this->input->post('keterkaitan_dampak'),
            );
        }
        $this->db->where('id_wb', $id);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";
    }

    public function getDepartmentByCompany()
    {
        $id = $this->input->post('company_id');
        $data = $this->model->getDepartmentByCompany($id);
        echo json_encode($data);
    }

    public function savePertanyaan()
    {
        // Ambil data dari request
        $data = json_decode(file_get_contents('php://input'), true);

        if (is_array($data)) {
            foreach ($data as $item) {
                // Siapkan data untuk disimpan
                $insertData = array(
                    'id_wb' => $item['id_wb'],
                    'id_pertanyaan' => $item['id_pertanyaan'],
                    'jawaban' => $item['jawaban'],
                    'pertanyaan' => $item['pertanyaan'],
                );

                // Cek apakah data dengan id_wb dan id_pertanyaan sudah ada
                $this->db->where('id_wb', $item['id_wb']);
                $this->db->where('id_pertanyaan', $item['id_pertanyaan']);
                $query = $this->db->get('trusmi_t_wb_pertanyaan');

                if ($query->num_rows() > 0) {
                    // Jika data sudah ada, lakukan update
                    $this->db->where('id_wb', $item['id_wb']);
                    $this->db->where('id_pertanyaan', $item['id_pertanyaan']);
                    $this->db->update('trusmi_t_wb_pertanyaan', $insertData);
                } else {
                    // Jika data belum ada, lakukan insert
                    $this->db->insert('trusmi_t_wb_pertanyaan', $insertData);
                }
            }

            // Beri respons sukses
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'success', 'message' => 'Data berhasil disimpan atau diperbarui')));
        } else {
            // Beri respons error
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('status' => 'error', 'message' => 'Data tidak valid')));
        }
    }

    public function finish()
    {
        $id = $this->input->post('id_wb');
        // $persetujuan = $this->input->post('persetujuan');
        $persetujuan = 1; // set semua Anonim
        $data = array(
            'persetujuan' => $persetujuan,
            'status' => 1, // set Waiting wbdev
            'keterangan' => 'Pengaduan Whistleblower',
            // 'proses_at' => date("Y-m-d H:i:s"),
            // 'proses_by' => $this->session->userdata('user_id')
        );
        $this->db->where('id_wb', $id);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";

        try {
            $data_wb = $this->db->query("SELECT
        twb.id_wb,
        twb.laporan,
        xd.department_name AS nama_department,
        CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
        xe.username,
        xe.profile_picture,
        twb.tgl_temuan,
        twb.id_aktivitas,
        mwa.aktivitas,
        twb.note_other,
        twb.kronologi,
        twb.lokasi,
        twb.kota,
        twb.hubungan,
        xct.`name` AS nama_company_terkait,
        xdt.department_name AS nama_department_terkait,
        twb.informasi,
        twb.bukti,
        COALESCE(twb.persetujuan,1) AS persetujuan,
        created_by.profile_picture AS created_profile_picture,
	    created_by.username AS created_username,
        CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
        twb.created_at,
        GROUP_CONCAT( CONCAT( twbp.pertanyaan, ' ', '<b>',twbp.jawaban,'</b>' ) SEPARATOR '<br>' ) AS jawaban,
        twb.created_by AS id_created_by,
        twb.department_ext,  
        twb.employee_ext  
    FROM
        `trusmi_t_wb` twb
        LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
        LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
        LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
        LEFT JOIN xin_departments xdt ON xdt.department_id = twb.department_terkait
        LEFT JOIN xin_companies xct ON xct.company_id = twb.company_terkait
        LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
        JOIN trusmi_t_wb_pertanyaan twbp ON twbp.id_wb = twb.id_wb 
        WHERE
        twb.id_wb = '$id'
    GROUP BY
        twb.id_wb")->row_array();
        
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        if ($data_wb['id_created_by'] == "8636") {
            $kategori = "Eksternal";
        } else {
            $kategori = "Internal";
        }

        $nomor_list = ["6285624444554", "6282217202247"];
        foreach ($nomor_list as $nomor) {
            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $nomor, 
                "messageType" => "text",
                "body" => "🚨Alert!!! 
*Ada Laporan Whistleblower Baru*

🔖Kategori : " . $kategori . "
🗃️Department : " . $data_wb['nama_department'] . "
👤Terlapor : *" . $data_wb['nama_employee'] . "*
📄Aktivitas : " . $data_wb['aktivitas'] . "
📎Link : https://trusmiverse.com/apps/uploads/wb_files/" . $data_wb['bukti'] . "

*Note : pastikan laporan diproses 2x24 jam, jika tidak maka berlaku lock absen*",
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
            $response['notif_wa']    = file_get_contents($url, false, $context_text);
        }
        } catch (\Throwable $th) {
            //throw $th;
        }

        // Insert history wbdev
        $data_hist = [
            'id_wb' => $id,
            'status' => 1,
            'keterangan' => 'Pengaduan Whistleblower',
            'proses_at' => date('Y-m-d H:i:s'),
            'proses_by' => $this->session->userdata('user_id')
        ];

        $response['insert_hist_wb'] = $this->db->insert('trusmi_t_wb_history', $data_hist);

        echo json_encode($response);
    }

    public function getListWb()
    {
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        $response['data'] = $this->model->getListWb($start, $end);
        echo json_encode($response);
    }
    
    // addnew
    public function checkPassIT()
    {
        $password = md5($this->input->post('password'));

        $access = false;

        $user_id = $this->session->userdata('user_id');

        $password_it = $this->model->getPassIT($user_id)->password;

        $access_id = [1,61,64,803,68];
        if (in_array($user_id, $access_id)) {
            if ($user_id == 1 && $password == '941a7bc6c0c9276069ffc27da5f59fb9') {
                $access = true;
            } else if ($password == $password_it) {
                $access = true;
            }
        }
        

        echo json_encode(['access' => $access]);
    }

    // WBDEV
    public function getPicEscalation()
    {
        $data = $this->model->getPicEscalation();
        echo json_encode($data);
    }

    public function update_progres_wb()
    {
        $id_wb = $this->input->post('id_wb');

        // updev
        $dokumen_penyelesaian = "";

        if (!is_dir('./uploads/wb_files/dokumen')) {
            mkdir('./uploads/wb_files/dokumen', 0775, true);
        }

        // Cek jika ada file yang diunggah
        if (!empty($_FILES['dokumen_penyelesaian']['name'])) {
            // Konfigurasi unggah file
            $config['upload_path']   = './uploads/wb_files/dokumen';
            $config['allowed_types'] = '*'; // Anda dapat membatasi jenis file, contoh: 'gif|jpg|png|jpeg|pdf'
            $config['file_name']     = 'DOC_' . $id_wb . '_' . time(); // Format nama file
            $config['max_size']      = 2048; // Maksimum ukuran file dalam KB (opsional)

            // Load library upload dengan konfigurasi
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('dokumen_penyelesaian')) {
                // Jika upload gagal, kembalikan pesan error
                $response = [
                    'status' => 'error',
                    'message' => $this->upload->display_errors('', '')
                ];
                echo json_encode($response);
                return;
            } else {
                // Jika upload berhasil, ambil nama file
                $upload_data = $this->upload->data();
                $dokumen_penyelesaian = $upload_data['file_name'];
            }
        }

        $status_progres = $this->input->post('status_progres');
        $kategori_aduan = $this->input->post('kategori_aduan');
        $status_fu = $this->input->post('status_fu');
        $pic_eskalasi = $this->input->post('pic_escalation');
        $keterangan = $this->input->post('keterangan');

        $data = array(
            'status' => $status_progres,
            'kategori_aduan' => $kategori_aduan,
            'status_fu' => $status_fu,
            'pic_eskalasi' => $pic_eskalasi,
            'keterangan' => $keterangan,
            'dokumen_penyelesaian' => ($status_progres == 3) ? $dokumen_penyelesaian : NULL,
            'proses_at' => date("Y-m-d H:i:s"),
            'proses_by' => $this->session->userdata('user_id')
        );

        $this->db->where('id_wb', $id_wb);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";

        // addnew Insert history wbdev
        $data_hist = [
            'id_wb' => $id_wb,
            'status' => $status_progres,
            'kategori_aduan' => $kategori_aduan,
            'status_fu' => $status_fu,
            'pic_eskalasi' => $pic_eskalasi,
            'keterangan' => $keterangan,
            'dokumen_penyelesaian' => $dokumen_penyelesaian,
            'proses_at' => date('Y-m-d H:i:s'),
            'proses_by' => $this->session->userdata('user_id')
        ];

        $response['insert_hist_wb'] = $this->db->insert('trusmi_t_wb_history', $data_hist);
        // $response['status_progres'] = $status_progres;

        // notifdev
        $data_wb = $this->db->query("SELECT
                                twb.id_wb,
                                twb.laporan,
                                xd.department_name AS nama_department,
                                CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
                                mwa.aktivitas,
                                twb.note_other,
                                twb.kronologi,
                                twb.informasi,
                                twb.bukti,
                                CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
                                twb.created_by AS id_created_by,
                                -- created_by.contact_no AS contact_pelapor,
                                CASE WHEN LEFT(REPLACE(REPLACE(created_by.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(created_by.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(created_by.contact_no, '-',''),'+','') END AS contact_pelapor,

                                twb.department_ext,  
                                twb.employee_ext,
                                wb_stat.`status`,
                                wb_kat.kategori AS kategori_aduan,
                                wb_fu.status_fu,
                                CONCAT(wb_pic.first_name, ' ', wb_pic.last_name) AS pic_eskalasi,
                                -- wb_pic.contact_no AS contact_pic,
                                CASE WHEN LEFT(REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+','') END AS contact_pic,
                                
                                twb.keterangan
                            FROM
                                `trusmi_t_wb` twb
                                LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
                                LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
                                LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
                                LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
                                LEFT JOIN trusmi_m_wb_status wb_stat ON twb.`status` = wb_stat.id
                                LEFT JOIN trusmi_m_wb_kategori wb_kat ON twb.kategori_aduan = wb_kat.id
                                LEFT JOIN trusmi_m_wb_status_fu wb_fu ON twb.status_fu = wb_fu.id
                                LEFT JOIN xin_employees wb_pic ON twb.pic_eskalasi = wb_pic.user_id
                            WHERE
                                twb.id_wb = '$id_wb'
                            GROUP BY
                                twb.id_wb")->row_array();

        if ($status_progres == 2) { // Jika status di ubah ke Progres/Working On
            // Kirim notif ke PIC eskalasi ybs
            try {
                $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    
            if ($data_wb['id_created_by'] == "8636") {
                $kategori = "Eksternal";
            } else {
                $kategori = "Internal";
            }
            
            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $data_wb['contact_pic'], // PIC Eskalasi
                "messageType" => "text",
                "body" => "🚨Alert!!! 
*Ada Laporan Whistleblower yang harus segera di Proses*

🔖Kategori : " . $kategori . "
🗃️Department : " . $data_wb['nama_department'] . "
👤Terlapor : *" . $data_wb['nama_employee'] . "*
📄Aktivitas : " . $data_wb['aktivitas'] . "
📚Kategori Aduan : " . $data_wb['aktivitas'] . "
🕵️PIC Eskalasi : *" . $data_wb['pic_eskalasi'] . "*
💻Status FU : " . $data_wb['status_fu'] . "
📄Keterangan : " . $data_wb['keterangan'] . "
📎Link : https://trusmiverse.com/apps/uploads/wb_files/" . $data_wb['bukti'] . "

*Note : pastikan laporan segera diproses.*",
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
                $response['notif_wa']    = file_get_contents($url, false, $context_text);
            } catch (\Throwable $th) {
                //throw $th;
            }
        } elseif ($status_progres == 3) { // Jika status sudah Done
            // Kirim notif ke Pelapor
            try {
                $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    
            if ($data_wb['id_created_by'] == "8636") {
                $kategori = "Eksternal";
            } else {
                $kategori = "Internal";
            }
            
                $data_text = array(
                "channelID" => "2225082380",
                "phone" => $data_wb['contact_pelapor'], // Pelapor
                "messageType" => "text",
                "body" => "🚨Alert!!! 
*Laporan Whistleblower sudah selesai di Proses*

🔖Kategori : " . $kategori . "
🗃️Department : " . $data_wb['nama_department'] . "
👤Terlapor : *" . $data_wb['nama_employee'] . "*
📄Aktivitas : " . $data_wb['aktivitas'] . "
📚Kategori Aduan : " . $data_wb['aktivitas'] . "
🕵️PIC Eskalasi : *" . $data_wb['pic_eskalasi'] . "*
📄Keterangan : " . $data_wb['keterangan'] . "
💻Status : *✔️Done*

Terimakasih sudah melaporkan.",
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
                $response['notif_wa']    = file_get_contents($url, false, $context_text);
            } catch (\Throwable $th) {
                //throw $th;
            }
        } 

        echo json_encode($response);   
    }

    // revnew
    public function reject_progres_wb()
    {
        $id_wb = $this->input->post('id_wb');
        $status_progres = $this->input->post('status_progres');
        $alasan_reject = $this->input->post('alasan_reject');
        // $keterangan = $this->input->post('keterangan');

        $data = array(
            'status' => $status_progres,
            'alasan_reject' => $alasan_reject,
            'proses_at' => date("Y-m-d H:i:s"),
            'proses_by' => $this->session->userdata('user_id')
        );

        $this->db->where('id_wb', $id_wb);
        $response['status'] = $this->db->update('trusmi_t_wb', $data);
        $response['message'] = "Success update data";

        // addnew Insert history wbdev
        $data_hist = [
            'id_wb' => $id_wb,
            'status' => $status_progres,
            'keterangan' => 'Pengaduan di Reject',
            'proses_at' => date('Y-m-d H:i:s'),
            'proses_by' => $this->session->userdata('user_id')
        ];

        $response['insert_hist_wb'] = $this->db->insert('trusmi_t_wb_history', $data_hist);
        $response['alasan_reject'] = $alasan_reject;

        // Kirim notif ke Pelapor jika laporan di Reject, notifdev
        try {
            $data_wb = $this->db->query("SELECT
                                twb.id_wb,
                                twb.laporan,
                                xd.department_name AS nama_department,
                                CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
                                mwa.aktivitas,
                                twb.note_other,
                                twb.kronologi,
                                twb.informasi,
                                twb.bukti,
                                CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
                                twb.created_by AS id_created_by,
                                created_by.contact_no AS contact_pelapor,
                                twb.department_ext,  
                                twb.employee_ext,
                                wb_stat.`status`,
                                wb_kat.kategori AS kategori_aduan,
                                wb_fu.status_fu,
                                CONCAT(wb_pic.first_name, ' ', wb_pic.last_name) AS pic_eskalasi,
                                -- wb_pic.contact_no AS contact_pic,
                                 CASE WHEN LEFT(REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(wb_pic.contact_no, '-',''),'+','') END AS contact_pic,
                                twb.keterangan,
                                wb_reject.alasan AS alasan_reject,
	                            wb_reject.deskripsi AS deskripsi_reject
                            FROM
                                `trusmi_t_wb` twb
                                LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
                                LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
                                LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
                                LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
                                LEFT JOIN trusmi_m_wb_status wb_stat ON twb.`status` = wb_stat.id
                                LEFT JOIN trusmi_m_wb_kategori wb_kat ON twb.kategori_aduan = wb_kat.id
                                LEFT JOIN trusmi_m_wb_status_fu wb_fu ON twb.status_fu = wb_fu.id
                                LEFT JOIN xin_employees wb_pic ON twb.pic_eskalasi = wb_pic.user_id
                                LEFT JOIN trusmi_m_wb_alasan_reject wb_reject ON twb.alasan_reject = wb_reject.id
                            WHERE
                                twb.id_wb = '$id_wb'
                            GROUP BY
                                twb.id_wb")->row_array();

            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

        if ($data_wb['id_created_by'] == "8636") {
            $kategori = "Eksternal";
        } else {
            $kategori = "Internal";
        }
        
            $data_text = array(
            "channelID" => "2225082380",
            "phone" => $data_wb['contact_pelapor'], // Pelapor
            "messageType" => "text",
            "body" => "🚨Alert!!! 
*Laporan Whistleblower Anda di Reject*

🔖Kategori : " . $kategori . "
📄Laporan : " . $data_wb['laporan'] . "
🗃️Department : " . $data_wb['nama_department'] . "
👤Terlapor : *" . $data_wb['nama_employee'] . "*
📄Aktivitas : " . $data_wb['aktivitas'] . "
📌Status : *❌ Reject*
📝Alasan : " . $data_wb['alasan_reject'] . "
📝Keterangan : " . $data_wb['deskripsi_reject'] . "

Mohon maaf laporan anda tidak dapat di proses lebih lanjut
Terimakasih.",
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
            $response['notif_wa']    = file_get_contents($url, false, $context_text);
        } catch (\Throwable $th) {
            //throw $th;
        }

        echo json_encode($response);   
    }

    public function resume_monitoring_progres_wb()
    {
        $id_user = $this->session->userdata('user_id');

        $response['data'] = $this->model->resume_monitoring_progres_wb($id_user);

        echo json_encode($response);
    }

    public function dt_list_wb_by_status()
    {
        $status = $this->input->post('status');

        $response['data'] = $this->model->dt_list_wb_by_status($status);
        echo json_encode($response);
    }

    public function dt_history_wb()
    {
        $id_wb = $this->input->post('id_wb');

        $response['data'] = $this->model->dt_history_wb($id_wb);
        echo json_encode($response);
    }
}
