<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fack extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('Filter');
        $this->load->library('encryption');
        $this->load->model('Model_fack', 'model_fack');
        $this->load->model("model_profile");
        $this->load->library('WAJS');
    }

    public function index()
    {
        if ($this->session->userdata('user_id') != "") {
            $data['pageTitle'] = "Formulir Registrasi Calon Karyawan";
            $data['css'] = "fack/css";
            $data['js'] = "fack/js";
            $data['content'] = "fack/index";
            $this->load->view('layout/main', $data);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function get_department()
    {
        $company_id = $this->input->post('company_id');
        $result = $this->model_fack->department($company_id);
        echo json_encode($result);
    }

    public function detail($ciphertext = null)
    {
        if ($this->session->userdata('user_id') != "") {
            if (isset($ciphertext)) {
                $application_id = preg_replace('/[^0-9.]+/', '', $ciphertext);
                $calon_karyawan = $this->model_fack->get_data_calon_karyawan_by_id($application_id);
                $m_pendidikan = $this->model_fack->get_pendidikan();
                $agama = $this->model_fack->get_agama();
                $data['pageTitle'] = "F.R.C.K";
                $data['ck'] = $calon_karyawan;
                $data['agama'] = $agama;
                $data['m_pendidikan'] = $m_pendidikan;
                $this->load->view('fack/detail', $data);
            } else {
                $response['status'] = 400;
                $response['msg'] = "Bad Request";
                echo json_encode($response);
            }
        } else {
            redirect('login', 'refresh');
        }
    }

    public function dt_fack()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end = $this->input->post('end') ?? date("Y-m-t");
        $response['data'] = $this->model_fack->dt_fack($start, $end);
        echo json_encode($response);
    }

    public function get_administrasi_need()
    {
        $response['company'] = $this->model_fack->company();
        $response['designation'] = $this->model_fack->get_designation();
        $response['office_shifts'] = $this->model_fack->get_office_shifts();
        $response['user_roles'] = $this->model_fack->get_user_roles();
        $response['leaves_type'] = $this->model_fack->get_leaves_type();
        $response['location'] = $this->model_fack->get_location();
        $response['pt'] = $this->model_fack->get_pt();

        $response['alasan'] = $this->model_fack->get_alasan('Offering');

        echo json_encode($response);
    }

    function get_designation()
    {
        $department_id = $this->input->post('department_id');
        $data = $this->model_fack->get_designation($department_id);
        echo json_encode($data);
    }


    function done()
    {
        $application_id = $this->input->post('application_id');

        if (isset($application_id)) {
            // ------------------------------------------------------------------------
            // 1. VALIDASI DATA DIRI (fack_personal_details)
            // ------------------------------------------------------------------------
            $this->db->select('no_ktp, no_kk, tempat_lahir, tgl_lahir, alamat_ktp, alamat_saat_ini, no_hp, email, agama, kewarganegaraan, status, pas_foto');
            $this->db->where('application_id', $application_id);
            $query = $this->db->get('fack_personal_details');
            $detail = $query->row();

            if ($detail) {
                // Mengecek apakah ada salah satu kolom wajib yang masih kosong
                if (
                    empty($detail->no_ktp) ||
                    empty($detail->no_kk) ||
                    empty($detail->tempat_lahir) ||
                    empty($detail->tgl_lahir) ||
                    empty($detail->alamat_ktp) ||
                    empty($detail->alamat_saat_ini) ||
                    empty($detail->no_hp) ||
                    empty($detail->email) ||
                    empty($detail->agama) ||
                    empty($detail->kewarganegaraan) ||
                    empty($detail->status) ||
                    empty($detail->pas_foto)
                ) {
                    $response['status'] = 400;
                    $response['msg'] = "Gagal: Seluruh kelengkapan Data Diri (KTP, KK, Tempat/Tgl Lahir, Alamat, No HP, Email, Agama, Kewarganegaraan, Status Pernikahan, dan Pas Foto) harus dilengkapi terlebih dahulu.";
                    echo json_encode($response);
                    return false; // Menghentikan proses
                }
            } else {
                // Jika application_id tidak ditemukan di tabel personal details
                $response['status'] = 400;
                $response['msg'] = "Data pelamar tidak ditemukan.";
                echo json_encode($response);
                return false;
            }

            // ------------------------------------------------------------------------
            // 2. VALIDASI DATA KELUARGA (fack_families)
            // ------------------------------------------------------------------------
            $this->db->where('application_id', $application_id);
            $family_count = $this->db->count_all_results('fack_families');

            if ($family_count == 0) {
                $response['status'] = 400;
                $response['msg'] = "Gagal: Data Keluarga masih kosong, harap isi minimal 1 data keluarga.";
                echo json_encode($response);
                return false;
            }

            // ------------------------------------------------------------------------
            // 3. VALIDASI DATA PENDIDIKAN (fack_education_level)
            // ------------------------------------------------------------------------
            $this->db->where('application_id', $application_id);
            $education_count = $this->db->count_all_results('fack_education_level');

            if ($education_count == 0) {
                $response['status'] = 400;
                $response['msg'] = "Gagal: Data Pendidikan masih kosong, harap isi riwayat pendidikan Anda.";
                echo json_encode($response);
                return false;
            }

            // ------------------------------------------------------------------------
            // 4. JIKA SEMUA VALIDASI LOLOS, LAKUKAN UPDATE
            // ------------------------------------------------------------------------
            $data = [
                'is_link_expired' => 1
            ];

            $update = $this->db->where('application_id', $application_id)->update('fack_personal_details', $data);

            $response['status'] = true; // Bisa menggunakan true atau 200 untuk menandakan sukses
            $response['data'] = $data;
            $response['done'] = $update;
            $response['msg'] = "Data berhasil dikirim.";

        } else {
            $response['status'] = 400;
            $response['msg'] = "Bad Request: Application ID tidak disertakan.";
        }

        echo json_encode($response);
    }

    public function generate_fack($ciphertext_application_id, $ciphertext_hr_by)
    {
        if (ctype_alpha(substr($ciphertext_application_id, 0, 2))) {
            $application_id = preg_replace('/[^0-9.]+/', '', $ciphertext_application_id);
            $hr_by = preg_replace('/[^0-9.]+/', '', $ciphertext_hr_by);

            $data = array();
            $create_fack = null;
            $getXinJobs = $this->db->select('application_id, full_name')->where('application_id', $application_id)->where('application_status', 5)->from('xin_job_applications');
            $isThereXinJobs = $getXinJobs->count_all_results();
            if ($isThereXinJobs > 0) {
                $isTherePersonalDetails = $this->db->select('application_id')->from('fack_personal_details')->where('application_id', $application_id)->count_all_results();
                if ($isTherePersonalDetails == 0) {
                    $dataXinJobs = $this->db->query("SELECT application_id, full_name, user_id_emp FROM xin_job_applications WHERE application_id = '$application_id'")->row_array();
                    $data = array(
                        'application_id' => $application_id,
                        // 'employee_id' => $dataXinJobs['user_id_emp'],
                        'nama' => str_replace("'", "", $dataXinJobs['full_name']),
                        'created_at' => date("Y-m-d H:i:s"),
                        'created_by' => $hr_by,
                        'is_already_sent' => 1
                    );
                    $create_fack = $this->db->insert("fack_personal_details", $data);
                    $send = $this->send_fack_to_karyawan($application_id);
                    $response['send_notif'] = $send;
                }
            }
            $response['data'] = $data;
            $response['create_fack'] = $create_fack;
        } else {
            $response['status'] = 400;
            $response['msg'] = "Bad Request";
        }
        echo json_encode($response);
    }

    public function send_fack_to_karyawan($applicant_id)
    {
        if (isset($applicant_id)) {
            // Query ke database tetap sama
            $data_karyawan = $this->db->query("SELECT
                j.job_id,
                pic_req.user_id AS user_id_pic,
                CONCAT(pic_req.first_name,' ',pic_req.last_name) AS pic_req_name,
                COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),1,1) = '0',
                CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),2)),
                REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ','')
                ),'') AS pic_req_no_hp,
                ja.full_name,
                c.`name` AS company_name,
                jt.type,
                ur.role_name,
                j.job_title,
                j.short_description,
                ja.contact,
                COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ',''),1,1) = '0',
                CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ',''),2)),
                REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ','')
                ),'') AS nomor_hp_bersih
                FROM
                `xin_job_applications` ja
                LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
                LEFT JOIN trusmi_interview i ON i.application_id = ja.application_id
                LEFT JOIN xin_employees pic_req ON pic_req.user_id = i.created_by
                LEFT JOIN xin_users u ON ja.user_id = u.user_id
                LEFT JOIN xin_companies c ON c.company_id = u.company_id
                LEFT JOIN xin_job_type jt ON jt.job_type_id = j.job_type
                LEFT JOIN xin_user_roles ur ON j.position_id = ur.role_id
                WHERE ja.application_id = '$applicant_id'")->row_array();

            if (!$data_karyawan) {
                echo json_encode(['msg' => 'Data karyawan tidak ditemukan.']);
                return;
            }
            // var_dump($data_karyawan);die();

            $hash_application_id = $this->hashApplicantId($applicant_id);

            // Siapkan body pesan sekali saja
            $messageBody = "👤Alert!!! 

*Permintaan Pengisian Kelengkapan Form Registrasi Calon Karyawan Trusmi Group*

Dear Bpk / Ibu " . $data_karyawan['full_name'] . ", 

Menindaklanjuti proses seleksi karyawan sesuai detail dibawah ini:
🏣Company : " . $data_karyawan['company_name'] . "
📍Position : *" . $data_karyawan['job_title'] . "*
🏆Level : " . $data_karyawan['role_name'] . "
🔒Status : " . $data_karyawan['type'] . "
📑Jobdesc : " . $data_karyawan['short_description'] . "

Terdapat pemintaan pengisian kelengkapan data pribadi sesuai link berikut :

https://www.trusmiverse.com/apps/fack/form/" . $hash_application_id . "

Mohon segera melengkapi data pribadi dan kami akan melanjutkan pada tahap offering. Terimakasih 🙏🏻";

            // Kirim pesan ke semua penerima menggunakan fungsi send_wa()
            $response = [];
            $response['karyawan'] = $this->send_wa_blast($data_karyawan['nomor_hp_bersih'], $messageBody, 0);
            $response['pic_request'] = $this->send_wa_blast($data_karyawan['pic_req_no_hp'], $messageBody, $data_karyawan['user_id_pic']);
            $response['comben'] = $this->send_wa_blast('6281120012145', $messageBody, 78);
            $response['it'] = $this->send_wa_blast('6285860428016', $messageBody, 5203);

            echo json_encode($response);
        } else {
            $response['msg'] = "Bad request";
            echo json_encode($response);
        }
    }
    //     public function send_fack_to_karyawan_old($applicant_id)
    //     {

    //         if (isset($applicant_id)) {
    //             $data_karyawan = $this->db->query("SELECT
    //                     j.job_id,
    //                     CONCAT(pic_req.first_name,' ',pic_req.last_name) AS pic_req_name,
    //                     COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),1,1) = '0',
    //                 CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),2)),
    //                 REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ','')
    //                 ),'') AS pic_req_no_hp,
    //                     ja.full_name,
    //                     c.`name` AS company_name,
    //                     jt.type,
    //                     ur.role_name,
    //                     j.job_title,
    //                     j.short_description,
    //                     ja.contact,
    //                     COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ',''),1,1) = '0',
    //                 CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ',''),2)),
    //                 REPLACE(REPLACE(REPLACE(ja.contact,'+',''),'-',''),' ','')
    //                 ),'') AS nomor_hp_bersih
    //                 FROM
    //                     `xin_job_applications` ja
    //                     LEFT JOIN xin_jobs j ON j.job_id = ja.job_id
    //                     LEFT JOIN trusmi_interview i ON i.application_id = ja.application_id
    //                     LEFT JOIN xin_employees pic_req ON pic_req.user_id = i.created_by
    //                     LEFT JOIN xin_users u ON ja.user_id = u.user_id
    //                     LEFT JOIN xin_companies c ON c.company_id = u.company_id
    //                     LEFT JOIN xin_job_type jt ON jt.job_type_id = j.job_type
    //                     LEFT JOIN xin_user_roles ur ON j.position_id = ur.role_id
    //                 WHERE ja.application_id = '$applicant_id'")->row_array();

    //             $hash_application_id = $this->hashApplicantId($applicant_id);

    //             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 // "channelID" => "2319536345", // Channel Trusmi Group
    //                 "phone" => $data_karyawan['nomor_hp_bersih'],
    //                 "messageType" => "text",
    //                 "body" => "👤Alert!!! 

    // *Permintaan Pengisian Kelengkapan Form Registrasi Calon Karyawan Trusmi Group*

    // Dear Bpk / Ibu " . $data_karyawan['full_name'] . ", 

    // Menindaklanjuti proses seleksi karyawan sesuai detail dibawah ini:
    // 🏣Company : " . $data_karyawan['company_name'] . "
    // 📍Position : *" . $data_karyawan['job_title'] . "*
    // 🏆Level : " . $data_karyawan['role_name'] . "
    // 🔒Status : " . $data_karyawan['type'] . "
    // 📑Jobdesc : " . $data_karyawan['short_description'] . "

    // Terdapat pemintaan pengisian kelengkapan data pribadi sesuai link berikut :

    // https://www.trusmiverse.com/apps/fack/form/" . $hash_application_id . "

    // Mohon segera melengkapi data pribadi dan kami akan melanjutkan pada tahap offering. Terimakasih 🙏🏻",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method"  => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" =>  "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text  = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);


    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 "phone" => $data_karyawan['pic_req_no_hp'],
    //                 "messageType" => "text",
    //                 "body" => "👤Alert!!! 

    // *Permintaan Pengisian Kelengkapan Form Registrasi Calon Karyawan Trusmi Group*

    // Dear Bpk / Ibu " . $data_karyawan['full_name'] . ", 

    // Menindaklanjuti proses seleksi karyawan sesuai detail dibawah ini:
    // 🏣Company : " . $data_karyawan['company_name'] . "
    // 📍Position : *" . $data_karyawan['job_title'] . "*
    // 🏆Level : " . $data_karyawan['role_name'] . "
    // 🔒Status : " . $data_karyawan['type'] . "
    // 📑Jobdesc : " . $data_karyawan['short_description'] . "

    // Terdapat pemintaan pengisian kelengkapan data pribadi sesuai link berikut :

    // https://www.trusmiverse.com/apps/fack/form/" . $hash_application_id . "

    // Mohon segera melengkapi data pribadi dan kami akan melanjutkan pada tahap offering. Terimakasih 🙏🏻",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method"  => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" =>  "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text  = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);


    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 // "channelID" => "2319536345", // Channel Trusmi Group
    //                 "phone" => '6281120012145', // comben
    //                 "messageType" => "text",
    //                 "body" => "👤Alert!!! 

    // *Permintaan Pengisian Kelengkapan Form Registrasi Calon Karyawan Trusmi Group*

    // Dear Bpk / Ibu " . $data_karyawan['full_name'] . ", 

    // Menindaklanjuti proses seleksi karyawan sesuai detail dibawah ini:
    // 🏣Company : " . $data_karyawan['company_name'] . "
    // 📍Position : *" . $data_karyawan['job_title'] . "*
    // 🏆Level : " . $data_karyawan['role_name'] . "
    // 🔒Status : " . $data_karyawan['type'] . "
    // 📑Jobdesc : " . $data_karyawan['short_description'] . "

    // Terdapat pemintaan pengisian kelengkapan data pribadi sesuai link berikut :

    // https://www.trusmiverse.com/apps/fack/form/" . $hash_application_id . "

    // Mohon segera melengkapi data pribadi dan kami akan melanjutkan pada tahap offering. Terimakasih 🙏🏻",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method"  => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" =>  "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text  = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);


    //             echo json_encode($response);
    //         } else {
    //             $response['msg'] = "Bad request";
    //             echo json_encode($response);
    //         }
    //     }

    public function form($ciphertext = null)
    {

        if (isset($ciphertext)) {
            $application_id = preg_replace('/[^0-9.]+/', '', $ciphertext);
            $calon_karyawan = $this->model_fack->get_data_calon_karyawan_by_id($application_id);
            $m_pendidikan = $this->model_fack->get_pendidikan();
            $agama = $this->model_fack->get_agama();
            $data['pageTitle'] = "F.R.C.K";
            $data['ck'] = $calon_karyawan;
            $data['profile'] = $this->model_fack->profile_karir($application_id);
            $data['pendidikan'] = $this->model_fack->pendidikan_karir($application_id);
            $data['pengalaman'] = $this->model_fack->pengalaman_karir($application_id);
            $data['organisasi'] = $this->model_fack->organisasi_karir($application_id);
            $data['agama'] = $agama;
            $data['m_pendidikan'] = $m_pendidikan;
            $this->load->view('fack/form', $data);
        } else {
            $response['status'] = 400;
            $response['msg'] = "Bad Request";
            echo json_encode($response);
        }
    }

    public function update_personal_details()
    {
        $update = null;

        $application_id = $this->input->post('application_id');
        $employee_name = $this->filter->sanitaze_input($this->input->post('employee_name'));
        $no_ktp = $this->input->post('no_ktp');
        if (empty($no_ktp)) {
            $response = [
                'status' => false,
                'message' => 'No KTP wajib diisi!'
            ];
            echo json_encode($response);
            return false; // Menghentikan eksekusi script selanjutnya
        }
        $no_kk = $this->input->post('no_kk');
        $no_npwp = $this->input->post('no_npwp');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tgl_lahir = $this->input->post('tgl_lahir');
        $alamat_ktp = $this->input->post('alamat_ktp');
        $alamat_saat_ini = $this->input->post('alamat_saat_ini');
        $no_hp = $this->input->post('no_hp');
        $email = $this->input->post('email');
        $agama = $this->input->post('agama');
        $kewarganegaraan = $this->input->post('kewarganegaraan');
        $status = $this->input->post('status');

        $data = [
            'nama' => $employee_name,
            'no_ktp' => $no_ktp,
            'no_kk' => $no_kk,
            'no_npwp' => $no_npwp,
            'tempat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'alamat_ktp' => $alamat_ktp,
            'alamat_saat_ini' => $alamat_saat_ini,
            'no_hp' => $no_hp,
            'email' => $email,
            'agama' => $agama,
            'kewarganegaraan' => $kewarganegaraan,
            'status' => $status,
        ];

        $update = $this->db->where('application_id', $application_id)->update('fack_personal_details', $data);

        $response['application_id'] = $application_id;
        $response['data'] = $data;
        $response['update'] = $update;
        echo json_encode($response);
    }


    public function update_lain_lain()
    {
        $update = null;

        $application_id = $this->input->post('application_id');
        $motivasi = $this->input->post('motivasi');
        $kesediaan_1 = $this->input->post('kesediaan_1');
        $kesediaan_2 = $this->input->post('kesediaan_2');
        $kesediaan_3 = $this->input->post('kesediaan_3');
        $kesediaan_4 = $this->input->post('kesediaan_4');
        $kesediaan_5 = $this->input->post('kesediaan_5');
        $hobi = $this->input->post('hobi');

        $data = [
            'motivasi' => $motivasi,
            'kesediaan_1' => $kesediaan_1,
            'kesediaan_2' => $kesediaan_2,
            'kesediaan_3' => $kesediaan_3,
            'kesediaan_4' => $kesediaan_4,
            'kesediaan_5' => $kesediaan_5,
            'hobi' => $hobi,
        ];

        $update = $this->db->where('application_id', $application_id)->update('fack_personal_details', $data);

        $response['application_id'] = $application_id;
        $response['data'] = $data;
        $response['update'] = $update;
        echo json_encode($response);
    }

    public function dt_daftar_keluarga()
    {
        $applicantion_id = $this->input->post('application_id');
        $query = "SELECT id, application_id, employee_id, `status`, nama, COALESCE(jenis_kelamin,'') AS jenis_kelamin, COALESCE(tempat_lahir,'') AS tempat_lahir, COALESCE(tgl_lahir,'') AS tgl_lahir, COALESCE(ed.name,'') AS pendidikan, COALESCE(pekerjaan,'') AS pekerjaan, COALESCE(no_hp,'') AS no_hp FROM fack_families 
        LEFT JOIN xin_qualification_education_level ed ON ed.education_level_id = fack_families.pendidikan
        WHERE application_id = '$applicantion_id'";
        $data = $this->db->query($query)->result();
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_pendidikan()
    {
        $application_id = $this->input->post('application_id');

        // 1. Ambil data utama dari fack_education_level
        $query = "SELECT id, application_id, employee_id, tingkat_pendidikan, nama_instansi, tempat, jurusan, status_pendidikan, keterangan_nilai, tahun_masuk_keluar 
              FROM fack_education_level 
              WHERE application_id = '$application_id'";
        $data = $this->db->query($query)->result();

        // 2. Jika data tidak ditemukan, ambil dari pendidikan_karir dan INSERT
        if (empty($data)) {
            $data_karir = $this->model_fack->pendidikan_karir($application_id);

            // Pastikan $data_karir ada isinya sebelum melakukan insert
            if (!empty($data_karir)) {
                $insert_data = []; // Array untuk menampung data yang akan di-insert

                foreach ($data_karir as $row) {
                    // Jangan masukkan 'id' karena biasanya auto-increment di database
                    $insert_data[] = [
                        'application_id' => $row->application_id,
                        'employee_id' => isset($row->employee_id) ? $row->employee_id : null,
                        'tingkat_pendidikan' => $row->pendidikan,
                        'nama_instansi' => $row->nama_sekolah,
                        'tempat' => $row->nama_sekolah,
                        'jurusan' => $row->jurusan,
                        'status_pendidikan' => '-',
                        'keterangan_nilai' => $row->nilai,
                        'tahun_masuk_keluar' => $row->dari . ' - ' . $row->sampai
                    ];
                }

                // Eksekusi insert batch ke tabel fack_education_level
                $this->db->insert_batch('fack_education_level', $insert_data);

                // 3. Tarik ulang data agar mendapatkan 'id' yang baru terbuat
            }
        }
        $data = $this->db->query($query)->result();

        // 4. Kembalikan response json
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_pengalaman_kerja()
    {
        $application_id = $this->input->post('application_id');

        // 1. Ambil data utama dari fack_work_experience
        $query = "SELECT id, application_id, employee_id, nama_perusahaan, lokasi, posisi, tahun_masuk, tahun_keluar, COALESCE(salary_awal,0) AS salary_awal, COALESCE(salary_akhir,0) AS salary_akhir, alasan_keluar 
              FROM fack_work_experience 
              WHERE application_id = '$application_id'";
        $data = $this->db->query($query)->result();

        if (empty($data)) {
            $data_karir = $this->model_fack->pengalaman_karir($application_id);
            if (!empty($data_karir)) {
                $insert_data = []; // Array untuk menampung data yang akan di-insert

                foreach ($data_karir as $row) {
                    $insert_data[] = [
                        'application_id' => $row->application_id,
                        'employee_id' => isset($row->employee_id) ? $row->employee_id : null,
                        'nama_perusahaan' => $row->nama,       // Diambil dari exp.nama
                        'lokasi' => $row->tempat,     // Diambil dari exp.tempat
                        'posisi' => $row->posisi,     // Diambil dari exp.posisi
                        'tahun_masuk' => $row->dari,       // Diambil dari exp.dari
                        'tahun_keluar' => $row->sampai,     // Diambil dari exp.sampai
                        'salary_awal' => 0,                // Default 0 karena tidak ada di query model
                        'salary_akhir' => 0,                // Default 0 karena tidak ada di query model
                        'alasan_keluar' => !empty($row->deskripsi) ? $row->deskripsi : '-' // Memanfaatkan deskripsi atau '-' jika kosong
                    ];
                }

                // Eksekusi insert batch ke tabel fack_work_experience
                $this->db->insert_batch('fack_work_experience', $insert_data);

                // 3. Tarik ulang data agar mendapatkan 'id' yang baru di-generate database
                $data = $this->db->query($query)->result();
            }
        }

        // 4. Kembalikan response json
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_pengalaman_organisasi()
    {
        $application_id = $this->input->post('application_id');

        // 1. Ambil data utama dari fack_organization_experience
        $query = "SELECT id, application_id, employee_id, nama_organisasi, lokasi, posisi, jenis_kegiatan, masa_aktif 
              FROM fack_organization_experience 
              WHERE application_id = '$application_id'";
        $data = $this->db->query($query)->result();

        // 2. Jika data tidak ditemukan, ambil dari organisasi_karir dan INSERT
        if (empty($data)) {
            // NOTE: Sesuaikan nama modelnya, asumsi menggunakan $this->model_fack
            $data_karir = $this->model_fack->organisasi_karir($application_id);

            // Pastikan $data_karir ada isinya sebelum melakukan insert
            if (!empty($data_karir)) {
                $insert_data = []; // Array untuk menampung data yang akan di-insert

                foreach ($data_karir as $row) {
                    $insert_data[] = [
                        'application_id' => $row->application_id,
                        'employee_id' => isset($row->employee_id) ? $row->employee_id : null,
                        'nama_organisasi' => $row->nama,       // Misal: dari kolom nama
                        'lokasi' => $row->tempat,     // Misal: dari kolom tempat
                        'posisi' => $row->posisi,     // Misal: dari kolom posisi
                        'jenis_kegiatan' => !empty($row->deskripsi) ? $row->deskripsi : '-', // Jika kosong isi strip '-'
                        'masa_aktif' => $row->dari . ' - ' . $row->sampai // Digabung seperti "2023 - 2025"
                        // 'created_at'   => date('Y-m-d H:i:s') // Opsional jika database tidak auto-fill timestamp
                    ];
                }

                // Eksekusi insert batch ke tabel fack_organization_experience
                $this->db->insert_batch('fack_organization_experience', $insert_data);

                // 3. Tarik ulang data agar mendapatkan 'id' yang baru di-generate database
                $data = $this->db->query($query)->result();
            }
        }

        // 4. Kembalikan response json
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_bahasa()
    {
        $applicantion_id = $this->input->post('application_id');
        $query = "SELECT id, application_id, employee_id, bahasa, 
        CASE WHEN lisan = 1 THEN 'Kurang' 
        WHEN lisan = 2 THEN 'Cukup'
        WHEN lisan = 3 THEN 'Baik'
        WHEN lisan = 4 THEN 'Baik Sekali'
        ELSE '' END AS lisan, 
        CASE WHEN tulisan = 1 THEN 'Kurang' 
        WHEN tulisan = 2 THEN 'Cukup'
        WHEN tulisan = 3 THEN 'Baik'
        WHEN tulisan = 4 THEN 'Baik Sekali'
        ELSE '' END AS tulisan 
        FROM fack_language WHERE application_id = '$applicantion_id'";
        $data = $this->db->query($query)->result();
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_training()
    {
        $applicantion_id = $this->input->post('application_id');
        $query = "SELECT id, application_id, employee_id, jenis, penyelenggara, tempat, tahun, dibiayai_oleh FROM fack_training WHERE application_id = '$applicantion_id'";
        $data = $this->db->query($query)->result();
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_pekerjaan_favorit()
    {
        $applicantion_id = $this->input->post('application_id');
        $query = "SELECT id, application_id, employee_id, posisi, COALESCE(ekspektasi_gaji,0) AS ekspektasi_gaji FROM fack_favorite_job WHERE application_id = '$applicantion_id'";
        $data = $this->db->query($query)->result();
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_daftar_referensi()
    {
        $applicantion_id = $this->input->post('application_id');
        $query = "SELECT id, application_id, employee_id, nama, jabatan, hubungan, no_hp FROM fack_reference WHERE application_id = '$applicantion_id'";
        $data = $this->db->query($query)->result();
        $response['data'] = $data;
        echo json_encode($response);
    }

    public function dt_pendidikan()
    {
        $query = "SELECT education_level_id AS id_pendidikan, `name` AS pendidikan FROM `xin_qualification_education_level`";
        $data = $this->db->query($query)->result();
        $application_id = $this->input->post('application_id');
        $response['data'] = $data;
        $response['status_keluarga_sudah_input'] = $this->model_fack->check_status_sudah_input($application_id);
        echo json_encode($response);
    }


    public function store_keluarga()
    {
        $application_id = $this->input->post('application_id_keluarga');
        $employee_id = $this->input->post('employee_id_keluarga');
        $status_keluarga = $this->input->post('status_keluarga');
        $nama_keluarga = $this->input->post('nama_keluarga');
        $jenis_kelamin_keluarga = $this->input->post('jenis_kelamin_keluarga');
        $tempat_lahir_keluarga = $this->input->post('tempat_lahir_keluarga');
        $tgl_lahir_keluarga = $this->input->post('tgl_lahir_keluarga');
        $pendidikan_keluarga = $this->input->post('pendidikan_keluarga');
        $pekerjaan_keluarga = $this->input->post('pekerjaan_keluarga');
        $no_hp = $this->input->post('no_hp');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'   => $employee_id,
            'status' => $status_keluarga,
            'nama' => $nama_keluarga,
            'jenis_kelamin' => $jenis_kelamin_keluarga,
            'tempat_lahir' => $tempat_lahir_keluarga,
            'tgl_lahir' => $tgl_lahir_keluarga,
            'pendidikan' => $pendidikan_keluarga,
            'pekerjaan' => $pekerjaan_keluarga,
            'no_hp' => $no_hp,
            'created_at' => date("Y-m-d H:i:s")
        );
        $store_data = $this->db->insert('fack_families', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }

    public function hapus_keluarga()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_families');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }

    public function dt_add_pendidikan()
    {
        $application_id = $this->input->post('application_id');
        $response['tingkat_pendidikan_sudah_input'] = $this->model_fack->check_status_sudah_input_tingkat_pendidikan($application_id);
        echo json_encode($response);
    }

    public function store_pendidikan()
    {
        $application_id = $this->input->post('application_id_pendidikan');
        $employee_id = $this->input->post('employee_id_pendidikan');
        $tingkat_pendidikan = $this->input->post('tingkat_pendidikan');
        $nama_instansi = $this->input->post('nama_instansi');
        $tempat_instansi = $this->input->post('tempat_instansi');
        $jurusan = $this->input->post('jurusan');
        $status_pendidikan = $this->input->post('status_pendidikan');
        $keterangan_nilai = $this->input->post('keterangan_nilai');
        $tahun_masuk = $this->input->post('tahun_masuk');
        $tahun_keluar = $this->input->post('tahun_keluar');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'tingkat_pendidikan' => $tingkat_pendidikan,
            'nama_instansi' => $nama_instansi,
            'tempat' => $tempat_instansi,
            'jurusan' => $jurusan,
            'status_pendidikan' => $status_pendidikan,
            'keterangan_nilai' => $keterangan_nilai,
            'tahun_masuk_keluar' => $tahun_masuk . " s/d " . $tahun_keluar,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_education_level', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_pendidikan()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_education_level');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function store_pengalaman_kerja()
    {
        $application_id = $this->input->post('application_id_pengalaman_kerja');
        $employee_id = $this->input->post('employee_id_pengalaman_kerja');
        $nama_perusahaan = $this->input->post('nama_perusahaan');
        $lokasi_perusahaan = $this->input->post('lokasi_perusahaan');
        $posisi = $this->input->post('posisi');
        $tahun_masuk_bekerja = $this->input->post('tahun_masuk_bekerja');
        $tahun_keluar_bekerja = $this->input->post('tahun_keluar_bekerja');
        $alasan_keluar = $this->input->post('alasan_keluar');
        $salary_awal_bekerja = $this->input->post('salary_awal_bekerja');
        $salary_akhir_bekerja = $this->input->post('salary_akhir_bekerja');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'nama_perusahaan' => $nama_perusahaan,
            'lokasi' => $lokasi_perusahaan,
            'posisi' => $posisi,
            'tahun_masuk' => $tahun_masuk_bekerja,
            'tahun_keluar' => $tahun_keluar_bekerja,
            'alasan_keluar' => $alasan_keluar,
            'salary_awal' => $salary_awal_bekerja,
            'salary_akhir' => $salary_akhir_bekerja,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_work_experience', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_pengalaman_kerja()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_work_experience');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }

    public function store_pengalaman_organisasi()
    {
        $application_id = $this->input->post('application_id_pengalaman_organisasi');
        $employee_id = $this->input->post('employee_id_pengalaman_organisasi');
        $nama_organisasi = $this->input->post('nama_organisasi');
        $lokasi_organisasi = $this->input->post('lokasi_organisasi');
        $posisi = $this->input->post('posisi_organisasi');
        $jenis_kegiatan = $this->input->post('jenis_kegiatan');
        $masa_aktif = $this->input->post('masa_aktif');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'nama_organisasi' => $nama_organisasi,
            'lokasi' => $lokasi_organisasi,
            'posisi' => $posisi,
            'jenis_kegiatan' => $jenis_kegiatan,
            'masa_aktif' => $masa_aktif,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_organization_experience', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_pengalaman_organisasi()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_organization_experience');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function store_bahasa()
    {
        $application_id = $this->input->post('application_id_bahasa');
        $employee_id = $this->input->post('employee_id_bahasa');
        $bahasa = $this->input->post('bahasa');
        $lisan = $this->input->post('lisan');
        $tulisan = $this->input->post('tulisan');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'bahasa' => $bahasa,
            'lisan' => $lisan,
            'tulisan' => $tulisan,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_language', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_bahasa()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_language');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function store_training()
    {
        $application_id = $this->input->post('application_id_training');
        $employee_id = $this->input->post('employee_id_training');
        $jenis_training = $this->input->post('jenis_training');
        $penyelenggara = $this->input->post('penyelenggara');
        $tempat_training = $this->input->post('tempat_training');
        $tahun_training = $this->input->post('tahun_training');
        $dibiayai_oleh = $this->input->post('dibiayai_oleh');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'jenis' => $jenis_training,
            'penyelenggara' => $penyelenggara,
            'tempat' => $tempat_training,
            'tahun' => $tahun_training,
            'dibiayai_oleh' => $dibiayai_oleh,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_training', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_training()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_training');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function store_pekerjaan_favorit()
    {
        $application_id = $this->input->post('application_id_pekerjaan_favorit');
        $employee_id = $this->input->post('employee_id_pekerjaan_favorit');
        $posisi = $this->input->post('posisi_pekerjaan_favorit');
        $ekspektasi_gaji = $this->input->post('ekspektasi_gaji');
        $tempat_training = $this->input->post('tempat_training');
        $tahun_training = $this->input->post('tahun_training');
        $dibiayai_oleh = $this->input->post('dibiayai_oleh');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'posisi' => $posisi,
            'ekspektasi_gaji' => $ekspektasi_gaji,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_favorite_job', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_pekerjaan_favorit()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_favorite_job');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function store_referensi()
    {
        $application_id = $this->input->post('application_id_referensi');
        $employee_id = $this->input->post('employee_id_referensi');
        $nama_referensi = $this->input->post('nama_referensi');
        $jabatan_referensi = $this->input->post('jabatan_referensi');
        $hubungan_referensi = $this->input->post('hubungan_referensi');
        $no_hp_referensi = $this->input->post('no_hp_referensi');

        $data = array(
            'application_id' => $application_id,
            // 'employee_id'           => $employee_id,
            'nama' => $nama_referensi,
            'jabatan' => $jabatan_referensi,
            'hubungan' => $hubungan_referensi,
            'no_hp' => $no_hp_referensi,
            'created_at' => date("Y-m-d H:i:s")
        );

        $store_data = $this->db->insert('fack_reference', $data);
        $response['data'] = $data;
        $response['status'] = $store_data;
        echo json_encode($response);
    }


    public function hapus_referensi()
    {
        $hapus = null;
        $id = $this->input->post('id');
        $application_id = $this->input->post('application_id');
        if (isset($id) && isset($application_id)) {
            $hapus = $this->db->where('id', $id)->where('application_id', $application_id)->delete('fack_reference');
        }
        $response['hapus'] = $hapus;
        echo json_encode($response);
    }


    public function test_remove_backtip()
    {
        $text = $this->input->post('text');
        $substringsToRemove = ['\'', '"'];
        echo json_encode(str_replace($substringsToRemove, "", $text));
    }

    function create_user_mkt_rsp($user_id, $user_name)
    {
        if ($user_id != "") {
            $check_akun = $this->db->query("SELECT COUNT(id_user) AS jml FROM rsp_project_live.`user` u WHERE u.join_hr = '$user_id' OR u.username = '$user_name'")->row();
            if ($check_akun->jml == 0) {
                $data_mkt = $this->db->query("SELECT
                        e.user_id,
                        e.employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        i.id_user_interview,
                        CONCAT(user_interview.first_name, ' ', user_interview.last_name) AS interview_name,
                        IF(u.id_user = u.spv, u.spv, 170) AS spv,
                        IF(u.id_user = u.spv, u.employee_name, 'Non SPV') AS spv_name,
                        IF(u.id_user = u.spv, u.id_manager, 2029) AS id_manager,
                        IF(u.id_user = u.spv, u.id_gm, NULL) AS id_gm,
                        e.contact_no,
                        e.email,
                        e.address,
                        e.username,
                        e.date_of_joining
                    FROM
                        xin_employees e 
                        LEFT JOIN xin_job_applications a ON a.user_id_emp = e.user_id
                        LEFT JOIN trusmi_interview i ON i.application_id = a.application_id
                        LEFT JOIN xin_employees user_interview ON user_interview.user_id = i.id_user_interview
                        LEFT JOIN rsp_project_live.`user` u ON u.join_hr = IF(i.id_user_interview = 0, NULL, i.id_user_interview)
                    WHERE 
                        e.company_id = 2 AND e.department_id = 120  AND e.designation_id = 731
                        AND e.user_id = $user_id")->row();

                $nik = $data_mkt->employee_id;
                $nama = $data_mkt->employee_name;
                $kontak = $data_mkt->contact_no;
                $email = $data_mkt->email;
                $alamat = $data_mkt->address;
                $username = $data_mkt->username;
                $password = "admin123";
                $manager = $data_mkt->id_manager;
                $gm = $data_mkt->id_gm;
                $divisi = 2;
                $spv = $data_mkt->spv;
                $id_hr = $data_mkt->user_id;
                $date_of_joining = $data_mkt->date_of_joining;
                $referral = 0;

                $data_akun_rsp = array(
                    "nik" => $nik,
                    "employee_name" => $nama,
                    "username" => $username,
                    "password" => md5($password),
                    "contact" => $kontak,
                    "address" => $alamat,
                    "email" => $email,
                    "isActive" => 1,
                    "id_manager" => $manager,
                    "id_gm" => $gm,
                    "id_divisi" => $divisi,
                    "spv" => $spv,
                    "id_hr" => $id_hr,
                    "join_hr" => $id_hr,
                    "date_of_joining" => $date_of_joining,
                    "referral" => $referral,
                    "images" => 'avatar-4dd.png',
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => 1
                );

                if ($data_mkt) {


                    $insert_akun_rsp = $this->db->insert("rsp_project_live.`user`", $data_akun_rsp);

                    $data_mkt_rsp = $this->db->query("SELECT max(id_user) AS id_user FROM rsp_project_live.`user` u WHERE u.join_hr = '$data_mkt->user_id'")->row();

                    $id_user = $data_mkt_rsp->id_user;

                    for ($i = 1; $i <= 32; $i++) {
                        if ($i == 1 || $i == 4) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $data_insert_user_access = array(
                            "id_user" => $id_user,
                            "access_level" => $i,
                            "status" => $status
                        );

                        $insert_user_access[] = $this->db->insert("rsp_project_live.user_access", $data_insert_user_access);
                    }
                }
            }
        }
    }

    // new function to create user for RSP project - dika
    function create_user_project_rsp($user_id, $user_name)
    {
        if ($user_id != "") {
            $check_akun = $this->db->query("SELECT COUNT(id_user) AS jml FROM rsp_project_live.`user` u WHERE u.join_hr = '$user_id' OR u.username = '$user_name'")->row();
            if ($check_akun->jml == 0) {
                $data_project = $this->db->query("SELECT
                        e.user_id,
                        e.employee_id,
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        i.id_user_interview,
                        CONCAT(user_interview.first_name, ' ', user_interview.last_name) AS interview_name,
                        IF(u.id_user = u.spv, u.spv, '') AS spv,
                        IF(u.id_user = u.spv, u.employee_name, 'Non SPV') AS spv_name,
                        IF(u.id_user = u.spv, u.id_manager, 1) AS id_manager,
                        IF(u.id_user = u.spv, u.id_gm, NULL) AS id_gm,
                        e.contact_no,
                        e.email,
                        e.address,
                        e.username,
                        e.date_of_joining
                    FROM
                        xin_employees e 
                        LEFT JOIN xin_job_applications a ON a.user_id_emp = e.user_id
                        LEFT JOIN trusmi_interview i ON i.application_id = a.application_id
                        LEFT JOIN xin_employees user_interview ON user_interview.user_id = i.id_user_interview
                        LEFT JOIN rsp_project_live.`user` u ON u.join_hr = IF(i.id_user_interview = 0, NULL, i.id_user_interview)
                    WHERE 
                        e.company_id = 2 AND e.department_id = 106
                        AND e.user_id = $user_id")->row();

                $nik = $data_project->employee_id;
                $nama = $data_project->employee_name;
                $kontak = $data_project->contact_no;
                $email = $data_project->email;
                $alamat = $data_project->address;
                $username = $data_project->username;
                $password = "admin123";
                $manager = $data_project->id_manager;
                $gm = $data_project->id_gm;
                $divisi = 6;
                $spv = $data_project->spv;
                $id_hr = $data_project->user_id;
                $date_of_joining = $data_project->date_of_joining;
                $referral = 0;

                $data_akun_rsp = array(
                    "nik" => $nik,
                    "employee_name" => $nama,
                    "username" => $username,
                    "password" => md5($password),
                    "contact" => $kontak,
                    "address" => $alamat,
                    "email" => $email,
                    "isActive" => 1,
                    "id_manager" => $manager,
                    "id_gm" => $gm,
                    "id_divisi" => $divisi,
                    "spv" => $spv,
                    "id_hr" => $id_hr,
                    "join_hr" => $id_hr,
                    "date_of_joining" => $date_of_joining,
                    "referral" => $referral,
                    "images" => 'avatar-4dd.png',
                    "created_at" => date('Y-m-d H:i:s'),
                    "created_by" => 1
                );

                if ($data_project) {


                    $insert_akun_rsp = $this->db->insert("rsp_project_live.`user`", $data_akun_rsp);

                    $data_project_rsp = $this->db->query("SELECT max(id_user) AS id_user FROM rsp_project_live.`user` u WHERE u.join_hr = '$data_project->user_id'")->row();

                    $id_user = $data_project_rsp->id_user;

                    for ($i = 1; $i <= 32; $i++) {
                        if ($i == 1 || $i == 9 || $i == 31) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }
                        $data_insert_user_access = array(
                            "id_user" => $id_user,
                            "access_level" => $i,
                            "status" => $status
                        );

                        $insert_user_access[] = $this->db->insert("rsp_project_live.user_access", $data_insert_user_access);
                    }
                }
            }
        }
    }

    public function insert_administrasi()
    {
        $data1 = array(
            'application_id' => $this->input->post('application_id'),
            'application_status' => $this->input->post('status_hasil'),
            'keterangan' => $this->input->post('keterangan'),
            'kendaraan' => $this->input->post('kesediaan_kendaraan'),
            'laptop' => $this->input->post('kesediaan_laptop'),
            'mess' => $this->input->post('kesediaan_mess'),
            'created_by' => $this->session->userdata('user_id'),
            'created_at' => date('Y-m-d H:i:s')
        );

        $query = $this->db->get_where('trusmi_administrasi', array('application_id' => $this->input->post('application_id')));
        $get_iq = $this->db->get_where('trusmi_psikotes', array('application_id' => $this->input->post('application_id')))->row_array();

        $application_id = $this->input->post('application_id');
        $get_user = $this->db->query("SELECT 
            SUBSTRING_INDEX(full_name, ' ', 1) AS first_name, 
            TRIM(REPLACE(full_name,SUBSTRING_INDEX(full_name, ' ', 1),'')) AS last_name,
            email,
            contact,
            tgl_lahir,
            gender,
            alamat_ktp,
            agama,
            status_pernikahan,
            tempat_lahir
        FROM xin_job_applications 
        WHERE application_id = '$application_id'")->row_array();
        $date_of_joining = $this->input->post('date_of_joining');
        $formatted_date = date('ymd', strtotime($date_of_joining));
        // $get_employee_id = $this->db->query("SELECT CONCAT(DATE_FORMAT('$date_of_joining', '%y%m%d'),',',(MAX(SUBSTRING_INDEX(employee_id, ',', -1)) + 1)) AS employee_id, (MAX(SUBSTRING_INDEX(employee_id, ',', -1)) + 1) max_id FROM xin_employees WHERE employee_id LIKE '$formatted_date,%'")->row_array();
        $get_employee_id = $this->db->query("SELECT CONCAT(DATE_FORMAT('$date_of_joining', '%y%m%d'),',',((SUBSTRING_INDEX(employee_id, ',', -1)) + 1)) AS employee_id, ((SUBSTRING_INDEX(employee_id, ',', -1)) + 1) max_id FROM xin_employees ORDER BY user_id DESC, date_of_joining DESC, SUBSTRING_INDEX(employee_id, ', ',-1) DESC LIMIT 1")->row_array();
        // echo json_encode($get_employee_id);
        // die();
        if (isset($get_employee_id)) {
            $max_id = 1;
            $employee_id = "" . $formatted_date . "," . $max_id;
        }
        if ($query->num_rows() > 0) {
            $this->db->where('application_id', $this->input->post('application_id'));
            $this->db->update('trusmi_administrasi', $data1);
        } else {
            $this->db->insert('trusmi_administrasi', $data1);
        }

        if ($this->input->post('status_hasil') == 7) {

            $application_id = $this->input->post('application_id');
            $get_fack_personal_detail = $this->db->query("SELECT 
                SUBSTRING_INDEX(nama, ' ', 1) AS first_name, 
                TRIM(REPLACE(nama,SUBSTRING_INDEX(nama, ' ', 1),'')) AS last_name,
                `status` AS status_pernikahan,
                COALESCE(agama,'') AS agama,
                tgl_lahir,
                COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(no_hp,'+',''),'-',''),' ',''),1,1) = '0',
                CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(no_hp,'+',''),'-',''),' ',''),2)),
                REPLACE(REPLACE(REPLACE(no_hp,'+',''),'-',''),' ','')
                ),'') AS no_hp, 
                email, 
                alamat_ktp, 
                tempat_lahir, 
                pas_foto, 
                no_ktp, 
                no_kk, 
                substr(created_at,1,10) AS ctm_offering, 
                alamat_saat_ini 
            FROM fack_personal_details WHERE application_id = '$application_id'")->row_array();
            $get_fack_families = $this->db->query("SELECT d.application_id, a.nama AS ayah, i.nama AS ibu FROM fack_personal_details d 
            LEFT JOIN fack_families a on a.`status` = 'Ayah' AND a.application_id = d.application_id
            LEFT JOIN fack_families i on i.`status` = 'Ibu' AND i.application_id = d.application_id
            WHERE d.application_id = '$application_id'")->row_array();
            $pas_foto = $get_fack_personal_detail['pas_foto'];
            $profile_picture = '';
            if ($pas_foto != '' && $pas_foto != null) {
                // $imagePath = "/opt/lampp/htdocs/apps/uploads/fack/pas_foto/" . $pas_foto;
                $imagePath = "/var/www/trusmiverse/hr/uploads/fack/pas_foto/" . $pas_foto;
                if (file_exists($imagePath) == 1) {
                    $newPath = "/var/www/trusmiverse/hr/uploads/profile/" . $pas_foto;
                    $copied = copy($imagePath, $newPath);
                    $profile_picture = $pas_foto;
                }
            }


            $is_active = 0;
            if ($this->input->post('date_of_joining') == date("Y-m-d")) {
                $is_active = 1;
            }

            $posisi = explode("|", $this->input->post('designation_administrasi'));
            $get_report_to = $this->db->query("SELECT head_id FROM xin_departments WHERE department_id = '$posisi[1]'")->row_array();
            $user_role_id = $this->input->post('user_role_id');
            $get_ctm_posisi = $this->db->query("SELECT role_name FROM xin_user_roles WHERE role_id = '$user_role_id'")->row_array();
            $default_password = "12345678";
            $options = array('cost' => 12);
            $password_hash = password_hash($default_password, PASSWORD_BCRYPT, $options);
            $substringsToRemove = ['\'', '"'];
            $user_name = strtolower($get_fack_personal_detail['first_name']) . $get_employee_id['max_id'];
            $data_emp = array(
                'employee_id' => $get_employee_id['employee_id'],
                'first_name' => str_replace($substringsToRemove, "", $get_fack_personal_detail['first_name']),
                'office_shift_id' => $this->input->post('office_shift_id'),
                'last_name' => str_replace($substringsToRemove, "", $get_fack_personal_detail['last_name']),
                'username' => strtolower($get_fack_personal_detail['first_name']) . $get_employee_id['max_id'],
                'email' => $get_fack_personal_detail['email'],
                'password' => $password_hash,
                'ctm_password' => md5($default_password),
                'date_of_birth' => $get_fack_personal_detail['tgl_lahir'],
                'gender' => ($get_user['gender'] == 'Pria') ? 'Male' : 'Female',
                'user_role_id' => $this->input->post('user_role_id'),
                'department_id' => $posisi[1],
                'designation_id' => $posisi[0],
                'company_id' => $posisi[2],
                'location_id' => $this->input->post('location_id'),
                'date_of_joining' => $this->input->post('date_of_joining'),
                'marital_status' => ($get_fack_personal_detail['status_pernikahan'] == "") ? "" : $get_fack_personal_detail['status_pernikahan'],
                'address' => ($get_fack_personal_detail['alamat_ktp'] == "") ? "" : $get_fack_personal_detail['alamat_ktp'],
                'profile_picture' => $profile_picture,
                'contact_no' => $get_fack_personal_detail['no_hp'],
                'is_active' => $is_active,
                'leave_categories' => $this->input->post('leave_categories'),
                'ethnicity_type' => ($get_fack_personal_detail['agama'] == "") ? "" : $get_fack_personal_detail['agama'],
                'created_at' => date('Y-m-d H:i:s'),
                'ctm_ayah' => ($get_fack_families['ayah'] == "") ? "" : $get_fack_families['ayah'],
                'ctm_ibu' => ($get_fack_families['ibu'] == "") ? "" : $get_fack_families['ibu'],
                'ctm_noktp' => $get_fack_personal_detail['no_ktp'],
                'ctm_nokk' => $get_fack_personal_detail['no_kk'],
                'ctm_offering' => $get_fack_personal_detail['ctm_offering'],
                'ctm_posisi' => $get_ctm_posisi['role_name'],
                'ctm_report_to' => $get_report_to['head_id'],
                'ctm_domisili' => $get_fack_personal_detail['alamat_saat_ini'],
                'ctm_tempat_lahir' => ($get_fack_personal_detail['tempat_lahir'] == "") ? "" : $get_fack_personal_detail['tempat_lahir'],
                'ctm_iq' => $get_iq['iq'],
                'ctm_disc' => $get_iq['disc3'],
                'ctm_type' => $this->input->post('type'),
                'ctm_grade' => $this->input->post('grade'),
                'ctm_kendaraan' => $this->input->post('kesediaan_kendaraan'),
                'ctm_laptop' => $this->input->post('kesediaan_laptop'),
                'ctm_mess' => $this->input->post('kesediaan_mess'),
                'ctm_pt' => $this->input->post('ctm_pt'),
                'ctm_cutoff' => $this->input->post('cutoff'),
            );

            $insert_karyawan_baru = $this->db->insert('xin_employees', $data_emp);
            // if (!$insert_karyawan_baru) {
            //     $error = $this->db->error();
            //     var_dump("MySQL Error: " . $error['message']);
            //     die();
            // }
            // die();
            // var_dump($insert_karyawan_baru); // This will only be reached if insert is successful
            // die(); // This would stop execution even on success, remove or move if needed

            $username = strtolower($get_fack_personal_detail['first_name']) . $get_employee_id['max_id'];
            $cek_user = $this->db->query("SELECT user_id FROM xin_employees WHERE username = '$username'")->row_array();

            $data2 = array(
                'application_status' => $this->input->post('status_hasil'),
                'user_id_emp' => $cek_user['user_id']
            );
            $this->db->where('application_id', $this->input->post('application_id'));
            $this->db->update('xin_job_applications', $data2);


            $data_fack_employee_id = array(
                'employee_id' => $cek_user['user_id']
            );
            $this->db->where('application_id', $this->input->post('application_id'));
            $this->db->update('fack_personal_details', $data_fack_employee_id);

            $application_id = $this->input->post('application_id');

            $isThereWorkExperience = $this->db->query("SELECT employee_id FROM fack_work_experience WHERE application_id = '$application_id'")->num_rows();
            if ($isThereWorkExperience > 0) {
                $this->db->where('application_id', $application_id);
                $this->db->update('fack_work_experience', $data_fack_employee_id);
                $data_fack_work_experience = $this->db->query("SELECT nama_perusahaan, posisi, tahun_masuk, tahun_keluar FROM fack_work_experience WHERE application_id = '$application_id'")->result();
                foreach ($data_fack_work_experience as $row_fw) {
                    $data_fw = array(
                        'employee_id' => $cek_user['user_id'],
                        'company_name' => $row_fw->nama_perusahaan,
                        'from_date' => $row_fw->tahun_masuk,
                        'to_date' => $row_fw->tahun_keluar,
                        'post' => $row_fw->posisi,
                        'description' => "",
                        'created_at' => date("d-m-Y")
                    );
                    $this->db->insert("xin_employee_work_experience", $data_fw);
                }
            }

            $isThereEducationLevel = $this->db->query("SELECT employee_id FROM fack_education_level WHERE application_id = '$application_id'")->num_rows();
            if ($isThereEducationLevel > 0) {
                $this->db->where('application_id', $application_id);
                $this->db->update('fack_education_level', $data_fack_employee_id);
                $data_educational_level = $this->db->query("SELECT
                    fe.application_id,
                    CASE WHEN fe.tingkat_pendidikan = 'SD' THEN 1
                    WHEN fe.tingkat_pendidikan = 'SLTP' THEN 2
                    WHEN fe.tingkat_pendidikan = 'SLTA' THEN 3
                    WHEN fe.tingkat_pendidikan = 'AKADEMI' THEN 6
                    WHEN fe.tingkat_pendidikan = 'S1' THEN 8
                    WHEN fe.tingkat_pendidikan = 'S2' THEN 9
                    ELSE 1 END AS education_level_id,
                    fe.nama_instansi AS `name`,
                    SUBSTRING_INDEX(fe.tahun_masuk_keluar, 's/d', 1) AS tahun_masuk,
                    SUBSTRING_INDEX(fe.tahun_masuk_keluar, 's/d', -1) AS tahun_keluar,
                    CONCAT('status : ',LOWER(fe.status_pendidikan),', keterangan nilai : ',if(fe.keterangan_nilai= '','-',LOWER(fe.keterangan_nilai)), ', jurusan : ',if(fe.jurusan = '', '-',LOWER(fe.jurusan))) AS `description`
                FROM `fack_education_level` fe WHERE fe.application_id = '$application_id'")->result();
                foreach ($data_educational_level as $row_fe) {
                    $data_fw = array(
                        'employee_id' => $cek_user['user_id'],
                        'name' => $row_fe->name,
                        'education_level_id' => $row_fe->education_level_id,
                        'from_year' => $row_fe->tahun_masuk,
                        'language_id' => 1,
                        'to_year' => $row_fe->tahun_keluar,
                        'skill_id' => 1,
                        'description' => $row_fe->description,
                        'created_at' => date("d-m-Y")
                    );
                    $this->db->insert("xin_employee_qualification", $data_fw);
                }
            }

            $isThereReference = $this->db->query("SELECT employee_id FROM fack_reference WHERE application_id = '$application_id'")->num_rows();
            if ($isThereReference > 0) {
                $this->db->where('application_id', $application_id);
                $this->db->update('fack_reference', $data_fack_employee_id);
            }

            $isThereFamilies = $this->db->query("SELECT employee_id FROM fack_families WHERE application_id = '$application_id'")->num_rows();
            if ($isThereFamilies > 0) {
                $this->db->where('application_id', $application_id);
                $this->db->update('fack_families', $data_fack_employee_id);
            }

            $isThereFamilies = $this->db->query("SELECT employee_id FROM fack_favorite_job WHERE application_id = '$application_id'")->num_rows();
            if ($isThereFamilies > 0) {
                $this->db->where('application_id', $application_id);
                $this->db->update('fack_favorite_job', $data_fack_employee_id);
            }


            $notif_aktivasi = $this->send_notifikasi_aktivasi_absen_to_karyawan($cek_user['user_id']); // aktivasi kirim absen ke karyawan disini mas sidik
            $notif_offering = $this->send_wa_offering_result($this->input->post('application_id'));
            if ($posisi[2] == '2') {
                $notif_offering_rsp = $this->send_wa_offering_result_simple($this->input->post('application_id'));
            }
            $response['user_id'] = $cek_user['user_id'];
            $response['status'] = $insert_karyawan_baru;
            $response['msg'] = 'test';
            echo json_encode($response);

            // 'department_id'     => $posisi[1],
            // 'designation_id'    => $posisi[0],
            // 'company_id'        => $posisi[2],
            // e.company_id = 2 AND e.department_id = 120  AND e.designation_id = 731
            // $cek_user['user_id']
            if ($posisi[2] == 2 && $posisi[1] == 120 && ($posisi[0] == 731 || $posisi[0] == 926 || $posisi[0] == 1690)) {
                $user_id = $cek_user['user_id'];
                if ($user_id != "") {
                    $this->create_user_mkt_rsp($user_id, $user_name);
                }
            }

            // create user project rsp
            if ($posisi[2] == 2 && $posisi[1] == 106) {
                $user_id = $cek_user['user_id'];
                if ($user_id != "") {
                    $this->create_user_project_rsp($user_id, $user_name);
                }
            }
        } else {

            $data3 = array(
                'application_status' => $this->input->post('status_hasil'),
                'alasan_gagal_join' => $this->input->post('select_alasan')
            );
            $update_xin_job = $this->db->where('application_id', $this->input->post('application_id'))->update('xin_job_applications', $data3);
            $response['status'] = $update_xin_job;
            $response['msg'] = 'test di else';
            echo json_encode($response);
        }
    }

    public function check_data()
    {
        $data_fack_work_experience = $this->db->query("SELECT nama_perusahaan, posisi, tahun_masuk, tahun_keluar FROM fack_work_experience WHERE application_id = '34216'")->result();
        foreach ($data_fack_work_experience as $row_fw) {
            $data_fw = array(
                'employee_id' => 2063,
                'company_name' => $row_fw->nama_perusahaan,
                'from_date' => $row_fw->tahun_masuk,
                'to_date' => $row_fw->tahun_keluar,
                'post' => $row_fw->posisi,
                'description' => "",
                'created_at' => date("d-m-Y")
            );
            // $this->db->insert("fack_work_experience", $data_fw);
        }
    }

    public function send_notifikasi_aktivasi_absen_to_karyawan($user_id)
    {
        if (isset($user_id)) {
            // 1. Query database untuk mendapatkan data (tidak ada perubahan di sini)
            $data_karyawan = $this->db->query("SELECT
                ja.application_id,
                pic_req.user_id AS user_id_pic,
                CONCAT(pic_req.first_name,' ',pic_req.last_name) AS pic_req_name,
                COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),1,1) = '0',
                CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),2)),
                REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ','')
                ),'') AS pic_req_no_hp,
                TRIM(CONCAT( e.first_name, ' ', REPLACE(e.last_name, ' (Karyawan Baru)', '') )) AS employee_name,
                c.`name` AS company_name,
                d.department_name,
                d.publik,
                CASE WHEN e.company_id = 3 THEN 'https://trusmicorp.com/apk/trusmiontime_bali/trusmiontime_bali.apk'
                ELSE IF(d.publik = 1,'https://bit.ly/trusmiontime_quiz_130_mkt','https://bit.ly/trusmiontime_quiz_130') END AS link_absen,
                ds.designation_name,
                ol.location_name,
                e.username,
                e.user_id AS user_id,
                '12345678' AS `password`,
                COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ',''),1,1) = '0',
                CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ',''),2)),
                REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ','')
                ),'') AS contact_no
                FROM
                xin_employees e
                LEFT JOIN xin_companies c ON c.company_id = e.company_id
                LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
                LEFT JOIN xin_job_applications ja ON ja.user_id_emp = e.user_id
                LEFT JOIN xin_jobs job ON job.job_id = ja.job_id
                LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic
                LEFT JOIN xin_departments d ON d.department_id = e.department_id 
                LEFT JOIN xin_office_location ol ON ol.location_id = e.location_id
                WHERE e.user_id = '$user_id'")->row_array();

            // Jika data tidak ditemukan, hentikan proses
            if (!$data_karyawan) {
                $response['msg'] = "Data karyawan tidak ditemukan";
                return $response;
            }

            // 2. Panggil notifikasi FDK (tidak ada perubahan)
            $this->notifikasi_fdk($data_karyawan);

            // 3. Siapkan body pesan sekali saja
            $messageBody = "📣📣 *Aktivasi Absen Karyawan* 📝📝 

Selamat datang *" . $data_karyawan['employee_name'] . "* di *Trusmi Group!*

Kami sangat senang Anda bisa bergabung sebagai bagian dari keluarga besar *Trusmi Group*. Kehadiran Anda di sini adalah sesuatu yang berharga bagi tim kami. Kami yakin Anda akan membawa banyak dampak positif, semangat baru dan kami berharap Anda dapat tumbuh bersama kami dalam mencapai kesuksesan bersama sebagai satu tim yang solid.

Jangan ragu untuk bertanya atau berkolaborasi dengan rekan-rekan tim. Kami selalu siap untuk membantu Anda dalam menghadapi tantangan baru dan mencapai tujuan bersama.

👤 Nama : " . $data_karyawan['employee_name'] . "
🪑 Jabatan : " . $data_karyawan['designation_name'] . "
🏛 Departemen : " . $data_karyawan['department_name'] . "
📍Lokasi : " . $data_karyawan['location_name'] . "

🌎 Link Absen (Android 11+) : http://bit.ly/48ONLQX
🌎 Link Absen (Android 10) : https://bit.ly/47vrLIE

🖥 Username : " . $data_karyawan['username'] . "
🔒 Password : " . $data_karyawan['password'] . "

⚠ Catatan : 
1. Absen menggunakan wifi ( *attendance* / *finger*, disesuaikan dengan penempatan masing-masing jika menggunakan hak akses absen local ) 
2. Absen di area kantor ( untuk hak akses local, akan tetapi jika anda mendapatkan hak akses absen public, maka anda dapat absen di area kantor / project / kantor pemasaran )
3. WAJIB absen masuk dan pulang
4. Jika masih ada yang ingin ditanyakan anda bisa whatsapp nomor berikut : 081120012145 ( Tim HR Kami )";

            // 4. Panggil fungsi bantuan 'send_wa' untuk setiap penerima
            $response = [];

            $response['karyawan'] = $this->send_wa_blast($data_karyawan['contact_no'], $messageBody, $data_karyawan['user_id']);
            $response['pic_request'] = $this->send_wa_blast($data_karyawan['pic_req_no_hp'], $messageBody, $data_karyawan['user_id_pic']);
            $response['comben'] = $this->send_wa_blast('6281120012145', $messageBody, 78);
            // $response['comben'] = $this->send_wa('6283824955357', $messageBody, 5203);
            // $response['comben'] = $this->send_wa_external('6281120012145', $messageBody, 78);
            // $response['pic_requester'] = $this->send_wa_external($data_karyawan['pic_req_no_hp'], $messageBody, $data_karyawan['user_id_pic']);
            // $response['karyawan'] = $this->send_wa_external($data_karyawan['contact_no'], $messageBody, $data_karyawan['user_id']);

        } else {
            $response['msg'] = "Bad request";
        }

        return $response;
    }
    //     public function send_notifikasi_aktivasi_absen_to_karyawan($user_id)
    //     {

    //         if (isset($user_id)) {
    //             $data_karyawan = $this->db->query("SELECT
    //                                             ja.application_id,
    //                                             pic_req.user_id AS user_id_pic,
    //                                             CONCAT(pic_req.first_name,' ',pic_req.last_name) AS pic_req_name,
    //                                             COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'aktivasi-',''),' ',''),1,1) = '0',
    //                                             CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ',''),2)),
    //                                             REPLACE(REPLACE(REPLACE(pic_req.contact_no,'+',''),'-',''),' ','')
    //                                             ),'') AS pic_req_no_hp,
    //                                             TRIM(CONCAT( e.first_name, ' ', REPLACE(e.last_name, ' (Karyawan Baru)', '') )) AS employee_name,
    //                                             c.`name` AS company_name,
    //                                             d.department_name,
    //                                             d.publik,
    //                                             -- IF(d.publik = 1,'https://bit.ly/trusmiontime_quiz_130_mkt','https://bit.ly/trusmiontime_quiz_130') AS link_absen,
    //                                             CASE WHEN e.company_id = 3 THEN 'https://trusmicorp.com/apk/trusmiontime_bali/trusmiontime_bali.apk'
    //                                             ELSE IF(d.publik = 1,'https://bit.ly/trusmiontime_quiz_130_mkt','https://bit.ly/trusmiontime_quiz_130') END AS link_absen,
    //                                             ds.designation_name,
    //                                             ol.location_name,
    //                                             e.username,
    //                                             e.user_id AS user_id,
    //                                             '12345678' AS `password`,
    //                                             COALESCE(IF(SUBSTR(REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ',''),1,1) = '0',
    //                                             CONCAT('62',SUBSTR(REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ',''),2)),
    //                                             REPLACE(REPLACE(REPLACE(e.contact_no,'+',''),'-',''),' ','')
    //                                             ),'') AS contact_no
    //                                             FROM
    //                                             xin_employees e
    //                                             LEFT JOIN xin_companies c ON c.company_id = e.company_id
    //                                             LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
    //                                             LEFT JOIN xin_job_applications ja ON ja.user_id_emp = e.user_id
    //                                             -- LEFT JOIN trusmi_interview i ON i.application_id = ja.application_id
    //                                             LEFT JOIN xin_jobs job ON job.job_id = ja.job_id
    // 											LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic
    //                                             -- LEFT JOIN xin_employees pic_req ON pic_req.user_id = i.created_by
    //                                             LEFT JOIN xin_departments d ON d.department_id = e.department_id 
    //                                             LEFT JOIN xin_office_location ol ON ol.location_id = e.location_id
    //                                             WHERE
    //             e.user_id = '$user_id'")->row_array();
    //             //passing data ke fdk
    //             $this->notifikasi_fdk($data_karyawan); // notifikasi fdk
    //             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 // "channelID" => "2319536345", // Channel Trusmi Group
    //                 "phone" => '6281120012145', // comben
    //                 "messageType" => "text",
    //                 "body" => "📣📣 *Aktivasi Absen Karyawan* 📝📝 

    // Selamat datang *" . $data_karyawan['employee_name'] . "* di *Trusmi Group!*

    // Kami sangat senang Anda bisa bergabung sebagai bagian dari keluarga besar *Trusmi Group*. Kehadiran Anda di sini adalah sesuatu yang berharga bagi tim kami. Kami yakin Anda akan membawa banyak dampak positif, semangat baru dan kami berharap Anda dapat tumbuh bersama kami dalam mencapai kesuksesan bersama sebagai satu tim yang solid.

    // Jangan ragu untuk bertanya atau berkolaborasi dengan rekan-rekan tim. Kami selalu siap untuk membantu Anda dalam menghadapi tantangan baru dan mencapai tujuan bersama.

    // 👤 Nama : " . $data_karyawan['employee_name'] . "
    // 🪑 Jabatan : " . $data_karyawan['designation_name'] . "
    // 🏛 Departemen : " . $data_karyawan['department_name'] . "
    // 📍Lokasi : " . $data_karyawan['location_name'] . "

    // 🌎 Link Absen : " . $data_karyawan['link_absen'] . "

    // 🖥 Username : " . $data_karyawan['username'] . "
    // 🔒 Password : " . $data_karyawan['password'] . "

    // ⚠ Catatan : 
    // 1. Absen menggunakan wifi ( *attendance* / *finger*, disesuaikan dengan penempatan masing-masing jika menggunakan hak akses absen local ) 
    // 2. Absen di area kantor ( untuk hak akses local, akan tetapi jika anda mendapatkan hak akses absen public, maka anda dapat absen di area kantor / project / kantor pemasaran )
    // 3. WAJIB absen masuk dan pulang
    // 4. Jika masih ada yang ingin ditanyakan anda bisa whatsapp nomor berikut : 081120012145 ( Tim HR Kami )",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method" => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" => "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);


    //             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 // "channelID" => "2319536345", // Channel Trusmi Group
    //                 "phone" => $data_karyawan['pic_req_no_hp'],
    //                 "messageType" => "text",
    //                 "body" => "📣📣 *Aktivasi Absen Karyawan* 📝📝 

    // Selamat datang *" . $data_karyawan['employee_name'] . "* di *Trusmi Group!*

    // Kami sangat senang Anda bisa bergabung sebagai bagian dari keluarga besar *Trusmi Group*. Kehadiran Anda di sini adalah sesuatu yang berharga bagi tim kami. Kami yakin Anda akan membawa banyak dampak positif, semangat baru dan kami berharap Anda dapat tumbuh bersama kami dalam mencapai kesuksesan bersama sebagai satu tim yang solid.

    // Jangan ragu untuk bertanya atau berkolaborasi dengan rekan-rekan tim. Kami selalu siap untuk membantu Anda dalam menghadapi tantangan baru dan mencapai tujuan bersama.

    // 👤 Nama : " . $data_karyawan['employee_name'] . "
    // 🪑 Jabatan : " . $data_karyawan['designation_name'] . "
    // 🏛 Departemen : " . $data_karyawan['department_name'] . "
    // 📍Lokasi : " . $data_karyawan['location_name'] . "

    // 🌎 Link Absen : " . $data_karyawan['link_absen'] . "

    // 🖥 Username : " . $data_karyawan['username'] . "
    // 🔒 Password : " . $data_karyawan['password'] . "

    // ⚠ Catatan : 
    // 1. Absen menggunakan wifi ( *attendance* / *finger*, disesuaikan dengan penempatan masing-masing jika menggunakan hak akses absen local ) 
    // 2. Absen di area kantor ( untuk hak akses local, akan tetapi jika anda mendapatkan hak akses absen public, maka anda dapat absen di area kantor / project / kantor pemasaran )
    // 3. WAJIB absen masuk dan pulang
    // 4. Jika masih ada yang ingin ditanyakan anda bisa whatsapp nomor berikut : 081120012145 ( Tim HR Kami )",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method" => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" => "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);


    //             $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
    //             $data_text = array(
    //                 // "channelID" => "2219204182", // channel BT
    //                 "channelID" => "2308388562", // Channel RSP
    //                 // "channelID" => "2319536345", // Channel Trusmi Group
    //                 "phone" => $data_karyawan['contact_no'],
    //                 "messageType" => "text",
    //                 "body" => "📣📣 *Aktivasi Absen Karyawan* 📝📝 

    // Selamat datang *" . $data_karyawan['employee_name'] . "* di *Trusmi Group!*

    // Kami sangat senang Anda bisa bergabung sebagai bagian dari keluarga besar *Trusmi Group*. Kehadiran Anda di sini adalah sesuatu yang berharga bagi tim kami. Kami yakin Anda akan membawa banyak dampak positif, semangat baru dan kami berharap Anda dapat tumbuh bersama kami dalam mencapai kesuksesan bersama sebagai satu tim yang solid.

    // Jangan ragu untuk bertanya atau berkolaborasi dengan rekan-rekan tim. Kami selalu siap untuk membantu Anda dalam menghadapi tantangan baru dan mencapai tujuan bersama.

    // 👤 Nama : " . $data_karyawan['employee_name'] . "
    // 🪑 Jabatan : " . $data_karyawan['designation_name'] . "
    // 🏛 Departemen : " . $data_karyawan['department_name'] . "
    // 📍Lokasi : " . $data_karyawan['location_name'] . "

    // 🌎 Link Absen : " . $data_karyawan['link_absen'] . "

    // 🖥 Username : " . $data_karyawan['username'] . "
    // 🔒 Password : " . $data_karyawan['password'] . "

    // ⚠ Catatan : 
    // 1. Absen menggunakan wifi ( *attendance* / *finger*, disesuaikan dengan penempatan masing-masing jika menggunakan hak akses absen local ) 
    // 2. Absen di area kantor ( untuk hak akses local, akan tetapi jika anda mendapatkan hak akses absen public, maka anda dapat absen di area kantor / project / kantor pemasaran )
    // 3. WAJIB absen masuk dan pulang
    // 4. Jika masih ada yang ingin ditanyakan anda bisa whatsapp nomor berikut : 081120012145 ( Tim HR Kami )",
    //                 "withCase" => true
    //             );

    //             $options_text = array(
    //                 'http' => array(
    //                     "method" => 'POST',
    //                     "content" => json_encode($data_text),
    //                     "header" => "Content-Type: application/json\r\n" .
    //                         "Accept: application/json\r\n" .
    //                         "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
    //                 )
    //             );
    //             $context_text = stream_context_create($options_text);
    //             $result_text = file_get_contents($url, false, $context_text);
    //             $response['text'] = json_decode($result_text);
    //             // echo json_encode($response);

    //         } else {
    //             $response['msg'] = "Bad request";
    //             // echo json_encode($response);
    //         }

    //         return $response;
    //     }


    public function hashApplicantId($applicant_id)
    {
        $arr_applicant_id = str_split($applicant_id, 1);
        $hash = $this->generateRandomString();
        for ($i = 0; $i < COUNT($arr_applicant_id); $i++) {
            $hash .= $arr_applicant_id[$i];
            $hash .= $this->generateRandomString();
        }
        return $hash;
    }

    function generateRandomString($length = 2)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Filepond
    public function filepond_process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $files = $_FILES["filepond"];
            $imageName = null;
            $id = null;

            $structuredFiles = [];
            if (isset($files)) {
                foreach ($files["name"] as $filename) {
                    $structuredFiles[] = [
                        "name" => $filename
                    ];
                }

                foreach ($files["type"] as $index => $filetype) {
                    $structuredFiles[$index]["type"] = $filetype;
                }

                foreach ($files["tmp_name"] as $index => $file_tmp_name) {
                    $structuredFiles[$index]["tmp_name"] = $file_tmp_name;
                }

                foreach ($files["error"] as $index => $file_error) {
                    $structuredFiles[$index]["error"] = $file_error;
                }

                foreach ($files["size"] as $index => $file_size) {
                    $structuredFiles[$index]["size"] = $file_size;
                }
            }

            $uniqueImgID = null;
            if (count($structuredFiles)) {
                foreach ($structuredFiles as $structuredFile) {
                    $uniqueImgID = $this->saveImagesToTempLocation($structuredFile);
                }
            }

            $response = [];
            if ($uniqueImgID) {

                $response["status"] = "success";
                $response["key"] = $uniqueImgID;
                $response["msg"] = null;
                $response["files"] = json_encode($structuredFiles);

                http_response_code(200);
            } else {

                $response["status"] = "error";
                $response["key"] = null;
                $response["msg"] = "An error occured while uploading image";
                $response["files"] = json_encode($structuredFiles);

                http_response_code(400);
            }

            header('Content-Type: application/json');
            echo json_encode($response);

            exit();
        } else {

            exit();
        }
    }

    function saveImagesToTempLocation($uploadedFile)
    {

        global $imageName;
        global $application_id;

        $imageUniqueId = null;

        // check that there were no errors while uploading file 
        if (isset($uploadedFile) && $uploadedFile['error'] === UPLOAD_ERR_OK) {

            $application_id = $this->input->post('application_id');
            $kode_name = "PF_" . $application_id . "_";
            $imageName = $this->uploadImageFilepond($uploadedFile, './uploads/fack/pas_foto/', $kode_name);

            if ($imageName) {

                $filePointer = './uploads/fack/pas_foto/' . $imageName;

                $newImageInfo = [
                    "pas_foto" => $imageName,
                    "updated_at" => date("Y-m-d H:i:s")
                ];

                $this->db->where('application_id', $application_id)->update("fack_personal_details", $newImageInfo);

                // array_push($arrayDBStore, $newImageInfo);

                // writeJsonFile($arrayDBStore);
            }
        }

        return $application_id;
    }


    function uploadImageFilepond($file, $fileDestination = "", $newName = "")
    {
        if ($fileDestination != "") {
            $fileName = $file['name'];
            $fileType = $file['type'];
            $fileTempName = $file['tmp_name'];
            $fileError = $file['error'];
            $fileSize = $file['size'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowedExts = array('jpg', 'jpeg', 'png', 'svg', 'gif');

            if (in_array($fileActualExt, $allowedExts)) {
                if ($fileError === 0) {
                    if ($fileSize < 2000000) {
                        $fileNewName = $newName . time() . "." . $fileActualExt;
                        $fileDestination = $fileDestination . $fileNewName;
                        move_uploaded_file($fileTempName, $fileDestination);

                        return $fileNewName;
                    } else {
                        return false; // error: file size too big
                    }
                } else {
                    return false; // error: error uploading file
                }
            } else {
                return false; // error: file ext not allowed
            }
        } else {
            return false; // no destination
        }
    }

    public function filepond_revert($key)
    {
        if ($_SERVER['REQUEST_METHOD'] === "DELETE") {

            $uniqueFileID = $key;

            $response = [];
            // trigger revertFunction
            if ($this->revertImagesFromUploadsLocation($uniqueFileID)) {

                $response["status"] = "success";
                $response["key"] = $uniqueFileID;

                http_response_code(200);
            } else {

                $response["status"] = "error";
                $response["msg"] = "File could not be deleted";

                http_response_code(400);
            }

            header('Content-Type: application/json');
            echo json_encode($response);

            exit();
        } else {
            exit();
        }
    }

    function revertImagesFromUploadsLocation($uniqueFileID)
    {

        $imgName = null;

        // check if there is a filename in the DB with key and campaignId
        $personal_data = $this->db->query("SELECT `pas_foto` FROM fack_personal_details WHERE application_id = '$uniqueFileID'")->row_array();

        // $arrayDBStore = readJsonFile();

        // $imageInfoIndex = array_search($uniqueFileID, array_column($arrayDBStore, 'id'));

        if (isset($personal_data)) {
            $imageInfo = $personal_data;
            $imgName = $imageInfo["pas_foto"];
        }

        if ($imgName != null || $imgName != "") {
            // check if there is file ($imgName) in ./images/ path on the server
            $imgFilePointer = './uploads/fack/pas_foto/' . $imgName;
            // if file exists --> delete file from server
            if (file_exists($imgFilePointer)) {
                $filedeleted = unlink($imgFilePointer);
                if ($filedeleted) {
                    // removing file from DB as well
                    // unset($arrayDBStore[$imageInfoIndex]);
                    // writeJsonFile($arrayDBStore);
                    $data_image = array(
                        'pas_foto' => '',
                        "updated_at" => date("Y-m-d H:i:s")
                    );
                    $this->db->where("application_id", $uniqueFileID)->update("fack_personal_details", $data_image);
                }
                return $filedeleted;
            }
        }

        return true;
    }

    public function filepond_load($key)
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {



            // $headers = getRequestHeaders();

            // header('Content-Type: application/json');
            // echo json_encode(["headers" =>$headers, "get" => $_GET]);
            // exit();

            $uniqueFileID = $key;


            // trigger load local image
            $loadImageResultArr = [$fileBlob, $imageName] = $this->loadLocalImage($uniqueFileID);
            // var_dump($loadImageResultArr);

            if ($fileBlob) {
                $imagePointer = './uploads/fack/pas_foto/' . $imageName;
                $fileContextType = mime_content_type($imagePointer);
                $fileSize = filesize($imagePointer);

                // $handle = fopen($imagePointer, 'r');
                // if (!$handle) return false;
                // $content = fread($handle, filesize($imagePointer));

                http_response_code(200);
                header('Access-Control-Expose-Headers: Content-Disposition, Content-Length, X-Content-Transfer-Id');
                header("Content-Type: $fileContextType");
                header("Content-Length: $fileSize");
                header("Content-Disposition: inline; filename='$imageName'");
                echo $fileBlob;
                // echo json_encode(strlen($fileBlob));
            } else {
                http_response_code(500);
            }

            exit();
        } else {

            http_response_code(400);
            exit();
        }
    }

    function getRequestHeaders()
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }

    function loadLocalImage($uniqueFileID)
    {

        $imageName = null;

        // checking if image exists in db with uniqueFileID
        $personal_data = $this->db->query("SELECT `pas_foto` FROM fack_personal_details WHERE application_id = '$uniqueFileID'")->row_array();

        if (isset($personal_data)) {
            $imageInfo = $personal_data;
            $imgName = $imageInfo["pas_foto"];
        }
        // if imageName was found in the DB, get file with imageName and return file object or blob
        $imagePointer = './uploads/fack/pas_foto/' . $imgName;
        $fileObject = null;
        if ($imgName != null || $imgName != "") {
            if (file_exists($imagePointer) == 1) {
                $fileObject = file_get_contents($imagePointer);
            }
        }

        return [$fileObject, $imgName];
    }

    public function send_wa_offering_result($application_id)
    {
        $result_text['wa_api'] = "";
        $offering = $this->model_fack->get_send_offering_result($application_id);

        // $kontak[]     = '6285860428016'; // Lutfiedadi
        $kontak[] = $offering['pic_contact'];
        $kontak[] = $offering['req_contact'];
        $kontak[] = $offering['aprv_contact'];
        $kontak[] = $offering['interview_contact'];
        // $kontak[]     = '628993036965'; // Faisal

        $str = $offering['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2308388562",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 

*Offering Result*

🏣Company : " . $offering['company'] . "
🗃️Department : " . $offering['department'] . "
📍Position : *" . $offering['position'] . "*
🏆Level : " . $offering['level'] . "
📝Need : " . $offering['need'] . "
🔒Status : " . $offering['status'] . "
📑Jobdesk : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

Terdapat informasi hasil offering dengan detail informasi sbb : 

👤Nama Kandidat : " . $offering['full_name'] . "
📝Keterangan Offering : " . $offering['keterangan'] . "
🛵Kesediaan Membawa Kendaraan : " . $offering['kendaraan'] . "
💻Kesediaan Menggunakan Laptop Pribadi : " . $offering['laptop'] . "
🏡Fasilitas Mess : " . $offering['mess'] . "
🗓Join Date : " . $offering['date_of_joining'] . "",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method" => 'POST',
                    "content" => json_encode($data_text),
                    "header" => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text = stream_context_create($options_text);
            $result_text['wa_api'] = file_get_contents($url, false, $context_text);
        }

        return $result_text;
    }



    public function send_wa_offering_result_simple($application_id)
    {
        $result_text['wa_api'] = "";
        $offering = $this->model_fack->get_send_offering_result($application_id);

        $kontak[] = '628996999783'; // ali
        // $kontak[]     = '6289513275135'; // arari
        // $kontak[]      = $offering['pic_contact'];
        // $kontak[]      = $offering['req_contact'];
        // $kontak[]      = $offering['aprv_contact'];
        // $kontak[]      = $offering['interview_contact'];
        // $kontak[]     = '628993036965'; // Faisal

        $str = $offering['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2308388562",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 

*Offering Result*

🏣Company : " . $offering['company'] . "
🗃️Department : " . $offering['department'] . "
📍Position : *" . $offering['position'] . "*
🏆Level : " . $offering['level'] . "

Terdapat informasi hasil offering dengan detail informasi sbb : 

👤Nama Kandidat : " . $offering['full_name'] . "
🗓Join Date : " . $offering['date_of_joining'] . "",
                "withCase" => true
            );

            $options_text = array(
                'http' => array(
                    "method" => 'POST',
                    "content" => json_encode($data_text),
                    "header" => "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text = stream_context_create($options_text);
            $result_text['wa_api'] = file_get_contents($url, false, $context_text);
        }

        return $result_text;
    }

    function printIDCard($id)
    {
        $this->model_fack->isPrinted($id);
        $data['my_profile'] = $this->model_profile->get_profile_by_id($id)->row();
        // var_dump($data['my_profile']);
        // die;
        $this->load->view('idcard/print', $data);
    }

    function printBatch()
    {
        $temp = array();
        $a = $this->input->post("id_user");
        if ($a) {
            for ($i = 0; $i < count($a); $i++) {

                $this->model_fack->isPrinted($a[$i]);
                $cek = $this->model_profile->get_profile_by_id($a[$i])->row();
                // var_dump(count($a));
                // die;
                array_push($temp, $cek);
            }

            $data['my_profile'] = $temp;
            // var_dump($data);
            // die;
            $this->load->view('idcard/print-batch', $data);
        } else {
            echo "<script>window.close()</script>";
        }
    }

    function downloadIDCard($id)
    {
        $data['my_profile'] = $this->model_profile->get_profile_by_id($id)->row();
        $this->load->view('idcard/download', $data);
    }

    public function id_card()
    {
        if ($this->session->userdata('user_id') != "") {
            $data['pageTitle'] = "ID Card Karyawan";
            $data['css'] = "fack/css";
            $data['js'] = "fack/js_card";
            $data['content'] = "fack/index_card";
            $this->load->view('layout/main', $data);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function dt_fack_card()
    {
        $start = $this->input->post('start') ?? date("Y-m-01");
        $end = $this->input->post('end') ?? date("Y-m-t");
        $id_user = $this->input->post('id_user');
        $response['data'] = $this->model_fack->dt_fack_card($start, $end, $id_user);
        echo json_encode($response);
    }

    public function isRevisi($id)
    {
        $data = $this->model_fack->isRevisi($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'Berhasil',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal',
            ];
        }
        echo json_encode($response);
    }

    public function unRevisi($id)
    {
        $data = $this->model_fack->unRevisi($id);
        if ($data) {
            $response = [
                'status' => true,
                'message' => 'Berhasil',
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Gagal',
            ];
        }
        echo json_encode($response);
    }

    public function dummy()
    {
        // $this->model_fack->dummy();
    }
    public function notifikasi_fdk($data)
    {
        $this->load->library('Whatsapp_lib');
        $msg = "🔔Notifikasi Pengisian FDK
*Formulir Dokumen Karyawan*

Dear Bpk / Ibu : " . $data['employee_name'] . "
🏣Company : " . $data['company_name'] . "
📍Position : " . $data['designation_name'] . "

Dalam upaya memverifikasi inputan pada Form Registrasi Calon Karyawan, kami mohon kesediaan Bapak/Ibu untuk mengisi formulir dokumen karyawan yang telah kami sediakan.

Dengan melampirkan beberpa dokumen seperti *KTP, KK, Lamaran, CV, Ijazah dan Dokumen lainnya* di link berikut : 
🔗 " . base_url('fdk/form/') . $this->hashApplicantId($data['user_id']) . "

Ketentuan :
📄 Dokumen harus berbentuk *jpg atau png*
📷 Foto yang di lampirkan harus *jelas dan memenuhi standar*
⏳ *Leadtime pengisian FDK maksimal 3 hari* dari tanggal join atau hari pertama kerja, maksimal pengisian jam 17:00 
🔒 *Lock Absen berlaku* jika belum mengisi dan tidak memenuhi standar pada Dokumen Wajib dan *berpengaruh pada absensi* di hari Lock Absen

Terima kasih atas perhatian dan kerjasamanya.";
        // $this->whatsapp_lib->send_single_msg('eaf', $data['contact_no'], $msg);
        // $this->whatsapp_lib->send_single_msg('eaf', $data['pic_req_no_hp'], $msg);
        // $this->whatsapp_lib->send_single_msg('eaf', '6281120012145', $msg);

        $hasil = $this->send_wa_blast($data['contact_no'], $msg, $data['user_id']);
        $this->send_wa_blast($data['pic_req_no_hp'], $msg, $data['user_id_pic']);
        $this->send_wa_blast('6281120012145', $msg, 78);

        // $hasil = $this->send_wa_external($data['contact_no'], $msg);
        // $this->send_wa_external($data['pic_req_no_hp'], $msg, $data['user_id_pic']);
        // $this->send_wa_external('081120012145', $msg, 78);

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

    function send_wa_external($phone, $msg)
    {
        try {
            $this->load->library('WAJS_eksternal');
            return $this->wajs_eksternal->send_wajs_notif_eksternal($phone, $msg, 'text', 'trusmiverse');
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }

    function send_wa_blast($phone = null, $msg = null, $user_id = null, $tipe = 'text', $url = '', $filename = null)
    {
        // Jika dipanggil via API (JSON)
        if ($phone === null && $msg === null) {
            $data = json_decode($this->input->raw_input_stream, true);

            $phone = $data['phone'] ?? null;
            $msg = $data['msg'] ?? null;
            $user_id = $data['user_id'] ?? null;
            $tipe = $data['tipe'] ?? 'notification';
            $url = $data['url'] ?? '';
            $filename = $data['filename'] ?? null;
        }

        $this->load->library('WAJS_hr');

        $wa_status = $this->wajs_hr->send_wajs_notif_hr(
            $phone,
            $msg,
            $tipe,
            'trusmiverse',
            $user_id,
            $url
        );

        return [
            'phone' => $phone,
            'msg' => $msg,
            'user_id' => $user_id,
            'tipe' => $tipe,
            'url' => $url,
            'filename' => $filename,
            'wa_status' => $wa_status
        ];
    }
    function load_data_karir()
    {
        $application_id = $this->input->post('application_id');
        $data = [
            'profile' => $this->model_fack->profile_karir($application_id),
            'pendidikan' => $this->model_fack->pendidikan_karir($application_id),
            'pengalaman' => $this->model_fack->pengalaman_karir($application_id),
            'organisasi' => $this->model_fack->organisasi_karir($application_id),
        ];
        echo json_encode($data);
    }
}
