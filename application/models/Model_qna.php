<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_qna extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function get_qna($id)
  {
    return $this->db->query("SELECT
                              MD5( id_question ) AS encrypt,
                              q.id_question,
                              q.judul,
                              q.pengantar,
                              q.department_id,
                              dp.department_name,
                              q.company_id,
                              comp.`name` AS company_name,
                              q.list_user_id
                            FROM
                              qna_m_question AS q
                              LEFT JOIN xin_departments AS dp ON dp.department_id = q.department_id
                              LEFT JOIN xin_companies AS comp ON comp.company_id = q.company_id
                            WHERE
                              MD5( id_question ) = '$id'")->row_array();
  }

  function get_qna_item($id)
  {
    return $this->db->query("SELECT
                              item.id_question_item,
                              item.question_id,
                              IF(item.no_urut = 0,item.huruf_urut,item.no_urut) AS urutan,
                              item.no_urut,
                              item.huruf_urut,
                              item.question,
                              item.type_id,
                              COALESCE(item.a_1) AS a_1,
                              COALESCE(item.a_2) AS a_2,
                              COALESCE(item.a_3) AS a_3,
                              COALESCE(item.a_4) AS a_4,
                              COALESCE(item.a_5) AS a_5,
                              CONCAT(item.a_1,'|',item.b_1) AS val_a_1,
                              CONCAT(item.a_2,'|',item.b_2) AS val_a_2,
                              CONCAT(item.a_3,'|',item.b_3) AS val_a_3,
                              CONCAT(item.a_4,'|',item.b_4) AS val_a_4,
                              CONCAT(item.a_5,'|',item.b_5) AS val_a_5,
                              item.bobot 
                            FROM
                              qna_m_question_item AS item 
                            WHERE
                              MD5( item.question_id ) = '$id'")->result();
  }

  function generate_no_answer()
  {
    $q = $this->db->query("SELECT
                            MAX( RIGHT ( id_answer, 4 ) ) AS kd_max 
                          FROM
                            qna_answer 
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

    return 'QNA' . date('ymd') . $kd;
  }

  function get_periode()
  {
    return $this->db->query("SELECT WEEK ( CURDATE( ), 1 ) - WEEK ( DATE_FORMAT( CURDATE( ), '%Y-%m-01' ), 1 ) + 1 AS minggu, LEFT(CURDATE(),7) AS bulan")->row_array();
  }

  function get_detail_employee($user_id)
  {
    return $this->db->query("SELECT
                              user_id,
                              CONCAT( first_name, ' ', last_name ) AS employee_name,
                              company_id,
                              department_id,
                              user_role_id 
                            FROM
                              xin_employees 
                            WHERE
                              user_id = $user_id")->row_array();
  }

  // Tidak dipakai, pindah ke list_qna_new : Faisal 01/07/2024
  function list_qna()
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    // $department_id  = $_SESSION['department_id'];
    // $designation_id = $_SESSION['designation_id'];

    $list_super       = [2,2903,5121,10127]; // Ali95
    $list_role_super  = [1,11]; // Superadmin, recruitment
    // $list_super       = [1139,8892,70,2,5197,2951,5086,5385,2729,68]; // Viky, Lintang, Nining27, Ali95, hience3160, alfin3333, saeroh, Farhan63
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    // Super Admin & Tambahan
    if (in_array($role_id,$list_role_super) || in_array($user_id,$list_super)) {
      $query = "SELECT
                CONCAT( emp.first_name, ' ', emp.last_name ) AS user_lock,
                'Start' AS text_qna,
                'danger' AS color_qna,
                -- IF(ans.id_answer IS NOT NULL,'Complete','Start') AS text_qna,
                -- IF(ans.id_answer IS NOT NULL,'success','danger') AS color_qna,
                ans.id_answer,
                md5(q.id_question) AS encrypt,
                q.id_question,
                q.judul,
                q.pengantar,
                q.category_id,
                ct.category,
                q.company_id,
                IF(q.company_id = 0,'All',comp.`name`) AS company_name,
                q.department_id,
                IF(q.department_id = 0,'All',dp.department_name) AS department_name,
                q.user_role_id,
                IF ( q.user_role_id = 0, 'All', rl.role_name ) AS role_name,
                q.list_user_id,
                GROUP_CONCAT(CONCAT( em.first_name, ' ', em.last_name )) AS employees,
                item.total AS total_question,
                q.created_at,
                q.created_by
              FROM
                qna_m_question AS q
                LEFT JOIN xin_employees AS emp ON emp.company_id = q.company_id AND emp.department_id = q.department_id AND emp.is_active = 1
                JOIN ( SELECT question_id, COUNT( question_id ) AS total FROM qna_m_question_item WHERE no_urut <> 0 GROUP BY question_id ) AS item ON item.question_id = q.id_question
                LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, q.list_user_id )
                LEFT JOIN xin_user_roles AS rl ON rl.role_id = q.user_role_id
                LEFT JOIN xin_departments AS dp ON dp.department_id = q.department_id
                LEFT JOIN xin_companies AS comp ON comp.company_id = q.company_id
                JOIN qna_m_category AS ct ON ct.id_category = q.category_id
                LEFT JOIN xin_employees AS adm ON adm.user_id = q.created_by
                LEFT JOIN qna_answer AS ans ON ans.id_question = q.id_question AND ans.periode = q.periode_lock AND ans.created_by = emp.user_id
              GROUP BY
                q.id_question";
    } else {
      $query = "SELECT
                CONCAT( emp.first_name, ' ', emp.last_name ) AS user_lock,
                IF(ans.id_answer IS NOT NULL,'Complete','Start') AS text_qna,
                IF(ans.id_answer IS NOT NULL,'success','danger') AS color_qna,
                ans.id_answer,
                md5(q.id_question) AS encrypt,
                q.id_question,
                q.judul,
                q.pengantar,
                q.category_id,
                ct.category,
                q.company_id,
                IF(q.company_id = 0,'All',comp.`name`) AS company_name,
                q.department_id,
                IF(q.department_id = 0,'All',dp.department_name) AS department_name,
                q.user_role_id,
                IF ( q.user_role_id = 0, 'All', rl.role_name ) AS role_name,
                q.list_user_id,
                GROUP_CONCAT(CONCAT( em.first_name, ' ', em.last_name )) AS employees,
                item.total AS total_question,
                q.created_at,
                q.created_by
              FROM
                qna_m_question AS q
                LEFT JOIN xin_employees AS emp ON emp.company_id = q.company_id AND emp.department_id = q.department_id AND emp.is_active = 1
                JOIN ( SELECT question_id, COUNT( question_id ) AS total FROM qna_m_question_item WHERE no_urut <> 0 GROUP BY question_id ) AS item ON item.question_id = q.id_question
                LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, q.list_user_id )
                LEFT JOIN xin_user_roles AS rl ON rl.role_id = q.user_role_id
                LEFT JOIN xin_departments AS dp ON dp.department_id = q.department_id
                LEFT JOIN xin_companies AS comp ON comp.company_id = q.company_id
                JOIN qna_m_category AS ct ON ct.id_category = q.category_id
                LEFT JOIN xin_employees AS adm ON adm.user_id = q.created_by
                LEFT JOIN qna_answer AS ans ON ans.id_question = q.id_question AND ans.periode = q.periode_lock AND ans.created_by = emp.user_id
              WHERE 
                    emp.user_id = $user_id
                  GROUP BY
                    q.id_question, emp.user_id";
    }

    return $this->db->query($query)->result();
  }

  function list_qna_new($periode)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    // $department_id  = $_SESSION['department_id'];
    // $designation_id = $_SESSION['designation_id'];

    $list_super       = [2,2903,5121,10127]; // Ali95
    $list_role_super  = [1,11]; // Superadmin, recruitment
    // $list_super       = [1139,8892,70,2,5197,2951,5086,5385,2729,68]; // Viky, Lintang, Nining27, Ali95, hience3160, alfin3333, saeroh, Farhan63
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    // Super Admin & Tambahan
    if (in_array($role_id,$list_role_super) || in_array($user_id,$list_super)) {
      $query = "SELECT
                  em.username,
                  IF ( ans.id_answer IS NOT NULL, 'Complete', 'Start' ) AS text_qna,
                  IF ( ans.id_answer IS NOT NULL, 'success', 'danger' ) AS color_qna,
                  ans.id_answer,
                  md5( q.id_question ) AS encrypt,
                  q.id_question,
                  q.judul,
                  q.pengantar,
                  ans.periode AS periode,
                  '' AS category_id,
                  'All' AS category,
                  em.company_id,
                  com.`name` AS company_name,
                  em.department_id,
                  dp.department_name,
                  em.user_role_id,
                  rl.role_name,
                  '' AS employees,
                  '' AS created_at,
                  '' AS created_by,
                  item.total AS total_question
                FROM
                  qna_m_question AS q
                  LEFT JOIN xin_employees AS em ON em.is_active = 1
                  LEFT JOIN xin_companies AS com ON com.company_id = em.company_id
                  LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
                  LEFT JOIN xin_user_roles AS rl ON rl.role_id = em.user_role_id
                  LEFT JOIN ( SELECT question_id, COUNT( question_id ) AS total FROM qna_m_question_item WHERE no_urut <> 0 GROUP BY question_id ) AS item ON item.question_id = q.id_question
                  LEFT JOIN qna_answer AS ans ON ans.id_question = q.id_question 
                  AND ans.periode = '$periode'
                  AND ans.created_by = em.user_id
                WHERE
                  em.user_id = $user_id
                GROUP BY
                  q.id_question, em.user_id";
    } else {
      $query = "SELECT
                  em.username,
                  IF ( ans.id_answer IS NOT NULL, 'Complete', 'Start' ) AS text_qna,
                  IF ( ans.id_answer IS NOT NULL, 'success', 'danger' ) AS color_qna,
                  ans.id_answer,
                  md5( q.id_question ) AS encrypt,
                  q.id_question,
                  q.judul,
                  q.pengantar,
                  lk.periode,
                  lk.category_id,
                  ct.category,
                  em.company_id,
                  com.`name` AS company_name,
                  em.department_id,
                  dp.department_name,
                  em.user_role_id,
                  rl.role_name,
                  lk.list_user_id,
                  '' AS employees,
                  lk.created_at,
                  lk.created_by,
                  item.total AS total_question
                FROM
                  qna_m_question AS q
                  JOIN qna_lock AS lk ON lk.id_question = q.id_question 
                  AND lk.periode = '$periode'
                  JOIN qna_m_category AS ct ON ct.id_category = lk.category_id
                  LEFT JOIN xin_employees AS em ON (
                  CASE
                      lk.category_id 
                      WHEN 2 THEN
                      em.is_active = 1 
                      AND FIND_IN_SET( em.user_role_id, lk.user_role_id ) 
                      AND em.company_id = lk.company_id 
                      WHEN 3 THEN
                      em.is_active = 1 
                      AND em.company_id = lk.company_id 
                      AND em.department_id = lk.department_id 
                      WHEN 4 THEN
                      em.is_active = 1 
                      AND FIND_IN_SET( em.user_id, lk.list_user_id ) 
                      WHEN 5 THEN
                      em.is_active = 1 
                      AND FIND_IN_SET( em.designation_id, lk.designation_id )
                      ELSE em.is_active = 1 
                    END 
                    )
                    LEFT JOIN xin_companies AS com ON com.company_id = em.company_id
                    LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
                    LEFT JOIN xin_user_roles AS rl ON rl.role_id = em.user_role_id
                    LEFT JOIN ( SELECT question_id, COUNT( question_id ) AS total FROM qna_m_question_item WHERE no_urut <> 0 GROUP BY question_id ) AS item ON item.question_id = q.id_question
                    LEFT JOIN qna_answer AS ans ON ans.id_question = q.id_question 
                    AND ans.periode = lk.periode 
                    AND ans.created_by = em.user_id 
                  WHERE
                    em.user_id = $user_id";
    }

    return $this->db->query($query)->result();
  }

  function list_result_qna($start,$end)
  {
    // $user_id        = $_SESSION['user_id'];
    // $role_id        = $_SESSION['user_role_id'];
    // $department_id  = $_SESSION['department_id'];
    // $designation_id = $_SESSION['designation_id'];

    // $list_super       = [1139,8892,70,2,5197,2951,5086,5385,2729,68]; // Viky, Lintang, Nining27, Ali95, hience3160, alfin3333, saeroh, Farhan63
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    // // Super Admin & Tambahan
    // if ($role_id == 1 || in_array($user_id,$list_super) || in_array($designation_id,$list_designation)) {
    //   $kondisi = "";
    // } else if ($role_id == 2) { // Head
    //   $kondisi = "AND em.department_id = $department_id";
    // } else if ($role_id == 3) { // Manager
    //   $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (4,5) OR gemba.created_by = $user_id)";
    // } else if ($role_id == 4) { // Ass Manager
    //   $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (5) OR gemba.created_by = $user_id)";
    // } else if ($user_id == 70) { // Nining27
    //   $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (4,5))";
    // } else if ($user_id == 3325 || $user_id == 5336) { // budiman1835, farouq3286
    //   $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (2))";
    // } else {
    //   $kondisi = "AND gemba.created_by = $user_id";
    // }

    return $this->db->query("SELECT
                              ans.id_answer,
                              ans.id_question,
                              q.judul,
                              ans.`week`,
                              ans.periode,
                              ans.company_id,
                              comp.`name` AS company_name,
                              ans.department_id,
                              dp.department_name,
                              ans.user_role_id,
                              rl.role_name,
                              ROUND(ans.nilai/20,2) AS nilai,
                              CASE
                                WHEN ROUND(ans.nilai/20,2) > 4.5 THEN
                                  'Istimewa'
                                WHEN ROUND(ans.nilai/20,2) > 3.5 THEN
                                  'Baik'
                                WHEN ROUND(ans.nilai/20,2) > 2 THEN
                                  'Cukup'
                                ELSE
                                  'Kurang'
                              END AS indikator,
                              ans.created_at,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by
                            FROM
                              qna_answer AS ans
                              JOIN xin_employees AS em ON em.user_id = ans.created_by
                              JOIN qna_m_question AS q ON q.id_question = ans.id_question
                              JOIN xin_companies AS comp ON comp.company_id = ans.company_id
                              JOIN xin_departments AS dp ON dp.department_id = ans.department_id
                              JOIN xin_user_roles AS rl ON rl.role_id = ans.user_role_id
                            WHERE 
                              DATE(ans.created_at) BETWEEN '$start' AND '$end'")->result();
  }

  function get_result_qna($id_answer)
  {
    return $this->db->query("SELECT
                              ans.id_answer,
                              ans.id_question_item,
                              q.question,
                              ans.answer,
                              ans.bobot
                            FROM
                              qna_answer_item AS ans
                              JOIN qna_m_question_item AS q ON q.id_question_item = ans.id_question_item
                            WHERE
                              ans.id_answer = '$id_answer'")->result();
  }

  function check_qna($user_id,$id)
  {
    return $this->db->query("SELECT
                              * 
                            FROM
                              qna_answer 
                            WHERE
                              created_by = $user_id 
                              AND md5(id_question) = '$id'
                              AND periode = LEFT ( CURDATE(), 7 )")->num_rows();
  }

  function get_resume_by_sub($start, $end)
  {
    return $this->db->query("SELECT
                              m.id_question,
                              m.judul,
                              m.huruf_urut,
                              m.question,
                              tx.nilai,
                              CASE
                                WHEN tx.nilai > 4.5 THEN
                                  'Istimewa'
                                WHEN tx.nilai > 3.5 THEN
                                  'Baik'
                                WHEN tx.nilai > 2 THEN
                                  'Cukup'
                                ELSE
                                  'Kurang'
                              END AS indikator,
                              tx.a1,
                              tx.a2,
                              tx.a3,
                              tx.a4,
                              tx.a5
                            FROM
                              (
                              SELECT
                                q.id_question,
                                q.judul,
                                qi.huruf_urut,
                                qi.question 
                              FROM
                                qna_m_question AS q
                                JOIN qna_m_question_item AS qi ON qi.question_id = q.id_question 
                              GROUP BY
                                q.id_question,
                                qi.huruf_urut 
                              ) AS m
                              JOIN (
                              SELECT
                                fix.id_question,
                                fix.huruf_urut,
                                ROUND(SUM(fix.nilai)/COUNT(fix.nilai),2) AS nilai,
                                SUM(fix.a1) AS a1,
                                SUM(fix.a2) AS a2,
                                SUM(fix.a3) AS a3,
                                SUM(fix.a4) AS a4,
                                SUM(fix.a5) AS a5
                              FROM
                                (
                                SELECT
                                  dua.id_answer,
                                  dua.id_question,
                                  dua.huruf_urut,
                                  ROUND( SUM( dua.bobot )/( SUM( dua.mbobot )/ 5 ), 2 ) AS nilai,
                                  COUNT(
                                  IF
                                  ( dua.poin = 1, 1, NULL )) AS a1,
                                  COUNT(
                                  IF
                                  ( dua.poin = 2, 1, NULL )) AS a2,
                                  COUNT(
                                  IF
                                  ( dua.poin = 3, 1, NULL )) AS a3,
                                  COUNT(
                                  IF
                                  ( dua.poin = 4, 1, NULL )) AS a4,
                                  COUNT(
                                  IF
                                  ( dua.poin = 5, 1, NULL )) AS a5 
                                FROM
                                  (
                                  SELECT
                                    a.id_answer,
                                    DATE( a.created_at ) AS tgl,
                                    ai.id_question,
                                    ai.id_question_item,
                                    qi.huruf_urut,
                                    ai.answer,
                                    qi.bobot AS mbobot,
                                    ai.bobot,
                                    ai.type_id,
                                  CASE
                                      WHEN ai.answer = tp.a_1 THEN
                                      5 
                                      WHEN ai.answer = tp.a_2 THEN
                                      4 
                                      WHEN ai.answer = tp.a_3 THEN
                                      3 
                                      WHEN ai.answer = tp.a_4 THEN
                                      2 ELSE 1 
                                    END AS poin 
                                  FROM
                                    qna_answer AS a
                                    JOIN qna_answer_item AS ai ON ai.id_answer = a.id_answer
                                    JOIN qna_m_type AS tp ON tp.id_type = ai.type_id
                                    JOIN qna_m_question_item AS qi ON qi.id_question_item = ai.id_question_item 
                                  WHERE
                                    DATE( a.created_at ) BETWEEN '$start' 
                                    AND '$end' 
                                  ) AS dua 
                                GROUP BY
                                  dua.id_answer,
                                  dua.id_question,
                                dua.huruf_urut 
                                ) AS fix
                              GROUP BY
                                fix.id_question,
                                fix.huruf_urut
                              ) AS tx ON tx.id_question = m.id_question 
                              AND tx.huruf_urut = m.huruf_urut")->result();
  }

  function get_resume_by_question($start, $end)
  {
    return $this->db->query("SELECT
                              m.id_question,
                              m.judul,
                              m.sub,
                              m.id_question_item,
                              m.question,
                              tx.nilai,
                            CASE
                                WHEN tx.nilai > 4.5 THEN
                                'Istimewa' 
                                WHEN tx.nilai > 3.5 THEN
                                'Baik' 
                                WHEN tx.nilai > 2 THEN
                                'Cukup' ELSE 'Kurang' 
                              END AS indikator,
                              tx.a1,
                              tx.a2,
                              tx.a3,
                              tx.a4,
                              tx.a5 
                            FROM
                              (
                              SELECT
                                q.id_question,
                                q.judul,
                                qii.question AS sub,
                                qi.huruf_urut,
                                qi.id_question_item,
                                qi.question 
                              FROM
                                qna_m_question AS q
                                JOIN qna_m_question_item AS qi ON qi.question_id = q.id_question 
                                AND qi.no_urut <> 0
                                JOIN qna_m_question_item AS qii ON qii.question_id = q.id_question 
                                AND qii.huruf_urut = qi.huruf_urut AND qii.no_urut = 0 
                              GROUP BY
                                q.id_question,
                                qi.id_question_item 
                              ) AS m
                              JOIN (
                              SELECT
                                dua.id_question,
                                dua.id_question_item,
                                ROUND( SUM( dua.bobot )/( SUM( dua.mbobot )/ 5 ), 2 ) AS nilai,
                                COUNT(
                                IF
                                ( dua.poin = 1, 1, NULL )) AS a1,
                                COUNT(
                                IF
                                ( dua.poin = 2, 1, NULL )) AS a2,
                                COUNT(
                                IF
                                ( dua.poin = 3, 1, NULL )) AS a3,
                                COUNT(
                                IF
                                ( dua.poin = 4, 1, NULL )) AS a4,
                                COUNT(
                                IF
                                ( dua.poin = 5, 1, NULL )) AS a5 
                              FROM
                                (
                                SELECT
                                  a.id_answer,
                                  DATE( a.created_at ) AS tgl,
                                  ai.id_question,
                                  qi.question,
                                  ai.id_question_item,
                                  ai.answer,
                                  qi.bobot AS mbobot,
                                  ai.bobot,
                                  ai.type_id,
                                CASE
                                    WHEN ai.answer = tp.a_1 THEN
                                    5 
                                    WHEN ai.answer = tp.a_2 THEN
                                    4 
                                    WHEN ai.answer = tp.a_3 THEN
                                    3 
                                    WHEN ai.answer = tp.a_4 THEN
                                    2 ELSE 1 
                                  END AS poin 
                                FROM
                                  qna_answer AS a
                                  JOIN qna_answer_item AS ai ON ai.id_answer = a.id_answer
                                  JOIN qna_m_type AS tp ON tp.id_type = ai.type_id
                                  JOIN qna_m_question_item AS qi ON qi.id_question_item = ai.id_question_item 
                                WHERE
                                  DATE( a.created_at ) BETWEEN '$start' 
                                  AND '$end' 
                                ) AS dua 
                              GROUP BY
                                dua.id_question,
                                dua.id_question_item 
                              ) AS tx ON tx.id_question = m.id_question 
                              AND tx.id_question_item = m.id_question_item")->result();
  }
}
