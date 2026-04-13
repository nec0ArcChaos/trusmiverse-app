<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_promotion extends CI_Model
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

    public function get_designation($company_id)
    {
        $query = "SELECT
            0 AS `id`,
            0 AS `value`,
            'Choose...' AS `text` UNION
        SELECT
            xin_designations.designation_id AS id,
            CONCAT(xin_departments.department_id, '-', xin_departments.location_id, '-', xin_designations.designation_id) AS `value`,
            xin_designations.designation_name AS `text` 
        FROM
            xin_designations 
            JOIN xin_departments ON xin_designations.department_id = xin_departments.department_id
        WHERE
            xin_designations.company_id = $company_id";

        return $this->db->query($query);
    }
    public function get_designation_by_dep($dep_id)
    {
        $query = "SELECT
            0 AS `id`,
            0 AS `value`,
            'Choose...' AS `text` UNION
        SELECT
            xin_designations.designation_id AS id,
            CONCAT(xin_departments.department_id, '-', xin_departments.location_id, '-', xin_designations.designation_id) AS `value`,
            xin_designations.designation_name AS `text` 
        FROM
            xin_designations 
            JOIN xin_departments ON xin_designations.department_id = xin_departments.department_id
        WHERE
            xin_designations.department_id = '$dep_id'";

        return $this->db->query($query);
    }

    public function get_employees($company_id)
    {
        $query = "SELECT
            0 AS `value`,
            'Choose...' AS `text` UNION
        SELECT
            CONCAT(xin_employees.user_id, '-', xin_employees.department_id, '-', xin_employees.designation_id) AS `value`,
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `text` 
        FROM
            xin_employees 
        WHERE
            xin_employees.company_id = $company_id 
            AND xin_employees.is_active = 1";

        return $this->db->query($query);
    }

    public function get_manager($user_id)
    {
        $query = "SELECT
            xin_employees.first_name,
            xin_employees.last_name,
            xin_designations.designation_name 
        FROM
            xin_employees
            JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id 
        WHERE
            xin_employees.user_id = $user_id";

        return $this->db->query($query);
    }
    public function get_location(){
        $query = "SELECT * FROM xin_office_location";
        return $this->db->query($query)->result();
    }

    public function get_promotion_list($company_id, $department_id, $start, $end)
    {
        $user_id    = $this->session->userdata('user_id');
        $user_it    = array(1, 61, 62, 323, 979, 63, 64, 778, 1161, 2041, 2063, 2969, 2969, 2070, 2903, 321, 6486);
        $level      = array(1, 2, 3, 4, 5, 10);
        if (in_array($user_id, $user_it)) {
            $company    = ($company_id == 0) ? "" : "AND xin_employee_promotions.company_id = $company_id";
            $department = ($department_id == 0) ? "" : "AND xin_employee_promotions.department_id = $department_id";
            $by         = "";
        } else {
            $company    = "";
            $department = "";
            $by         = "AND xin_employee_promotions.added_by = $user_id";
        }

        $query = "SELECT
            xin_employee_promotions.promotion_id,
            REPLACE ( REPLACE ( xin_employees.employee_id, ',', '' ), '.', '' ) AS employee_id,
            xin_employees.contact_no AS no_kontak,
            CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee,
            xin_employee_promotions.description,
            xin_companies.`name` AS company,
            xin_departments.department_name AS department,
            xin_designations.designation_name AS designation,
            last_dep.department_name AS last_department,
            last_des.designation_name AS last_designation,
            CASE
                WHEN xin_employee_promotions.`status` = 1 THEN 'Approve'
                WHEN xin_employee_promotions.`status` = 2 THEN 'Reject'
                ELSE 'Waiting'
            END AS `status`,
            xin_employee_promotions.type AS id_type,
            CASE
                WHEN xin_employee_promotions.type = 1 THEN
                'Promosi' 
                WHEN xin_employee_promotions.type = 2 THEN
                'Demosi' 
                WHEN xin_employee_promotions.type = 3 THEN
                'Rotasi' 
                WHEN xin_employee_promotions.type = 4 THEN
                'Mutasi' 
                WHEN xin_employee_promotions.type = 5 THEN
                'Assignment' ELSE '' 
            END AS type,
            xin_employee_promotions.title,
            CONCAT(
                CASE
                    WHEN xin_employee_promotions.type = 1 THEN
                    'Promosi' 
                    WHEN xin_employee_promotions.type = 2 THEN
                    'Demosi' 
                    WHEN xin_employee_promotions.type = 3 THEN
                    'Rotasi' 
                    WHEN xin_employee_promotions.type = 4 THEN
                    'Mutasi' 
                    WHEN xin_employee_promotions.type = 5 THEN
                    'Assignment' ELSE '' 
                END,
                ' ke ',
                xin_designations.designation_name 
            ) AS `to`,
            CONCAT( added.first_name, ' ', added.last_name ) AS added_by,
            xin_employee_promotions.promotion_date AS `date`,
            CONCAT( approved.first_name, ' ', approved.last_name ) AS approved_by,
            xin_employee_promotions.approve_at,
            xin_employee_promotions.employee_id AS user_id,
            xin_employee_promotions.company_id,
            xin_employee_promotions.department_id,
            xin_employee_promotions.designation_id,
            xin_employee_promotions.location_id,
            xin_employee_promotions.last_target,
            xin_employee_promotions.target,
            xin_employee_promotions.created_at
        FROM
            xin_employee_promotions
            JOIN xin_employees ON xin_employee_promotions.employee_id = xin_employees.user_id
            JOIN xin_companies ON xin_employee_promotions.company_id = xin_companies.company_id
            JOIN xin_departments ON xin_employee_promotions.department_id = xin_departments.department_id
            JOIN xin_designations ON xin_employee_promotions.designation_id = xin_designations.designation_id
            JOIN xin_departments AS last_dep ON xin_employee_promotions.last_department_id = last_dep.department_id
            JOIN xin_designations AS last_des ON xin_employee_promotions.last_designation_id = last_des.designation_id
            JOIN xin_employees AS added ON xin_employee_promotions.added_by = added.user_id
            LEFT JOIN xin_employees AS approved ON xin_employee_promotions.approve_by = approved.user_id
        WHERE
            xin_employee_promotions.promotion_date BETWEEN '$start' AND '$end'
            $company
            $department
            $by";

        return $this->db->query($query);
    }

    function get_roles()
    {
        $query = "SELECT xin_user_roles.role_id, xin_user_roles.role_name FROM xin_user_roles WHERE role_id <> 1";

        return $this->db->query($query);
    }
}
