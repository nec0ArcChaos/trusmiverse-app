<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_main extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_task()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( ticket_task.id_task, 3 ) ) AS kd_max 
        FROM
        ticket_task 
        WHERE
        SUBSTR( ticket_task.created_at, 1, 10 ) = CURDATE( )");
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

    public function get_requester()
    {
        return $this->db->query("SELECT
			CONCAT(
				CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ),
				' | ',
				hris.xin_companies.alias,
				' | ',
				hris.xin_departments.department_name 
			) AS requester,
			hris.xin_employees.user_id AS `id_requester` 
		FROM
			hris.xin_employees
			JOIN hris.xin_companies ON hris.xin_employees.company_id = hris.xin_companies.company_id
			JOIN hris.xin_departments ON hris.xin_employees.department_id = hris.xin_departments.department_id 
		WHERE
			hris.xin_employees.is_active = 1 AND hris.xin_employees.user_id != 1");
    }

    public function get_detail_task($id_task)
    {
        $query = "SELECT
                    t.created_by,
                    t.location,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    CONCAT(em.first_name, ' ', em.last_name) AS requested_by,
                    em.profile_picture AS requested_photo,
                    em.contact_no AS requested_contact_no,
                    d.department_name AS requested_department,
                    ds.designation_name AS requested_designation,
                    cmp.name AS requested_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name, ' (',e.contact_no,')')) AS team_name,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    t.level AS id_level,
                    lvl.level AS `level`,
                    lvl.color AS `level_color`,
                    t.task,
                    t.description,
                    t.note,
                    t.progress,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS `start_2`,
                    COALESCE(DATE_FORMAT(t.end, '%d %b %y'),'') AS `end_2`,
                    COALESCE(CASE WHEN DATE_FORMAT( t.`start`, '%b %y' ) = DATE_FORMAT( t.`end`, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d' ), '-', DATE_FORMAT( t.`end`, '%d %b %y' ))
	WHEN  DATE_FORMAT( t.`start`, '%y' ) = DATE_FORMAT( t.`end`, '%y' ) AND DATE_FORMAT( t.`start`, '%b' ) != DATE_FORMAT( t.`end`, '%b' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d %b' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' ))
	ELSE CONCAT(DATE_FORMAT( t.`start`, '%d %b %y' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' )) END,'') AS timeline,
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
                    pic AS id_pic,
                    COALESCE(t.due_date,'') AS due_date,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date_2,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_TIME, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'bg-light-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'bg-light-yellow' 
                    ELSE 'bg-light-blue' END AS due_date_style,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'text-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'text-yellow' 
                    ELSE 'text-blue' END AS due_date_style_text,
                    COALESCE(t.start,CURRENT_TIME) AS `start`,
                    COALESCE(t.end,t.due_date) AS `end`
                FROM
                    `ticket_task` t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = em.designation_id
                    LEFT JOIN ticket_type ty ON ty.id = t.type
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN ticket_status s ON s.id = t.`status`
                    LEFT JOIN ticket_level lvl ON lvl.id = t.`level`
                    LEFT JOIN ticket_priority p ON p.id = t.priority
                    WHERE t.id_task = '$id_task'
                    GROUP BY t.id_task";
        return $this->db->query($query)->row();
    }

    function get_log_history($id_task)
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
                    FROM ticket_task_history h
                    LEFT JOIN ticket_task task ON task.id_task = h.id_task
                    LEFT JOIN ticket_status s ON s.id = h.`status`
                    LEFT JOIN ticket_status sb ON sb.id = h.`status_before`
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
                    FROM ticket_task_history h
                    LEFT JOIN ticket_task task ON task.id_task = h.id_task
                    LEFT JOIN ticket_status s ON s.id = h.`status`
                    LEFT JOIN ticket_status sb ON sb.id = h.`status_before`
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
                    FROM ticket_task_history h
                    LEFT JOIN ticket_task task ON task.id_task = h.id_task
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND (h.note IS NOT NULL AND h.note  != '')
                    -- NOTE

                                
                ) history_log 
                ORDER BY datetime DESC";
        return $this->db->query($query)->result();
    }

    function get_comment($id_task)
    {
        $query = "SELECT
        COALESCE(c.id,0) AS id_comment,
        c.id_task,
        c.`comment`,
        COALESCE(c.reply_to,'') AS reply_to,
        CASE WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 24 THEN
					CONCAT(DATE_FORMAT(c.created_at,'%d %b %y'),' | ', DATE_FORMAT(c.created_at,'%H:%i'))
				WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 1 THEN
					CONCAT(TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME),' hrs ago')
					ELSE
						CONCAT(TIMESTAMPDIFF(MINUTE,c.created_at,CURRENT_TIME), ' mnt ago')
				END AS `times`,
        DATE_FORMAT(c.created_at,'%d %b %y') AS tgl,
        DATE_FORMAT(c.created_at,'%H:%i') AS jam,
        c.created_by,
        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
        e.profile_picture
    FROM
        `ticket_comment` c
        LEFT JOIN xin_employees e ON e.user_id = c.created_by
        WHERE c.id_task = '$id_task' AND c.reply_to IS NULL
        ORDER BY c.created_at DESC";
        return $this->db->query($query)->result();
    }

    function get_reply($id_task)
    {
        $query = "SELECT
        COALESCE(c.id,0) AS id_comment,
        c.id_task,
        c.`comment`,
        COALESCE(c.reply_to,'') AS reply_to,
        CASE WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 24 THEN
					CONCAT(DATE_FORMAT(c.created_at,'%d %b %y'),' | ', DATE_FORMAT(c.created_at,'%H:%i'))
				WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 1 THEN
					CONCAT(TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME),' hrs ago')
					ELSE
						CONCAT(TIMESTAMPDIFF(MINUTE,c.created_at,CURRENT_TIME), ' mnt ago')
				END AS times,
        DATE_FORMAT(c.created_at,'%d %b %y') AS tgl,
        DATE_FORMAT(c.created_at,'%H:%i') AS jam,
        c.created_by,
        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
        e.profile_picture
    FROM
        `ticket_comment` c
        LEFT JOIN xin_employees e ON e.user_id = c.created_by
        WHERE c.id_task = '$id_task' AND c.reply_to IS NOT NULL
        ORDER BY c.created_at";
        return $this->db->query($query)->result();
    }

    function get_attachment($id_task)
    {
        $query = "SELECT
                        a.note AS `filename`,
                        a.attachment AS `file`,
                        SUBSTRING_INDEX(a.attachment, '.', -1) AS type_file,
                        CONCAT(e.first_name,' ',e.last_name) AS created_by,
                        a.created_at,
                        CASE WHEN TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) > 24 THEN
                            CONCAT(DATE_FORMAT(a.created_at,'%d %b %y'),' | ', DATE_FORMAT(a.created_at,'%H:%i'))
                        WHEN TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) > 1 THEN
                            CONCAT(TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME),' hrs ago')
                            ELSE
                                CONCAT(TIMESTAMPDIFF(MINUTE,a.created_at,CURRENT_TIME), ' mnt ago')
                        END AS `times`
                    FROM ticket_task_attach a 
                    LEFT JOIN xin_employees e ON e.user_id = a.created_by
                    WHERE a.id_task = '$id_task'
                    UNION
                    SELECT
                        b.id_task AS `filename`,
                        b.file AS `file`,
                        SUBSTRING_INDEX(b.file, '.', -1) AS type_file,
                        CONCAT( e.first_name, ' ', e.last_name ) AS created_by,
                        b.created_at,
                        CASE WHEN TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) > 24 THEN
                            CONCAT(DATE_FORMAT(b.created_at,'%d %b %y'),' | ', DATE_FORMAT(b.created_at,'%H:%i'))
                        WHEN TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) > 1 THEN
                            CONCAT(TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME),' hrs ago')
                            ELSE
                                CONCAT(TIMESTAMPDIFF(MINUTE,b.created_at,CURRENT_TIME), ' mnt ago')
                        END AS `times`
                    FROM
                        ticket_task b
                        LEFT JOIN xin_employees e ON e.user_id = b.created_by 
                    WHERE
                        b.id_task = '$id_task' AND b.file IS NOT NULL AND b.file != ''";
        return $this->db->query($query)->result();
    }

    public function get_ticket_request($id_task)
    {
        $query = "SELECT
                    t.id_task,
                    t.task,
                    t.description,
                    tt.type,
                    c.category,
                    o.object,
                    p.priority,
                    DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                    r.user_id as requester_id,
                    CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                        CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                        ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                        CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                        ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no
                FROM
                    `ticket_task` t
                    LEFT JOIN ticket_category c ON c.id = t.category
                    LEFT JOIN ticket_type tt ON tt.id = t.type
                    LEFT JOIN ticket_object o ON o.id = t.object
                    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                    LEFT JOIN xin_employees r ON r.user_id = t.created_by
                    LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                    t.id_task = '$id_task'";
        return $this->db->query($query)->result();
    }

    public function get_ticket_request_working_on($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        CONCAT(DATE_FORMAT(t.`start`, '%d %b'), ' s/d ', DATE_FORMAT(t.`end`,'%d %b')) AS timeline,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 2";
        return $this->db->query($query)->row();
    }

    public function get_ticket_request_qa($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        CONCAT(DATE_FORMAT(t.`start`, '%d %b'), ' s/d ', DATE_FORMAT(t.`end`,'%d %b')) AS timeline,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 11";
        return $this->db->query($query)->row();
    }

    public function get_ticket_request_done($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 3";
        return $this->db->query($query)->row();
    }

    public function get_ticket_request_cancel($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        t.note,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 4";
        return $this->db->query($query)->row();
    }


    public function get_ticket_request_hold($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        t.note,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 7";
        return $this->db->query($query)->row();
    }


    public function get_ticket_request_rescheduled($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        t.note,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `ticket_task` t
                        LEFT JOIN ticket_category c ON c.id = t.category
                        LEFT JOIN ticket_type tt ON tt.id = t.type
                        LEFT JOIN ticket_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN ticket_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 6";
        return $this->db->query($query)->row();
    }
}
