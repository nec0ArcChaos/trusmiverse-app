<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_one_on_one extends CI_Model
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
                              usr.id_user,
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
                              JOIN rsp_project_live.user AS usr ON usr.join_hr = em.user_id
                            WHERE
                              em.is_active = 1 
                              AND em.user_id <> 1
                              AND em.department_id IN ( 120, 154, 155 )")->result();
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
                              AND em.user_role_id IN ( 1, 2, 3, 4, 5, 6 ,11)
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

  function list_one($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $kondisi = "";

    // $list_super       = [1139, 8892, 2, 5197, 5086, 5385, 2729];   // Viky, Lintang, Ali95, hience3160, alfin3333, saeroh
    // $list_department  = [117, 1, 72, 73, 156, 157, 167];
    // $list_designation = [1217, 1218]; // HRBP Manager, Officer

    // if ($role_id == 1 || in_array($user_id, $list_super) || $department_id == 1 || in_array($designation_id, $list_designation)) { // Super Admin, or HR Holding
    //   $kondisi = "";
    // } else if (in_array($department_id, $list_department)) { // HR sesuai Company
    //   $kondisi = "AND (coaching.company_id = $company_id OR coaching.created_by = $user_id)";
    // } else if ($role_id == 2) { // Head
    //   $kondisi = "AND coaching.department_id = $department_id";
    // } else if ($role_id == 3) { // Manager
    //   $kondisi = "AND ((coaching.department_id = $department_id OR kary.ctm_report_to = $user_id) AND (coaching.role_id NOT IN (1,2,3,10) OR coaching.created_by = $user_id))";
    // } else if ($role_id == 4) { // Ass Manager
    //   $kondisi = "AND coaching.department_id = $department_id AND (coaching.role_id NOT IN (1,2,3,4,10) OR coaching.created_by = $user_id)";
    // } else if ($user_id == 3325 || $user_id == 5336 || $user_id == 5078) { // budiman1835, farouq3286, aisyah3066
    //   $kondisi = "AND (coaching.created_by = $user_id OR coaching.company_id = 2)";
    // } else if ($user_id == 329) { // ratih
    //   $kondisi = "AND (coaching.created_by = $user_id OR coaching.department_id IN (25,120,154,155))";
    // } else if ($user_id == 70) { // nining27
    //   $kondisi = "AND (coaching.created_by = $user_id OR coaching.company_id IN (1,4,5))";
    // } else {
    //   $kondisi = "AND coaching.created_by = $user_id";
    // }

    // if ($user_id == 7731) { // Dimas Nurulloh
    //   $kondisi = "AND (coaching.created_by = $user_id OR coaching.department_id IN (106,142,183))";
    // }

    // if ($user_id == 2735) { // Siti Cahyati
    //   $kondisi = "AND (coaching.created_by IN ($user_id,6736) OR coaching.department_id IN (142,204,205,206,207,210,211))";
    // }

    return $this->db->query("SELECT
                              one.id_one,
                              CONCAT( em.first_name, ' ', em.last_name ) AS karyawan,
                              one.tempat,
                              one.tanggal,
                              CONCAT( ats.first_name, ' ', ats.last_name ) AS atasan,
                              COALESCE(one.foto,'') AS foto,
                              com.`name` AS company_name,
                              dp.department_name,
                              dg.designation_name,
                              one.created_at,
                              CONCAT( cb.first_name, ' ', cb.last_name ) AS created_by 
                            FROM
                              one_header AS one
                              LEFT JOIN xin_employees AS cb ON cb.user_id = one.created_by
                              LEFT JOIN xin_employees AS ats ON ats.user_id = one.atasan
                              LEFT JOIN xin_employees AS em ON em.user_id = one.karyawan
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = one.designation_id
                              LEFT JOIN xin_departments AS dp ON dp.department_id = one.department_id
                              LEFT JOIN xin_companies AS com ON com.company_id = one.company_id 
                            WHERE
                              DATE ( one.created_at ) BETWEEN '$start' 
                              AND '$end'")->result();
  }

  function get_list_indikator($id_one,$id)
  {
    return $this->db->query("SELECT
                              m.id,
                              m.indikator,
                              COALESCE(ind.actual,0) AS	actual,
                              COALESCE(ind.target,0) AS `target`
                            FROM
                              one_m_indikator AS m
                              LEFT JOIN one_indikator AS ind ON ind.indikator = m.id 
                              AND ind.id_one = '$id_one'
                            WHERE
                              m.id = $id
                            LIMIT 1")->row_array();
  }

  function get_list_indikator_item($id_one,$id)
  {
    return $this->db->query("SELECT
                              m.id,
                              COALESCE(item.identifikasi,'-') AS identifikasi,
                              COALESCE(item.solusi,'-') AS solusi,
                              COALESCE(item.target_solusi,'-') AS target_solusi,
                              COALESCE(item.deadline_solusi,'-') AS deadline_solusi,
                              COALESCE(item.komitmen,'-') AS komitmen
                            FROM
                              one_m_indikator AS m
                              LEFT JOIN one_indikator_item AS item ON item.indikator = m.id 
                              AND item.id_one = '$id_one'
                            WHERE
                              m.id = $id")->result();
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
  
  // One on One
  function generate_id_one()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( id_one, 4 ) ) AS kd_max 
                              FROM
                                one_header 
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

    return 'ONE' . date('ymd') . $kd;
  }

  function check_header($id_one)
  {
    return $this->db->query("SELECT * FROM one_header WHERE id_one = '$id_one'")->num_rows();
  }

  function check_indikator($id_one,$indikator)
  {
    return $this->db->query("SELECT * FROM one_indikator WHERE id_one = '$id_one' AND indikator = '$indikator'")->num_rows();
  }
  
  function get_list_feedback($id_one,$id_indikator)
  {
    return $this->db->query("SELECT * FROM one_indikator_item WHERE id_one = '$id_one' AND indikator = $id_indikator")->result();
  }

  function get_indikator_sales($user_id,$designation_id,$id_user)
  {
    return $this->db->query("SELECT
                              m.id,
                              m.indikator,
                            CASE
                                WHEN lbr.designation_id = 1448 THEN
                              IF
                                ( m.target_salesman = 3,( lbr.kerja * m.target_sales ), m.target_salesman ) 
                                WHEN lbr.designation_id = 1512 THEN
                              IF
                                ( m.target_junior_salesman = 3,( lbr.kerja * m.target_sales ), m.target_junior_salesman ) ELSE
                              IF
                                ( m.target_sales = 3,( lbr.kerja * m.target_sales ), m.target_sales ) 
                              END AS `target`,
                              COALESCE ( bk.booking, ck.ceklok, db.`database`, fu.follow_up, 0 ) AS actual 
                            FROM
                              hris.one_m_indikator AS m
                              LEFT JOIN (
                              SELECT
                                1 AS id,
                                COUNT( bk.id_gci ) AS booking,
                                $user_id AS id_hr 
                              FROM
                                rsp_project_live.t_gci AS bk 
                              WHERE
                                bk.id_kategori = 3 
                                AND LEFT ( bk.created_at, 7 ) = LEFT(CURDATE(),7) 
                                AND bk.id_user = $id_user 
                              ) AS bk ON bk.id = m.id
                              LEFT JOIN (
                              SELECT
                                2 AS id,
                                COUNT( db.id_gci ) AS `database`,
                                $user_id AS id_hr 
                              FROM
                                rsp_project_live.t_gci AS db 
                              WHERE
                                db.id_kategori = 1 
                                AND LEFT ( db.created_at, 7 ) = LEFT(CURDATE(),7) 
                                AND db.id_user = $id_user 
                              ) AS db ON db.id = m.id
                              LEFT JOIN (
                              SELECT
                                3 AS id,
                                ROUND( COUNT( mkt.id_gci )/ COUNT( fu.id_gci )* 100, 0 ) AS follow_up,
                                $user_id AS id_hr 
                              FROM
                                rsp_project_live.t_gci AS fu
                                LEFT JOIN rsp_project_live.t_gci_fu AS mkt ON mkt.id_gci = fu.id_gci 
                              WHERE
                                fu.id_kategori = 1 
                                AND LEFT ( fu.created_at, 7 ) = LEFT(CURDATE(),7) 
                                AND fu.id_user = $id_user 
                              ) AS fu ON fu.id = m.id
                              LEFT JOIN (
                              SELECT
                                4 AS id,
                                COALESCE ( ROUND( COUNT( mkt.id_gci )/ COUNT( fu.id_gci )* 100, 0 ), 0 ) AS ceklok,
                                $user_id AS id_hr 
                              FROM
                                rsp_project_live.t_gci AS fu
                                LEFT JOIN rsp_project_live.t_gci_fu AS mkt ON mkt.id_gci = fu.id_gci 
                                AND mkt.fu_sales IN ( 'Ceklok', 'Booking' ) 
                              WHERE
                                fu.id_kategori = 1 
                                AND LEFT ( fu.created_at, 7 ) = LEFT ( CURDATE(), 7 ) 
                                AND fu.id_user = $id_user 
                              ) AS ck ON ck.id = m.id
                              LEFT JOIN (
                              SELECT
                                2 AS id,
                                $designation_id AS designation_id,
                                COUNT( employee_id ) AS kerja 
                              FROM
                                xin_attendance_time 
                              WHERE
                                employee_id = $user_id 
                                AND LEFT ( attendance_date, 7 ) = LEFT ( CURDATE(), 7 )
                              ) AS lbr ON lbr.id = m.id")->result();
  }

  function get_resume($start,$end)
  {
    return $this->db->query("SELECT
                              hd.karyawan AS user_id,
                              CONCAT(em.first_name,' ',em.last_name) AS karyawan,
                              hd.tanggal,
                              ind.id_one,
                              ind.indikator AS id_indikator,
                              m.indikator,
                              ind.target,
                              ind.actual,
                              COALESCE(itm.identifikasi,'-') AS identifikasi,
                              COALESCE(itm.solusi,'-') AS solusi,
                              COALESCE(itm.target_solusi,'-') AS target_solusi,
                              COALESCE(itm.deadline_solusi,'-') AS deadline_solusi,
                              COALESCE(itm.komitmen,'-') AS komitmen
                            FROM
                              one_indikator AS ind
                              JOIN one_header AS hd ON hd.id_one = ind.id_one
                              LEFT JOIN xin_employees AS em ON em.user_id = hd.karyawan
                              JOIN one_m_indikator AS m ON m.id = ind.indikator
                              LEFT JOIN one_indikator_item AS itm ON itm.id_one = ind.id_one AND itm.indikator = ind.indikator
                            WHERE
                              hd.tanggal BETWEEN '$start' AND '$end'")->result();
  }

  function get_resume_sales($start,$end)
  {    
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $company_id     = $_SESSION['company_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    // Role : Ass BM / SPV
    if ($role_id == 1) {
      $kondisi = "";
    } else if ($role_id == 3) {
      $kondisi = " AND bm.join_hr = $user_id";
    } else if (in_array($role_id, array(4,5))) {
      $kondisi = " AND spv.join_hr = $user_id";
    } else {
      $kondisi = " AND rsp.join_hr = $user_id";
    }

    return $this->db->query("SELECT
                              mkt.id_user,
                              mkt.sales,
                              mkt.spv,
                              mkt.bm,
                              mkt.tgt_booking,
                              COALESCE ( gci.booking, 0 ) AS booking,
                              ( lbr.kerja * 3 ) AS tgt_db,
                              COALESCE ( gci.db, 0 ) AS db,
                              100 AS tgt_fu,
                              fu.fu,
                              fu.p_fu,
                              100 AS tgt_ceklok,
                              ck.ceklok,
                              ck.p_ceklok,
                              COALESCE(one.total_one,0) AS one
                            FROM
                              (
                              SELECT
                                1 AS id,
                                rsp.id_user,
                                rsp.join_hr AS id_hr,
                                rsp.employee_name AS sales,
                                spv.employee_name AS spv,
                                bm.employee_name AS bm,
                              CASE
                                  hr.designation_id 
                                  WHEN 1448 THEN
                                  4 
                                  WHEN 1512 THEN
                                  3 ELSE 2 
                                END tgt_booking 
                            FROM
                              rsp_project_live.`user` AS rsp
                              JOIN hris.xin_employees AS hr ON hr.user_id = rsp.join_hr
                              JOIN rsp_project_live.`user` AS spv ON spv.id_user = rsp.spv
                              JOIN rsp_project_live.`user` AS bm ON bm.id_user = rsp.id_manager 
                            WHERE
                              rsp.id_divisi IN ( 2, 20 ) 
                              AND rsp.isActive = 1 
                              AND rsp.id_user <> rsp.spv 
                              AND rsp.id_user <> rsp.id_manager 
                              AND rsp.id_user <> rsp.id_gm 
                              $kondisi
                              ) AS mkt
                              LEFT JOIN (
                              SELECT
                                bk.id_user AS id_user,
                                COUNT( IF ( bk.id_kategori = 3, 1, NULL ) ) AS booking,
                                COUNT( IF ( bk.id_kategori = 1, 1, NULL ) ) AS db 
                              FROM
                                rsp_project_live.t_gci AS bk 
                              WHERE
                                LEFT ( bk.created_at, 7 ) = LEFT ( CURDATE(), 7 ) 
                                AND bk.id_user <> 1 
                              GROUP BY
                                bk.id_user 
                              ORDER BY
                                bk.id_user 
                              ) AS gci ON gci.id_user = mkt.id_user
                              LEFT JOIN (
                              SELECT
                                gci.id_user,
                                COUNT( gci.id_gci ) AS db,
                                COUNT( fu.id_gci ) AS fu,
                                ROUND( COUNT( fu.id_gci )/ COUNT( gci.id_gci )* 100, 0 ) AS p_fu 
                              FROM
                                rsp_project_live.t_gci AS gci
                                LEFT JOIN rsp_project_live.t_gci_fu AS fu ON fu.id_gci = gci.id_gci 
                              WHERE
                                gci.id_kategori = 1 
                                AND LEFT ( gci.created_at, 7 ) = LEFT ( CURDATE(), 7 ) 
                              GROUP BY
                                gci.id_user 
                              ORDER BY
                                gci.id_user 
                              ) AS fu ON fu.id_user = mkt.id_user
                              LEFT JOIN (
                              SELECT
                                gci.id_user,
                                COUNT( gci.id_gci ) AS db,
                                COUNT( ck.id_gci ) AS ceklok,
                                COALESCE ( ROUND( COUNT( ck.id_gci )/ COUNT( gci.id_gci )* 100, 0 ), 0 ) AS p_ceklok 
                              FROM
                                rsp_project_live.t_gci AS gci
                                LEFT JOIN rsp_project_live.t_gci_fu AS ck ON ck.id_gci = gci.id_gci 
                                AND ck.fu_sales IN ( 'Ceklok', 'Booking' ) 
                              WHERE
                                gci.id_kategori = 1 
                                AND LEFT ( gci.created_at, 7 ) = LEFT ( CURDATE(), 7 ) 
                              GROUP BY
                                gci.id_user 
                              ORDER BY
                                gci.id_user 
                              ) AS ck ON ck.id_user = mkt.id_user
                              LEFT JOIN (
                              SELECT
                                1 AS id,
                                COUNT( employee_id ) AS kerja 
                              FROM
                                xin_attendance_time 
                              WHERE
                                employee_id = $user_id 
                                AND LEFT ( attendance_date, 7 ) = LEFT ( CURDATE(), 7 )
                              ) AS lbr ON lbr.id = mkt.id
                              LEFT JOIN (
                              SELECT
                                karyawan AS id_hr,
                                COUNT( karyawan ) AS total_one 
                              FROM
                                one_header 
                              WHERE
                                LEFT ( tanggal, 7 ) = LEFT ( CURDATE(), 7 ) 
                              GROUP BY
                              karyawan 
                              ) AS one ON one.id_hr = mkt.id_hr")->result();
  }
}
