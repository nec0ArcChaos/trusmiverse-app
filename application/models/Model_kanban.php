<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_kanban extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function kanban_data($id_task = null, $user_id = null)
    {

        $user_role_id = $_SESSION['user_role_id'];
        if ($user_id == null) {
            $user_id = $this->session->userdata('user_id');
        }

        if ($id_task != null) {
            if ($user_role_id == "1" && $user_id != "323") {
                if ($user_id == null || $user_id == "") {
                    $kondisi = "WHERE td_task.id_task = '$id_task'";
                } else {
                    $kondisi = "WHERE td_task.id_task = '$id_task'
                        AND FIND_IN_SET($user_id, td_task.pic)";
                }
            } else {
                $kondisi = "WHERE td_task.id_task = '$id_task'
                        AND FIND_IN_SET($user_id, td_task.pic)";
            }
        } else {
            if ($user_role_id == "1" && $user_id != "323" && $user_id != 118) {
                $kondisi = "";
                if ($user_id == null || $user_id == "") {
                    $kondisi = "";
                } else {
                    // $kondisi = "WHERE FIND_IN_SET($user_id, td_task.pic)";
                    $kondisi = "";
                }
            } else {
                $kondisi = "WHERE FIND_IN_SET($user_id, td_task.pic)";
            }
        }

        $query = "SELECT 
                    td_task.id_task,
                    td_type.id AS id_type,
                    td_type.type,
                    td_category.id AS id_category,
                    td_category.category,
                    td_object.id AS id_object,
                    td_object.object,
                    td_task.task,
                    td_task.description,
                    td_task.pic AS id_pic,
                    GROUP_CONCAT(CONCAT(xin_employees.first_name, ' ', xin_employees.last_name)) AS pic,
                    GROUP_CONCAT(
                        CASE 
                            WHEN xin_employees.profile_picture IS NULL OR xin_employees.profile_picture='' OR xin_employees.profile_picture='no file' 
                                THEN 
                                    CASE 
                                        WHEN xin_employees.gender = 'Male' 
                                            THEN 'default_male.jpg'
                                        ELSE 'default_female.jpg'
                                    END
                            ELSE COALESCE(xin_employees.profile_picture,'')
                        END
                    ) AS profile_picture,
                    
                    td_status.id AS id_status,
                    td_status.status,
                    td_status.color AS status_color,
                    td_task.progress,
                    td_priority.id AS id_priority,
                    td_priority.priority,
                    COALESCE(td_task.start) AS start,
                    COALESCE(td_task.end) AS end,
                    td_task.due_date,
                    COALESCE(td_task.note,'') AS note,
                    td_task.created_at,
                    CONCAT(created_by.first_name, ' ', created_by.last_name) AS created_by,
                    COALESCE(td_task.indicator,'') AS indicator,
                    COALESCE(td_task.strategy,'') AS strategy,
                    COALESCE(td_task.jenis_strategy,'') AS jenis_strategy,
                    COALESCE(td_task.evaluation,'') AS evaluation,
                    COALESCE(td_task_attach.attachment,'') AS attachment
                    
                FROM td_task
                LEFT JOIN td_type ON td_type.id = td_task.type
                LEFT JOIN td_category ON td_category.id = td_task.category
                LEFT JOIN td_object ON td_object.id = td_task.object
                LEFT JOIN xin_employees ON FIND_IN_SET(xin_employees.user_id, td_task.pic)
                LEFT JOIN td_status ON td_status.id = td_task.status
                LEFT JOIN td_priority ON td_priority.id = td_task.priority
                LEFT JOIN xin_employees created_by ON created_by.user_id = td_task.created_by
                LEFT JOIN td_task_attach ON td_task_attach.id_task = td_task.id_task
                $kondisi
                AND td_status.id != 3
                GROUP BY td_task.id_task";
        return $this->db->query($query)->result();
    }


    function log_history($id_task)
    {

        $query = "SELECT * 
                FROM 
                (
                        
                    -- CREATED
                    SELECT 
                        'created' AS jenis,
                        task.task AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM td_task_history h
                    LEFT JOIN td_task task ON task.id_task = h.id_task
                    LEFT JOIN td_status s ON s.id = h.`status`
                    LEFT JOIN td_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NULL
                    AND h.status = 1
                    -- CREATED

                    UNION

                    -- STATUS
                    SELECT 
                        'status' AS jenis,
                        NULL AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM td_task_history h
                    LEFT JOIN td_task task ON task.id_task = h.id_task
                    LEFT JOIN td_status s ON s.id = h.`status`
                    LEFT JOIN td_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NOT NULL
                    AND h.status != h.status_before
                    -- STATUS
                                       

                    UNION 
                                        
                    -- NOTE
                    SELECT 
                        'note' AS jenis,
                        h.note AS history,
                        NULL AS status_before,
                        NULL AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM td_task_history h
                    LEFT JOIN td_task task ON task.id_task = h.id_task
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND (h.note IS NOT NULL AND h.note  != '')
                    -- NOTE
                    
                    UNION 
                    
                    -- PROGRESS

                    SELECT * FROM
                    (SELECT
                            'progress' AS jenis,
                            s.sub_task AS history,
                            h.id_sub_task AS status_before, -- id_sub_task
                            ty.sub_type AS status,
                            COALESCE(s.target,0) AS progress_before, -- target
                            CASE WHEN s.type = 3
                                THEN 																	
                                    CASE WHEN ROUND(((COALESCE(h_group_month.jml_input,0) / COALESCE(s.target,1) ) * 100) * (h.no_urut / COALESCE(h_group_month.jml_input,1))) > 100 THEN 100
                                    ELSE ROUND(((COALESCE(h_group_month.jml_input,0) / COALESCE(s.target,1) ) * 100) * (h.no_urut / COALESCE(h_group_month.jml_input,1))) END						
                                ELSE
                                    CASE WHEN ROUND(((COALESCE(h_group.jml_input,0) / COALESCE(s.target,1) ) * 100) * (h.no_urut / COALESCE(h_group.jml_input,1))) > 100 THEN 100
                                    ELSE ROUND(((COALESCE(h_group.jml_input,0) / COALESCE(s.target,1) ) * 100) * (h.no_urut / COALESCE(h_group.jml_input,1)))
                                END 
                            END AS progress,
                            CONCAT(e.first_name,' ', e.last_name) AS employee,
                            COALESCE(e.profile_picture,'') AS photo,
                            h.created_at AS datetime,
                            DATE(h.created_at) AS tanggal,
                            TIME(h.created_at) AS waktu,
                            COALESCE(h.note,'') AS note
                    FROM td_sub_task_history h
                    JOIN td_sub_task s ON s.id_sub_task = h.id_sub_task
                    JOIN td_sub_type ty ON ty.id = s.type
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    LEFT JOIN 
                    (	SELECT
                            h.id_sub_task,
                            COUNT(h.id) AS jml_input
                        FROM td_sub_task_history h
                        WHERE h.id_task = '$id_task'
                        GROUP BY h.id_sub_task
                    ) h_group ON h_group.id_sub_task = h.id_sub_task
                    LEFT JOIN
                    (	SELECT
                            h.id_sub_task,
                            COUNT(h.id) AS jml_input
                        FROM td_sub_task_history h
                        WHERE h.id_task = '$id_task'
                        GROUP BY SUBSTR(h.created_at,1,7), h.id_sub_task
                    ) h_group_month ON h_group_month.id_sub_task = h.id_sub_task
                    WHERE h.id_task = '$id_task'
                    AND DATE(h.created_at) >= s.`start`
                    ORDER BY h.created_at DESC, h.id_sub_task DESC
                    ) progress
                    -- PROGRESS
                    

                                
                ) history_log 
                ORDER BY datetime DESC";
        return $this->db->query($query)->result();
    }

    function get_sub_task($id_task)
    {
        $query = "SELECT 
                    t.sub_task, 
                    y.id AS id_type,
                    y.sub_type AS type,
                    t.start,
                    t.end,
                    DATEDIFF(CURRENT_DATE,t.end),
                    IF(DATEDIFF(CURRENT_DATE,t.end) < 0, DATEDIFF(CURRENT_DATE, t.start)+1, DATEDIFF(t.end, t.start)+1) AS count_day_berjalan,
                    DATEDIFF(t.end, t.start)+1 AS count_day,
                    IF(CEIL(DATEDIFF(t.end, t.start)+1 / 7)>4,4,CEIL(DATEDIFF(t.end, t.start)+1 / 7)) AS count_week,
                    2 AS count_twice,
                    1 AS count_month,
                    COALESCE(daily.jml,0) AS history_daily,
                    ROUND(COALESCE(daily.jml,0) / IF(DATEDIFF(CURRENT_DATE,t.end) < 0, DATEDIFF(CURRENT_DATE, t.start)+1, DATEDIFF(t.end, t.start)+1) * 100) AS p_daily 
                
                    
                    
                FROM td_sub_task t
                LEFT JOIN td_sub_type y ON y.id = t.type
                LEFT JOIN (
                    
                    SELECT
                        daily.id_sub_task,
                        COUNT(daily.id_sub_task) AS jml
                    FROM
                    (SELECT
                            h.id_sub_task,
                            s.start,
                            s.end,
                            DATEDIFF(CURRENT_DATE,s.end)
                    -- 		COUNT(h.id_sub_task) AS jml
                        FROM td_sub_task_history h
                        JOIN td_sub_task s ON s.id_sub_task = h.id_sub_task
                        WHERE h.id_task = '$id_task'
                        AND DATE(h.created_at) BETWEEN IF(DATEDIFF(CURRENT_DATE,s.end) < 0,  DATE(s.start), CURRENT_DATE) AND DATE(s.end)
                        GROUP BY DATE(h.created_at), h.id_sub_task
                    ) daily
                    GROUP BY daily.id_sub_task
                ) daily ON daily.id_sub_task = t.id_sub_task 
                WHERE t.id_task = '$id_task'
                ORDER BY y.id ASC";
        return $this->db->query($query)->result();
    }

    function get_evaluasi($id_task)
    {
        $query = "SELECT * FROM
                    (SELECT
                        'evaluasi' AS jenis,
                        h.evaluasi AS history,
                        s.sub_task,
                        ty.sub_type AS status,
                        h_group.progress AS progress_before,
                        ROUND(SUM(h_group.progress) OVER (PARTITION BY h.id_sub_task ORDER BY h.id)) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM td_sub_task_history h
                    JOIN td_sub_task s ON s.id_sub_task = h.id_sub_task
                    JOIN td_sub_type ty ON ty.id = s.type
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    LEFT JOIN (
                        SELECT id, id_sub_task, progress
                        FROM td_sub_task_history 
                        WHERE id_task = '$id_task' 
                        AND (evaluasi IS NOT NULL AND evaluasi != '')
                        GROUP BY DATE(created_at), id_sub_task
                        ORDER BY id_sub_task, id 
                    ) h_group ON (h_group.id = h.id AND h_group.id_sub_task = h.id_sub_task)
                    WHERE h.id_task = '$id_task'
                    AND (h.evaluasi IS NOT NULL AND h.evaluasi != '')
                    ORDER BY h.id DESC
                    ) progress";
        return $this->db->query($query)->result();
    }

    function get_attachment($id_task)
    {
        $query = "SELECT
                    a.note AS filename,
                    a.attachment AS file,
                    CONCAT(e.first_name,' ',e.last_name) AS created_by,
                    a.created_at
                FROM td_task_attach a 
                LEFT JOIN xin_employees e ON e.user_id = a.created_by
                WHERE a.id_task = '$id_task'";
        return $this->db->query($query)->result();
    }
}
