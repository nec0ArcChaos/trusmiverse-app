<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_report_tkb extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function detail_budget($y, $m)
    {
        $month = $y . '-' . $m;
        $sql = "SELECT
        e_pengajuan.id_pengajuan,
        lpj.id_lpj,
        e_pengajuan.id_biaya,
        e_pengajuan.id_divisi,
        e_pengajuan.id_kategori,
        COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS `username`,
        SUBSTR( e_pengajuan.created_at, 1, 16 ) AS created_at,
        SUBSTR( e_approval.update_approve, 1, 16 ) AS tgl_approve,
        e_pengajuan.nama_penerima,
        e_kategori.nama_kategori,
        e_jenis_biaya.jenis AS keperluan,
        e_tipe_pembayaran.nama_tipe,
        e_budget.budget,
        e_pengajuan.note AS note_fnc,
        detail.note AS note_user,
        e_m_status.nama_status,
        detail.nominal_uang,
        CASE
            WHEN lpj.id_lpj IS NULL AND e_kategori.nama_kategori = 'Reimbursment'
						THEN
						'Tidak Perlu LPJ'
						WHEN lpj.id_lpj IS NULL
						THEN
            'Belum LPJ'
						ELSE 'Sudah LPJ' 
        END AS status_lpj,
        lpj.tgl_lpj AS tanggal_lpj,
        lpj2.nominal_lpj,
        detail.nominal_uang - lpj2.nominal_lpj AS deviasi,
        lpj.nama_status AS approval_lpj,
        lpj2.nominal_lpj AS actual_budget,
        COALESCE(lpj2.nominal_lpj, detail.nominal_uang) AS cash_out,
        CONCAT(em.first_name,' ',em.last_name) AS pengaju,
        dep.department_name as department
        FROM
        e_eaf.e_pengajuan
        LEFT JOIN hris.xin_employees AS usr ON usr.user_id = e_pengajuan.id_user
        LEFT JOIN hris.xin_employees as em ON em.user_id = e_pengajuan.pengaju
        LEFT JOIN hris.xin_departments as dep ON dep.department_id = em.department_id
        LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status`
        LEFT JOIN e_eaf.e_kategori ON e_kategori.id_kategori = e_pengajuan.id_kategori
        LEFT JOIN e_eaf.e_tipe_pembayaran ON e_tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
        LEFT JOIN e_eaf.e_jenis_biaya ON e_jenis_biaya.id_jenis = e_pengajuan.jenis
        LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = e_pengajuan.budget
        LEFT JOIN e_eaf.e_detail_keperluan AS detail ON detail.id_pengajuan = e_pengajuan.id_pengajuan
        LEFT JOIN (
        SELECT
            lpj.id_pengajuan AS id_lpj,
            SUBSTR( lpj.created_at, 1, 16 ) AS tgl_lpj,
            header_lpj.id_pengajuan,
            header_lpj.note_lpj,
            e_m_status.nama_status 
        FROM
            e_eaf.e_pengajuan AS lpj
        LEFT JOIN ( SELECT Max( e_header_lpj.id_lpj ) AS id_lpj, e_header_lpj.id_pengajuan, e_header_lpj.note_lpj FROM e_eaf.e_header_lpj GROUP BY e_header_lpj.id_pengajuan ) AS header_lpj ON header_lpj.id_lpj = lpj.id_pengajuan
        LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = lpj.`status` 
        WHERE
        id_kategori = 19
            ) AS lpj ON lpj.id_pengajuan = e_pengajuan.id_pengajuan
            LEFT JOIN ( SELECT id_pengajuan AS id_lpj, total_pengajuan AS nominal_lpj FROM e_eaf.e_pengajuan WHERE id_kategori = 19 ) AS lpj2 ON e_pengajuan.temp = lpj2.id_lpj
            LEFT JOIN e_eaf.e_approval ON e_pengajuan.id_pengajuan = e_approval.id_pengajuan 
            AND e_approval.`level` = 5 AND  e_approval.`status` = 'Approve'
        WHERE
        e_eaf.e_jenis_biaya.id_jenis IN (98,99,111,112,114,137,138,139,140,147,166)
        AND SUBSTR( e_approval.update_approve, 1, 7 ) = '$month'
        AND e_pengajuan.flag != 'LPJ'
        AND e_pengajuan.`status` = 3";

        return $this->db->query($sql);
    }
}
