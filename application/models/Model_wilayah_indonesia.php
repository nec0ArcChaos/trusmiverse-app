<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_wilayah_indonesia extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_province(){
        $this->db->select('*');
        $this->db->from('province');
        return $this->db->get()->result();
    }


    public function profile_data($id_sub_task, $user_id)
    {
        $query = "SELECT
                    st.id_sub_task,
                    st.id_task,
                        t.task AS goal,
                    st.sub_task AS strategy,
                    e.user_id,
                    CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                    d.designation_name AS jabatan,
                    CASE 
                        WHEN e.profile_picture IS NULL OR e.profile_picture='' OR e.profile_picture='no file' 
                            THEN 
                                CASE WHEN e.gender = 'Male' THEN 'default_male.jpg'
                                ELSE 'default_female.jpg'
                            END
                        ELSE COALESCE(e.profile_picture,'')
                    END AS photo_profile,
                    p.logo AS logo_perushaan,
                    COALESCE(st.target,0) AS target,
                    COALESCE(st.actual,0) AS actual,
                    COALESCE(st.progress,0) AS progress,
                    st.type AS id_type,
                    COALESCE (st.file, '') AS `file`,
                    stt.sub_type AS type,
                    st.`start`,
                    st.`end`,
                    COALESCE(st.jam_notif, '07:00') AS jam_notif,
                    COALESCE (
                        CASE
                            WHEN DATE_FORMAT(st.`start`, '%b %y') = DATE_FORMAT(st.`end`, '%b %y') THEN CONCAT(
                                DATE_FORMAT(st.`start`, '%d'),
                                '-',
                                DATE_FORMAT(st.`end`, '%d %b %y')
                            )
                            WHEN DATE_FORMAT(st.`start`, '%y') = DATE_FORMAT(st.`end`, '%y')
                            AND DATE_FORMAT(st.`start`, '%b') != DATE_FORMAT(st.`end`, '%b') THEN CONCAT(
                                DATE_FORMAT(st.`start`, '%d %b'),
                                ' - ',
                                DATE_FORMAT(st.`end`, '%d %b %y')
                            )
                            ELSE CONCAT(
                                DATE_FORMAT(st.`start`, '%d %b %y'),
                                ' - ',
                                DATE_FORMAT(st.`end`, '%d %b %y')
                            )
                        END,
                        ''
                    ) AS periode,
                    v.today,
                    CASE
                        WHEN st.type = 1 THEN ROUND(((1 /(DATEDIFF(st.`end`, st.`start`) + 1)) * 100), 2)
                        WHEN st.type = 2 THEN ROUND(((1 / st.target) * 100), 2)
                        WHEN st.type = 3 THEN ROUND(
                            (
                                (1 /(TIMESTAMPDIFF(MONTH, st.`start`, st.`end`) + 1)) * 100
                            ),
                            2
                        )
                        WHEN st.type = 4 THEN 50
                        ELSE 0
                    END `next_progress`,
                    DATEDIFF(st.`end`, st.`start`) + 1 AS jml_hari,
                    TIMESTAMPDIFF(MONTH, st.`start`, st.`end`) + 1 AS date_month,
                    vx.jml_week,
                    v.week_number,
                    v.`week_start_date`,
                    v.`week_end_date`
                FROM
                    td_sub_task st
                        LEFT JOIN td_task t ON t.id_task = st.id_task 
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, t.pic)
                        LEFT JOIN xin_designations d ON d.designation_id = e.designation_id
                        LEFT JOIN xin_companies p ON p.company_id = e.company_id
                    LEFT JOIN td_sub_type stt ON st.type = stt.id
                    LEFT JOIN (
                        SELECT
                            CURRENT_DATE AS today,
                            v.week_number,
                            v.week_start_date,
                            v.week_end_date
                        FROM
                            (
                                SELECT
                                    CONCAT(
                                        'W',
                                        ROW_NUMBER() OVER (
                                            ORDER BY
                                                WEEK(start_date)
                                        )
                                    ) AS `week_number`,
                                    MIN(start_date) AS `week_start_date`,
                                    MAX(start_date) AS `week_end_date`
                                FROM
                                    (
                                        SELECT
                                            ADDDATE(
                                                '1970-01-01',
                                                t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0
                                            ) AS start_date
                                        FROM
                                            (
                                                SELECT
                                                    0 t0
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t0,
                                            (
                                                SELECT
                                                    0 t1
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t1,
                                            (
                                                SELECT
                                                    0 t2
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t2,
                                            (
                                                SELECT
                                                    0 t3
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t3,
                                            (
                                                SELECT
                                                    0 t4
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t4
                                    ) v
                                    LEFT JOIN td_sub_task st ON v.start_date BETWEEN st.`start`
                                    AND st.`end`
                                WHERE
                                    st.id_sub_task = '$id_sub_task'
                                GROUP BY
                                    WEEK(start_date)
                                ORDER BY
                                    WEEK(start_date)
                            ) AS v
                        WHERE
                            CURRENT_DATE BETWEEN v.week_start_date
                            AND v.week_end_date
                    ) v ON v.today = CURRENT_DATE
                    LEFT JOIN (
                        SELECT
                            v.id_sub_task,
                            COUNT(v.week_number) AS jml_week,
                            MIN(v.week_start_date) AS week_start,
                            MAX(v.week_end_date) AS week_end
                        FROM
                            (
                                SELECT
                                    st.id_sub_task,
                                    CONCAT(
                                        'W',
                                        ROW_NUMBER() OVER (
                                            ORDER BY
                                                WEEK(start_date)
                                        )
                                    ) AS `week_number`,
                                    MIN(start_date) AS `week_start_date`,
                                    MAX(start_date) AS `week_end_date`
                                FROM
                                    (
                                        SELECT
                                            ADDDATE(
                                                '1970-01-01',
                                                t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0
                                            ) AS start_date
                                        FROM
                                            (
                                                SELECT
                                                    0 t0
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t0,
                                            (
                                                SELECT
                                                    0 t1
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t1,
                                            (
                                                SELECT
                                                    0 t2
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t2,
                                            (
                                                SELECT
                                                    0 t3
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t3,
                                            (
                                                SELECT
                                                    0 t4
                                                UNION
                                                SELECT
                                                    1
                                                UNION
                                                SELECT
                                                    2
                                                UNION
                                                SELECT
                                                    3
                                                UNION
                                                SELECT
                                                    4
                                                UNION
                                                SELECT
                                                    5
                                                UNION
                                                SELECT
                                                    6
                                                UNION
                                                SELECT
                                                    7
                                                UNION
                                                SELECT
                                                    8
                                                UNION
                                                SELECT
                                                    9
                                            ) t4
                                    ) v
                                    LEFT JOIN td_sub_task st ON v.start_date BETWEEN st.`start`
                                    AND st.`end`
                                WHERE
                                    st.id_sub_task = '$id_sub_task'
                                GROUP BY
                                    WEEK(start_date)
                                ORDER BY
                                    WEEK(start_date)
                            ) AS v
                    ) AS vx ON vx.id_sub_task = st.id_sub_task
                WHERE st.id_sub_task = '$id_sub_task'
                AND e.user_id = $user_id
                LIMIT 1";
        return $this->db->query($query)->row_array();
    }


}
