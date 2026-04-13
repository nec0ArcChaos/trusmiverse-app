<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_mm extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function ibr_pro_profile($user_id)
    {
        $query = "SELECT 
                    	-- t.id_task,
                        GROUP_CONCAT(t.id_task) AS id_task,
                    	t.task,
                    -- 	e.username,
                    	e.user_id,
                        CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                        d.designation_name AS jabatan,
                        CASE 
                            WHEN e.profile_picture IS NULL OR e.profile_picture='' OR e.profile_picture='no file' 
                                THEN 
                                    CASE 
                                        WHEN e.gender = 'Male' 
                                            THEN 'default_male.jpg'
                                        ELSE 'default_female.jpg'
                                    END
                            ELSE COALESCE(e.profile_picture,'')
                        END AS photo_profile,
                        p.logo AS logo_perushaan,
                        COUNT(t.id_task) AS goal,
                        COALESCE(strategy.jumlah,0) AS strategy
                    FROM xin_employees e 
                    LEFT JOIN td_task t ON FIND_IN_SET(e.user_id, t.pic)
                    LEFT JOIN xin_designations d ON d.designation_id = e.designation_id
                    LEFT JOIN xin_companies p ON p.company_id = e.company_id
                    LEFT JOIN (
                        SELECT
                            e.user_id,
                            COUNT(id_sub_task) AS jumlah
                        FROM td_sub_task st
                        LEFT JOIN td_task t ON t.id_task = st.id_task
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, t.pic)
                        GROUP BY e.user_id
                    ) strategy ON strategy.user_id = e.user_id
                    
                    WHERE e.user_id = $user_id
                    AND t.due_date >= CURRENT_DATE
                    GROUP BY e.user_id";
        return $this->db->query($query)->row_array();
    }

    public function get_goals($id_task)
    {
        $query = "SELECT 
                    td_task.id_task, 
                    td_task.task,
                    COALESCE(ev.evaluasi,'-') AS evaluasi
                FROM td_task 
                LEFT JOIN (
                    SELECT id_task, id_sub_task, evaluasi
                    FROM td_sub_task_history
                    WHERE (id_task, id) IN (
                            SELECT id_task, MAX(id) AS max_id
                            FROM td_sub_task_history
                                    WHERE evaluasi IS NOT NULL 
                                    AND evaluasi != ''
                            GROUP BY id_task
                    )
                ) ev ON ev.id_task = td_task.id_task
                WHERE td_task.id_task = '$id_task' LIMIT 1";
        return $this->db->query($query)->row_array();
    }

    // public function get_strategy($id_task)
    // {
    //     $query = "SELECT
    //                 t.`status` AS id_status,
    //                 s.`status` AS `status`,
    //                 st.id_sub_task,
    //                 st.id_task,
    //                 t.task AS goal,
    //                 st.sub_task AS strategy,
    //                 st.type AS id_type,
    //                 COALESCE (st.file, '') AS `file`,
    //                 stt.sub_type,
    //                 st.`start`,
    //                 st.`end`,
    //                 COALESCE (
    //                     CASE
    //                         WHEN DATE_FORMAT(st.`start`, '%b %y') = DATE_FORMAT(st.`end`, '%b %y') THEN CONCAT(
    //                             DATE_FORMAT(st.`start`, '%d'),
    //                             '-',
    //                             DATE_FORMAT(st.`end`, '%d %b %y')
    //                         )
    //                         WHEN DATE_FORMAT(st.`start`, '%y') = DATE_FORMAT(st.`end`, '%y')
    //                         AND DATE_FORMAT(st.`start`, '%b') != DATE_FORMAT(st.`end`, '%b') THEN CONCAT(
    //                             DATE_FORMAT(st.`start`, '%d %b'),
    //                             ' - ',
    //                             DATE_FORMAT(st.`end`, '%d %b %y')
    //                         )
    //                         ELSE CONCAT(
    //                             DATE_FORMAT(st.`start`, '%d %b %y'),
    //                             ' - ',
    //                             DATE_FORMAT(st.`end`, '%d %b %y')
    //                         )
    //                     END,
    //                     ''
    //                 ) AS periode,
    //                 COALESCE(st.target, 0) AS target,
    //                 COALESCE(x.jml_input, 0) AS jml_input,
    //                 COALESCE(x.jml_progress, 0) AS jml_progress,
    //                 COALESCE(x.consistency, 0) AS consistency,
    //                 COALESCE(ev.evaluasi,'-') AS evaluasi,
    //                 history_date.max_date
    //             FROM
    //                 td_sub_task st
    //                 LEFT JOIN td_sub_type stt ON st.type = stt.id
    //                 LEFT JOIN (
    //                     SELECT
    //                         his.id_sub_task,
    //                         his.id_task,
    //                         st.type,
    //                         CASE
    //                             WHEN st.type = 1 THEN ROUND(SUM(his.progress))
    //                             WHEN st.type = 2 THEN ROUND(his.progress * COUNT(DISTINCT his.week_number))
    //                             WHEN st.type = 3 THEN ROUND(
    //                                 his.progress * COUNT(DISTINCT SUBSTR(his.created_at, 1, 7))
    //                             )
    //                             WHEN st.type = 4 THEN IF(
    //                                 ROUND(SUM(his.progress)) >= 100,
    //                                 100,
    //                                 ROUND(SUM(his.progress))
    //                             )
    //                             ELSE 0
    //                         END AS jml_progress,
    //                         CASE
    //                             WHEN st.type = 1 
    //                                 THEN COUNT(his.created_at) 
    //                             WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' 
    //                                 THEN COUNT(DISTINCT his.week_number)
    //                             WHEN st.type = 3 
    //                                 THEN COUNT(DISTINCT SUBSTR(his.created_at,1,7))
    //                             WHEN st.type = 4 THEN 2
    //                             ELSE 0
    //                         END AS jml_input,
    //                         CASE
    //                             WHEN st.type = 1 THEN DATEDIFF(
    //                                 IF(CURRENT_DATE < st.`end`, CURRENT_DATE, st.`end`),
    //                                 st.`start`
    //                             ) + 1
    //                             WHEN st.type = 2 THEN COUNT(DISTINCT his.week_number)
    //                             WHEN st.type = 3 THEN 1
    //                             WHEN st.type = 4 THEN 2
    //                             ELSE 0
    //                         END AS target,
    //                         ROUND(
    //                             (
    //                                     CASE WHEN st.type = 1 THEN
    //                                         COUNT(his.created_at)
    //                                     WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' THEN 
    //                                         COUNT(DISTINCT his.week_number)
    //                                     WHEN st.type = 3 THEN 
    //                                         COUNT(DISTINCT SUBSTR(his.created_at,1,7))
    //                                     WHEN st.type = 4 THEN
    //                                         2
    //                                     ELSE
    //                                         0
    //                                     END 
    //                                     / st.target
    //                             ) * 100
    //                         ) AS consistency
    //                     FROM
    //                         (
    //                             SELECT
    //                                 sth.id_sub_task,
    //                                 sth.id_task,
    //                                 st.target,
    //                                 sth.progress,
    //                                 SUBSTR(sth.created_at, 1, 10) created_at,
    //                                 sth.week_number
    //                             FROM
    //                                 td_sub_task_history sth
    //                                 LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
    //                             WHERE sth.id_task = '$id_task' 
    //                             AND SUBSTR(sth.created_at, 1, 10) >= st.start
    //                             GROUP BY
    //                                 SUBSTR(sth.created_at, 1, 10),
    //                                 sth.id_sub_task
    //                         ) AS his
    //                         LEFT JOIN td_sub_task st ON st.id_sub_task = his.id_sub_task
    //                     GROUP BY
    //                         his.id_sub_task
    //                 ) AS x ON x.id_sub_task = st.id_sub_task
    //                 LEFT JOIN td_task t ON t.id_task = st.id_task
    //                 LEFT JOIN td_status s ON s.id = t.`status`
    //                 LEFT JOIN (
    //                     SELECT id_task, id_sub_task, evaluasi
    //                     FROM td_sub_task_history
    //                     WHERE (id_task, id) IN (
    //                             SELECT id_task, MAX(id) AS max_id
    //                             FROM td_sub_task_history
    //                                     WHERE evaluasi IS NOT NULL 
    //                                     AND evaluasi != ''
    //                             GROUP BY id_task
    //                     )
    //                 ) ev ON ev.id_task = st.id_task
    //                 LEFT JOIN (
    //                     SELECT id_task, id_sub_task, MAX(created_at) AS max_date FROM td_sub_task_history GROUP BY id_sub_task
    //                 ) history_date ON history_date.id_sub_task = st.id_sub_task
    //             WHERE
    //                 st.id_task = '$id_task'";
    //     return $this->db->query($query)->result();
    // }

    function get_consistency($user_id)
    {
        $query = "SELECT 
                    ROUND(SUM(task.consistency) / COUNT(task.consistency)) AS consistency
                FROM
                (SELECT
                    ROUND(COALESCE(
                        SUM(x.consistency) / COUNT(t.id_task),
                    0)) AS consistency
                FROM td_sub_task st
                LEFT JOIN td_sub_type stt ON st.type = stt.id
                LEFT JOIN (
                    SELECT
                        his.id_sub_task,
                        his.id_task,
                        ROUND(
                            (
                                CASE WHEN st.type = 1 THEN
                                        COUNT(his.created_at)
                                WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' THEN 
                                        COUNT(DISTINCT his.week_number)
                                WHEN st.type = 3 THEN 
                                        COUNT(DISTINCT SUBSTR(his.created_at,1,7))
                                WHEN st.type = 4 THEN
                                        2
                                ELSE
                                        0
                                END 
                                / st.target
                            ) * 100
                        ) AS consistency
                    FROM
                    (
                        SELECT
                            sth.id_sub_task,
                            sth.id_task,
                            st.target,
                            sth.progress,
                            SUBSTR(sth.created_at, 1, 10) created_at,
                            sth.week_number
                        FROM
                                td_sub_task_history sth
                                LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                                WHERE SUBSTR(sth.created_at, 1, 10) >= st.start
                        GROUP BY
                                SUBSTR(sth.created_at, 1, 10),
                                sth.id_sub_task
                    ) AS his
                            LEFT JOIN td_sub_task st ON st.id_sub_task = his.id_sub_task
                    GROUP BY
                            his.id_sub_task
                    ) AS x ON x.id_sub_task = st.id_sub_task
                    LEFT JOIN td_task t ON t.id_task = st.id_task
                    WHERE FIND_IN_SET ('$user_id', t.pic)
                    GROUP BY t.id_task
                ) task
                ;
                                                        
                                                        
                                                        ";
        return $this->db->query($query)->result();
    }


    public function ibr_pro_list_data()
    {
        $user_id = $_SESSION['user_id'];
        if ($user_id == 803) {
            // 786 = Abdul Goffar,
            // 1434 = Alfiyawati Santika,
            // 2 = Ali Yasin,
            // 1449 = Angga Nur Fardiansah,
            // 2964 = Bregas Prakoso,
            // 77 = Fani Fitrianingsih,
            // 331 = Feronita,
            // 2397 = Firman Tigoastomo Basuki,
            // 323 = Hendra Arya Cahyadi,
            // 1186 = Idham Nurhakim Dipura,
            // 90 = Indra Bayu Ramadhani,
            // 355 = Mochamad Ridwan,
            // 68 = Syekh Farhan Robbani,
            // 76 = Yeyen Nuryenti 
            // 6486 = Bella Admin HR 
            $cond = "AND e.user_id IN ('$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76','6486','1139')";
        } else {
            $cond = "";
        }
        $query = "SELECT 
                    	-- t.id_task,
                        GROUP_CONCAT(t.id_task) AS id_task,
                    	t.task,
                    -- 	e.username,
                    	e.user_id,
                        CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                        d.designation_name AS jabatan,
                        CASE 
                            WHEN e.profile_picture IS NULL OR e.profile_picture='' OR e.profile_picture='no file' 
                                THEN 
                                    CASE 
                                        WHEN e.gender = 'Male' 
                                            THEN 'default_male.jpg'
                                        ELSE 'default_female.jpg'
                                    END
                            ELSE COALESCE(e.profile_picture,'')
                        END AS photo_profile,
                        p.logo AS logo_perushaan,
                        COUNT(t.id_task) AS goal,
                        COALESCE(strategy.jumlah,0) AS strategy
                    FROM xin_employees e 
                    LEFT JOIN td_task t ON FIND_IN_SET(e.user_id, t.pic)
                    LEFT JOIN xin_designations d ON d.designation_id = e.designation_id
                    LEFT JOIN xin_companies p ON p.company_id = e.company_id
                    LEFT JOIN (
                        SELECT
                            e.user_id,
                            COUNT(id_sub_task) AS jumlah
                        FROM td_sub_task st
                        LEFT JOIN td_task t ON t.id_task = st.id_task
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, t.pic)
                        GROUP BY e.user_id
                    ) strategy ON strategy.user_id = e.user_id
                    WHERE t.id_task IS NOT NULL $cond
                    GROUP BY e.user_id";
        return $this->db->query($query)->result();
    }
}
