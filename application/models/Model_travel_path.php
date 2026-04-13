<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_travel_path extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  // New
  function generate_id_travel_path()
  {
    $q = $this->db->query("SELECT
                            MAX( RIGHT ( id_tp, 4 ) ) AS kd_max 
                          FROM
                            tp_travel_path 
                          WHERE
                            DATE ( created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%04s", $tmp);
      }
    } else {
      $kd = "0001";
    }

    return 'TP' . date('ymd') . $kd;
  }
 
  function list_path($start,$end)
  {
    $company_id       = $_SESSION['company_id'];
    $department_id    = $_SESSION['department_id'];
    $designation_id   = $_SESSION['designation_id'];
    $user_id          = $_SESSION['user_id'];
    $user_role_id     = $_SESSION['user_role_id'];

    if ($user_id == 2041 || $user_role_id == 1) {
      $kondisi = "";
    } else {
      $kondisi = "AND company_id = $company_id
                  AND department_id = $department_id
                  AND (FIND_IN_SET($designation_id,designation_id) OR FIND_IN_SET($user_id,user_id))";
    }

    return $this->db->query("SELECT
                              m.*,
                              tp.`status`,
                              tp.`week`,
                              tp.periode,
                              tp.created_at,
                              prd.periode
                            FROM
                              tp_m_point AS m
                              JOIN tp_m_point_periode AS prd ON prd.id = m.id
                              LEFT JOIN tp_travel_path AS tp ON tp.point_id = m.id AND tp.periode = prd.periode AND tp.created_by = $user_id
                            WHERE
                              prd.periode = LEFT('$start',7)
                              $kondisi")->result();
  }

  function get_detail_path($id)
  {
    $user_id = $_SESSION['user_id'];
    return $this->db->query("SELECT
                              `path`.standar,
                              LEFT(`path`.`start`,5) AS `start`,
                              LEFT(`path`.`end`,5) AS `end`,
                              `path`.no_urut,
                              kat.id_point,
                              kat.category,
                              item.updated_by,
                              IF(item.updated_by IS NULL,'','completed') AS sts,
                              item.tp_id,
                              item.path_id,
                              item.travel_path
                            FROM
                              tp_m_path AS `path`
                              JOIN tp_m_category AS kat ON `path`.category_id = kat.id
                              LEFT JOIN tp_travel_path_item AS item ON item.path_id = `path`.id_path
                              LEFT JOIN tp_travel_path AS tp ON tp.id_tp = item.tp_id AND tp.point_id = kat.id_point
                            WHERE
                              kat.id_point = $id
                              AND tp.created_by = $user_id")->result();
  }

  function get_detail_travel_path($tp_id,$path_id)
  {
    return $this->db->query("SELECT
                              item.travel_path,
                              `path`.standar,
                              `path`.`start`,
                              `path`.`end`,
                              `path`.no_urut,
                              kat.category,
                              COALESCE(item.`status`,'#') AS `status`,
                              CASE
                                WHEN item.keputusan IS NOT NULL THEN
                                'Keputusan'
                                WHEN item.regulasi IS NOT NULL THEN
                                'Regulasi' ELSE '#' 
                              END AS tipe,
                              COALESCE(item.keputusan,item.regulasi) AS note,
                              item.evaluasi,
                              item.foto
                            FROM
                              tp_travel_path_item AS item
                              JOIN tp_m_path AS `path` ON `path`.id_path = item.path_id
                              JOIN tp_m_category AS kat ON kat.id = `path`.category_id
                            WHERE
                              item.tp_id = '$tp_id' 
                              AND item.path_id = '$path_id'")->row_array();
  }

  function get_master_path($id)
  {
    return $this->db->query("SELECT
                              * 
                            FROM
                              tp_m_path AS pt
                              JOIN tp_m_category AS kt ON kt.id = pt.category_id 
                            WHERE
                              kt.id_point = $id")->result();
  }

  function check_travel_path()
  {
    $user_id = $_SESSION['user_id'];

    return $this->db->query("SELECT * FROM tp_travel_path WHERE LEFT(created_at,7) = LEFT(CURDATE(),7) AND created_by = $user_id")->num_rows();
  }
  // End New
  
  function list_proses()
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];

    $list_super     = [1139,8892,8970,70]; // Viky, Lintang, Nining27

    // Super Admin & Tambahan
    if ($role_id == 1 || in_array($user_id,$list_super)) {
      $kondisi = "";
    } else {
      $kondisi = "AND gemba.created_by = $user_id";
    }

    return $this->db->query("SELECT
                              gemba.id_gemba,
                              gemba.tgl_plan,
                              gemba.tipe_gemba AS id_gemba_tipe,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              gemba.evaluasi,
                              gemba.peserta,
                              gemba.created_at,
                              CONCAT( em.first_name, ' ', em.last_name ) AS created_by,
                              gemba.updated_at,
                              CONCAT( up.first_name, ' ', up.last_name ) AS updated_by 
                            FROM
                              gemba
                              JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                              LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                              LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by 
                            WHERE
                              (item.total_progres > 0 OR gemba.evaluasi IS NULL) $kondisi")->result();
  }
  
  function get_detail_gemba($id_gemba)
  {
    return $this->db->query("SELECT
                              item.id_gemba,
                              item.id_gemba_ceklis,
                              cek.concern,
                              cek.monitoring,
                              IF(item.id_gemba_ceklis %2 = 0,'primary','info') AS warna
                            FROM
                              gemba_item AS item
                              JOIN gemba_ceklis AS cek ON cek.id = item.id_gemba_ceklis
                            WHERE
                              item.id_gemba = '$id_gemba' 
                              AND item.`status` IS NULL")->result();
  }
  
  function get_detail_evaluasi($id_gemba)
  {
    return $this->db->query("SELECT
                              gemba.id_gemba,
                              DATE_FORMAT( gemba.tgl_plan, '%d %M %Y' ) AS tgl_plan,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              COALESCE ( gemba.evaluasi, '' ) AS evaluasi,
                              COALESCE ( gemba.peserta, '' ) AS peserta,
                              gemba.`status`
                            FROM
                              gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                            WHERE
                              gemba.id_gemba = '$id_gemba'")->row_array();
  }
  
  function list_gemba($start,$end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super       = [1139,8892,8970,70,2,5197,2951,5086,5385,2729,68]; // Viky, Lintang, Nining27, Ali95, hience3160, alfin3333, saeroh, Farhan63
    $list_designation = [1217,1218]; // HRBP Manager, Officer

    // Super Admin & Tambahan
    if ($role_id == 1 || in_array($user_id,$list_super) || in_array($designation_id,$list_designation)) {
      $kondisi = "";
    } else if ($role_id == 2) { // Head
      $kondisi = "AND em.department_id = $department_id";
    } else if ($role_id == 3) { // Manager
      $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (4,5) OR gemba.created_by = $user_id)";
    } else if ($role_id == 4) { // Ass Manager
      $kondisi = "AND em.department_id = $department_id AND (em.user_role_id IN (5) OR gemba.created_by = $user_id)";
    } else if ($user_id == 70) { // Nining27
      $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (4,5))";
    } else if ($user_id == 3325 || $user_id == 5336) { // budiman1835, farouq3286
      $kondisi = "AND (gemba.created_by = $user_id OR em.company_id IN (2))";
    } else {
      $kondisi = "AND gemba.created_by = $user_id";
    }

    return $this->db->query("SELECT
                              gemba.id_gemba,
                              gemba.tgl_plan,
                              gemba.tipe_gemba AS id_gemba_tipe,
                              tp.tipe_gemba,
                              gemba.lokasi,
                              gemba.evaluasi,
                              gemba.peserta,
                              gemba.created_at,
                              CONCAT(em.first_name,' ',em.last_name) AS created_by,
                              gemba.updated_at,
                              CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                              IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'Waiting Completed','Completed') AS `status`,
                              IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'warning','success') AS color,
                              sts.`status` AS status_akhir,
                              sts.`color` AS color_akhir
                            FROM
                              gemba
                              JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                              JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                              LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                              LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
                              JOIN td_status_strategy AS sts ON sts.id = gemba.`status`
                            WHERE gemba.tgl_plan BETWEEN '$start' AND '$end' $kondisi")->result();
  }

  function get_result_gemba($id_gemba)
  {
    return $this->db->query("SELECT
                              item.id_gemba,
                              cek.concern,
                              cek.monitoring,
                              item.`status`,
                              COALESCE(item.file,'') AS `file`,
                              COALESCE(item.link,'') AS link,
                              item.updated_at,
                              CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                              IF(`status` IS NULL,'Waiting','Done') AS status_item,
                              IF(`status` IS NULL,'warning','success') AS warna_item
                            FROM
                              gemba_item AS item
                              JOIN gemba_ceklis AS cek ON cek.id = item.id_gemba_ceklis 
                              LEFT JOIN xin_employees AS up ON up.user_id = item.updated_by
                            WHERE
                              item.id_gemba = '$id_gemba'")->result();
  }

  function get_status_strategy()
  {
    return $this->db->query("SELECT id, `status` FROM td_status_strategy")->result();
  }
}
