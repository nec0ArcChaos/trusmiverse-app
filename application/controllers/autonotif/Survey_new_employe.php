<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Survey_new_employe extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library('FormatJson');
        $this->load->library('WAJS');
    }

    function broadcast(){
        $query = "SELECT
                emp.user_id,
                CONCAT(emp.first_name,' ',emp.last_name) AS nama,
                des.designation_name,
                dep.department_name,
                comp.`name` AS company_name,
                emp.contact_no,
                emp.date_of_joining,
                DATEDIFF(CURDATE(),emp.date_of_joining) AS date_diff
                FROM
                xin_employees emp
                    LEFT JOIN xin_departments dep ON dep.department_id = emp.department_id
                    LEFT JOIN xin_designations des ON des.designation_id = emp.designation_id
                    LEFT JOIN xin_companies comp ON comp.company_id = emp.company_id
                WHERE DATEDIFF(CURDATE(),emp.date_of_joining) = 7";
        $data = $this->db->query($query)->result();


        foreach ($data as $item) {
            $msg = "*📢 INFORMASI WAJIB UNTUK KARYAWAN BARU (JOIN < 1 BULAN)*

Kepada Bapak/ibu/sdr/i.

Nama : *$item->nama*
Jabatan : *$item->designation_name*
Department : *$item->department_name*
Company : *$item->company_name*

Bagi seluruh karyawan yang baru bergabung dalam 1 bulan terakhir, mohon perhatian untuk segera mengisi Survey Evaluasi Kerja 1 Bulan Pertama 

*Tujuan Survey:*
Untuk memastikan bahwa kamu telah:
1️⃣ Menerima target kerja dari atasan
2️⃣ Memahami standar kerja & SOP yang berlaku
3️⃣ Mendapatkan arahan dan bimbingan dari atasan langsung
4️⃣ Menerima fasilitas kerja sesuai dukungan dari perusahaan

⏰ Batas waktu pengisian: Maksimal 3 hari sejak pesan ini diterima
❗️Jika hingga hari ke-3 survey belum diisi, maka karyawan tidak dapat melakukan absen pulang sebelum menyelesaikan pengisian survey

*Link survey:* https://bit.ly/4iT6j3G
Bila ada pertanyaan, silakan hubungi kami

Terima kasih atas perhatiannya dan kerjasama yang baik!😊 
Tetap semangat & sukses menjalani masa adaptasi!🔥";
            // $this->send_wa('083824955357', $msg, 5203);
            $this->send_wa($item->contact_no, $msg, $item->user_id);
        }
    }

    function send_wa($phone, $msg, $user_id = '')
    {
        try {
            // $this->load->library('WAJS');
            return $this->wajs->send_wajs_notif($phone, $msg, 'text', 'trusmiverse', $user_id);
        } catch (\Throwable $th) {
            return "Server WAJS Error";
        }
    }
}
