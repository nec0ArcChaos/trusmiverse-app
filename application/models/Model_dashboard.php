<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function personal_info()
    {
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT
			e.user_id, e.employee_id,
			CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
			COALESCE(e.profile_picture,'') AS profile_picture,
			IF(e.profile_background = '', 'bg-visi-misi.jpeg', COALESCE(e.profile_background,'bg-visi-misi.jpeg')) AS profile_background,
			e.email,
			e.email_corporate,
			e.company_id,
			c.name AS company_name,
			e.department_id,
			d.department_name,
			e.designation_id,
			ds.designation_name,
			e.email,
			e.gender,
            COALESCE(e.wa_notif_reg,0) AS registered,
            IF(e.password IS NOT NULL AND e.password != '', 1, '') AS `password`,
            COALESCE(ctm_pin_slip,'') AS ctm_pin_slip,
			DATE_FORMAT(e.date_of_joining,'%d %M %Y') AS date_of_joining,
			CONCAT(FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12), ' Tahun, ', TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE)) - (FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12)*12), ' Bulan') AS masa_kerja,
			DATE_FORMAT(e.date_of_birth,'%d %M %Y') AS date_of_birth_text,
            e.date_of_birth,
            TIMESTAMPDIFF( YEAR, date_of_birth, CURDATE( ) ) AS age,
			e.contact_no,
			COALESCE(e.ttd,'') AS ttd,
            COALESCE(e.got_it,0) AS got_it,
            COALESCE(e.got_it_banner,0) AS got_it_banner,
            COALESCE(e.reminder_change_password,0) AS reminder_change_password,
            ultah.text_ultah,
            ultah.text_ultah_wa,
            ultah.url_image as ultah_url_image
		FROM
			xin_employees e
			LEFT JOIN xin_companies c ON c.company_id = e.company_id
			LEFT JOIN xin_departments d ON d.department_id = e.department_id
			LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
            LEFT JOIN m_dashboard_ultah ultah ON ultah.company_id = e.company_id
			WHERE e.user_id = '$user_id'";
        return $this->db->query($query)->row();
    }

    public function team_info()
    {
        $user_id = $this->session->userdata("user_id");
        $department_id = $this->session->userdata("department_id");
        $designation_id = $this->session->userdata("designation_id");
        $query = "SELECT
			e.user_id,
			CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
			e.profile_picture,
			e.profile_background,
			e.email,
			e.company_id,
			c.name AS company_name,
			e.department_id,
			d.department_name,
			e.designation_id,
			ds.designation_name,
			e.email,
			e.gender,
			DATE_FORMAT(e.date_of_joining,'%d %M %Y') AS date_of_joining,
			CONCAT(FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12), ' Tahun, ', TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE)) - (FLOOR(TIMESTAMPDIFF(MONTH,e.date_of_joining,COALESCE(if(date_of_leaving = '',NULL,date_of_leaving),CURRENT_DATE))/12)*12), ' Bulan') AS masa_kerja,
			DATE_FORMAT(e.date_of_birth,'%d %M %Y') AS date_of_birth,
			e.contact_no
		FROM
			xin_employees e
			LEFT JOIN xin_companies c ON c.company_id = e.company_id
			LEFT JOIN xin_departments d ON d.department_id = e.department_id
			LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
			WHERE e.user_id != '$user_id' AND e.user_id != '1' AND (e.department_id = '$department_id' OR e.designation_id = '$designation_id') AND e.is_active =1 ORDER BY e.designation_id,e.first_name LIMIT 9";
        return $this->db->query($query)->result();
    }


    public function get_employee_id()
    {
        $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS employee_name FROM xin_employees WHERE user_id != 1 AND is_active = 1";
        return $this->db->query($query)->result();
    }


    public function total_hari()
    {
        $this->db->query("SELECT
        DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') + INTERVAL a + b DAY dte,
        weekday(DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') + INTERVAL a + b DAY) AS id_hari,
        DAYNAME(DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') + INTERVAL a + b DAY) AS nama_hari,
        IF(weekday(DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') + INTERVAL a + b DAY) = 0,0,1) AS hari_kerja
    FROM
        (
        SELECT
            0 a UNION
        SELECT
            1 a UNION
        SELECT
            2 UNION
        SELECT
            3 UNION
        SELECT
            4 UNION
        SELECT
            5 UNION
        SELECT
            6 UNION
        SELECT
            7 UNION
        SELECT
            8 UNION
        SELECT
            9 
        ) d,
        ( SELECT 0 b UNION SELECT 10 UNION SELECT 20 UNION SELECT 30 UNION SELECT 40 ) m 
    WHERE
        DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') + INTERVAL a + b DAY <= DATE_FORMAT(CURRENT_DATE, '%Y-%m-20')
    ORDER BY
        a + b");
    }

    public function resume_izin_leave($user_id)
    {
        $query = "SELECT 
                    COUNT(leave_id) AS jml_izin
                FROM xin_leave_applications 
                WHERE 
                from_date >= DATE_FORMAT( CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21' ) 
                AND to_date <= DATE_FORMAT( CURRENT_DATE, '%Y-%m-21' ) AND employee_id = $user_id 
                AND `status` = 2";
        return $this->db->query($query)->row();
    }

    public function resume_absen()
    {
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT x.user_id,
        SUM(CASE WHEN x.clock_in IS NOT NULL AND x.clock_out IS NOT NULL THEN 1 ELSE 0 END) AS present,
        SUM(
                CASE WHEN x.diff_in > 0 THEN
                    CASE WHEN x.diff_in > 180 THEN IF(x.diff_out >= 240,0,x.diff_in)
                        WHEN x.diff_in > 120 THEN IF(x.diff_out >= 180,0,x.diff_in)
                            WHEN x.diff_in > 60 THEN IF(x.diff_out >= 120,0,x.diff_in)
                                WHEN x.diff_in > 0 THEN IF(x.diff_out >= 60,0,x.diff_in)
                                    ELSE 0 END
                    ELSE 0 END
            ) AS dt
        FROM(
        SELECT
            e.user_id,
            CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
            t.attendance_date,
            CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_in_time
            WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_in_time
            WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_in_time
            WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_in_time
            WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_in_time
            WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_in_time
            WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_in_time	
            ELSE '' END
            AS shift_in,
            TIME_FORMAT(t.clock_in, '%H:%i') AS clock_in,
            TIMESTAMPDIFF(MINUTE,CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(s.monday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(s.tuesday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(s.wednesday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(s.thursday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(s.friday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(s.saturday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(s.monday_in_time)
            ELSE '' END, TIME(t.clock_in)) AS diff_in,
            t.photo_in,
            CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_out_time
            WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_out_time
            WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_out_time
            WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_out_time
            WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_out_time
            WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_out_time
            WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_out_time	
            ELSE '' END
            AS shift_out,
            TIME_FORMAT(t.clock_out, '%H:%i') AS clock_out,
            TIMESTAMPDIFF(MINUTE,CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(s.monday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(s.tuesday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(s.wednesday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(s.thursday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(s.friday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(s.saturday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(s.monday_out_time)
            ELSE '' END, TIME(t.clock_out)) AS diff_out,
            t.photo_out
        FROM
            xin_employees e
            LEFT JOIN xin_office_shift s ON e.office_shift_id = s.office_shift_id
            LEFT JOIN xin_attendance_time t ON t.employee_id = e.user_id
        WHERE
            e.user_id = '$user_id' AND t.attendance_date BETWEEN DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') AND DATE_FORMAT(CURRENT_DATE, '%Y-%m-21')
            ) AS x";
        return $this->db->query($query)->row();
    }

    public function resume_absen_new()
    {
        $user_id = $this->session->userdata("user_id");
        $query = "SELECT x.user_id,
        SUM(CASE WHEN x.clock_in IS NOT NULL AND x.clock_out IS NOT NULL THEN 1 ELSE 0 END) AS present,
        SUM(CASE WHEN x.leave_id IS NOT NULL THEN 0 ELSE IF(x.diff_in >= 0, x.diff_in,0) END) AS dt
        FROM(
        SELECT
            e.user_id,
            CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
            t.attendance_date,
            CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_in_time
            WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_in_time
            WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_in_time
            WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_in_time
            WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_in_time
            WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_in_time
            WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_in_time	
            ELSE '' END
            AS shift_in,
            TIME_FORMAT(t.clock_in, '%H:%i') AS clock_in,
            TIMESTAMPDIFF(MINUTE,CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(s.monday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(s.tuesday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(s.wednesday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(s.thursday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(s.friday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(s.saturday_in_time)
            WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(s.monday_in_time)
            ELSE '' END, TIME(t.clock_in)) AS diff_in,
            t.photo_in,
            CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN s.monday_out_time
            WHEN WEEKDAY(t.attendance_date) = 1 THEN s.tuesday_out_time
            WHEN WEEKDAY(t.attendance_date) = 2 THEN s.wednesday_out_time
            WHEN WEEKDAY(t.attendance_date) = 3 THEN s.thursday_out_time
            WHEN WEEKDAY(t.attendance_date) = 4 THEN s.friday_out_time
            WHEN WEEKDAY(t.attendance_date) = 5 THEN s.saturday_out_time
            WHEN WEEKDAY(t.attendance_date) = 6 THEN s.monday_out_time	
            ELSE '' END
            AS shift_out,
            TIME_FORMAT(t.clock_out, '%H:%i') AS clock_out,
            TIMESTAMPDIFF(MINUTE,CASE 
            WHEN WEEKDAY(t.attendance_date) = 0 THEN TIME(s.monday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 1 THEN TIME(s.tuesday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 2 THEN TIME(s.wednesday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 3 THEN TIME(s.thursday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 4 THEN TIME(s.friday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 5 THEN TIME(s.saturday_out_time)
            WHEN WEEKDAY(t.attendance_date) = 6 THEN TIME(s.monday_out_time)
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
					AND SUBSTR( from_date, 1, 10 ) BETWEEN DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') AND DATE_FORMAT(CURRENT_DATE, '%Y-%m-20')
				) izin_dt ON izin_dt.employee_id = e.user_id AND izin_dt.date = t.attendance_date 
        WHERE
            e.user_id = '$user_id' AND t.attendance_date BETWEEN DATE_FORMAT(CURRENT_DATE - INTERVAL 1 MONTH, '%Y-%m-21') AND DATE_FORMAT(CURRENT_DATE, '%Y-%m-20')
            ) AS x";
        return $this->db->query($query)->row();
    }

    public function detail_absen($periode,  $employee_id, $designation_id = null, $cutoff) // detdev addnew cutof
    {
        $time = strtotime($periode);

        $start = date("Y-m-21", strtotime("-1 month", $time));
        $end = date("Y-m-20",  $time);
        $get_user_company_id = $this->db->query("SELECT company_id, office_shift_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
        $company_id = $get_user_company_id->company_id;
        $office_shift_id = $get_user_company_id->office_shift_id;


        $month = date("m", strtotime($periode));
        // takeout kondisi lama by Ade
        // if ($designation_id == 731) { //adding this condition for grade sales
        //     $start = date("Y-m-01", $time);
        //     $end = date("Y-m-t",  $time);
        // } else if ($company_id == 3) {
        //     if ($month == date("m") && date("d") <= 20) {
        //         $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
        //     }else if ($month > date("m") && date("d") > 20) {
        //         $start          = date("Y-m-16", strtotime("-2 month", strtotime(date($periode . '-30'))));
        //     } else {
        //         $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-30'))));
        //     }
        //     $end            = date($periode . "-15");
        // } else {
        //     if ($month == date("m") && date("d") <= 20) {
        //         $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
        //     }else if ($month > date("m") && date("d") > 20) {
        //         $start          = date("Y-m-21", strtotime("-2 month", strtotime(date($periode . '-30'))));
        //     } else {
        //         $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-30'))));
        //     }
        //     $end            = date($periode . "-20");
        // }

        // detdev new condition by Cutoff
        if ($cutoff == 1) { // 21-20
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-d'))));
            }else if ($month > date("m") && date("d") > 20) {
                $start          = date("Y-m-21", strtotime("-2 month", strtotime(date($periode . '-01'))));
            } else {
                $start          = date("Y-m-21", strtotime("-1 month", strtotime(date($periode . '-01'))));
            }
            $end            = date($periode . "-20");

        } else if ($cutoff == 2) { // 16-15
            if ($month == date("m") && date("d") <= 20) {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-d'))));
            }else if ($month > date("m") && date("d") > 20) {
                $start          = date("Y-m-16", strtotime("-2 month", strtotime(date($periode . '-01'))));
            } else {
                $start          = date("Y-m-16", strtotime("-1 month", strtotime(date($periode . '-01'))));
            }
            $end            = date($periode . "-15");

        } else { // 01-eom
            $start = date("Y-m-01", $time);
            $end = date("Y-m-t",  $time);
        }

        $user_id =  $employee_id;
        $query = "SELECT 
        x.*, $office_shift_id  AS office_shift_id,
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
        e.user_id = '$user_id' AND t.attendance_date BETWEEN '$start' AND '$end'
        AND e.ctm_cutoff = '$cutoff' -- addnew
        ORDER BY attendance_date DESC) AS x";
        $data_detail_absen = $this->db->query($query)->result();
        $hasil['data_detail_absen'] = $data_detail_absen;
        $hasil['start_detail'] = $start;
        $hasil['end_detail'] = $end;
        return $hasil;
    }


    public function new_detail_absen($start, $end,  $employee_id)
    {
        $get_user_company_id = $this->db->query("SELECT company_id, office_shift_id FROM xin_employees WHERE user_id = '$employee_id'")->row();
        $company_id = $get_user_company_id->company_id;
        $office_shift_id = $get_user_company_id->office_shift_id;
        $user_id =  $employee_id;
        $query = "SELECT 
        x.*, $office_shift_id  AS office_shift_id,
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
        $data_detail_absen = $this->db->query($query)->result();
        $hasil['data_detail_absen'] = $data_detail_absen;
        $hasil['start_detail'] = $start;
        $hasil['end_detail'] = $end;
        return $hasil;
    }

    public function get_leave_type()
    {
        $user_id = $this->session->userdata('user_id');
        if ((int)date("d") <= 20) {
            $periode = (int)date("m");
        } else {
            $periode = (int)date("m") + 1;
        }
        if ($user_id) {
            $query = "SELECT
                    lt.leave_type_id,
                    lt.type_name,
                    COALESCE(lt.warning,'') AS warning,
                    (lt.days_per_year*1) AS days_per_year,
                    COALESCE(x.jml_hari,0) AS jml_hari,
                    (lt.days_per_year*1) - COALESCE(x.jml_hari,0) AS sisa_izin
                FROM
                    xin_employees e
                    LEFT JOIN xin_leave_type lt ON FIND_IN_SET( lt.leave_type_id, e.leave_categories )
                    LEFT JOIN 
                    (
                                SELECT
                                la.periode,
                                la.employee_id,
                                la.leave_type_id,
                                la.to_date,
                                SUM(la.jml_hari) AS jml_hari
                                FROM
                                (
                                        SELECT
                                            CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
                                            ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END periode,
                                            la.employee_id,
                                            from_date,
                                            to_date,
                                            la.leave_type_id,
                                            TIMESTAMPDIFF(DAY,from_date,to_date) + 1 AS jml_hari
                                        FROM
                                            xin_leave_applications la
                                        WHERE
                                            employee_id = '$user_id' AND 
                                            SUBSTR(from_date,1,4) = YEAR(CURRENT_DATE) AND la.`status` = 2 AND CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
                                            ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END = '$periode'
                                ) AS la 
                            LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
                            GROUP BY la.leave_type_id, la.periode
                    ) AS x ON x.leave_type_id = lt.leave_type_id
                WHERE
                    user_id = '$user_id'";
            return $this->db->query($query)->result();
        }
        return false;
    }

    // public function cek_leave($leave_type, $periode)
    // {
    //     $user_id = $this->session->userdata('user_id');
    //     if ($user_id) {
    //         $query = "SELECT
    //                 lt.leave_type_id,
    //                 lt.type_name,
    //                 COALESCE(lt.warning,'') AS warning,
    //                 (lt.days_per_year*1) AS days_per_year,
    //                 COALESCE(x.jml_hari,0) AS jml_hari,
    //                 (lt.days_per_year*1) - COALESCE(x.jml_hari,0) AS sisa_izin
    //             FROM
    //                 xin_employees e
    //                 LEFT JOIN xin_leave_type lt ON FIND_IN_SET( lt.leave_type_id, e.leave_categories )
    //                 LEFT JOIN 
    //                 (
    //                             SELECT
    //                             la.periode,
    //                             la.employee_id,
    //                             la.leave_type_id,
    //                             la.to_date,
    //                             SUM(la.jml_hari) AS jml_hari
    //                         FROM
    //                         (
    //                                 SELECT
    //                                     CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date)
    //                                     ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END periode,
    //                                     la.employee_id,
    //                                     from_date,
    //                                     to_date,
    //                                     la.leave_type_id,
    //                                     TIMESTAMPDIFF(DAY,from_date,to_date) + 1 AS jml_hari
    //                                 FROM
    //                                     xin_leave_applications la
    //                                 WHERE
    //                                     employee_id = '$user_id' AND 
    //                                     SUBSTR(from_date,1,4) = YEAR(CURRENT_DATE) AND la.`status` = 2 AND la.leave_type_id = '$leave_type' AND 
    //                                     CASE WHEN DAY(from_date) <= 20 THEN MONTH(from_date) ELSE IF(MONTH(from_date) + 1 = 13, 1, MONTH(from_date) + 1) END = '$periode'
    //                         ) AS la 
    //                         LEFT JOIN xin_leave_type lt ON lt.leave_type_id = la.leave_type_id
    //                         GROUP BY la.leave_type_id, la.periode
    //                 ) AS x ON x.leave_type_id = lt.leave_type_id
    //             WHERE
    //                 user_id = '$user_id'";
    //         return $this->db->query($query)->result();
    //     }
    //     return false;
    // }

    public function cek_driver($user_id, $start, $end)
    {
        return $this->db->query("SELECT
		IF ( SUM( DATE_FORMAT( TIMEDIFF( CONCAT( to_date, ' ', end_time ), CONCAT( from_date, ' ', start_time ) ), '%k' ) - IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 )  ) >= IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 ), 1, 0 ) AS driver,
		IF ( xin_leave_applications.employee_id IN ( 64, 14 ), 9, 11 ) AS max_work
		FROM
		xin_leave_applications 
		WHERE
		xin_leave_applications.employee_id = $user_id 
		AND xin_leave_applications.leave_type_id = 23 
		AND xin_leave_applications.`status` = 2 
		AND xin_leave_applications.from_date BETWEEN '$start' 
		AND '$end'")->row_array();
    }

    public function cek_leave($user_id, $start, $end, $type)
    {
        $data = $this->db->query("SELECT
			COALESCE( SUM( DATEDIFF( xin_leave_applications.to_date, xin_leave_applications.from_date ) + 1 ), 0 ) AS total
			FROM
			xin_leave_applications 
			WHERE
			xin_leave_applications.employee_id = $user_id 
			AND xin_leave_applications.leave_type_id IN $type
			AND xin_leave_applications.`status` IN (1,2)
			AND from_date BETWEEN '$start' 
			AND '$end'")->row_array();

        return $data['total'];
    }

    public function get_kota()
    {
        $data = $this->db->query("SELECT
		trusmi_kota.id,
		trusmi_kota.state_id,
		trusmi_kota.city,
		trusmi_kota.zona,
		trusmi_provinsi.state 
		FROM
		trusmi_kota
		JOIN trusmi_provinsi ON trusmi_kota.state_id = trusmi_provinsi.state_id")->result();

        return $data;
    }

    public function add_leave_record($data)
    {
        $this->db->insert('xin_leave_applications', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function cek_pin_slip_pass($user_id)
    {
        $query = "SELECT
                user_id,
                com.`name` AS company_name,
                CONCAT( first_name, ' ', last_name ) AS nama,
                xin_employees.email,
                ctm_pin_slip,
                ctm_password
            FROM
                `xin_employees`
                JOIN xin_companies com ON com.company_id = xin_employees.company_id 
                JOIN trusmi_m_lock lk ON lk.id_lock = 125
            WHERE
                (ctm_pin_slip IS NULL
                OR xin_employees.email IS NULL 
                OR ctm_password = '25d55ad283aa400af464c76d713c07ad') 
                AND xin_employees.is_active = 1
                AND xin_employees.user_id = '$user_id'";
        return $this->db->query($query)->result();
    }
}
