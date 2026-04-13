<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_resume_resignation extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function dashboard_1($start = null, $end = null, $company_id = null)
    {
        if ($start === null) {
            $start = date("Y-m-01");
        }
        if ($end === null) {
            $end = date("Y-m-t");
        }
        if ($company_id != null) {
            $kondisi = "AND empris.company_id = '$company_id'";
        } else {
            $kondisi = "";
        }
        return $this->db->query("SELECT 
	(CASE 
        WHEN timestampdiff(MONTH,`emp`.`date_of_joining`,CURDATE()) < 3 THEN 1
        WHEN timestampdiff(MONTH,`emp`.`date_of_joining`,CURDATE()) = 3 THEN 2
        WHEN timestampdiff(MONTH,`emp`.`date_of_joining`,CURDATE()) > 3 THEN 3
    END) AS masa_kerja,
	empris.company_id,
	comp.`name` AS company_name,
	depa.department_id,
	depa.department_name,
	COUNT(empris.resignation_id) AS mp
FROM
	xin_employee_resignations empris
LEFT JOIN xin_employees emp ON emp.user_id = empris.employee_id
LEFT JOIN xin_companies comp ON comp.company_id = empris.company_id
LEFT JOIN xin_departments depa ON depa.company_id = emp.company_id AND depa.department_id = emp.department_id
LEFT JOIN trusmi_resign_category_new cate ON cate.category = empris.category
LEFT JOIN trusmi_resign_reason_new reas ON reas.reason = empris.reason
WHERE
	empris.resignation_date BETWEEN '$start' AND '$end' $kondisi
GROUP BY masa_kerja, department_id, company_id
ORDER BY 
	empris.company_id DESC, depa.department_id DESC, masa_kerja DESC")->result_array();
    }

    public function dashboard_2($start = null, $end = null, $company_id = null)
    {
        if ($start === null) {
            $start = date("Y-m-01");
        }
        if ($end === null) {
            $end = date("Y-m-t");
        }
        if ($company_id != null) {
            $kondisi = "AND empris.company_id = '$company_id'";
        } else {
            $kondisi = "";
        }
        return $this->db->query("SELECT 
	CONCAT(depa.department_name, ' - ', comp.`name`) AS department,
	SUM(if(empris.category = 'Diputus Kontrak' AND empris.reason = 'Diputus Kontrak', 1, 0)) AS diputus_perusahaan,
	SUM(if(empris.category = 'Habis Kontrak' AND empris.reason = 'Perusahaan', 1, 0)) AS habis_perusahaan,
	SUM(if(empris.category = 'Habis Kontrak' AND empris.reason = 'Pribadi', 1, 0)) AS habis_pribadi,
	SUM(if(empris.category = 'Resign', 1, 0)) AS resign
FROM
	xin_employee_resignations empris
LEFT JOIN xin_employees emp ON emp.user_id = empris.employee_id
LEFT JOIN xin_companies comp ON comp.company_id = empris.company_id
LEFT JOIN xin_departments depa ON depa.company_id = emp.company_id AND depa.department_id = emp.department_id
WHERE
	empris.resignation_date BETWEEN '$start' AND '$end' $kondisi
GROUP BY
	department
ORDER BY 
	department DESC")->result();
    }

    public function dashboard_3($start = null, $end = null, $company_id = null)
    {
        if ($start === null) {
            $start = date("Y-m-01");
        }
        if ($end === null) {
            $end = date("Y-m-t");
        }
        if ($company_id != null) {
            $kondisi = "AND empris.company_id = '$company_id'";
        } else {
            $kondisi = "";
        }
        return $this->db->query("SELECT 
	SUM(if(empris.category = 'Diputus Kontrak' AND empris.reason = 'Diputus Kontrak', 1, 0)) AS diputus_perusahaan,
	SUM(if(empris.category = 'Habis Kontrak' AND empris.reason = 'Perusahaan', 1, 0)) AS habis_perusahaan,
	SUM(if(empris.category = 'Habis Kontrak' AND empris.reason = 'Pribadi', 1, 0)) AS habis_pribadi,
	SUM(if(empris.category = 'Resign', 1, 0)) AS resign
FROM
	xin_employee_resignations empris
LEFT JOIN xin_employees emp ON emp.user_id = empris.employee_id
LEFT JOIN xin_companies comp ON comp.company_id = empris.company_id
LEFT JOIN xin_departments depa ON depa.company_id = emp.company_id AND depa.department_id = emp.department_id
WHERE
	empris.resignation_date BETWEEN '$start' AND '$end' $kondisi")->row();
    }

    public function dashboard_4($start = null, $end = null, $company_id = null)
    {
        if ($start === null) {
            $start = date("Y-m-01");
        }
        if ($end === null) {
            $end = date("Y-m-t");
        }
        if ($company_id != null) {
            $kondisi = "AND empris.company_id = '$company_id'";
        } else {
            $kondisi = "";
        }
        return $this->db->query("SELECT 
	cate.id_category,
	empris.category,
	empris.reason,
	COUNT(empris.resignation_id) AS mp
FROM
	xin_employee_resignations empris
LEFT JOIN xin_employees emp ON emp.user_id = empris.employee_id
LEFT JOIN xin_companies comp ON comp.company_id = empris.company_id
LEFT JOIN xin_departments depa ON depa.company_id = emp.company_id AND depa.department_id = emp.department_id
LEFT JOIN trusmi_resign_category_new cate ON cate.category = empris.category
LEFT JOIN trusmi_resign_reason_new reas ON reas.reason = empris.reason
WHERE
	empris.resignation_date BETWEEN '$start' AND '$end' AND empris.reason != '' $kondisi
GROUP BY reason")->result();
    }

}
