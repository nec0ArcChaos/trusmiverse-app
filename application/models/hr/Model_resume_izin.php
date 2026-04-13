<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_resume_izin extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
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

    public function get_resume_izin($company_id, $department_id, $employee_id, $start, $end)
    {
        $company        = ($company_id == 0) ? "" : "AND applied.company_id = $company_id" ;
        $department     = ($department_id == 0) ? "" : "AND applied.department_id = $department_id" ;
        $employee       = ($employee_id == 0) ? "" : "AND applied.user_id = $employee_id" ;

        $query = "SELECT
            xin_leave_applications.leave_id,
            xin_leave_type.type_name AS leave_type,
            xin_leave_applications.reason,
            xin_leave_applications.remarks,
            CASE
                WHEN xin_leave_applications.`status` = 1 THEN
                'Pending' 
                WHEN xin_leave_applications.`status` = 2 THEN
                'Approve' 
                WHEN xin_leave_applications.`status` = 3 THEN
                'Reject' 
            END AS `status`,
            xin_leave_applications.leave_attachment AS attachment,
            CONCAT( applied.first_name, ' ', applied.last_name ) AS employee,
            xin_departments.department_name AS department,
            xin_companies.`name` AS company,
            CONCAT( xin_leave_applications.from_date, ' to ', xin_leave_applications.to_date ) AS request_duration,
            DATEDIFF( xin_leave_applications.to_date, xin_leave_applications.from_date - INTERVAL 1 DAY ) AS total,
            DATE( xin_leave_applications.created_at ) AS applied_on,
            xin_leave_applications.approved_at,
            CONCAT( approved.first_name, ' ', approved.last_name ) AS approved,
            xin_leave_applications.verified_at,
            CONCAT( verified.first_name, ' ', verified.last_name ) AS verified 
        FROM
            xin_leave_applications
            JOIN xin_leave_type ON xin_leave_applications.leave_type_id = xin_leave_type.leave_type_id
            JOIN xin_employees AS applied ON xin_leave_applications.employee_id = applied.user_id
            JOIN xin_companies ON applied.company_id = xin_companies.company_id
            JOIN xin_departments ON applied.department_id = xin_departments.department_id
            LEFT JOIN xin_employees AS approved ON xin_leave_applications.approved_by = approved.user_id
            LEFT JOIN xin_employees AS verified ON xin_leave_applications.verified_by = verified.user_id 
        WHERE
            xin_leave_applications.leave_attachment != '' 
            AND xin_leave_applications.from_date BETWEEN '$start' 
            AND '$end'
            $company
            $department
            $employee";

        return $this->db->query($query);
    }
}
