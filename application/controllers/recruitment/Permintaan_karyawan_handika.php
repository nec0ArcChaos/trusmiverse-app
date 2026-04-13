<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Permintaan_karyawan_handika extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_permintaan_karyawan_handika', 'model');
        $this->load->model('recruitment/Model_job_post_handika', 'model_job_post');
        $this->load->model("model_profile");
        $this->load->helper('string');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle']        = "Permintaan Karyawan";
        $data['css']              = "recruitment/permintaan_karyawan_handika/css";
        $data['js']               = "recruitment/permintaan_karyawan_handika/js";
        $data['content']          = "recruitment/permintaan_karyawan_handika/index";
        $data['department']     = $this->model->department_loker()->result();
        $data['posisi']         = $this->model->get_posisi1()->result();
        $data['contract']       = $this->model->get_contract();
        $data['education']      = $this->model->get_education()->result();
        $data['status_job']     = $this->model->get_status_job()->result();
        $data['all_employee']   = $this->model->get_all_employees();
        $this->load->view('layout/main', $data);
    }
    public function list_permintaan()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $status = $_POST['status'];
        $session = $this->session->userdata('username');
        $user_id = $this->session->userdata('user_id');
        $user_info = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $user_id")->row_array();
        if (in_array($user_info['user_role_id'], array(1, 11, 12))) {
            if ($user_id == 2188) {
                $applicants = $this->model->list_permintaan($start, $end, $status, $user_id);
            } else {
                $applicants = $this->model->list_permintaan($start, $end, $status);
            }
        } else {
            $applicants = $this->model->list_permintaan($start, $end, $status, $user_id);
        }
        $data['data'] = $applicants;
        echo json_encode($data);
    }
    function detail_permintaan()
    {
        $id = $_POST['id'];
        $data['permintaan'] = $this->model->detail_permintaan($id);
        echo json_encode($data);
    }
    function get_perusahaan()
    {
        $data['perusahaan'] = $this->model->get_perusahaan();
        echo json_encode($data);
    }
    function get_department()
    {
        $id = $_POST['id'];
        $data['department'] = $this->model->get_department($id);
        echo json_encode($data);
    }
    function get_posisi()
    {
        $id_perusahaan = $_POST['id_perusahaan'];
        $id_department = $_POST['id_department'];
        $data['posisi'] = $this->model->get_posisi2($id_perusahaan, $id_department);
        echo json_encode($data);
    }
    function get_location()
    {
        $id = $_POST['id_perusahaan'];
        $data['location'] = $this->model->get_location($id);
        echo json_encode($data);
    }
    function get_kel_posisi()
    {
        $data['posisi'] = $this->model->get_posisi3();
        echo json_encode($data);
    }
    function get_status_karyawan()
    {
        $data['status_karyawan'] = $this->model->get_status_karyawan();
        echo json_encode($data);
    }
    function get_tipe_kontrak()
    {
        $data['tipe_kontrak'] = $this->model->get_tipe_kontrak();
        echo json_encode($data);
    }
    function get_pengganti()
    {
        $id = $_POST['id'];
        if (isset($_POST['nama'])) {
            $nama = $_POST['nama'];
        } else {
            $nama = '';
        }

        $data['pengganti'] = $this->model->get_pengganti($id, $nama);
        echo json_encode($data);
    }
    function get_dt_posisi()
    {
        $department = $_POST['department'];
        $posisi = explode('|', $_POST['posisi']);
        $job_profil = $this->model->get_job_profil($department, $posisi[0])->row_array();
        $isset_jp = $this->model->get_job_profil($department, $posisi[0])->num_rows();
        if ($isset_jp > 0) {
            $job_task = $this->model->get_job_task($job_profil['no_jp'])->row_array();
            $job_kpi = $this->model->get_job_kpi($job_profil['no_jp'])->row_array();
            $job_kpi = $job_kpi['job_kpi'];
            $data['bawahan'] = $job_profil['bawahan'];
            $data['role_id'] = $job_profil['role_id'];
            // Job Desc
            $data['job_desc'] = $this->html_job_desc($job_task['job_desc']);
            // Job Kompetensi
            $data['kompetensi'] = $this->html_kompetensi($job_profil['kompetensi']);
            // KPI
            $data['job_kpi'] = $this->html_kpi($job_kpi);
        } else {
            $data['job_desc'] = '';
            $data['kompetensi'] = '';
            $data['job_kpi'] = '';
        }
        echo json_encode($data);
    }
    function add_permintaan()
    {
        $posisi = explode('|', $_POST['posisi']);

        $created_at_now = date('Y-m-d H:i:s');
        $permintaan = [
            "employer_id" => substr($_POST['perusahaan'], 0, 1),
            "department_id" => $_POST['department'],
            "job_title" => $posisi[1],
            "designation_id" => $posisi[0],
            "job_vacancy" => $_POST['jumlah'],
            "location_id" => $_POST['location'],
            "position_id" => $_POST['kel_posisi'],
            "job_type" => $_POST['status_karyawan'],
            "type_contract" => $_POST['tipe_kontrak'],
            "gender" => $_POST['gender'],
            "perencanaan" => $_POST['perencanaan'],
            "dasar" => $_POST['permohonan'],
            "salary" => $_POST['salary'],
            "latar_kebutuhan" => $_POST['latar_belakang'],
            "long_description" => $_POST['job_desc'],
            "kpi" => $_POST['kpi'],
            "bawahan_langsung" => $_POST['bawahan_lgsg'],
            "pendidikan" => $_POST['pendidikan'],
            "financial" => $_POST['financial'],
            "bawahan_tidak" => $_POST['bawahan_tidak_lgsg'],
            "minimum_experience" => $_POST['pengalaman'],
            "kemampuan" => $_POST['kemampuan'],
            "komp_kunci" => $_POST['key_kompetensi'],
            "komp_pemimpin" => $_POST['leader_komp'],
            'created_at'            => $created_at_now,
            'created_by'            => $this->session->userdata('user_id')
        ];
        if (isset($_POST['pengganti_hidden']) && $_POST['pengganti_hidden'] !== 'none') {
            $permintaan += [
                "pengganti" => $_POST['pengganti_hidden']
            ];
        };

        $design_id = $posisi[0];
        $department_id = $_POST['department'];
        $dataDesignation = $this->db->query("SELECT * FROM xin_designations WHERE designation_id = '$design_id'")->row();
        $dataDepartment = $this->db->query("SELECT * FROM xin_departments WHERE department_id = '$department_id'")->row();
        if (!is_null($dataDesignation->standar_mpp)) {
            $standar_mpp = $dataDesignation->standar_mpp;
            $karyawan_aktif = $this->model->designation_count_active($design_id)->total_active;
            $total_vacancy_fpk_baru = $this->model->job_count_active($design_id)->total_vacancy ?? 0;
            $job_vacancy = $_POST['jumlah'];

            $hitung_vacancy = $karyawan_aktif + $total_vacancy_fpk_baru + $job_vacancy;
            // echo "Job Vacancy : $job_vacancy, MPP : $standar_mpp, Karyawan aktif : $karyawan_aktif, Total vacancy loker yang masih aktif : $total_vacancy_fpk_baru,  Hitung Vacancy : $hitung_vacancy";

            if ($hitung_vacancy <= $standar_mpp) {
                $permintaan += [
                    'status' => 4,
                    'verified_at' => $created_at_now,
                    'verified_by' => $dataDepartment->head_id,
                    'approved_by' => 8663,
                    'approved_at' => $created_at_now
                ];
                
                $this->db->trans_start();
                try {
                    $data['insert'] = $this->db->insert('trusmi_jobs_request', $permintaan);
                    if ($data['insert']) {
                        $job_title = $posisi[1];
                        $user_id = $this->session->userdata('user_id');
                        $created_at = $permintaan['created_at'];
                        $fpk = $this->db->query("SELECT * FROM trusmi_jobs_request WHERE job_title = '$job_title' AND created_by = $user_id AND created_at = '$created_at'")->row_array();
                        
                        
                        $company_id = $permintaan['employer_id'];
                        $jurl = random_string('alnum', 40);
                        $total_job = $this->model->job_count_active($design_id)->total_job ?? '0';
                        if ($total_job == '0') {
                            $status_publish = 1;
                        } else {
                            $status_publish = 2;
                        }
                        $position = $permintaan['position_id'];
                        $dataUserRole = $this->db->query("SELECT * FROM xin_user_roles WHERE role_id = '$position'")->row();
                        $timestamp = strtotime($created_at_now);
                        $target_day = @$dataUserRole->target ?? 0;
                        $date_of_closing = date('Y-m-d', strtotime('+'.$target_day.' day', $timestamp));

                        if ($company_id == 1 && $department_id == 68) {
                            $category = 1;
                            $pic = 4367;
                            // $pic = 64;
                        } else if ($company_id == 1 && $department_id == 1) {
                            $category = 2;
                            $pic = 4367;
                            // $pic = 64;
                        } else if ($company_id == 2 && $department_id == 120) {
                            $category = 3;
                            $pic = 8482;
                            // $pic = 64;
                        } else if ($company_id == 2 && $department_id == 106) {
                            $category = 6;
                            $pic = 4367;
                            // $pic = 64;
                        } else {
                            $category = 4;
                            $pic = 2535;
                            // $pic = 64;
                        }

                        $latest_job_id = @$this->model->job_count_active($design_id)->id ?? null;
                        if (!is_null($latest_job_id)) {
                            $latest_job = $this->db->query("SELECT * FROM xin_jobs WHERE job_id = '$latest_job_id'")->row_array();
                            if (@$latest_job) {
                                $pic = @$latest_job['pic'] ?? $pic;
                            }
                        }
                        
                        // Insert or update xin_jobs
                        $jobs = array(
                            'job_title' => $permintaan['job_title'],
                            'designation_id' => $design_id,
                            'employer_id' => $company_id,
                            'location_id' => $permintaan['location_id'],
                            'job_type' => $permintaan['job_type'],
                            'category_id' => @$category,
                            'position_id' => $permintaan['position_id'],
                            'job_url' => $jurl,
                            // 'short_description' => $qt_short_description,
                            'long_description' => $permintaan['long_description'],
                            'status' => $status_publish ?? null, // status_publish
                            'job_vacancy' => $job_vacancy,
                            'date_of_closing' => $date_of_closing,
                            'gender' => $permintaan['gender'],
                            'minimum_experience' => $permintaan['minimum_experience'],
                            'reff_job_id' => $fpk['job_id'],
                            'pic' => $pic,
                            'created_at' => $created_at_now,
                        );

                        $this->db->insert('xin_jobs', $jobs);

                        $this->db->where('job_id', $fpk['job_id']);
                        $this->db->update('trusmi_jobs_request', array(
                            'pic' => $pic
                        ));
                        $this->db->trans_complete();

                        if ($this->db->trans_status() === FALSE) {
                            # Something went wrong.
                            $this->db->trans_rollback();
                        } 
                        else {
                            # Everything is Perfect. 
                            # Committing data to the database.
                            $this->db->trans_commit();
                            $data['send_wa'] = $this->send_wa_fpk_approved($fpk['job_id']);
                        }
                    } else {
                        $data['error'] = 'Gagal menginput data.';
                    }
                } catch (\Throwable $th) {
                    $this->db->trans_rollback();
                    $data['error'] = 'Gagal menginput data.';
                }
                
            } else {
                $permintaan += [
                    'status' => 1
                ];
                $data['insert'] = $this->db->insert('trusmi_jobs_request', $permintaan);
                if ($data['insert']) {
                    $job_title = $posisi[1];
                    $user_id = $this->session->userdata('user_id');
                    $created_at = $permintaan['created_at'];
                    if (substr($_POST['perusahaan'], 0, 1) == 1 || substr($_POST['perusahaan'], 0, 1) == 3) {
                        $fpk = $this->db->query("SELECT * FROM trusmi_jobs_request WHERE job_title = '$job_title' AND created_by = $user_id AND created_at = '$created_at'")->row_array();
                        // $data['api_wa'] = 
                        $this->send_wa_fpk($fpk['job_id']);
                    }
                } else {
                    $data['error'] = 'Gagal menginput data.';
                }
            }
        } else {
            $permintaan += [
                'status' => 1
            ];
            $data['insert'] = $this->db->insert('trusmi_jobs_request', $permintaan);
            if ($data['insert']) {
                $job_title = $posisi[1];
                $user_id = $this->session->userdata('user_id');
                $created_at = $permintaan['created_at'];
                if (substr($_POST['perusahaan'], 0, 1) == 1 || substr($_POST['perusahaan'], 0, 1) == 3) {
                    $fpk = $this->db->query("SELECT * FROM trusmi_jobs_request WHERE job_title = '$job_title' AND created_by = $user_id AND created_at = '$created_at'")->row_array();
                    // $data['api_wa'] = 
                    $this->send_wa_fpk($fpk['job_id']);
                }
            } else {
                $data['error'] = 'Gagal menginput data.';
            }
        }

        echo json_encode($data);
    }
    public function send_wa_fpk($job_id)
    {
        $kontak[] = '628996999783'; // Ali95
        // $kontak[] = '6285727312007'; // nahdliyatul521 sudah resign
        $kontak[] = '628157720291'; // nani1283
        // // $kontak[] = '6285860428016';
        $fpk        = $this->model->detail_send_fpk($job_id);

        $str = $fpk['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 
*There is New Request FPK*

🏣Company : " . $fpk['company'] . "
🗃️Department : " . $fpk['department'] . "
📍Position : *" . $fpk['position'] . "*
🎚️Level : " . $fpk['level'] . "
📝Need : " . $fpk['need'] . "
🔒Status : " . $fpk['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

👤Requested By : " . $fpk['created'] . "
🕐Requested At : " . $fpk['created_at'] . "",
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
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);
        }
        // return $result_text;
    }

    public function send_wa_fpk_approved($job_id)
    {
        // $kontak[] = '628996999783';
        // $kontak[] = '6285727312007';
        // $kontak[] = '6285860428016';

        $fpk        = $this->model_job_post->get_send_fpk_approved($job_id);
        $kontak[]     = '628';

        // Jika bukan IT maka send ke PIC
        if ($_SESSION['user_id'] == 1) {

            $kontak[]    = '6282316041423'; //ari

            // $kontak[]    = '6285860428016'; //lutfie
            $kontak[]    = '6281321464138'; //handika

        } else {

            $kontak[]    = $fpk['req_contact'];
            $kontak[]    = '62895360604421'; //constantin wirasandi
            $kontak[]    = '6281120012145'; //comben

        }

        $str = $fpk['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 
*Your FPK Has Been Approved*

🏣Company : " . $fpk['company'] . "
🗃️Department : " . $fpk['department'] . "
📍Position : *" . $fpk['position'] . "*
🏆Level : " . $fpk['level'] . "
📝Need : " . $fpk['need'] . "
🔒Status : " . $fpk['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

👤Approved By : " . $fpk['approved_by'] . "
👤Person in Charge By : " . $fpk['pic_by'] . "
👤Requested By : " . $fpk['requested_by'] . "
🕐Requested At : " . $fpk['requested_at'] . "
🕐Deadline : " . $fpk['deadline'] . "",
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
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);
        }

        return $result_text;
    }

    function edit_permintaan()
    {
        $id = $_POST['id'];
        $data['permintaan'] = $this->model->edit_permintaan($id);
        $data['permintaan']['gender'] = (int)$data['permintaan']['gender'];
        $data['perusahaan'] = $this->model->get_perusahaan();
        $data['status_approve'] = $this->model->get_status_job()->result();
        $data['job_desc'] = $this->html_job_desc($data['permintaan']['long_description']);
        $data['kpi'] = $this->html_kpi($data['permintaan']['kpi']);
        $data['kompetensi'] = $this->html_kompetensi($data['permintaan']['komp_pemimpin']);
        echo json_encode($data);
    }
    function save_edit_permintaan()
    {
        $posisi = explode('|', $_POST['posisi']);
        $permintaan = [
            "employer_id" => substr($_POST['perusahaan'], 0, 1),
            "department_id" => $_POST['department'],
            "job_title" => $posisi[1],
            "designation_id" => $posisi[0],
            "job_vacancy" => $_POST['jumlah'],
            "location_id" => $_POST['location'],
            "position_id" => $_POST['kel_posisi'],
            "job_type" => $_POST['status_karyawan'],
            "type_contract" => $_POST['tipe_kontrak'],
            "gender" => $_POST['gender'],
            "perencanaan" => $_POST['perencanaan'],
            "dasar" => $_POST['permohonan'],
            "salary" => $_POST['salary'],
            "latar_kebutuhan" => $_POST['latar_belakang'],
            "long_description" => $_POST['job_desc'],
            "kpi" => $_POST['kpi'],
            "bawahan_langsung" => $_POST['bawahan_lgsg'],
            "pendidikan" => $_POST['pendidikan'],
            "financial" => $_POST['financial'],
            "bawahan_tidak" => $_POST['bawahan_tidak_lgsg'],
            "minimum_experience" => $_POST['pengalaman'],
            "kemampuan" => $_POST['kemampuan'],
            "komp_kunci" => $_POST['key_kompetensi'],
            "komp_pemimpin" => $_POST['leader_komp'],
            'status'                => $_POST['status_approve']
        ];
        if ($_POST['status_approve'] !== "1") {
            $permintaan += [
                'verified_at'            => date('Y-m-d H:i:s'),
                'verified_by'            => $this->session->userdata('user_id')
            ];
        }
        if (isset($_POST['pengganti_hidden']) && $_POST['pengganti_hidden'] !== 'none') {
            $permintaan += [
                "pengganti" => $_POST['pengganti_hidden']
            ];
        } else {
            $permintaan += [
                "pengganti" => ''
            ];
        };
        $this->db->where('job_id', $_POST['job_id']);
        $data['update_pk'] = $this->db->update('trusmi_jobs_request', $permintaan);
        // Send WA First Level Rejected
        $data['api_wa']   = ($_POST['status_approve'] == 3) ? $this->send_wa_fpk_rejected_level_1($_POST['job_id']) : "Approved First Level Not Send WA";

        if ($data['update_pk'] == true) {
            $data['result'] = "Job Verified.";
        } else {
            $data['error'] = "Gagal memperbaharui permintaan karyawan";
        }
        echo json_encode($data);
    }
    function send_wa_fpk_rejected_level_1($job_id)
    {
        $fpk        = $this->model->get_send_fpk_rejected_level_1($job_id);
        $kontak[]     = '628993036965';
        // $kontak[]     = '6285640279721';

        // Jika bukan IT maka send ke PIC
        $session = $this->session->userdata('user_id');
        if ($session !== 1) {
            $kontak[]    = $fpk['verified_contact'];
            $kontak[]    = $fpk['req_contact'];
            // $kontak[]	= '62895360604421';//constantin wirasandi
            $kontak[]     = '628993036965'; // Faisal IT
        }
        $str = $fpk['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2225082380",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 
*Your FPK Has Been Rejected on First Level*

🏣Company : " . $fpk['company'] . "
🗃️Department : " . $fpk['department'] . "
📍Position : *" . $fpk['position'] . "*
🏆Level : " . $fpk['level'] . "
📝Need : " . $fpk['need'] . "
🔒Status : " . $fpk['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

👤Rejected By : " . $fpk['verified_by'] . "
👤Requested By : " . $fpk['requested_by'] . "
🕐Requested At : " . $fpk['requested_at'] . "

_Silahkan hubungi PIC Recruitment terkait_.",
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
            $result_text['wa_api']    = file_get_contents($url, false, $context_text);
        }
        return $result_text;
    }
    function get_data_pengganti()
    {
        $nama = $_POST['nama'];
        $data['pengganti'] = $this->model->get_data_pengganti($nama);
        echo json_encode($data);
    }

    function html_job_desc($jobdesc)
    {
        $job_desc = htmlspecialchars_decode(strip_tags($jobdesc, '<ul><li>'));
        $job_desc = str_replace(['<ul>', '</ul>'], '', $job_desc);
        $job_desc = str_replace(['<li>', '</li>'], ["\n• ", ''], $job_desc);
        $job_desc = trim($job_desc);
        return $job_desc;
    }
    function html_kpi($kpi)
    {
        $job_kpi = htmlspecialchars_decode(strip_tags($kpi, '<ul><li>'));
        $job_kpi = str_replace(['<ul>', '</ul>'], '', $job_kpi);
        $job_kpi = str_replace(['<li>', '</li>'], ["\n• ", ''], $job_kpi);
        $job_kpi = trim($job_kpi);
        return $job_kpi;
    }
    function html_kompetensi($komp)
    {
        $job_kompetensi = htmlspecialchars_decode($komp);
        $job_kompetensi = str_replace(['<li>', '</li>', '<p>', '</p>'], ["\n", '', "\n", ''], $job_kompetensi);
        $job_kompetensi = str_replace('&nbsp;', ' ', $job_kompetensi);
        $job_kompetensi = strip_tags($job_kompetensi);
        $job_kompetensi = trim($job_kompetensi);
        $job_kompetensi = preg_replace('/\s*\n\s*/', "\n", $job_kompetensi);
        $job_kompetensi = preg_replace("/\n+/", "\n", $job_kompetensi);
        return $job_kompetensi;
    }
    function add_jabatan()
    {
        $data['jabatan'] = array(
            'company'       => $_POST['perusahaan'],
            'department'    => $_POST['department'],
            'nama_dokumen'  => ucwords($_POST['jabatan']),
            'jenis_doc'     => 'Job Profile',
            'created_at'    => date('Y-m-d H:i:s'),
            'created_by'    => $this->session->userdata('user_id')
        );

        $data['insert'] = $this->db->insert('trusmi_sop', $data['jabatan']);
        $this->send_wa_job_profile($_POST['jabatan'], $_POST['department'], $this->session->userdata('user_id'));
        echo json_encode($data);
    }

    function send_wa_job_profile($jabatan, $divisi, $user)
    {
        $data = $this->model->job_profile($jabatan, $divisi, $user)->row_array();

        $jabatan        = $data['jabatan'];
        $divisi         = $data['divisi'];
        $company_id     = $data['company_id'];
        $perusahaan     = $data['perusahaan'];
        $user           = $data['user'];

        if ($company_id == 2) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text1 = array(
                "channelID" => "2225082380",
                "phone" => "6289656108701",
                "messageType" => "text",
                "body" => "👤Alert!!! 
*There is New Request Job Profile Jabatan Baru*

📍Jabatan :" . $jabatan . "
🗃️Divisi :" . $divisi . "
🏣Perusahaan :" . $perusahaan . "
👤User :" . $user . "",
                "withCase" => true
            );

            $options_text1 = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text1),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text1   = stream_context_create($options_text1);
            $result_text['wa_sandi']    = file_get_contents($url, false, $context_text1);
        } else if (in_array($company_id, [4, 5])) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";
            $data_text2 = array(
                "channelID" => "2225082380",
                "phone" => "6281223553352",
                "messageType" => "text",
                "body" => "Pengajuan Pembuatan Job Profile Jabatan Baru
            Jabatan     : $jabatan
            Disivi      : $divisi
            Perusahaan  : $perusahaan
            User        : $user",
                "withCase" => true
            );
            $options_text2 = array(
                'http' => array(
                    "method"  => 'POST',
                    "content" => json_encode($data_text2),
                    "header" =>  "Content-Type: application/json\r\n" .
                        "Accept: application/json\r\n" .
                        "API-Key: 40191091f286e1a4269fa1e49b32b6546f30e4f6497a9e478daa8cf743e2ccf1"
                )
            );

            $context_text2   = stream_context_create($options_text2);
            $result_text['wa_rindi']    = file_get_contents($url, false, $context_text2);
        }
    }
    function get_user_role()
    {
        $id = $this->session->userdata('user_id');
        $user_info = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $id")->row_array();
        $data['edit'] = false;
        if (in_array($user_info['user_role_id'], array(1, 2, 3, 10, 11, 12))) {
            $data['edit'] = true;
        }
        echo json_encode($data);
    }
}
