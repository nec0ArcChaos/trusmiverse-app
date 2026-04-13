<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_problem_solving_new extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_id_problem_solving()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( id_ps, 4 ) ) AS kd_max 
                              FROM
                                ps_task 
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

    return 'PS' . date('ymd') . $kd;
  }

  function get_master($tipe)
  {
    if ($tipe == "category") {
      $kondisi = "WHERE category IS NOT NULL";
    } else if ($tipe == "priority") {
      $kondisi = "WHERE priority IS NOT NULL";
    } else if ($tipe == "status") {
      $kondisi = "WHERE `status` IS NOT NULL AND id <> 1";
    }
    return $this->db->query("SELECT * FROM ps_m_category $kondisi")->result();
  }

  function get_category_new()
  {
    return $this->db->query("SELECT * FROM ps_m_category_new")->result();
  }

  function get_pic($department_id)
  {
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    // if ($role_id == 1) { // Super Admin
    //   $kondisi = "";
    // } else {
      $kondisi = "AND em.department_id = $department_id";
    // }
    return $this->db->query("SELECT
                              em.user_id,
                              CONCAT(em.first_name,' ',em.last_name,' | ',dep.department_name) AS employee_name
                            FROM
                              xin_employees AS em
                              JOIN xin_companies AS com ON com.company_id = em.company_id
                              JOIN xin_departments AS dep ON dep.department_id = em.department_id
                            WHERE
                              em.is_active = 1 
                              AND em.user_role_id NOT IN ( 7, 8 ) 
                              AND em.user_id <> 1
                              $kondisi")->result();
  }

  function get_pic_public($user_id)
  {
    $emp = $this->db->query("SELECT * FROM xin_employees WHERE user_id = $user_id")->row_array();
    $role_id        = $emp['user_role_id'];
    $company_id     = $emp['company_id'];
    if ($role_id == 1) { // Super Admin
      $kondisi = "";
    } else {
      $kondisi = "AND em.company_id = $company_id";
    }
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
                              AND em.user_id <> 1
                              $kondisi")->result();
  }

  function get_department()
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    // if ($role_id == 1) { 
      $kondisi = "";
    // } else {
    //   $kondisi = "WHERE company_id = $company_id";
    // }
    return $this->db->query("SELECT 
      xin_departments.department_id,
      xin_departments.department_name,
      com.name as company_name
    FROM 
      xin_departments
      JOIN xin_companies AS com ON com.company_id = xin_departments.company_id 
    $kondisi")->result();
  }

  function get_project()
    {
        $query = "SELECT
                m.id_project,
                m.project
              FROM
                rsp_project_live.m_project m
                WHERE m.status is null
                ORDER BY m.project";
        return $this->db->query($query)->result();
    }

  function list_problem($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super       = [1,5286];   // farid3241
    // $list_department  = [117,1,72,73,156,157,167];
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
      $kondisi = "";
    } else {
      $kondisi = "AND (tsk.created_by = '$user_id' OR tsk.pic = '$user_id' OR tsk.delegate_escalate_to = '$user_id' OR ps_task_delegate_history.delegate_escalate_to = '$user_id')";
    }
    
    return $this->db->query("SELECT
                              tsk.id_ps,
                              tsk.problem,
                              tsk.solving,
                              tsk.category_id,
                              ct.category,
                              tsk.category_new_id,
                              ctn.category as category_new,
                              tsk.priority_id,
                              pt.priority,
                              DATE_FORMAT(tsk.deadline,'%d %b %Y') AS deadline,
                              tsk.file_problem,
                              tsk.link_problem,
                              tsk.department_id,
                              depa.department_name,
                              tsk.tindakan,
                              tsk.repetisi,
                              tsk.hasil_review as rating_feedback,
                              tsk.note_review as feedback,
                              tsk.`status` AS status_id,
                              sts.`status`,
                              tsk.resume,
                              tsk.created_at,
                              tsk.delegate_escalate_to,
                              tsk.tasklist,
                              tsk.deadline_solution,
                              CONCAT(dgec.first_name,' ',dgec.last_name) AS delegate_escalate_name,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              tsk.created_by AS created_by_id,
                              tsk.factor,
                              CONCAT(pc.first_name,' ',pc.last_name) AS pic,
                              tsk.pic AS pic_id,
                              tsk.id_project,
                              mp.project
                            FROM
                              ps_task AS tsk
                              JOIN xin_employees AS em ON em.user_id = tsk.created_by
                              LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic
                              LEFT JOIN xin_employees AS dgec ON dgec.user_id = tsk.delegate_escalate_to
                              LEFT JOIN xin_departments AS depa ON depa.department_id = tsk.department_id
                              LEFT JOIN ps_m_category AS ct ON ct.id = tsk.category_id
                              LEFT JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
                              LEFT JOIN ps_m_category AS sts ON sts.id = tsk.`status`
                              LEFT JOIN ps_m_category_new AS ctn ON ctn.id = tsk.category_new_id
                              LEFT JOIN ps_task_delegate_history ON ps_task_delegate_history.id_ps = tsk.id_ps
                              LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = tsk.id_project
                            WHERE
                              DATE ( tsk.created_at ) BETWEEN '$start'
                              AND '$end' $kondisi
                              ORDER BY tsk.created_at DESC")->result();
  }

  function list_problem_feedback()
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super       = [5286];   // farid3241
    // $list_department  = [117,1,72,73,156,157,167];
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
      $kondisi = "";
    } else {
      $kondisi = "AND tsk.created_by = $user_id";
    }

    return $this->db->query("SELECT
                              tsk.id_ps,
                              tsk.problem,
                              tsk.solving,
                              tsk.category_id,
                              ct.category,
                              tsk.category_new_id,
                              ctn.category as category_new,
                              tsk.priority_id,
                              pt.priority,
                              DATE_FORMAT(tsk.deadline,'%d %b %Y') AS deadline,
                              tsk.file_problem,
                              tsk.link_problem,
                              tsk.department_id,
                              depa.department_name,
                              tsk.tindakan,
                              tsk.repetisi,
                              tsk.hasil_review as rating_feedback,
                              tsk.note_review as feedback,
                              tsk.`status` AS status_id,
                              sts.`status`,
                              tsk.resume,
                              tsk.created_at,
                              tsk.delegate_escalate_to,
                              tsk.tasklist,
                              tsk.deadline_solution,
                              CONCAT(dgec.first_name,' ',dgec.last_name) AS delegate_escalate_name,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              created_by AS created_by_id,
                              tsk.factor,
                              CONCAT(pc.first_name,' ',pc.last_name) AS pic,
                              tsk.pic AS pic_id,
                              tsk.id_project,
                              mp.project
                            FROM
                              ps_task AS tsk
                              JOIN xin_employees AS em ON em.user_id = tsk.created_by
                              LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic
                              LEFT JOIN xin_employees AS dgec ON dgec.user_id = tsk.delegate_escalate_to
                              LEFT JOIN xin_departments AS depa ON depa.department_id = tsk.department_id
                              LEFT JOIN ps_m_category AS ct ON ct.id = tsk.category_id
                              LEFT JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
                              LEFT JOIN ps_m_category AS sts ON sts.id = tsk.`status`
                              LEFT JOIN ps_m_category_new AS ctn ON ctn.id = tsk.category_new_id
                              LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = tsk.id_project
                            WHERE
                              hasil_review is NULL AND DATE ( tsk.created_at ) > '2025-05-01' $kondisi
                              ORDER BY tsk.created_at DESC")->result();
  }

  function get_detail_user($user_id)
  {
    return $this->db->query("SELECT
                              user_id,
                              CONCAT(first_name,' ',last_name) AS name,
                              contact_no,
                              xin_employees.company_id,
                              xin_employees.department_id,
                              depa.department_name,
                              xin_employees.designation_id,
                              xin_employees.user_role_id AS role_id 
                            FROM
                              xin_employees 
                              LEFT JOIN xin_departments AS depa ON depa.department_id = xin_employees.department_id
                            WHERE
                              user_id = $user_id")->row_array();
  }

  function get_detail_problem($id)
  {
    return $this->db->query("SELECT
                              tsk.id_ps,
                              tsk.problem,
                              tsk.solving,
                              tsk.category_id,
                              ct.category,
                              tsk.category_new_id,
                              ctn.category as category_new,
                              tsk.priority_id,
                              pt.priority,
                              DATE_FORMAT(tsk.deadline,'%d %b %Y') AS deadline,
                              tsk.file_problem,
                              tsk.link_problem,
                              tsk.department_id,
                              depa.department_name,
                              tsk.tindakan,
                              tsk.repetisi,
                              tsk.hasil_review as rating_feedback,
                              tsk.note_review as feedback,
                              tsk.`status` AS status_id,
                              sts.`status`,
                              tsk.resume,
                              tsk.created_at,
                              tsk.delegate_escalate_to,
                              tsk.tasklist,
                              tsk.deadline_solution,
                              tsk.lampiran,
                              tsk.link_solution,
                              CONCAT(dgec.first_name,' ',dgec.last_name) AS delegate_escalate_name,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              tsk.factor,
                              CONCAT(pc.first_name,' ',pc.last_name) AS pic,
                              tsk.pic AS pic_id,
                              tsk.id_project,
                              mp.project
                            FROM
                              ps_task AS tsk
                              JOIN xin_employees AS em ON em.user_id = tsk.created_by
                              LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic
                              LEFT JOIN xin_employees AS dgec ON dgec.user_id = tsk.delegate_escalate_to
                              LEFT JOIN xin_departments AS depa ON depa.department_id = tsk.department_id
                              LEFT JOIN ps_m_category AS ct ON ct.id = tsk.category_id
                              LEFT JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
                              LEFT JOIN ps_m_category AS sts ON sts.id = tsk.`status`
                              LEFT JOIN ps_m_category_new AS ctn ON ctn.id = tsk.category_new_id
                              LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = tsk.id_project
                            WHERE
                              tsk.id_ps = '$id'")->row_array();
  }

  function profile_data($id, $user_id)
  {
    $check = $this->db->query("SELECT * FROM ps_task WHERE id_ps = '$id'")->row_array();
    if ($check['pic'] == $user_id) {
      $pic_or_delegate = "LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.pic AND pc.user_id = $user_id";
      $is_pic = 'true as is_pic,';
    } elseif ($check['delegate_escalate_to'] == $user_id) {
      $pic_or_delegate = "LEFT JOIN xin_employees AS pc ON pc.user_id = tsk.delegate_escalate_to AND pc.user_id = $user_id";
      $is_pic = 'false as is_pic,';
    } else {
      return false;
    }
    return $this->db->query("SELECT
                              
                              tsk.id_ps,
                              tsk.problem,
                              tsk.solving,
                              tsk.category_id,
                              ct.category,
                              tsk.category_new_id,
                              ctn.category as category_new,
                              tsk.priority_id,
                              pt.priority,
                              DATE_FORMAT(tsk.deadline,'%d %b %Y') AS deadline,
                              tsk.file_problem,
                              tsk.link_problem,
                              tsk.department_id,
                              depa.department_name,
                              tsk.tindakan,
                              tsk.repetisi,
                              tsk.hasil_review as rating_feedback,
                              tsk.note_review as feedback,
                              tsk.`status` AS status_id,
                              sts.`status`,
                              tsk.resume,
                              tsk.created_at,
                              tsk.delegate_escalate_to,
                              tsk.tasklist,
                              tsk.deadline_solution,
                              tsk.lampiran,
                              tsk.link_solution,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              tsk.factor,
                              CONCAT(pc.first_name,' ',pc.last_name) AS pic_name,
                              tsk.pic AS pic_id,
                              (CASE 
                                  WHEN (`pc`.`gender` = 'Male') THEN 
                                      CONCAT('https://trusmiverse.com/hr/uploads/profile/', COALESCE(NULLIF(`pc`.`profile_picture`, ''), 'default_male.jpg'))
                                  ELSE 
                                      CONCAT('https://trusmiverse.com/hr/uploads/profile/', COALESCE(NULLIF(`pc`.`profile_picture`, ''), 'default_female.jpg'))
                              END) AS `pic_photo`,
                              desi.designation_name AS pic_designation,
                              tsk.id_project,
                              mp.project
                            FROM
                              ps_task AS tsk
                              JOIN xin_employees AS em ON em.user_id = tsk.created_by
                              $pic_or_delegate
                              LEFT JOIN xin_designations AS desi ON desi.designation_id = pc.designation_id
                              LEFT JOIN xin_departments AS depa ON depa.department_id = tsk.department_id
                              LEFT JOIN ps_m_category AS ct ON ct.id = tsk.category_id
                              LEFT JOIN ps_m_category AS pt ON pt.id = tsk.priority_id
                              LEFT JOIN ps_m_category AS sts ON sts.id = tsk.`status`
                              LEFT JOIN ps_m_category_new AS ctn ON ctn.id = tsk.category_new_id
                              LEFT JOIN rsp_project_live.m_project AS mp ON mp.id_project = tsk.id_project
                            WHERE
                              tsk.id_ps = '$id'")->row_array();
  }

  public function get_history_delegate($id)
  {
    return $this->db->query("SELECT
                              his.id_ps,
                              CONCAT(em.first_name,' ',em.last_name) AS delegate_name,
                              CONCAT(pc.first_name,' ',pc.last_name) AS created_by,
                              his.created_at
                            FROM
                              ps_task_delegate_history AS his
                              LEFT JOIN xin_employees AS em ON em.user_id = his.delegate_escalate_to
                              LEFT JOIN xin_employees AS pc ON pc.user_id = his.created_by
                            WHERE
                                his.id_ps = '$id'")->result();
  }

} 
