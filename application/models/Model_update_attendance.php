<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_update_attendance extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function dt_attendance($date, $id)
    {
        $query = "SELECT
                    time_attendance_id,
                    employee_id,
                    attendance_date,
                    clock_in,
                    COALESCE(clock_out,'-') AS clock_out,
                    COALESCE(total_work,'-') AS total_work
                    FROM
                    xin_attendance_time
                    WHERE
                    employee_id = $id
                    AND attendance_date = '$date'
                    ORDER BY
                    time_attendance_id";

        return $this->db->query($query)->result();
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
                    xin_employees.user_id AS `value`,
                    CONCAT(xin_employees.first_name, ' ', xin_employees.last_name) AS `text`
                    FROM
                    xin_employees
                    WHERE
                    xin_employees.company_id = $company_id
                    AND xin_employees.department_id = $department_id
                    AND xin_employees.is_active = 1";

        return $this->db->query($query);
    }
}
