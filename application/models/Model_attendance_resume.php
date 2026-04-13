<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_attendance_resume extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function dt_attendance($company_id, $department_id, $employee_id, $start, $end){

        // if($employee_id = '2378'){ // 0: All
        //     $kondisi = "AND hris.xin_employees.department_id in (133,27,25,26)";
        // }else
        
        if($employee_id != '0'){ // 0: All
            if($this->session->userdata('user_id') == '2535'){ // 0: nani
                $kondisi = "AND hris.xin_employees.department_id = 120";
            } else {
                $kondisi = "AND hris.xin_employees.user_id = $employee_id";
            }
        }else if($department_id != '0'){
            $kondisi = "AND hris.xin_employees.department_id = $department_id";
        }else if($company_id != '0'){
            $kondisi = "AND hris.xin_employees.company_id = $company_id";
        }else{
            $company_id = $this->session->userdata('company_id');
            $kondisi = "AND hris.xin_employees.company_id = $company_id";
        }

        $query = "SELECT
                    hris.xin_employees.company_id,
                    hris.xin_attendance_time.employee_id,
                    hris.xin_attendance_time.time_attendance_id,
                    CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS username,
                    hris.xin_designations.designation_name,
                    hris.xin_attendance_time.attendance_date,
                    substr( hris.xin_attendance_time.clock_in, 12, 5 ) AS clock_in,
                    substr( hris.xin_attendance_time.clock_out, 12, 5 ) AS clock_out,
                    -- hris.xin_attendance_time.total_work,
                    TIME_FORMAT(
                        TIMEDIFF(
                            STR_TO_DATE(SUBSTR(hris.xin_attendance_time.clock_out, 12, 5), '%H:%i'),
                            STR_TO_DATE(SUBSTR(hris.xin_attendance_time.clock_in, 12, 5), '%H:%i')
                        ), '%H:%i'
                    ) AS total_work,
                    TIMEDIFF( substr( hris.xin_attendance_time.clock_in, 12, 8 ), hris.xin_attendance_time.shift_in ) AS late,
                    hris.xin_attendance_time.photo_in,
                    hris.xin_attendance_time.photo_out,

                    -- addnew
                    hris.xin_attendance_time.shift_in,
                    hris.xin_attendance_time.shift_out
                FROM
                    hris.xin_attendance_time
                    JOIN hris.xin_employees ON hris.xin_employees.user_id = hris.xin_attendance_time.employee_id
                    JOIN hris.xin_companies ON hris.xin_companies.company_id = hris.xin_employees.company_id
                    JOIN hris.xin_departments ON hris.xin_departments.department_id = hris.xin_employees.department_id
                    JOIN hris.xin_designations ON hris.xin_designations.designation_id = hris.xin_employees.designation_id 
                WHERE ( hris.xin_attendance_time.attendance_date BETWEEN '$start' AND '$end' ) 
                -- AND hris.xin_employees.company_id = 1
                -- AND hris.xin_employees.department_id = 68
                -- AND hris.xin_employees.user_id = 63
                $kondisi
                GROUP BY
                    hris.xin_attendance_time.attendance_date,
                    hris.xin_attendance_time.employee_id
                ORDER BY CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) ASC, 
                hris.xin_attendance_time.attendance_date ASC";
        return $this->db->query($query)->result();
    }


    function dt_pembatalan_absensi($company_id, $department_id, $employee_id, $start, $end)
	{

        if($employee_id != '0'){ // 0: All
            if($this->session->userdata('user_id') == '2535'){ // 0: nani
                $kondisi = "AND hris.xin_employees.department_id = 120";
            } else {
                $kondisi = "AND hris.xin_employees.user_id = $employee_id";
            }
        }else if($department_id != '0'){
            $kondisi = "AND hris.xin_employees.department_id = $department_id";
        }else if($company_id != '0'){
            $kondisi = "AND hris.xin_employees.company_id = $company_id";
        }else{
            $company_id = $this->session->userdata('company_id');
            $kondisi = "AND hris.xin_employees.company_id = $company_id";
        }
		
        
		$query = "SELECT
				hris.xin_employees.company_id,
				hris.xin_attendance_delete.employee_id,
				hris.xin_attendance_delete.time_attendance_id,
				CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS username,
				hris.xin_designations.designation_name,
				hris.xin_attendance_delete.attendance_date,
				substr( hris.xin_attendance_delete.clock_in, 12, 5 ) AS clock_in,
				substr( hris.xin_attendance_delete.clock_out, 12, 5 ) AS clock_out,
				hris.xin_attendance_delete.total_work,
				TIMEDIFF( substr( hris.xin_attendance_delete.clock_in, 12, 8 ), '08:00:00' ) AS late,
				hris.xin_attendance_delete.photo_in,
				hris.xin_attendance_delete.photo_out,
				SUBSTR(hris.xin_attendance_delete.delete_at,1,10) AS tgl_hapus,
				hris.xin_attendance_delete.delete_by,
                CONCAT( hapus.first_name, ' ', hapus.last_name ) AS user_hapus
			FROM hris.xin_attendance_delete
            JOIN hris.xin_employees ON hris.xin_employees.user_id = hris.xin_attendance_delete.employee_id
            JOIN hris.xin_employees hapus ON hapus.user_id = IF(hris.xin_attendance_delete.delete_by=18,340,hris.xin_attendance_delete.delete_by)
            JOIN hris.xin_designations ON hris.xin_designations.designation_id = hris.xin_employees.designation_id 
            WHERE ( hris.xin_attendance_delete.attendance_date BETWEEN '$start' AND '$end' ) 
			-- $kondisi
			GROUP BY
				hris.xin_attendance_delete.attendance_date,
				hris.xin_attendance_delete.employee_id";
		return $this->db->query($query)->result();
	}



    public function tanggal_periode($start, $end)
    {
        $query = "SELECT date FROM `all_dates` WHERE date BETWEEN '2023-04-21' AND '2023-05-20'";

        return $this->db->query($query);
    }

    public function get_company()
    {
        $query = "SELECT
            xin_companies.company_id,
            xin_companies.`name` AS company 
        FROM
            xin_companies";

        return $this->db->query($query);
    }

    public function get_department($company_id)
    {
        $query = "SELECT
            0 AS `value`,
            'All Departments' AS `text` UNION
        SELECT
            xin_departments.department_id AS `value`,
            xin_departments.department_name AS `text` 
        FROM
            xin_departments 
        WHERE
            xin_departments.company_id != 0 AND xin_departments.company_id = $company_id";

        return $this->db->query($query);
    }

    public function get_employees($company_id, $department_id)
    {
        $query = "SELECT
            0 AS `value`,
            'All Employees' AS `text` UNION
        SELECT
            xin_employees.user_id AS `value`,
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `text` 
        FROM
            xin_employees 
        WHERE
            xin_employees.company_id = $company_id 
            AND xin_employees.department_id = $department_id 
            AND xin_employees.is_active = 1";

        return $this->db->query($query);
    }

    public function get_periode($periode, $start, $end, $tipe)
    {
        if ($tipe == 1) {
            $select = "CASE
                WHEN MONTH(all_dates.date) = 1 THEN 'Januari'
                WHEN MONTH(all_dates.date) = 2 THEN 'Februari'
                WHEN MONTH(all_dates.date) = 3 THEN 'Maret'
                WHEN MONTH(all_dates.date) = 4 THEN 'April'
                WHEN MONTH(all_dates.date) = 5 THEN 'Mei'
                WHEN MONTH(all_dates.date) = 6 THEN 'Juni'
                WHEN MONTH(all_dates.date) = 7 THEN 'Juli'
                WHEN MONTH(all_dates.date) = 8 THEN 'Agustus'
                WHEN MONTH(all_dates.date) = 9 THEN 'September'
                WHEN MONTH(all_dates.date) = 10 THEN 'Oktober'
                WHEN MONTH(all_dates.date) = 11 THEN 'November'
                WHEN MONTH(all_dates.date) = 12 THEN 'Desember'
            END AS bulan,
            COUNT( SUBSTR( all_dates.date, 1, 7 ) ) AS colspan";

            $group  = "GROUP BY SUBSTR( all_dates.date, 1, 7 )";
        } else {
            $select = "all_dates.date, SUBSTR( all_dates.date, 9, 10 ) AS tgl";

            $group  = "";
        }

        $query = "SELECT
            $select
        FROM
            all_dates 
        WHERE
            all_dates.date BETWEEN '$start' 
            AND '$end' 
            $group
        ORDER BY
            all_dates.date";

        return $this->db->query($query);
    }


}
