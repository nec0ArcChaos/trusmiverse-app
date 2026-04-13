<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_monitoring_absen_mkt extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dt_monitoring_absen_mkt()
    {
        $query = "SELECT m.user_id,
            m.employee_name,
            m.spv,
            m.manager,
            m.gm,
            TIMESTAMPDIFF(DAY,CURRENT_DATE - INTERVAL 4 DAY,CURRENT_DATE - INTERVAL 1 DAY) + 1  AS harus_absen,
            SUM(IF(att.clock_in IS NULL AND att.clock_out IS NULL AND a.leave_type_id IS NULL, 0,1)) AS absen,
            SUM(IF(att.clock_in IS NULL AND att.clock_out IS NULL AND a.leave_type_id IS NULL, 1,0)) AS tdk_absen 
            FROM
            (		
                SELECT 
                        a.attendance_date, 
                        employee.*
                FROM 
                (
                    SELECT
                    attendance_date 
                    FROM
                    xin_attendance_time 
                    WHERE
                    SUBSTR( attendance_date, 1, 7 ) = SUBSTR( CURRENT_DATE, 1, 7 ) 
                    AND attendance_date BETWEEN ( CURRENT_DATE - INTERVAL 4 DAY ) 
                    AND ( CURRENT_DATE - INTERVAL 1 DAY ) 
                    GROUP BY
                    attendance_date
                ) AS a, 
                (
                    SELECT 
                        e.user_id, 
                        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                        spv.employee_name AS spv,
                        manager.employee_name AS manager,
                        COALESCE(gm.employee_name,'-') AS gm
                    FROM xin_employees e 
                    LEFT JOIN rsp_project_live.`user` u ON u.join_hr = e.user_id
                    LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                    LEFT JOIN rsp_project_live.`user` manager ON manager.id_user = spv.id_manager
                    LEFT JOIN rsp_project_live.`user` gm ON gm.id_user = manager.id_gm
                    WHERE e.is_active = 1 AND e.department_id = 120 AND u.isActive = 1 AND u.id_user != u.id_gm AND u.id_user != u.id_manager AND u.id_user != u.spv
                ) AS employee
            ) AS m
        LEFT JOIN xin_attendance_time att ON att.employee_id = m.user_id AND m.attendance_date = att.attendance_date
        LEFT JOIN xin_leave_applications a ON a.employee_id = m.user_id AND m.attendance_date >= DATE( a.from_date ) AND m.attendance_date <= DATE( a.to_date ) AND a.status IN (4,2)
        GROUP BY m.user_id";
        return $this->db->query($query)->result();
    }

    function dt_monitoring_absen_mkt_nonaktif()
    {
        $user_id = $this->session->userdata('user_id');
        $designation_id = $this->session->userdata('designation_id');
        $condition = "";
        if (in_array($designation_id, array(894, 1257))) {
            $condition = " AND gm.join_hr = '$user_id'";
        }
        $query = "SELECT
                e.user_id,
                CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                spv.employee_name AS spv,
                manager.employee_name AS manager,
                COALESCE(gm.employee_name,'-') AS gm,
                e.is_active,
                e.auto_non_active,
                e.auto_non_active_at
            FROM xin_employees e
                LEFT JOIN rsp_project_live.`user` u ON u.join_hr = e.user_id
                LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = u.spv
                LEFT JOIN rsp_project_live.`user` manager ON manager.id_user = spv.id_manager
                LEFT JOIN rsp_project_live.`user` gm ON gm.id_user = manager.id_gm
            WHERE
                u.id_divisi = 2 
                AND e.is_active = 0 
                AND u.id_gm != u.id_user 
                AND u.id_manager != u.id_user 
                AND u.spv != u.id_user
                AND e.auto_non_active = 1
                $condition";
        return $this->db->query($query)->result();
    }

    function activated_user()
    {
        $user_id = $this->input->post('user_id');
        if ($user_id != '') {
            $data = array(
                'is_active' => 1,
                'auto_non_active' => NULL
            );
            return $this->db->where('user_id', $user_id)->update('xin_employees', $data);
        }
        return false;
    }

    public function detail_absen($periode,  $employee_id)
    {
        $time = strtotime($periode);
        $start = date("Y-m-21", strtotime("-1 month", $time));
        $end = date("Y-m-20",  $time);

        $get_user_company_id = $this->db->query("SELECT company_id, office_shift_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
        $company_id = $get_user_company_id->company_id;
        $office_shift_id = $get_user_company_id->office_shift_id;


        $month = date("m", strtotime($periode));
        if ($company_id == 3) {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date("Y-m-15", strtotime("+1 month", strtotime(date($periode . '-30'))));
        } else {
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
            } else {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-30'))));
            }
            $end            = date("Y-m-20", strtotime("+1 month", strtotime(date($periode . '-30'))));
        }
        $user_id =  $employee_id;
        $query = "SELECT x.*, $office_shift_id  AS office_shift_id,
        CASE WHEN x.leave_id IS NOT NULL THEN
			0
		ELSE x.diff_in END AS dt
        FROM( 
        SELECT
        e.user_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
        t.attendance_date,
        -- CASE 
        -- WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_in_time
        -- WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_in_time	
        -- ELSE '' END
        t.shift_in AS shift_in,
        TIME_FORMAT(t.clock_in, '%H:%i') AS clock_in,
        TIMESTAMPDIFF(MINUTE,CASE 
        WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(t.shift_in)
        WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(t.shift_in)
        ELSE '' END, TIME(t.clock_in)) AS diff_in,
        t.photo_in,
        -- CASE 
        -- WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_out_time
        -- WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_out_time	
        -- ELSE '' END
        t.shift_out AS shift_out,
        TIME_FORMAT(t.clock_out, '%H:%i') AS clock_out,
        TIMESTAMPDIFF(MINUTE,CASE 
        WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(t.shift_out)
        WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(t.shift_out)
        ELSE '' END, TIME(t.clock_out)) AS diff_out,
        t.photo_out,
        izin_dt.leave_id
    FROM
        xin_employees e
        LEFT JOIN xin_office_shift s ON e.office_shift_id = s.office_shift_id
        LEFT JOIN xin_attendance_time t ON t.employee_id = e.user_id
        LEFT JOIN (
				SELECT
					leave_id,
					employee_id,
					SUBSTR( from_date, 1, 10 ) AS date
				FROM
					xin_leave_applications 
				WHERE
					employee_id = '$user_id' 
					AND leave_type_id = 11 
					AND `status` = 2 
					AND SUBSTR( from_date, 1, 10 ) BETWEEN '$start' AND '$end'
				) izin_dt ON izin_dt.employee_id = e.user_id AND izin_dt.date = t.attendance_date 
    WHERE
        e.user_id = '$user_id' AND t.attendance_date BETWEEN '$start' AND '$end' ORDER BY attendance_date DESC) AS x";
        return $this->db->query($query)->result();
    }
}
