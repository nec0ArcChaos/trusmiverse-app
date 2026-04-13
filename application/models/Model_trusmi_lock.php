<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_lock extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_lock_absen($start, $end)
  {
    $id_user = $this->session->userdata('user_id');
    if (in_array($id_user, array(1, 323, 78, 1139, 321, 2735, 2307, 4138, 3613, 3820, 4770, 2951, 5197, 2378, 5684, 2729, 70, 1784, 778, 979, 3648, 6486, 6127, 5121, 5534, 4770, 6717, 6806, 4954, 3651, 2505, 4498, 8892, 8970, 8140))) {
      $kondisi = "";
    } else {
      $kondisi = "AND (locked.employee_id = '$id_user' OR usr.id_user = '$id_user')";
    }
    return $this->db->query("SELECT @no:=@no+1 nomor, 
                                  locked.id,
                                  locked.employee_id,
                                  CONCAT(emp.first_name,' ',emp.last_name) as employee_name,
                                  locked.type_lock,
                                  locked.alasan_lock,
                                  locked.`status`,
                                  locked.created_at as locked_at,
                                  usr.id_user as id_user_locked,
                                  usr.employee_name as locked_by,
                                  locked.activity,
                                  locked.updated_at as unlocked_at
                                FROM
                                 hris.trusmi_lock_absen_manual AS locked
                                  JOIN hris.xin_employees AS emp ON emp.user_id = locked.employee_id
                                  JOIN hris.`user` as usr ON usr.id_user = locked.created_by,
                                  (SELECT @no:= 0) AS no
                                WHERE
                                  DATE( locked.created_at ) BETWEEN '$start' 
                                  AND '$end' $kondisi")->result();
  }

  function get_employee()
  {
    $id_hr = $_SESSION['user_id'];
    if (in_array($id_hr, array(340, 272, 4303))) {
      // Jika Manager Marketing yang ingin Lock
      if ($id_hr == 340) {
        $new_kondisi = "AND mm.join_hr in (340, 272, 4303)";
      } else {
        $new_kondisi = "AND mm.join_hr = $id_hr";
      }
      $query = "SELECT
                  below.id_user AS id_rsp,
                  below.join_hr AS user_id,
                  below.employee_name,
                  mm.employee_name as mm,
                  c.`name` AS company,
                  d.department_name AS department,
                  dg.designation_name AS designation
                FROM
                  rsp_project_live.`user` AS mm
                  JOIN rsp_project_live.`user` AS below ON (below.id_manager = mm.id_user OR below.id_gm = mm.id_user)
                  JOIN xin_employees emp ON emp.user_id = below.join_hr
                  JOIN xin_companies c ON c.company_id = emp.company_id
                  JOIN xin_departments d ON d.department_id = emp.department_id
                  JOIN xin_designations dg ON dg.designation_id = emp.designation_id
                WHERE
                  -- (mm.id_user = mm.id_manager OR mm.id_user = mm.id_gm) 
                  -- AND
                  mm.id_divisi = 2
                  AND mm.isActive = 1
                  AND (below.id_user <> below.id_manager OR below.id_user <> below.id_gm)
                  AND below.isActive = 1
                  AND below.id_divisi IN (2,20)
                  AND below.join_hr IS NOT NULL
                  $new_kondisi";
    } else if ($id_hr == 5286 || $id_hr == 7804) { // Farid PDCA & Nilsen
      // Muncul Hanya Markom
      $query = "SELECT
                  emp.`user_id`,
                  CONCAT( emp.first_name, ' ', emp.last_name ) AS employee_name,
                  c.`name` AS company,
                  d.department_name AS department,
                  dg.designation_name AS designation
                FROM
                  hris.xin_employees emp
                  JOIN xin_companies c ON c.company_id = emp.company_id
                  JOIN xin_departments d ON d.department_id = emp.department_id
                  JOIN xin_designations dg ON dg.designation_id = emp.designation_id
                WHERE
                  emp.is_active = 1 
                  AND emp.`user_id` <> 1
                  AND emp.department_id IN (137,233)";
    } else {
      // Muncul Semua
      $query = "SELECT
                  emp.`user_id`,
                  CONCAT( emp.first_name, ' ', emp.last_name ) AS employee_name,
                  c.`name` AS company,
                  d.department_name AS department,
                  dg.designation_name AS designation
                FROM
                  hris.xin_employees emp
                  JOIN xin_companies c ON c.company_id = emp.company_id
                  JOIN xin_departments d ON d.department_id = emp.department_id
                  JOIN xin_designations dg ON dg.designation_id = emp.designation_id
                WHERE
                  emp.is_active = 1 
                  AND emp.`user_id` <> 1";
    }
    return $this->db->query($query)->result();
  }

  function get_data_msg($lock_at, $lock_by)
  {
    $query = "SELECT
                MAX(name_lock_at) as name_lock_at,
                MAX(name_lock_by) as name_lock_by, 
                MAX(contact_lock_by) as contact_lock_by, 
                MAX(contact_lock_at) as contact_lock_at, 
                MAX(department_lock_by) as department_lock_by 
              FROM
                (
                SELECT
                  't_lock_notif' AS `group`,
                CASE
                    xe.user_id 
                    WHEN $lock_at THEN
                    CONCAT( xe.first_name, ' ', xe.last_name ) ELSE '' 
                  END AS name_lock_at,
                CASE
                    xe.user_id 
                    WHEN $lock_by THEN
                    CONCAT( xe.first_name, ' ', xe.last_name ) ELSE '' 
                  END AS name_lock_by,
                CASE
                    xe.user_id 
                    WHEN $lock_at THEN
                  IF
                    (
                      LEFT ( xe.contact_no, 2 ) = '08',
                      CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 2 ) ),
                      CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 3 ) ) 
                    ) ELSE '' 
                  END AS contact_lock_at,
                CASE
                    xe.user_id 
                    WHEN $lock_by THEN
                  IF
                    (
                      LEFT ( xe.contact_no, 2 ) = '08',
                      CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 2 ) ),
                      CONCAT( '628', RIGHT ( xe.contact_no, LENGTH( xe.contact_no ) - 3 ) ) 
                    ) ELSE '' 
                  END AS contact_lock_by,
                CASE
                    xe.user_id 
                    WHEN $lock_by THEN
                    xd.department_name ELSE '' 
                  END AS department_lock_by 
                FROM
                  xin_employees xe
                  LEFT JOIN xin_departments xd ON xd.department_id = xe.department_id 
              WHERE
                xe.user_id IN ( $lock_at, $lock_by )) t_lock
                GROUP BY `group`";
    return $this->db->query($query)->row_array();
  }
}
