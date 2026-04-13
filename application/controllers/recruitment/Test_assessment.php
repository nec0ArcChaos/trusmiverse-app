<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_candidates extends CI_Controller //Formulir Dokumen Karyawan
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('encryption');
        $this->load->library('Whatsapp_lib');
        $this->load->model('recruitment/Model_job_candidates', 'model');
        $this->load->model("model_profile");
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }
    function index()
    {
        $user = $this->session->userdata('user_id');
        $data['pageTitle'] = "Auto Screening - Job Candidates";
        $data['css'] = "recruitment/job_candidates/css_ai";
        $data['js'] = "recruitment/job_candidates/js_ai";
        $data['content'] = "recruitment/job_candidates/index_ai";
        $data['assessment'] = $this->model->get_list_test();


        $data['alasan'] = $this->model->get_alasan('database');

        $this->load->view('layout/main', $data);
    }
    // new development
    
    function get_all_test()
    {
        $data = $this->model->get_all_test();

        // 2. Jika tidak ada data, hentikan proses
        if (empty($data)) {
            // Anda bisa menampilkan pesan atau redirect,
            // tapi untuk download, lebih baik hentikan saja.
            echo "Tidak ada data untuk diunduh.";
            return;
        }

        // 3. Tentukan nama file yang akan diunduh
        $filename = 'laporan_test_' . date('Y-m-d') . '.csv';

        // 4. Atur HTTP Headers untuk memicu download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // 5. Buka output stream PHP untuk menulis data
        $output = fopen('php://output', 'w');

        // 6. Tulis baris header CSV (mengambil dari key array pertama)
        // Menggunakan (array) untuk memastikan bekerja baik untuk object maupun array
        fputcsv($output, array_keys((array) $data[0]));

        // 7. Loop dan tulis setiap baris data ke file CSV
        foreach ($data as $row) {
            // Menggunakan (array) untuk mengubah object menjadi array jika perlu
            fputcsv($output, (array) $row);
        }

        // 8. Tutup stream
        fclose($output);

        // 9. Hentikan eksekusi script lebih lanjut
        exit;
    }
}
