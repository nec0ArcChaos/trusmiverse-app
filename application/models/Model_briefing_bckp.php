<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_briefing extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_id_briefing()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( briefing.id_briefing, 4 ) ) AS kd_max 
                              FROM
                                briefing 
                              WHERE
                                DATE( briefing.created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return 'BF' . date('ymd') . $kd;
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

  function list_briefing($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super       = [1139, 8892, 2, 5197, 5086, 5385, 2729, 68];   // Viky, Lintang, Ali95, hience3160, farrel3072,alfin3333,saeroh,farhan
    $list_department  = [117, 1, 72, 73, 156, 157, 167];
    $list_designation = [1217, 1218]; // HRBP Manager, Officer

    if ($role_id == 1 || in_array($user_id, $list_super) || $department_id == 1 || in_array($designation_id, $list_designation)) { // Super Admin, or HR Holding
      $kondisi = "";
    } else if (in_array($department_id, $list_department)) { // HR sesuai Company
      $kondisi = "AND (briefing.company_id = $company_id OR briefing.created_by = $user_id)";
    } else if ($role_id == 2) { // Head
      $kondisi = "AND briefing.department_id = $department_id";
    } else if ($role_id == 3) { // Manager
      $kondisi = "AND briefing.department_id = $department_id AND (briefing.role_id IN (4,5) OR briefing.created_by = $user_id)";
    } else if ($role_id == 4) { // Ass Manager
      $kondisi = "AND briefing.department_id = $department_id AND (briefing.role_id IN (5) OR briefing.created_by = $user_id)";
    } else if ($user_id == 3325 || $user_id == 5336) { // budiman1835,farouq3286
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.company_id = 2)";
    } else if ($user_id == 329) { // ratih
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (25,120,154,155))";
    } else if ($user_id == 2505 || $user_id == 5078) { // puput maulani all marketing rsp, aisyah3066
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (120,137,154,155))";
    } else { // SPV
      $kondisi = "AND briefing.created_by = $user_id";
    }

    return $this->db->query("SELECT
                              briefing.id_briefing,
                              briefing.review,
                              briefing.plan,
                              briefing.informasi,
                              briefing.motivasi,
                              COALESCE(briefing.foto,'') AS foto,
                              briefing.company_id,
                              comp.name AS company_name,
                              briefing.department_id,
                              dp.department_name,
                              briefing.designation_id,
                              dg.designation_name,
                              briefing.role_id,
                              role.role_name,
                              briefing.created_at,
                              CONCAT(usr.first_name,' ',usr.last_name) AS created_by
                            FROM
                              briefing 
                              JOIN xin_employees AS usr ON usr.user_id = briefing.created_by
                              LEFT JOIN xin_companies AS comp ON comp.company_id = briefing.company_id
                              LEFT JOIN xin_departments AS dp ON dp.department_id = briefing.department_id
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = briefing.designation_id
                              LEFT JOIN xin_user_roles AS role ON role.role_id = briefing.role_id
                            WHERE
                              DATE( briefing.created_at ) BETWEEN '$start' 
                              AND '$end'
                              $kondisi")->result();
  }

  function dt_lock_brif_d_v1($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
		$role_id        = $_SESSION['user_role_id'];

		$kondisi = "";
		if ($role_id == 1) {
		$kondisi = "";
		} else {
		$kondisi = "WHERE xx.user_id = $user_id ";
		}

    $query = "SELECT 
    xx.user_id, 
    xx.employee_name,
    COUNT(IF(xx.created_by IS NULL,1,NULL)) AS total_lock,
    SUM(lock_t) AS lock_t,
    xx.company_name,
    xx.jabatan
    FROM(
    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, c.attendance_date, b.created_at, b.created_by,
    CASE WHEN attendance_date = CURRENT_DATE AND b.created_by IS NULL THEN 1 ELSE 0 END lock_t
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
      WHERE a.is_active = 1 AND (user_id IN (0)) 
      ) tm
			LEFT JOIN xin_attendance_time c ON c.employee_id = tm.user_id
      LEFT JOIN briefing b ON tm.user_id = b.created_by AND SUBSTR(b.created_at, 1, 10) = SUBSTR(c.attendance_date, 1, 10)
      WHERE SUBSTR(c.attendance_date, 1, 10) BETWEEN '2024-03-01' AND  '2024-03-29'
    GROUP BY tm.user_id, SUBSTR(c.attendance_date,1,10)
    ) xx  

		GROUP BY xx.user_id";
    return $this->db->query($query);
  }
}
