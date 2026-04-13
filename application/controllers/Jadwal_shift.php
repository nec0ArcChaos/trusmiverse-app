<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// untuk upload
use PhpOffice\PhpSpreadsheet\IOFactory;

class Jadwal_shift extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->model('Model_jadwal_shift', 'model');
        $this->load->model('hr/model_rekap_absen', 'model_rekap_absen');

        if ($this->session->userdata('user_id') == "") {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content']            = "jadwal_shift/index";
        $data['pageTitle']          = "Jadwal Shift";
        $data['css']                = "jadwal_shift/css";
        $data['js']                 = "jadwal_shift/js";

        $data['tanggal_periode']  = $this->model_rekap_absen->tanggal_periode(1, 2)->result();
        $data['get_company']  = $this->model_rekap_absen->get_company()->result();
        $this->load->view("layout/main", $data);
    }

    public function list_jadwal_shift()
    {
        $department_id = $this->input->post('department');
        $periode       = $this->input->post('periode');
        $cutoff       = $this->input->post('cutoff');
        $data['data']                = $this->model->data_jadwal_shift($department_id, $periode, $cutoff);
        echo json_encode($data);

    }

    public function cek_jam_shift()
    {
        // $department_id = $this->input->post('department');
        $department_id = '';
        
        $data['data']                = $this->model->cek_jam_shift($department_id);
        echo json_encode($data);

    }

    public function export_excel()
    {
        $company_id    = $this->input->get('company_id');
        $department_id = $this->input->get('department_id');
        $periode_tb       = $this->input->get('periode'); // format: 2026-03
        $cutoff        = $this->input->get('cutoff');

        $year  = date('Y', strtotime($periode_tb));
        $month = date('m', strtotime($periode_tb));

        // ===============================
        // HITUNG START & END DATE
        // ===============================

        if ($cutoff == 1) {
            // 21 bulan sebelumnya - 20 bulan ini
            $start = date('Y-m-21', strtotime('-1 month', strtotime($periode_tb)));
            $end   = $year . '-' . $month . '-20';
        }

        elseif ($cutoff == 2) {
            // 16 bulan sebelumnya - 15 bulan ini
            $start = date('Y-m-16', strtotime('-1 month', strtotime($periode_tb)));
            $end   = $year . '-' . $month . '-15';
        }

        elseif ($cutoff == 3) {
            // 01 - akhir bulan
            $start = $year . '-' . $month . '-01';
            $end   = date("Y-m-t", strtotime($periode_tb));
        }


        $periode = $start.' to '.$end;
        $dates = $this->getDates($start,$end);

        $spreadsheet = new Spreadsheet();

        /*
        =============================
        SHEET 1 : DATA USER
        =============================
        */

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data');

        $sheet->setCellValue('A1','full_name');
        $sheet->setCellValue('B1','username');
        $sheet->setCellValue('C1','company_name');
        $sheet->setCellValue('D1','department_name');
        $sheet->setCellValue('E1','designation_name');
        $sheet->setCellValue('F1','periode');
        $sheet->setCellValue('G1','nama_hari');
        $sheet->setCellValue('H1','tanggal');
        $sheet->setCellValue('I1','shift');

        /*
        STYLE HEADER & KOLOM
        */

        $this->setHeaderStyle($sheet,'A1:I1');
        $this->setColumnWidth($sheet);

        $sheet->freezePane('A2');

        /*
        =============================
        DATA USER DARI DATABASE
        =============================
        */

        $users = $this->model->get_user_shift($department_id, $cutoff); // buat di model

        $row = 2;


        $designationList = [];
       foreach($users as $u)
        {

            foreach($dates as $date)
            {

                $sheet->setCellValue('A'.$row,$u->full_name);
                $sheet->setCellValue('B'.$row,$u->username);
                $sheet->setCellValue('C'.$row,$u->company_name);
                $sheet->setCellValue('D'.$row,$u->department_name);
                $sheet->setCellValue('E'.$row,$u->designation_name);
                $sheet->setCellValue('F'.$row,$periode);

                $designationList[] = $u->designation_id;

                $sheet->setCellValue(
                    'G'.$row,
                    $this->hariIndo($date)
                );

                $sheet->setCellValue(
                    'H'.$row,
                    $date
                );

                /*
                =============================
                DROPDOWN SHIFT
                =============================
                */

                $validation = $sheet->getCell('I'.$row)->getDataValidation();

                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);

                $validation->setFormula1('ShiftList!$A$2:$A$100');               
                // $validation->setFormula1('"'.$shiftList.'"');
                $row++;

            }

        }

        /*
        =============================
        SHEET 2 : MASTER SHIFT
        =============================
        */

        $shiftSheet = $spreadsheet->createSheet();
        $shiftSheet->setTitle('ShiftList');

        $shiftSheet->setCellValue('A1','shift');
        $shiftSheet->setCellValue('B1','senin');
        $shiftSheet->setCellValue('C1','selasa');
        $shiftSheet->setCellValue('D1','rabu');
        $shiftSheet->setCellValue('E1','kamis');
        $shiftSheet->setCellValue('F1','jumat');
        $shiftSheet->setCellValue('G1','sabtu');
        $shiftSheet->setCellValue('H1','minggu');

        $this->setHeaderStyle($shiftSheet,'A1:H1');
        $this->setColumnWidth($shiftSheet);


        $designationListString = implode(',', array_unique($designationList));
        $shifts = $this->model->get_shift($designationListString);

        $r = 2;

        foreach($shifts as $s)
        {
            $shiftSheet->setCellValue(
                'A'.$r,
                $s->shift_name . ' - ('.$s->office_shift_id.')'
            );
            $shiftSheet->setCellValue(
                'B'.$r,
                $s->senin
            );
            $shiftSheet->setCellValue(
                'C'.$r,
                $s->selasa
            );
            $shiftSheet->setCellValue(
                'D'.$r,
                $s->rabu
            );
            $shiftSheet->setCellValue(
                'E'.$r,
                $s->kamis
            );
            $shiftSheet->setCellValue(
                'F'.$r,
                $s->jumat
            );
            $shiftSheet->setCellValue(
                'G'.$r,
                $s->sabtu
            );
            $shiftSheet->setCellValue(
                'H'.$r,
                $s->minggu
            );
            $r++;
        }

        /*
        =============================
        DOWNLOAD EXCEL
        =============================
        */

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="template_jadwal_shift.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
        // echo $users;
    }

 

    private function getDates($start, $end)
    {
        $dates = [];

        $current = strtotime($start);
        $end = strtotime($end);

        while ($current <= $end)
        {
            $dates[] = date('Y-m-d', $current);
            $current = strtotime('+1 day', $current);
        }

        return $dates;
    }

    private function hariIndo($date)
    {
        $hari = [
            'Sunday'=>'Minggu',
            'Monday'=>'Senin',
            'Tuesday'=>'Selasa',
            'Wednesday'=>'Rabu',
            'Thursday'=>'Kamis',
            'Friday'=>'Jumat',
            'Saturday'=>'Sabtu'
        ];

        return $hari[date('l', strtotime($date))];
    }

    private function setHeaderStyle($sheet,$range)
    {

        $sheet->getStyle($range)->getFont()->setBold(true);

        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet->getStyle($range)->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('FFE7F3FF');

    }

    private function setColumnWidth($sheet)
    {

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(15);
        $sheet->getColumnDimension('I')->setWidth(20);

    }

    // public function upload_excel()
    // {

    //     if(!isset($_FILES['file']['name']) || $_FILES['file']['name'] == ''){
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'File tidak ditemukan'
    //         ]);
    //         return;
    //     }

    //     /*
    //     =========================
    //     SET PATH UPLOAD
    //     =========================
    //     */

    //     $upload_path = FCPATH.'assets/uploads/jadwalshift/';

    //     if(!is_dir($upload_path)){
    //         mkdir($upload_path,0777,true);
    //     }

    //     /*
    //     =========================
    //     RENAME FILE
    //     =========================
    //     */

    //     $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    //     $file_name = 'jadwalshift_'.date('YmdHis').'.'.$ext;

    //     $full_path = $upload_path.$file_name;

    //     /*
    //     =========================
    //     MOVE FILE
    //     =========================
    //     */

    //     if(!move_uploaded_file($_FILES['file']['tmp_name'],$full_path)){

    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'Upload gagal'
    //         ]);
    //         return;

    //     }

    //     /*
    //     =========================
    //     BACA EXCEL
    //     =========================
    //     */

    //     $spreadsheet = IOFactory::load($full_path);
    //     $rows = $spreadsheet->getActiveSheet()->toArray();

    //     /*
    //     ============================
    //     AMBIL DATA USER SEKALI
    //     ============================
    //     */

    //     $employees = $this->db->query("
    //         SELECT user_id,username
    //         FROM xin_employees
    //         WHERE is_active = 1
    //     ")->result();

    //     $userMap = [];

    //     foreach($employees as $e){
    //         $userMap[$e->username] = $e->user_id;
    //     }

    //     /*
    //     ============================
    //     AMBIL DATA SHIFT SEKALI
    //     ============================
    //     */

    //     $shifts = $this->db->query("
    //         SELECT *
    //         FROM xin_office_shift
    //     ")->result();

    //     $shiftMap = [];

    //     foreach($shifts as $s){
    //         $shiftMap[$s->office_shift_id] = $s;
    //     }

    //     /*
    //     ============================
    //     LOOP DATA EXCEL
    //     ============================
    //     */

    //     $insert = [];

    //     foreach($rows as $i => $row){

    //         if($i == 0) continue; // skip header

    //         $username = $row[1];
    //         $periode  = $row[5];
    //         $tanggal  = $row[7];
    //         $shift    = $row[8];

    //         if($username == '' || $tanggal == ''){
    //             continue;
    //         }

    //         if(!isset($userMap[$username])){
    //             continue;
    //         }

    //         $user_id = $userMap[$username];

    //         /*
    //         =====================
    //         AMBIL SHIFT ID
    //         =====================
    //         */

    //         $office_shift_id = null;
    //         $shift_in = null;
    //         $shift_out = null;

    //         if($shift != ''){

    //             preg_match('/\((.*?)\)/',$shift,$match);

    //             if(isset($match[1])){

    //                 $office_shift_id = $match[1];

    //                 if(isset($shiftMap[$office_shift_id])){

    //                     $shift_in  = $shiftMap[$office_shift_id]->monday_in_time;
    //                     $shift_out = $shiftMap[$office_shift_id]->monday_out_time;

    //                 }

    //             }

    //         }

    //         /*
    //         =====================
    //         CEK DUPLIKAT
    //         =====================
    //         */

    //         $cek = $this->db->query("
    //             SELECT id
    //             FROM t_jadwal_shift
    //             WHERE user_id = ?
    //             AND tanggal = ?
    //         ",[$user_id,$tanggal])->row();

    //         if($cek){
    //             continue;
    //         }

    //         /*
    //         =====================
    //         INSERT ARRAY
    //         =====================
    //         */

    //         // $periodes = date('Y-m', strtotime($tanggal));
    //         $range = $row[5];

    //         $tanggal_akhir = substr(trim($range), -10);

    //         $periodes = date('Y-m', strtotime($tanggal_akhir));

    //         $insert[] = [
    //             'user_id' => $user_id,
    //             'tanggal' => $tanggal,
    //             'office_shift_id' => $office_shift_id,
    //             'shift_in' => $shift_in,
    //             'shift_out' => $shift_out,
    //             'periode' => $periodes,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'created_by' => $this->session->userdata('user_id'),
    //             'file_upload' => $file_name,
    //         ];

    //     }

    //     /*
    //     ============================
    //     INSERT BATCH
    //     ============================
    //     */

    //     if(!empty($insert)){
    //         $this->db->insert_batch('t_jadwal_shift',$insert);
    //     }

    //     echo json_encode([
    //         'status' => true,
    //         'total_insert' => count($insert),
    //         'message' => 'Upload berhasil'
    //     ]);

    //     // echo "<pre>";
    //     // print_r($this->db->error());
    //     // exit;

    //     // echo json_encode([
    //     //     'status' => true,
    //     //     'message' => 'controller upload terpanggil',
    //     //     // 'data'      => $insert,

    //     // ]);

    // }

    // public function upload_excel2()
    // {

    //     if(!isset($_FILES['file']['name']) || $_FILES['file']['name'] == ''){
    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'File tidak ditemukan'
    //         ]);
    //         return;
    //     }

    //     /*
    //     =========================
    //     SET PATH UPLOAD
    //     =========================
    //     */

    //     $upload_path = FCPATH.'assets/uploads/jadwalshift/';

    //     if(!is_dir($upload_path)){
    //         mkdir($upload_path,0777,true);
    //     }

    //     /*
    //     =========================
    //     RENAME FILE
    //     =========================
    //     */

    //     $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    //     $file_name = 'jadwalshift_'.date('YmdHis').'.'.$ext;

    //     $full_path = $upload_path.$file_name;

    //     /*
    //     =========================
    //     MOVE FILE
    //     =========================
    //     */

    //     if(!move_uploaded_file($_FILES['file']['tmp_name'],$full_path)){

    //         echo json_encode([
    //             'status' => false,
    //             'message' => 'Upload gagal'
    //         ]);
    //         return;

    //     }

    //     /*
    //     =========================
    //     BACA EXCEL
    //     =========================
    //     */

    //     $spreadsheet = IOFactory::load($full_path);
    //     $rows = $spreadsheet->getActiveSheet()->toArray();

    //     /*
    //     ============================
    //     AMBIL DATA USER SEKALI
    //     ============================
    //     */

    //     $employees = $this->db->query("
    //         SELECT user_id,username
    //         FROM xin_employees
    //         WHERE is_active = 1
    //     ")->result();

    //     $userMap = [];

    //     foreach($employees as $e){
    //         $userMap[$e->username] = $e->user_id;
    //     }

    //     /*
    //     ============================
    //     AMBIL DATA SHIFT SEKALI
    //     ============================
    //     */

    //     $shifts = $this->db->query("
    //         SELECT *
    //         FROM xin_office_shift
    //     ")->result();

    //     $shiftMap = [];

    //     foreach($shifts as $s){
    //         $shiftMap[$s->office_shift_id] = $s;
    //     }

    //     /*
    //     ============================
    //     LOOP DATA EXCEL
    //     ============================
    //     */

    //     $insert = [];

    //     foreach($rows as $i => $row){

    //         if($i == 0) continue; // skip header

    //         $username = $row[1];
    //         $periode  = $row[5];
    //         $tanggal  = $row[7];
    //         $shift    = $row[8];

    //         /*
    //         =====================
    //         CEK USER
    //         =====================
    //         */

    //         if(!isset($userMap[$username])){
    //             $skip_user++;
    //             continue;
    //         }

    //         $user_id = $userMap[$username];

    //          /*
    //         =====================
    //         CEK SHIFT
    //         =====================
    //         */

    //         if($shift == ''){
    //             $skip_shift++;
    //             continue;
    //         }

    //          /*
    //         =====================
    //         AMBIL SHIFT ID
    //         =====================
    //         */

    //         $office_shift_id = null;
    //         $shift_in = null;
    //         $shift_out = null;

    //         preg_match('/\((.*?)\)/',$shift,$match);

    //         if(!isset($match[1])){
    //             $skip_shift++;
    //             continue;
    //         }

    //         $office_shift_id = $match[1];

    //         if(!isset($shiftMap[$office_shift_id])){
    //             $skip_shift++;
    //             continue;
    //         }

    //         $shift_in  = $shiftMap[$office_shift_id]->monday_in_time;
    //         $shift_out = $shiftMap[$office_shift_id]->monday_out_time;

    //         /*
    //         =====================
    //         CEK DUPLIKAT
    //         =====================
    //         */

    //         $cek = $this->db->query("
    //             SELECT id
    //             FROM t_jadwal_shift
    //             WHERE user_id = ?
    //             AND tanggal = ?
    //         ",[$user_id,$tanggal])->row();

    //         if($cek){
    //             $skip_dup++;
    //             continue;
    //         }

    //         /*
    //         =====================
    //         INSERT ARRAY
    //         =====================
    //         */

    //         // $periodes = date('Y-m', strtotime($tanggal));
    //         $range = $row[5];

    //         $tanggal_akhir = substr(trim($range), -10);

    //         $periodes = date('Y-m', strtotime($tanggal_akhir));

    //         $insert[] = [
    //             'user_id' => $user_id,
    //             'tanggal' => $tanggal,
    //             'office_shift_id' => $office_shift_id,
    //             'shift_in' => $shift_in,
    //             'shift_out' => $shift_out,
    //             'periode' => $periodes,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'created_by' => $this->session->userdata('user_id'),
    //             'file_upload' => $file_name,
    //         ];

    //     }

    //     /*
    //     ============================
    //     INSERT BATCH
    //     ============================
    //     */

    //     if(!empty($insert)){
    //         $this->db->insert_batch('t_jadwal_shift',$insert);
    //     }

    //     echo json_encode([
    //         'status' => true,
    //         'total_insert' => count($insert),
    //         'skip_shift' => $skip_shift,
    //         'skip_user' => $skip_user,
    //         'skip_duplicate' => $skip_dup,
    //         'message' => 'Upload berhasil'
    //     ]);

    //     // echo "<pre>";
    //     // print_r($this->db->error());
    //     // exit;

    //     // echo json_encode([
    //     //     'status' => true,
    //     //     'message' => 'controller upload terpanggil',
    //     //     // 'data'      => $insert,

    //     // ]);

    // }

    public function upload_excel()
    {

        if(!isset($_FILES['file']['name']) || $_FILES['file']['name'] == ''){
            echo json_encode([
                'status' => false,
                'message' => 'File tidak ditemukan'
            ]);
            return;
        }

        /*
        =========================
        PATH UPLOAD
        =========================
        */

        $upload_path = FCPATH.'assets/uploads/jadwalshift/';

        if(!is_dir($upload_path)){
            mkdir($upload_path,0777,true);
        }

        $ext  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $file_name = 'jadwalshift_'.date('YmdHis').'.'.$ext;
        $full_path = $upload_path.$file_name;

        if(!move_uploaded_file($_FILES['file']['tmp_name'],$full_path)){
            echo json_encode([
                'status' => false,
                'message' => 'Upload gagal'
            ]);
            return;
        }

        /*
        =========================
        BACA EXCEL
        =========================
        */

        $spreadsheet = IOFactory::load($full_path);
        $rows = $spreadsheet->getActiveSheet()->toArray();

        /*
        =========================
        MASTER USER
        =========================
        */

        $employees = $this->db->query("
            SELECT user_id, username
            FROM xin_employees
            WHERE is_active = 1
        ")->result();

        $userMap = [];
        foreach($employees as $e){
            $userMap[trim($e->username)] = $e->user_id;
        }

        /*
        =========================
        MASTER SHIFT
        =========================
        */

        $shifts = $this->db->query("
            SELECT *
            FROM xin_office_shift
        ")->result();

        $shiftMap = [];
        foreach($shifts as $s){
            $shiftMap[$s->office_shift_id] = $s;
        }

        /*
        =========================
        AMBIL DUPLICATE SEKALI
        =========================
        */

        $tanggalList = [];

        foreach($rows as $i => $row){

            if($i == 0) continue;

            $tanggal = trim($row[7]);

            if($tanggal != ''){
                $tanggalList[] = $tanggal;
            }
        }

        $tanggalList = array_unique($tanggalList);

        $duplicateMap = [];

        if(!empty($tanggalList)){

            $this->db->where_in('tanggal',$tanggalList);
            $dup = $this->db->get('t_jadwal_shift')->result();

            foreach($dup as $d){
                $duplicateMap[$d->user_id.'_'.$d->tanggal] = true;
            }
        }

        /*
        =========================
        LOOP EXCEL
        =========================
        */

        $insert = [];

        $skip_shift = 0;
        $skip_user  = 0;
        $skip_dup   = 0;

        foreach($rows as $i => $row){

            if($i == 0) continue;

            $username = trim($row[1]);
            $range    = trim($row[5]);
            $tanggal  = trim($row[7]);
            $shift    = trim($row[8]);

            if($username == '' || $tanggal == ''){
                continue;
            }

            /*
            =========================
            USER
            =========================
            */

            if(!isset($userMap[$username])){
                $skip_user++;
                continue;
            }

            $user_id = $userMap[$username];

            /*
            =========================
            SHIFT
            =========================
            */

            if($shift == ''){
                $skip_shift++;
                continue;
            }

            preg_match('/\((.*?)\)/',$shift,$match);

            if(!isset($match[1])){
                $skip_shift++;
                continue;
            }

            $office_shift_id = $match[1];

            if(!isset($shiftMap[$office_shift_id])){
                $skip_shift++;
                continue;
            }

            $shift_in  = $shiftMap[$office_shift_id]->monday_in_time;
            $shift_out = $shiftMap[$office_shift_id]->monday_out_time;

            /*
            =========================
            DUPLICATE CHECK
            =========================
            */

            $key = $user_id.'_'.$tanggal;

            if(isset($duplicateMap[$key])){
                $skip_dup++;
                continue;
            }

            /*
            =========================
            PERIODE
            =========================
            */

            $tanggal_akhir = substr($range,-10);
            $periode = date('Y-m',strtotime($tanggal_akhir));

            /*
            =========================
            INSERT ARRAY
            =========================
            */

            $insert[] = [
                'user_id' => $user_id,
                'tanggal' => $tanggal,
                'office_shift_id' => $office_shift_id,
                // 'shift_in' => $shift_in,
                // 'shift_out' => $shift_out,
                'periode' => $periode,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'file_upload' => $file_name,
            ];

        }

        /*
        =========================
        INSERT BATCH
        =========================
        */

        if(!empty($insert)){
            $this->db->insert_batch('t_jadwal_shift',$insert);
        }

        /*
        =========================
        RESPONSE
        =========================
        */

        echo json_encode([
            'status' => true,
            'total_insert' => count($insert),
            'skip_shift' => $skip_shift,
            'skip_user' => $skip_user,
            'skip_duplicate' => $skip_dup,
            'message' => 'Upload selesai'
        ]);

    }

    public function get_shift(){

        // $shift = $this->db->get('mst_shift')->result();
        $designationListString = $this->input->post('designation_id');
        $shift                = $this->model->get_shift($designationListString);

        echo json_encode($shift);

    }

    public function update_shift(){

        $id_jadwal = $this->input->post('id_jadwal');
        $shift_id  = $this->input->post('shift_id');

        $this->db->where('id',$id_jadwal);
        $update = $this->db->update('t_jadwal_shift',[
            'office_shift_id'=>$shift_id
        ]);

        echo json_encode([
            'status'=>$update ? true : false
        ]);

    }
}