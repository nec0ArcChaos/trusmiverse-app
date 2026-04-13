<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fdk extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->model('Model_fdk', 'model_fdk');
        $this->load->model("model_profile");
        $this->load->library('FormatJson');
        $this->load->library('Vcard');
        $this->load->library('Filter');
        $this->load->library('Whatsapp_lib');
        $this->load->library('WAJS');
    }
    function index()
    {

        if ($this->session->userdata('user_id') != "") {
            $data['pageTitle'] = "Formulir Dokumen Karyawan";
            $data['css'] = "fdk/css";
            $data['js'] = "fdk/js";
            $data['content'] = "fdk/index";
            // $data['fdk']= $this->model_fdk->get_data();
            $this->load->view('layout/main', $data);
        } else {
            redirect('login', 'refresh');
        }
    }
    function get_data()
    {
        if ($_POST['start'] != null) { /*klo ada datanya*/
            $start = $_POST['start'];
            $end = $_POST['end'];
        } else {
            $start = date('Y-m-01');
            $end = date('Y-m-t');
        }
        $data['data'] = $this->model_fdk->get_data($start, $end);
        echo json_encode($data);
    }
    function karyawan()
    {
        $data = $this->model_fdk->get_karyawan();
        echo json_encode($data);
    }
    // function get_karyawan();
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
    public function hashUser($applicant_id)
    {
        $arr_applicant_id = str_split($applicant_id, 1);
        $hash = $this->generateRandomString();
        for ($i = 0; $i < COUNT($arr_applicant_id); $i++) {
            $hash .= $arr_applicant_id[$i];
            $hash .= $this->generateRandomString();
        }
        echo json_encode($hash);
    }
    public function send_to($id)
    {
        $data = $this->model_fdk->karyawan($id);
        $msg = "🔔Notifikasi Pengisian FDK
*Formulir Dokumen Karyawan*

Dear Bpk / Ibu : " . $data['full_name'] . "
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
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', $data['contact_no'], $msg);
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', $data['pic_contact_no'], $msg);
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', '081120012145', $msg); //comben
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', '083824955357', $msg); //comben
        $hasil = $this->send_wa_blast($data['contact_no'], $msg, $data['user_id']);
        $this->send_wa_blast($data['pic_contact_no'], $msg, $data['user_id_pic']);
        $this->send_wa_blast('081120012145', $msg, 78);
        // $this->send_wa('083824955357', $msg, 5203);
        echo json_encode($msg);
    }
    function konfirmasi($user_id)
    {
        if (isset($user_id)) {
            $data = $this->model_fdk->karyawan($user_id);

            $msg = "🔔 FDK Approved✅
Formulir Dokumen Karyawan

Dear Bpk / Ibu : " . $data['full_name'] . "
🏣Company : " . $data['company_name'] . "
📍Position : " . $data['designation_name'] . "

Kami ingin memberitahukan bahwa dokumen dokumen yang Anda unggah melalui Form Dokumen Karyawan telah *diverifikasi dan memenuhi standar dokumen yang ditentukan.*

Terima kasih atas perhatian dan kerjasamanya.";

            // $this->whatsapp_lib->send_single_msg('eaf', $data['contact_no'], $msg);
            // $this->whatsapp_lib->send_single_msg('eaf', $data['pic_contact_no'], $msg);
            // $this->whatsapp_lib->send_single_msg('eaf', '081120012145', $msg); //comben
            $this->send_wa_blast($data['contact_no'], $msg, $data['user_id']);
            $this->send_wa_blast($data['pic_contact_no'], $msg, $data['user_id_pic']);
            $this->send_wa_blast('081120012145', $msg, 78);
            $this->db->set('status', 3);
            $this->db->set('approved_at', date('Y-m-d H:i:s'));
            $this->db->where('employee_id', $user_id);
            $this->db->update('fdk');
            echo json_encode($msg);
        } else {
            $response = "Bad request";
            echo json_encode($response);
        }
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
    public function form($ciphertext = null)
    {
        $id = preg_replace('/[^0-9.]+/', '', $ciphertext);
        $data = [
            'karyawan' => $this->model_fdk->karyawan($id),
            'pageTitle' => "Formulir Dokumen Karyawan",
            'profile' => $this->model_fdk->profile_karir($id),
            // 'file'=> $this->model_fdk->get_required($application_id),
        ];
        if ($data['karyawan'] != NULL) {
            $this->load->view('fdk/form', $data);
        } else { // jika user tidak ada
            show_404();
        }
    }
    function insert_dokumen()
    {
        $employee_id = $this->input->post('user_id');
        $data = [
            'id' => '',
            'employee_id' => $employee_id,
            'ktp' => '',
            'kk' => '',
            'lamaran' => '',
            'cv' => '',
            'ijazah' => '',
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('fdk', $data);
        if ($this->cek_upload_null('ktp') == false) {
            $ktp = $this->upload_file('ktp', 'req');
            $this->model_fdk->update_one_file($employee_id, 'ktp', $ktp);
        }
        if ($this->cek_upload_null('kk') == false) {
            $kk = $this->upload_file('kk', 'req');
            $this->model_fdk->update_one_file($employee_id, 'kk', $kk);
        }
        if ($this->cek_upload_null('lamaran') == false) {
            $lamaran = $this->upload_file('lamaran', 'req');
            $this->model_fdk->update_one_file($employee_id, 'lamaran', $lamaran);
        }
        if ($this->cek_upload_null('cv') == false) {
            $cv = $this->upload_file('cv', 'req');
            $this->model_fdk->update_one_file($employee_id, 'cv', $cv);
        }
        if ($this->cek_upload_null('ijazah') == false) {
            $ijazah = $this->upload_file('ijazah', 'req');
            $this->model_fdk->update_one_file($employee_id, 'ijazah', $ijazah);
        }
        if ($this->cek_upload_null('transkip') == false) {
            $transkip = $this->upload_file('transkip', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'transkip', $transkip);
        }
        if ($this->cek_upload_null('npwp') == false) {
            $npwp = $this->upload_file('npwp', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'npwp', $npwp);
        }
        if ($this->cek_upload_null('surat_lulus') == false) {
            $surat_lulus = $this->upload_file('surat_lulus', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'surat_lulus', $surat_lulus);
        }
        if ($this->cek_upload_null('sertifikat') == false) {
            $sertifikat = $this->upload_file('sertifikat', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'sertifikat', $sertifikat);
        }
        if ($this->cek_upload_null('verklaring') == false) {
            $verklaring = $this->upload_file('verklaring', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'verklaring', $verklaring);
        }
        if ($this->cek_upload_null('dokumen_lain') == false) {
            $dokumen_lain = $this->upload_file('dokumen_lain', 'opt');
            $this->model_fdk->update_one_file($employee_id, 'dokumen_lain', $dokumen_lain);
        }
        $response['update'] = true;
        $response['user_id'] = $employee_id;
        echo json_encode($response);
    }
    function update_dokumen_wajib()
    {

        $user_id = $this->input->post('user_id');
        if ($this->cek_upload_null('ktp') == false && $this->cek_upload_null('kk') == false && $this->cek_upload_null('cv') == false && $this->cek_upload_null('lamaran') == false && $this->cek_upload_null('ijazah') == false) {
            $ktp = $this->upload_file('ktp', 'req');
            $kk = $this->upload_file('kk', 'req');
            $lamaran = $this->upload_file('lamaran', 'req');
            $cv = $this->upload_file('cv', 'req');
            $ijazah = $this->upload_file('ijazah', 'req');
            $status = 0;
            $data = [
                'id' => '',
                'employee_id' => $user_id,
                'ktp' => $ktp,
                'ktp_status' => $status,
                'kk' => $kk,
                'kk_status' => $status,
                'lamaran' => $lamaran,
                'lamaran_status' => $status,
                'cv' => $cv,
                'cv_status' => $status,
                'ijazah' => $ijazah,
                'ijazah_status' => $status,
                'contact' => (isset($_FILES['kontak'])) ? 1 : NULL,
                'status' => 2,
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $response['update'] = $this->model_fdk->update_dokumen_wajib($user_id, $data);
            $response['user_id'] = $user_id;
            // Handle VCF file upload and extraction here
            if (isset($_FILES['kontak']) && $_FILES['kontak']['error'] == 0) {
                $vcfFile = $_FILES['kontak']['tmp_name'];
                $vCard = new Vcard($vcfFile, false, ['Collapse' => false]);

                $phone_data = [];
                if (count($vCard) > 1) {
                    foreach ($vCard as $vCardPart) {
                        $phone_data[] = $this->processVCard($vCardPart); // Assume processVCard is defined
                    }
                } else {
                    $phone_data[] = $this->processVCard($vCard); // Assume processVCard is defined
                }
                echo json_encode($phone_data);
                $jsonFile = FCPATH . 'uploads/fdk/temp_phone.json';
                $jsonData = [];

                if (file_exists($jsonFile)) {
                    $jsonContent = file_get_contents($jsonFile);
                    $jsonData = json_decode($jsonContent, true); // Convert to associative array
                }
                foreach ($phone_data as $phone_entry) {
                    $jsonData[] = [
                        'user_id' => $user_id,
                        'name' => ($phone_entry['name'] == NULL) ? $phone_entry['first_name'] : $phone_entry['name'],
                        'phone' => $phone_entry['phone'],
                        'email' => (isset($phone_entry['email'])) ? $phone_entry['email'] : null,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }

                // Encode back to JSON and save to file
                file_put_contents($jsonFile, json_encode($jsonData, JSON_PRETTY_PRINT));
            }
            echo json_encode($response);
        }
        if ($this->cek_upload_null('ktp') == false) {
            $ktp = $this->upload_file('ktp', 'req');
            $hasil = $this->model_fdk->update_one_file($user_id, 'ktp', $ktp);
            echo json_encode($hasil);
        }
        if ($this->cek_upload_null('kk') == false) {
            $kk = $this->upload_file('kk', 'req');
            $hasil = $this->model_fdk->update_one_file($user_id, 'kk', $kk);
            echo json_encode($hasil);
        }
        if ($this->cek_upload_null('lamaran') == false) {
            $lamaran = $this->upload_file('lamaran', 'req');
            $hasil = $this->model_fdk->update_one_file($user_id, 'lamaran', $lamaran);
            echo json_encode($hasil);
        }
        if ($this->cek_upload_null('cv') == false) {
            $cv = $this->upload_file('cv', 'req');
            $hasil = $this->model_fdk->update_one_file($user_id, 'cv', $cv);
            echo json_encode($hasil);
        }
        if ($this->cek_upload_null('ijazah') == false) {
            $ijazah = $this->upload_file('ijazah', 'req');
            $hasil = $this->model_fdk->update_one_file($user_id, 'ijazah', $ijazah);
            echo json_encode($hasil);
        }
    }

    function update_dokumen_optional()
    {
        $user_id = $this->input->post('user_id');
        $status = $this->input->post('status');
        if ($this->cek_upload_null('transkip') == true && $this->cek_upload_null('npwp') == true && $this->cek_upload_null('surat_lulus') == true && $this->cek_upload_null('verklaring') == true && $this->cek_upload_null('sertifikat') == true && $this->cek_upload_null('dokumen_lain') == true) { // tidak ada yang di isi
            $data = [
                'status' => 2,
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            $response['update'] = $this->model_fdk->update_dokumen_optional($user_id, $data);
            echo json_encode($response);
        } else { // sudah submit revisi
            if ($this->cek_upload_null('transkip') == false) {
                $transkip = $this->upload_file('transkip', 'opt');
                $this->model_fdk->update_one_file($user_id, 'transkip', $transkip);
            }
            if ($this->cek_upload_null('npwp') == false) {
                $npwp = $this->upload_file('npwp', 'opt');
                $this->model_fdk->update_one_file($user_id, 'npwp', $npwp);
            }
            if ($this->cek_upload_null('surat_lulus') == false) {
                $surat_lulus = $this->upload_file('surat_lulus', 'opt');
                $this->model_fdk->update_one_file($user_id, 'surat_lulus', $surat_lulus);
            }
            if ($this->cek_upload_null('sertifikat') == false) {
                $sertifikat = $this->upload_file('sertifikat', 'opt');
                $this->model_fdk->update_one_file($user_id, 'sertifikat', $sertifikat);
            }
            if ($this->cek_upload_null('verklaring') == false) {
                $verklaring = $this->upload_file('verklaring', 'opt');
                $this->model_fdk->update_one_file($user_id, 'verklaring', $verklaring);
            }
            if ($this->cek_upload_null('dokumen_lain') == false) {
                $dokumen_lain = $this->upload_file('dokumen_lain', 'opt');
                $this->model_fdk->update_one_file($user_id, 'dokumen_lain', $dokumen_lain);
            }
            $data = [
                'status' => 1,
            ];
            $response['update'] = $this->model_fdk->update_dokumen_optional($user_id, $data);
            echo json_encode($response);
            $response['update'] = true;
            $response['user_id'] = $user_id;
            echo json_encode($response);
        }
    }
    function upload_file($input, $dir)
    {
        $config['upload_path'] = './uploads/fdk/' . $dir . '/';
        $config['allowed_types'] = '*';
        $config['max_size'] = 0;
        $config['file_name'] = time();

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($input)) {
            return NULL;
        } else {
            $files = $this->upload->data();

            // Check if file is an image
            if (strpos($files['file_type'], 'image') !== false) {
                if ($files['file_size'] > 2048) {
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = $files['full_path'];
                    $config['quality'] = '50%'; // Adjust the quality as needed

                    $this->load->library('image_lib', $config);
                    if (!$this->image_lib->resize()) {
                        echo $this->image_lib->display_errors();
                        return NULL;
                    }

                    $this->image_lib->clear();
                }
            }

            return $file_upload = $dir . '/' . $files['raw_name'] . $files['file_ext'];
        }
    }
    function submit_form()
    {
        $user_id = $this->input->post('user_id');
        $hasil = $this->model_fdk->submit_form($user_id);
        echo json_encode($hasil);
    }
    function done()
    {
        $response['data'] = 'sidik';
        echo json_encode($response);
    }
    function cek_upload_null($input)
    {
        if ($_FILES[$input]['size'] == 0) {
            return true;
        } else {
            return false;
        }
    }
    public function get_data_appl()
    {
        $data['data'] = $this->model_fdk->get_data_appl();
        echo json_encode($data);
    }
    public function update_dokumen()
    {
        $type = $this->input->post('type');
        $user_id = $this->input->post('user_id');
        $dokumen = $this->input->post('dokumen');
        $user = $this->session->userdata('user_id');
        if ($type == 1) { // approve
            $status = 2;
            $data = [
                $dokumen . '_status' => $status,
                $dokumen . '_approve_by' => $user,
                $dokumen . '_approve_at' => date('Y-m-d H:i:s'),
            ];
        } else { // reject
            $status = 1;
            $data = [
                $dokumen . '_status' => $status,
            ];
            $this->notif_reject($user_id, $dokumen);
        }
        $this->db->where('employee_id', $user_id);
        $hasil = $this->db->update('fdk', $data);
        // $cek = $this->model_fdk->cek_all_approve($user_id);
        // if($cek->status_dokumen = 'Approved'){
        //     $this->konfirmasi($user_id);
        //     $this->db->query("UPDATE SET status='3' FROM fdk WHERE employee_id='$user_id'");
        // }
        echo json_encode($hasil);
    }

    public function notif_reject($id, $dokumen)
    {

        $data = $this->model_fdk->karyawan($id);
        $msg = "🔔 Permintaan Pengisian Ulang FDK
*Formulir Dokumen Karyawan*

Dear Bpk / Ibu : " . $data['full_name'] . "
🏣Company : " . $data['company_name'] . "
📍Position : " . $data['designation_name'] . "

Dalam rangka memastikan bahwa semua data yang telah diinput pada Form Dokumen Karyawan telah terverifikasi dengan benar, kami memohon kesediaan Bapak/Ibu untuk mengisi ulang FDK untuk *dokumen " . $this->get_full_dokumen($dokumen) . "* di karenakan kurang memenuhi standar dokumen.

*Pastikan dokumen jelas (tidak blur), tidak terpotong, dan sesuai.*

Silakan mengunggah ulang dokumen tersebut melalui link berikut:
🔗 " . base_url('fdk/form/') . $this->hashApplicantId($data['user_id']) . "

Terima kasih atas perhatian dan kerjasamanya.
";
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', $data['contact_no'], $msg);
        // $hasil = $this->whatsapp_lib->send_single_msg('eaf', '081120012145', $msg); //comben
        $hasil = $this->send_wa($data['contact_no'], $msg, $data['user_id']);
        $this->send_wa('081120012145', $msg, 78);
        echo json_encode($msg);
    }
    function print_view($user_id)
    {
        $data = $this->model_fdk->get_print_view($user_id);
        // var_dump($data);die();
        $this->load->view('fdk/print_view', $data);
    }

    function get_full_dokumen($dokumen)
    {
        if ($dokumen == 'ktp') {
            $data = 'Kartu Tanda Penduduk (KTP)';
        } else if ($dokumen == 'kk') {
            $data = 'Kartu Keluarga (KK)';
        } else if ($dokumen == 'lamaran') {
            $data = 'Surat Lamaran';
        } else if ($dokumen == 'cv') {
            $data = 'CV (Curriculum Vitae)';
        } else if ($dokumen == 'ijazah') {
            $data = 'Ijazah';
        } else if ($dokumen == 'transkip') {
            $data = 'Transkip Nilai';
        } else if ($dokumen == 'npwp') {
            $data = 'Nomor Pokok Wajib Pajak';
        } else if ($dokumen == 'surat_lulus') {
            $data = 'Surat Kelulusan';
        } else if ($dokumen == 'verklaring') {
            $data = 'Surat Keterangan Bekerja (Paklaring)';
        } else if ($dokumen == 'seritifikat') {
            $data = 'Sertifikat';
        } else if ($dokumen == 'dokumen_lain') {
            $data = 'Dokumen Lain';
        }
        return $data;
    }
    function processVCard(Vcard $vCard)
    {
        $data = [];

        // Extract full name
        if (isset($vCard->FN[0])) {
            $data['name'] = $vCard->FN[0];
        }
        if (isset($vCard->N[0])) {
            $data['first_name'] = $vCard->N[0];
        }
        // Extract phone numbers
        if (isset($vCard->TEL[0])) {
            $data['phone'] = $vCard->TEL[0]['Value'];
        }
        if (isset($vCard->EMAIL[0])) {
            $data['phone'] = $vCard->EMAIL[0]['Value'];
        }


        return $data;
    }
    function get_contact()
    {
        $id = $this->input->post('id');
        $data['data'] = $this->model_fdk->get_contact($id);
        echo json_encode($data);
    }

    function cron_reminder()
    {
        $data = $this->model_fdk->get_view_fdk_notif();
        if (count($data) == 0) {
            return false;
        }
        foreach ($data as $fdk) {
            $msg = "🔔Mengingatkan Kembali anda belum menyelesaikan FDK
*Formulir Dokumen Karyawan*

Dear Bpk / Ibu : *" . $fdk->full_name . "*
🏣Company : " . $fdk->company_name . "
📍Position : " . $fdk->designation_name . "

Dalam upaya memverifikasi inputan pada Form Registrasi Calon Karyawan, kami mohon kesediaan Bapak/Ibu untuk mengisi formulir dokumen karyawan yang telah kami sediakan.

Dengan melampirkan beberpa dokumen seperti *KTP, KK, Lamaran, CV, Ijazah dan Dokumen lainnya* di link berikut : 
🔗 " . base_url('fdk/form/') . $this->hashApplicantId($fdk->user_id) . "

Ketentuan :
📄 Dokumen harus berbentuk *jpg atau png*
📷 Foto yang di lampirkan harus *jelas dan memenuhi standar*
⏳ *Leadtime pengisian FDK maksimal 3 hari* dari tanggal join atau hari pertama kerja, maksimal pengisian jam 17:00 
🔒 *Lock Absen berlaku* jika belum mengisi dan tidak memenuhi standar pada Dokumen Wajib dan *berpengaruh pada absensi* di hari Lock Absen

Terima kasih atas perhatian dan kerjasamanya.";
            // $hasil = $this->whatsapp_lib->send_single_msg('eaf', '083824955357', $msg);
            // $hasil = $this->whatsapp_lib->send_single_msg('eaf', $fdk->contact_no, $msg);
            // $hasil = $this->whatsapp_lib->send_single_msg('eaf', $fdk->pic_contact_no, $msg);
            // $hasil = $this->whatsapp_lib->send_single_msg('eaf', '081120012145', $msg); //comben
            $hasil = $this->send_wa_blast($fdk->contact_no, $msg, $fdk->user_id);
            $this->send_wa_blast($fdk->pic_contact_no, $msg, $fdk->user_id_pic);
            $this->send_wa_blast('081120012145', $msg, 78);
        }
        echo json_encode($hasil);
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
}
