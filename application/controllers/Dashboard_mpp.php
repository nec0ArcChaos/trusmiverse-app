<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_mpp extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_dashboard_mpp', 'model');
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
        $data['pageTitle']  = "Dashboard MPP";
        $data['css']        = "dashboard_mpp/css";
        $data['js']         = "dashboard_mpp/js";
        $data['content']    = "dashboard_mpp/index";

        $data['get_company']  = $this->model->get_company()->result();

        if (isset($_GET['company'])) {

            $company = $_GET['company'];
            $department = $_GET['department'];

            if ($company != 0) {
                $company_name = $this->db->query("SELECT xin_companies.`name` FROM xin_companies WHERE company_id='$company'")->row()->name;
            } else {
                $company_name = "All Companies";
            }
            $data['company_name'] = $company_name;

            if ($department != 0) {
                $department_name = $this->db->query("SELECT xin_departments.`department_name` FROM xin_departments WHERE department_id='$department'")->row()->department_name;
            } else {
                $department_name = "All Departments";
            }
            $data['department_name'] = $department_name;

            $dt_jumlah_karyawan = $this->model->dt_jumlah_karyawan_by_status($company, $department)->result();

            // KARTAP
            $jumlah_kartap = (isset($dt_jumlah_karyawan[0]->active_employees)) ? $dt_jumlah_karyawan[0]->active_employees : 0;
            $data['jumlah_kartap'] = $jumlah_kartap;

            $data['leader_below_kartap'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 1, 'reguler', 'below');
            $data['leader_up_kartap'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 1, 'reguler', 'up');

            $data['kartap_staff'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Staff', $company, $department);
            $data['kartap_officer'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Officer', $company, $department);
            $data['kartap_spv'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Supervisor', $company, $department);
            $data['kartap_manager'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Manager', $company, $department);
            $data['kartap_head'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Head', $company, $department);
            $data['kartap_direktur'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Direktur', $company, $department);

            // KONTRAK
            $jumlah_kontrak = (isset($dt_jumlah_karyawan[1]->active_employees)) ? $dt_jumlah_karyawan[1]->active_employees : 0;

            $data['jumlah_kontrak_all'] = $jumlah_kontrak; // Kontrak reguler

            $data['leader_below_reguler_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 2, 'reguler', 'below');
            $data['leader_up_reguler_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 2, 'reguler', 'up');

            $data['kontrak_helper'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Helper', $company, $department);
            $data['kontrak_staff'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Staff', $company, $department);
            $data['kontrak_officer'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Officer', $company, $department);
            $data['kontrak_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Supervisor', $company, $department);
            $data['kontrak_manager'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Manager', $company, $department);
            $data['kontrak_head'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Head', $company, $department);
            $data['kontrak_direktur'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Direktur', $company, $department);

            // NON KONTRAK
            $jumlah_non_kontrak = (isset($dt_jumlah_karyawan[2]->active_employees)) ? $dt_jumlah_karyawan[2]->active_employees : 0;
            $data['jumlah_non_kontrak'] = $jumlah_non_kontrak;
            $data['leader_below_non_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 3, '', 'below');
            $data['leader_up_non_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 3, '', 'up');

            $data['non_kontrak_helper'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Helper', $company, $department);
            $data['non_kontrak_staff'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Staff', $company, $department);
            $data['non_kontrak_officer'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Officer', $company, $department);
            $data['non_kontrak_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Supervisor', $company, $department);
            $data['non_kontrak_manager'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Manager', $company, $department);
            $data['non_kontrak_head'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Head', $company, $department);
            $data['non_kontrak_direktur'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Direktur', $company, $department);

            // PERJANJIAN
            $jumlah_perjanjian = (isset($dt_jumlah_karyawan[3]->active_employees)) ? $dt_jumlah_karyawan[3]->active_employees : 0;
            $data['jumlah_perjanjian'] = $jumlah_perjanjian;
            $data['leader_below_perjanjian'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 4, '', 'below');
            $data['leader_up_perjanjian'] = $this->model->dt_jumlah_karyawan_by_kategori_level($company, $department, 4, '', 'up');

            $data['perjanjian_helper'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Helper', $company, $department);
            $data['perjanjian_staff'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Staff', $company, $department);
            $data['perjanjian_officer'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Officer', $company, $department);
            $data['perjanjian_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Supervisor', $company, $department);
            $data['perjanjian_manager'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Manager', $company, $department);
            $data['perjanjian_head'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Head', $company, $department);
            $data['perjanjian_direktur'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Direktur', $company, $department);
        } else {

            $data['company_name'] = "All Companies";
            $data['department_name'] = "All Departments";

            // Data Jumlah karyawan All Company All Department
            $dt_jumlah_karyawan = $this->model->dt_jumlah_karyawan_by_status()->result();

            // Jumlah karyawan tetap all
            $jumlah_kartap_all = $dt_jumlah_karyawan[0]->active_employees;
            $data['jumlah_kartap'] = $jumlah_kartap_all;

            $data['leader_below_kartap'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 1, 'reguler', 'below');
            $data['leader_up_kartap'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 1, 'reguler', 'up');

            $data['kartap_staff'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Staff');
            $data['kartap_officer'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Officer');
            $data['kartap_spv'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Supervisor');
            $data['kartap_manager'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Manager');
            $data['kartap_head'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Head');
            $data['kartap_direktur'] = $this->model->dt_jumlah_karyawan_by_level(1, 'Direktur');
            // $levels = $this->model->dt_jumlah_karyawan_by_level2(1)->result();
            // $data['kartap_staff'] = $levels[4]->active_employees;
            // $data['kartap_officer'] = $levels[3]->active_employees;
            // $data['kartap_spv'] = $levels[5]->active_employees;
            // $data['kartap_manager'] = $levels[2]->active_employees;
            // $kartap_head = $levels[1]->active_employees;
            // $kartap_direktur = $levels[0]->active_employees;
            // $data['kartap_gm'] = $kartap_head + $kartap_direktur;

            // Jumlah karyawan kontrak all
            $jumlah_kontrak = $dt_jumlah_karyawan[1]->active_employees;

            $data['jumlah_kontrak_all'] = $jumlah_kontrak; // Kontrak reguler

            $data['leader_below_reguler_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 2, 'reguler', 'below');
            $data['leader_up_reguler_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 2, 'reguler', 'up');

            $data['kontrak_helper'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Helper');
            $data['kontrak_staff'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Staff');
            $data['kontrak_officer'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Officer');
            $data['kontrak_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Supervisor');
            $data['kontrak_manager'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Manager');
            $data['kontrak_head'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Head');
            $data['kontrak_direktur'] = $this->model->dt_jumlah_karyawan_by_level(2, 'Direktur');

            // Non Kontrak
            $jumlah_non_kontrak = $dt_jumlah_karyawan[2]->active_employees;
            $data['jumlah_non_kontrak'] = $jumlah_non_kontrak;
            $data['leader_below_non_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 3, '', 'below');
            $data['leader_up_non_kontrak'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 3, '', 'up');

            $data['non_kontrak_helper'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Helper');
            $data['non_kontrak_staff'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Staff');
            $data['non_kontrak_officer'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Officer');
            $data['non_kontrak_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Supervisor');
            $data['non_kontrak_manager'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Manager');
            $data['non_kontrak_head'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Head');
            $data['non_kontrak_direktur'] = $this->model->dt_jumlah_karyawan_by_level(3, 'Direktur');

            // Perjanjian
            $jumlah_perjanjian = $dt_jumlah_karyawan[3]->active_employees;
            $data['jumlah_perjanjian'] = $jumlah_perjanjian;
            $data['leader_below_perjanjian'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 4, '', 'below');
            $data['leader_up_perjanjian'] = $this->model->dt_jumlah_karyawan_by_kategori_level(0, 0, 4, '', 'up');

            $data['perjanjian_helper'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Helper');
            $data['perjanjian_staff'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Staff');
            $data['perjanjian_officer'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Officer');
            $data['perjanjian_supervisor'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Supervisor');
            $data['perjanjian_manager'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Manager');
            $data['perjanjian_head'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Head');
            $data['perjanjian_direktur'] = $this->model->dt_jumlah_karyawan_by_level(4, 'Direktur');
        }

        $this->load->view('layout/main', $data);
    }

    public function dt_karyawan()
    {
        $contract_type = $_POST['contract_type'];
        $category_level = $_POST['category_level'];
        $level = $_POST['level'];
        $company_id = $_POST['company_id'];
        $department_id = $_POST['department_id'];

        $data['data'] = $this->model->dt_karyawan($contract_type, $category_level, $level, $company_id, $department_id)->result();

        echo json_encode($data);
    }

    public function get_department()
    {
        $company_id     = $_POST['company_id'];
        $data           = $this->model->get_department($company_id)->result();

        echo json_encode($data);
    }

    public function get_jumlah_karyawan()
    {
        $company_id     = (isset($_POST['company_id'])) ? $_POST['company_id'] : $this->session->userdata('company_id');
        $department_id  = (isset($_POST['department_id'])) ? $_POST['department_id'] : $this->session->userdata('department_id');

        echo '<table id="dt_jumlah_karyawan" class="table table-sm table-striped table-bordered nowrap" style="width:100%">';
        echo '<thead>';
        echo '<tr>';
        echo '<th rowspan="2">No</th>';
        echo '<th rowspan="2">Employee</th>';
        echo '<th rowspan="2">Designation</th>';
        echo '<th rowspan="2">Department</th>';
        echo '<th rowspan="2">Location</th>';
        echo '<th rowspan="2">Date Of Joining</th>';
        echo '<th rowspan="2">Last Present</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        echo '</tbody>';
        echo '</table>';
    }

    public function excel($company_id, $department_id, $employee_id, $periode)
    {
        $company_id     = ($company_id == 'undefined') ? $this->session->userdata('company_id') : $company_id;
        $department_id  = ($department_id == 'undefined') ? $this->session->userdata('department_id') : $department_id;
        $employee_id    = ($employee_id == 'undefined') ? $this->session->userdata('user_id') : $employee_id;

        if ($company_id == 3) {
            $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
            $end            = date($periode . "-15");
        } else {
            $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
            $end            = date($periode . "-20");
        }

        if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Direktur', 'Head', 'Manager'))) {
            $posisi = "'Direktur', 'Head', 'Manager', 'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model->get_sub_emp($department_id, $posisi, $employee_id);
        } else if ($this->session->userdata('user_role_id') != 1 && in_array($this->session->userdata('posisi'), array('Assistent Manager', 'Supervisor'))) {
            $posisi = "'Assistent Manager', 'Supervisor', 'Officer', 'Staff', 'Helper'";
            $sub_emp = $this->model->get_sub_emp($department_id, $posisi, $employee_id);
        } else {
            $sub_emp = 0;
        }

        // $sub_emp_len    = strlen($sub_emp)-1;
        // $sub_emp        = substr($sub_emp,0,$sub_emp_len);

        $bulan          = $this->model->get_periode($periode, $start, $end, 1)->result();
        $tanggal        = $this->model->get_periode($periode, $start, $end, 0)->result();
        $absensi        = $this->model->get_absensi($start, $end, $company_id, $department_id, $employee_id, $sub_emp)->result();

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
}
