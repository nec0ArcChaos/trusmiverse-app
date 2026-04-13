<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_overtime_request extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function list_head()
    {
            $query = "SELECT 
                    -- 	dep.department_id,
                    -- 	dep.department_name,
                    -- 	h.username,
                        h.user_id
                    FROM xin_departments dep 
                    JOIN xin_employees h ON h.user_id = dep.head_id
                    GROUP BY h.user_id";
        $result = $this->db->query($query)->result();

        $heads = [];
        foreach ($result as $row) {
            array_push($heads, $row->user_id);
        }
        return $heads;
    }

    function list_manager()
    {
        $query = "SELECT user_id FROM xin_employees WHERE ctm_posisi = 'Manager' AND is_active = 1";
        $result = $this->db->query($query)->result();

        $managers = [];
        foreach ($result as $row) {
            array_push($managers, $row->user_id);
        }
        return $managers;
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
        $super_user = [1, 979, 778, 6486, 1369, 1139];
        $heads = $this->list_head();
        $managers = $this->list_manager();


        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, e.department_id, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $level_sto = $get_level_sto['level_sto'];
        $department_id = $get_level_sto['department_id'];
        if ($time_request_id == null) {
            if ($user_id == 1721) { // custom akses untuk user Eco
                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.company_id = 3 
                    AND tr.department_id NOT IN (47,116,168,169)
                    AND tr.request_date BETWEEN '$start' AND '$end'";
                } else {
                    $kondisi = "WHERE tr.company_id = 3 
                    AND tr.department_id NOT IN (47,116,168,169)
                    AND tr.is_approved = $status 
                    AND tr.request_date BETWEEN '$start' AND '$end'";
                }
            } else if (in_array($user_id, $super_user) == 1) { // kondisi super user

                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end'";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                AND tr.is_approved = $status";
                }
            } else if (in_array($user_id, $heads) && in_array($user_id, $managers)) { // kondisi per department head dan manager divisi lain
                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                    AND ((tr.is_approved != 1 
                    AND dep.head_id = $user_id) OR (tr.is_approved != 1 
                    AND em.department_id = '$department_id'))";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' AND (tr.is_approved = $status 
                    AND dep.head_id = $user_id) OR (tr.is_approved = $status 
                    AND em.department_id = '$department_id')";
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
            } else if (in_array($user_id, $managers)) { // kondisi per department manager
                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                    AND tr.is_approved != 1 
                                    AND em.department_id = '$department_id'";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' AND  tr.is_approved = $status 
                                    AND em.department_id = '$department_id'";
                }
            } else if ($level_sto >= 4) { // kondisi jika level sto dari roles lebih atau sama dengan officer
                if ($status == "" || $status == null) {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' 
                                    AND tr.is_approved != 1 
                                    AND em.department_id = '$department_id'
                                    AND ur.level_sto < '$level_sto'";
                } else {
                    $kondisi = "WHERE tr.request_date BETWEEN '$start' AND '$end' AND   tr.is_approved = $status 
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
                    COALESCE(tr.dirut_at,'') AS approve_dirut_date,
                    COALESCE(tr.dokumen,'') AS dokumen -- devnew
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
