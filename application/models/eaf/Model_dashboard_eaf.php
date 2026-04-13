<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_eaf extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function get_dashboard($y, $m)
    {
        $sql = "SELECT
            company_kode,

            /* ================= BUDGET YTD ================= */
            SUM(budget_ytd) AS budget_ytd,

            /* ================= BUDGET MTD ================= */
            ROUND(
                SUM(budget_ytd)
                /
                DAY(LAST_DAY(CONCAT($y,'-',LPAD($m,2,'0'),'-01')))
                *
                DAY(CURDATE())
            ,0) AS budget_mtd,

            /* ================= ACTUAL ================= */
            SUM(actual_store) AS actual_store,

            /* ================= % TERHADAP MTD ================= */
            ROUND(
                IFNULL(
                    SUM(actual_store) /
                    NULLIF(
                        (
                            SUM(budget_ytd)
                            /
                            DAY(LAST_DAY(CONCAT($y,'-',LPAD($m,2,'0'),'-01')))
                            *
                            DAY(CURDATE())
                        ),
                    0),
                0) * 100
            ,2) AS persen_mtd,

            /* ================= SISA BUDGET ================= */
            SUM(budget_ytd) - SUM(actual_store) AS sisa_budget

        FROM
        (
            SELECT
                e_company.company_kode,

                /* Budget YTD */
                e_biaya.budget_awal +
                COALESCE(tambahan.nominal_tambah,0) AS budget_ytd,

                /* Actual */
                COALESCE(m_0.sudah_lpj,0)
                +
                COALESCE(m_0.rembers,0) AS actual_store

            FROM e_eaf.e_biaya

            LEFT JOIN e_eaf.e_company
                ON e_company.company_id = e_biaya.company_id

            /* ================= TAMBAHAN ================= */
            LEFT JOIN (
                SELECT
                    id_biaya,
                    SUM(nominal_tambah) AS nominal_tambah
                FROM e_eaf.e_biaya_penambahan
                WHERE bulan = $m
                AND tahun = $y
                GROUP BY id_biaya
            ) tambahan
                ON tambahan.id_biaya = e_biaya.id_biaya


            /* ================= ACTUAL ================= */
            LEFT JOIN (
                SELECT
                    id_biaya,

                    SUM(
                        IF(
                            id_kategori = 18
                            AND total_pengajuan_lpj IS NOT NULL,
                            COALESCE(total_pengajuan_lpj,total_pengajuan_eaf),
                            0
                        )
                    ) AS sudah_lpj,

                    SUM(
                        IF(id_kategori = 17,total_pengajuan_eaf,0)
                    ) AS rembers

                FROM(
                    SELECT
                        e_pengajuan.id_biaya,
                        e_pengajuan.id_kategori,
                        e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                        lpj.total_pengajuan AS total_pengajuan_lpj,
                        approval.update_approve

                    FROM e_eaf.e_pengajuan

                    LEFT JOIN (
                        SELECT id_pengajuan AS id_lpj,total_pengajuan
                        FROM e_eaf.e_pengajuan
                        WHERE id_kategori = 19
                    ) lpj
                    ON e_pengajuan.temp = lpj.id_lpj

                    LEFT JOIN (
                        SELECT id_pengajuan,update_approve
                        FROM e_eaf.e_approval
                        WHERE level = 5
                        AND status = 'Approve'
                    ) approval
                    ON approval.id_pengajuan = e_pengajuan.id_pengajuan

                    WHERE
                        substr(approval.update_approve,1,7)=CONCAT($y,'-',LPAD($m,2,'0'))
                        AND e_pengajuan.status=3
                )x
                GROUP BY id_biaya
            ) m_0
                ON m_0.id_biaya = e_biaya.id_biaya

            WHERE
                e_biaya.bulan = $m
                AND e_biaya.tahun_budget = $y

                AND e_company.company_kode IN (
                    'BT',
                    'B2B BT',
                    'BT MOMEN',
                    'BT Online',
                    'BT MDN',
                    'BT JKT',
                    'BT LNG',
                    'BK',
                    'HO',
                    'HANDPRINT',
                    'KONVEKSI',
                    'MINI FACTORY',
                    'FBT',
                    'TKB',
                    'Produksi Batik',
                    'Produksi Bali',
                    'EC TKB'
                )

        ) AS dashboard

        GROUP BY company_kode
        ORDER BY company_kode
        ";

        return $this->db->query($sql)->result();
    }

    function get_dashboard_detail($y, $m)
    {
        $sql = "SELECT
                    e_company.company_kode,
                    e_biaya.nama_biaya,

                    COALESCE(m_0.sudah_lpj,0)
                    +
                    COALESCE(m_0.rembers,0) AS actual_biaya

                FROM e_eaf.e_biaya

                LEFT JOIN e_eaf.e_company
                    ON e_company.company_id = e_biaya.company_id

                LEFT JOIN (
                    SELECT
                        id_biaya,

                        SUM(
                            IF(id_kategori=18
                            AND total_pengajuan_lpj IS NOT NULL,
                            COALESCE(total_pengajuan_lpj,total_pengajuan_eaf),0)
                        ) AS sudah_lpj,

                        SUM(
                            IF(id_kategori=17,total_pengajuan_eaf,0)
                        ) AS rembers

                    FROM(
                        SELECT
                            e_pengajuan.id_biaya,
                            e_pengajuan.id_kategori,
                            e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                            lpj.total_pengajuan AS total_pengajuan_lpj,
                            approval.update_approve

                        FROM e_eaf.e_pengajuan

                        LEFT JOIN (
                            SELECT id_pengajuan AS id_lpj,total_pengajuan
                            FROM e_eaf.e_pengajuan
                            WHERE id_kategori=19
                        ) lpj
                        ON e_pengajuan.temp=lpj.id_lpj

                        LEFT JOIN (
                            SELECT id_pengajuan,update_approve
                            FROM e_eaf.e_approval
                            WHERE level=5
                            AND status='Approve'
                        ) approval
                        ON approval.id_pengajuan=e_pengajuan.id_pengajuan

                        WHERE
                        substr(approval.update_approve,1,7)=CONCAT($y,'-',LPAD($m,2,'0'))
                        AND e_pengajuan.status=3
                    )x
                    GROUP BY id_biaya
                ) m_0
                    ON m_0.id_biaya=e_biaya.id_biaya

                WHERE
                    e_biaya.bulan=$m
                    AND e_biaya.tahun_budget=$y
                    AND e_company.company_kode IN (
                        'BT',
                        'B2B BT',
                        'BT MOMEN',
                        'BT Online',
                        'BT MDN',
                        'BT JKT',
                        'BT LNG',
                        'BK',
                        'HO',
                        'HANDPRINT',
                        'KONVEKSI',
                        'MINI FACTORY',
                        'FBT',
                        'TKB',
                        'Produksi Batik',
                        'Produksi Bali',
                        'EC TKB'
                    )
        ";
        return $this->db->query($sql)->result();
    }

    public function get_detail_company($y, $m, $company)
    {
        $sql = "SELECT
            e_biaya.id_budget,
            e_company.company_kode,
            e_biaya.id_biaya,
            e_biaya.nama_biaya,
            budget.employee_name AS employee_name,
            e_biaya.minggu,
            e_biaya.budget_awal,
            COALESCE(tambahan.nominal_tambah,0) AS penambahan,
            (
                e_biaya.budget_awal 
                + COALESCE(tambahan.nominal_tambah,0)
            ) - COALESCE(m_0.total,0) AS sisa,

            CASE
                WHEN m_0.total >
                (e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0))
                THEN ABS(
                    (e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0))
                    - m_0.total
                )
            END AS total_over_budget,

            t_s.total_sisa,
            m_0.rembers,
            m_0.belum_lpj,
            m_0.sudah_lpj,
            m_0.sudah_lpj + m_0.rembers AS actual_budget,
            m_0.total AS cash_out,

            ROUND(
                (m_0.sudah_lpj + m_0.rembers) /
                (e_biaya.budget_awal + COALESCE(tambahan.nominal_tambah,0))
            *100,0) AS persen

        FROM e_eaf.e_biaya
        LEFT JOIN e_eaf.e_company 
            ON e_company.company_id = e_biaya.company_id

        LEFT JOIN (
            SELECT
                id_biaya,
                SUM(total) AS total,
                SUM(IF(id_kategori=17,total_pengajuan_eaf,0)) AS rembers,
                SUM(IF(id_kategori=18 AND total_pengajuan_lpj IS NULL,total_pengajuan_eaf,0)) AS belum_lpj,
                SUM(IF(id_kategori=18 AND total_pengajuan_lpj IS NOT NULL,
                    COALESCE(total_pengajuan_lpj,total_pengajuan_eaf),0)) AS sudah_lpj
            FROM(
                SELECT
                    e_pengajuan.id_pengajuan,
                    approval.update_approve,
                    e_pengajuan.id_biaya,
                    e_pengajuan.id_kategori,
                    lpj.total_pengajuan AS total_pengajuan_lpj,
                    e_pengajuan.total_pengajuan AS total_pengajuan_eaf,
                    COALESCE(lpj.total_pengajuan,e_pengajuan.total_pengajuan) AS total
                FROM e_eaf.e_pengajuan
                LEFT JOIN (
                    SELECT id_pengajuan AS id_lpj,total_pengajuan
                    FROM e_eaf.e_pengajuan
                    WHERE id_kategori=19
                ) lpj ON e_pengajuan.temp = lpj.id_lpj

                LEFT JOIN (
                    SELECT id_pengajuan,update_approve
                    FROM e_eaf.e_approval
                    WHERE level=5
                    AND status='Approve'
                ) approval ON approval.id_pengajuan=e_pengajuan.id_pengajuan

                WHERE substr(approval.update_approve,1,7)=CONCAT($y,'-',LPAD($m,2,'0'))
                AND e_pengajuan.status=3
            ) x
            GROUP BY id_biaya
        ) m_0 ON m_0.id_biaya=e_biaya.id_biaya

        LEFT JOIN (
            SELECT id_budget,
                SUM(IF(budget>0,budget,0)) AS total_sisa
            FROM e_eaf.e_biaya
            WHERE bulan=09 AND tahun_budget=2021
            GROUP BY id_budget
        ) t_s ON t_s.id_budget=e_biaya.id_budget

        LEFT JOIN (
            SELECT
                e_jenis_biaya.id_budget,
                COALESCE(
                    REPLACE(CONCAT(TRIM(usr.first_name),' ',TRIM(usr.last_name)),',',', '),
                '') AS employee_name
            FROM e_eaf.e_jenis_biaya
            JOIN hris.xin_employees usr
                ON e_jenis_biaya.id_user_approval=usr.user_id
        ) budget ON e_biaya.id_budget=budget.id_budget

        LEFT JOIN (
            SELECT
                id_biaya,
                SUM(nominal_tambah) AS nominal_tambah
            FROM e_eaf.e_biaya_penambahan
            WHERE bulan=$m
            AND tahun=$y
            GROUP BY id_biaya
        ) tambahan ON tambahan.id_biaya=e_biaya.id_biaya

        WHERE
            e_company.company_kode = '$company'
            AND bulan=$m
            AND tahun_budget=$y

        GROUP BY e_biaya.id_biaya
        ";

        return $this->db
            ->query($sql, [$company])
            ->result_array();
    }
}
