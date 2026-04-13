<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_monday extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    public function get_type()
    {
        return $this->db->query("SELECT id AS id_type, `type` FROM td_type")->result();
    }
    public function get_all_category()
    {
        return $this->db->query("SELECT id AS id_category, `category` FROM td_category")->result();
    }
    public function get_category($id_type)
    {
        return $this->db->query("SELECT id AS id_category, `category` FROM td_category WHERE `type` = '$id_type'")->result();
    }
    public function get_all_object()
    {
        return  $this->db->query("SELECT id AS id_object, `object` FROM td_object")->result();
    }
    public function get_object($id_category)
    {
        return  $this->db->query("SELECT id AS id_object, `object` FROM td_object WHERE `category` = '$id_category'")->result();
    }
    public function get_status()
    {
        return  $this->db->query("SELECT id AS id_status, `status`, `color` FROM td_status")->result();
    }
    public function get_pic()
    {
        $user_id = $this->session->userdata('user_id');
        $cond = "AND ur.level_sto >= 2";
        if ($user_id == "803") {
            // $cond = "AND e.user_id IN ('786','1434','2','1449','2964','77','331','2397','323','1186','90','355','68','76')";
            $cond = "AND e.user_id NOT IN ('1')";
        }
        return  $this->db->query("SELECT e.user_id AS id_pic, CONCAT(e.first_name, ' ',e.last_name) AS pic FROM xin_employees e
        LEFT JOIN xin_user_roles ur ON ur.role_id = e.user_role_id WHERE e.is_active = 1 $cond")->result();
    }
    public function get_priority()
    {
        return  $this->db->query("SELECT id AS id_priority, `priority`, `color` FROM td_priority")->result();
    }
    public function get_type_active($id_type)
    {
        return  $this->db->query("SELECT id AS id_type, `type` FROM td_type WHERE `id` = '$id_type'")->row();
    }

    function generate_id_task()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( td_task.id_task, 3 ) ) AS kd_max 
        FROM
        td_task 
        WHERE
        SUBSTR( td_task.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'T' . date('ymd') . $kd;
    }

    function generate_id_sub_task()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( td_sub_task.id_sub_task, 3 ) ) AS kd_max 
        FROM
        td_sub_task 
        WHERE
        SUBSTR( td_sub_task.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'ST' . date('ymd') . $kd;
    }

    public function dt_task($start, $end)
    {
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        $hrbp = ['70', '321', '5530', '5529', '5534'];
        $buspro_analis = ['5530'];
        if (($user_role_id == 1 && $user_id != 323 && $user_id == 3651 && $user_id == 2903)) {
            $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else if ($user_id == "979") {
            $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end')";
        } else if ($user_id == "329") {
            $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND cmp.company_id IN ('1','2') AND em.username != 'anggi399') OR (em.username != 'anggi399' AND substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND ((FIND_IN_SET('$user_id',t.pic) OR t.created_by = '$user_id')) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else if ($user_id == "329" || in_array($user_id, $hrbp) == 1) {
            $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND cmp.company_id = '2') OR (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND ((FIND_IN_SET('$user_id',t.pic) OR t.created_by = '$user_id')) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else if ($user_id == "4138") { // farhan2434 pengganti Siti Cahyati
            $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND d.department_id = '106') OR ((FIND_IN_SET('$user_id',t.pic) OR ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND t.created_by = '$user_id'))) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else if (in_array($user_id, ["5197", "4954", "5078", "5529"])) { // Hience Thionie haya3467 all divisi marketing
            $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND d.department_id IN (120,137,154,155)) OR ((FIND_IN_SET('$user_id',t.pic) OR ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND t.created_by = '$user_id'))) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else if ($user_id == "4770") { // dewi2853 4770 Dewi Anggraeni Divisi Finance
            $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND d.department_id IN (27,33,47,89,90,99,116,168)) OR ((FIND_IN_SET('$user_id',t.pic) OR ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND t.created_by = '$user_id'))) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
            // } else if (in_array($user_id, $buspro_analis) == 1) {
            //     $cond = "WHERE ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND d.department_id IN (25,136)) OR ((FIND_IN_SET('$user_id',t.pic) OR ((substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND t.created_by = '$user_id')))";
        } else if ($user_id == 803) {
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
            // $cond = "WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' AND 
            //     (
            //         FIND_IN_SET('$user_id',t.pic) 
            //         OR FIND_IN_SET('786',t.pic)
            //         OR FIND_IN_SET('1434',t.pic)
            //         OR FIND_IN_SET('2',t.pic)
            //         OR FIND_IN_SET('1449',t.pic)
            //         OR FIND_IN_SET('2964',t.pic)
            //         OR FIND_IN_SET('77',t.pic)
            //         OR FIND_IN_SET('331',t.pic)
            //         OR FIND_IN_SET('2397',t.pic)
            //         OR FIND_IN_SET('323',t.pic)
            //         OR FIND_IN_SET('1186',t.pic)
            //         OR FIND_IN_SET('90',t.pic)
            //         OR FIND_IN_SET('355',t.pic)
            //         OR FIND_IN_SET('68',t.pic)
            //         OR FIND_IN_SET('76',t.pic)
            //         OR t.created_by 
            //             IN (
            //                 '$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76'
            //             )
            //     )";
            $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND ((FIND_IN_SET('$user_id',t.pic) OR t.created_by = '$user_id')) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        } else {
            $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' OR t.due_date BETWEEN '$start' AND '$end') AND ((FIND_IN_SET('$user_id',t.pic) OR t.created_by = '$user_id')) OR (substr( t.created_at, 1, 10 ) < '$start' AND t.`status` IN (1,2) AND (( FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' )))";
        }
        $query = "SELECT
                    t.created_by,
                    COALESCE(item.id_mom,'IBR Pro') AS id_mom,
                    md5(item.id_mom) AS enc_mom,
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
                    t.pic AS id_pic,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-danger' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-warning' 
                    ELSE 'bg-primary' END AS due_date_style,
                    issue.verified_status,
                    GROUP_CONCAT(
                        DISTINCT CASE
                            WHEN t.status = 2 AND issue.verified_status = 2 OR issue.owner_verified_status = 2 THEN st.id_sub_task
                        END
                    ) AS unverified_sub_tasks
                FROM
                    `td_task` t
                    LEFT JOIN td_sub_task st ON st.id_task = t.id_task
                    LEFT JOIN mom_issue_item item ON item.id_sub_task = st.id_sub_task
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN td_type ty ON ty.id = t.type
                    LEFT JOIN td_category c ON c.id = t.category
                    LEFT JOIN td_object o ON o.id = t.object
                    LEFT JOIN td_status s ON s.id = t.`status`
                    LEFT JOIN td_priority p ON p.id = t.priority
                    LEFT JOIN mom_issue_item issue ON issue.id_sub_task = st.id_sub_task 
                    $cond
                    GROUP BY t.id_task ORDER BY t.created_at DESC";
        return $this->db->query($query)->result();
    }

    public function dt_sub_task($id_task)
    {
        $query = "SELECT
                    t.`created_by` AS created_by,
                    COALESCE(item.id_mom,'IBR Pro') AS id_mom,
                    t.`status` AS id_status,
                    s.`status` AS `status`,
                    st.id_sub_task,
                    st.id_task,
                    st.indicator,
                    IF(sth_now.id_sub_task IS NOT NULL,1,0) sudah_update,
                    COALESCE(x.max_date,'') AS max_date,
                    COALESCE(x.jml_input,0) AS jml_input,
                    COALESCE(st.target,0) AS targetx,
                    COALESCE(st.note,'') AS note,
                    st.sub_task,
                    COALESCE(st.type,'') AS id_type,
                    COALESCE(st.file, '') AS `file`,
                    COALESCE(stt.sub_type,'') AS sub_type,
                    IF(COALESCE(st.`start`,CURRENT_DATE) = '0000-00-00',CURRENT_DATE, COALESCE(st.`start`,CURRENT_DATE)) AS `start`,
                    IF(COALESCE(st.`end`,CURRENT_DATE) = '0000-00-00',CURRENT_DATE, COALESCE(st.`end`,CURRENT_DATE)) AS `end`,
                    COALESCE(st.`jam_notif`,'07:00') AS jam_notif,
                    st.day_per_week,
                    COALESCE (
                    CASE

                    WHEN DATE_FORMAT( st.`start`, '%b %y' ) = DATE_FORMAT( st.`end`, '%b %y' ) THEN
                    CONCAT(
                    DATE_FORMAT( st.`start`, '%d' ),
                    '-',
                    DATE_FORMAT( st.`end`, '%d %b %y' )) 
                    WHEN DATE_FORMAT( st.`start`, '%y' ) = DATE_FORMAT( st.`end`, '%y' ) 
                    AND DATE_FORMAT( st.`start`, '%b' ) != DATE_FORMAT( st.`end`, '%b' ) THEN
                    CONCAT(
                        DATE_FORMAT( st.`start`, '%d %b' ),
                        ' - ',
                        DATE_FORMAT( st.`end`, '%d %b %y' )) ELSE CONCAT(
                        DATE_FORMAT( st.`start`, '%d %b %y' ),
                        ' - ',
                    DATE_FORMAT( st.`end`, '%d %b %y' )) 
                    END,
                    '' 
                    ) AS periode,
                    IF(COALESCE(x.jml_progress,0)>=100,100,COALESCE(x.jml_progress,0)) AS jml_progress,
                    COALESCE(x.consistency,0) AS consistency,
                    COALESCE(ss.id,'') AS id_status_strategy,
                    COALESCE(ss.status,'-') AS status_strategy,
                    st.verified_status,
                    stv.verified,
                    st.verified_note,
                    st.verified_by,
                    st.verified_at,
                    sub_item.verified_status AS verified_pdca,
                    sub_item.owner_verified_status AS verified_owner
                    

                    FROM
                    td_sub_task st
                    LEFT JOIN td_sub_type stt ON st.type = stt.id
                    LEFT JOIN td_status stv ON stv.id = st.verified_status
                    LEFT JOIN (
                            SELECT
                            his.id_sub_task,
                            his.id_task,
                            st.type,
                            CASE WHEN st.type = 3 THEN 
                            ROUND(COUNT(DISTINCT SUBSTR(his.created_at,1,7)) / st.target * 100) 
                            ELSE
                            ROUND(COUNT(DISTINCT SUBSTR(his.created_at,1,10)) / st.target * 100) END AS jml_progress,
                            -- IF(ROUND(SUM( his.progress ))>=100,100,ROUND(SUM( his.progress ))) AS jml_progress,
                            -- CASE WHEN st.type = 1 THEN
                            --     ROUND(SUM( his.progress ))
                            --     WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' THEN
                            --     ROUND(his.progress * COUNT( DISTINCT his.week_number )) 
                            --     WHEN st.type = 3 THEN
                            --     ROUND(his.progress * COUNT( DISTINCT SUBSTR(his.created_at,1,7) ))
                            --     WHEN st.type = 4 THEN
                            --     IF(ROUND(SUM( his.progress ))>=100,100,ROUND(SUM( his.progress ))) ELSE 0 
                            -- END AS jml_progress,
                            COUNT(his.created_at) AS jml_input,
                            MAX(his.created_at) AS max_date,

                            CASE WHEN st.type = 1 THEN
                            DATEDIFF(IF(CURRENT_DATE < st.`end`,CURRENT_DATE, st.`end`) ,st.`start`) + 1 
                            WHEN st.type = 2  AND his.week_number IS NOT NULL AND his.week_number != '' THEN
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
                                        CASE WHEN st.type = 1 AND (his.created_at >= st.start AND his.created_at <= st.end) THEN
                                            COUNT(his.created_at)
                                        WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' THEN 
                                            cons_week.consistency
                                        WHEN st.type = 3 THEN 
                                            COUNT(DISTINCT SUBSTR(his.created_at,1,7))
                                        WHEN st.type = 4 THEN
                                            2
                                        ELSE
                                            0
                                        END 
                                        / 
                                        CASE WHEN st.type = 1 AND (his.created_at >= st.start AND his.created_at <= st.end) THEN
                                            DATEDIFF(CURRENT_DATE, st.start)+1
                                        WHEN st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '' THEN 
                                            cons_week.target_consistency
                                        WHEN st.type = 3 THEN 
                                            TIMESTAMPDIFF(MONTH, CURRENT_DATE, st.start)+1
                                        WHEN st.type = 4 THEN
                                            2
                                        ELSE
                                            0
                                        END 
                                        -- IF(st.type = 2 AND his.week_number IS NOT NULL AND his.week_number != '',cons_week.target_consistency ,st.target)
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
                                WHERE sth.id_task = '$id_task'
                                AND SUBSTR( sth.created_at, 1, 10 ) >= st.start
                                GROUP BY
                                SUBSTR( sth.created_at, 1, 10 ),
                                sth.id_sub_task
                            ) AS his
                    LEFT JOIN 
                    (
                        SELECT
                            st.id_sub_task,
                            SUM(
                            IF
                            ( FIND_IN_SET( WEEKDAY( start_date ), st.day_per_week ), 1, 0 )) AS target_consistency,
                            COALESCE ( act_cons.consistency, 0 ) AS consistency,
                        CASE WHEN SUM(
                                IF
                                ( FIND_IN_SET( WEEKDAY( start_date ), st.day_per_week ), 1, 0 )) = 0 
                                AND COALESCE ( act_cons.consistency, 0 ) = 0 THEN
                                    0 ELSE ROUND(
                                        COALESCE ( act_cons.consistency, 0 ) / SUM(
                                        IF
                                        ( FIND_IN_SET( WEEKDAY( start_date ), st.day_per_week ), 1, 0 ))* 100 
                                    ) 
                                END AS percen_cons 
                        FROM
                        (
                            SELECT
                                ADDDATE( '1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0 ) AS start_date 
                            FROM
                                ( SELECT 0 t0 UNION  SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 ) t0,
                                ( SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9  ) t1,
                                ( SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9  ) t2,
                                ( SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9  ) t3,
                                (  SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 ) t4 
                            ) v
                            LEFT JOIN 
                            (
                                SELECT
                                    id_sub_task,
                                    id_task,
                                    type,
                                    `start`,
                                    `end`,
                                    COALESCE ( day_per_week, 1 ) AS day_per_week,
                                    `status`
                                FROM
                                    td_sub_task st 
                                WHERE
                                    st.type = 2 
                            ) st ON st.id_task = '$id_task'
                            LEFT JOIN (
                                SELECT 
                                    x.id_sub_task,
                                    x.id_task,
                                    x.created_at AS created_at,
                                    COUNT( x.consistency ) AS consistency 
                                FROM
                                (
                                    SELECT
                                        sth.id_sub_task,
                                        sth.id_task,
                                        sth.week_day,
                                        st.day_per_week,
                                        SUBSTR( sth.created_at, 1, 10 ) AS created_at,
                                        1 AS consistency
                                    FROM
                                        td_sub_task_history sth
                                        LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task 
                                    WHERE
                                        sth.id_task = '$id_task' 
                                        AND st.type = 2 
                                        AND FIND_IN_SET( sth.week_day, st.day_per_week ) 
                                        AND SUBSTR( sth.created_at, 1, 10 ) >= st.`start` AND  SUBSTR( sth.created_at, 1, 10 ) <= st.`end`
                                    GROUP BY
                                        SUBSTR( sth.created_at, 1, 10 ),
                                        sth.id_sub_task
                                ) AS x GROUP BY x.id_sub_task
                            ) AS act_cons ON act_cons.id_sub_task = st.id_sub_task 
                            WHERE
                                start_date BETWEEN st.`start` 
                            AND IF(CURRENT_DATE < st.`end`, CURRENT_DATE, st.`end`)  
                            GROUP BY
                                st.id_sub_task
                        ) AS cons_week ON cons_week.id_sub_task = his.id_sub_task
                        LEFT JOIN td_sub_task st ON st.id_sub_task = his.id_sub_task
                        GROUP BY his.id_sub_task
                    ) AS x ON x.id_sub_task = st.id_sub_task
                    LEFT JOIN td_task t ON t.id_task = st.id_task
                    LEFT JOIN mom_issue_item item ON item.id_task = t.id_task
                    LEFT JOIN mom_issue_item sub_item ON sub_item.id_sub_task = st.id_sub_task
                    LEFT JOIN (SELECT id_sub_task FROM td_sub_task_history WHERE SUBSTR(td_sub_task_history.created_at,1,10) = CURRENT_DATE GROUP BY id_sub_task) AS sth_now ON sth_now.id_sub_task = x.id_sub_task
                    LEFT JOIN td_status s ON s.id = t.`status`
                    LEFT JOIN td_status_strategy ss ON ss.id = st.status
                    WHERE
                    st.id_task = '$id_task'
                    GROUP BY st.id_sub_task
                    ";
        return $this->db->query($query)->result();
    }


    public function get_detail_task($id_task)
    {
        $query = "SELECT
                    t.created_by,
                    COALESCE(item.id_mom,'IBR Pro') AS id_mom,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    CONCAT(em.first_name, ' ', em.last_name) AS owner_name,
                    em.profile_picture AS owner_photo,
                    d.department_name AS owner_department,
                    cmp.name AS owner_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name)) AS team_name,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    t.task,
                    t.description,
                    t.indicator,
                    t.note,
                    t.progress,
                    COALESCE(t.strategy,'') AS strategy,
                    COALESCE(t.jenis_strategy,'') AS jenis_strategy,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS `start_2`,
                    COALESCE(DATE_FORMAT(t.end, '%d %b %y'),'') AS `end_2`,
                    t.type AS id_type,
                    ty.type,
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
                    t.pic AS id_pic,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-light-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-light-yellow' 
                    ELSE 'bg-light-blue' END AS due_date_style,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'text-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'text-yellow' 
                    ELSE 'text-blue' END AS due_date_style_text
                FROM
                    `td_task` t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN td_type ty ON ty.id = t.type
                    LEFT JOIN td_category c ON c.id = t.category
                    LEFT JOIN td_object o ON o.id = t.object
                    LEFT JOIN td_status s ON s.id = t.`status`
                    LEFT JOIN td_priority p ON p.id = t.priority
                    LEFT JOIN mom_issue_item item ON item.id_task = t.id_task
                    WHERE t.id_task = '$id_task'
                    GROUP BY t.id_task";
        return $this->db->query($query)->row();
    }

    public function get_detail_sub_task($id_sub_task)
    {
        $query = "SELECT
                        st.id_sub_task,
                        st.id_task,
                        st.sub_task,
						t.type AS id_type_goals,
                        st.type AS id_type,
                        COALESCE ( st.file, '' ) AS `file`,
                        stt.sub_type,
                        st.`start`,
                        st.`end`,
                        COALESCE(st.jam_notif,'07:00') AS jam_notif,
                        COALESCE (
                        CASE WHEN DATE_FORMAT( st.`start`, '%b %y' ) = DATE_FORMAT( st.`end`, '%b %y' ) THEN
                                CONCAT(
                                    DATE_FORMAT( st.`start`, '%d' ),
                                    '-',
                                DATE_FORMAT( st.`end`, '%d %b %y' )) 
                                WHEN DATE_FORMAT( st.`start`, '%y' ) = DATE_FORMAT( st.`end`, '%y' ) 
                                AND DATE_FORMAT( st.`start`, '%b' ) != DATE_FORMAT( st.`end`, '%b' ) THEN
                                    CONCAT(
                                        DATE_FORMAT( st.`start`, '%d %b' ),
                                        ' - ',
                                        DATE_FORMAT( st.`end`, '%d %b %y' )) ELSE CONCAT(
                                        DATE_FORMAT( st.`start`, '%d %b %y' ),
                                        ' - ',
                                    DATE_FORMAT( st.`end`, '%d %b %y' )) 
                                END,
                                '' 
                            ) AS periode,
                            v.today,
                                                        CASE WHEN st.type = 1 THEN
                                                                ROUND(((1/(DATEDIFF(st.`end`,st.`start`)+1))*100),2)
                                                        WHEN st.type = 2 THEN
                                                                ROUND(((1/st.target)*100),2)
                                                        WHEN st.type = 3 THEN
                                                            ROUND(((1/(TIMESTAMPDIFF(MONTH,st.`start`,st.`end`)+1))*100),2)
                                                        WHEN st.type = 4 THEN
                                                                50
                                                            ELSE
                                                                0
                                                        END `progress`,
                                                        DATEDIFF(st.`end`,st.`start`)+1 AS jml_hari,
                                                        TIMESTAMPDIFF(MONTH,st.`start`,st.`end`)+1 AS date_month,
                                                        vx.jml_week,
                            v.week_number,
                            v.`week_start_date`,
                            v.`week_end_date`,
                            COALESCE(ii.ekspektasi, '-') AS ekspektasi
                        FROM
                            td_sub_task st
                            LEFT JOIN td_sub_type stt ON st.type = stt.id
                            LEFT JOIN td_task t ON t.id_task = st.id_task
                            LEFT JOIN mom_issue_item AS ii ON ii.id_sub_task = st.id_sub_task
                            LEFT JOIN (
                                    SELECT
                        CURRENT_DATE AS today,
                        v.week_number,
                        v.week_start_date,
                        v.week_end_date
                    FROM (
                        SELECT CONCAT('W', ROW_NUMBER() OVER (ORDER BY MIN(DATE(start_date)))) AS `week_number`, 
                        MIN(DATE(start_date)) AS `week_start_date`, MAX(DATE(start_date)) AS `week_end_date`
                        FROM (
                            SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                            ) v
                            LEFT JOIN td_sub_task st ON v.start_date BETWEEN st.`start` AND st.`end`
                            WHERE st.id_sub_task = '$id_sub_task'
                            GROUP BY WEEK(start_date)
                            ORDER BY WEEK(start_date)
                        ) AS v WHERE CURRENT_DATE BETWEEN v.week_start_date AND v.week_end_date
                    ) v ON v.today = CURRENT_DATE
                                                        
                                        LEFT JOIN (
                                            SELECT
                                                v.id_sub_task,
                                                COUNT(v.week_number) AS jml_week,
                                                MIN(v.week_start_date) AS week_start,
                                                MAX(v.week_end_date) AS week_end
                                                FROM (
                                                SELECT 
                                                st.id_sub_task,
                                                CONCAT('W', ROW_NUMBER() OVER (ORDER BY WEEK(start_date))) AS `week_number`, 
                                                MIN(start_date) AS `week_start_date`, MAX(start_date) AS `week_end_date`
                                                FROM (
                                                SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                FROM
                                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                                ) v
                                                LEFT JOIN td_sub_task st ON v.start_date BETWEEN st.`start` AND st.`end`
                                                WHERE st.id_sub_task = '$id_sub_task'
                                                GROUP BY WEEK(start_date)
                                                ORDER BY WEEK(start_date)
                                            ) AS v
                                        ) AS vx ON vx.id_sub_task = st.id_sub_task
                    WHERE
                        st.id_sub_task = '$id_sub_task'";
        return $this->db->query($query)->row();
    }

    public function get_target_week($start_date, $end_date, $sub_day)
    {
        $query = "SELECT 
                    start_date,
                    WEEKDAY(start_date) AS week_day,
                    SUM(IF(FIND_IN_SET(WEEKDAY(start_date),'$sub_day'),1,0)) AS jml_week
                    FROM (
                    SELECT ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                    FROM
                        (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                        (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                        (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                        (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                        (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                    ) v
                    WHERE start_date BETWEEN '$start_date' AND '$end_date'";
        return $this->db->query($query)->row();
    }



    function log_history_sub_task($id_sub_task)
    {

        $query = "SELECT
                        x.* 
                    FROM
                        (
                        SELECT
                            sth.id,
                            sth.created_at,
                            'note' AS type_history,
                            sth.note AS keterangan,
                            sth.created_by,
                            CONCAT( e.first_name, ' ', e.last_name ) AS pic,
                            CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END AS photo 
                        FROM
                            td_sub_task_history sth
                            LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                            LEFT JOIN td_sub_type tst ON tst.id = st.type
                            LEFT JOIN xin_employees e ON e.user_id = sth.created_by 
                        WHERE
                            sth.id_sub_task = '$id_sub_task' AND sth.note IS NOT NULL UNION
                        SELECT
                            sth.id,
                            sth.created_at,
                            'evaluasi' AS type_history,
                            sth.evaluasi AS keterangan,
                            sth.created_by,
                            CONCAT( e.first_name, ' ', e.last_name ) AS pic,
                            CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END AS photo 
                        FROM
                            td_sub_task_history sth
                            LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                            LEFT JOIN td_sub_type tst ON tst.id = st.type
                            LEFT JOIN xin_employees e ON e.user_id = sth.created_by 
                        WHERE
                            sth.id_sub_task = '$id_sub_task' AND sth.evaluasi IS NOT NULL AND sth.evaluasi != '' UNION
                        SELECT
                            sth.id,
                            sth.created_at,
                            'file' AS type_history,
                            sth.file AS keterangan,
                            sth.created_by,
                            CONCAT( e.first_name, ' ', e.last_name ) AS pic,
                            CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END AS photo 
                        FROM
                            td_sub_task_history sth
                            LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                            LEFT JOIN td_sub_type tst ON tst.id = st.type
                            LEFT JOIN xin_employees e ON e.user_id = sth.created_by 
                        WHERE
                            sth.id_sub_task = '$id_sub_task' AND sth.file IS NOT NULL AND sth.file != '' UNION
                        SELECT
                            sth.id,
                            sth.created_at,
                            'link' AS type_history,
                            sth.link AS keterangan,
                            sth.created_by,
                            CONCAT( e.first_name, ' ', e.last_name ) AS pic,
                            CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END AS photo 
                        FROM
                            td_sub_task_history sth
                            LEFT JOIN td_sub_task st ON st.id_sub_task = sth.id_sub_task
                            LEFT JOIN td_sub_type tst ON tst.id = st.type
                            LEFT JOIN xin_employees e ON e.user_id = sth.created_by 
                        WHERE
                            sth.id_sub_task = '$id_sub_task' AND sth.link IS NOT NULL AND sth.link != ''
                        ) AS x 
                    ORDER BY
                        x.id DESC";
        return $this->db->query($query)->result();
    }

    function get_solver_ibr($id_sub_task)
    {
        $query = "SELECT 
            YEAR(mom_header.created_at) AS tahun,
            sub_task.id_sub_task,
            sub_task.id_task,
            mom_header.id_mom,
            MD5(mom_header.id_mom) AS mom,
            mom_header.meeting,
            CASE 
                WHEN mom_header.meeting = 'Internal GM' THEN 
                    COALESCE(
                        CASE 
                            WHEN pdca.contact_no LIKE '0%' THEN 
                                CONCAT('62', SUBSTRING(pdca.contact_no, 2)) 
                            ELSE 
                                pdca.contact_no 
                        END,
                        CASE 
                            WHEN emp.contact_no LIKE '0%' THEN 
                                CONCAT('62', SUBSTRING(emp.contact_no, 2)) 
                            ELSE 
                                emp.contact_no 
                        END
                    )
                ELSE 
                    CASE 
                        WHEN emp.contact_no LIKE '0%' THEN 
                            CONCAT('62', SUBSTRING(emp.contact_no, 2)) 
                        ELSE 
                            emp.contact_no 
                    END
            END AS contact,
            mom_m_verify.pic,
            CASE 
                WHEN pdca.contact_no LIKE '0%' THEN 
                    CONCAT('62', SUBSTRING(pdca.contact_no, 2)) 
                ELSE 
                    pdca.contact_no 
            END AS contact_no_pdca,
            CASE 
                WHEN emp.contact_no LIKE '0%' THEN 
                    CONCAT('62', SUBSTRING(emp.contact_no, 2)) 
                ELSE 
                    emp.contact_no 
            END AS contact_no,
            task.task,
            sub_task.sub_task,
            sub_task.evaluasi,
            TRIM(CONCAT(solver.first_name, ' ', solver.last_name)) AS pic,
            CASE 
                WHEN sub_task.status = 1 THEN 'Jalan Berhasil'
                WHEN sub_task.status = 2 THEN 'Jalan Tidak Berhasil'
                WHEN sub_task.status = 3 THEN 'Tidak Berjalan'
                WHEN sub_task.status = 4 THEN 'Progress'
                ELSE ''
            END AS status,
            his.file,
            his.link
        FROM td_sub_task AS sub_task
        LEFT JOIN td_task AS task 
            ON task.id_task = sub_task.id_task
        LEFT JOIN mom_issue_item AS issue_item 
            ON issue_item.id_sub_task = sub_task.id_sub_task
        LEFT JOIN mom_header 
            ON mom_header.id_mom = issue_item.id_mom
        LEFT JOIN xin_employees AS emp 
            ON emp.user_id = mom_header.created_by
        LEFT JOIN (
            SELECT 
                td_sub_task_history.id_sub_task,
                IF(
                    td_sub_task_history.file = '', 
                    NULL, 
                    CONCAT('https://trusmiverse.com/apps/uploads/monday/history_sub_task/', td_sub_task_history.file)
                ) AS file,
                td_sub_task_history.link,
                td_sub_task_history.created_by
            FROM td_sub_task_history
            WHERE id_sub_task = '$id_sub_task'
            ORDER BY id DESC 
            LIMIT 1
        ) AS his 
            ON his.id_sub_task = sub_task.id_sub_task
        LEFT JOIN xin_employees AS solver 
            ON solver.user_id = his.created_by
        LEFT JOIN mom_m_verify 
            ON FIND_IN_SET(mom_header.department, mom_m_verify.department_id)
        LEFT JOIN xin_employees AS pdca 
            ON pdca.user_id = mom_m_verify.pic
        WHERE sub_task.id_sub_task = '$id_sub_task'";

        return $this->db->query($query)->row_array();
    }
    public function get_mom_issue_item($id_mom, $id_task)
    {
        $query = "SELECT * FROM `mom_issue_item` item WHERE item.id_mom = '$id_mom' AND item.id_task = '$id_task' ORDER BY item.id_issue_item DESC LIMIT 1";
        return $this->db->query($query)->row_object();
    }
    public function detail_tasklist($id)
    {
        $query = "SELECT
	task.id_task,
	sub.id_sub_task,
	task.task,
	task.description,
	task.jenis_strategy,
	st.`status`,
	task.progress,
	task.due_date,
	task.done_date,
	TRIM(CONCAT(crt.first_name,' ',crt.last_name)) AS created,
	task.created_at,
	crt.contact_no AS contact_created,
    epic.user_id AS id_pic,
	TRIM(CONCAT(epic.first_name,' ',epic.last_name)) AS pic,
	epic.contact_no AS contact_pic
FROM
	td_task task
    LEFT JOIN td_sub_task sub ON sub.id_task = task.id_task
	LEFT JOIN xin_employees epic ON FIND_IN_SET(epic.user_id,task.pic)
	LEFT JOIN xin_employees crt ON crt.user_id = task.created_by
	LEFT JOIN td_status st ON st.id = task.status
WHERE task.id_task = '$id'
GROUP BY epic.user_id
";
        return $this->db->query($query)->result();
    }
    public function list_verif()
    {
        $user = $this->session->userdata('user_id');
        $super = [1];
        $kondisi = "";
        if (in_array($user, $super)) {
            $kondisi = "";
        } else {
            $kondisi = "AND (task.pic = '$user' OR task.created_by = '$user')";
        }
        $query = "SELECT
                    sub.id_task,
                    sub.id_sub_task,
                    task.task,
                    sub.sub_task,
                    task.strategy,
                    task.description,
                    task.due_date,
                    sub.type AS id_type,
                    ty.type,
                    task.jenis_strategy,
                    sub.created_by,
                    sub.progress,
                    sub.note,
                    st.`status`,
                    st.`color` AS status_color,
                    c.category,
                    sub.verified_status,
                    CONCAT(epic.first_name,' ',epic.last_name) AS pic,
                    CONCAT(crt.first_name,' ',crt.last_name) AS created,
                    vr.verified,
                    vr.verified_color,
                    COALESCE(SUBSTR(task.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(task.end,1,10),'') AS `end`,
                    mtask.evaluasi,
                    mtask.file,
                    mtask.link
                    
                FROM
                    `td_sub_task` sub
                    LEFT JOIN td_task task ON task.id_task = sub.id_task
                    LEFT JOIN mom_issue_item item ON item.id_sub_task = sub.id_sub_task
                    LEFT JOIN td_status st ON st.id = task.`status`
                LEFT JOIN td_type ty ON ty.id = task.type
                LEFT JOIN td_category c ON c.id = task.category
                    LEFT JOIN td_status vr ON vr.id = sub.verified_status
                    LEFT JOIN xin_employees epic ON FIND_IN_SET(epic.user_id,task.pic)
                    LEFT JOIN xin_employees crt ON crt.user_id = task.created_by
                    LEFT JOIN (SELECT
                    max_task.id,
                    max_task.id_sub_task AS idx,
                    max_task.evaluasi,
                    max_task.file,
                    max_task.link 
                FROM
                    td_sub_task_history AS max_task
                    JOIN ( SELECT id_sub_task, MAX( id ) AS max_id FROM td_sub_task_history GROUP BY id_sub_task ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task 
                    AND max_task.id = subquery_max.max_id) AS mtask ON mtask.idx = sub.id_sub_task
                WHERE item.id_mom IS NULL AND sub.note <> 'Created from MOM' AND sub.verified_status IS NULL $kondisi AND task.created_at > '2025-03-25'
                GROUP BY epic.user_id, sub.id_sub_task
                ";
        return $this->db->query($query)->result();
    }

    function get_detail_ibr_for_notif($id_sub_task)
    {
        $query = "SELECT
            YEAR(task.created_at) AS tahun,
            sub_task.id_sub_task,
            sub_task.id_task,
            CASE    
                WHEN solver.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( solver.contact_no, 2 )) ELSE solver.contact_no 
            END AS contact_no,
												CASE    
                WHEN pic_mom.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( pic_mom.contact_no, 2 )) ELSE pic_mom.contact_no 
            END AS contact_no_pic,
            task.task,
            sub_task.sub_task,
            sub_task.evaluasi,
            TRIM(CONCAT(solver.first_name, ' ', solver.last_name)) AS pic,
            TRIM(CONCAT(pic_mom.first_name, ' ', pic_mom.last_name)) AS pic_mom,
            CASE    
                WHEN sub_task.status = 1 THEN
                'Jalan Berhasil' 
                WHEN sub_task.status = 2 THEN
                'Jalan Tidak Berhasil' 
                WHEN sub_task.status = 3 THEN
                'Tidak Berjalan' 
                WHEN sub_task.status = 4 THEN
                'Progress' ELSE '' 
            END AS status,
            his.file,
            his.link,
            TRIM(CONCAT(crt.first_name, ' ', crt.last_name)) AS pdca,
            sub_task.verified_note
        FROM
            td_sub_task AS sub_task
            JOIN td_task AS task ON task.id_task = sub_task.id_task
            LEFT JOIN xin_employees pic_mom ON FIND_IN_SET(pic_mom.user_id,task.pic) 
            LEFT JOIN xin_employees AS crt ON crt.user_id = task.created_by
            JOIN (
            SELECT
                td_sub_task_history.id_sub_task,
                IF ( td_sub_task_history.file = '', NULL, CONCAT( 'https://trusmiverse.com/apps/uploads/monday/history_sub_task/', td_sub_task_history.file )) AS file,
                td_sub_task_history.link,
                td_sub_task_history.created_by
            FROM
                td_sub_task_history 
            WHERE
                id_sub_task = '$id_sub_task' 
            ORDER BY
                id DESC 
            LIMIT 1
            ) AS his ON his.id_sub_task = sub_task.id_sub_task 
            JOIN xin_employees AS solver ON solver.user_id = his.created_by
        WHERE
            sub_task.id_sub_task = '$id_sub_task'
												GROUP BY pic_mom.user_id";

        return $this->db->query($query)->result();
    }

    public function update_status_done($id_task){
        $query = "UPDATE td_task
                    SET status = 3,
                        progress = 100,
                        done_date = NOW()
                    WHERE id_task = '$id_task'
                    AND NOT EXISTS (
                        SELECT 1
                        FROM td_sub_task
                        WHERE id_task = '$id_task'
                        AND status IS NULL
                    )
                    AND NOT EXISTS (
                        SELECT 1
                        FROM td_sub_task
                        WHERE id_task = '$id_task'
                        AND type IN (1, 2)
                    )
                    AND NOT EXISTS (
                        SELECT 1
                        FROM mom_issue_item
                        WHERE id_task = '$id_task'
                        AND (verified_status = 2 OR owner_verified_status = 2) 
                    )
            ";
    
        $this->db->query($query);
        return $this->db->affected_rows(); // return jumlah baris yang berubah
    }

    public function check_revisi($id_task){
        $query = "SELECT
                task.id_task,
                item.verified_status,
                item.owner_verified_status
            FROM
                td_task task
                LEFT JOIN mom_issue_item item ON task.id_task = item.id_task
                WHERE (verified_status = 2 OR owner_verified_status = 2)
                AND task.id_task = '$id_task'
                GROUP BY item.id
                ";
        return $this->db->query($query)->num_rows();
    }
    public function check_consistency($id_task){
        $query = "SELECT
                    * 
                FROM
                    td_sub_task sub 
                WHERE
                    sub.type IN ( 1, 2 ) 
                    AND sub.end > CURDATE()
                    AND sub.id_task = '$id_task'";
        return $this->db->query($query)->num_rows();
    }
    
}
