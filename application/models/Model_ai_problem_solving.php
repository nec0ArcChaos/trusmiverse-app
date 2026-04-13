<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_ai_problem_solving extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_no_problem_solving()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( no_ps, 4 ) ) AS kd_max 
                              FROM
                                ai_problem_solving 
                              WHERE
                                DATE( created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return 'APS' . date('ymd') . $kd;
  }

  function list_problem($start, $end)
  {
    // $user_id        = $_SESSION['user_id'];
    // $role_id        = $_SESSION['user_role_id'];
    // $company_id     = $_SESSION['company_id'];
    // $department_id  = $_SESSION['department_id'];
    // $designation_id = $_SESSION['designation_id'];

    // $list_super       = [5286];   // farid3241
    // $list_department  = [117,1,72,73,156,157,167];
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    // if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
    //   $kondisi = "";
    // } else {
    //   $kondisi = "AND tsk.department_id = $department_id";
    // }

    return $this->db->query("SELECT
                              tsk.no_ps,
                              tsk.problem,
                              tsk.rekom_why_1,
                              tsk.why_1,
                              tsk.rekom_why_2,
                              tsk.why_2,
                              tsk.rekom_why_3,
                              tsk.why_3,
                              tsk.rekom_why_4,
                              tsk.why_4,
                              tsk.rekom_why_5,
                              tsk.why_5,
                              tsk.rekom_solving,
                              tsk.solving,
                              tsk.created_at,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by
                            FROM
                              ai_problem_solving AS tsk
                              JOIN xin_employees AS em ON em.user_id = tsk.created_by
                            WHERE
                              DATE ( tsk.created_at ) BETWEEN '$start'
                              AND '$end'
                            ORDER BY tsk.created_at DESC")->result();
  }

} // End of class
