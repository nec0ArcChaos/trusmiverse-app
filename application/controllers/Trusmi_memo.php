<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Trusmi_memo extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_trusmi_memo", 'model');


        // Bypass login check for print_ba with valid apikey
        $apikey = $this->input->get('apikey');
        if ($apikey && $this->uri->segment(2) === 'read') {
            $decoded = $this->decode_url_string($apikey);
            $parts = explode('|', $decoded);

            if (count($parts) === 2) {
                list($timestamp, $user_id) = $parts;
                // Check if the key is valid (not expired, e.g., 60 minutes)
                if (time() - $timestamp <= 3600) {
                    // Bypass authentication and set a temporary valid session variable for printing
                    $this->session->set_userdata("user_id", $user_id);
                    return; // Stop constructor here, allow method execution
                }
            }
        }

        if ($this->session->userdata('user_id') != "") {
        } else {
            $tgl = $this->uri->segment(3);
            $judul = $this->uri->segment(4);
            $url = $tgl . '/' . $judul;
            $link = array(
                'previus_link' => 'trusmi_memo/read/' . $url,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    private function decode_url_string($string)
    {
        $string = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($string) % 4;
        if ($mod4) {
            $string .= substr('====', $mod4);
        }
        return base64_decode($string);
    }


    public function index()
    {
        $data['pageTitle'] = "Trusmi Sistem Memo, SK, BA";
        $data['css'] = "trusmi_memo/css";
        $data['content'] = "trusmi_memo/index";
        $data['js'] = "trusmi_memo/js";
        // $data['employee'] = $this->model->get_employee();
        $data['master'] = $this->db->get('trusmi_m_memo')->result();
        $data['user_id'] = $this->session->userdata("user_id");
        $data['companies'] = $this->model->get_companies();
        $data['roles'] = $this->model->get_role();
        $data['is_admin'] = $this->model->access_admin();
        $this->load->view('layout/main', $data);

    }

    function dt_memo()
    {
        $id = $this->session->userdata("user_id");
        $start = @$_REQUEST['start'] ?? null;
        $end = @$_REQUEST['end'] ?? null;
        $status_memo = @$_REQUEST['status_memo'];
        $user = $this->db->query("SELECT * FROM xin_employees WHERE user_id = '$id'")->row_array();
        $data['data'] = $this->model->dt_memo($start, $end, $user['department_id'], $user['user_role_id'], $status_memo, $id);
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function data_memo()
    {
        $tipe = $this->input->post('tipe');
        $start = $this->input->post('start');
        $end = $this->input->post('end');
        if ($tipe == 0 || $tipe == 1 || $tipe == 2 || $tipe == 4) {
            $data = $this->model->data_memo($start, $end, $tipe);
        } else if ($tipe == 3) {//waiting approv
            $data = $this->model->data_approval($start, $end, $tipe);
        } else {
            // $data = $this->model->data_revisi($start, $end, $tipe);
        }
        echo json_encode($data);
    }
    function get_draf()
    {
        $id_memo = $this->input->post('id_memo');
        $data = $this->model->get_draf($id_memo);
        echo json_encode($data);
    }

    function get_companies()
    {
        $data['company'] = $this->model->get_companies();
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function get_department()
    {
        $company_id = $this->input->post('company_id');
        $data['department'] = $this->model->get_department($company_id);
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function get_employee()
    {
        $department_ids = $this->input->post('department_id');

        // Jika tidak ada data yang dikirim, kembalikan array JSON kosong.
        if (is_null($department_ids)) {
            echo json_encode([]);
            return;
        }
        if (!is_array($department_ids)) {
            $department_ids = explode(',', $department_ids);
        }
        $clean_ids = array_filter($department_ids);

        if (empty($clean_ids)) {
            echo json_encode([]);
            return;
        }
        $department_id_string = implode(',', $clean_ids);
        $data = $this->model->get_to_person($department_id_string);
        echo json_encode($data);
    }

    function get_role()
    {
        $data['role'] = $this->model->get_role();
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function get_approval()
    {
        $data = $this->model->get_approval();
        echo json_encode($data);
    }
    function get_all_pic()
    {
        $data = $this->model->get_all_pic();
        echo json_encode($data);
    }
    function get_admin_pic()
    {
        // if ($this->session->userdata('user_id') != 1) {
        //     echo json_encode([]);
        //     return;
        // }
        $data = $this->model->get_admin_pic();
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function get_employees_for_admin()
    {
        $data = $this->model->get_employees_for_admin();
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function update_admin_pic()
    {
        // if ($this->session->userdata('user_id') != 1) {
        //     echo json_encode(['status' => false, 'message' => 'Unauthorized']);
        //     return;
        // }
        $id       = $this->input->post('id');
        $username = $this->input->post('username');
        if (!$id || !$username) {
            echo json_encode(['status' => false, 'message' => 'Input tidak valid']);
            return;
        }
        $result = $this->model->update_admin_pic($id, $username);
        header('Content-type: application/json');
        echo json_encode(['status' => $result]);
    }
    function insert_admin_pic()
    {
        if ($this->session->userdata('user_id') != 1) {
            echo json_encode(['status' => false, 'message' => 'Unauthorized']);
            return;
        }
        $username = $this->input->post('username');
        if (!$username) {
            echo json_encode(['status' => false, 'message' => 'Username tidak valid']);
            return;
        }
        $result = $this->model->insert_admin_pic($username);
        header('Content-type: application/json');
        echo json_encode(['status' => $result]);
    }
    function delete_admin_pic()
    {
        if ($this->session->userdata('user_id') != 1) {
            echo json_encode(['status' => false, 'message' => 'Unauthorized']);
            return;
        }
        $id = $this->input->post('id');
        if (!$id) {
            echo json_encode(['status' => false, 'message' => 'ID tidak valid']);
            return;
        }
        $result = $this->model->delete_admin_pic($id);
        header('Content-type: application/json');
        echo json_encode(['status' => $result]);
    }
    function draf()
    {
        $file_name = null; // Variabel untuk menampung nama file jika ada

        // --- BAGIAN BARU: HANDLE FILE UPLOAD ---
        // Cek apakah ada file yang di-upload dengan nama 'lampiran_memo'
        if (isset($_FILES['lampiran_memo']) && $_FILES['lampiran_memo']['error'] != 4) {

            // Konfigurasi untuk upload
            // PENTING: 'upload_path' adalah PATH di server, bukan URL
            $config['upload_path'] = './uploads/files_memo/';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg';
            $config['max_size'] = 2048; // 2MB dalam kilobytes
            $config['encrypt_name'] = TRUE; // Enkripsi nama file agar unik & aman

            // Buat direktori jika belum ada
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            // Load library upload
            $this->load->library('upload', $config);

            // Lakukan upload
            if ($this->upload->do_upload('lampiran_memo')) {
                // Jika upload berhasil, ambil nama filenya
                $upload_data = $this->upload->data();
                $file_name = $upload_data['file_name'];
            } else {
                // Jika upload gagal, hentikan proses dan kirim error
                $error = ['status' => false, 'error' => $this->upload->display_errors('', '')];
                echo json_encode($error);
                return; // Hentikan eksekusi
            }
        }
        $id_memo = $this->input->post('id_memo');
        $judul = $this->input->post('judul');
        $company_id = $this->input->post('company_id');
        $department_arr = $this->input->post('department_id');
        $to_person_arr = $this->input->post('to_person');
        $role_arr = $this->input->post('role_id');
        $priority = $this->input->post('priority') ?? null;
        $category = $this->input->post('category') ?? null;
        $content = $this->input->post('content');
        $approval = $this->input->post('approval');
        $tujuan = $this->input->post('tujuan') ?? null;
        $jenis = $this->input->post('jenis') ?? null;
        $cc_arr = $this->input->post('cc');
        $department_str = is_array($department_arr) ? implode(',', $department_arr) : "";
        $to_person_str = is_array($to_person_arr) ? implode(',', $to_person_arr) : NULL;
        $role_str = is_array($role_arr) ? implode(',', $role_arr) : NULL;
        $cc_str = is_array($cc_arr) ? implode(',', $cc_arr) : NULL;

        $slug = $this->generate_unique_slug($judul);

        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Dapatkan semua elemen <img> dari konten
        // --- Kode yang sudah ada untuk memproses gambar ---
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Pastikan src bukan URL absolut atau data URI (base64)
            if ($src && !preg_match('/^(https?:\/\/|\/\/|data:image)/i', $src)) {
                $newSrc = base_url(ltrim($src, '/'));
                $img->setAttribute('src', $newSrc);
            }
        }
        $xpath = new DOMXPath($dom);
        $nodesToRemove = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' starter-template ')]");
        foreach ($nodesToRemove as $node) {
            $node->parentNode->removeChild($node);
        }
        $modifiedContent = $dom->saveHTML();

        // $cek_approval = $this->db->get_where('trusmi_t_memo_approval',['id_approval'=>$approval,'id_memo'=>$id_memo])->result();

        $this->db->where('id_approval', $approval);
        $this->db->where('id_memo', $id_memo);
        $this->db->delete('trusmi_t_memo_approval');


        $data = [
            'judul' => $judul,
            'company_id' => $company_id,
            'department_id' => $department_str,
            'to_person' => $to_person_str,
            'role_id' => $role_str,
            'priority' => $priority,
            'category' => $category,
            'tujuan' => $tujuan,
            'jenis' => $jenis,
            'cc' => $cc_str,
            'content' => $modifiedContent,
            'status_memo' => 1,
            'url' => $slug,
            'created_at' => date('y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
        ];
        if ($file_name) {
            $data['lampiran'] = $file_name; // Ganti 'nama_kolom_file' dengan nama kolom di DB
        }

        if ($id_memo == 'null') {
            $new_memo_id = $this->model->get_id_memo(); // Panggil fungsi untuk generate ID baru
            $data['id_memo'] = $new_memo_id;

            $data_approval = $this->model->list_approval($approval);
            foreach ($data_approval as $value) {
                $data_approval_item = [
                    'id_approval' => $value->id,
                    'id_memo' => $new_memo_id,
                    'tipe' => $value->tipe,
                    'pic' => $value->user_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('trusmi_t_memo_approval', $data_approval_item);
            }
            $kode = $this->model->get_kode_department($this->session->userdata('department_id'));
            $data['created_company'] = $kode->kode_comp;
            $data['created_department'] = $kode->kode_dep;


            // Panggil fungsi model untuk insert data
            $result['status'] = $this->db->insert('trusmi_t_memo', $data);
            $result['tipe'] = 'insert';


        } else {
            $data_approval = $this->model->list_approval($approval);
            foreach ($data_approval as $value) {
                $data_approval_item = [
                    'id_approval' => $value->id,
                    'id_memo' => $id_memo,
                    'tipe' => $value->tipe,
                    'pic' => $value->user_id,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('trusmi_t_memo_approval', $data_approval_item);
            }
            $this->db->where('id_memo', $id_memo);
            $result['status'] = $this->db->update('trusmi_t_memo', $data);
            $result['tipe'] = 'update';
        }
        echo json_encode($result);
    }
    function save()
    {
        $id_memo_post = $this->input->post('id_memo');
        $judul = $this->input->post('judul');
        $approval = $this->input->post('approval');
        $file_name = null;

        // --- 1. TENTUKAN ID MEMO YANG AKAN DIGUNAKAN ---
        $memo_id_to_use = '';
        $is_new_memo = ($id_memo_post == 'null' || empty($id_memo_post));

        if ($is_new_memo) {
            // Jika ini memo baru, buat ID baru
            $memo_id_to_use = $this->model->get_id_memo();
        } else {
            // Jika ini memo lama (update), gunakan ID yang ada
            $memo_id_to_use = $id_memo_post;
        }

        // --- HANDLE FILE UPLOAD (Logika ini sudah benar) ---
        if (isset($_FILES['lampiran_memo']) && $_FILES['lampiran_memo']['error'] != 4) {
            $config['upload_path'] = './uploads/files_memo/';
            $config['allowed_types'] = 'pdf|png|jpg|jpeg';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE);
            }

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('lampiran_memo')) {
                $file_name = $this->upload->data('file_name');
            } else {
                echo json_encode(['status' => false, 'error' => $this->upload->display_errors('', '')]);
                return;
            }
        }

        // --- 2. HAPUS APPROVAL LAMA & SISIPKAN YANG BARU DENGAN ID YANG BENAR ---
        // Hapus semua approval yang terkait dengan memo ini untuk memastikan data bersih
        $this->db->where('id_memo', $id_memo_post);
        $this->db->delete('trusmi_t_memo_approval');

        // Sisipkan approval yang baru
        $data_approval = $this->model->list_approval($approval);
        foreach ($data_approval as $value) {
            $data_approval_item = [
                'id_approval' => $value->id,
                'id_memo' => $memo_id_to_use, // Gunakan ID yang sudah ditentukan
                'tipe' => $value->tipe,
                'pic' => $value->user_id,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('trusmi_t_memo_approval', $data_approval_item);
        }
        $department_arr = $this->input->post('department_id');
        $to_person_arr = $this->input->post('to_person');
        $role_arr = $this->input->post('role_id');
        $cc_arr = $this->input->post('cc');
        $department_str = is_array($department_arr) ? implode(',', $department_arr) : '';
        $to_person_str = is_array($to_person_arr) ? implode(',', $to_person_arr) : NULL;
        $role_str = is_array($role_arr) ? implode(',', $role_arr) : NULL;
        $cc_str = is_array($cc_arr) ? implode(',', $cc_arr) : NULL;

        $slug = $this->generate_unique_slug($judul);
        $dom = new DOMDocument();
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $this->input->post('content'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Dapatkan semua elemen <img> dari konten
        // --- Kode yang sudah ada untuk memproses gambar ---
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Pastikan src bukan URL absolut atau data URI (base64)
            if ($src && !preg_match('/^(https?:\/\/|\/\/|data:image)/i', $src)) {
                $newSrc = base_url(ltrim($src, '/'));
                $img->setAttribute('src', $newSrc);
            }
        }
        $xpath = new DOMXPath($dom);
        $nodesToRemove = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' starter-template ')]");
        foreach ($nodesToRemove as $node) {
            $node->parentNode->removeChild($node);
        }
        $modifiedContent = $dom->saveHTML();

        $data = [
            'judul' => $judul,
            'company_id' => $this->input->post('company_id'),
            'department_id' => $department_str,
            'to_person' => $to_person_str,
            'role_id' => $role_str,
            'cc' => $cc_str,
            'priority' => $this->input->post('priority'),
            'category' => $this->input->post('category'),
            'content' => $modifiedContent,
            'tujuan' => $this->input->post('tujuan'),
            'jenis' => $this->input->post('jenis'),
            'status_memo' => 2,
            'url' => $slug,
            'created_at' => date('y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
        ];

        if ($file_name) {
            $data['lampiran'] = $file_name;
        }
        if ($is_new_memo) {
            // Tambahkan ID memo ke data utama untuk operasi insert
            $data['id_memo'] = $memo_id_to_use;
            $kode = $this->model->get_kode_department($this->session->userdata('department_id'));
            $data['created_company'] = $kode->kode_comp;
            $data['created_department'] = $kode->kode_dep;

            $result['status'] = $this->db->insert('trusmi_t_memo', $data);
            $result['tipe'] = 'insert';
        } else {
            $this->db->where('id_memo', $memo_id_to_use);
            $result['status'] = $this->db->update('trusmi_t_memo', $data);
            $result['tipe'] = 'update';
        }

        $this->send_notif($memo_id_to_use);
        echo json_encode($result);
    }

    function form_approve()
    {
        $id_approval = $this->input->post('id_approval');
        $id_memo = $this->input->post('id_memo');
        $status = $this->input->post('status_approve');
        $note = $this->input->post('note');
        if ($status == 2) {//revisi
            $data = [
                'status_approval' => $status,
                // 'approve_at' => date('Y-m-d H:i:s'),
                // 'approve_by' => $this->session->userdata('user_id'),
                'note_revisi' => $note,
                'revisi_at' => date('Y-m-d H:i:s'),
                'revisi_by' => $this->session->userdata('user_id'),
            ];
            $this->db->where('id', $id_approval);
            $result = $this->db->update('trusmi_t_memo_approval', $data);
            $result = $this->insert_revisi($id_memo, $note);
        } else if ($status == 5) {
            $data = [
                'status_memo' => $status,
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
                'note_update' => $note
            ];
            $this->db->where('id_memo', $id_memo);
            $result = $this->db->update('trusmi_t_memo', $data);
        } else {
            $data = [
                'status_approval' => $status,
                'approve_at' => date('Y-m-d H:i:s'),
                'approve_by' => $this->session->userdata('user_id'),
                'note_revisi' => $note
            ];
            $this->db->where('id', $id_approval);
            $result = $this->db->update('trusmi_t_memo_approval', $data);
            $this->cek_status_approval($id_memo, 1);
        }

        echo json_encode($result);
    }
    function delete_approval($id_memo)
    {
        $this->db->where('id_memo', $id_memo);
        $this->db->delete('trusmi_t_memo_approval');
    }
    function form_add_approval()
    {
        $nama = $this->input->post('nama');
        $diverifikasi_array = $this->input->post('diverifikasi');
        $diverifikasi_string = is_array($diverifikasi_array) ? implode(',', $diverifikasi_array) : null;
        $disetujui_array = $this->input->post('disetujui');
        $disetujui_string = is_array($disetujui_array) ? implode(',', $disetujui_array) : null;
        $mengetahui_array = $this->input->post('mengetahui');
        $mengetahui_string = is_array($mengetahui_array) ? implode(',', $mengetahui_array) : null;

        $id_approval = $this->model->generate_approval_id();

        $data = [
            'id_approval' => $id_approval,
            'nama' => $nama,
            'diverifikasi' => $diverifikasi_string,
            'disetujui' => $disetujui_string,
            'mengetahui' => $mengetahui_string,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id')
        ];
        $this->db->insert('trusmi_m_memo_approval', $data);
        echo json_encode($this->input->post());
    }

    function insert_revisi($id_memo, $note)
    {
        $data = [
            'id_memo' => $id_memo,
            'note_revisi' => $note,
            'status_revisi' => 0,
            'feedback_at' => date('Y-m-d H:i:s'),
            'feedback_by' => $this->session->userdata('user_id')
        ];
        $result = $this->db->insert('trusmi_t_memo_history', $data);
        return $result;
    }
    function form_approve_sekdir()
    {
        $id_memo = $this->input->post('id_memo');
        $status = $this->input->post('status_approve');
        $note = $this->input->post('note');
        $publish = $this->input->post('publish_sekarang');
        $publish_date = $this->input->post('publish_datetime');


        if ($status == 4) {
            $data = [
                'status_memo' => $status,
                'note_update' => $note,
                'approve_at' => date('Y-m-d H:i:s'),
                'approve_by' => $this->session->userdata('user_id'),
                'publish' => ($publish == 'on') ? date('Y-m-d H:i:s') : $publish_date
            ];
            $memo_number = $this->_generate_memo_number($id_memo);
            if ($memo_number) {
                $data['nomer'] = $memo_number;
            }
            $this->broadcast($id_memo);
            $this->db->where('id_memo', $id_memo);
            $result = $this->db->update('trusmi_t_memo', $data);
        } else if ($status == 5) {
            $data = [
                'status_memo' => $status,
                'updated_by' => $this->session->userdata('user_id'),
                'updated_at' => date('Y-m-d H:i:s'),
                'note_update' => 'Reject Sekdir'
            ];
            $this->db->where('id_memo', $id_memo);
            $result = $this->db->update('trusmi_t_memo', $data);

        }
        echo json_encode($result);
    }
    function broadcast($id_memo)
    {
        $this->load->library('email_api');
        $data = $this->model->get_detail_notif($id_memo);
        $jam = (int) date('H');

        // 3. Tentukan ucapan salam berdasarkan jam
        if ($jam >= 4 && $jam < 11) {
            $salam = 'Selamat Pagi';
        } elseif ($jam >= 11 && $jam < 15) {
            $salam = 'Selamat Siang';
        } elseif ($jam >= 15 && $jam < 19) {
            $salam = 'Selamat Sore';
        } else {
            $salam = 'Selamat Malam';
        }
        // var_dump($data);die();
        $base = base_url('/trusmi_memo/read') . '/';
        foreach ($data as $item) {
            $contact = $item->contact_no;
            $link = $base . $item->url;
            $judul_memo = ucfirst(strtolower($item->judul));
            $tahun = date('Y');

            $msg = "
            <style>
.btn {
  background-color: #f44336;
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  border-radius : 5px;
}

.btn:hover, .btn:active {
  background-color: red;
}
</style>
<div style='padding:0px 15px'>
$salam <strong>{$item->nama_karyawan}</strong>,
---
Anda menerima <strong>{$item->jenis}</strong> baru dengan rincian sebagai berikut:

Nomor Memo  : <strong>{$item->nomer}</strong>
Perihal     : <strong>{$judul_memo}</strong>

Mohon untuk segera membaca dan menindaklanjuti isi memo tersebut.

Untuk melihat rincian selengkapnya, silakan akses tautan berikut:
<a class='btn' href='{$link}' target='_blank'>Lihat Memo</a>

atau copy paste di browser melalui link berikut

<a href='{$link}' target='_blank'>{$link}</a>

Terima kasih atas perhatian Anda.

Hormat kami,
{$item->created_by_name}

---
<pre>Email ini dibuat secara otomatis. Mohon untuk tidak membalas.
© {$tahun} {$item->company_name} - {$item->department_name}  </pre>
</div>
";
            //     $msg = "
            //     <!DOCTYPE html>
            // <html>
            // <head>
            // <meta charset='UTF-8'>
            // <title>Pemberitahuan Memo Baru</title>
            // </head>
            // <body style='margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;'>
            //     <table border='0' cellpadding='0' cellspacing='0' width='100%'>
            //         <tr>
            //             <td style='padding: 20px 0;'>
            //                 <table align='center' border='0' cellpadding='0' cellspacing='0' width='600' style='border-collapse: collapse; background-color: #ffffff; border: 1px solid #dddddd;'>

            //                     <tr>
            //                         <td align='center' style='padding: 30px 0;'>
            //                             <img src='https://karir.trusmigroup.com/assets/images/logo.png' alt='Trusmi Group Logo' width='180' style='display: block;' />
            //                         </td>
            //                     </tr>

            //                     <tr>
            //                         <td style='padding: 20px 40px;'>
            //                             <h2 style='color: #333333; margin-top: 0;'>Pemberitahuan Memo Baru</h2>
            //                             <p style='font-size: 16px; line-height: 1.6; color: #555555;'>{$salam}, <b>{$item->nama_karyawan}</b></p>
            //                             <p style='font-size: 16px; line-height: 1.6; color: #555555;'>Anda telah menerima memo internal baru dengan rincian sebagai berikut:</p>

            //                             <table border='0' cellpadding='8' cellspacing='0' width='100%' style='margin: 20px 0; border-top: 1px solid #eeeeee; border-bottom: 1px solid #eeeeee;'>
            //                                 <tr>
            //                                     <td style='width: 120px; font-size: 15px;'><strong>Nomor Memo</strong></td>
            //                                     <td style='font-size: 15px;'>: {$item->nomer}</td>
            //                                 </tr>
            //                                 <tr>
            //                                     <td style='font-size: 15px;'><strong>Perihal</strong></td>
            //                                     <td style='font-size: 15px;'>: " . ucfirst(strtolower($item->judul)) . "</td>
            //                                 </tr>
            //                             </table>

            //                             <p style='font-size: 16px; line-height: 1.6; color: #555555;'>Mohon untuk segera diperhatikan dan dijalankan sebagaimana mestinya.</p>

            //                             <table border='0' cellpadding='0' cellspacing='0' width='100%'>
            //                                 <tr>
            //                                     <td align='center' style='padding: 20px 0;'>
            //                                         <a href='{$link}' target='_blank' style='background-color: #007bff; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold;'>
            //                                             Baca Selengkapnya
            //                                         </a>
            //                                     </td>
            //                                 </tr>
            //                             </table>
            //                         </td>
            //                     </tr>

            //                     <tr>
            //                         <td style='background-color: #fafafa; padding: 30px 40px;'>
            //                             <p style='margin: 0; font-size: 14px; color: #555555;'>
            //                                 Hormat kami,<br>
            //                                 <strong>{$item->created_by_name}</strong>
            //                             </p>
            //                             <p style='margin-top: 20px; font-size: 12px; color: #999999;'>
            //                                 &copy; " . date('Y') . " Trusmi Group. Ini adalah email yang dibuat secara otomatis.
            //                             </p>
            //                         </td>
            //                     </tr>
            //                 </table>
            //             </td>
            //         </tr>
            //     </table>
            // </body>
            // </html>
            // ";
            $response = $this->email_api->send(
                $contact,
                $msg,
                1
            );
            // print_r($response);
        }
    }

    function upload_image_content()
    {
        header('Content-Type: application/json');

        // Konfigurasi untuk library Upload CodeIgniter
        $config['upload_path'] = './uploads/files_memo/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE; // Nama file akan di-hash secara otomatis

        // Muat library upload dengan konfigurasi yang sudah dibuat
        $this->load->library('upload', $config);

        // Lakukan proses upload. 'file' adalah nama field dari TinyMCE/AJAX
        if ($this->upload->do_upload('file')) {
            // Jika upload berhasil, ambil data file
            $uploadData = $this->upload->data();
            $fileName = $uploadData['file_name'];
            $fileUrl = 'https://trusmiverse.com/apps/uploads/files_memo/' . $fileName;
            echo json_encode(['location' => $fileUrl]);

        } else {
            // Jika upload gagal, kirim pesan error dari library
            http_response_code(500); // Server error
            echo json_encode(['error' => $this->upload->display_errors('', '')]);
        }
    }

    function cek_status_approval($id_memo, $tipe)
    {
        $data_approval = $this->model->cek_status_approval($id_memo);

        if (!empty($data_approval)) {
            $semua_disetujui = true; // Anggap semua status adalah 1 (disetujui) pada awalnya
            foreach ($data_approval as $approval) {
                if ($approval->status_approval != 1) {
                    $semua_disetujui = false; // Ubah penanda menjadi false
                    break; // Hentikan perulangan karena sudah pasti tidak semua disetujui
                }
            }
            if ($semua_disetujui) {
                $this->db->where('id_memo', $id_memo);
                $this->db->update('trusmi_t_memo', ['status_memo' => 3]);
            }
        }
    }


    function read()
    {
        $tgl = $this->uri->segment(3);
        $judul = $this->uri->segment(4);
        $url = $tgl . '/' . $judul;
        $data_memo = $this->model->read($url);
        // var_dump($data_memo);die();

        $data = [
            'content' => $data_memo,
            'approval' => $this->model->approval($data_memo->id_memo),
        ];
        // var_dump($data);die();
        $this->load->view('trusmi_memo/read.php', $data);
    }

    function _generate_memo_number($id_memo)
    {
        // 1. Get the memo's department, company, and creation date
        $memo = $this->db->select('t.created_company, t.created_department, t.created_at, jn.jenis, t.jenis AS id_jenis')
            ->join('trusmi_m_memo jn', 'jn.id = t.jenis', 'left')
            ->where('t.id_memo', $id_memo)
            ->get('trusmi_t_memo t')
            ->row();

        if (!$memo) {
            return null; // Return null if memo not found
        }

        $department_code = $memo->created_department;
        $company_code = $memo->created_company;
        $memo_year = date('Y', strtotime($memo->created_at));
        $memo_month = date('n', strtotime($memo->created_at));
        $jenis = trim($memo->jenis ?? '');
        $id_jenis = $memo->id_jenis;

        if ($jenis === '') {
            $type = 'MI'; // fallback jika jenis kosong
        } else {
            // pecah berdasarkan spasi, ambil huruf pertama tiap kata, uppercase (support multibyte)
            $words = preg_split('/\s+/', $jenis);
            $type = '';
            foreach ($words as $w) {
                if ($w === '')
                    continue;
                $type .= mb_strtoupper(mb_substr($w, 0, 1, 'UTF-8'), 'UTF-8');
            }
            if ($type === '')
                $type = 'MI';
        }

        // 2. Calculate the running number for that department, month, and year
        $this->db->where('created_department', $department_code);
        $this->db->where('YEAR(created_at)', $memo_year);
        $this->db->where('MONTH(created_at)', $memo_month);
        $this->db->where('jenis', $id_jenis);
        $this->db->where('nomer IS NOT NULL', null, false); // Count only those that already have a number
        $count = $this->db->count_all_results('trusmi_t_memo');

        // The new number is the total count + 1, formatted with leading zeros
        $running_number = sprintf('%03d', $count + 1);

        // 3. Convert month to Roman numeral
        $roman_months = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $roman_month = $roman_months[$memo_month];

        // 4. Assemble the final memo number string
        // Format: Running Number / Memo Internal / Company Code / Department Code / Roman Month / Year
        $final_number = "{$running_number}/{$type}/{$company_code}/{$department_code}/{$roman_month}/{$memo_year}";

        return $final_number;
    }

    function simpan_memo_approval()
    {
        $user_id = $_POST["user_id"];

        $id = $this->model->get_id_memo();
        $dt_memo = [
            'id_memo' => $id,
            'tipe_memo' => $_POST['tipe_memo'],
            'note' => $_POST['note'] . " - Approve by Ibnu Riyanto (" . $_POST['no_app'] . ")",
            'note_update' => $_POST['note'] . " - Approve by Ibnu Riyanto (" . $_POST['no_app'] . ")",
            'company_id' => $_POST['company_id'],
            'department_id' => $_POST['department_id'],
            'role_id' => $_POST['role_id'],
            'created_by' => $user_id,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_by' => 803,
            'updated_at' => date("Y-m-d H:i:s"),
            'files_memo' => 'https://trusmiverse.com/apps/uploads/trusmi_approval/' . $_POST['file_1'],
            'status_memo' => 1,
            'id_approval' => $_POST['no_app'],
            'start_feedback_at' => date('Y-m-01', strtotime('+3 months', strtotime(date('Y-m-d'))))
        ];
        $data['insert_memo'] = $this->db->insert('trusmi_t_memo', $dt_memo);
        header('Content-type: application/json');
        echo json_encode($data);
    }

    function edit_memo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $note = $_POST['note'];
            $dt_memo = [
                'updated_at' => date("Y-m-d H:i:s"),
                'updated_by' => $this->session->userdata("user_id"),
                'note_update' => $note,
                'status_memo' => $status
            ];
            $this->db->where('id_memo', $id);
            $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }

    }

    function feedback_memo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (!empty($_FILES['files']['tmp_name'])) {
                if (is_uploaded_file($_FILES['files']['tmp_name'])) {
                    //checking file type
                    $allowed = array('pdf', 'xls', 'xlsx', 'png', 'jpg', 'jpeg', 'doc', 'docx');
                    $filename = $_FILES['files']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["files"]["tmp_name"];
                        $profile = "./uploads/files_memo/feedback/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'feedback_memo_ba_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                    } else {
                        $fname = null;
                    }
                }
            } else {
                $fname = null;
            }

            $dt_memo = [
                'status_feedback' => $_POST['status_feedback'],
                'feedback' => $_POST['feedback'],
                'file_feedback' => $fname,
                'link_feedback' => $_POST['link_feedback'] ?? null,
                'feedback_at' => date('Y-m-d H:i:s'),
                'feedback_by' => $this->session->userdata("user_id"),
                'status_feedback' => $_POST['status_feedback'],
                'start_feedback_at' => date('Y-m-01', strtotime('+3 months', strtotime(date('Y-m-d'))))
            ];
            $this->db->where('id_memo', $id);
            $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
            unset($dt_memo['start_feedback_at']);
            $dt_memo['id_memo'] = $id;
            $this->db->insert('trusmi_t_memo_history', $dt_memo);
            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }

    }

    function generate_unique_slug($judul)
    {
        $base_slug = strtolower($judul);
        $base_slug = str_replace(' ', '-', $base_slug);
        $base_slug = preg_replace('/[^a-z0-9\-]/', '', $base_slug); // Hanya huruf, angka, dan strip
        $base_slug = preg_replace('/-+/', '-', $base_slug); // Ganti strip ganda menjadi tunggal
        $base_slug = trim($base_slug, '-'); // Hapus strip di awal atau akhir

        // Jika base_slug kosong setelah dibersihkan (misal judulnya hanya simbol),
        // berikan nilai default agar tidak error.
        if (empty($base_slug)) {
            $base_slug = 'memo';
        }

        // 2. Memeriksa keunikan slug menggunakan Query Builder
        $slug = $base_slug;
        $counter = 2;

        while (true) {
            $this->db->where("SUBSTRING_INDEX(url, '/', -1) =", $slug);
            $this->db->from('trusmi_t_memo');
            $count = $this->db->count_all_results();
            if ($count == 0) {
                break;
            }

            // Jika sudah ada, buat slug baru dengan akhiran angka
            $slug = $base_slug . '_' . $counter;
            $counter++;
        }

        // 3. Menambahkan format tanggal di depan slug
        $final_url = date('Y-m-d') . '/' . $slug;

        return $final_url;
    }

    function feedback_memo_history()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $data['status'] = true;
            $data['histories'] = $this->model->feedback_memo_history($id);

            header('Content-type: application/json');
            echo json_encode($data);
        } else {
            $data['status'] = false;

            header('Content-type: application/json');
            echo json_encode($data);
        }
    }

    function edit_file_memo()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (!empty($_FILES['files']['tmp_name'])) {
                if (is_uploaded_file($_FILES['files']['tmp_name'])) {
                    //checking file type
                    $allowed = array('pdf', 'xls', 'xlsx');
                    $filename = $_FILES['files']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    if (in_array($ext, $allowed)) {
                        $tmp_name = $_FILES["files"]["tmp_name"];
                        $profile = "./uploads/files_memo/";
                        // basename() may prevent filesystem traversal attacks;
                        // further validation/sanitation of the filename may be appropriate
                        $newfilename = 'memo_ba_' . $this->session->userdata("user_id") . '_' . substr(time(), -5) . '.' . $ext;
                        $data['move'] = move_uploaded_file($tmp_name, $profile . $newfilename);
                        $fname = $newfilename;
                        $dt_memo = [
                            'files_memo' => $fname,
                        ];
                        $this->db->where('id_memo', $id);
                        $data['update'] = $this->db->update('trusmi_t_memo', $dt_memo);
                        header('Content-type: application/json');
                        echo json_encode($data);
                    } else {
                        $data['update'] = false;
                        header('Content-type: application/json');
                        echo json_encode($data);
                    }
                }
            } else {
                $data['update'] = false;
                header('Content-type: application/json');
                echo json_encode($data);
            }
        } else {
            $data['update'] = false;
            header('Content-type: application/json');
            echo json_encode($data);
        }

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

     function send_notif($id_memo){
       try {
            $recipients = $this->model->get_detail_notif_wa($id_memo);
            if (empty($recipients)) {
                return;
            }
            $memo = $recipients[0];
            foreach ($recipients as $item) {
                if (empty($item->contact_no)) {
                    continue;
                }
                $deadline = date('d/m/Y', strtotime($item->deadline));
                $msg = "📋 *Persetujuan Memo Diperlukan*\n\n"
                     . "Dear Bpk / Ibu : *$item->pic*\n\n"
                     . "Disampaikan bahwa telah diterbitkan memo baru dengan rincian sebagai berikut:\n\n"
                     . "📌 Judul           : *" . $item->judul . "*\n"
                     . "📂 Jenis           : *" . $item->jenis . "*\n"
                     . "🏷️ Kategori        : *" . $item->category . "*\n"
                     . "⚡ Prioritas       : *" . $item->priority . "*\n"
                     . "✅ Tipe Approval   : *" . $item->jenis_approval . "*\n"
                     . "⏰ Deadline        : *" . $deadline . "*\n\n"
                     . "👤 Dibuat Oleh     : *" . $item->created_by_name . "* (*" . $item->created_by_position . "*)\n\n"
                     . "Mohon agar memo tersebut dapat segera ditinjau dan ditindaklanjuti sesuai dengan kebutuhan dan ketentuan yang berlaku."
                     . "Terima kasih.🙏🏻";
                $this->send_wa($item->contact_no, $msg, $item->id_pic);

                
            }
        } catch (\Throwable $th) {
            // Notifikasi gagal tidak memblokir proses simpan memo
        }
     }

    //   function send_notif(){
    //     $phone = '08978462751';
    //     $msg = 'Ini adalah pesan notifikasi WA';
    //     $user_id = 11689; // Opsional, bisa digunakan untuk logging atau keperluan lain
    //     $result = $this->send_wa_blast($phone, $msg, $user_id);
    //     echo json_encode(['result' => $result]);
    //  }

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

    function _send_notif_memo_saved($id_memo)
    {
        
    }
}