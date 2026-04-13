<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dash_attendance extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function dash_absen($startdate, $enddate)
	{
		return $this->db->query("SELECT
			xin_companies.company_id,
			xin_companies.NAME as company,
			count( x.employee_id ) AS jumlah,
			m.employee,
			round(((count(x.employee_id) / m.employee) * 100),2) as persen
			FROM
			xin_companies
			LEFT JOIN (
				SELECT
				xin_employees.company_id,
				xin_attendance_time.employee_id 
				FROM
				xin_attendance_time
				JOIN xin_employees ON xin_employees.user_id = xin_attendance_time.employee_id 
				WHERE
				xin_attendance_time.attendance_date BETWEEN '$startdate' 
				AND '$enddate' 
				GROUP BY
				xin_attendance_time.employee_id 
				) x ON x.company_id = xin_companies.company_id
			LEFT JOIN
			(SELECT
				company_id,
				count( user_id ) AS employee 
				FROM
				xin_employees 
				where is_active=1	
				GROUP BY
				company_id
				) m on m.company_id=xin_companies.company_id
			GROUP BY
			xin_companies.company_id")->result();
	}


	public function absen_dept($startdate, $enddate)
	{
		return $this->db->query("SELECT
			xin_companies.company_id,
			xin_companies.NAME as company,
			xin_departments.department_id,
			xin_departments.department_name as department,
			count( x.employee_id ) AS jumlah,
			m.employee,
			round(((count(x.employee_id) / m.employee) * 100),2) as persen
			FROM
			xin_departments
			LEFT JOIN xin_companies on xin_companies.company_id=xin_departments.company_id
			LEFT JOIN (
				SELECT
				xin_employees.department_id,
				xin_attendance_time.employee_id 
				FROM
				xin_attendance_time
				JOIN xin_employees ON xin_employees.user_id = xin_attendance_time.employee_id 
				WHERE
				xin_attendance_time.attendance_date BETWEEN '$startdate' 
				AND '$enddate' 
				GROUP BY
				xin_attendance_time.employee_id 
				) x ON x.department_id = xin_departments.department_id
			LEFT JOIN
			(SELECT
				department_id,
				count( user_id ) AS employee 
				FROM
				xin_employees 
				where is_active=1	
				GROUP BY
				department_id
				) m on m.department_id=xin_departments.department_id
			GROUP BY
			xin_departments.department_id")->result();
	}

	public function list_absen_company($company_id, $startdate, $enddate)
	{
		return $this->db->query("SELECT
			xin_employees.company_id,
			xin_attendance_time.employee_id,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS username,
			xin_designations.designation_name,
			xin_departments.department_name,
			xin_attendance_time.attendance_date,
			substr( xin_attendance_time.clock_in, 12, 5 ) AS clock_in,
			substr( xin_attendance_time.clock_out, 12, 5 ) AS clock_out,
			xin_attendance_time.shift_in,
			xin_attendance_time.shift_out,
			xin_attendance_time.total_work,
			-- TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), '08:00:00' ) AS late,
			CASE
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Mon' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.monday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Tue' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.tuesday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Wed' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.wednesday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Thu' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.thursday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Fri' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.friday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Sat' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.saturday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Sun' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.sunday_in_time, ':00' ) ) 
			END AS late,
			TIME_FORMAT( xin_attendance_time.break_out, '%H:%i' ) AS break_out,
			TIME_FORMAT( xin_attendance_time.break_in, '%H:%i' ) AS break_in,
			TIME_FORMAT( ABS( TIMEDIFF( TIME_FORMAT( xin_attendance_time.break_out, '%H:%i' ), TIME_FORMAT( xin_attendance_time.break_in, '%H:%i' ) ) ), '%H:%i' ) AS total_break 
		FROM
			xin_attendance_time
			JOIN xin_employees ON xin_employees.user_id = xin_attendance_time.employee_id
			JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
			JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
			JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id 
		WHERE
			xin_employees.company_id = $company_id 
			AND xin_attendance_time.attendance_date BETWEEN '$startdate' 
			AND '$enddate' 
		GROUP BY
			xin_attendance_time.attendance_date,
			xin_attendance_time.employee_id");
	}


	public function list_absen_department($department_id, $startdate, $enddate)
	{
		return $this->db->query("SELECT
			xin_employees.company_id,
			xin_attendance_time.employee_id,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS username,
			xin_designations.designation_name,
			xin_attendance_time.attendance_date,
			substr( xin_attendance_time.clock_in, 12, 5 ) AS clock_in,
			substr( xin_attendance_time.clock_out, 12, 5 ) AS clock_out,
			xin_attendance_time.total_work,
				-- TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), '08:00:00' ) AS late
				CASE
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Mon' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.monday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Tue' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.tuesday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Wed' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.wednesday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Thu' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.thursday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Fri' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.friday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Sat' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.saturday_in_time, ':00' ) ) 
				WHEN DATE_FORMAT( xin_attendance_time.attendance_date, '%a' ) = 'Sun' THEN
				TIMEDIFF( substr( xin_attendance_time.clock_in, 12, 8 ), CONCAT( xin_office_shift.sunday_in_time, ':00' ) ) 
				END AS late 
				FROM
				xin_attendance_time
				JOIN xin_employees ON xin_employees.user_id = xin_attendance_time.employee_id
				JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id 
				JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id 
				WHERE
				xin_employees.department_id = $department_id 
				AND xin_attendance_time.attendance_date BETWEEN '$startdate' 
				AND '$enddate' 
				GROUP BY
				xin_attendance_time.attendance_date,
				xin_attendance_time.employee_id");
	}
}
