<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Rekap_absen_ade extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('hr/model_rekap_absen_ade', 'model_rekap_absen');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
        //  User IT
        //  61 Anggi
        //  62 Lutfi
        //  63 Said
        //  64 Lutfiedadi
        //  1161 Fujiyanto
        //  2041 Faisal
        //  2063 Aris
        //  2070 Kania
        //  2969 Ari Fadzri
        // $user_it = array(1, 61, 62, 323, 979, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070);
        // if (in_array($this->session->userdata('user_id'), $user_it)) {
        // } else {
        //     $this->session->set_flashdata('no_access', 1);
        //     redirect('dashboard', 'refresh');
        // }
    }

    public function index()
    {
        $data['pageTitle']  = "Rekap Absen";
        $data['css']        = "hr/rekap_absen/css";
        $data['js']         = "hr/rekap_absen/js_ade";
        $data['content']    = "hr/rekap_absen/index_ade";

        $data['start']      = date("Y-m-21", strtotime("-1 month", strtotime(date('Y-m-d'))));
        $data['end']        = date("Y-m-20");

        // print_r($this->session->userdata()); die;
        $data['id_cutoff'] = $this->session->userdata('cutoff');

        $sub_emp  = '1426,2535,2859,4367';

        // $sub_emp_len    = strlen($sub_emp)-1;
        // $sub_emp        = substr($sub_emp,0,$sub_emp_len);

        // var_dump($sub_emp_len);
        // var_dump($sub_emp);
        // die();

        $data['tanggal_periode']  = $this->model_rekap_absen->tanggal_periode(1, 2)->result();
        $data['get_company']  = $this->model_rekap_absen->get_company()->result();
        $this->load->view('layout/main', $data);
    }

    public function get_department()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model_rekap_absen->get_department($company_id)->result();

        echo json_encode($data);
    }

    public function get_employees()
    {
        $company_id     = $_POST['company_id'];
        $department_id  = $_POST['department_id'];
        $data           = $this->model_rekap_absen->get_employees($company_id, $department_id)->result();

        echo json_encode($data);
    }

    public function test_date()
    {
        // echo date("Y-m-t");
        echo strtotime(date('Y-m-d'));
        echo '<br/>';
        echo date("Y-m-21", strtotime("-1 month", strtotime(date('2024-02-01'))));
    }

    public function get_rekap_absen()
    {
        $company_id     = (isset($_POST['company_id'])) ? $_POST['company_id'] : $this->session->userdata('company_id');
        $department_id  = (isset($_POST['department_id'])) ? $_POST['department_id'] : $this->session->userdata('department_id');
        $employee_id    = (isset($_POST['employee_id'])) ? $_POST['employee_id'] : $this->session->userdata('user_id');
        $user_info      = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $employee_id")->row_array();
        $designation_id = $user_info['designation_id'];
        $user_id = $this->session->userdata('user_id');

        $spesial_case = ['329']; // ratih pdca

        if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Direktur', 'Head', 'Manager'))) {
            $posisi = "'Direktur', 'Head', 'Manager', 'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Assistent Manager', 'Supervisor'))) {
            $posisi = "'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else {
            $sub_emp = 0;
        }

        // COMMENT BY SAID KARENA NAMA SAFIRA AZ ZAHRA TIDAK MUNCUL DI LOGIN NYA BU ULFA 

        // $sub_emp_len    = strlen($sub_emp)-1;
        // $sub_emp        = substr($sub_emp,0,$sub_emp_len);

        // echo $this->session->userdata('posisi');

        // echo $sub_emp;

        $periode        = $_POST['periode']; // 2025-02

        // if ($designation_id == 731 || $department_id == 'grade_sales') {
        //     $start = date($periode . "-01");
        //     $end = date('Y-m-t', strtotime($periode . '-01'));
        // } else if ($company_id == 3) {
        //     $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
        //     $end            = date($periode . "-15");
        // } else {
        //     $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01')))); // 2025-01-21
        //     $end            = date($periode . "-20"); // 2025-02-20
        // }

        // addnew
        $cutoff        = (isset($_POST['cutoff']) ? $_POST['cutoff'] : $user_info['ctm_cutoff']);

        if ($cutoff == 1) { // 21-20
            $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-20");
        } else if ($cutoff == 2) { // 16-15
            $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-15");
        } else { // 01-eom
            $start = date($periode . "-01");
            $end = date('Y-m-t', strtotime($periode . '-01'));
        }

        // echo $start . ' sd ' . $end;
        // die;


        $bulan          = $this->model_rekap_absen->get_periode($periode, $start, $end, 1)->result();
        $tanggal        = $this->model_rekap_absen->get_periode($periode, $start, $end, 0)->result();
        $absensi        = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id, $sub_emp, $periode, $cutoff)->result(); // addnew cutoff
        echo '<table id="dt_rekap_absen" class="table table-sm table-striped table-bordered nowrap" style="width:100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="2">No</th>';
        echo '<th rowspan="2">Employee</th>';
        echo '<th rowspan="2">Designation</th>';
        echo '<th rowspan="2">Department</th>';
        echo '<th rowspan="2">Location</th>';
        echo '<th rowspan="2">Date Of Joining</th>';
        echo '<th rowspan="2">Last Present</th>';

        foreach ($bulan as $bln) {
            echo '<th colspan="' . $bln->colspan . '">' . $bln->bulan . '</th>';
        }
        echo '<th rowspan="2">Harus Hadir</th>';
        echo '<th rowspan="2">Total Hadir</th>';
        echo '<th colspan="3">Terlambat</th>';
        echo '<th colspan="2">Off</th>';
        echo '<th colspan="3">Ijin Pulang Cepat & Datang Terlambat</th>';
        echo '<th colspan="6">Lock Absen</th>';
        echo '<th rowspan="2">Finger 1x</th>';
        echo '<th colspan="8">Cuti Khusus</th>';
        echo '<th colspan="3">Dinas Luar Kota</th>';
        echo '<th colspan="3">Sakit</th>';
        echo '<th rowspan="2">Total Libnas</th>';
        echo '<th rowspan="2">Resign</th>';
        echo '<th rowspan="2">Kehadiran</th>';
        echo '<th rowspan="2">Kedisiplinan</th>';
        echo '</tr>';
        echo '<tr>';

        foreach ($tanggal as $tgl) {
            echo '<th>' . $tgl->tgl . '</th>';
        }

        // terlambat
        echo '<th>Jam Masuk Tdk Sesuai</th>';
        echo '<th>Jam Pulang Lebih Cepat Tdk Ijin</th>';
        echo '<th>Total Menit</th>';
        // off
        echo '<th>Libur</th>';
        echo '<th>Kelebihan Off</th>';
        // ijin pulang cepat dan datang terlambat
        echo '<th>Pulang Cepat</th>';
        echo '<th>Datang Terlambat</th>';
        echo '<th>Total</th>';
        // lock absen
        echo '<th>Lock Video</th>';
        echo '<th>Lock Tasklist</th>';
        echo '<th>Lock EAF</th>';
        echo '<th>Lock Training</th>';
        echo '<th>Lock Absen Selain Kategori di Samping</th>';
        echo '<th>Total</th>';
        // cuti khusus
        echo '<th>Cuti Tahunan</th>';
        echo '<th>Cuti Bersalin / Keguguran / Istri Bersalin / Istri Keguguran</th>';
        echo '<th>Kematian Keluarga</th>';
        echo '<th>Karyawan Menikah</th>';
        echo '<th>Pernikahan Anak Kandung Karyawan / Pernikahan Saudara Kandung Karyawan</th>';
        echo '<th>Khitan Anak</th>';
        echo '<th>Skripsi / Wisuda</th>';
        echo '<th>Total</th>';
        // dinas luar kota
        echo '<th>Non Driver</th>';
        echo '<th>Driver</th>';
        echo '<th>Total</th>';
        // sakit
        echo '<th>Karyawan Sakit</th>';
        echo '<th>Keluarga Sakit (Anak / Suami / Istri / Orang Tua)</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        echo '</thead>';

        $no = 1;
        echo '<tbody>';
        foreach ($absensi as $abs) {

            $lebih_absen    = $abs->harus_hadir - $abs->total_hadir;
            $lebih_absen    = ($lebih_absen < 0) ? 0 : $lebih_absen;
            $kehadiran      = ($abs->harus_hadir < 1) ? 0 : round(($abs->total_hadir / $abs->harus_hadir) * 100);
            $kedisiplinan   = ($abs->harus_hadir < 1) ? 0 : round((($abs->total_hadir - $abs->telat - $abs->bolos - $abs->total_izin_pc_dt - $abs->absen_sekali) / $abs->harus_hadir) * 100);

            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $abs->employee . '</td>';
            echo '<td>' . $abs->designation . '</td>';
            echo '<td>' . $abs->department . '</td>';
            echo '<td>' . $abs->location . '</td>';
            echo '<td>' . $abs->date_of_joining . '</td>';
            echo '<td>' . $abs->last_present . '</td>';
            echo str_replace('*', '"', $abs->absensi);
            echo '<td align="center">' . $abs->harus_hadir . '</td>';
            echo '<td align="center">' . $abs->total_hadir . '</td>';
            // terlambat
            echo '<td align="center">' . $abs->telat . '</td>';
            echo '<td align="center">' . $abs->bolos . '</td>';
            echo '<td align="center">' . $abs->menit_telat . '</td>';
            // off
            echo '<td align="center">' . $abs->absen . '</td>';
            echo '<td align="center">' . $lebih_absen . '</td>';
            // ijin pulang cepat dan datang terlambat
            echo '<td align="center">' . $abs->izin_pc . '</td>';
            echo '<td align="center">' . $abs->izin_dt . '</td>';
            echo '<td align="center">' . $abs->total_izin_pc_dt . '</td>';
            // lock absen
            echo '<td align="center">' . $abs->lock_video . '</td>';
            echo '<td align="center">' . $abs->lock_tasklist . '</td>';
            echo '<td align="center">' . $abs->lock_eaf . '</td>';
            echo '<td align="center">' . $abs->lock_training . '</td>';
            echo '<td align="center">' . $abs->lock_other . '</td>';
            echo '<td align="center">' . $abs->total_lock . '</td>';
            // finger 1x
            echo '<td align="center">' . $abs->absen_sekali . '</td>';
            // cuti khusus
            echo '<td align="center">' . $abs->cuti_tahunan . '</td>';
            echo '<td align="center">' . $abs->cuti_bersalin . '</td>';
            echo '<td align="center">' . $abs->kematian_keluarga . '</td>';
            echo '<td align="center">' . $abs->karyawan_menikah . '</td>';
            echo '<td align="center">' . $abs->pernikahan_anak . '</td>';
            echo '<td align="center">' . $abs->khitan_anak . '</td>';
            echo '<td align="center">' . $abs->skripsi_wisuda . '</td>';
            echo '<td align="center">' . $abs->total_cuti_khusus . '</td>';
            // dinas luar kota
            echo '<td align="center">' . $abs->non_driver . '</td>';
            echo '<td align="center">' . $abs->driver . '</td>';
            echo '<td align="center">' . $abs->total_dinas . '</td>';
            // sakit
            echo '<td align="center">' . $abs->karyawan_sakit . '</td>';
            echo '<td align="center">' . $abs->keluarga_sakit . '</td>';
            echo '<td align="center">' . $abs->total_sakit . '</td>';

            echo '<td align="center">' . $abs->libur_nasional . '</td>';
            echo '<td align="center">' . $abs->resign . '</td>';
            echo '<td align="center">' . $kehadiran . '%</td>';
            echo '<td align="center">' . $kedisiplinan . '%</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }

    public function excel($company_id, $department_id, $employee_id, $periode, $cutoff) // addnew cutoff
    {
        $company_id     = ($company_id == 'undefined') ? $this->session->userdata('company_id') : $company_id;
        $department_id  = ($department_id == 'undefined') ? $this->session->userdata('department_id') : $department_id;
        $employee_id    = ($employee_id == 'undefined') ? $this->session->userdata('user_id') : $employee_id;
        $user_info      = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $employee_id")->row_array();
        $designation_id = $user_info['designation_id'];

        // if ($designation_id == 731 || $department_id == 'grade_sales') {
        //     $start = date($periode . "-01");
        //     $end = date('Y-m-t', strtotime($periode . '-01'));
        // } else if ($company_id == 3) {
        //     $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
        //     $end            = date($periode . "-15");
        // } else {
        //     $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01'))));
        //     $end            = date($periode . "-20");
        // }

        // addnew update
        if ($cutoff == 1) { // 21-20
            $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-20");
        } else if ($cutoff == 2) { // 16-15
            $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-15");
        } else { // 01-eom
            $start = date($periode . "-01");
            $end = date('Y-m-t', strtotime($periode . '-01'));
        }


        if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Direktur', 'Head', 'Manager'))) {
            $posisi = "'Direktur', 'Head', 'Manager', 'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Assistent Manager', 'Supervisor'))) {
            $posisi = "'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else {
            $sub_emp = 0;
        }

        // $sub_emp_len    = strlen($sub_emp)-1;
        // $sub_emp        = substr($sub_emp,0,$sub_emp_len);

        $bulan          = $this->model_rekap_absen->get_periode($periode, $start, $end, 1)->result();
        $tanggal        = $this->model_rekap_absen->get_periode($periode, $start, $end, 0)->result();
        $absensi        = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id, $sub_emp, $periode, $cutoff)->result(); // addnew

        $name_file      = "Rekap Absen Periode " . $start . " s/d " . $end;
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $name_file . ".xls");
        echo '<h4>' . $name_file . '</h4>';
        echo '<table border="1">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="2">No</th>';
        echo '<th rowspan="2">Employee</th>';
        echo '<th rowspan="2">Designation</th>';
        echo '<th rowspan="2">Department</th>';
        echo '<th rowspan="2">Location</th>';
        echo '<th rowspan="2">Date Of Joining</th>';
        echo '<th rowspan="2">Last Present</th>';

        foreach ($bulan as $bln) {
            echo '<th colspan="' . $bln->colspan . '">' . $bln->bulan . '</th>';
        }
        echo '<th rowspan="2">Harus Hadir</th>';
        echo '<th rowspan="2">Total Hadir</th>';
        echo '<th colspan="3">Terlambat</th>';
        echo '<th colspan="2">Off</th>';
        echo '<th colspan="3">Ijin Pulang Cepat & Datang Terlambat</th>';
        echo '<th colspan="6">Lock Absen</th>';
        echo '<th rowspan="2">Finger 1x</th>';
        echo '<th colspan="8">Cuti Khusus</th>';
        echo '<th colspan="3">Dinas Luar Kota</th>';
        echo '<th colspan="3">Sakit</th>';
        echo '<th rowspan="2">Total Libnas</th>';
        echo '<th rowspan="2">Resign</th>';
        echo '<th rowspan="2">Kehadiran</th>';
        echo '<th rowspan="2">Kedisiplinan</th>';
        echo '</tr>';
        echo '<tr>';

        foreach ($tanggal as $tgl) {
            echo '<th>' . $tgl->tgl . '</th>';
        }

        // terlambat
        echo '<th>Jam Masuk Tdk Sesuai</th>';
        echo '<th>Jam Pulang Lebih Cepat Tdk Ijin</th>';
        echo '<th>Total Menit</th>';
        // off
        echo '<th>Libur</th>';
        echo '<th>Kelebihan Off</th>';
        // ijin pulang cepat dan datang terlambat
        echo '<th>Pulang Cepat</th>';
        echo '<th>Datang Terlambat</th>';
        echo '<th>Total</th>';
        // lock absen
        echo '<th>Lock Video</th>';
        echo '<th>Lock Tasklist</th>';
        echo '<th>Lock EAF</th>';
        echo '<th>Lock Training</th>';
        echo '<th>Lock Absen Selain Kategori di Samping</th>';
        echo '<th>Total</th>';
        // cuti khusus
        echo '<th>Cuti Tahunan</th>';
        echo '<th>Cuti Bersalin / Keguguran / Istri Bersalin / Istri Keguguran</th>';
        echo '<th>Kematian Keluarga</th>';
        echo '<th>Karyawan Menikah</th>';
        echo '<th>Pernikahan Anak Kandung Karyawan / Pernikahan Saudara Kandung Karyawan</th>';
        echo '<th>Khitan Anak</th>';
        echo '<th>Skripsi / Wisuda</th>';
        echo '<th>Total</th>';
        // dinas luar kota
        echo '<th>Non Driver</th>';
        echo '<th>Driver</th>';
        echo '<th>Total</th>';
        // sakit
        echo '<th>Karyawan Sakit</th>';
        echo '<th>Keluarga Sakit (Anak / Suami / Istri / Orang Tua)</th>';
        echo '<th>Total</th>';
        echo '</tr>';
        echo '</thead>';

        $no = 1;
        echo '<tbody>';
        foreach ($absensi as $abs) {

            $lebih_absen    = $abs->harus_hadir - $abs->total_hadir;
            $lebih_absen    = ($lebih_absen < 0) ? 0 : $lebih_absen;
            $kehadiran      = ($abs->harus_hadir < 1) ? 0 : round(($abs->total_hadir / $abs->harus_hadir) * 100);
            $kedisiplinan   = ($abs->harus_hadir < 1) ? 0 : round((($abs->total_hadir - $abs->telat - $abs->bolos - $abs->total_izin_pc_dt - $abs->absen_sekali) / $abs->harus_hadir) * 100);

            echo '<tr>';
            echo '<td>' . $no++ . '</td>';
            echo '<td>' . $abs->employee . '</td>';
            echo '<td>' . $abs->designation . '</td>';
            echo '<td>' . $abs->department . '</td>';
            echo '<td>' . $abs->location . '</td>';
            echo '<td>' . $abs->date_of_joining . '</td>';
            echo '<td>' . $abs->last_present . '</td>';
            echo $abs->absensi;
            echo '<td align="center">' . $abs->harus_hadir . '</td>';
            echo '<td align="center">' . $abs->total_hadir . '</td>';
            // terlambat
            echo '<td align="center">' . $abs->telat . '</td>';
            echo '<td align="center">' . $abs->bolos . '</td>';
            echo '<td align="center">' . $abs->menit_telat . '</td>';
            // off
            echo '<td align="center">' . $abs->absen . '</td>';
            echo '<td align="center">' . $lebih_absen . '</td>';
            // ijin pulang cepat dan datang terlambat
            echo '<td align="center">' . $abs->izin_pc . '</td>';
            echo '<td align="center">' . $abs->izin_dt . '</td>';
            echo '<td align="center">' . $abs->total_izin_pc_dt . '</td>';
            // lock absen
            echo '<td align="center">' . $abs->lock_video . '</td>';
            echo '<td align="center">' . $abs->lock_tasklist . '</td>';
            echo '<td align="center">' . $abs->lock_eaf . '</td>';
            echo '<td align="center">' . $abs->lock_training . '</td>';
            echo '<td align="center">' . $abs->lock_other . '</td>';
            echo '<td align="center">' . $abs->total_lock . '</td>';
            // finger 1x
            echo '<td align="center">' . $abs->absen_sekali . '</td>';
            // cuti khusus
            echo '<td align="center">' . $abs->cuti_tahunan . '</td>';
            echo '<td align="center">' . $abs->cuti_bersalin . '</td>';
            echo '<td align="center">' . $abs->kematian_keluarga . '</td>';
            echo '<td align="center">' . $abs->karyawan_menikah . '</td>';
            echo '<td align="center">' . $abs->pernikahan_anak . '</td>';
            echo '<td align="center">' . $abs->khitan_anak . '</td>';
            echo '<td align="center">' . $abs->skripsi_wisuda . '</td>';
            echo '<td align="center">' . $abs->total_cuti_khusus . '</td>';
            // dinas luar kota
            echo '<td align="center">' . $abs->non_driver . '</td>';
            echo '<td align="center">' . $abs->driver . '</td>';
            echo '<td align="center">' . $abs->total_dinas . '</td>';
            // sakit
            echo '<td align="center">' . $abs->karyawan_sakit . '</td>';
            echo '<td align="center">' . $abs->keluarga_sakit . '</td>';
            echo '<td align="center">' . $abs->total_sakit . '</td>';

            echo '<td align="center">' . $abs->libur_nasional . '</td>';
            echo '<td align="center">' . $abs->resign . '</td>';
            echo '<td align="center">' . $kehadiran . '%</td>';
            echo '<td align="center">' . $kedisiplinan . '%</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';

        echo '<p>Kode Absensi : </p>
        <ul style="font-size: 10pt;text-align: justify;">
        <li>A : Absen / Libur Mingguan</li>
        <li>H : Hari Libur Nasional / Pergantian hari libur nasional/Pergantian hari libur</li>
        <li>C : Cuti Tahunan</li>
        <li>T : Terlambat</li>
        <li>PC : Pulang Cepat</li>
        <li>DT : Datang Terlambat</li>
        <li>R : Resign</li>
        <li>F : Absen 1x</li>
        <li>CB : Cuti Bersalin / Keguguran / Istri Bersalin / Istri Keguguran</li>
        <li>KL : Kematian Keluarga</li>
        <li>DL : Dinas Luar Kota (Non Driver)</li>
        <li>DD : Dinas Luar Kota Driver</li>
        <li>M : Karyawan Menikah</li>
        <li>S : Karyawan Sakit</li>
        <li>PR : Pernikahan Anak Kandung Karyawan / Pernikahan Saudara Kandung Karyawan</li>
        <li>KA : Khitan Anak</li>
        <li>SK : Keluarga Sakit (Anak / Suami / Istri / Orang Tua)</li>
        <li>SW : Skripsi / Wisuda</li>
        <li>CL : Cuti Tahun Lalu</li>
        <li>P : Present</li>
        <li>NP : Pulang Cepat Tanpa Izin</li>
        <li>LV : Lock Video</li>
        <li>LT : Lock Tasklist</li>
        <li>LE : Lock EAF</li>
        <li>LR : Lock Training</li>
        <li>LA : Lock Lain-lain</li>
        </ul>
        <ul style="font-size: 10pt;text-align: justify;">
        <li>Kehadiran = Total Hadir / Harus Hadir</li>
        <li>Kedisiplinan = ( Total Hadir - Jam Masuk Tdk Sesuai - Jam Pulang Cepat Tdk Ijin - Total Ijin Pulang Cepat & Datang Terlambat - Finger 1x ) / Harus Hadir</li>
        </ul>';
    }



    public function harus_hadir($company_id, $department_id, $employee_id, $periode, $cutoff)
    {
        $company_id     = ($company_id == 'undefined') ? $this->session->userdata('company_id') : $company_id;
        $department_id  = ($department_id == 'undefined') ? $this->session->userdata('department_id') : $department_id;
        $employee_id    = ($employee_id == 'undefined') ? $this->session->userdata('user_id') : $employee_id;
        $user_info      = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $employee_id")->row_array();
        $designation_id = $user_info['designation_id'];

        // if ($designation_id == 731 || $department_id == 'grade_sales') {
        //     $start = date($periode . "-01");
        //     $end = date('Y-m-t', strtotime($periode . '-01'));
        // } else if ($company_id == 3) {
        //     $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
        //     $end            = date($periode . "-15");
        // } else {
        //     $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
        //     $end            = date($periode . "-20");
        // }

        // addnew update
        if ($cutoff == 1) { // 21-20
            $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-20");
        } else if ($cutoff == 2) { // 16-15
            $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
            $end            = date($periode . "-15");
        } else { // 01-eom
            $start = date($periode . "-01");
            $end = date('Y-m-t', strtotime($periode . '-01'));
        }

        if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Direktur', 'Head', 'Manager'))) {
            $posisi = "'Direktur', 'Head', 'Manager', 'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Assistent Manager', 'Supervisor'))) {
            $posisi = "'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model_rekap_absen->get_sub_emp($department_id, $posisi, $employee_id);
        } else {
            $sub_emp = 0;
        }

        // $sub_emp_len    = strlen($sub_emp)-1;
        // $sub_emp        = substr($sub_emp,0,$sub_emp_len);

        $bulan          = $this->model_rekap_absen->get_periode($periode, $start, $end, 1)->result();
        $tanggal        = $this->model_rekap_absen->get_periode($periode, $start, $end, 0)->result();
        $absensi        = $this->model_rekap_absen->get_absensi($start, $end, $company_id, $department_id, $employee_id, $sub_emp, $periode, $cutoff)->result();

        $result[] = array(
            'ID User',
            'Employee',
            'Designation',
            'Department',
            'Location',
            'Date Of Joining',
            'Harus Hadir',
            'Total Hadir',
            'Periode',
        );

        $no = 1;
        foreach ($absensi as $abs) {

            $lebih_absen    = $abs->harus_hadir - $abs->total_hadir;
            $lebih_absen    = ($lebih_absen < 0) ? 0 : $lebih_absen;
            $kehadiran      = ($abs->harus_hadir < 1) ? 0 : round(($abs->total_hadir / $abs->harus_hadir) * 100);
            $kedisiplinan   = ($abs->harus_hadir < 1) ? 0 : round((($abs->total_hadir - $abs->telat - $abs->bolos - $abs->total_izin_pc_dt - $abs->absen_sekali) / $abs->harus_hadir) * 100);

            $result[] = array(
                $abs->user_id,
                $abs->employee,
                $abs->designation,
                $abs->department,
                $abs->location,
                $abs->date_of_joining,
                $abs->harus_hadir,
                $abs->total_hadir,
                $periode
            );
        }

        echo json_encode($result);
    }

    public function import_harus_hadir()
    {
        if (!empty($_FILES['attachment']['tmp_name'])) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                //checking image type
                $allowed =  array('xls', 'xlsx');
                $filename = $_FILES['attachment']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["attachment"]["tmp_name"];
                    // $profile = "/opt/lampp/htdocs/apps/assets/harus_hadir/";
                    $profile = "/var/www/trusmiverse/apps/assets/harus_hadir/";
                    // $profile = "/uploads/leave/";
                    $set_img = base_url() . "assets/harus_hadir/";
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $name = basename($_FILES["attachment"]["name"]);
                    $newfilename = 'harus_hadir_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($tmp_name, $profile . $newfilename);
                    $fname = $newfilename;
                } else {
                    $Return['error'] = '';
                }
            }
        } else {
            $fname = '';
        }

        $filename = $fname;
        include APPPATH . 'third_party/excel/PHPExcel.php';
        $excel = PHPExcel_IOFactory::load('./assets/harus_hadir/' . $filename);

        foreach ($excel->getWorksheetIterator() as $row) {
            $title          = $row->getTitle();
            $row_tertinggi  = $row->getHighestRow();

            $response['row_tertinggi'] = $row_tertinggi - 1;
            for ($i = 3; $i <= $row_tertinggi; $i++) {
                $employee_id   = $row->getCellByColumnAndRow(0, $i)->getValue();
                $harus_hadir   = $row->getCellByColumnAndRow(7, $i)->getValue();
                $periode       = $row->getCellByColumnAndRow(8, $i)->getValue();

                $cek = $this->model_rekap_absen->cek_harus_hadir($periode, $employee_id)->num_rows();

                if ($cek > 0) {
                    $update = array(
                        'harus_hadir'   => $harus_hadir
                    );

                    $this->db->where('employee_id', $employee_id);
                    $this->db->where('periode', $periode);
                    $result['update'] = $this->db->update('trusmi_harus_hadir', $update);
                } else {
                    $insert = array(
                        'employee_id'   => $employee_id,
                        'harus_hadir'   => $harus_hadir,
                        'periode'       => $periode,
                    );

                    $result['insert'] = $this->db->insert('trusmi_harus_hadir', $insert);
                }
            }
        }

        $result['status'] = true;

        echo json_encode($result);
    }
}
