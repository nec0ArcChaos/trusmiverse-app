<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_onboarding extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function funnel($periode){
        $query = "SELECT 
                COUNT(DISTINCT emp.user_id) AS total_karyawan,
                COUNT(CASE WHEN onb.status IN (1,2,3,4) THEN 1 END) AS training_class,
                COUNT(CASE WHEN onb.status IN (2,3,4) THEN 1 END) AS assignment,
                COUNT(CASE WHEN onb.status IN( 3,4) THEN 1 END) AS office_tour,
                COUNT(CASE WHEN onb.status = 4 THEN 1 END) AS serah_terima
            FROM 
                xin_employees emp
            LEFT JOIN (
                SELECT user_id, MAX(id) AS max_id
                FROM t_onboarding
                GROUP BY user_id
            ) latest_onb ON latest_onb.user_id = emp.user_id

            -- 2. Join ke tabel onboarding utama untuk mendapatkan nilai status dari ID terakhir tersebut
            LEFT JOIN t_onboarding onb ON onb.id = latest_onb.max_id

            WHERE 
                LEFT(emp.date_of_joining, 7) = '$periode';";
        return $this->db->query($query)->row_object();
    }
    function overall($periode){
        $query = "SELECT
                IFNULL(
                    ROUND(
                        (COUNT(CASE WHEN onb.status = 4 THEN 1 END) / NULLIF(COUNT(DISTINCT emp.user_id), 0)) * 100, 
                    1), 
                0) AS overall
            FROM
                xin_employees emp
            LEFT JOIN (
                SELECT user_id, MAX(id) AS max_id
                FROM t_onboarding
                GROUP BY user_id
            ) latest_onb ON latest_onb.user_id = emp.user_id
            LEFT JOIN t_onboarding onb ON onb.id = latest_onb.max_id
            WHERE LEFT(emp.date_of_joining, 7) = '$periode';";
        return $this->db->query($query)->row_object();
    }

    function resume($periode){
        $query = "SELECT 
                COUNT(DISTINCT emp.user_id) AS total_karyawan,
                COUNT(DISTINCT emp.user_id)- COUNT(onb.id) AS not_started,
                
                -- 2. Jumlah karyawan yang sudah masuk ke proses onboarding (memiliki record di t_onboarding)
                COUNT(onb.id) AS jumlah_peserta_onboarding,
                
                -- 3. Jumlah karyawan yang saat ini tertahan di status 1
                COUNT(CASE WHEN onb.status = '1' THEN 1 END) AS peserta,
                
                -- 4. Jumlah karyawan yang sedang berproses (status 2 dan 3)
                COUNT(CASE WHEN onb.status IN ('2', '3') THEN 1 END) AS progres,
                COALESCE(ROUND(COUNT(CASE WHEN onb.status IN ('2', '3') THEN 1 END) / NULLIF(COUNT(onb.id), 0) * 100, 2), 0) AS persen_progres,
                
                -- 5. Jumlah karyawan yang sudah selesai onboarding (status 4)
                COUNT(CASE WHEN onb.status = '4' THEN 1 END) AS compelete,
                
                -- 6. Persentase Complete vs Jumlah Peserta Onboarding
                -- Diberikan IFNULL dan NULLIF agar jika pembaginya 0 tidak menyebabkan error
                COALESCE(
                    ROUND(
                        (COUNT(CASE WHEN onb.status = '4' THEN 1 END) / NULLIF(COUNT(onb.id), 0)) * 100
                    , 2), 
                0) AS persen_complete

            FROM xin_employees emp

            -- Subquery: Cari ID onboarding terakhir untuk setiap user
            LEFT JOIN (
                SELECT user_id, MAX(id) AS max_id
                FROM t_onboarding
                GROUP BY user_id
            ) latest_onb ON latest_onb.user_id = emp.user_id

            -- Join ke tabel onboarding utama untuk mendapatkan nilai status dari ID terakhir
            LEFT JOIN t_onboarding onb ON onb.id = latest_onb.max_id

            WHERE 
                LEFT(emp.date_of_joining, 7) = '$periode';";
        return $this->db->query($query)->row_object();
    }

    function onboarding_monitoring($periode){
        $query = "WITH BaseOnboarding AS (
                SELECT
                    emp.user_id,
                    emp.first_name,
                    emp.last_name,
                    emp.username,
                    emp.date_of_joining,
                    emp.date_of_leaving,
                    emp.contact_no,
                    xin_companies.`name` AS company,
                    xin_departments.department_name AS departement,
                    xin_designations.designation_name AS designation,
                    xin_office_location.location_name AS location_name,
                    -- Pivot actual tanggal dari t_onboarding (diambil dari created_at)
                    MAX(CASE WHEN onb_all.status = '1' THEN onb_all.created_at END) AS actual_tgl_1,
                    MAX(CASE WHEN onb_all.status = '2' THEN onb_all.created_at END) AS actual_tgl_2,
                    MAX(CASE WHEN onb_all.status = '3' THEN onb_all.created_at END) AS actual_tgl_3,
                    MAX(CASE WHEN onb_all.status = '4' THEN onb_all.created_at END) AS actual_tgl_4,
                    -- Pivot is_lanjut dari t_onboarding untuk masing-masing tahap
                    MAX(CASE WHEN onb_all.status = '1' THEN onb_all.is_lanjut END) AS is_lanjut_1,
                    MAX(CASE WHEN onb_all.status = '2' THEN onb_all.is_lanjut END) AS is_lanjut_2,
                    MAX(CASE WHEN onb_all.status = '3' THEN onb_all.is_lanjut END) AS is_lanjut_3,
                    MAX(CASE WHEN onb_all.status = '4' THEN onb_all.is_lanjut END) AS is_lanjut_4,
                    -- Data status terakhir untuk baris utama
                    onb_main.id AS main_onb_id,
                    mob_main.status AS current_status_text,
                    onb_main.created_at AS last_update
                FROM
                    xin_employees emp
                    JOIN t_onboarding onb_main ON onb_main.id = (SELECT MAX(id) FROM t_onboarding WHERE user_id = emp.user_id)
                    JOIN m_onboarding mob_main ON CAST(onb_main.status AS UNSIGNED) = mob_main.id
                    LEFT JOIN t_onboarding onb_all ON emp.user_id = onb_all.user_id
                    JOIN xin_companies ON emp.company_id = xin_companies.company_id
                    JOIN xin_departments ON emp.department_id = xin_departments.department_id
                    JOIN xin_designations ON emp.designation_id = xin_designations.designation_id
                    JOIN xin_office_location ON emp.location_id = xin_office_location.location_id
                WHERE
                    LEFT(emp.date_of_joining, 7) = '$periode'
                GROUP BY
                    emp.user_id
                ),
                CalculatedDates AS (
                -- Tahap 2: Hitung Due Date berdasarkan Leadtime
                SELECT
                    b.*,
                    DATE(DATE_ADD(b.date_of_joining, INTERVAL(SELECT leadtime FROM m_onboarding WHERE id = 1) DAY)) AS due_date_1,
                    DATE(DATE_ADD(b.actual_tgl_1, INTERVAL(SELECT leadtime FROM m_onboarding WHERE id = 2) DAY)) AS due_date_2,
                    DATE(DATE_ADD(b.actual_tgl_2, INTERVAL(SELECT leadtime FROM m_onboarding WHERE id = 3) DAY)) AS due_date_3,
                    DATE(DATE_ADD(b.actual_tgl_3, INTERVAL(SELECT leadtime FROM m_onboarding WHERE id = 4) DAY)) AS due_date_4
                FROM
                    BaseOnboarding b
                )
                -- Tahap 3: Final Select dengan logika is_lanjut
                SELECT
                c.main_onb_id AS id,
                c.user_id,
                CONCAT(c.first_name, ' ', c.last_name) AS nama_karyawan,
                c.company,
                c.departement,
                c.date_of_joining,
                c.date_of_leaving,
                c.current_status_text AS status,
                -- Status 1: Training Class
                1 AS training_class,
                c.actual_tgl_1 AS actual_tgl_training,
                c.due_date_1,
                CASE
                    WHEN c.actual_tgl_1 IS NULL THEN
                        'In Progress'
                    WHEN c.is_lanjut_1 = '1'
                        AND c.actual_tgl_1 <= c.due_date_1 THEN
                        'Ontime'
                    WHEN c.is_lanjut_1 = '1'
                        AND c.actual_tgl_1 > c.due_date_1 THEN
                        'Late'
                    ELSE
                        'Tidak Lanjut'
                END AS status_ontime_training,
                -- Status 2: Assignment
                2 AS assignment,
                c.actual_tgl_2 AS actual_tgl_assignment,
                c.due_date_2,
                CASE
                    WHEN c.actual_tgl_2 IS NULL THEN
                        (CASE WHEN c.actual_tgl_1 IS NULL OR c.is_lanjut_1 != '1' THEN '-' ELSE 'In Progress' END)
                    WHEN c.is_lanjut_2 = '1'
                        AND c.actual_tgl_2 <= c.due_date_2 THEN
                        'Ontime'
                    WHEN c.is_lanjut_2 = '1'
                        AND c.actual_tgl_2 > c.due_date_2 THEN
                        'Late'
                    ELSE
                        'Tidak Lanjut'
                END AS status_ontime_assignment,
                -- Status 3: Office Tour
                3 AS office_tour,
                c.actual_tgl_3 AS actual_tgl_tour,
                c.due_date_3,
                CASE
                    WHEN c.actual_tgl_3 IS NULL THEN
                        (CASE WHEN c.actual_tgl_2 IS NULL OR c.is_lanjut_2 != '1' THEN '-' ELSE 'In Progress' END)
                    WHEN c.is_lanjut_3 = '1'
                        AND c.actual_tgl_3 <= c.due_date_3 THEN
                        'Ontime'
                    WHEN c.is_lanjut_3 = '1'
                        AND c.actual_tgl_3 > c.due_date_3 THEN
                        'Late'
                    ELSE
                        'Tidak Lanjut'
                END AS status_ontime_tour,
                -- Status 4: Serah Terima
                4 AS serah_terima,
                c.actual_tgl_4 AS actual_tgl_serah_terima,
                c.due_date_4,
                CASE
                    WHEN c.actual_tgl_4 IS NULL THEN
                        (CASE WHEN c.actual_tgl_3 IS NULL OR c.is_lanjut_3 != '1' THEN '-' ELSE 'In Progress' END)
                    WHEN c.is_lanjut_4 = '1'
                        AND c.actual_tgl_4 <= c.due_date_4 THEN
                        'Ontime'
                    WHEN c.is_lanjut_4 = '1'
                        AND c.actual_tgl_4 > c.due_date_4 THEN
                        'Late'
                    ELSE
                        'Tidak Lanjut'
                END AS status_ontime_serah_terima,
                -- Logika Nilai Posttest
                GREATEST(
                    IFNULL(CAST(NULLIF(tp.nilai_posttest, '') AS DECIMAL), 0),
                    IFNULL(CAST(NULLIF(tp.nilai_posttest2, '') AS DECIMAL), 0),
                    IFNULL(CAST(NULLIF(tp.nilai_posttest3, '') AS DECIMAL), 0)
                ) AS max_nilai,
                CASE
                    WHEN tp.id_test IS NULL THEN
                        'Not Tested'
                    WHEN GREATEST(
                            IFNULL(CAST(NULLIF(tp.nilai_posttest, '') AS DECIMAL), 0),
                            IFNULL(CAST(NULLIF(tp.nilai_posttest2, '') AS DECIMAL), 0),
                            IFNULL(CAST(NULLIF(tp.nilai_posttest3, '') AS DECIMAL), 0)
                        ) >= 80 THEN
                        'Lulus'
                    ELSE
                        'Belum Lulus'
                END AS status_test
                FROM
                CalculatedDates c
                LEFT JOIN trusmi_pretest tp ON tp.employe_id = c.user_id
                AND tp.id_training = 363
                ORDER BY
                c.last_update DESC;";
        return $this->db->query($query)->result();
    }
    function list_onboarding(){
        $query = "SELECT
                emp.user_id,
                CONCAT(emp.first_name, ' ', emp.last_name) AS nama,
                CONCAT(pic_req.first_name, ' ', pic_req.last_name) AS pic_nama,
                com.`alias` AS company,
                des.designation_name,
                emp.date_of_joining,
                'tst' AS status
                FROM
                xin_employees emp
                JOIN xin_companies com ON emp.company_id = com.company_id
                JOIN xin_designations des ON emp.designation_id = des.designation_id
                LEFT JOIN fack_personal_details fc ON fc.employee_id = emp.user_id
                LEFT JOIN xin_job_applications ja ON ja.application_id = fc.application_id
                AND ja.application_status = 7
                LEFT JOIN xin_jobs job ON job.job_id = ja.job_id
                LEFT JOIN xin_employees pic_req ON pic_req.user_id = job.pic
                WHERE
                -- emp.is_active = 1
                -- AND
                SUBSTR(emp.date_of_joining, 1, 10) BETWEEN '2026-02-01'
                AND '2026-02-30'
                AND fc.employee_id IS NOT NULL
                GROUP BY
                emp.user_id
                ORDER BY
                emp.date_of_joining DESC";
        return $this->db->query($query)->result();
    }

}
