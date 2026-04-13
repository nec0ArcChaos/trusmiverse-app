<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_denda_ade extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_dt_denda($periode)
  {
    $id_user = $this->session->userdata('user_id');
    if (in_array($id_user, array(1,78,1161))) {
      $kondisi = "";
    } else {
      $kondisi = "AND (denda.employee_id = '$id_user' OR usr.id_user = '$id_user')";
    }
    return $this->db->query("SELECT 
                                  denda.id,
                                  denda.employee_id,
                                  CONCAT(emp.first_name,' ',emp.last_name) as employee_name,
                                  denda.nominal,
                                  denda.keterangan,
                                  denda.created_at as denda_at,
                                  denda.periode,
                                  usr.id_user as id_user_denda,
                                  usr.employee_name as denda_by,
                                  xin_companies.`name` AS company_name,
																	xin_departments.department_name,
																	xin_designations.designation_name,
                                  coalesce(denda.id_rekomendasi,0) AS id_rekomendasi
                                FROM
                                 hris.trusmi_denda AS denda
                                  JOIN hris.xin_employees AS emp ON emp.user_id = denda.employee_id
                                  LEFT JOIN xin_companies ON xin_companies.company_id = emp.company_id
                                  LEFT JOIN xin_departments ON xin_departments.department_id = emp.department_id
                                  LEFT JOIN xin_designations ON xin_designations.designation_id = emp.designation_id
                                  JOIN hris.`user` as usr ON usr.id_user = denda.created_by
                                  WHERE
                                  denda.periode = '$periode' $kondisi")->result();
  }

  function get_employee()
  {
    $id_hr = $_SESSION['user_id'];
    // if (in_array($id_hr, array(340, 272, 4303))) {
     
      // Muncul Semua
      $query = "SELECT
                  `user_id`,
                  CONCAT( first_name, ' ', last_name ) AS employee_name,
                  CONCAT(xin_companies.`name`, ' | ', xin_departments.department_name) department_name,
									xin_designations.designation_name
                FROM
                  hris.xin_employees 
                  LEFT JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id
									LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
									LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
                WHERE
                  xin_employees.is_active = 1 
                  AND `user_id` <> 1";
    // }
    return $this->db->query($query)->result();
  }

  // addnew
  function dt_rekomendasi_denda($periode, $company, $department)
	{
		if ($department != null) {
			$sub_query = "WHERE periode = '$periode' AND company_id = '$company' AND department_id = $department";
		} else if ($company != null) {
			$sub_query = "WHERE periode = '$periode' AND company_id = '$company'";
		} else {
			$sub_query = "WHERE periode = '$periode'";
		}
		$query = "SELECT 
      denda.id,
      denda.status,
      denda.user_id,
      denda.karyawan,
      denda.company,
      denda.department,
      denda.designation,
      denda.company_id,
      denda.department_id,
      denda.designation_id,
      denda.head_id,
      denda.created_at,
      denda.date_of_joining,
      denda.masa_kerja,
      denda.periode,
      denda.tipe,
      denda.note,
      CASE 
          WHEN emp.profile_picture = '' 
          THEN 
              CONCAT(
                  'https://trusmiverse.com/hr/uploads/profile/', 
                  IF(emp.gender = 'Male', 'default_male.jpg', 'default_female.jpg')
              ) 
          ELSE CONCAT('https://trusmiverse.com/hr/uploads/profile/', emp.profile_picture) 
      END AS profil
  FROM 
      trusmi_rekomen_denda AS denda
  JOIN 
      xin_employees AS emp 
      ON emp.user_id = denda.user_id $sub_query AND denda.status = '0'";
		return $this->db->query($query)->result();
	}
}
