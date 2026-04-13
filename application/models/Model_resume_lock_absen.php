<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_resume_lock_absen extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function lock_absen()
    {
        $query = "SELECT 
            e.user_id,
            e.first_name,
            e.last_name,
            d.designation_name,
            COALESCE(l.total_lock, 0) AS jumlah_lock,
            COALESCE(l.total_lock_mom, 0) AS jumlah_lock_mom,
            COALESCE(l.total_lock_non_mom, 0) AS jumlah_lock_non_mom,
            COALESCE(a.tidak_absen, 0) AS lock_tidak_absen,
            COALESCE(m1.mom_sesuai, 0) AS mom_sesuai,
            COALESCE(m2.mom_tidak_sesuai, 0) AS mom_tidak_sesuai,
            
            -- persentase mom issue vs lock mom
            CASE 
                WHEN COALESCE(l.total_lock_mom, 0) = 0 THEN 0
                ELSE ROUND((COALESCE(m1.mom_sesuai, 0) / l.total_lock_mom) * 100)
            END AS persen_sesuai_vs_lock_mom,

            -- persentase
            -- CASE 
            --     WHEN COALESCE(l.total_lock_mom, 0) = 0 THEN '0%'
            --     ELSE CONCAT(ROUND((COALESCE(m1.mom_sesuai, 0) / l.total_lock_mom) * 100), '%')
            -- END AS persen_sesuai_vs_lock_mom,

            -- pers max 100
            -- LEAST(
            -- CASE 
            --     WHEN COALESCE(l.total_lock_mom, 0) = 0 THEN 0
            --     ELSE ROUND((COALESCE(m1.total_issue, 0) / l.total_lock_mom) * 100, 2)
            -- END
            -- , 100) AS persen_sesuai_vs_lock_mom,

            CASE 
                WHEN COALESCE(l.total_lock_mom, 0) = 0 THEN 0
                ELSE ROUND((COALESCE(m2.mom_tidak_sesuai, 0) / l.total_lock_mom) * 100)
            END AS persen_tidak_vs_lock_mom

            -- persentase
            -- CASE 
            --     WHEN COALESCE(l.total_lock_mom, 0) = 0 THEN '0%'
            --     ELSE CONCAT(ROUND((COALESCE(m2.mom_tidak_sesuai, 0) / l.total_lock_mom) * 100), '%')
            -- END AS persen_tidak_vs_lock_mom


        FROM xin_employees e
        LEFT JOIN xin_designations d 
            ON e.designation_id = d.designation_id

        -- subquery lock
        INNER JOIN (
            SELECT 
                thl.employee_id,
                COUNT(*) AS total_lock,
                SUM(CASE WHEN tml.id_lock IN (57,69,70,172,179,180) THEN 1 ELSE 0 END) AS total_lock_mom,
                SUM(CASE WHEN tml.id_lock NOT IN (57,69,70,172,179,180) THEN 1 ELSE 0 END) AS total_lock_non_mom
            FROM trusmi_history_lock thl
            LEFT JOIN trusmi_m_lock tml ON tml.id_lock = thl.lock_type
            GROUP BY thl.employee_id
        ) l ON l.employee_id = e.user_id

        -- subquery attendance
        LEFT JOIN (
            SELECT 
                xat.employee_id,
                COUNT(*) AS tidak_absen
            FROM xin_attendance_time xat
            WHERE xat.clock_out IS NULL OR xat.clock_out = ''
            GROUP BY xat.employee_id
        ) a ON a.employee_id = e.user_id

        -- mom sesuai
        LEFT JOIN (
            SELECT 
                e2.user_id,
                COUNT(*) AS mom_sesuai
            FROM mom_issue_item mii
            JOIN xin_employees e2 
                ON FIND_IN_SET(e2.user_id, mii.pic)
            WHERE mii.verified_status = 1
            GROUP BY e2.user_id
        ) m1 ON m1.user_id = e.user_id

        -- mom tidak sesuai
        LEFT JOIN (
            SELECT 
                e2.user_id,
                COUNT(*) AS mom_tidak_sesuai
            FROM mom_issue_item mii
            JOIN xin_employees e2 
                ON FIND_IN_SET(e2.user_id, mii.pic)
            WHERE mii.verified_status = 2
            GROUP BY e2.user_id
        ) m2 ON m2.user_id = e.user_id

        WHERE e.is_active = 1
    ";

        return $this->db->query($query)->result();
    }
}