<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_table extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function dt_tickets($start, $end, $filter_type, $filter_pic, $filter_status)
    {
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        $department_id = $this->session->userdata("department_id");

        if ($filter_type == "all") {
            $cond_type = "";
        } else {
            $cond_type = "AND t.type = '$filter_type'";
        }

        if ($filter_pic == "all") {
            $cond_pic = "";
        } else {
            $cond_pic = "AND (FIND_IN_SET( '$filter_pic', t.pic ) OR t.created_by = '$filter_pic')";
        }

        if ($filter_status == "all" || $filter_status == "") {
            $cond_status = "";
        } else {
            $cond_status = "AND t.status IN ($filter_status)";
        }
        // 2521 najmatul laela, 5648 haryadi3543, 2765 rizal aburakman
        if ($user_role_id == 1 || in_array($user_id, [1, 61, 62, 323, 979, 63, 64, 1161, 2041, 2063, 2969, 2070, 2903, 2521, 5648, 2765]) == 1 || in_array($department_id, [68, 83]) == 1) {
            $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_pic $cond_type $cond_status) OR (t.due_date BETWEEN '$start' AND '$end' AND t.type IN (1,2) $cond_pic $cond_type $cond_status)";
            if ($user_id == 2969) {
                $cond_status_qa = " AND t.status IN (11,14)";
                $cond = "WHERE (substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_type $cond_status) OR (t.due_date BETWEEN '$start' AND '$end' AND t.type IN (1,2) $cond_type $cond_status) OR (t.due_date BETWEEN '$start' AND '$end' AND t.type IN (1,2) $cond_type $cond_status_qa)";
            }
        } else {
            $cond = "WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' AND (FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id') $cond_status";
        }
        $query = "SELECT
                    t.created_by,
                    t.description,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS tgl_diproses,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    em.username AS owner_username,
                    CONCAT(em.first_name, ' ', em.last_name) AS owner_name,
                    CASE WHEN em.profile_picture IS NOT NULL AND em.profile_picture != '' AND em.profile_picture != 'no file' THEN em.profile_picture ELSE IF(em.gender='Male','default_male.jpg','default_female.jpg')  END AS owner_photo,
                    d.department_name AS owner_department,
                    cmp.name AS owner_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name)) AS team_name,
                    GROUP_CONCAT(DISTINCT CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' AND e.profile_picture != 'no file' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END) AS profile_picture_pic,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    t.task,
                    t.progress,
                    CASE WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > (60*24) THEN
                            CONCAT(TIMESTAMPDIFF( DAY, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' days')
                        WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 60 THEN
                            CONCAT(TIMESTAMPDIFF( HOUR, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' hour')
                        WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 0 THEN
                            CONCAT(TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' minutes')
                        ELSE
                            ''
                    END AS leadtime_process,
                    CASE WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > (60*24) THEN
                            CONCAT(TIMESTAMPDIFF( DAY, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' days')
                        WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 60 THEN
                            CONCAT(TIMESTAMPDIFF( HOUR, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' hour')
                        WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 0 THEN
                            CONCAT(TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' minutes')
                        ELSE
                            ''
                    END AS leadtime_progress,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(CASE WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.START, '%d' ), '-', DATE_FORMAT( t.END, '%d %b %y' ))
	WHEN  DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN CONCAT(DATE_FORMAT( t.START, '%d %b' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' ))
	ELSE CONCAT(DATE_FORMAT( t.START, '%d %b %y' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' )) END,'') AS timeline,
                    t.type AS id_type,
                    ty.type,
                    st.sub_type,
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
                    t.note,
                    COALESCE(DATE_FORMAT(t.due_date, '%d %b %y'),'') AS due_date,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-danger' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-warning' 
                    ELSE 'bg-primary' END AS due_date_style
                FROM
                    `ticket_task` t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_sub_type st ON st.id = c.sub_type
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_priority p ON p.id = t.priority
                    $cond
                    GROUP BY t.id_task ORDER BY t.created_at DESC";
        return $this->db->query($query)->result();
    }
}
