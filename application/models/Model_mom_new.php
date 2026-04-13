<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_mom_new extends CI_Model
{
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function generate_id_mom()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( mom_header.id_mom, 3 ) ) AS kd_max 
                              FROM
                                mom_header 
                              WHERE
                                DATE( mom_header.created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }

    return 'MOM' . date('ymd') . $kd;
  }

  function get_list_mom($start, $end, $closed)
  {
    $user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];

    if ($role_id == 1 || $user_id == 1139) { // Ittrusmi & Viky & Super Admin
      if ($closed == 0) { // Draft
        $kondisi = "";
      } else { // Finish
        $kondisi = "AND tgl BETWEEN '$start' AND '$end'";
      }
    } else if ($department_id == 117) { // PDCA RSP
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Munculkan Created By User PDCA dan Created By dari Semua User RSP
        $kondisi = "AND tgl BETWEEN '$start' AND '$end' AND (created.user_id = $user_id OR created.company_id = 2)";
      } 
    } else {
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Finish
        $kondisi = "AND tgl BETWEEN '$start' AND '$end' AND created.user_id = $user_id";
      }
    }

    return $this->db->query("SELECT
                              mom.id_mom,
                              md5(id_mom) AS id_link,
                              mom.judul,
                              mom.tempat,
                              DATE_FORMAT( mom.tgl, '%d %b %y' ) AS tgl,
                              CONCAT( SUBSTR(mom.start_time,1,5), ' - ', SUBSTR(mom.end_time,1,5) ) AS waktu,
                              mom.agenda,
                              GROUP_CONCAT( COALESCE(peserta.employee_name,'') ) AS peserta,
                              GROUP_CONCAT(
                              CASE
                                  WHEN peserta.profile_picture = '' 
                                  AND peserta.gender = 'Male' THEN
                                    'default_male.jpg' 
                                    WHEN peserta.profile_picture = '' 
                                    AND peserta.gender = 'Female' THEN
                                      'default_female.jpg' ELSE COALESCE(peserta.profile_picture,'default_male.jpg') 
                                    END 
                                    ) AS pp_peserta,
                              CONCAT( created.first_name, ' ', created.last_name ) AS created_by,
                              created.username,
                              created.user_id,
                              CASE
                              WHEN created.profile_picture = '' 
                              AND created.gender = 'Male' THEN
                                'default_male.jpg' 
                                WHEN created.profile_picture = '' 
                                AND created.gender = 'Female' THEN
                                  'default_female.jpg' ELSE created.profile_picture 
                                  END AS profile_picture,
                              DATE_FORMAT( mom.created_at, '%d %b %y' ) AS created_at,
                              mom.pembahasan
                            FROM
                              mom_header AS mom
                              LEFT JOIN ( SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name, contact_no, profile_picture, gender FROM xin_employees ) AS peserta ON FIND_IN_SET( peserta.user_id, mom.peserta )
                              LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by 
                            WHERE
                              closed = $closed
                              $kondisi
                            GROUP BY
                              mom.id_mom")->result();
  }

  function get_employee()
  {
    // $query = "SELECT
    //             `user_id`,
    //             CONCAT( first_name, ' ', last_name ) AS employee_name
    //           FROM
    //             hris.xin_employees 
    //           WHERE
    //             is_active = 1 
    //             AND `user_id` <> 1";
    $query = "SELECT
                em.`user_id`,
                CONCAT( em.first_name, ' ', em.last_name, ' | ', dp.department_name ) AS employee_name 
              FROM
                hris.xin_employees AS em
                LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
              WHERE
                em.is_active = 1 
                AND em.`user_id` <> 1";
    return $this->db->query($query)->result();
  }

  function get_kategori()
  {
    return $this->db->query("SELECT * FROM mom_kategori")->result();
  }

  function get_total_kategori()
  {
    return $this->db->query("SELECT COUNT(id) AS total FROM mom_kategori")->row_array();
  }

  function cek_issue($id_mom, $id_issue)
  {
    $this->db->where('id_mom', $id_mom);
    $this->db->where('id_issue', $id_issue);
    return $this->db->get('mom_issue')->num_rows();
  }

  function cek_issue_item($id_mom, $id_issue, $id_issue_item)
  {
    $this->db->where('id_mom', $id_mom);
    $this->db->where('id_issue', $id_issue);
    $this->db->where('id_issue_item', $id_issue_item);
    return $this->db->get('mom_issue_item')->num_rows();
  }

  function generate_id_task()
  {
    $q = $this->db->query("SELECT
                              MAX( RIGHT ( td_task.id_task, 3 ) ) AS kd_max 
                            FROM
                              td_task 
                            WHERE
                              SUBSTR( td_task.created_at, 1, 10 ) = CURDATE( )");
    $kd = "";

    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int) $k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }
    return 'T' . date('ymd') . $kd;
  }

  function generate_id_sub_task()
  {
    $q = $this->db->query("SELECT
        MAX( RIGHT ( td_sub_task.id_sub_task, 3 ) ) AS kd_max 
        FROM
        td_sub_task 
        WHERE
        SUBSTR( td_sub_task.created_at, 1, 10 ) = CURDATE( )");
    $kd = "";

    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int) $k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }
    return 'ST' . date('ymd') . $kd;
  }

  function get_list_rekap($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];

    if ($user_id == "803") { // Pak Ibnu
      $cond = "AND pic.user_id IN ('$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76')";
    } else if ($user_id == 1139 || $department_id == 117 || $role_id == 1) { // Viky, Div PDCA, Super Admin
      $cond = "";
    } else {
      $cond = "AND pic.user_id = '$user_id'";
    }
    return $this->db->query("SELECT
                              pic.user_id,
                              pic.username,
                              CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
                              dg.designation_name AS jabatan,
                              COUNT(IF(item.kategori = 1,1,NULL)) AS tasklist,
                              COUNT(IF(item.kategori = 2,1,NULL)) AS keputusan,
                              COUNT(IF(item.kategori = 3,1,NULL)) AS konsep,
                              COUNT(IF(item.kategori = 4,1,NULL)) AS `statement`,
                              COUNT(IF(item.kategori = 5,1,NULL)) AS instruksi,
                              COUNT(IF(item.kategori = 6,1,NULL)) AS strategi,
                              COUNT(IF(item.kategori = 7,1,NULL)) AS brainstorming,
                              COUNT(IF(item.kategori = 8,1,NULL)) AS daily,
                              COUNT(IF(item.kategori = 9,1,NULL)) AS weekly,
                              COUNT(IF(item.kategori = 10,1,NULL)) AS monthly,
                              COUNT(IF(ibr.`status` IN (1,2),1,NULL)) AS progres,
                              COUNT(IF(ibr.`status` = 3,1,NULL)) AS done,
                              COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1,1,NULL)) AS ontime,
                              COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0,1,NULL)) AS late
                            FROM
                              mom_issue_item as item
                              JOIN xin_employees AS pic ON FIND_IN_SET(pic.user_id,item.pic)
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = pic.designation_id
                              JOIN mom_header as mom ON mom.id_mom = item.id_mom
                              JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
                            WHERE
                              mom.tgl BETWEEN '$start' AND '$end' $cond
                            GROUP BY
                              pic.user_id")->result();
  }

  function get_detail_rekap($start, $end, $user, $tipe)
  {
    if ($tipe == 30) {
      $kondisi = "AND ibr.`status` IN (1,2)";
    } else if ($tipe == 40) {
      $kondisi = "AND ibr.`status` = 3";
    } else if ($tipe == 50) {
      $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1";
    } else if ($tipe == 60) {
      $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0";
    } else {
      $kondisi = "AND item.kategori = $tipe";
      // $kondisi = "";
    }
    return $this->db->query("SELECT
                              mom.tgl AS tgl_meeting,
                              pic.user_id,
                              pic.username,
                              CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
                              issue.issue,
                              item.action,
                              item.kategori AS id_kategori,
                              kat.kategori,
                              item.deadline,
                              ibr.`status` AS id_status,
                              COALESCE(sts.`status`,'') AS `status`,
                              sts.color,
                              ibr.done_date,
                              sub.evaluasi 
                            FROM
                              mom_issue_item AS item
                              JOIN xin_employees AS pic ON FIND_IN_SET( pic.user_id, item.pic )
                              JOIN mom_issue AS issue ON issue.id_mom = item.id_mom AND issue.id_issue = item.id_issue
                              JOIN mom_header AS mom ON mom.id_mom = item.id_mom
                              JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
                              LEFT JOIN td_sub_task AS sub ON ibr.id_task = item.id_task AND sub.id_sub_task = item.id_sub_task
                              LEFT JOIN td_status AS sts ON sts.id = ibr.`status`
                            WHERE
                              mom.tgl BETWEEN '$start' 
                              AND '$end'
                              AND pic.user_id = '$user'
                              $kondisi")->result();
  }

  function resume_get_list_rekap($start, $end)
  {
    $user_id = $_SESSION['user_id'];
    if ($user_id == 803) {
      // 786 = Abdul Goffar,
      // 1434 = Alfiyawati Santika,
      // 2 = Ali Yasin,
      // 1449 = Angga Nur Fardiansah,
      // 2964 = Bregas Prakoso,
      // 77 = Fani Fitrianingsih,
      // 331 = Feronita,
      // 2397 = Firman Tigoastomo Basuki,
      // 323 = Hendra Arya Cahyadi,
      // 1186 = Idham Nurhakim Dipura,
      // 90 = Indra Bayu Ramadhani,
      // 355 = Mochamad Ridwan,
      // 68 = Syekh Farhan Robbani,
      // 76 = Yeyen Nuryenti 
      $cond = "AND pic.user_id IN ('$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76')";
    } else {
      $cond = "";
    }
    return $this->db->query("SELECT
                              pic.user_id,
                              pic.username,
                              CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
                              COUNT(IF(item.kategori IN (1,6,8,9,10),1,NULL)) AS tasklist,
                              COUNT(IF(item.kategori <> 1,1,NULL)) AS non_tasklist,
                              COUNT(IF(ibr.`status` IN (1,2),1,NULL)) AS progres,
                              COUNT(IF(ibr.`status` = 3,1,NULL)) AS done,
                              COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1,1,NULL)) AS ontime,
                              COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0,1,NULL)) AS late
                            FROM
                              mom_issue_item as item
                              JOIN xin_employees AS pic ON FIND_IN_SET(pic.user_id,item.pic)
                              JOIN mom_header as mom ON mom.id_mom = item.id_mom
                              JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
                            WHERE
                              mom.tgl BETWEEN '$start' AND '$end' $cond
                            GROUP BY
                              pic.user_id")->result();
  }

  function resume_get_detail_rekap($start, $end, $user, $tipe)
  {
    if ($tipe == 1) {
      $kondisi = "AND item.kategori IN (1,6,8,9,10)";
    } else if ($tipe == 2) {
      $kondisi = "AND item.kategori <> 1";
    } else if ($tipe == 3) {
      $kondisi = "AND ibr.`status` IN (1,2)";
    } else if ($tipe == 4) {
      $kondisi = "AND ibr.`status` = 3";
    } else if ($tipe == 5) {
      $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1";
    } else if ($tipe == 6) {
      $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0";
    } else {
      $kondisi = "";
    }
    return $this->db->query("SELECT
                              mom.tgl AS tgl_meeting,
                              pic.user_id,
                              pic.username,
                              CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
                              issue.issue,
                              item.action,
                              item.kategori AS id_kategori,
                              kat.kategori,
                              item.deadline,
                              ibr.`status` AS id_status,
                              COALESCE(sts.`status`,'') AS `status`,
                              sts.color,
                              ibr.done_date,
                              sub.evaluasi 
                            FROM
                              mom_issue_item AS item
                              JOIN xin_employees AS pic ON FIND_IN_SET( pic.user_id, item.pic )
                              JOIN mom_issue AS issue ON issue.id_mom = item.id_mom AND issue.id_issue = item.id_issue
                              JOIN mom_header AS mom ON mom.id_mom = item.id_mom
                              JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
                              LEFT JOIN td_sub_task AS sub ON ibr.id_task = item.id_task AND sub.id_sub_task = item.id_sub_task
                              LEFT JOIN td_status AS sts ON sts.id = ibr.`status`
                            WHERE
                              mom.tgl BETWEEN '$start' 
                              AND '$end'
                              AND pic.user_id = '$user'
                              $kondisi")->result();
  }

  function print_header($id)
  {
    return $this->db->query("SELECT
                              id_mom,
                              judul,
                              DAYNAME( tgl ) AS hari,
                              DATE_FORMAT( tgl, '%d %M %Y' ) AS tgl,
                              tempat,
                              CONCAT(
                                LEFT ( start_time, 5 ),
                                ' - ',
                              LEFT ( end_time, 5 )) AS waktu,
                              agenda,
                              pembahasan,
                              closing_statement
                            FROM
                              mom_header 
                            WHERE
                              md5(id_mom) = '$id'")->row_array();
  }

  function print_peserta($id)
  {
    return $this->db->query("SELECT
                              mom.id_mom,
                              CONCAT(em.first_name,' ',em.last_name) AS employee_name,
                              em.profile_picture,
                              em.gender
                            FROM
                              mom_header AS mom
                              LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, mom.peserta ) 
                            WHERE
                              md5(id_mom) = '$id';")->result();
  }

  function print_issue($id)
  {
    return $this->db->query("SELECT id_mom, id_issue, issue FROM mom_issue WHERE md5(id_mom) = '$id'")->result();
  }

  function print_issue_item($id_mom, $id_issue)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              item.id_task,
                              item.id_sub_task,
                              issue.issue,
                              item.action,
                              kat.id AS id_kategori,
                              kat.kategori,
                              item.deadline AS deadline_e,
                              DATE_FORMAT( item.deadline, '%d %b %Y' ) AS deadline,
                              GROUP_CONCAT(
                              CONCAT( em.first_name, ' ', em.last_name )) AS pic,
                              td_task.`status` AS id_status,
                              td_status.`status`,
                              td_status.`label`,
                              td_sub_task.evaluasi
                            FROM
                              mom_issue AS issue
                              JOIN mom_issue_item AS item ON item.id_mom = issue.id_mom 
                              AND item.id_issue = issue.id_issue
                              LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic ) 
                              LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task ON td_task.id_task = issue.id_task
                              LEFT JOIN td_sub_task ON td_task.id_task = issue.id_task AND td_sub_task.id_sub_task = item.id_sub_task
                              LEFT JOIN td_status ON td_status.id = td_task.`status`
                            WHERE
                              issue.id_mom = '$id_mom'
                              AND item.id_issue = '$id_issue' 
                            GROUP BY
                              item.id_issue_item")->result();
  }

  function get_send_wa($id_mom)
  {
    return $this->db->query("SELECT
                              mom.id_mom,
                              mom.judul,
                              mom.tempat,
                              DATE_FORMAT( mom.tgl, '%d %b %Y' ) AS tgl,
                              mom.waktu,
                              mom.agenda,
                              mom.peserta,
                              mom.pembahasan,
                              mom.closing_statement,
                              em.user_id,
                              GROUP_CONCAT( REPLACE(REPLACE(REPLACE(em.contact_no,' ',''),'+',''),'-','')) AS kontak,
                              CONCAT('https://trusmiverse.com/apps/pr/mom/',md5(mom.id_mom)) AS link
                            FROM
                              (
                              SELECT
                                mom.id_mom,
                                mom.judul,
                                mom.tempat,
                                mom.tgl,
                                CONCAT( LEFT ( mom.start_time, 5 ), ' - ', LEFT ( mom.end_time, 5 )) AS waktu,
                                mom.agenda,
                                GROUP_CONCAT(CONCAT(em.first_name,' ',em.last_name)) AS peserta,
                                CONCAT( mom.peserta, ',', COALESCE(item.pic,'') ) AS pic,
                                mom.pembahasan,
                                mom.closing_statement 
                              FROM
                                mom_header AS mom
                                JOIN ( SELECT id_mom, GROUP_CONCAT( pic ) AS pic FROM mom_issue_item WHERE id_mom = '$id_mom' GROUP BY id_mom ) AS item ON item.id_mom = mom.id_mom
                                LEFT JOIN xin_employees AS em ON FIND_IN_SET(em.user_id,mom.peserta) 
                              WHERE
                                mom.id_mom = '$id_mom' 
                              ) AS mom
                              LEFT JOIN (
                              SELECT
                                user_id,
                                IF ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS contact_no 
                              FROM
                                xin_employees 
                              ) AS em ON FIND_IN_SET( em.user_id, mom.pic ) 
                            GROUP BY
                              em.user_id")->result_array();
  }

  // Data untuk Autonotif ketika H-1 dari Deadline
  function mom_autonotif()
  {
    return $this->db->query("SELECT
                              item.id_mom,
                              item.id_issue,
                              item.id_issue_item,
                              item.deadline,
                              em.employee_name,                              
                              REPLACE(REPLACE(REPLACE(em.kontak,' ',''),'+',''),'-','') AS kontak_pic,
                              mom.judul,
                              mom.tempat,
                              mom.tgl,
                              CONCAT(
                                LEFT ( start_time, 5 ),
                                ' - ',
                              LEFT ( end_time, 5 )) AS waktu,
                              mom.agenda,
                              GROUP_CONCAT( ps.employee_name ) AS peserta,
                              mom.pembahasan,
                              mom.closing_statement,                              
                              CONCAT('https://trusmiverse.com/apps/pr/mom/',md5(mom.id_mom)) AS link
                            FROM
                              mom_issue_item AS item
                              JOIN mom_issue AS issue ON issue.id_issue = item.id_issue 
                              AND issue.id_mom = item.id_mom
                              JOIN mom_header AS mom ON mom.id_mom = item.id_mom
                              LEFT JOIN (
                              SELECT
                                user_id,
                                CONCAT( first_name, ' ', last_name ) AS employee_name,
                              IF
                                (
                                  LEFT ( contact_no, 1 ) = '0',
                                CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS kontak
                              FROM
                                xin_employees 
                              ) AS em ON FIND_IN_SET( em.user_id, item.pic )
                              LEFT JOIN (SELECT user_id, CONCAT(first_name,' ',last_name) AS employee_name FROM xin_employees) AS ps ON FIND_IN_SET( ps.user_id, mom.peserta ) 
                            WHERE
                              item.kategori IN (1,6,8,9,10) 
                              AND CURDATE() = DATE_SUB( item.deadline, INTERVAL 1 DAY ) 
                            GROUP BY
                              em.user_id")->result_array();
  }

  function get_result_meeting($id)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              issue.id_issue,
                              issue.issue,
                              item.id_issue_item,
                              item.id_task,
                              item.id_sub_task,
                              item.action,
                              COALESCE(item.kategori,'') AS id_kategori,
                              kat.kategori,
                              COALESCE(item.deadline,'') AS deadline,
                              item.pic,
                              GROUP_CONCAT( em.employee_name ) AS list_pic
                            FROM
                              mom_issue AS issue
                              JOIN mom_issue_item AS item ON item.id_mom = issue.id_mom AND item.id_issue = issue.id_issue
                              LEFT JOIN (SELECT user_id, CONCAT(first_name,' ',last_name) AS employee_name FROM xin_employees) AS em ON FIND_IN_SET( em.user_id, item.pic )
                              LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
                            WHERE
                              issue.id_mom = '$id'
                            GROUP BY
                              item.id_issue_item,
                              item.id_issue")->result();
  }

  // Update
  function get_issue_new($id_mom)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              issue.id_issue,
                              issue.issue,
                              issue.deadline,
                              GROUP_CONCAT(issue.user_id) AS pic
                            FROM
                              (
                              SELECT
                                issue.id_mom,
                                issue.id_issue,
                                issue.issue,
                                MAX( item.deadline ) AS deadline,
                                em.user_id 
                              FROM
                                mom_issue_item AS item
                                JOIN mom_issue AS issue ON issue.id_mom = item.id_mom 
                                AND issue.id_issue = item.id_issue
                                LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic ) 
                              WHERE
                                issue.id_mom = '$id_mom' 
                                AND item.kategori IN (1,6,8,9,10) 
                              GROUP BY
                                issue.id_issue,
                                em.user_id 
                              ) AS issue 
                            GROUP BY
                              issue.id_issue")->result();
  }

  function get_issue_item_new($id_mom, $id_issue)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              issue.issue,
                              item.id_issue,
                              item.id_issue_item,
                              item.action,
                              item.deadline,
                              item.pic,
                              item.kategori
                            FROM
                              mom_issue_item AS item
                              JOIN mom_issue AS issue ON issue.id_mom = item.id_mom 
                              AND issue.id_issue = item.id_issue
                            WHERE
                              issue.id_mom = '$id_mom' 
                              AND item.id_issue = '$id_issue' 
                              AND item.kategori IN (1,6,8,9,10)")->result();
  }

  function cek_due_date_task($id_task)
  {
    return $this->db->query("SELECT id_task, task, due_date FROM td_task WHERE id_task = '$id_task'")->row_array();
  }

  function get_draft_header($id)
  {
    return $this->db->query("SELECT
                              id_mom,
                              judul,
                              tempat,
                              tgl,
                              LEFT(start_time,5) AS start_time,
                              LEFT(end_time,5) AS end_time,
                              agenda,
                              peserta,
                              pembahasan,
                              closing_statement,
                              created_at,
                              created_by,
                              closed 
                            FROM
                              mom_header 
                            WHERE
                              id_mom = '$id' 
                              AND closed = 0")->row_array();
  }

  // Result Draft
  function get_issue_result($id_mom)
  {
    $query = "SELECT
        mom_issue.id_issue,
        mom_issue.issue,
        COUNT( mom_issue.id_issue ) AS action,
        COUNT( mom_issue.id_issue ) + 1 AS rowspan
      FROM
        mom_issue
        LEFT JOIN mom_issue_item ON mom_issue.id_mom = mom_issue_item.id_mom 
        AND mom_issue.id_issue = mom_issue_item.id_issue 
      WHERE
        mom_issue.id_mom = '$id_mom' 
      GROUP BY
        mom_issue.id_issue
      ORDER BY
        mom_issue.id_issue";

    return $this->db->query($query);
  }

  function get_issue_item_result($id_mom, $id_issue)
  {
    $this->db->where('id_mom', $id_mom);
    $this->db->where('id_issue', $id_issue);
    return $this->db->get('mom_issue_item')->result();
  }
  // End Result Draft

}
