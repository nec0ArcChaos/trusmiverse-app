<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_report extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function report($y, $m)
    {
        $id_user     = $this->session->userdata('user_id');
    
        $month = $y . '-' . $m;
        $cek_param = $this->get_e_parameter(8, $id_user)->row_array();

        if ($id_user == 1) {
            $kondisi = "";
        } else if ($cek_param['id'] != Null) {
            $kondisi = "";
        } else {
            $kondisi = "AND budget.id_user_approval = $id_user";
        }

        $sql = "SELECT
        e_biaya.id_budget,
        e_company.company_kode,
        e_biaya.id_biaya,
        e_biaya.nama_biaya,
        budget.employee_name AS user,
		e_biaya.minggu,
        e_biaya.budget_awal,
        COALESCE ( tambahan.nominal_tambah, 0 ) AS nominal_tambah,
        (
        e_biaya.budget_awal + COALESCE ( tambahan.nominal_tambah, 0 )) - COALESCE ( m_0.total, 0 ) AS sisa,
        CASE
			WHEN m_0.total > (e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0))
			THEN abs((e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0)) - m_0.total)
        END AS total_over_budget,
        t_s.total_sisa AS total_sisa,
        m_0.rembers,
        m_0.belum_lpj,
        m_0.sudah_lpj,
        m_0.sudah_lpj + m_0.rembers AS act_budget,
        m_0.total AS actual_m0,
		ROUND((m_0.sudah_lpj + m_0.rembers)/(e_biaya.budget_awal+COALESCE (tambahan.nominal_tambah, 0))*100,0) AS presentase
    FROM
        e_eaf.e_biaya
        LEFT JOIN e_eaf.e_company ON e_company.company_id = e_biaya.company_id
        LEFT JOIN (
        SELECT
            id_pengajuan,
            id_biaya,
            SUM( total ) AS total,
            SUM( IF ( id_kategori = 17, total_pengajuan_eaf, 0 ) ) AS rembers,
            SUM( IF ( id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0 ) ) AS belum_lpj,
            SUM( IF ( id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE ( total_pengajuan_lpj, total_pengajuan_eaf ), 0 ) ) AS sudah_lpj 
        FROM
            (
            SELECT
                e_pengajuan.id_pengajuan,
                approval.update_approve AS update_approve,
                e_pengajuan.id_biaya AS id_biaya,
                lpj.created_at AS tgl_LPJ,
                lpj.id_lpj,
                e_pengajuan.id_kategori,
                lpj.total_pengajuan AS total_pengajuan_lpj,
                e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                COALESCE ( lpj.total_pengajuan, e_pengajuan.total_pengajuan ) AS total 
            FROM
                e_eaf.`e_pengajuan`
                LEFT JOIN ( SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf.e_pengajuan WHERE id_kategori = 19 ) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                LEFT JOIN ( SELECT id_pengajuan, update_approve 
                    FROM e_eaf.e_approval WHERE 
                    -- id_user_approval = 737 AND 
                    e_approval.`level` = 5
                    AND `status` = 'Approve'
                ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan 
            WHERE
                substr( approval.update_approve, 1, 7 ) = '$month' 
                AND e_pengajuan.`status` = 3 
            ) x 
        GROUP BY
            id_biaya 
        ) AS m_0 ON m_0.id_biaya = e_biaya.id_biaya
        LEFT JOIN (
        SELECT
            id_budget,
            SUM(
            IF
            ( budget < 0, budget, 0 )) AS over_budget 
        FROM
            e_eaf.e_biaya 
        WHERE
            bulan = 09 
            AND tahun_budget = 2021 
        ) AS o_b ON o_b.id_budget = e_biaya.id_budget
        LEFT JOIN (
        SELECT
            id_budget,
            SUM(
            IF
            ( budget > 0, budget, 0 )) AS total_sisa 
        FROM
            e_eaf.e_biaya 
        WHERE
            bulan = 09 AND tahun_budget = 2021 
        ) AS t_s ON t_s.id_budget = e_biaya.id_budget
        LEFT JOIN (
        SELECT
            e_jenis_biaya.id_budget,
            e_jenis_biaya.id_user_approval,
            COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS `employee_name`
        FROM
            e_eaf.e_jenis_biaya
            JOIN hris.xin_employees AS usr ON e_jenis_biaya.id_user_approval = usr.user_id

        ) AS budget ON e_biaya.id_budget = budget.id_budget
        LEFT JOIN (
        SELECT
            e_biaya_penambahan.id_biaya,
            SUM( e_biaya_penambahan.nominal_tambah ) AS nominal_tambah 
        FROM
            e_eaf.e_biaya_penambahan 
        WHERE
            e_biaya_penambahan.bulan = $m
            AND e_biaya_penambahan.tahun = $y
        GROUP BY
            e_biaya_penambahan.id_biaya,
            e_biaya_penambahan.bulan,
            e_biaya_penambahan.tahun 
        ) AS tambahan ON tambahan.id_biaya = e_biaya.id_biaya 
        WHERE
		bulan = $m
        AND tahun_budget = $y
        $kondisi
        GROUP BY id_biaya";

        return $this->db->query($sql);
    }

    function detail_budget($id_biaya, $y, $m)
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
        e_pengajuan.id_biaya = $id_biaya
        AND SUBSTR( e_approval.update_approve, 1, 7 ) = '$month'
        AND e_pengajuan.flag != 'LPJ'
        AND e_pengajuan.`status` = 3";

        return $this->db->query($sql);
    }

    function report_eaf($startdate, $enddate, $id_kategori, $tipe)
    {
        if ($tipe == 1) { // Sudah LPJ
            // $where1 = "AND lpj.id_pengajuan IS NOT NULL";
            // $where = "AND lpj.id_pengajuan IS NOT NULL";
            $where = "AND lpj.id_pengajuan IS NOT NULL";
        } else if ($tipe == 2) { // Belum LPJ
            // $where1 = "AND lpj.id_pengajuan IS NULL";
            $where = "AND lpj.id_pengajuan IS NULL";
        } else if ($tipe == 3) { // > 2 Hari
            $where1 = "";
            $where = "AND (
                        TIMESTAMPDIFF(HOUR, apr.update_approve, COALESCE ( lpj.tgl_input, NOW() ) ) - (
                        SELECT
                            COUNT( holidays.id ) * 24 AS total 
                        FROM
                            (
                            SELECT
                                x.id,
                                x.date 
                            FROM
                                (
                                SELECT
                                    h.holiday_id AS id,
                                    h.start_date AS date 
                                FROM
                                    hris.xin_holidays AS h UNION ALL
                                SELECT
                                    w.weekend_id,
                                    w.weekend_date 
                                FROM
                                    hris.trusmi_weekend AS w 
                                WHERE
                                    w.weekend_name = 'Sunday' 
                                ) AS x 
                            GROUP BY
                                x.date 
                            ) AS holidays 
                        WHERE
                            holidays.date BETWEEN DATE( apr.update_approve ) 
                            AND COALESCE ( DATE( lpj.tgl_input ), CURDATE( ) ) 
                        ) 
                    ) > 48";
        } else if ($tipe == 4) { // > 2 Hari belum LPJ
            $where1 = "";
            $where = "AND (
                        TIMESTAMPDIFF(HOUR, apr.update_approve, COALESCE ( lpj.tgl_input, NOW() ) ) - (
                        SELECT
                            COUNT( holidays.id ) * 24 AS total 
                        FROM
                            (
                            SELECT
                                x.id,
                                x.date 
                            FROM
                                (
                                SELECT
                                    h.holiday_id AS id,
                                    h.start_date AS date 
                                FROM
                                    hris.xin_holidays AS h UNION ALL
                                SELECT
                                    w.weekend_id,
                                    w.weekend_date 
                                FROM
                                    hris.trusmi_weekend AS w 
                                WHERE
                                    w.weekend_name = 'Sunday' 
                                ) AS x 
                            GROUP BY
                                x.date 
                            ) AS holidays 
                        WHERE
                            holidays.date BETWEEN DATE( apr.update_approve ) 
                            AND COALESCE ( DATE( lpj.tgl_input ), CURDATE( ) ) 
                        ) 
                    ) > 48 AND lpj.id_pengajuan IS NULL";
        } else {
            $where1 = "AND lpj.id_pengajuan IS NULL";
            $where = "";
        }

        $sql = "SELECT
                    *,
                IF
                    ( x.leadtime > 48, 'Late', 'Ontime' ) AS status_leadtime 
                FROM
                    (SELECT
                    det.tgl_nota,
                    aju.id_pengajuan,

                    COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS `username`,
                    COALESCE(REPLACE(CONCAT(TRIM(fin.first_name), ' ', TRIM(fin.last_name)),',',', '),'') AS `finance`,

                    COALESCE(REPLACE(CONCAT(TRIM(pengaju.first_name), ' ', TRIM(pengaju.last_name)),',',', '),'') AS `pengaju`,
                    pengaju_dept.department_name AS pengaju_dept_name,
                    pengaju_comp.name AS pengaju_comp_name,
                    
                    aju.tgl_input as created_at,
                    apr.update_approve as tgl_approve,
                    aju.nama_penerima,
                IF
                    ( aju.id_kategori = 18, 'Pembawaan', 'Reimbursment' ) AS nama_kategori,
                    det.nama_keperluan as keperluan,
                    tp.nama_tipe,
                    bud.budget,
                    ecomp.company_name AS bud_company_name,
                    aju.note,
                IF
                    ( aju.`status` = 3, 'Cash Out', 'Waiting Cash Out' ) AS nama_status,
                    det.nominal_uang,
                IF
                    ( LEFT ( aju.temp, 3 ) = 'LPJ', 'Sudah LPJ', 'Belum LPJ' ) AS status_lpj,
                    lpj.tgl_input AS tanggal_lpj,
                    h_lpj.nominal_lpj,
                    lpj.total_pengajuan,
                    det.nominal_uang - h_lpj.nominal_lpj AS deviasi,
                CASE
                        WHEN lpj.`status` = 8 THEN
                        'Cash Back Budget' 
                        WHEN lpj.`status` = 7 THEN
                        'Approved LPJ'  
                        WHEN aju.id_kategori = 17 THEN
                        '' ELSE 'Waiting Approval LPJ' 
                    END AS approval_lpj,
                    COALESCE ( h_lpj.nominal_lpj, det.nominal_uang ) AS actual_budget,
                    TIMESTAMPDIFF(HOUR, apr.update_approve, COALESCE ( lpj.tgl_input, NOW() )) - (
                    SELECT
                        COUNT( holidays.id ) * 24 AS total 
                    FROM
                        (
                        SELECT
                            x.id,
                            x.date 
                        FROM
                            (
                            SELECT
                                h.holiday_id AS id,
                                h.start_date AS date 
                            FROM
                                hris.xin_holidays AS h UNION ALL
                            SELECT
                                w.weekend_id,
                                w.weekend_date 
                            FROM
                                hris.trusmi_weekend AS w 
                            WHERE
                                w.weekend_name = 'Sunday' 
                            ) AS x 
                        GROUP BY
                            x.date 
                        ) AS holidays 
                    WHERE
                        holidays.date BETWEEN DATE( apr.update_approve ) 
                        AND COALESCE ( DATE( lpj.tgl_input ), CURDATE( ) ) 
                    ) AS leadtime,
                CASE
                        WHEN TIMESTAMPDIFF(HOUR, apr.update_approve, COALESCE ( lpj.tgl_input, NOW() )) > 48 THEN
                        'Late' ELSE 'Ontime' 
                    END AS status_leadtime
                FROM
                    e_eaf.e_pengajuan AS aju
                    LEFT JOIN e_eaf.e_pengajuan AS lpj ON lpj.id_pengajuan = aju.temp
                    LEFT JOIN e_eaf.e_approval AS apr ON apr.id_pengajuan = aju.id_pengajuan 
                    AND apr.`level` = 5
                    LEFT JOIN e_eaf.e_tipe_pembayaran AS tp ON tp.id_pengajuan = aju.id_pengajuan
                    LEFT JOIN e_eaf.e_header_lpj AS h_lpj ON h_lpj.id_pengajuan = aju.id_pengajuan
                    LEFT JOIN (SELECT id_pengajuan, update_approve FROM e_eaf.e_approval WHERE level = 5 AND `status` = 'Approve'
										AND DATE( update_approve ) BETWEEN '$startdate' 
                    AND '$enddate') apr_lpj ON h_lpj.id_lpj = apr_lpj.id_pengajuan

                    LEFT JOIN e_eaf.e_biaya AS biaya ON biaya.id_biaya = aju.id_biaya
                    LEFT JOIN e_eaf.e_budget AS bud ON bud.id_budget = aju.budget
                    LEFT JOIN e_eaf.e_company AS ecomp ON ecomp.company_id = bud.company_id
                    LEFT JOIN e_eaf.e_detail_keperluan AS det ON det.id_pengajuan = aju.id_pengajuan

                    LEFT JOIN hris.xin_employees as usr ON usr.user_id = aju.pengaju
                    LEFT JOIN hris.xin_employees as fin ON fin.user_id = apr.id_user

                    
                    LEFT JOIN hris.xin_employees as pengaju ON pengaju.user_id = aju.pengaju
                    LEFT JOIN hris.xin_departments AS pengaju_dept ON pengaju_dept.department_id = pengaju.department_id
                    LEFT JOIN hris.xin_companies AS pengaju_comp ON pengaju_comp.company_id = pengaju.company_id


                WHERE
                    aju.id_kategori = '$id_kategori' 
                    AND aju.`status` NOT IN ( 1, 2, 4, 5, 11 ) 
                    AND DATE( apr.update_approve ) BETWEEN '$startdate' 
                    AND '$enddate' 
                    $where 
                    ) AS x 
                GROUP BY
                    x.id_pengajuan";
        return $this->db->query($sql);
    }

    // report budget by user
    function report_user($y, $m, $id_user)
    {
        $id_user = $this->session->userdata('user_id');
        $month = $y . '-' . $m;
        // 1358 idam, 61 hac
        if ($id_user == 1) {
            $user = " ";
        } else {
            $user = " AND id_user = $id_user";
        }

        $sql = "SELECT
        e_biaya.id_budget,
        e_biaya.id_biaya,
        e_biaya.nama_biaya,
        budget.id_user,
        budget.employee_name AS user,
        e_biaya.minggu,
        e_biaya.budget_awal,
        COALESCE ( tambahan.nominal_tambah, 0 ) AS nominal_tambah,
        (
        e_biaya.budget_awal + COALESCE ( tambahan.nominal_tambah, 0 )) - COALESCE ( m_0.total, 0 ) AS sisa,
        CASE
			WHEN m_0.total > (e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0))
			THEN abs((e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0)) - m_0.total)
        END AS total_over_budget,
        t_s.total_sisa AS total_sisa,
        m_0.rembers,
        m_0.belum_lpj,
        m_0.sudah_lpj,
        m_0.sudah_lpj + m_0.rembers AS act_budget,
        m_0.total AS actual_m0,
        ROUND(( m_0.sudah_lpj + m_0.rembers )/( e_biaya.budget_awal + COALESCE ( tambahan.nominal_tambah, 0 ))* 100, 0 ) AS presentase 
        FROM
        e_eaf.e_biaya
        LEFT JOIN (
        SELECT
            id_pengajuan,
            id_biaya,
            SUM( total ) AS total,
            SUM( IF ( id_kategori = 17, total_pengajuan_eaf, 0 ) ) AS rembers,
            SUM( IF ( id_kategori = 18 AND total_pengajuan_lpj IS NULL, total_pengajuan_eaf, 0 ) ) AS belum_lpj,
            SUM( IF ( id_kategori = 18 AND total_pengajuan_lpj IS NOT NULL, COALESCE ( total_pengajuan_lpj, total_pengajuan_eaf ), 0 ) ) AS sudah_lpj 
        FROM
            (
            SELECT
                e_pengajuan.id_pengajuan,
                approval.update_approve AS update_approve,
                e_pengajuan.id_biaya AS id_biaya,
                lpj.created_at AS tgl_LPJ,
                lpj.id_lpj,
                e_pengajuan.id_kategori,
                lpj.total_pengajuan AS total_pengajuan_lpj,
                e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                COALESCE ( lpj.total_pengajuan, e_pengajuan.total_pengajuan ) AS total 
            FROM
                e_eaf.`e_pengajuan`
                LEFT JOIN ( SELECT id_pengajuan AS id_lpj, total_pengajuan, created_at FROM e_eaf._pengajuan WHERE id_kategori = 19 ) AS lpj ON e_pengajuan.temp = lpj.id_lpj
                LEFT JOIN ( SELECT id_pengajuan, update_approve 
                    FROM e_eaf.e_approval 
                    WHERE 
                    FIND_IN_SET(e_approval.id_user_approval,(SELECT user_id FROM e_eaf.e_parameter WHERE id = 8))
                ) AS approval ON approval.id_pengajuan = e_pengajuan.id_pengajuan 
            WHERE
                substr( approval.update_approve, 1, 7 ) = '$month' 
                AND e_pengajuan.`status` = 3 
            ) x 
        GROUP BY
            id_biaya 
        ) AS m_0 ON m_0.id_biaya = e_biaya.id_biaya
        LEFT JOIN (
        SELECT
            id_budget,
            SUM(
            IF
            ( budget < 0, budget, 0 )) AS over_budget 
        FROM
            e_biaya 
        WHERE
            bulan = 09 
            AND tahun_budget = 2021 
        ) AS o_b ON o_b.id_budget = e_biaya.id_budget
        LEFT JOIN (
        SELECT
            id_budget,
            SUM(
            IF
            ( budget > 0, budget, 0 )) AS total_sisa 
        FROM
            e_biaya 
        WHERE
            bulan = 09 
            AND tahun_budget = 2021 
        ) AS t_s ON t_s.id_budget = e_biaya.id_budget
        LEFT JOIN ( SELECT e_jenis_biaya.id_budget, user.id_user, user.employee_name 
                FROM e_eaf.e_jenis_biaya 
                LEFT JOIN hris.xin_employees AS user ON e_jenis_biaya.id_user_approval = user.user_id
            ) AS budget ON e_biaya.id_budget = budget.id_budget
        LEFT JOIN (
        SELECT
            e_biaya_penambahan.id_biaya,
            SUM( e_biaya_penambahan.nominal_tambah ) AS nominal_tambah 
        FROM
            e_eaf.e_biaya_penambahan 
        WHERE
            e_biaya_penambahan.bulan = $m 
            AND e_biaya_penambahan.tahun = $y 
        GROUP BY
            e_biaya_penambahan.id_biaya,
            e_biaya_penambahan.bulan,
            e_biaya_penambahan.tahun 
        ) AS tambahan ON tambahan.id_biaya = e_biaya.id_biaya 
    WHERE
        bulan = $m 
        AND tahun_budget = $y 
        $user 
    GROUP BY
        id_biaya";

        return $this->db->query($sql);
    }












    function data_daily($start, $end)
    {
        return $this->db->query("SELECT
			Count( IF ( pengajuan.id_kategori = 18 AND pengajuan.`status` = 3, 1, NULL ) ) AS qty_pembawaan,
			Count( IF ( pengajuan.id_kategori = 17 AND pengajuan.`status` = 3, 1, NULL ) ) AS qty_reimburs,
			Count( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7,8), 1, NULL ) ) AS qty_lpj,
			Sum( IF ( pengajuan.id_kategori = 18 AND pengajuan.`status` = 3, pengajuan.total_pengajuan, NULL ) ) AS total_pembawaan,
			Sum( IF ( pengajuan.id_kategori = 17 AND pengajuan.`status` = 3, pengajuan.total_pengajuan, NULL ) ) AS total_reimburs,
			Sum( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7,8), pengajuan.total_pengajuan, NULL ) ) AS total_lpj 
		FROM
			e_eaf.e_pengajuan AS pengajuan
			JOIN e_eaf.e_approval AS approval ON pengajuan.id_pengajuan = approval.id_pengajuan 
			AND approval.id_user_approval = 1709 
		WHERE
			SUBSTR( approval.update_approve, 1, 10 ) BETWEEN '$start' 
			AND '$end'");
    }

    function data_detail_daily($tipe, $kategori, $status, $start, $end, $tgl, $company)
    {
        if ($tipe == 1) {
            $where = "AND SUBSTR( e_approval.update_approve, 1, 10 ) BETWEEN '$start' 
			AND '$end'";
        } else if ($tipe == 2) {
            $where = "AND SUBSTR( e_approval.update_approve, 1, 10 ) = '$tgl'";
        } else if ($tipe == 3) {
            $where = "AND budget.company_id = $company AND SUBSTR( e_approval.update_approve, 1, 10 ) BETWEEN '$start' 
			AND '$end'";
        } else {
            $where = "";
        }

        if ($status == 11) {
            $status = "IN (7)";
        } else {
            $status = "= " . $status;
        }

        if ($kategori == 19) {
            $detail = "detail.id_lpj";
        } else {
            $detail = "detail.id_pengajuan";
        }

        return $this->db->query("SELECT
			e_pengajuan.id_pengajuan,
			e_pengajuan.id_biaya,
			`user`.username,
            COALESCE(REPLACE(CONCAT(TRIM(pengaju.first_name), ' ', TRIM(pengaju.last_name)),',',', '),'') AS `pengaju`,
            pengaju_dept.department_name AS pengaju_dept_name,
            pengaju_comp.alias AS pengaju_comp_name,


			SUBSTR( e_pengajuan.created_at, 1, 16 ) AS created_at,
			SUBSTR( e_approval.update_approve, 1, 16 ) AS tgl_approve,
			e_pengajuan.nama_penerima,
			kategori.nama_kategori,
			jenis_biaya.jenis AS keperluan,
			tipe_pembayaran.nama_tipe,
			budget.budget,
			e_pengajuan.note,
			detail.note AS note_keperluan,
			e_m_status.nama_status,
			e_pengajuan.total_pengajuan AS nominal_uang,
			CASE
				WHEN lpj.id_lpj IS NULL THEN
				'Belum LPJ' ELSE 'Sudah LPJ' 
			END AS status_lpj,
			lpj.tgl_lpj AS tanggal_lpj,
			lpj2.nominal_lpj,
			detail.nominal_uang - lpj2.nominal_lpj AS deviasi,
			lpj.nama_status AS approval_lpj,
			COALESCE ( lpj2.nominal_lpj, detail.nominal_uang ) AS actual_budget 
		FROM
			e_eaf.e_pengajuan
            LEFT JOIN hris.xin_employees AS `user` ON `user`.user_id = e_pengajuan.id_user
            LEFT JOIN hris.xin_employees AS pengaju ON pengaju.user_id = e_pengajuan.pengaju
            LEFT JOIN hris.xin_departments as pengaju_dept ON pengaju_dept.department_id = `user`.department_id
            LEFT JOIN hris.xin_companies as pengaju_comp ON pengaju_comp.company_id = `user`.company_id


			LEFT JOIN ( SELECT e_approval.id_pengajuan, Max( e_approval.update_approve ) AS update_approve 
                FROM e_eaf.e_approval GROUP BY e_approval.id_pengajuan 
            ) AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan

			LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = e_pengajuan.`status`
			LEFT JOIN e_eaf.e_kategori AS kategori ON kategori.id_kategori = e_pengajuan.id_kategori
			LEFT JOIN e_eaf.e_jenis_biaya AS jenis_biaya ON jenis_biaya.id_jenis = e_pengajuan.jenis
			LEFT JOIN e_eaf.e_tipe_pembayaran AS tipe_pembayaran ON tipe_pembayaran.id_pengajuan = e_pengajuan.id_pengajuan
			LEFT JOIN e_eaf.e_budget AS budget ON budget.id_budget = e_pengajuan.budget
			LEFT JOIN e_eaf.e_company ON e_company.company_id = budget.company_id




			LEFT JOIN e_eaf.e_detail_keperluan AS detail ON $detail = e_pengajuan.id_pengajuan
			LEFT JOIN (
			SELECT
				lpj.id_pengajuan AS id_lpj,
				SUBSTR( lpj.created_at, 1, 16 ) AS tgl_lpj,
				e_header_lpj.id_pengajuan,
				e_header_lpj.note_lpj,
				e_m_status.nama_status 
			FROM
				e_eaf.e_pengajuan AS lpj
				LEFT JOIN e_eaf.e_header_lpj ON e_header_lpj.id_lpj = lpj.id_pengajuan
				LEFT JOIN e_eaf.e_m_status ON e_m_status.id_status = lpj.`status` 
			WHERE
				id_kategori = 19 
			) AS lpj ON lpj.id_pengajuan = e_pengajuan.id_pengajuan
			LEFT JOIN ( SELECT id_pengajuan AS id_lpj, total_pengajuan AS nominal_lpj 
                FROM e_eaf.e_pengajuan WHERE id_kategori = 19 
            ) AS lpj2 ON e_pengajuan.temp = lpj2.id_lpj
		WHERE
			e_pengajuan.id_kategori = $kategori
			AND e_pengajuan.`status` $status
			$where 
		GROUP BY
			e_pengajuan.id_pengajuan 
		ORDER BY
			e_pengajuan.id_pengajuan");
    }

    function data_daily_item($start, $end, $kategori, $status)
    {
        if ($kategori == 19) {
            $select     = ", SUM(eaf.total_pengajuan) AS pembawaan, SUM(eaf.total_pengajuan) - Sum(pengajuan.total_pengajuan) AS sisa";
            $join         = "JOIN (SELECT
				pengajuan.id_pengajuan,
				pengajuan.temp,
				pengajuan.total_pengajuan 
			FROM
				e_eaf.e_pengajuan AS pengajuan
				JOIN e_eaf.e_approval AS approval ON pengajuan.id_pengajuan = approval.id_pengajuan 
				AND approval.id_user_approval = 1709
			WHERE
				SUBSTR( temp, 1, 3 ) = 'lpj' 
			GROUP BY
				pengajuan.id_pengajuan
			) eaf ON pengajuan.id_pengajuan = eaf.temp";
            $status = "IN (6,7)";
        } else {
            $select     = "";
            $join         = "";
            $status     = "= " . $status;
        }

        return $this->db->query("SELECT
			SUBSTR( approval.update_approve, 1, 10 ) AS tanggal,
			DATE_FORMAT( approval.update_approve, '%d' ) AS tgl,
			Count( pengajuan.id_pengajuan ) AS qty,
			Sum( pengajuan.total_pengajuan ) AS nominal
			$select
		FROM
			e_eaf.e_pengajuan AS pengajuan
			-- JOIN e_eaf.e_approval AS approval ON pengajuan.id_pengajuan = approval.id_pengajuan AND approval.id_user_approval = 1709
            	LEFT JOIN ( SELECT e_approval.id_pengajuan, Max( e_approval.update_approve ) AS update_approve 
                FROM e_eaf.e_approval GROUP BY e_approval.id_pengajuan 
            ) AS approval ON approval.id_pengajuan = pengajuan.id_pengajuan
			$join
		WHERE
			SUBSTR( approval.update_approve, 1, 10 ) BETWEEN '$start' 
			AND '$end'
			AND pengajuan.id_kategori = $kategori 
			AND pengajuan.`status` $status 
		GROUP BY
			SUBSTR( approval.update_approve, 1, 10 ) 
		ORDER BY
			SUBSTR( approval.update_approve, 1, 10 )");
    }

    function data_daily_resume($start, $end)
    {
        return $this->db->query("SELECT
			pengajuan.id_divisi,
            e_budget.company_id AS bud_company_id,
			e_company.company_kode,
			COUNT( IF ( pengajuan.id_kategori = 18 AND pengajuan.`status` = 3, 1, NULL ) ) AS qty_pembawaan,
			SUM( IF ( pengajuan.id_kategori = 18 AND pengajuan.`status` = 3, pengajuan.total_pengajuan, NULL ) ) AS total_pembawaan,
			COUNT( IF ( pengajuan.id_kategori = 17 AND pengajuan.`status` = 3, 1, NULL ) ) AS qty_reimburs,
			SUM( IF ( pengajuan.id_kategori = 17 AND pengajuan.`status` = 3, pengajuan.total_pengajuan, NULL ) ) AS total_reimburs,
			COUNT( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7), 1, NULL ) ) AS qty_lpj,
			SUM( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7), eaf.total_pengajuan, NULL ) ) AS total_lpj_pembawaan,
			SUM( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7), pengajuan.total_pengajuan, NULL ) ) AS total_lpj,
			SUM( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7), eaf.total_pengajuan, NULL ) ) - SUM( IF ( pengajuan.id_kategori = 19 AND pengajuan.`status`  in (7), pengajuan.total_pengajuan, NULL ) ) AS sisa 
		FROM
			e_eaf.e_pengajuan AS pengajuan
			LEFT JOIN e_eaf.e_budget ON e_budget.id_budget = pengajuan.budget
			LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id
			JOIN e_eaf.e_approval AS approval ON pengajuan.id_pengajuan = approval.id_pengajuan AND approval.id_user_approval = 1709
			LEFT JOIN (
			SELECT
				pengajuan.id_pengajuan,
				pengajuan.temp,
				pengajuan.total_pengajuan 
			FROM
				e_eaf.e_pengajuan AS pengajuan
			WHERE
				SUBSTR( temp, 1, 3 ) = 'lpj' 
				AND pengajuan.tgl_input BETWEEN '$start' 
				AND '$end' 
			) eaf ON pengajuan.id_pengajuan = eaf.temp 
		WHERE
			SUBSTR( approval.update_approve, 1, 10 ) BETWEEN '$start' 
			AND '$end'
		GROUP BY
			e_company.company_id");
    }

    function get_e_parameter($id_param, $id_user)
    {
        return $this->db->query("SELECT * FROM e_eaf.e_parameter WHERE id = $id_param AND FIND_IN_SET($id_user,user_id) LIMIT 1");
    }

    function belum_lpj_h2()
    {
        $query = "SELECT
                    `x`.`id_user` AS `created_by`,
                    `x`.`id_user` AS `id_hr`,
                    `x`.`pengaju` AS `name`,
                    count( 0 ) AS `jumlah`,
                    `trusmi_m_lock`.`id_lock` AS `id_lock`,
                    `trusmi_m_lock`.`status_lock` AS `status_lock`,
                    concat( `trusmi_m_lock`.`warning_lock`, ' [', group_concat( DISTINCT `x`.`id_pengajuan` SEPARATOR ', ' ), ']' ) AS `warning_lock` 
                FROM
                    ((
                        SELECT
                            `x`.`tgl_nota` AS `tgl_nota`,
                            `x`.`id_pengajuan` AS `id_pengajuan`,
                            `x`.`id_user` AS `id_user`,
                            `x`.`username` AS `username`,
                            `x`.`finance` AS `finance`,
                            `x`.`pengaju` AS `pengaju`,
                            `x`.`pengaju_dept_name` AS `pengaju_dept_name`,
                            `x`.`pengaju_comp_name` AS `pengaju_comp_name`,
                            `x`.`created_at` AS `created_at`,
                            `x`.`tgl_approve` AS `tgl_approve`,
                            `x`.`nama_penerima` AS `nama_penerima`,
                            `x`.`nama_kategori` AS `nama_kategori`,
                            `x`.`keperluan` AS `keperluan`,
                            `x`.`nama_tipe` AS `nama_tipe`,
                            `x`.`budget` AS `budget`,
                            `x`.`bud_company_name` AS `bud_company_name`,
                            `x`.`note` AS `note`,
                            `x`.`nama_status` AS `nama_status`,
                            `x`.`nominal_uang` AS `nominal_uang`,
                            `x`.`status_lpj` AS `status_lpj`,
                            `x`.`tanggal_lpj` AS `tanggal_lpj`,
                            `x`.`nominal_lpj` AS `nominal_lpj`,
                            `x`.`total_pengajuan` AS `total_pengajuan`,
                            `x`.`deviasi` AS `deviasi`,
                            `x`.`approval_lpj` AS `approval_lpj`,
                            `x`.`actual_budget` AS `actual_budget`,
                            `x`.`leadtime` AS `leadtime`,
                            `x`.`status_leadtime` AS `status_leadtime` 
                        FROM
                            (
                            SELECT
                                `det`.`tgl_nota` AS `tgl_nota`,
                                `aju`.`id_pengajuan` AS `id_pengajuan`,
                                `aju`.`pengaju` AS `id_user`,
                                COALESCE ( REPLACE ( concat( trim( `usr`.`first_name` ), ' ', trim( `usr`.`last_name` )), ',', ', ' ), '' ) AS `username`,
                                COALESCE ( REPLACE ( concat( trim( `fin`.`first_name` ), ' ', trim( `fin`.`last_name` )), ',', ', ' ), '' ) AS `finance`,
                                COALESCE ( REPLACE ( concat( trim( `pengaju`.`first_name` ), ' ', trim( `pengaju`.`last_name` )), ',', ', ' ), '' ) AS `pengaju`,
                                `pengaju_dept`.`department_name` AS `pengaju_dept_name`,
                                `pengaju_comp`.`name` AS `pengaju_comp_name`,
                                `aju`.`tgl_input` AS `created_at`,
                                `apr`.`update_approve` AS `tgl_approve`,
                                `aju`.`nama_penerima` AS `nama_penerima`,
                            IF
                                (( `aju`.`id_kategori` = 18 ), 'Pembawaan', 'Reimbursment' ) AS `nama_kategori`,
                                `det`.`nama_keperluan` AS `keperluan`,
                                `tp`.`nama_tipe` AS `nama_tipe`,
                                `bud`.`budget` AS `budget`,
                                `ecomp`.`company_name` AS `bud_company_name`,
                                `aju`.`note` AS `note`,
                            IF
                                (( `aju`.`status` = 3 ), 'Cash Out', 'Waiting Cash Out' ) AS `nama_status`,
                                `det`.`nominal_uang` AS `nominal_uang`,
                            IF
                                (( LEFT ( `aju`.`temp`, 3 ) = 'LPJ' ), 'Sudah LPJ', 'Belum LPJ' ) AS `status_lpj`,
                                `lpj`.`tgl_input` AS `tanggal_lpj`,
                                `h_lpj`.`nominal_lpj` AS `nominal_lpj`,
                                `lpj`.`total_pengajuan` AS `total_pengajuan`,(
                                    `det`.`nominal_uang` - `h_lpj`.`nominal_lpj` 
                                    ) AS `deviasi`,(
                                CASE
                                        
                                        WHEN ( `lpj`.`status` = 8 ) THEN
                                        'Cash Back Budget' 
                                        WHEN ( `lpj`.`status` = 7 ) THEN
                                        'Approved LPJ' 
                                        WHEN ( `aju`.`id_kategori` = 17 ) THEN
                                        '' ELSE 'Waiting Approval LPJ' 
                                    END 
                                    ) AS `approval_lpj`,
                                    COALESCE ( `h_lpj`.`nominal_lpj`, `det`.`nominal_uang` ) AS `actual_budget`,(
                                        timestampdiff(
                                            HOUR,
                                            `apr`.`update_approve`,
                                            COALESCE (
                                                `lpj`.`tgl_input`,
                                            now())) - (
                                        SELECT
                                            ( count( `holidays`.`id` ) * 24 ) AS `total` 
                                        FROM
                                            (
                                            SELECT
                                                `x`.`id` AS `id`,
                                                `x`.`DATE` AS `DATE` 
                                            FROM
                                                (
                                                SELECT
                                                    `h`.`holiday_id` AS `id`,
                                                    `h`.`start_date` AS `DATE` 
                                                FROM
                                                    `xin_holidays` `h` UNION ALL
                                                SELECT
                                                    `w`.`weekend_id` AS `weekend_id`,
                                                    `w`.`weekend_date` AS `weekend_date` 
                                                FROM
                                                    `trusmi_weekend` `w` 
                                                WHERE
                                                ( `w`.`weekend_name` = 'Sunday' )) `x` 
                                            GROUP BY
                                                `x`.`DATE` 
                                            ) `holidays` 
                                        WHERE
                                            (
                                                `holidays`.`DATE` BETWEEN cast( `apr`.`update_approve` AS DATE ) 
                                                AND COALESCE (
                                                    cast( `lpj`.`tgl_input` AS DATE ),
                                                curdate())))) AS `leadtime`,(
                                    CASE
                                            
                                            WHEN ( timestampdiff( HOUR, `apr`.`update_approve`, COALESCE ( `lpj`.`tgl_input`, now())) > 48 ) THEN
                                            'Late' ELSE 'Ontime' 
                                        END 
                                        ) AS `status_leadtime` 
                                    FROM
                                        ((((((((((((((
                                                                                                `e_eaf`.`e_pengajuan` `aju`
                                                                                                LEFT JOIN `e_eaf`.`e_pengajuan` `lpj` ON ((
                                                                                                        `lpj`.`id_pengajuan` = `aju`.`temp` 
                                                                                                    )))
                                                                                            LEFT JOIN `e_eaf`.`e_approval` `apr` ON (((
                                                                                                        `apr`.`id_pengajuan` = `aju`.`id_pengajuan` 
                                                                                                        ) 
                                                                                                AND ( `apr`.`level` = 5 ))))
                                                                                        LEFT JOIN `e_eaf`.`e_tipe_pembayaran` `tp` ON ((
                                                                                                `tp`.`id_pengajuan` = `aju`.`id_pengajuan` 
                                                                                            )))
                                                                                    LEFT JOIN `e_eaf`.`e_header_lpj` `h_lpj` ON ((
                                                                                            `h_lpj`.`id_pengajuan` = `aju`.`id_pengajuan` 
                                                                                        )))
                                                                                LEFT JOIN (
                                                                                SELECT
                                                                                    `e_eaf`.`e_approval`.`id_pengajuan` AS `id_pengajuan`,
                                                                                    `e_eaf`.`e_approval`.`update_approve` AS `update_approve` 
                                                                                FROM
                                                                                    `e_eaf`.`e_approval` 
                                                                                WHERE
                                                                                    ((
                                                                                            `e_eaf`.`e_approval`.`level` = 5 
                                                                                            ) 
                                                                                        AND ( `e_eaf`.`e_approval`.`status` = 'Approve' ))) `apr_lpj` ON ((
                                                                                        `h_lpj`.`id_lpj` = `apr_lpj`.`id_pengajuan` 
                                                                                    )))
                                                                            LEFT JOIN `e_eaf`.`e_biaya` `biaya` ON ((
                                                                                    `biaya`.`id_biaya` = `aju`.`id_biaya` 
                                                                                )))
                                                                        LEFT JOIN `e_eaf`.`e_budget` `bud` ON ((
                                                                                `bud`.`id_budget` = `aju`.`budget` 
                                                                            )))
                                                                    LEFT JOIN `e_eaf`.`e_company` `ecomp` ON ((
                                                                            `ecomp`.`company_id` = `bud`.`company_id` 
                                                                        )))
                                                                LEFT JOIN `e_eaf`.`e_detail_keperluan` `det` ON ((
                                                                        `det`.`id_pengajuan` = `aju`.`id_pengajuan` 
                                                                    )))
                                                            LEFT JOIN `xin_employees` `usr` ON ((
                                                                    `usr`.`user_id` = `aju`.`pengaju` 
                                                                )))
                                                        LEFT JOIN `xin_employees` `fin` ON ((
                                                                `fin`.`user_id` = `apr`.`id_user` 
                                                            )))
                                                    LEFT JOIN `xin_employees` `pengaju` ON ((
                                                            `pengaju`.`user_id` = `aju`.`pengaju` 
                                                        )))
                                                LEFT JOIN `xin_departments` `pengaju_dept` ON ((
                                                        `pengaju_dept`.`department_id` = `pengaju`.`department_id` 
                                                    )))
                                            LEFT JOIN `xin_companies` `pengaju_comp` ON ((
                                                    `pengaju_comp`.`company_id` = `pengaju`.`company_id` 
                                                ))) 
                                    WHERE
                                        ((
                                                `aju`.`id_kategori` = '18' 
                                                ) 
                                            AND (
                                            `aju`.`status` NOT IN ( 1, 2, 4, 5, 11 )) 
                                            AND ((
                                                    timestampdiff(
                                                        HOUR,
                                                        `apr`.`update_approve`,
                                                        COALESCE (
                                                            `lpj`.`tgl_input`,
                                                        now())) - (
                                                    SELECT
                                                        ( count( `holidays`.`id` ) * 24 ) AS `total` 
                                                    FROM
                                                        (
                                                        SELECT
                                                            `x`.`id` AS `id`,
                                                            `x`.`DATE` AS `DATE` 
                                                        FROM
                                                            (
                                                            SELECT
                                                                `h`.`holiday_id` AS `id`,
                                                                `h`.`start_date` AS `DATE` 
                                                            FROM
                                                                `xin_holidays` `h` UNION ALL
                                                            SELECT
                                                                `w`.`weekend_id` AS `weekend_id`,
                                                                `w`.`weekend_date` AS `weekend_date` 
                                                            FROM
                                                                `trusmi_weekend` `w` 
                                                            WHERE
                                                            ( `w`.`weekend_name` = 'Sunday' )) `x` 
                                                        GROUP BY
                                                            `x`.`DATE` 
                                                        ) `holidays` 
                                                    WHERE
                                                        (
                                                            `holidays`.`DATE` BETWEEN cast( `apr`.`update_approve` AS DATE ) 
                                                            AND COALESCE (
                                                                cast( `lpj`.`tgl_input` AS DATE ),
                                                            curdate())))) > 48 
                                            ) 
                                        AND ( `lpj`.`id_pengajuan` IS NULL ))) `x` 
                                GROUP BY
                                    `x`.`id_pengajuan` 
                                ) `x`
                                JOIN `trusmi_m_lock` ON (((
                                            `trusmi_m_lock`.`is_active` = 1 
                                            ) 
                                    AND ( `trusmi_m_lock`.`id_lock` = 171 )))) 
                        WHERE
                            ( HOUR ( now()) > 7 ) 
                    GROUP BY
                    `x`.`id_user`";
        return $this->db->query($query)->result();
    }
}
