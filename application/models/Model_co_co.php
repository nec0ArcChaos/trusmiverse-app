<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_co_co extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_id_coaching()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( coaching.id_coaching, 4 ) ) AS kd_max 
                              FROM
                                coaching 
                              WHERE
                                DATE( coaching.created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return 'CC' . date('ymd') . $kd;
  }

  function get_karyawan()
  {
    return $this->db->query("SELECT
                              em.user_id,
                              CONCAT( em.first_name, ' ', em.last_name,' | ',dp.department_name, ' | ', comp.`name` ) AS employee_name,
                              em.company_id,
                              comp.`name` AS company_name,
                              em.department_id,
                              dp.department_name,
                              em.designation_id,
                              em.user_role_id,
                              CASE
                                  WHEN em.company_id = 2 
                                  AND em.department_id IN ( 120, 154, 155 ) 
                                  AND em.user_role_id = 7 THEN
                                    'mkt_rsp' ELSE '' 
                                    END AS kode 
                            FROM
                              xin_employees AS em
                              LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
                              LEFT JOIN xin_companies AS comp ON comp.company_id =  em.company_id
                            WHERE
                              em.is_active = 1 
                              AND em.user_id <> 1")->result();
  }

  function get_atasan($dep_id = null)
  {
    // $kondisi = "";
    // if (isset($dep_id)) {
    //   $kondisi = "AND department_id = $dep_id";
    // }
    $department_id = $_SESSION['department_id'];

    return $this->db->query("SELECT
                              em.user_id,
                              CONCAT( em.first_name, ' ', em.last_name,' | ',dg.designation_name ) AS employee_name,
                              em.company_id,
                              em.department_id,
                              dg.designation_name,
                              em.designation_id,
                              em.user_role_id 
                            FROM
                              xin_employees as em
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = em.designation_id
                            WHERE
                              em.is_active = 1 
                              AND em.user_id <> 1 
                              AND em.user_role_id IN ( 1, 2, 3, 4, 5, 6 ,10, 11)
                              AND em.department_id = $department_id")->result();
  }

  function get_detail_user($user_id)
  {
    return $this->db->query("SELECT
                              user_id,
                              company_id,
                              department_id,
                              designation_id,
                              user_role_id AS role_id 
                            FROM
                              xin_employees 
                            WHERE
                              user_id = $user_id")->row_array();
  }

  function list_coaching($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super       = [1139, 8892, 8970, 2, 5197, 5086, 5385, 2729, 803, 3651, 2903, 10214, 4498, 10127, 7731, 10404];   // Viky, Lintang, Ali95, hience3160, alfin3333, saeroh, ibnu123, od rsp, moch5508, pujaannicha8053
    $list_department  = [117, 1, 72, 73, 156, 157, 167];
    $list_designation = [1217, 1218]; // HRBP Manager, Officer

    if ($role_id == 1 || in_array($user_id, $list_super) || $department_id == 1 || in_array($designation_id, $list_designation)) { // Super Admin, or HR Holding
      $kondisi = "";
    } else if (in_array($department_id, $list_department)) { // HR sesuai Company
      $kondisi = "AND (coaching.company_id = $company_id OR coaching.created_by = $user_id)";
      if ($user_id == 11372) { // soniyanto8949
        $kondisi = " AND (coaching.company_id = $company_id OR coaching.created_by IN (9621, 10176, 10168, $user_id))";
      }
    } else if ($role_id == 2) { // Head
      $kondisi = "AND (coaching.department_id = $department_id OR coaching.created_by = $user_id)";
    } else if ($role_id == 3) { // Manager
      $kondisi = "AND ((coaching.department_id = $department_id OR kary.ctm_report_to = $user_id) AND (coaching.role_id NOT IN (1,2,3,10) OR coaching.created_by = $user_id))";
    } else if ($role_id == 4) { // Ass Manager
      $kondisi = "AND coaching.department_id = $department_id AND (coaching.role_id NOT IN (1,2,3,4,10) OR coaching.created_by = $user_id)";
    } else if ($user_id == 3325 || $user_id == 5336 || $user_id == 5078) { // budiman1835, farouq3286, aisyah3066
      $kondisi = "AND (coaching.created_by = $user_id OR coaching.company_id = 2)";
    } else if ($user_id == 329) { // ratih
      $kondisi = "AND (coaching.created_by = $user_id OR coaching.department_id IN (25,120,154,155))";
    } else if ($user_id == 4954 || $user_id == 5121) { // rochmat dan dewana
      $kondisi = "AND (coaching.created_by = $user_id OR coaching.department_id IN (120))";
    } else if ($user_id == 70) { // nining27
      $kondisi = "AND (coaching.created_by = $user_id OR coaching.company_id IN (1,4,5))";
    } else {
      $kondisi = "AND coaching.created_by = $user_id";
    }

    // if ($user_id == 7731) { // Dimas Nurulloh
    //   $kondisi = "AND (coaching.created_by = $user_id OR coaching.department_id IN (106,142,183))";
    // }

    if ($user_id == 2735 || $user_id == 1186) { // Siti Cahyati / Idham N Dipura
      $kondisi = "AND (coaching.created_by IN ($user_id,6736,1186,2735) OR coaching.department_id IN (142,204,205,206,207,210,211))";
    }

    if ($user_id == 1369) { // abyan
      $kondisi = "AND (coaching.company_id IN (1,3,5) OR coaching.created_by = $user_id)";
    }

    return $this->db->query("SELECT
                              coaching.id_coaching,
                              CONCAT(kary.first_name,' ',kary.last_name) AS karyawan,
                              coaching.tempat,
                              DATE_FORMAT(coaching.tanggal,'%d %b %Y') AS tanggal,
                              CONCAT(atas.first_name,' ',atas.last_name) AS atasan,
                              coaching.review,
                              coaching.goals,
                              coaching.reality,
                              coaching.option,
                              coaching.will,
                              coaching.komitmen,
                              COALESCE(coaching.foto,'') AS foto,
                              coaching.company_id,
                              comp.name AS company_name,
                              coaching.department_id,
                              dp.department_name,
                              coaching.designation_id,
                              dg.designation_name,
                              coaching.role_id,
                              role.role_name,
                              coaching.created_at,
                              CONCAT(usr.first_name,' ',usr.last_name) AS created_by,
                              coaching.status,
                              COALESCE(coaching.end_session_at,'') AS end_session_at,
                              COALESCE(coaching.review_problem,'') AS review_problem,
                              COALESCE(coaching.key_takeaways,'') AS key_takeaways,
                              COALESCE(coaching.main_issue_highlight,'') AS main_issue_highlight,
                              COALESCE(coaching.percentage_burnout,'') AS percentage_burnout,
                              COALESCE(coaching.reasoning_burnout,'') AS reasoning_burnout,
                              COALESCE(coaching.root_cause_hypothesis,'') AS root_cause_hypothesis
                            FROM
                              coaching 
                              JOIN xin_employees AS kary ON kary.user_id = coaching.karyawan
                              JOIN xin_employees AS atas ON atas.user_id = coaching.atasan
                              JOIN xin_employees AS usr ON usr.user_id = coaching.created_by
                              LEFT JOIN xin_companies AS comp ON comp.company_id = coaching.company_id
                              LEFT JOIN xin_departments AS dp ON dp.department_id = coaching.department_id
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = coaching.designation_id
                              LEFT JOIN xin_user_roles AS role ON role.role_id = coaching.role_id
                            WHERE
                              DATE( coaching.created_at ) BETWEEN '$start' 
                              AND '$end'
                              $kondisi")->result();
  }

  function get_detail_mkt_rsp($id_rsp)
  {
    return $this->db->query("SELECT
                              usr.id_user,
                              usr.employee_name,
                              usr.username,
                              usr.date_of_joining,
                              TIMESTAMPDIFF(
                                MONTH,
                                usr.date_of_joining,
                              CURDATE()) AS umur,
                              tgt.kelompok AS kategori_umur,
                              tgt.booking AS tgt_booking,
                              COALESCE(book.booking,0) AS booking,
                              tgt.akad AS tgt_akad,
                              COALESCE(akad.akad,0) AS akad,
                              usr.id_hr,
                              usr.spv AS id_spv,
                              usr.id_manager,
                              usr.id_gm 
                            FROM
                              rsp_project_live.`user` AS usr
                              JOIN rsp_project_live.m_target_usia AS tgt ON tgt.usia = (
                              CASE
                                  WHEN TIMESTAMPDIFF( MONTH, usr.date_of_joining, CURDATE() ) < 1 THEN
                                  0 
                                  WHEN TIMESTAMPDIFF( MONTH, usr.date_of_joining, CURDATE() ) < 4 THEN
                                  2 
                                  WHEN TIMESTAMPDIFF( MONTH, usr.date_of_joining, CURDATE() ) < 7 THEN
                                  5 
                                  WHEN TIMESTAMPDIFF( MONTH, usr.date_of_joining, CURDATE() ) < 13 THEN
                                  11 ELSE 12 
                                END 
                                )
                                LEFT JOIN (
                                SELECT
                                  id_user,
                                  COUNT( id_gci ) AS booking 
                                FROM
                                  rsp_project_live.t_gci 
                                WHERE
                                  id_user = $id_rsp 
                                  AND id_kategori IN ( 3, 45 ) 
                                  AND DATE( created_at ) BETWEEN DATE_FORMAT( CURDATE(), '%Y-%m-01' ) 
                                AND CURDATE()) AS book ON book.id_user = usr.id_user
                                LEFT JOIN (
                                SELECT COALESCE
                                  ( created_by, $id_rsp ) AS id_user,
                                  COUNT( id_gci ) AS akad 
                                FROM
                                  rsp_project_live.view_status_gci 
                                WHERE
                                  created_by = $id_rsp 
                                  AND status_proses = 45 
                                  AND DATE( created_at ) BETWEEN DATE_FORMAT( CURDATE(), '%Y-%m-01' ) 
                                AND CURDATE()) AS akad ON akad.id_user = usr.id_user 
                              WHERE
                                usr.id_user = $id_rsp 
                                AND usr.id_user <> spv 
                                AND usr.id_user <> id_manager 
                                AND usr.id_user <> id_gm")->row_array();
  }

  function get_id_rsp($id_hr)
  {
    return $this->db->query("SELECT id_user, employee_name, id_hr FROM rsp_project_live.`user` AS usr WHERE usr.id_hr = $id_hr")->row_array();
  }

  function generate_body_resume_m_v3($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];

    $kondisi = "";
    if ($role_id == 1) {
      $kondisi = "";
    } else if ($user_id == 1161 || $user_id == 70 || $user_id == 803) { // fuji
      $kondisi = "";
    } else {
      $kondisi = "WHERE xx.user_id = $user_id ";
    }

    $query = "SELECT 
    xx.user_id, 
    xx.employee_name,
    COUNT(IF(xx.input >= 1,1,NULL)) AS w1,
    xx.input,
    xx.company_name,
    xx.jabatan
    FROM(
    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, 

    CASE 
		WHEN b.tanggal IS NULL THEN 0
		WHEN COUNT(b.tanggal) < 3 THEN 0
		ELSE 1 END AS input
    FROM
      (
      SELECT 
      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan
      FROM xin_employees a
      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
      LEFT JOIN xin_companies c ON c.company_id = a.company_id
      LEFT JOIN xin_departments d ON d.department_id = a.department_id
      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
      WHERE a.is_active = 1 AND (user_id IN (118,637,998,2108,2733,1294,1733,1369,1844)) 
      ) tm
      LEFT JOIN coaching b ON FIND_IN_SET(tm.user_id, b.created_by) AND SUBSTR(b.tanggal, 1, 10) BETWEEN '$start' AND '$end'
    GROUP BY tm.user_id
    ) xx $kondisi GROUP BY xx.user_id";
    return $this->db->query($query);
  }

  function get_pekerjaan()
  {
    return $this->db->get('m_pekerjaan')->result();
  }

  function get_sub_pekerjaan($pekerjaan)
  {
    return $this->db->get_where('m_sub_pekerjaan', ['id_pekerjaan' => $pekerjaan])->result();
  }
  function get_det_pekerjaan($id_sub_pekerjaan)
  {
    return $this->db->get_where('t_detail_pekerjaan', ['id_sub_pekerjaan' => $id_sub_pekerjaan])->result();
  }
  function detail_print($id)
  {
    $query = "SELECT
                  coaching.id_coaching,
                  CONCAT(kary.first_name,' ',kary.last_name) AS karyawan,
                  coaching.tempat,
                  DATE_FORMAT(coaching.tanggal,'%d %b %Y') AS tanggal,
                  CONCAT(atas.first_name,' ',atas.last_name) AS atasan,
                  coaching.review,
                  coaching.goals,
                  coaching.reality,
                  coaching.option,
                  coaching.will,
                  coaching.komitmen,
                  COALESCE(coaching.foto,'') AS foto,
                  coaching.company_id,
                  comp.name AS company_name,
                  coaching.department_id,
                  dp.department_name,
                  coaching.designation_id,
                  dg.designation_name,
                  coaching.role_id,
                  role.role_name,
                  coaching.created_at,
                  CONCAT(usr.first_name,' ',usr.last_name) AS created_by
                FROM
                  coaching 
                  JOIN xin_employees AS kary ON kary.user_id = coaching.karyawan
                  JOIN xin_employees AS atas ON atas.user_id = coaching.atasan
                  JOIN xin_employees AS usr ON usr.user_id = coaching.created_by
                  LEFT JOIN xin_companies AS comp ON comp.company_id = coaching.company_id
                  LEFT JOIN xin_departments AS dp ON dp.department_id = coaching.department_id
                  LEFT JOIN xin_designations AS dg ON dg.designation_id = coaching.designation_id
                  LEFT JOIN xin_user_roles AS role ON role.role_id = coaching.role_id
                WHERE
                  coaching.id_coaching = '$id'";
    return $this->db->query($query)->row_object();
  }
}
