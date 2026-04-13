<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_ibr_pro_calendar extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function ibr_pro_calendar($user_id)
    {
        // $user_id = $this->session->userdata("user_id");
        $query = "SELECT xx.* FROM(
        
                SELECT
                    st.id_sub_task AS id_sub_task,
                    st.sub_task AS title,
                    x.jml_progress AS progress,
                    x.consistency AS consistency,
                    st.type,
                    st.target,
                    st.actual,
                    CASE WHEN st.type = 1 THEN
                        'regular-event cursor-pointer'
                    WHEN st.type = 2 THEN
                        'task-event cursor-pointer'
                    WHEN st.type = 3 THEN
                        'reminder-event cursor-pointer'
                    ELSE 'meeting-event cursor-pointer' END AS className,
                    st.`start` AS `start`,
                    st.`end` + INTERVAL 1 DAY AS `end`
                FROM
                    `td_sub_task` st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN (
                        SELECT
                            his.id_sub_task,
                            his.id_task,
                            st.type,
                        CASE WHEN st.type = 1 THEN
                                ROUND(
                                SUM( his.progress )) 
                                WHEN st.type = 2 THEN
                                ROUND(
                                his.progress * COUNT( DISTINCT his.week_number )) 
                                WHEN st.type = 3 THEN
                                ROUND(
                                his.progress * COUNT( DISTINCT SUBSTR( his.created_at, 1, 7 ) )) 
                                WHEN st.type = 4 THEN
                            IF
                                (
                                    ROUND(
                                    SUM( his.progress ))>= 100,
                                    100,
                                    ROUND(
                                    SUM( his.progress ))) ELSE 0 
                            END AS jml_progress,
                            COUNT( his.created_at ) AS jml_input,
                        CASE
                                
                                WHEN st.type = 1 THEN
                                DATEDIFF( IF ( CURRENT_DATE < st.`end`, CURRENT_DATE, st.`end` ), st.`start` ) + 1 
                                WHEN st.type = 2 THEN
                                COUNT( DISTINCT his.week_number ) 
                                WHEN st.type = 3 THEN
                                1 
                                WHEN st.type = 4 THEN
                                2 ELSE 0 
                            END AS `target`,
                            ROUND(
                                (
                                CASE
                                        
                                        WHEN st.type = 1 THEN
                                        COUNT( his.created_at ) 
                                        WHEN st.type = 2 THEN
                                        COUNT( DISTINCT his.week_number ) 
                                        WHEN st.type = 3 THEN
                                        COUNT(
                                        DISTINCT SUBSTR( his.created_at, 1, 7 )) 
                                        WHEN st.type = 4 THEN
                                        2 ELSE 0 
                                    END / st.target 
                                ) * 100 
                            ) AS consistency 
                        FROM
                            (
                            SELECT
                                sth.id_sub_task,
                                sth.id_task,
                                st.target,
                                sth.progress,
                                SUBSTR( sth.created_at, 1, 10 ) created_at,
                                sth.week_number 
                            FROM
                                td_sub_task_history sth
                                LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                                LEFT JOIN td_task t ON t.id_task = st.id_task
                            WHERE
                                FIND_IN_SET('$user_id',t.pic)
                            GROUP BY
                                SUBSTR( sth.created_at, 1, 10 ),
                                sth.id_sub_task 
                            ) AS his
                            LEFT JOIN td_sub_task st ON st.id_sub_task = his.id_sub_task 
                        GROUP BY
                            his.id_sub_task 
                ) AS x ON x.id_sub_task = st.id_sub_task
                WHERE FIND_IN_SET('$user_id', t.pic)
                -- UNION
                -- -- Dailiy
                -- SELECT 
                --     m.type AS resourceId,
                --     m.id_sub_task AS groupId,
                --     CASE WHEN daily.created_at IS NULL THEN 'no' ELSE 'yes' END AS title,
                --     '' AS progress,
                --     '' AS consistency,
                --     m.type,
                --     CASE WHEN daily.created_at IS NULL THEN 'bg-danger text-white' ELSE 'bg-primary text-white' END AS className,
                --     m.tgl AS `start`,
                --     m.tgl AS `end`	
                -- FROM (

                -- SELECT
                --     st.id_task,
                --     st.id_sub_task,
                --     st.type,
                --     st.`start` + INTERVAL a + b DAY tgl
                -- FROM
                --     (
                --     SELECT
                --         0 a UNION
                --     SELECT
                --         1 a UNION
                --     SELECT
                --         2 UNION
                --     SELECT
                --         3 UNION
                --     SELECT
                --         4 UNION
                --     SELECT
                --         5 UNION
                --     SELECT
                --         6 UNION
                --     SELECT
                --         7 UNION
                --     SELECT
                --         8 UNION
                --     SELECT
                --         9 
                --     ) d,
                --     ( SELECT 0 b UNION SELECT 10 UNION SELECT 20 UNION SELECT 30 UNION SELECT 40 ) m,
                --     td_sub_task st
                -- WHERE
                --     st.`start` + INTERVAL a + b DAY <= st.`end` AND st.type = 1 AND st.created_by = '$user_id'
                -- ORDER BY
                --     st.id_task, st.id_sub_task, (st.`start` + INTERVAL a + b DAY)
                    
                --     ) AS m
                --     LEFT JOIN (
                --                 SELECT
                --                     st.id_sub_task,
                --                     st.progress,
                --                     SUBSTR(sth.created_at,1,10) AS created_at
                --                 FROM
                --                     td_sub_task_history sth
                --                     JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                --                 WHERE
                --                     sth.created_by = '$user_id' AND st.type = 1
                --                     GROUP BY SUBSTR(sth.created_at,1,10), st.id_sub_task
                --                             ) AS daily ON daily.id_sub_task = m.id_sub_task AND daily.created_at = m.tgl
                -- -- Weekly
                -- UNION
                -- SELECT
                --     m.type AS resourceId,
                --     m.id_sub_task AS groupId,
                --     CASE WHEN sthw.created_at IS NULL THEN 'no' ELSE 'yes' END AS title,
                --     '' AS progress,
                --     '' AS consistency,
                --     m.type,
                --     CASE WHEN sthw.created_at IS NULL THEN 'bg-danger text-white' ELSE 'bg-primary text-white' END AS className,
                --     m.week_start_date AS `start`,
                --     m.week_end_date AS `end`
                -- FROM (
                -- (SELECT 
                --     st.id_sub_task,
                --     st.type,
                --     CONCAT('W', ROW_NUMBER() OVER (ORDER BY WEEK(start_date))) AS `week_number`, 
                -- MIN(start_date) AS `week_start_date`, MAX(start_date) AS `week_end_date`
                -- FROM (
                -- SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                -- FROM
                --     (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                --     (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                --     (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                --     (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                --     (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                -- ) v
                -- JOIN ( 
                -- SELECT
                --     st.id_sub_task,
                --     st.type,
                --     'week' AS param,
                --     MIN( st.`start` ) AS `start`,
                --     MAX( st.`end` ) AS `end` 
                -- FROM
                --     td_sub_task st
                -- JOIN td_task t ON t.id_task = st.id_task
                -- WHERE FIND_IN_SET('$user_id',t.pic) AND st.type = 2
                -- GROUP BY st.id_sub_task
                -- ) st ON st.param = 'week'
                -- WHERE start_date BETWEEN st.`start` AND st.`end`
                -- GROUP BY WEEK(start_date)
                -- ORDER BY WEEK(start_date))
                -- ) m
                -- LEFT JOIN (
                --     SELECT 
                --         sth.id_sub_task,
                --         sth.week_number,
                --         sth.week_start_date,
                --         sth.week_end_date,
                --         SUBSTR(sth.created_at,1,10) AS created_at
                --     FROM td_sub_task_history sth 
                --     JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                --     JOIN td_task t ON t.id_task = st.id_task
                --     WHERE FIND_IN_SET('$user_id',t.pic) AND st.type = 2
                --     GROUP BY sth.id_sub_task, sth.week_number
                -- ) sthw ON sthw.id_sub_task = m.id_sub_task AND sthw.week_number = m.week_number AND sthw.week_start_date = m.week_start_date AND sthw.week_end_date = m.week_end_date
                
                ) AS xx
                ";
        return $this->db->query($query)->result();
    }


    public function ibr_pro_calendar_v2($user_id)
    {

        // get max end date from strategy
        $query_max_date = "SELECT MAX(t.end) max_date FROM `td_task` t WHERE FIND_IN_SET( '803', t.pic ) OR t.created_by = '803'";
        $get_max_date = $this->db->query($query_max_date)->row();
        $max_date = $get_max_date->max_date;
        $query_tgl = "SELECT 
                            x.tgl AS `start`,
                            x.tgl AS `end`,
                            GROUP_CONCAT(DISTINCT t.id_sub_task) AS id_sub_task,
                            CONCAT(SUM(IF(t.id_sub_task IS NOT NULL, 1,0)), ' Act') AS title,
                            CASE WHEN SUM(IF(t.id_sub_task IS NOT NULL, 1,0)) <= 5 THEN
                                'regular-event cursor-pointer'
                            WHEN SUM(IF(t.id_sub_task IS NOT NULL, 1,0)) > 5 AND SUM(IF(t.id_sub_task IS NOT NULL, 1,0)) <= 10  THEN
                                'task-event cursor-pointer'
                            ELSE 'birthday-event cursor-pointer' END AS className
                        
                        FROM(
                        SELECT tgl
                        FROM (
                        SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS tgl
                        FROM
                            (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                            (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                            (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                            (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                            (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE tgl BETWEEN '2023-12-01' AND '$max_date' 
                        GROUP BY tgl
                        ORDER BY tgl
                        ) AS x
                        LEFT JOIN (
                        SELECT
                            t.id_task,
                            st.id_sub_task,
                            st.`start`,
                            st.`end` 
                        FROM
                            ( SELECT t.id_task FROM `td_task` t WHERE FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' ) AS t
                            LEFT JOIN td_sub_task st ON st.id_task = t.id_task
                        ) AS t ON DATE(x.tgl) BETWEEN DATE(t.`start`) AND DATE(t.`end`)
                        WHERE t.id_sub_task IS NOT NULL
                        GROUP BY x.tgl";
        return $this->db->query($query_tgl)->result();
    }

    public function ibr_pro_calendar_v2_detail($id_sub_task)
    {
        $explode_id_sub_task = explode(",", $id_sub_task);
        $implode_id_sub_task = implode(",", $explode_id_sub_task);
        $query_strategy = "SELECT
                    t.created_by,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    em.username AS owner_username,
                    CONCAT(em.first_name, ' ', em.last_name) AS owner_name,
                    em.profile_picture AS owner_photo,
                    d.department_name AS owner_department,
                    cmp.name AS owner_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name)) AS team_name,
                    GROUP_CONCAT(DISTINCT CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' AND e.profile_picture != 'no file' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END) AS profile_picture_pic,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    st.id_sub_task,
                    t.task,
                    t.indicator,
                    t.progress,
                    GROUP_CONCAT(DISTINCT COALESCE(st.sub_task,'')) AS strategy,
                    COALESCE(t.jenis_strategy,'') AS jenis_strategy,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(CASE WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.START, '%d' ), '-', DATE_FORMAT( t.END, '%d %b %y' ))
	WHEN  DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN CONCAT(DATE_FORMAT( t.START, '%d %b' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' ))
	ELSE CONCAT(DATE_FORMAT( t.START, '%d %b %y' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' )) END,'') AS timeline,
                    t.type AS id_type,
                    ty.type,
                    st.type AS id_sub_type,
                    sty.sub_type AS sub_type,
                    t.category AS id_category,
                    c.category,
                    t.object AS id_object,
                    o.object,
                    t.priority AS id_priority,
                    p.priority,
                    p.color AS priority_color,
                    t.`status` AS id_status,
                    s.`status`,
                    s.`color` AS status_color,
                    pic AS id_pic,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-danger' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-warning' 
                    ELSE 'bg-primary' END AS due_date_style
                FROM
                    `td_task` t
                    LEFT JOIN td_sub_task st ON st.id_task = t.id_task
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN td_sub_type sty ON sty.id = st.type
                    LEFT JOIN td_type ty ON ty.id = t.type
                    LEFT JOIN td_category c ON c.id = t.category
                    LEFT JOIN td_object o ON o.id = t.object
                    LEFT JOIN td_status s ON s.id = t.`status`
                    LEFT JOIN td_priority p ON p.id = t.priority
                    WHERE FIND_IN_SET(st.id_sub_task,'$implode_id_sub_task')
                    GROUP BY st.id_sub_task ORDER BY t.created_at DESC";
        return $this->db->query($query_strategy)->result();
    }
}
