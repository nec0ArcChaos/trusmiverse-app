<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_push_notification_TrusmiOntime extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function getToken($user_id)
  {
    return $this->db->query("SELECT * FROM trusmi_ontime_notif_token_device WHERE user_id = $user_id")->row_array();
  }

  // function generate_id_problem_solving()
  // {
  //   $q = $this->db->query("SELECT 
  //                               MAX( RIGHT ( id_ps, 4 ) ) AS kd_max 
  //                             FROM
  //                               ps_task 
  //                             WHERE
  //                               DATE( created_at ) = CURDATE()");
  //   $kd = "";
  //   if ($q->num_rows() > 0) {
  //     foreach ($q->result() as $k) {
  //       $tmp = ((int)$k->kd_max) + 1;
  //       $kd = sprintf("%04s", $tmp);
  //     }
  //   } else {
  //     $kd = "0001";
  //   }

  //   return 'PS' . date('ymd') . $kd;
  // }

  // function get_master($tipe)
  // {
  //   if ($tipe == "category") {
  //     $kondisi = "WHERE category IS NOT NULL";
  //   } else if ($tipe == "priority") {
  //     $kondisi = "WHERE priority IS NOT NULL";
  //   } else if ($tipe == "status") {
  //     $kondisi = "WHERE `status` IS NOT NULL AND id <> 1";
  //   }
  //   return $this->db->query("SELECT * FROM ps_m_category $kondisi")->result();
  // }

  function get_employee()
  {
    return $this->db->query("SELECT
                              em.user_id,
                              CONCAT(em.first_name,' ',em.last_name,' | ',dep.department_name, ' - ', com.kode) AS employee_name
                            FROM
                              xin_employees AS em
                              JOIN xin_companies AS com ON com.company_id = em.company_id
                              JOIN xin_departments AS dep ON dep.department_id = em.department_id
                            WHERE
                              em.is_active = 1 
                              AND em.user_role_id NOT IN ( 7, 8 ) 
                              AND em.user_id <> 1")->result();
  }
  
  // function list_problem($start,$end)
  // {
  //   $user_id        = $_SESSION['user_id'];
  //   $role_id        = $_SESSION['user_role_id'];
  //   $company_id     = $_SESSION['company_id'];
  //   $department_id  = $_SESSION['department_id'];
  //   $designation_id = $_SESSION['designation_id'];

  //   $list_super       = [5286];   // farid3241
  //   // $list_department  = [117,1,72,73,156,157,167];
  //   // $list_designation = [1217,1218]; // HRBP Manager, Officer
    
  //   if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
  //     $kondisi = "";
  //   } else {
  //     $kondisi = "AND tsk.department_id = $department_id";
  //   }

  //   return $this->db->query("SELECT
  //                             tsk.id_ps,
  //                             tsk.problem,
  //                             tsk.category_id,
  //                             ct.category,
  //                             tsk.priority_id,
  //                             pt.priority,
  //                             DATE_FORMAT(tsk.deadline,'%d %b %Y') AS deadline,
  //                             tsk.`status` AS status_id,
  //                             sts.`status`,
  //                             tsk.resume,
  //                             tsk.created_at,
  //                             CONCAT(em.first_name,' ',em.last_name) AS created_by,
  //                             tsk.factor,
  //                             CONCAT(pc.first_name,' ',pc.last_name) AS pic
  //                           FROM
  //                             ps_task AS tsk
  //                             JOIN xin_employees AS em ON em.user_id = tsk.created_by
  //                             LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic
  //                             JOIN ps_m_category AS ct ON ct.id = tsk.category_id
  //                             JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
  //                             JOIN ps_m_category AS sts ON sts.id = tsk.`status`
  //                           WHERE
  //                             DATE ( tsk.created_at ) BETWEEN '$start'
  //                             AND '$end' $kondisi")->result();
  // }

  // function get_detail_user($user_id)
  // {
  //   return $this->db->query("SELECT
  //                             user_id,
  //                             company_id,
  //                             department_id,
  //                             designation_id,
  //                             user_role_id AS role_id 
  //                           FROM
  //                             xin_employees 
  //                           WHERE
  //                             user_id = $user_id")->row_array();
  // }

  // function get_detail_problem($id)
  // {
  //   return $this->db->query("SELECT
  //                             tsk.id_ps,
  //                             tsk.problem,
  //                             tsk.category_id,
  //                             ct.category,
  //                             tsk.priority_id,
  //                             pt.priority,
  //                             DATE_FORMAT(tsk.deadline,'%d %M %Y') AS deadline,
  //                             tsk.`status` AS status_id,
  //                             sts.`status`,
  //                             tsk.resume,
  //                             tsk.created_at,
  //                             CONCAT(em.first_name,' ',em.last_name) AS created_by,
  //                             tsk.factor,
  //                             CONCAT(pc.first_name,' ',pc.last_name) AS pic
  //                           FROM
  //                             ps_task AS tsk
  //                             JOIN xin_employees AS em ON em.user_id = tsk.created_by
  //                             LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic
  //                             JOIN ps_m_category AS ct ON ct.id = tsk.category_id
  //                             JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
  //                             JOIN ps_m_category AS sts ON sts.id = tsk.`status`
  //                           WHERE
  //                             tsk.id_ps = '$id'")->row_array();
  // }

  function list_push_notification($start,$end)
  {
    return $this->db->query("SELECT
                              notif.id,
                              notif.judul,
                              notif.pesan,
                              GROUP_CONCAT(CONCAT(em.first_name,' ',em.last_name)) AS karyawan,
                              notif.created_at,
                              CONCAT(cby.first_name,' ',cby.last_name) AS created_by
                            FROM
                              trusmi_ontime_notif_push AS notif
                              JOIN xin_employees AS em ON FIND_IN_SET(em.user_id,notif.user_id)
                              JOIN xin_employees AS cby ON cby.user_id = notif.created_by
                            WHERE
                              DATE(notif.created_at) BETWEEN '$start' AND '$end'
                            GROUP BY
                              notif.id")->result();
  }

} // End of class
