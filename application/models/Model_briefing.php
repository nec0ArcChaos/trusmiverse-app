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
        $tmp = ((int) $k->kd_max) + 1;
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
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['user_role_id'];
    $company_id = $_SESSION['company_id'];
    $department_id = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_super = [1139, 8892, 8970, 2, 5197, 5086, 5385, 2729, 68, 2903, 6408, 7731, 10214, 10127, 4498, 7731, 10404, 11664, 11665];   // Viky, Lintang, Ali95, hience3160, farrel3072,alfin3333,saeroh,farhan, od rsp, moch5508, pujaannicha8053
    $list_department = [117, 1, 72, 73, 156, 157, 167];
    $list_designation = [1217, 1218]; // HRBP Manager, Officer

    if ($role_id == 1 || in_array($user_id, $list_super) || $department_id == 1 || in_array($designation_id, $list_designation)) { // Super Admin, or HR Holding
      $kondisi = "";
    } else if (in_array($department_id, $list_department)) { // HR sesuai Company
      $kondisi = "AND (briefing.company_id = $company_id OR briefing.created_by = $user_id)";
      if ($user_id == 11372) { // soniyanto8949
        $kondisi = "AND (briefing.company_id = $company_id OR briefing.created_by IN (9621, 10176, 10168, $user_id))";
      }
    } else if ($role_id == 2) { // Head
      $kondisi = "AND briefing.department_id = $department_id";
    } else if ($role_id == 3) { // Manager
      $kondisi = "AND briefing.department_id = $department_id AND (briefing.role_id IN (4,5) OR briefing.created_by = $user_id)";
    } else if ($role_id == 4) { // Ass Manager
      $kondisi = "AND briefing.department_id = $department_id AND (briefing.role_id IN (5) OR briefing.created_by = $user_id)";
    } else if ($user_id == 3325 || $user_id == 5336) { // budiman1835,farouq3286
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.company_id = 2)";
    } else if ($user_id == 2735) { // siticahyati
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (106))";
    } else if ($user_id == 329) { // ratih
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (25,120,154,155))";
    } else if ($user_id == 2505 || $user_id == 5078) { // puput maulani all marketing rsp, aisyah3066
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (120,137,154,155))";
    } else if ($user_id == 4499) { // elia2700
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.department_id IN (203,158))";
    } else { // SPV
      $kondisi = "AND briefing.created_by = $user_id";
    }



    if ($user_id == 7731) { // Dimas Nurulloh
      $kondisi = "AND (briefing.created_by = $user_id OR briefing.company_id IN (1,2))";
    }

    if ($user_id == 2735) { // Siti Cahyati
      $kondisi = "AND (briefing.created_by IN ($user_id,6736) OR briefing.department_id IN (142,204,205,206,207,210,211))";
    }

    if ($user_id == 1369) { // abyan
      $kondisi = "AND (briefing.company_id IN (1,3,5) OR briefing.created_by = $user_id)";
    }

    return $this->db->query("SELECT
                              briefing.id_briefing,
                              briefing.review,
                              briefing.plan,
                              briefing.informasi,
                              briefing.motivasi,
                              COALESCE(briefing.foto, '') AS foto,
                              briefing.company_id,
                              comp.name AS company_name,
                              briefing.department_id,
                              dp.department_name,
                              briefing.designation_id,
                              dg.designation_name,
                              briefing.role_id,
                              role.role_name,
                              briefing.created_at,
                              CONCAT(usr.first_name, ' ', usr.last_name) AS created_by,
                              COALESCE(REPLACE(GROUP_CONCAT(CONCAT(TRIM(peserta.first_name), ' ', TRIM(peserta.last_name))),',',', '),'') AS peserta,
                              COALESCE(briefing.sanksi,'') AS sanksi,
                              COALESCE(briefing.feedback,'') AS feedback,
                              COALESCE(briefing.feedback_at,'') AS feedback_at,
                              COALESCE(CONCAT(feedback_head.first_name, ' ', feedback_head.last_name),'') AS feedback_by,
                              COALESCE(briefing.review_bm,'') AS review_bm,
                              COALESCE(briefing.keputusan_bm,'') AS keputusan_bm,
                              COALESCE(briefing.feedback_bm_at,'') AS feedback_bm_at,
                              COALESCE(CONCAT(feedback_bm.first_name, ' ', feedback_bm.last_name),'') AS feedback_bm_by,
                              REPLACE(REPLACE(REPLACE(usr.contact_no,'+',''),'-',''),' ','') AS no_user
                          FROM
                              briefing
                          JOIN xin_employees AS usr ON usr.user_id = briefing.created_by
                          LEFT JOIN xin_companies AS comp ON comp.company_id = briefing.company_id
                          LEFT JOIN xin_departments AS dp ON dp.department_id = briefing.department_id
                          LEFT JOIN xin_designations AS dg ON dg.designation_id = briefing.designation_id
                          LEFT JOIN xin_user_roles AS role ON role.role_id = briefing.role_id
                          LEFT JOIN xin_employees AS peserta ON FIND_IN_SET(peserta.user_id, briefing.peserta)
                          LEFT JOIN xin_employees AS feedback_head ON feedback_head.user_id = briefing.feedback_by
                          LEFT JOIN xin_employees AS feedback_bm ON feedback_bm.user_id = briefing.feedback_bm_by
                          WHERE SUBSTR(briefing.created_at,1,10) BETWEEN '$start' AND '$end'
                          $kondisi
                          GROUP BY briefing.id_briefing")->result();
  }

  function dt_lock_brif_d_v1($start, $end)
  {
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['user_role_id'];

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

  function get_peserta($department_id)
  {
    $user_id = $_SESSION['user_id'];
    $kondisi = "department_id = $department_id";

    $finance_dep = [27, 33, 47, 89, 90, 99, 116, 168, 186, 202];
    $human_dep = [1, 72, 73, 156, 157, 167];

    if ($user_id == 2735) {
      $kondisi = "department_id IN (106,105,111,158,142,151)";
    } else if ($user_id == 1186) {
      $kondisi = "department_id IN (204,211)";
    }

    if (in_array($department_id, $finance_dep)) {
      $kondisi = "department_id IN (27,33,47,89,90,99,116,168,186,202)";
    } else if (in_array($department_id, $human_dep)) {
      $kondisi = "department_id IN (1,72,73,156,157,167)";
    } else if ($user_id == 68) {
      $kondisi = "department_id IN (203,205,158) OR user_id IN (10133,9633)";
    }

    // kondisi baru
    // check jika assisten bm / bm
    $check_atasan = $this->check_atasan($user_id);
    if ($check_atasan->num_rows() > 0) { // jika ada ambil sales
      $id_user_rsp = $check_atasan->row()->id_user;
      $query = "SELECT
                  e.user_id,
                  CONCAT(e.first_name, ' ', e.last_name) AS employee_name,
                  if(sales.join_hr IS NOT NULL,'1','') AS sales
                  FROM xin_employees e
                  LEFT JOIN (
                      SELECT
                      u.id_gm AS id_gm,
                      u.id_manager AS id_bm,
                      u.join_hr,
                      u.employee_name
                      FROM
                      rsp_project_live.`user` u 
                      WHERE
                      u.join_hr = '$user_id' 
                      AND ( u.id_user = u.spv OR u.id_user = u.id_manager OR u.id_user = id_gm ) AND u.isActive = 1
                  ) AS atasan ON atasan.join_hr = '$user_id'
                  LEFT JOIN (
                      SELECT
                      sales.join_hr,
                      sales.employee_name AS sales
                      FROM
                      rsp_project_live.`user` sales 
                      WHERE
                      sales.id_user != '$id_user_rsp' 
                      AND 
                      ( sales.spv = '$id_user_rsp' OR sales.id_manager = '$id_user_rsp' OR sales.id_gm = '$id_user_rsp' ) AND sales.isActive = 1
                  ) AS sales ON sales.join_hr = e.user_id
                  WHERE 
                  e.is_active = 1 AND e.user_id != 1";
    } else {
      $query = "SELECT
                user_id,
                CONCAT(first_name, ' ', last_name) AS employee_name                
              FROM xin_employees 
              WHERE $kondisi
              AND is_active = 1";
    }
    return $this->db->query($query)->result();
  }

  function check_atasan($user_id)
  {
    $query = $this->db->query("SELECT
              u.id_gm AS id_gm,
              u.id_manager AS id_bm,
              u.id_user,
              u.employee_name
            FROM
              rsp_project_live.`user` u 
            WHERE
              u.join_hr = '$user_id' 
              AND ( u.id_user = u.spv OR u.id_user = u.id_manager OR u.id_user = id_gm ) AND u.isActive = 1");
    return $query;
  }

  function get_sales_by_id_atasan($id_user_rsp)
  {
    $query = $this->db->query("SELECT
                sales.id_user AS id_sales,
                sales.join_hr AS id_hr_sales,
                sales.employee_name AS sales,
                COALESCE(a.clock_in,'') AS clock_in
              FROM
                rsp_project_live.`user` sales 
                LEFT JOIN xin_attendance_time a ON a.employee_id = sales.join_hr AND a.attendance_date = CURRENT_DATE
              WHERE
                sales.id_user != '$id_user_rsp' 
                AND 
                ( sales.spv = '$id_user_rsp' OR sales.id_manager = '$id_user_rsp' OR sales.id_gm = '$id_user_rsp' ) AND sales.isActive = 1")->result();
    return $query;
  }

  function get_sales_preview($id_user_rsp)
  {
    // Ambil tanggal hari ini
    $today = date('Y-m-d');
    $currentDay = date('j'); // Mendapatkan hari dalam bulan (tanpa leading zero)

    // Tentukan rentang tanggal
    if ($currentDay == 1) {
      // Jika hari pertama dalam bulan
      $startDate = date('Y-m-01', strtotime('first day of last month')); // Awal bulan lalu
      $endDate = $today; // Hari ini
    } else {
      $startDate = date('Y-m-01');
      $endDate = date('Y-m-d');
    }
    $query = "SELECT
                sales.id_user AS id_sales,
                sales.join_hr AS id_hr_sales,
                sales.employee_name AS sales,
                COALESCE ( a.clock_in, '' ) AS clock_in,
                COUNT(DISTINCT g.id_gci) AS db,
                COUNT(DISTINCT IF(COALESCE(fmkt.freq,1) = 1,fmkt.id_fu,NULL)) AS fu1,
                COUNT(DISTINCT IF(COALESCE(fmkt.freq,1) = 2,fmkt.id_fu,NULL)) AS fu2,
                COUNT(DISTINCT IF(COALESCE(fmkt.freq,1) = 3,fmkt.id_fu,NULL)) AS fu3,
                COUNT(DISTINCT IF(COALESCE(g.id_kategori,0) = 2, g.id_gci,NULL)) AS ceklok,
                COUNT(DISTINCT IF(COALESCE(g.id_kategori,0) = 3, g.id_gci,NULL)) AS booking,
                COALESCE(bi.target_db,3) AS target_db,
                COUNT(DISTINCT IF(DATE(g.created_at) = (CURRENT_DATE - INTERVAL 1 DAY), g.id_gci,NULL)) AS db_aktual,
                CASE WHEN COALESCE(bi.target_db,3) <= 0 THEN 100 
                ELSE 
                ROUND(COUNT(DISTINCT IF(DATE(g.created_at) = (CURRENT_DATE - INTERVAL 1 DAY), g.id_gci,NULL)) / COALESCE(bi.target_db,3) * 100) 
                END AS persen_aktual,
                COALESCE(ta.latitude,'') AS latitude,
                COALESCE(ta.longitude,'') AS longitude,
                3 AS target_db_today
              FROM
                rsp_project_live.`user` sales
                LEFT JOIN xin_attendance_time a ON a.employee_id = sales.join_hr
                AND a.attendance_date = CURRENT_DATE 
                LEFT JOIN rsp_project_live.t_gci g ON DATE(g.created_at) BETWEEN '$startDate' AND '$endDate' AND sales.id_user = g.created_by
                LEFT JOIN rsp_project_live.t_follow_up_mkt fmkt ON DATE(fmkt.created_at) BETWEEN '$startDate' AND '$endDate' AND fmkt.created_by = sales.id_user AND g.id_gci = fmkt.id_gci
                LEFT JOIN rsp_project_live.t_activity ta ON ta.created_by = '$id_user_rsp' AND DATE(ta.tanggal) = CURRENT_DATE
                LEFT JOIN briefing_item_mkt bi ON DATE(bi.created_at) = (CURRENT_DATE - INTERVAL 1 DAY) AND bi.id_user = sales.id_user
              WHERE
                sales.id_user != '$id_user_rsp' 
                AND ( sales.spv = '$id_user_rsp' OR sales.id_manager = '$id_user_rsp' OR sales.id_gm = '$id_user_rsp' ) 
                AND sales.isActive = 1
                GROUP BY sales.id_user
                ORDER BY COUNT(DISTINCT g.id_gci) DESC, COUNT(DISTINCT IF(COALESCE(g.id_kategori,0) = 3, g.id_gci,NULL)) DESC";

    return $this->db->query($query)->result();
  }

  function get_sales_preview_resume($id_user_rsp, $start, $end)
  {
    // Ambil tanggal hari ini
    $today = date('Y-m-d');
    $currentDay = date('j'); // Mendapatkan hari dalam bulan (tanpa leading zero)

    // // Tentukan rentang tanggal
    // if ($currentDay == 1) {
    //   // Jika hari pertama dalam bulan
    //   $startDate = date('Y-m-01', strtotime('first day of last month')); // Awal bulan lalu
    //   $endDate = $today; // Hari ini
    // } else {
    $startDate = $start;
    $endDate = $end;
    // }

    if ($id_user_rsp == 1 || $id_user_rsp == 61) {
      $kondisi = "";
    } else {
      $kondisi = "WHERE id_sales != '$id_user_rsp' AND ( spv = '$id_user_rsp' OR id_manager = '$id_user_rsp' OR id_gm = '$id_user_rsp' )";
    }


    $query = "SELECT
              *
              FROM
                summary_briefing_sales
                $kondisi
                GROUP BY id_sales";

    return $this->db->query($query)->result();
  }

  function get_content_wa($id_briefing)
  {
    $query = "SELECT
                b.id_briefing,
                DATE(b.created_at) AS tanggal,
                b.review,
                CONCAT(usr.first_name, ' ', usr.last_name) AS user_briefing,
                REPLACE(REPLACE(REPLACE(usr.contact_no,'+',''),'-',''),' ','') AS contact_user,
                COALESCE(b.feedback,'') AS feedback,
                COALESCE(CONCAT(feedback.first_name, ' ', feedback.last_name),'') AS user_feedback,
                COALESCE(DATE(b.feedback_at),'') AS feedback_at
              FROM briefing b
              LEFT JOIN xin_employees usr ON usr.user_id = b.created_by
              LEFT JOIN xin_employees feedback ON feedback.user_id = b.feedback_by
              WHERE b.id_briefing = '$id_briefing'
              LIMIT 1";
    return $this->db->query($query)->row_array();
  }


  function dt_list_memo()
  {
    $query = "SELECT
          t.id_memo,
          t.tipe_memo,
          t.note,
          t.created_at,
          t.files_memo,
          t.status_memo,
          u.employee_name AS created_by,
          GROUP_CONCAT( DISTINCT md.divisi ) AS divisi,
          GROUP_CONCAT( DISTINCT hx.role_name ) AS jabatan,
          u1.employee_name AS updated_by,
          note_update 
        FROM
          rsp_project_live.t_memo_new t
          JOIN rsp_project_live.`user` u ON u.id_user = t.created_by
          LEFT JOIN rsp_project_live.`user` u1 ON u1.id_user = t.updated_by
          JOIN rsp_project_live.m_divisi md ON FIND_IN_SET( md.id_divisi, t.divisi )
          JOIN hris.xin_user_roles hx ON FIND_IN_SET( hx.role_id, t.jabatan ) 
        WHERE
          md.id_divisi = 2 AND t.status_memo = 1 AND t.created_by != 1
        GROUP BY
          t.id_memo
        ORDER BY 
          t.created_at DESC";
    return $this->db->query($query)->result();
  }

  function getSOP($jenis_dokumen)
  {
    $role_id = $this->session->userdata("department_id");
    if ($jenis_dokumen == 'job_profile') {
      $dok = " AND det.jenis_doc = 'Job Profile' GROUP BY det.no_doc
            union
                    SELECT
                        'Job Profile' AS jenis_doc,
                        CONCAT( 'Job Profile ', xin_designations.designation_name ) AS nama_dokumen,
                        xin_departments.department_name ,
                        xin_designations.designation_name ,
                        trusmi_job_profile.no_jp,
                        trusmi_job_profile.no_dok,
                        trusmi_job_profile.release_date AS tgl_terbit ,
                        '' as file
                    FROM
                        trusmi_job_profile
                        JOIN xin_departments ON trusmi_job_profile.departement_id = xin_departments.department_id
                        JOIN xin_designations ON trusmi_job_profile.designation_id = xin_designations.designation_id
                        WHERE  xin_departments.department_id in ($role_id)  
                        GROUP BY trusmi_job_profile.no_jp";
    } else if ($jenis_dokumen == "sop") {
      $dok = " AND det.jenis_doc = 'SOP' GROUP BY det.no_doc";
    } else if ($jenis_dokumen == "flowchart") {
      $dok = " AND det.jenis_doc = 'Flowchart' GROUP BY det.no_doc";
    } else if ($jenis_dokumen == "instruksi_kerja") {
      // edit by Ade
      $dok = " AND det.jenis_doc = 'Instruksi Kerja'  GROUP BY
                                                            det.no_doc,
                                                            dp.department_name,
                                                            det.jenis_doc,
                                                            det.no_jp,
                                                            det.tgl_terbit,
                                                            det.nama_dokumen,
                                                            det.file";
    } else {
      $dok = " AND det.jenis_doc = 'Job Profile' GROUP BY det.no_doc";
    }
    // update kueri untuk menampilkan beberapa designation by Ade
    $sql = "SELECT
        dp.department_name,
        GROUP_CONCAT(DISTINCT dg.designation_name SEPARATOR ', ') AS designation_name,
        det.no_doc,
        det.jenis_doc,
        det.no_jp,
        DATE_FORMAT(det.tgl_terbit, '%d-%m-%Y') AS tgl_terbit,
        det.nama_dokumen,
        det.file
    FROM
        xin_departments AS dp
        LEFT JOIN (
            SELECT
                'inv' AS tipe,
                '' AS no_jp,
                '' AS level_sto,
                inv.company,
                dp.department_id,
                inv.designation,
                inv.no_doc,
                inv.jenis_doc,
                inv.id_sop,
                inv.tgl_terbit,
                inv.tgl_update,
                inv.start_date,
                inv.end_date,
                inv.nama_dokumen,
                inv.file
            FROM
                trusmi_sop AS inv
                JOIN xin_departments AS dp ON FIND_IN_SET(dp.department_id, inv.department)
            WHERE
                inv.file IS NOT NULL
        ) AS det ON dp.department_id = det.department_id
        LEFT JOIN xin_companies AS com ON com.company_id = det.company
        LEFT JOIN xin_designations AS dg ON FIND_IN_SET(dg.designation_id, det.designation)
        LEFT JOIN xin_companies AS c ON c.company_id = dp.company_id
        LEFT JOIN xin_employees AS em ON FIND_IN_SET(em.designation_id, det.designation) AND em.department_id = det.department_id AND em.is_active = 1
    WHERE
        dp.department_id IN ($role_id)
        $dok
    ";

    $list_sop = $this->db->query($sql)->result();
    $response_sop['status'] = 200;
    $response_sop['error'] = false;
    $response_sop['data'] = $list_sop;
    return $response_sop;
  }
}
