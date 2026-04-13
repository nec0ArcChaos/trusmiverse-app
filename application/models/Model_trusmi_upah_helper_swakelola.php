<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_upah_helper_swakelola extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_employee()
  {
      $query = "SELECT
  xin_employees.user_id,
  CONCAT(xin_employees.first_name,' ' ,xin_employees.last_name) as `name`,
  xin_companies.`name` as company_name,
  xin_departments.department_name,
  xin_employees.designation_id,
  xin_designations.designation_name,
  xin_employees.is_active,
  COALESCE(trusmi_upah_helper_swakelola.upah,0) as upah,
  trusmi_upah_helper_swakelola.created_at,
  CONCAT(crt.first_name,' ' ,crt.last_name) as created_by,
  trusmi_upah_helper_swakelola.updated_at,
  CONCAT(updt.first_name,' ' ,updt.last_name) as updated_by
FROM
  xin_employees
LEFT JOIN trusmi_upah_helper_swakelola ON trusmi_upah_helper_swakelola.user_id = xin_employees.user_id
LEFT JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id
LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
LEFT JOIN xin_employees crt ON crt.user_id = trusmi_upah_helper_swakelola.created_by
LEFT JOIN xin_employees updt ON updt.user_id = trusmi_upah_helper_swakelola.updated_by
WHERE
  xin_employees.company_id = 2
  AND xin_employees.department_id in (161,245)
  AND xin_employees.designation_id in (1906,1883,1720)
  AND xin_employees.is_active = 1";

    return $this->db->query($query)->result();
  }

  function get_log($user_id)
  {
      $query = "SELECT
  xin_employees.user_id,
  CONCAT(xin_employees.first_name,' ' ,xin_employees.last_name) as `name`,
  xin_companies.`name` as company_name,
  xin_departments.department_name,
  xin_employees.designation_id,
  xin_designations.designation_name,
  xin_employees.is_active,
  COALESCE(trusmi_upah_helper_swakelola_log.upah,0) as upah,
  trusmi_upah_helper_swakelola_log.created_at,
  CONCAT(crt.first_name,' ' ,crt.last_name) as created_by
FROM
  xin_employees
LEFT JOIN trusmi_upah_helper_swakelola_log ON trusmi_upah_helper_swakelola_log.user_id = xin_employees.user_id
LEFT JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id
LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
LEFT JOIN xin_employees crt ON crt.user_id = trusmi_upah_helper_swakelola_log.created_by
WHERE
  trusmi_upah_helper_swakelola_log.user_id = '$user_id'";

    return $this->db->query($query)->result();
  }
  
}
