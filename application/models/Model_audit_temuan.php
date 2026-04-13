<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_audit_temuan extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_id_findings()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( audit_temuan.id_temuan, 4 ) ) AS kd_max 
                              FROM
                                audit_temuan 
                              WHERE
                                DATE( audit_temuan.created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return 'AUD' . date('ymd') . $kd;
  }

  function get_department()
  {
    return $this->db->query("SELECT
                              dep.department_id,
                              dep.department_name,
                              dep.company_id,
                              comp.`name` AS company_name,
                              CONCAT(dep.department_name,' | ',comp.`name`) AS show_name
                            FROM
                              xin_departments AS dep
                              JOIN xin_companies AS comp ON comp.company_id = dep.company_id
                            WHERE
                              dep.hide = 0")->result();
  }

  function get_karyawan($dep_id)
  {
    return $this->db->query("SELECT
                              em.user_id,
                              CONCAT( em.first_name, ' ', em.last_name ) AS employee_name 
                            FROM
                              xin_employees AS em 
                            WHERE
                              em.is_active = 1 
                              AND em.user_id <> 1 
                              AND em.department_id = $dep_id");
  }

  function get_aturan($dep_id)
  {
    return $this->db->query("SELECT
                              id_sop,
                              nama_dokumen
                            FROM
                              trusmi_sop 
                            WHERE
                              department = $dep_id 
                              AND nama_dokumen IS NOT NULL 
                              AND nama_dokumen != '' 
                            GROUP BY
                              nama_dokumen 
                            ORDER BY
                              nama_dokumen ASC");
  }

  function list_findings($start, $end, $id_temuan = null)
  {
    // $user_id        = $_SESSION['user_id'];
    // $role_id        = $_SESSION['user_role_id'];
    // $company_id     = $_SESSION['company_id'];
    // $department_id  = $_SESSION['department_id'];
    // $designation_id = $_SESSION['designation_id'];

    // $list_super       = [1139,8892,2,5197,5086,5385,2729];   // Viky, Lintang, Ali95, hience3160, alfin3333, saeroh
    // $list_department  = [117,1,72,73,156,157,167];
    // $list_designation = [1217,1218]; // HRBP Manager, Officer

    // if ($role_id == 1 || in_array($user_id,$list_super) || $department_id == 1 || in_array($designation_id,$list_designation)) { // Super Admin, or HR Holding
    //   $kondisi = "";
    // } else if ( in_array($department_id,$list_department)) { // HR sesuai Company
    //   $kondisi = "AND (coaching.company_id = $company_id OR coaching.created_by = $user_id)";
    // } else if ($role_id == 2) { // Head
    //   $kondisi = "AND coaching.department_id = $department_id";
    // } else if ($role_id == 3) { // Manager
    //   $kondisi = "AND coaching.department_id = $department_id AND (coaching.role_id NOT IN (1,2,3,10) OR coaching.created_by = $user_id)";
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


    $user_id = $this->session->userdata('user_id');
    $condition = " AND head.user_id = $user_id OR aud.created_by = $user_id";
    if ($user_id == 1 || $user_id == 4498) {
      $condition = '';
    }

    // najmatul1273
    if ($user_id == 2521) {
      $condition = " AND (head.user_id = $user_id OR aud.created_by IN ($user_id,4134,3609))";
    }

    if ($id_temuan != null) {
      $kondisi = "aud.id_temuan = '$id_temuan'";
    } else {
      $kondisi = "DATE( aud.created_at ) BETWEEN '$start' AND '$end' $condition";
    }

    return $this->db->query("SELECT
                              aud.id_temuan,
                              aud.category,
                              aud.id_divisi AS department_id,
                              dp.department_name AS divisi,
                              aud.company_id,
                              com.`name` AS company_name,
                              aud.employee_id,
                              CONCAT( em.first_name, ' ', em.last_name ) AS employee_name,
                              aud.proses_kerja,
                              aud.sub_proses_kerja,
                              aud.temuan,
                              aud.root_cause,
                              aud.tanggal_kejadian,
                              aud.aturan_sop,
                              sop.nama_dokumen,
                              CONCAT( audit.first_name, ' ', audit.last_name ) AS auditor,
                              aud.created_at AS waktu_input,
                              aud.`status`,
                              sts.`status` AS status_temuan,
                              sts.color_status,
                              COALESCE(aud.level_temuan,'') AS level_temuan,
                              REPLACE ( alat.alat_bukti, ',', ', ' ) AS alat_bukti,
                              REPLACE ( lampiran.lampiran, ',', ', ' ) AS lampiran,
                              aud.tanggal_tanggapan,
                              aud.feedback,
                              aud.lampiran_feedback,
                              aud.keterangan_pic,
                              aud.tanggal_keterangan_pic,
                              COALESCE(sts_cr.`status`,'') AS status_corrective,
                              aud.corrective,
                              aud.deadline_corrective,
                              COALESCE(aud.lampiran_corrective,'') AS lampiran_corrective,
                              COALESCE(sts_pm.`status`,'') AS status_preventif,
                              aud.preventif,
                              COALESCE(aud.lampiran_preventif,'') AS lampiran_preventif,
                              aud.deadline_preventif,
                              aud.id_plan
                            FROM
                              audit_temuan AS aud
                              JOIN xin_employees AS em ON em.user_id = aud.employee_id
                              JOIN xin_employees AS audit ON audit.user_id = aud.created_by
                              LEFT JOIN xin_departments dep ON dep.department_id = audit.department_id
					                    LEFT JOIN xin_employees head ON head.user_id = dep.head_id
                              JOIN xin_departments AS dp ON dp.department_id = aud.id_divisi
                              JOIN xin_companies AS com ON com.company_id = dp.company_id
                              LEFT JOIN trusmi_sop AS sop ON sop.id_sop = aud.aturan_sop
                              JOIN audit_status_temuan AS sts ON sts.id = aud.`status`
                              LEFT JOIN audit_status_temuan AS kat ON kat.id = aud.category
                              LEFT JOIN ( SELECT id_temuan, GROUP_CONCAT( alat_bukti ) AS alat_bukti FROM audit_alat_bukti_temuan GROUP BY id_temuan ) AS alat ON alat.id_temuan = aud.id_temuan
                              LEFT JOIN ( SELECT id_temuan, GROUP_CONCAT( lampiran ) AS lampiran FROM audit_lampiran_temuan GROUP BY id_temuan ) AS lampiran ON lampiran.id_temuan = aud.id_temuan
                              LEFT JOIN audit_status_temuan AS sts_cr ON sts_cr.id = aud.`status_corrective`
                              LEFT JOIN audit_status_temuan AS sts_pm ON sts_pm.id = aud.`status_preventif`
                            WHERE
                              $kondisi")->result();
  }


  function get_send_wa($id_temuan)
  {
    $query = "SELECT
                aud.id_temuan,
                MD5(aud.id_temuan) AS kode_temuan,
                aud.employee_id,
                em.employee_name,
                IF ( LEFT ( em.contact, 1 ) = 0, CONCAT( '62', SUBSTR( em.contact, 2 )), em.contact ) AS employee_contact,
                aud.id_divisi AS department_id,
                dp.department_name,
                COALESCE(dp.head_id,'') AS head_id,
                IF ( LEFT ( hd.contact, 1 ) = 0, CONCAT( '62', SUBSTR( hd.contact, 2 )), hd.contact ) AS head_contact,
                aud.temuan,
                aud.tanggal_kejadian,
                aud.category,
                COALESCE(aud.level_temuan,'') AS level_temuan,
                aud.created_by AS auditor_id,
                audit.employee_name AS auditor,
                IF ( LEFT ( audit.contact, 1 ) = 0, CONCAT( '62', SUBSTR( audit.contact, 2 )), audit.contact ) AS auditor_contact
              FROM
                audit_temuan AS aud
                JOIN (
                SELECT
                  user_id,
                  CONCAT( first_name, ' ', last_name ) AS employee_name,
                  REPLACE ( REPLACE ( REPLACE ( contact_no, '-', '' ), ' ', '' ), '+', '' ) AS contact 
                FROM
                  xin_employees 
                WHERE
                  is_active = 1 
                ) AS em ON em.user_id = aud.employee_id
                JOIN (
                SELECT
                  user_id,
                  CONCAT( first_name, ' ', last_name ) AS employee_name,
                  REPLACE ( REPLACE ( REPLACE ( contact_no, '-', '' ), ' ', '' ), '+', '' ) AS contact 
                FROM
                  xin_employees 
                WHERE
                  is_active = 1 
                ) AS `audit` ON audit.user_id = aud.created_by
                JOIN xin_departments AS dp ON dp.department_id = aud.id_divisi
                LEFT JOIN (
                SELECT
                  user_id AS head_id,
                  username,
                  REPLACE ( REPLACE ( REPLACE ( contact_no, '-', '' ), ' ', '' ), '+', '' ) AS contact,
                  user_role_id 
                FROM
                  xin_employees 
                WHERE
                  is_active = 1 
                  AND user_role_id < 6 
                ) AS hd ON hd.head_id = dp.head_id 
              WHERE
                aud.id_temuan = '$id_temuan'";

    return $this->db->query($query);
  }

  function get_detail_feedback($id_temuan, $ket = null)
  {
    if ($ket != null) {
      $kondisi = "aud.id_temuan = '$id_temuan'";
    } else {
      $kondisi = "MD5( aud.id_temuan ) = '$id_temuan'";
    }
    return $this->db->query("SELECT
                              aud.id_temuan,
                              MD5( aud.id_temuan ) AS kode_temuan,
                              aud.employee_id,
                              CONCAT( em.first_name, ' ', em.last_name ) AS employee_name,
                              em.designation_id,
                              dg.designation_name,
                              aud.id_divisi AS department_id,
                              dp.department_name,
                              dp.company_id,
                              comp.`name` AS company_name,
                              aud.temuan,
                              aud.category,
                              COALESCE(aud.level_temuan,'-') AS level_temuan,
                              aud.tanggal_kejadian,
                              aud.root_cause,
                              REPLACE ( alat.alat_bukti, ',', ', ' ) AS alat_bukti,
                              REPLACE ( lampiran.lampiran, ',', ', ' ) AS lampiran,
                              aud.created_by AS auditor_id,
                              CONCAT( audit.first_name, ' ', audit.last_name ) AS auditor,
                              aud.created_at AS auditor_at,
                              aud_dg.designation_name AS auditor_designation,
                              aud.`status` AS id_status,
                              sts.`status`,
                              sts.color_status,
                              aud.feedback,
                              COALESCE(aud.status_corrective,'#') AS status_corrective,
                              COALESCE(sts_cr.`status`,'') AS sts_corrective,
                              aud.corrective,
                              aud.deadline_corrective,
                              COALESCE(aud.status_preventif,'#') AS status_preventif,
                              COALESCE(sts_pm.`status`,'') AS sts_preventif,
                              aud.preventif,
                              aud.deadline_preventif,
                              aud.tanggal_tanggapan,
                              DATEDIFF(CURDATE(),DATE(aud.created_at)) AS leadtime_feedback,
                              COALESCE(aud.keterangan_pic,'') AS keterangan_pic,
                              aud.lampiran_feedback,
                              aud.lampiran_corrective,
                              aud.lampiran_preventif
                            FROM
                              audit_temuan AS aud
                              JOIN xin_employees AS em ON em.user_id = aud.employee_id
                              JOIN xin_designations AS dg ON dg.designation_id = em.designation_id
                              JOIN xin_employees AS `audit` ON audit.user_id = aud.created_by
                              JOIN xin_designations AS aud_dg ON aud_dg.designation_id = audit.designation_id
                              JOIN xin_departments AS dp ON dp.department_id = aud.id_divisi
                              LEFT JOIN xin_companies AS comp ON comp.company_id = dp.company_id
                              LEFT JOIN ( SELECT id_temuan, GROUP_CONCAT( alat_bukti ) AS alat_bukti FROM audit_alat_bukti_temuan GROUP BY id_temuan ) AS alat ON alat.id_temuan = aud.id_temuan
                              LEFT JOIN ( SELECT id_temuan, GROUP_CONCAT( lampiran ) AS lampiran FROM audit_lampiran_temuan GROUP BY id_temuan ) AS lampiran ON lampiran.id_temuan = aud.id_temuan 
                              JOIN audit_status_temuan AS sts ON sts.id = aud.`status`
                              LEFT JOIN audit_status_temuan AS sts_cr ON sts_cr.id = aud.`status_corrective`
                              LEFT JOIN audit_status_temuan AS sts_pm ON sts_pm.id = aud.`status_preventif`
                            WHERE
                              $kondisi")->row_array();
  }

  function get_status_feedback()
  {
    return $this->db->query("SELECT id, `status` FROM audit_status_temuan WHERE id IN (2,5,6)")->result();
  }

  function get_status_corrective()
  {
    return $this->db->query("SELECT id, `status` FROM audit_status_temuan WHERE id IN (5,6)")->result();
  }

  function get_status_preventive()
  {
    return $this->db->query("SELECT id, `status` FROM audit_status_temuan WHERE id IN (7,8,9)")->result();
  }

  function get_status_audit()
  {
    return $this->db->query("SELECT id, `status` FROM audit_status_temuan WHERE id IN (3,4,10)")->result();
  }

  function get_send_wa_keterangan($id_temuan)
  {
    return $this->db->query("SELECT
                              aud.id_temuan,
                              aud.`status` AS id_status,
                              aud.employee_id,
                              aud.category,
                              em.employee_name,
                              IF ( LEFT ( em.contact, 1 ) = 0, CONCAT( '62', SUBSTR( em.contact, 2 )), em.contact ) AS employee_contact,
                              aud.keterangan_pic 
                            FROM
                              audit_temuan AS aud
                              JOIN (
                              SELECT
                                user_id,
                                CONCAT( first_name, ' ', last_name ) AS employee_name,
                                REPLACE ( REPLACE ( REPLACE ( contact_no, '-', '' ), ' ', '' ), '+', '' ) AS contact 
                              FROM
                                xin_employees 
                              WHERE
                                is_active = 1 
                              ) AS em ON em.user_id = aud.employee_id 
                            WHERE
                              aud.id_temuan = '$id_temuan'");
  }
  function get_plan($plan = null)
  {
    if ($plan != null) {
      $sub_query = "WHERE id_plan = '$plan'";
    } else {
      $sub_query = '';
    }
    $query = "SELECT * FROM t_audit_plan_monthly $sub_query;";
    return $this->db->query($query)->result();
  }
}
