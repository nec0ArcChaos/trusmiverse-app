<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_security_on_duty extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // Security On Duty
    
    function generate_id_security_task()
    {
        $q = $this->db->query("SELECT 
                                MAX( RIGHT ( id_task, 4 ) ) AS kd_max 
                              FROM
                                sc_t_task 
                              WHERE
                                DATE( created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return 'SC' . date('ymd') . $kd;
    }

    function cek_task($id_site, $id_shift, $id_user)
    {
        $sql = "SELECT
                    * 
                FROM
                    sc_t_task 
                WHERE
                    id_site = '$id_site' 
                    AND id_shift = $id_shift 
                    AND DATE( created_at ) = CURDATE()
                    AND created_by = $id_user";

        return $this->db->query($sql);
    }

    function dt_list_task_item($id_task)
    {
        $sql = "SELECT
                    * 
                FROM
                    `sc_t_task_item`
                WHERE
                    id_task = '$id_task'
                    AND time_start <= CURTIME()
	                AND time_end >= CURTIME()
                ORDER BY `status` ASC";

        return $this->db->query($sql);
    }

    function detail_task_item($id)
    {
        $sql = "SELECT
                    sc_t_task_item.*,
                    SUBSTR(sc_t_task_item.time_start, 1, 5) AS timestart, 
                    SUBSTR(sc_t_task_item.time_end, 1, 5) AS timeend 
                FROM
                    `sc_t_task_item`
                WHERE
                    id = '$id'";

        return $this->db->query($sql);
    }

    // addnew Resume
    function dt_resume_tasklist($datestart, $dateend)
    {
        $user_id = $this->session->userdata('user_id');
        
        if (in_array($user_id, [1, 476, 8066, 5840, 1994, 5941, 10197, 10176]) == 1) {
            $kondisi = "";
        } else {
            $kondisi = "AND task.created_by = '$user_id'";
        }

        $sql = "SELECT
                    task.id_task,
                    task.id_project,
                    m_project.project,
                    task.id_shift,
                    shift.shift,
                    -- ROUND(task.achievement, 2) AS achievement,
                    ROUND((COUNT(IF(LEFT(sc_t_task_item.photo,3) = 'sc_', 1, NULL)) / COUNT(sc_t_task_item.id_task)) * 100, 2) AS achievement,
                    task.average_rating,
                    task.created_at,
                    task.created_by AS id_created_by,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by
                FROM
                    `sc_t_task` AS task
                    JOIN rsp_project_live.m_project m_project ON task.id_project = m_project.id_project
                    JOIN sc_m_shift shift ON task.id_shift = shift.id_shift
                    JOIN xin_employees emp ON task.created_by = emp.user_id
                    JOIN sc_t_task_item ON sc_t_task_item.id_task = task.id_task
                WHERE
                    task.created_at BETWEEN '$datestart' AND '$dateend'
                    $kondisi
                GROUP BY task.id_task";

        return $this->db->query($sql);
    }

    function dt_list_detail_task($datestart, $dateend)
    {
        $user_id = $this->session->userdata('user_id');
        
        if (in_array($user_id, [1, 476, 8066, 5840, 1994, 5941, 10197, 10176]) == 1) {
            $kondisi = "";
        } else {
            $kondisi = "AND item.created_by = '$user_id'";
        }

        $sql = "SELECT
                    item.id_task,
                    task.id_project,
                    m_project.project,
                    task.id_shift,
                    shift.shift,
                    item.tasklist,
                    item.time_start,
                    item.time_end,
                    item.time_actual,
                    item.`status`,
                    item.photo,
                    item.note,
                    item.created_at,
                    item.created_by AS id_created_by,
                    CONCAT(emp.first_name, ' ', emp.last_name) AS created_by
                FROM
                    sc_t_task_item AS item
                    JOIN sc_t_task task ON item.id_task = task.id_task
                    JOIN rsp_project_live.m_project m_project ON task.id_project = m_project.id_project
                    JOIN sc_m_shift shift ON task.id_shift = shift.id_shift
                    JOIN xin_employees emp ON task.created_by = emp.user_id
                WHERE
                    item.created_at BETWEEN '$datestart' AND '$dateend'
                    $kondisi";

        return $this->db->query($sql);
    }

   function detail_modal($id_task)
{
    $sql = "SELECT
                item.id,
                item.id_task,
                task.id_project,
                m_project.project,
                task.id_shift,
                shift.shift,
                item.tasklist,
                item.time_start,
                item.time_end,
                item.time_actual,
                item.status,
                item.photo,
                item.note,
                item.created_at,
                item.created_by AS id_created_by,
                CONCAT(emp.first_name, ' ', emp.last_name) AS created_by
            FROM sc_t_task_item AS item
            JOIN sc_t_task task ON item.id_task = task.id_task
            JOIN rsp_project_live.m_project m_project ON task.id_project = m_project.id_project
            JOIN sc_m_shift shift ON task.id_shift = shift.id_shift
            JOIN xin_employees emp ON task.created_by = emp.user_id
            WHERE item.id_task = '$id_task' ";

    return $this->db->query($sql);
}


    // addnew for MASTER
    function generate_id_site()
    {
        $q = $this->db->query("SELECT MAX(RIGHT(id_site, 4)) AS kd_max FROM sc_m_site");

        if ($q->num_rows() > 0 && $q->row()->kd_max != null) {
            $tmp = (int)$q->row()->kd_max + 1;
            $kd = sprintf("%04s", $tmp);
        } else {
            $kd = "0001";
        }

        return 'ST' . $kd;
    }



    // -----------------------------------------------------------------------------------
    function list_head()
    {
        $query = "SELECT 
                -- 	dep.department_id,
                -- 	dep.department_name,
                -- 	h.username,
                    h.user_id
                FROM xin_departments dep 
                JOIN xin_employees h ON h.user_id = dep.head_id
                GROUP BY dep.department_id";
        $result = $this->db->query($query)->result();

        $heads = [];
        foreach ($result as $row) {
            array_push($heads, $row->user_id);
        }
        return $heads;
    }

    function get_level_sto()
    {
        $user_id = $_SESSION['user_id'];
        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, e.department_id, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        return $get_level_sto;
    }


    function dt_overtime_request($start, $end, $time_request_id, $status)
    {

        $user_id = $_SESSION['user_id'];
        // $user_role_id = $_SESSION['user_role_id'];
        $super_user = [1, 323, 979, 778, 6486, 1139];
        $heads = $this->list_head();


        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, e.department_id, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $level_sto = $get_level_sto['level_sto'];
        $department_id = $get_level_sto['department_id'];
        if ($time_request_id == null) {
            if (in_array($user_id, $super_user) == 1) { // kondisi super user

                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end'";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                AND tr.is_approved = $status";
                }
            } else if (in_array($user_id, $heads)) { // kondisi per department head

                if ($status == "" || $status == null) {
                    $kondisi = "WHERE (tr.request_date BETWEEN '$start' AND '$end' 
                                AND tr.is_approved != 1 
                                AND dep.head_id = $user_id)";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' AND tr.is_approved = $status 
                                AND dep.head_id = $user_id";
                }
            } else if ($level_sto >= 4) { // kondisi jika level sto dari roles lebih atau sama dengan officer
                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                    AND tr.is_approved != 1 
                                    AND em.department_id = '$department_id'
                                    AND ur.level_sto < '$level_sto'";
                } else {
                    $kondisi = "WHERE tr.is_approved = $status 
                                    AND em.department_id = '$department_id'
                                    AND ur.level_sto < '$level_sto'";
                }
            } else { // kondisi user 

                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                AND tr.employee_id = $user_id";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' AND tr.is_approved = $status 
                                AND tr.employee_id = $user_id";
                }
            }
        } else {
            $kondisi = "WHERE tr.time_request_id = '$time_request_id'";
        }


        if (in_array($user_id, $super_user) == 1) { // kondisi super user
            $user_level = 1; // 1 : head
        } else if (in_array($user_id, $heads) == 1) { // kondisi per department head
            $user_level = 1; // 1 : head
        } else {
            $user_level = 2; // staff
        }

        $query = "SELECT
                    $user_level AS user_level,
                    ur.level_sto,
                    tr.time_request_id,
                    CONCAT(em.first_name,' ',em.last_name) AS employee_name,
                    com.`name` AS company_name,
                    dep.department_name AS department_name,
                    dsg.designation_name AS designation_name,
                    tr.request_date AS date,
                    DATE_FORMAT(tr.request_date, '%a, %d %b %Y') AS converted_date,
                    TIME_FORMAT(tr.request_clock_in, '%H:%i') AS in_time,
                    TIME_FORMAT(tr.request_clock_out, '%H:%i') AS out_time,
                    TIME_FORMAT(tr.request_clock_in, '%H:%i') AS clock_in,
                    TIME_FORMAT(absen.shift_in, '%H:%i') AS shift_in,
                    TIME_FORMAT(absen.clock_in, '%H:%i') AS clock_in,
                    TIME_FORMAT(absen.shift_out, '%H:%i') AS shift_out,
                    TIME_FORMAT(absen.clock_out, '%H:%i') AS clock_out,
                    TIME_FORMAT(tr.request_clock_out, '%H:%i') AS clock_out,
                    CONCAT(HOUR(tr.total_hours), 'hr ', MINUTE(tr.total_hours), 'mn') AS total_hours,
                    CASE tr.is_approved
                        WHEN 1 THEN 'Pending'
                        WHEN 2 THEN 'Acepted'
                        WHEN 3 THEN 'Reject'
                        WHEN 4 THEN 'Waiting Dirut'
                        ELSE ''
                    END AS status,
                    tr.is_approved,
                    tr.request_reason AS reason,
                    tr.created_at,
                    COALESCE(CONCAT(gm.first_name,' ',gm.last_name),'') AS approve_gm,
                    COALESCE(tr.gm_at,'') AS approve_gm_date,
                    COALESCE(CONCAT(dirut.first_name,' ',dirut.last_name),'') AS approve_dirut,
                    COALESCE(tr.dirut_at,'') AS approve_dirut_date
                FROM xin_attendance_time_request tr
                JOIN xin_employees em ON em.user_id = tr.employee_id
                LEFT JOIN xin_attendance_time absen ON absen.employee_id = em.user_id AND tr.request_date = absen.attendance_date
                LEFT JOIN xin_user_roles ur ON ur.role_id = em.user_role_id
                LEFT JOIN xin_departments dep ON dep.department_id = tr.department_id
                LEFT JOIN xin_companies com ON com.company_id = tr.company_id
                LEFT JOIN xin_designations dsg ON dsg.designation_id = em.designation_id
                LEFT JOIN xin_employees gm ON gm.user_id = tr.approve_gm
                LEFT JOIN xin_employees dirut ON dirut.user_id = tr.approve_dirut
                
                $kondisi

                ORDER BY request_date DESC, tr.time_request_id DESC";





        return $this->db->query($query)->result();
    }


    function data_employee($user_id)
    {
        $query = "SELECT user_id, 
                    company_id, 
                    department_id, 
                    designation_id, 
                    user_role_id 
                FROM xin_employees 
                WHERE user_id = '$user_id' 
                LIMIT 1";
        return $this->db->query($query)->row_array();
    }
}
