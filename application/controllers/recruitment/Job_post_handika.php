<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_post_handika extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_job_post', 'model');
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
        $data['pageTitle']        = "Job Post";
        $data['css']              = "recruitment/job_post/css";
        $data['js']               = "recruitment/job_post/js";
        $data['content']          = "recruitment/job_post/index";
        $data['department']     = $this->model->department_loker()->result();
        $data['posisi']         = $this->model->get_posisi1()->result();
        $data['contract']       = $this->model->get_contract();
        $data['education']      = $this->model->get_education()->result();
        $data['status_job']     = $this->model->get_status_job()->result();
        $data['all_employee']   = $this->model->get_all_employees();
        $this->load->view('layout/main', $data);
    }

    public function dt_job_post()
    {
        $start = $_POST['start'];
        $end = $_POST['end'];
        $data['data'] = $this->model->dt_job_post($start, $end);
        echo json_encode($data);
    }
    public function dt_list_permintaan()
    {
        if (isset($_POST['job_id'])) {
            $job_id = $_POST['job_id'];
            $start = null;
            $end = null;
        } else {
            $job_id = null;
            $start = $_POST['start'];
            $end = $_POST['end'];
        }

        $data['data'] = $this->model->dt_list_permintaan($job_id, $start, $end);
        echo json_encode($data);
    }

    function detail_permintaan()
    {
        $job_id = $_POST['job_id'];
        $data['permintaan'] = $this->model->detail_permintaan($job_id);
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
    function get_jabatan()
    {
        $id_perusahaan = $_POST['id_perusahaan'];
        $id_department = $_POST['id_department'];
        $data['posisi'] = $this->model->get_jabatan($id_perusahaan, $id_department);
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
        $data['posisi'] = $this->model->get_kel_posisi();
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
        $data['pengganti'] = $this->model->get_pengganti($id);
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

    function get_pic_recruiter()
    {
        $data = $this->model->get_pic_recruiter()->result();
        echo json_encode($data);
    }

    function get_category()
    {
        $data = $this->model->get_category()->result();
        echo json_encode($data);
    }

    function save_job_post()
    {

        $this->db->trans_start();

        try {


            $job_id = $_POST['job_id'];
            $job_title = $_POST['job_title'];
            $posisi = explode('|', $_POST['jabatan']);
            $designation_id = $posisi[0];
            $employer_id = substr($_POST['perusahaan'], 0, 1);
            $location_id = $_POST['location'];
            $job_type = $_POST['status_karyawan'];
            $position_id = $_POST['kel_posisi'];
            $job_desc = $_POST['job_desc'];
            $job_vacancy = $_POST['jumlah'];
            $gender = $_POST['gender'];
            $minimum_experience = $_POST['pengalaman'];
            $jurl = random_string('alnum', 40);
            if (isset($_POST['status'])) {
                $status_publish = $_POST['status'];
            } else {
                $status_publish = 2;
            }
            if (isset($_POST['pic_recruiter'])) {
                $pic_recruiter = $_POST['pic_recruiter'];
            } else {
                $pic_recruiter = 0;
            }



            // UPDATE job_request
            $permintaan = [
                "employer_id" => $employer_id,
                "department_id" => $_POST['department'],
                "job_title" => $job_title,
                "designation_id" => $designation_id,
                "job_vacancy" => $job_vacancy,
                "location_id" => $location_id,
                "position_id" => $position_id,
                "job_type" => $job_type,
                "type_contract" => $_POST['tipe_kontrak'],
                "gender" => $gender,
                "perencanaan" => $_POST['perencanaan'],
                "dasar" => $_POST['permohonan'],
                "salary" => $_POST['salary'],
                "latar_kebutuhan" => $_POST['latar_belakang'],
                "long_description" => $job_desc,
                "kpi" => $_POST['kpi'],
                "bawahan_langsung" => $_POST['bawahan_lgsg'],
                "pendidikan" => $_POST['pendidikan'],
                "financial" => $_POST['financial'],
                "bawahan_tidak" => $_POST['bawahan_tidak_lgsg'],
                "minimum_experience" => $minimum_experience,
                "kemampuan" => $_POST['kemampuan'],
                "komp_kunci" => $_POST['key_kompetensi'],
                "komp_pemimpin" => $_POST['leader_komp'],
                'status' => $_POST['status_approval'],
                'alasan_reject' => $_POST['reason'] ?? null,
                'pic' => $pic_recruiter,
                'approved_by' => $_SESSION['user_id'],
                'approved_at' => date('Y-m-d H:i:s')
            ];

            if (isset($_POST['pengganti_hidden']) && $_POST['pengganti_hidden'] !== 'none') {
                $permintaan += [
                    "pengganti" => $_POST['pengganti_hidden']
                ];
            } else {
                $permintaan += [
                    "pengganti" => ''
                ];
            };


            $cek_job = $this->model->cek_job($designation_id, $position_id, $location_id)->num_rows();

            if (isset($_POST['edit'])) {

                $this->db->where('job_id', $job_id);
                $data['update_jobs_request'] = $this->db->update('trusmi_jobs_request', $permintaan);
            } else {

                if ($status_publish == 1 && $cek_job > 0) {
                    $data['update_jobs_request'] = false;
                    $data['reason'] = "Maaf, lowongan yang anda input masih tersedia. Silahkan inputkan lowongan yang lain.";
                } else {
                    $this->db->where('job_id', $job_id);
                    $data['update_jobs_request'] = $this->db->update('trusmi_jobs_request', $permintaan);
                }
            }

            // END UPDATE job_request


            // Insert or update xin_jobs
            $jobs = array(
                'job_title' => $job_title,
                'designation_id' => $designation_id,
                'employer_id' => $employer_id,
                'location_id' => $location_id,
                'job_type' => $job_type,
                'category_id' => $_POST['category'],
                'position_id' => $position_id,
                'job_url' => $jurl,
                // 'short_description' => $qt_short_description,
                'long_description' => $job_desc,
                'status' => $status_publish ?? null, // status_publish
                // 'is_featured' => $this->input->post('is_featured'),
                'job_vacancy' => $job_vacancy,
                'date_of_closing' => $_POST['closing_date'],
                'gender' => $gender,
                'minimum_experience' => $minimum_experience,
                'reff_job_id' => $job_id,
                'pic' => $pic_recruiter,
            );

            if (isset($_POST['edit'])) {


                $this->db->where('reff_job_id', $job_id);
                $data['insert_xin_jobs'] = $this->db->update('xin_jobs', $jobs);
            } else {



                if ($status_publish == 1 && $cek_job > 0) { // sudah ada job post

                    $data['insert_xin_jobs'] = false;
                    $data['reason'] = "Maaf, lowongan yang anda input masih tersedia. Silahkan inputkan lowongan yang lain.";
                } else {  // belum ada job post

                    // append created_at tp $jobs
                    $jobs['created_at'] = date('Y-m-d H:i:s');
                    $data['insert_xin_jobs'] = $this->db->insert('xin_jobs', $jobs);
                }
            }
            // END Insert xin_jobs


            if ($cek_job == 0) {
                // Send WA
                if ($_POST['pic_recruiter_contact'] == '' || $_POST['pic_recruiter_contact'] == null) {
                    $pic_recruiter_contact = '';
                } else {
                    $pic_recruiter_contact = $_POST['pic_recruiter_contact'];
                }
                if ($_POST['status_approval'] == '4') {
                    $data['send_fpk'] = $this->send_wa_fpk_approved($job_id, $pic_recruiter_contact);
                } else if ($_POST['status_approval'] == '5') {
                    $data['send_fpk'] = $this->send_wa_fpk_rejected($job_id, $pic_recruiter_contact);
                }
            }


            $this->db->trans_commit();
        } catch (Exception $e) {

            $data['update_jobs_request'] = false;
            $data['insert_xin_jobs'] = false;

            $this->db->trans_rollback();
        }


        if ($data['update_jobs_request'] == true && $data['insert_xin_jobs'] == true) {
            $data['result'] = "Job Verified.";
            $data['save_job_post'] = true;
        } else {
            $data['error'] = "Gagal memperbaharui permintaan karyawan";
            $data['save_job_post'] = false;
        }
        echo json_encode($data);
    }

    function delete_job()
    {
        $job_id = $_POST['job_id'];
        $this->db->where('job_id', $job_id);
        $data['delete_job'] = $this->db->delete('xin_jobs');
        echo json_encode($data);
    }


    public function send_wa_fpk_approved($job_id, $pic_recruiter_contact)
    {
        // $kontak[] = '628996999783';
        // $kontak[] = '6285727312007';
        // $kontak[] = '6285860428016';

        $fpk        = $this->model->get_send_fpk_approved($job_id);
        $kontak[]     = '628';

        // Jika bukan IT maka send ke PIC
        if ($_SESSION['user_id'] == 1) {

            $kontak[]    = '6282316041423'; //ari

        } else {

            $kontak[]    = $pic_recruiter_contact;
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
                "channelID" => "2507194023",
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



    public function send_wa_fpk_rejected($job_id, $pic_recruiter_contact)
    {
        // $kontak[] = '628996999783';
        // $kontak[] = '6285727312007';
        // $kontak[] = '6285860428016';

        $fpk        = $this->model->get_send_fpk_approved($job_id);
        $kontak[]     = '628993036965';

        // Jika bukan IT maka send ke PIC
        if ($_SESSION['user_id'] != 1) {
            $kontak[]    = $pic_recruiter_contact;
            $kontak[]    = $fpk['req_contact'];
            $kontak[]    = '62895360604421'; //constantin wirasandi
            $kontak[]    = '6281120012145'; //comben            
        } else {
            $kontak[]    = '6282316041423'; //ari
        }

        $str = $fpk['jobdesk'];
        $deskripsi = str_replace("&lt;ol&gt;", "&lt;ul&gt;", $str);
        $deskripsi = str_replace("&lt;/ol&gt;", "&lt;/ul&gt;", $deskripsi);

        foreach ($kontak as $key => $value) {
            $url = "https://onetalk-api.taptalk.io/api/integration/v1/inbox/send_message_whatsapp";

            $data_text = array(
                "channelID" => "2507194023",
                "phone" => $value,
                "messageType" => "text",
                "body" => "👤Alert!!! 
*Your FPK Has Been Rejected*

🏣Company : " . $fpk['company'] . "
🗃️Department : " . $fpk['department'] . "
📍Position : *" . $fpk['position'] . "*
🏆Level : " . $fpk['level'] . "
📝Need : " . $fpk['need'] . "
🔒Status : " . $fpk['status'] . "
📑Jobdesc : " . strip_tags(htmlspecialchars_decode($deskripsi)) . "

👤Rejected By : " . $fpk['approved_by'] . "
👤Requested By : " . $fpk['requested_by'] . "
🕐Requested At : " . $fpk['requested_at'] . "",
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





    // OLD    
    function add_permintaan()
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
            'created_at'            => date('Y-m-d H:i:s'),
            'created_by'            => $this->session->userdata('user_id'),
            'status'                => 1
        ];
        if (isset($_POST['pengganti_hidden']) && $_POST['pengganti_hidden'] !== 'none') {
            $permintaan += [
                "pengganti" => $_POST['pengganti_hidden']
            ];
        };
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
        echo json_encode($data);
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
                "channelID" => "2507194023",
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
        $data['api_wa'] = $this->send_wa_job_profile($_POST['jabatan'], $_POST['department'], $this->session->userdata('user_id'));
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
                "channelID" => "2507194023",
                // "phone" => "6289656108701",
                "phone" => "6285640279721",
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
                "channelID" => "2507194023",
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
        return $result_text;
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
