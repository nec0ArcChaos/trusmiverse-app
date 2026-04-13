<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_manage_leave extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_lock_absen($start, $end)
  {
      $id_user = $this->session->userdata('user_id');
      if (in_array($id_user, array(1,323,78,1139,321,2735,2307))) {
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
    if (in_array($id_hr,array(340,272,4303))) {
      // Jika Manager Marketing yang ingin Lock
      $query = "SELECT
                  below.id_user AS id_rsp,
                  below.id_hr AS user_id,
                  below.employee_name,
                  mm.employee_name as mm
                FROM
                  rsp_project_live.`user` AS mm
                  JOIN rsp_project_live.`user` AS below ON below.id_manager = mm.id_user
                WHERE
                  mm.id_user = mm.id_manager 
                  AND mm.id_divisi = 2 
                  AND mm.isActive = 1
                  AND below.id_user <> below.id_manager
                  AND below.isActive = 1
                  AND below.id_divisi = 2
                  AND below.id_hr IS NOT NULL
                  AND mm.id_hr = $id_hr";
    } else {
      // Muncul Semua
      $query = "SELECT
                  `user_id`,
                  CONCAT( first_name, ' ', last_name ) AS employee_name
                FROM
                  hris.xin_employees 
                WHERE
                  is_active = 1 
                  AND `user_id` <> 1";
    }
    return $this->db->query($query)->result();
  }
}
