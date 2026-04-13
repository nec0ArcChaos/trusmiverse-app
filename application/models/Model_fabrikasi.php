<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_fabrikasi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getHelper()
    {
        $query = "SELECT
	CONCAT( E.first_name, ' ', E.last_name ) AS nama,E.user_id, C.`name` AS company_name, D.department_name , DS.designation_name
FROM
	`xin_employees` E 
	LEFT JOIN xin_companies C ON C.company_id = E.company_id
	LEFT JOIN xin_departments D ON D.department_id = E.department_id
	LEFT JOIN xin_designations DS ON DS.designation_id = E.designation_id
WHERE
	E.department_id = 205 
	AND E.designation_id = 1553 
	AND E.is_active = 1";

        return $this->db->query($query)->result();
    }

    public function getDataUpah()
    {
        $query = "SELECT
        CONCAT( E.first_name, ' ', E.last_name ) AS nama,E.user_id, C.`name` AS company_name, D.department_name , DS.designation_name, U.nominal,U.lembur
    FROM
        `xin_employees` E 
        LEFT JOIN xin_companies C ON C.company_id = E.company_id
        LEFT JOIN xin_departments D ON D.department_id = E.department_id
        LEFT JOIN xin_designations DS ON DS.designation_id = E.designation_id
        JOIN trusmi_upah_helper U ON E.user_id = U.employee_id
    WHERE
        E.department_id = 205 
        AND E.designation_id = 1553 
        AND E.is_active = 1";

        return $this->db->query($query)->result();
    }
}
