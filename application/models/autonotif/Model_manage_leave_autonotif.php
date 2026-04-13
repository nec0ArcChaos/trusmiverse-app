<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_manage_leave_autonotif extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function autonotif_all()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
        t.pic,
        st.`start`,
        st.notify_date,
        st.notify_count,
        COALESCE(st.jam_notif,'07:00') AS jam_notif,
        e.user_id,
        e.username,
        CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
        CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
        ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
        t.task,
        st.sub_task,
        tt.sub_type AS sub_type,
        COALESCE(st.evaluasi,'') AS evaluasi,
        st.id_sub_task,
        st.id_task,
        st.type AS id_sub_type,
        COALESCE(x.target_progress,st.target) AS target_progress,
        COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
        COALESCE(x.actual,0) AS actual,
        COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
        COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency
    FROM td_sub_task st
    LEFT JOIN td_task t ON t.id_task = st.id_task
    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
    LEFT JOIN
        (
        SELECT
                sth.id_sub_task,
                sth.id_task,
                st.target AS target_progress,
                DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1 AS target_cons,
                COUNT(DISTINCT SUBSTR( sth.created_at, 1, 10 )) AS actual 
        FROM
                td_sub_task_history sth
                LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                LEFT JOIN td_task t ON t.id_task = st.id_task 
        WHERE
                SUBSTR( sth.created_at, 1, 10 ) BETWEEN SUBSTR( st.`start`, 1, 10 ) 
                AND SUBSTR( st.`end`, 1, 10 ) 
                AND t.`status` = 2 AND st.type = 1
        GROUP BY
                sth.id_sub_task 
        ) AS x ON st.id_sub_task = x.id_sub_task
        LEFT JOIN td_sub_type tt ON tt.id = st.type
        LEFT JOIN (SELECT id_sub_task, MAX(SUBSTR(created_at,1,10)) AS input_terakhir FROM td_sub_task_history sth GROUP BY id_sub_task) AS t_sudah_input ON t_sudah_input.id_sub_task = st.id_sub_task
        WHERE t.`status` = 2 AND st.type = 1 AND CURRENT_DATE >= st.`start`
        AND CURRENT_DATE >= COALESCE(postponed_date,CURRENT_DATE) AND '$jam_sekarang' >= COALESCE(postponed_hour,'00:00') AND IF(SUBSTR(t_sudah_input.input_terakhir,1,10) = CURRENT_DATE, 1,0) = 0 AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1 AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100
				
				
				
UNION



SELECT
                    t.pic,
                    st.`start`,
										st.notify_date,
										st.notify_count,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target,st.target) AS target_progress,
                    COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
                    COALESCE(x.act_cons,0) AS actual,
                    COALESCE(x.p_progress,0) AS p_progress,
                    COALESCE(x.p_cons,0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN td_sub_task_history tsth ON tsth.id_sub_task = st.id_sub_task AND SUBSTR(tsth.created_at,1,10) = CURRENT_DATE
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                                            SELECT
                                                st.id_sub_task,
                                                st.`start`,
                                                st.`end`,
                                                t_date.day_date,
                                                st.target,
                                                COALESCE(act.act_progress,0) AS act_progress,
                                                ROUND(COALESCE(act.act_progress,0) / st.target * 100) AS p_progress,
                                                SUM(if(FIND_IN_SET(WEEKDAY(t_date.day_date),st.day_per_week),1,0)) AS target_cons,
                                                COALESCE(act.act_cons,0) AS act_cons,
                                                ROUND(COALESCE(act.act_cons,0) / st.target * 100) AS p_cons
                                            FROM
                                                td_sub_task st
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            LEFT JOIN (
                                            SELECT
                                                start_date AS `day_date`
                                            FROM (
                                                SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                            ) v
                                            WHERE start_date BETWEEN '2023-01-01' AND CURRENT_DATE
                                            GROUP BY (start_date)
                                            ORDER BY (start_date)
                                            ) t_date ON t_date.day_date >= st.`start` AND t_date.day_date <= st.`end`
                                            LEFT JOIN
                                            (



                                            SELECT
                                                xx.id_sub_task,
                                                SUM(xx.act_progress) AS act_progress,
                                                SUM(xx.act_cons) AS act_cons
                                            FROM(
                                            SELECT
                                                sth.id_sub_task,
                                                st.sub_task,
                                                st.day_per_week,
                                                sth.week_day,
                                                sth.week_number,
                                                SUBSTR(sth.created_at,1,10) AS h_created_at,
                                                COUNT(DISTINCT SUBSTR(sth.created_at,1,10)) AS act_progress,
                                                CASE WHEN st.day_per_week IS NULL OR st.day_per_week != '' THEN (IF(FIND_IN_SET(sth.week_day,st.day_per_week),1,0))
                                                ELSE
                                                    COUNT(DISTINCT week_number)
                                            END AS act_cons
                                            FROM
                                                td_sub_task_history sth
                                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task AND st.type = 2
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            WHERE CURRENT_DATE >= st.`start` AND sth.week_day IS NOT NULL AND sth.week_number IS NOT NULL AND sth.week_number != ''
                                            GROUP BY SUBSTR(sth.created_at,1,10),sth.id_sub_task
                                            ) AS xx GROUP BY xx.id_sub_task
                                            ) AS act ON act.id_sub_task = st.id_sub_task
                                                WHERE st.type = 2 AND CURRENT_DATE >= st.`start` AND st.day_per_week IS NOT NULL
                                                GROUP BY st.id_sub_task
                                            ORDER BY id_sub_task, day_date
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 2 AND CURRENT_DATE >= st.`start` AND SUBSTR(tsth.created_at,1,10) IS NULL AND CURRENT_DATE >= COALESCE(st.postponed_date,CURRENT_DATE) AND '$jam_sekarang' >= COALESCE(st.postponed_hour,'00:00')
                    AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1 AND COALESCE(x.p_progress,0) < 100 AND FIND_IN_SET(WEEKDAY(CURRENT_DATE), st.day_per_week)
										
										
UNION 



SELECT
                    t.pic,
                    st.`start`,
                    st.notify_date,
										st.notify_count,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target_progress,st.target) AS target_progress,
                    COALESCE(x.target_cons,0) AS target_cons,
                    COALESCE(x.actual,0) AS actual,
                    COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
                    COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                        SELECT
                            sth.id_sub_task,
                            sth.week_day,
                            st.target AS target_progress,
                            (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) AS target_cons,
                            COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) AS actual,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100)) AS p_progress,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) * 100)) AS p_cons
                        FROM
                            td_sub_task_history sth
                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task 
                        WHERE
                            st.type = 3 
                        GROUP BY
                            SUBSTR(
                                sth.created_at,
                            1,
                            7), st.id_sub_task
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 3 AND CURRENT_DATE >= st.`start` AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100 AND FIND_IN_SET(WEEKDAY(CURRENT_DATE),COALESCE(st.day_per_week,0))
         AND COALESCE(st.jam_notif,'07:00') = '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1";

        return $this->db->query($query)->result();
    }



    public function autonotif_kokatto_daily()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
                        xx.* 
                    FROM
                        (
                        SELECT
                            t.pic,
                            st.`start`,
                            st.notify_date,
                            st.notify_count,
                            COALESCE ( st.jam_notif, '07:00' ) AS jam_notif,
                            e.user_id,
                            e.username,
                        CASE
                                
                                WHEN LEFT ( REPLACE ( REPLACE ( e.contact_no, '-', '' ), '+', '' ), 1 ) = 0 THEN
                                CONCAT(
                                    '62',
                                SUBSTR( REPLACE ( REPLACE ( e.contact_no, '-', '' ), '+', '' ), 2 )) ELSE REPLACE ( REPLACE ( e.contact_no, '-', '' ), '+', '' ) 
                            END AS contact_no,
                            t.task,
                            st.sub_task,
                            tt.sub_type AS sub_type,
                            COALESCE ( st.evaluasi, '' ) AS evaluasi,
                            st.id_sub_task,
                            st.id_task,
                            st.type AS id_sub_type,
                            COALESCE ( x.target_progress, st.target ) AS target_progress,
                        COALESCE ( x.target_cons, DATEDIFF( IF ( CURRENT_DATE > st.END, st.END, CURRENT_DATE ), st.`start` )+ 1 ) AS target_cons,
                        COALESCE ( x.actual, 0 ) AS actual,
                        COALESCE ( round( x.actual / x.target_progress * 100 ), 0 ) AS p_progress,
                        COALESCE ( round( x.actual / x.target_cons * 100 ), 0 ) AS p_consistency 
                    FROM
                        td_sub_task st
                        LEFT JOIN td_task t ON t.id_task = st.id_task
                        LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                        LEFT JOIN (
                        SELECT
                            sth.id_sub_task,
                            sth.id_task,
                            st.target AS target_progress,
                        DATEDIFF( IF ( CURRENT_DATE > st.END, st.END, CURRENT_DATE ), st.`start` )+ 1 AS target_cons,
                        COUNT(
                        DISTINCT SUBSTR( sth.created_at, 1, 10 )) AS actual 
                    FROM
                        td_sub_task_history sth
                        LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                        LEFT JOIN td_task t ON t.id_task = st.id_task 
                    WHERE
                        SUBSTR( sth.created_at, 1, 10 ) BETWEEN SUBSTR( st.`start`, 1, 10 ) 
                        AND SUBSTR( st.`end`, 1, 10 ) 
                        AND t.`status` = 2 
                        AND st.type = 1 
                    GROUP BY
                        sth.id_sub_task 
                        ) AS x ON st.id_sub_task = x.id_sub_task
                        LEFT JOIN td_sub_type tt ON tt.id = st.type
                        LEFT JOIN ( SELECT id_sub_task, MAX( SUBSTR( created_at, 1, 10 )) AS input_terakhir FROM td_sub_task_history sth GROUP BY id_sub_task ) AS t_sudah_input ON t_sudah_input.id_sub_task = st.id_sub_task 
                    WHERE
                        t.`status` = 2 
                    AND st.type = 1 
                    AND CURRENT_DATE >= st.`start` 
                    AND CURRENT_DATE >= COALESCE ( postponed_date, CURRENT_DATE ) 
                    AND '$jam_sekarang' >= COALESCE ( postponed_hour, '00:00' ) 
                    AND IF( SUBSTR( t_sudah_input.input_terakhir, 1, 10 ) = CURRENT_DATE, 1, 0 ) = 0 
                    AND COALESCE ( st.jam_notif, '07:00' ) <= '$jam_sekarang' 
                    AND COALESCE ( st.notify_date, CURRENT_DATE ) <= CURRENT_DATE 
                    -- AND CASE WHEN COALESCE ( st.notify_date, CURRENT_DATE ) < CURRENT_DATE THEN 0 ELSE COALESCE ( st.notify_count, 0 ) END = 1 
                    AND st.notify_date = CURRENT_DATE AND COALESCE ( st.notify_count, 0 ) = 1 
                    AND COALESCE ( round( x.actual / x.target_progress * 100 ), 0 ) < 100 
                        ) AS xx 
                        -- WHERE xx.user_id IN (2063, 4078)
                    GROUP BY
                        xx.jam_notif,
                        xx.user_id,
                        xx.id_task";
        return $this->db->query($query)->result();
    }




    public function autonotif_all_dev()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
        t.pic,
        st.`start`,
        st.notify_date,
        st.notify_count,
        COALESCE(st.jam_notif,'07:00') AS jam_notif,
        e.user_id,
        e.username,
        CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
        CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
        ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
        t.task,
        st.sub_task,
        tt.sub_type AS sub_type,
        COALESCE(st.evaluasi,'') AS evaluasi,
        st.id_sub_task,
        st.id_task,
        st.type AS id_sub_type,
        COALESCE(x.target_progress,st.target) AS target_progress,
        COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
        COALESCE(x.actual,0) AS actual,
        COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
        COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency
    FROM td_sub_task st
    LEFT JOIN td_task t ON t.id_task = st.id_task
    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
    LEFT JOIN
        (
        SELECT
                sth.id_sub_task,
                sth.id_task,
                st.target AS target_progress,
                DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1 AS target_cons,
                COUNT(DISTINCT SUBSTR( sth.created_at, 1, 10 )) AS actual 
        FROM
                td_sub_task_history sth
                LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                LEFT JOIN td_task t ON t.id_task = st.id_task 
        WHERE
                SUBSTR( sth.created_at, 1, 10 ) BETWEEN SUBSTR( st.`start`, 1, 10 ) 
                AND SUBSTR( st.`end`, 1, 10 ) 
                AND t.`status` = 2 AND st.type = 1
        GROUP BY
                sth.id_sub_task 
        ) AS x ON st.id_sub_task = x.id_sub_task
        LEFT JOIN td_sub_type tt ON tt.id = st.type
        LEFT JOIN (SELECT id_sub_task, MAX(SUBSTR(created_at,1,10)) AS input_terakhir FROM td_sub_task_history sth GROUP BY id_sub_task) AS t_sudah_input ON t_sudah_input.id_sub_task = st.id_sub_task
        WHERE t.`status` = 2 AND st.type = 1 AND CURRENT_DATE >= st.`start`
        AND CURRENT_DATE >= COALESCE(postponed_date,CURRENT_DATE) 
        -- AND '$jam_sekarang' >= COALESCE(postponed_hour,'00:00') AND IF(SUBSTR(t_sudah_input.input_terakhir,1,10) = CURRENT_DATE, 1,0) = 0 AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1 AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100
				
				
				
UNION



SELECT
                    t.pic,
                    st.`start`,
										st.notify_date,
										st.notify_count,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target,st.target) AS target_progress,
                    COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
                    COALESCE(x.act_cons,0) AS actual,
                    COALESCE(x.p_progress,0) AS p_progress,
                    COALESCE(x.p_cons,0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN td_sub_task_history tsth ON tsth.id_sub_task = st.id_sub_task AND SUBSTR(tsth.created_at,1,10) = CURRENT_DATE
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                                            SELECT
                                                st.id_sub_task,
                                                st.`start`,
                                                st.`end`,
                                                t_date.day_date,
                                                st.target,
                                                COALESCE(act.act_progress,0) AS act_progress,
                                                ROUND(COALESCE(act.act_progress,0) / st.target * 100) AS p_progress,
                                                SUM(if(FIND_IN_SET(WEEKDAY(t_date.day_date),st.day_per_week),1,0)) AS target_cons,
                                                COALESCE(act.act_cons,0) AS act_cons,
                                                ROUND(COALESCE(act.act_cons,0) / st.target * 100) AS p_cons
                                            FROM
                                                td_sub_task st
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            LEFT JOIN (
                                            SELECT
                                                start_date AS `day_date`
                                            FROM (
                                                SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                            ) v
                                            WHERE start_date BETWEEN '2023-01-01' AND CURRENT_DATE
                                            GROUP BY (start_date)
                                            ORDER BY (start_date)
                                            ) t_date ON t_date.day_date >= st.`start` AND t_date.day_date <= st.`end`
                                            LEFT JOIN
                                            (



                                            SELECT
                                                xx.id_sub_task,
                                                SUM(xx.act_progress) AS act_progress,
                                                SUM(xx.act_cons) AS act_cons
                                            FROM(
                                            SELECT
                                                sth.id_sub_task,
                                                st.sub_task,
                                                st.day_per_week,
                                                sth.week_day,
                                                sth.week_number,
                                                SUBSTR(sth.created_at,1,10) AS h_created_at,
                                                COUNT(DISTINCT SUBSTR(sth.created_at,1,10)) AS act_progress,
                                                CASE WHEN st.day_per_week IS NULL OR st.day_per_week != '' THEN (IF(FIND_IN_SET(sth.week_day,st.day_per_week),1,0))
                                                ELSE
                                                    COUNT(DISTINCT week_number)
                                            END AS act_cons
                                            FROM
                                                td_sub_task_history sth
                                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task AND st.type = 2
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            WHERE CURRENT_DATE >= st.`start` AND sth.week_day IS NOT NULL AND sth.week_number IS NOT NULL AND sth.week_number != ''
                                            GROUP BY SUBSTR(sth.created_at,1,10),sth.id_sub_task
                                            ) AS xx GROUP BY xx.id_sub_task
                                            ) AS act ON act.id_sub_task = st.id_sub_task
                                                WHERE st.type = 2 AND CURRENT_DATE >= st.`start` AND st.day_per_week IS NOT NULL
                                                GROUP BY st.id_sub_task
                                            ORDER BY id_sub_task, day_date
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 2 AND CURRENT_DATE >= st.`start` AND SUBSTR(tsth.created_at,1,10) IS NULL AND CURRENT_DATE >= COALESCE(st.postponed_date,CURRENT_DATE) AND '$jam_sekarang' >= COALESCE(st.postponed_hour,'00:00')
                    AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1 AND COALESCE(x.p_progress,0) < 100
										
										
UNION 



SELECT
                    t.pic,
                    st.`start`,
                    st.notify_date,
										st.notify_count,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target_progress,st.target) AS target_progress,
                    COALESCE(x.target_cons,0) AS target_cons,
                    COALESCE(x.actual,0) AS actual,
                    COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
                    COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                        SELECT
                            sth.id_sub_task,
                            sth.week_day,
                            st.target AS target_progress,
                            (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) AS target_cons,
                            COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) AS actual,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100)) AS p_progress,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) * 100)) AS p_cons
                        FROM
                            td_sub_task_history sth
                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task 
                        WHERE
                            st.type = 3 
                        GROUP BY
                            SUBSTR(
                                sth.created_at,
                            1,
                            7), st.id_sub_task
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 3 AND CURRENT_DATE >= st.`start` AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100 AND FIND_IN_SET(WEEKDAY(CURRENT_DATE),COALESCE(st.day_per_week,0))
         AND COALESCE(st.jam_notif,'07:00') = '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 1";

        return $this->db->query($query)->result();
    }


    public function autonotif_daily()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
        t.pic,
        st.`start`,
        st.notify_date,
        st.notify_count,
        COALESCE(st.jam_notif,'07:00') AS jam_notif,
        e.user_id,
        e.username,
        CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
        CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
        ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
        t.task,
        st.sub_task,
        tt.sub_type AS sub_type,
        COALESCE(st.evaluasi,'') AS evaluasi,
        st.id_sub_task,
        st.id_task,
        st.type AS id_sub_type,
        COALESCE(x.target_progress,st.target) AS target_progress,
        COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
        COALESCE(x.actual,0) AS actual,
        COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
        COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency,
        t_sudah_input.input_terakhir,
        IF(SUBSTR(t_sudah_input.input_terakhir,1,10) = CURRENT_DATE, 1,0) AS sudah_input
    FROM td_sub_task st
    LEFT JOIN td_task t ON t.id_task = st.id_task
    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
    LEFT JOIN
        (
        SELECT
                sth.id_sub_task,
                sth.id_task,
                st.target AS target_progress,
                DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1 AS target_cons,
                COUNT(DISTINCT SUBSTR( sth.created_at, 1, 10 )) AS actual 
        FROM
                td_sub_task_history sth
                LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                LEFT JOIN td_task t ON t.id_task = st.id_task 
        WHERE
                SUBSTR( sth.created_at, 1, 10 ) BETWEEN SUBSTR( st.`start`, 1, 10 ) 
                AND SUBSTR( st.`end`, 1, 10 ) 
                AND t.`status` = 2 AND st.type = 1
        GROUP BY
                sth.id_sub_task 
        ) AS x ON st.id_sub_task = x.id_sub_task
        LEFT JOIN td_sub_type tt ON tt.id = st.type
        LEFT JOIN (SELECT id_sub_task, MAX(SUBSTR(created_at,1,10)) AS input_terakhir FROM td_sub_task_history sth GROUP BY id_sub_task) AS t_sudah_input ON t_sudah_input.id_sub_task = st.id_sub_task
        WHERE t.`status` = 2 AND st.type = 1 AND CURRENT_DATE >= st.`start`
        AND CURRENT_DATE >= COALESCE(postponed_date,CURRENT_DATE) AND '$jam_sekarang' >= COALESCE(postponed_hour,'00:00') AND IF(SUBSTR(t_sudah_input.input_terakhir,1,10) = CURRENT_DATE, 1,0) = 0 AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 2 AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100";
        return $this->db->query($query)->result();
    }


    public function autonotif_weekly()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
                    t.pic,
                    st.`start`,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target,st.target) AS target_progress,
                    COALESCE(x.target_cons,DATEDIFF(IF(CURRENT_DATE > st.end,st.end,CURRENT_DATE), st.`start`)+1) AS target_cons,
                    COALESCE(x.act_cons,0) AS actual,
                    COALESCE(x.p_progress,0) AS p_progress,
                    COALESCE(x.p_cons,0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN td_sub_task_history tsth ON tsth.id_sub_task = st.id_sub_task AND SUBSTR(tsth.created_at,1,10) = CURRENT_DATE
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                                            SELECT
                                                st.id_sub_task,
                                                st.`start`,
                                                st.`end`,
                                                t_date.day_date,
                                                st.target,
                                                COALESCE(act.act_progress,0) AS act_progress,
                                                ROUND(COALESCE(act.act_progress,0) / st.target * 100) AS p_progress,
                                                SUM(if(FIND_IN_SET(WEEKDAY(t_date.day_date),st.day_per_week),1,0)) AS target_cons,
                                                COALESCE(act.act_cons,0) AS act_cons,
                                                ROUND(COALESCE(act.act_cons,0) / st.target * 100) AS p_cons
                                            FROM
                                                td_sub_task st
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            LEFT JOIN (
                                            SELECT
                                                start_date AS `day_date`
                                            FROM (
                                                SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                    (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                    (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                    (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                    (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                    (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                            ) v
                                            WHERE start_date BETWEEN '2023-01-01' AND CURRENT_DATE
                                            GROUP BY (start_date)
                                            ORDER BY (start_date)
                                            ) t_date ON t_date.day_date >= st.`start` AND t_date.day_date <= st.`end`
                                            LEFT JOIN
                                            (



                                            SELECT
                                                xx.id_sub_task,
                                                SUM(xx.act_progress) AS act_progress,
                                                SUM(xx.act_cons) AS act_cons
                                            FROM(
                                            SELECT
                                                sth.id_sub_task,
                                                st.sub_task,
                                                st.day_per_week,
                                                sth.week_day,
                                                sth.week_number,
                                                SUBSTR(sth.created_at,1,10) AS h_created_at,
                                                COUNT(DISTINCT SUBSTR(sth.created_at,1,10)) AS act_progress,
                                                CASE WHEN st.day_per_week IS NULL OR st.day_per_week != '' THEN (IF(FIND_IN_SET(sth.week_day,st.day_per_week),1,0))
                                                ELSE
                                                    COUNT(DISTINCT week_number)
                                            END AS act_cons
                                            FROM
                                                td_sub_task_history sth
                                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task AND st.type = 2
                                            JOIN td_task t ON t.id_task = st.id_task AND t.`status` = 2
                                            WHERE CURRENT_DATE >= st.`start` AND sth.week_day IS NOT NULL AND sth.week_number IS NOT NULL AND sth.week_number != ''
                                            GROUP BY SUBSTR(sth.created_at,1,10),sth.id_sub_task
                                            ) AS xx GROUP BY xx.id_sub_task
                                            ) AS act ON act.id_sub_task = st.id_sub_task
                                                WHERE st.type = 2 AND CURRENT_DATE >= st.`start` AND st.day_per_week IS NOT NULL
                                                GROUP BY st.id_sub_task
                                            ORDER BY id_sub_task, day_date
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 2 AND CURRENT_DATE >= st.`start` AND SUBSTR(tsth.created_at,1,10) IS NULL AND CURRENT_DATE >= COALESCE(st.postponed_date,CURRENT_DATE) AND '$jam_sekarang' >= COALESCE(st.postponed_hour,'00:00')
                    AND COALESCE(st.jam_notif,'07:00') <= '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 2 AND COALESCE(x.p_progress,0) < 100
                    ";
        return $this->db->query($query)->result();
    }

    public function autonotif_monthly()
    {
        $jam_sekarang = date("H:i");
        $query = "SELECT
                    t.pic,
                    st.`start`,
                    st.day_per_week,
                    WEEKDAY(CURRENT_DATE) AS week_day,
                    COALESCE(st.jam_notif,'07:00') AS jam_notif,
                    e.user_id,
                    e.username,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no,
                    t.task,
                    st.sub_task,
                    tt.sub_type AS sub_type,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.id_sub_task,
                    st.id_task,
                    st.type AS id_sub_type,
                    COALESCE(x.target_progress,st.target) AS target_progress,
                    COALESCE(x.target_cons,0) AS target_cons,
                    COALESCE(x.actual,0) AS actual,
                    COALESCE(round(x.actual / x.target_progress * 100),0) AS p_progress,
                    COALESCE(round(x.actual / x.target_cons * 100),0) AS p_consistency
                FROM td_sub_task st
                LEFT JOIN td_task t ON t.id_task = st.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                LEFT JOIN
                    (
                        SELECT
                            sth.id_sub_task,
                            sth.week_day,
                            st.target AS target_progress,
                            (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) AS target_cons,
                            COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) AS actual,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100)) AS p_progress,
                            if(ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / st.target * 100) > 100, 100, ROUND(COUNT(DISTINCT SUBSTR( sth.created_at, 1, 7 )) / (TIMESTAMPDIFF(MONTH,`start`,CURRENT_DATE) + 1) * 100)) AS p_cons
                        FROM
                            td_sub_task_history sth
                            JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task 
                        WHERE
                            st.type = 3 
                        GROUP BY
                            SUBSTR(
                                sth.created_at,
                            1,
                            7), st.id_sub_task
                    ) AS x ON st.id_sub_task = x.id_sub_task
                    LEFT JOIN td_sub_type tt ON tt.id = st.type
                    WHERE t.`status` = 2 AND st.type = 3 AND CURRENT_DATE >= st.`start` AND COALESCE(round(x.actual / x.target_progress * 100),0) < 100 AND FIND_IN_SET(WEEKDAY(CURRENT_DATE),COALESCE(st.day_per_week,0))
         AND COALESCE(st.jam_notif,'07:00') = '$jam_sekarang' AND COALESCE(st.notify_date,CURRENT_DATE) <= CURRENT_DATE AND CASE WHEN COALESCE(st.notify_date,CURRENT_DATE) < CURRENT_DATE THEN 0 ELSE COALESCE(st.notify_count,0) END < 2
         ";
        return $this->db->query($query)->result();
    }


    public function autonotif_twice()
    {
        $jam_sekarang = date("H:00");
        $query = "SELECT
                    t.`status` AS id_status,
                    s.`status` AS `status`,
                    st.id_sub_task,
                    st.id_task,
                    t.task,
                    st.sub_task,
                    COALESCE(st.evaluasi,'') AS evaluasi,
                    st.type AS id_type,
                    COALESCE ( st.file, '' ) AS `file`,
                    stt.sub_type,
                    st.`start`,
                    st.`end`,
                    COALESCE (
                        CASE WHEN DATE_FORMAT( st.`start`, '%b %y' ) = DATE_FORMAT( st.`end`, '%b %y' ) THEN
                        CONCAT(DATE_FORMAT( st.`start`, '%d' ),'-',DATE_FORMAT( st.`end`, '%d %b %y' )) 
                    WHEN DATE_FORMAT( st.`start`, '%y' ) = DATE_FORMAT( st.`end`, '%y' ) AND DATE_FORMAT( st.`start`, '%b' ) != DATE_FORMAT( st.`end`, '%b' ) THEN
                        CONCAT(DATE_FORMAT( st.`start`, '%d %b' ),' - ',DATE_FORMAT( st.`end`, '%d %b %y' )) ELSE 
                        CONCAT(DATE_FORMAT( st.`start`, '%d %b %y' ),' - ',DATE_FORMAT( st.`end`, '%d %b %y' )) 
                    END,
                    '' ) AS periode,
                    st.target,
                    CASE WHEN st.type = 1 THEN
                        CONCAT(st.target, ' Hari') 
                    WHEN st.type = 2 THEN
                        CONCAT(st.target, ' Minggu') 
                    WHEN st.type = 3 THEN
                        CONCAT(st.target, ' Bulan') 
                    WHEN st.type = 4 THEN
                        CONCAT(st.target, ' Kali') 
                    ELSE 
                        CONCAT(st.target, '') 
                    END AS target_ket,
                    st.actual,
                    CASE WHEN st.type = 1 THEN
                        CONCAT(st.actual, ' Hari') 
                    WHEN st.type = 2 THEN
                        CONCAT(st.actual, ' Minggu') 
                    WHEN st.type = 3 THEN
                        CONCAT(st.actual, ' Bulan') 
                    WHEN st.type = 4 THEN
                        CONCAT(st.actual, ' Kali') 
                    ELSE 
                        CONCAT(st.actual, '') 
                    END AS actual_ket,
                    COALESCE(x.jml_progress,0) AS jml_progress,
                    COALESCE(x.consistency,0) AS consistency,
                    st.jam_notif
                FROM
                    td_sub_task st
                LEFT JOIN td_sub_type stt ON st.type = stt.id
                LEFT JOIN (
                    SELECT
                    his.id_sub_task,
                    his.id_task,
                    st.type,
                    CASE WHEN st.type = 1 THEN
                        ROUND(SUM( his.progress ))
                        WHEN st.type = 2 THEN
                        ROUND(his.progress * COUNT( DISTINCT his.week_number )) 
                        WHEN st.type = 3 THEN
                        ROUND(his.progress * COUNT( DISTINCT SUBSTR(his.created_at,1,7) ))
                        WHEN st.type = 4 THEN
                        IF(ROUND(SUM( his.progress ))>=100,100,ROUND(SUM( his.progress ))) ELSE 0 
                    END AS jml_progress,
                    COUNT(his.created_at) AS jml_input,
                    CASE WHEN st.type = 1 THEN
                        DATEDIFF(IF(CURRENT_DATE < st.`end`,CURRENT_DATE, st.`end`) ,st.`start`) + 1 
                    WHEN st.type = 2 THEN
                        COUNT(DISTINCT his.week_number)
                    WHEN st.type = 3 THEN
                        1
                    WHEN st.type = 4 THEN
                        2
                    ELSE
                        0	
                    END AS target,
                    ROUND(
                        (
                                CASE WHEN st.type = 1 THEN
                                    COUNT(his.created_at)
                                WHEN st.type = 2 THEN 
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
                    FROM (
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
                        GROUP BY
                        SUBSTR( sth.created_at, 1, 10 ),
                        sth.id_sub_task
                    ) AS his
                    LEFT JOIN td_sub_task st ON st.id_sub_task = his.id_sub_task
                    GROUP BY his.id_sub_task
                    ) AS x ON x.id_sub_task = st.id_sub_task
                    LEFT JOIN td_task t ON t.id_task = st.id_task
                    LEFT JOIN td_status s ON s.id = t.`status`
                WHERE st.type = 4 AND t.`status` = 2 AND COALESCE(st.jam_notif,'07:00') = '$jam_sekarang'";
        return $this->db->query($query)->result();
    }
}
