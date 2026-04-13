<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_mom extends CI_Model
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

  function generate_id_plan()
  {
    $q = $this->db->query("SELECT 
                                MAX( RIGHT ( mom_plan.id_plan, 3 ) ) AS kd_max 
                              FROM
                                mom_plan 
                              WHERE
                                DATE( mom_plan.created_at ) = CURDATE()");
    $kd = "";
    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int)$k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }

    return 'P' . date('ymd') . $kd;
  }

  function get_list_mom($start, $end, $closed)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];
    $designation_id = $_SESSION['designation_id'];

    // Akun Pak Hendra hanya Muncul MOM PIC/Peserta sendiri saja bukan Super Admin
    if ($user_id == 323) {
      $role_id = 0;
    }

    // Tambahan Kondisi akun ratih, keculikan anggi399
    $tertentu = "";
    if ($user_id == 329) {
      $tertentu = "AND mom.created_by <> 1212";
    }

    $super            = [1139, 8892, 8970, 803, 4138, 5086, 5385, 329, 4498, 3651, 2903, 5121, 8204, 2735, 9645,10214, 10127, 7731, 10404]; // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu, Farhan, alfin3333, ratih, sandi2696, od rsp, muhammad5956(hilal), cita7321, moch5508, pujaannicha8053
    $list_designation = [1217, 1218]; // HRBP Manager, Officer

    $kondisi_new = "";
    $kondisi_jobdesk = "";
    if ($role_id == 1 || in_array($user_id, $super) || in_array($designation_id, $list_designation)) {
      if ($closed == 0) { // Draft
        $kondisi = "";
      } else { // Finish
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end' $tertentu";
        if ($user_id != 1 && $user_id != 5121 && $user_id != 803 && $user_id != 323 && $user_id != 8204) { // Jika Super Admin bukan akun Pak Ibnu & Pak Hendra, & hilal
          $kondisi_new = "WHERE NOT FIND_IN_SET(68,final.department_id)";
        }
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($role_id == 2 || $role_id == 3) { // Role Head Department, Manager
      if ($closed == 0) { // Draft
        $kondisi = "AND created.department_id = $department_id";
        $kondisi_new = "";
      } else { // Munculkan Created By User Department
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new = "WHERE FIND_IN_SET($department_id,final.list_dep_pic) OR final.department_id = $department_id";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($department_id == 117) { // PDCA RSP
      if ($closed == 0) { // Draft
        // $kondisi = "AND created.user_id = $user_id";
        $kondisi = ""; // PDCA akses All Draft
      } else { // Munculkan Created By User PDCA dan Created By dari Semua User RSP
        if ($user_id == 4770) { // Akun dewi2853 minta Akses MOM Finance khususnya Department yg ada Bu Fani
          $kondisi      = "AND mom.tgl BETWEEN '$start' AND '$end'";
          $kondisi_new  = "WHERE NOT FIND_IN_SET(68,final.list_dep_pic) AND ( FIND_IN_SET(89,final.list_dep_pic) OR final.department_id IN(89,26) OR final.user_id = $user_id OR final.company_id = 2 OR FIND_IN_SET(133,final.list_dep_pic) OR FIND_IN_SET(83,final.list_dep_pic) OR FIND_IN_SET(26,final.list_dep_pic) )";
        } else if ($user_id == 6806 || $user_id == 5121) { // Akun Adrian, Dhewana bisa akses IT selain itu tidak bisa
          $kondisi      = "AND mom.tgl BETWEEN '$start' AND '$end'";
          // $kondisi_new  = "WHERE FIND_IN_SET(68,final.list_dep_pic) AND ( FIND_IN_SET(89,final.list_dep_pic) OR final.department_id = 89 OR final.user_id = $user_id OR final.company_id = 2 OR FIND_IN_SET(133,final.list_dep_pic) OR FIND_IN_SET(83,final.list_dep_pic) )";
        } else {
          $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end' AND (created.user_id = $user_id OR (created.company_id = 2 AND created.department_id <> 68))";
          $kondisi_new  = "WHERE NOT FIND_IN_SET(68,final.list_dep_pic) AND NOT FIND_IN_SET(26,final.list_dep_pic)";
        }
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 70 || $user_id == 2729 
    // || $user_id == 321 
    || $user_id == 7838) { // Nining27, saeroh1425, andre22, hrbatik
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Munculkan Created By User Batik dan Created By dari Semua User Batik
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        // $kondisi_new = "WHERE FIND_IN_SET(5,final.list_comp_pic) OR final.user_id = $user_id";
        $kondisi_new = "WHERE final.company_id IN (1,5) OR final.user_id = $user_id OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 1369) { // abyan
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else {
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new = "WHERE final.company_id IN (1,3,5) OR final.user_id = $user_id OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 2735 || $user_id == 7731) { // siti1423 dan moch5508
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
        $kondisi_new = "";
      } else { // Finish
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR final.user_id = $user_id OR FIND_IN_SET(106,final.list_dep_pic) OR final.department_id IN( 106,142,207,204,210,205,206,211,161) OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 1186) { // Idham Nurhakim Dipura
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
        $kondisi_new = "";
      } else { // Finish
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR final.user_id = $user_id OR FIND_IN_SET(106,final.list_dep_pic) OR final.department_id IN( 106,142,207,204,210,205,206,211) OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 2378) { // ilham1150
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
        $kondisi_new = "";
      } else { // Finish
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR final.user_id = $user_id OR FIND_IN_SET(68,final.list_dep_pic) OR FIND_IN_SET(72,final.list_dep_pic) OR FIND_IN_SET(156,final.list_dep_pic) OR FIND_IN_SET(157,final.list_dep_pic) OR FIND_IN_SET(83,final.list_dep_pic) OR FIND_IN_SET(133,final.list_dep_pic) OR FIND_IN_SET(25,final.list_dep_pic) OR FIND_IN_SET(186,final.list_dep_pic) OR FIND_IN_SET(27,final.list_dep_pic) OR FIND_IN_SET(26,final.list_dep_pic) OR final.department_id IN (68,72,156,157,83,133,25,186,27,26) OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else if ($user_id == 4954 || $user_id == 5078) { // Akses Marketing RSP
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Munculkan Created By Marketing RSP dan Department Marketing RSP
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new  = "WHERE final.user_id = $user_id OR FIND_IN_SET(120,final.list_dep_pic) OR FIND_IN_SET(154,final.list_dep_pic) OR FIND_IN_SET(155,final.list_dep_pic) OR final.department_id IN (120,154,155)  OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    } else {
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
        $kondisi_new = "";
      } else { // Finish
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        // $kondisi_new = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR final.user_id = $user_id";
        $kondisi_new = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR final.user_id = $user_id OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    }


    if ($user_id == 2505) { // puput1261
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Munculkan Department IT dan Buspro
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new  = "WHERE final.user_id = $user_id OR FIND_IN_SET(68,final.list_dep_pic) OR FIND_IN_SET(25,final.list_dep_pic) OR FIND_IN_SET(136,final.list_dep_pic) OR final.department_id IN (68,25,136)  OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    }

    if ($user_id == 7731 || $user_id == 321) { // Dimas Nurullah, Andre22
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Munculkan Department Idham Nurhakim Dipura dan Aris Kurniawan
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new  = "WHERE final.user_id = $user_id 
        OR FIND_IN_SET(106,final.list_dep_pic) 
        OR FIND_IN_SET(142,final.list_dep_pic) 
        OR FIND_IN_SET(183,final.list_dep_pic) 
        OR FIND_IN_SET(72,final.list_dep_pic) 
        OR FIND_IN_SET(151,final.list_dep_pic) 
        OR FIND_IN_SET(80,final.list_dep_pic) 
        OR FIND_IN_SET(158,final.list_dep_pic) 
        OR final.department_id IN (106,142,183,72,151,80,158)  
        OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    }

    if ($user_id == 5510) { // idris3450
      if ($closed == 0) { // Draft
        $kondisi = "AND created.user_id = $user_id";
      } else { // Tambahan MoM Angga Prabowo
        $kondisi = "AND mom.tgl BETWEEN '$start' AND '$end'";
        $kondisi_new  = "WHERE FIND_IN_SET($user_id,final.list_peserta_pic) OR FIND_IN_SET(476,final.list_peserta_pic) OR final.user_id = $user_id  OR FIND_IN_SET($user_id,final.cc)";
        $kondisi_jobdesk = "AND mom.meeting NOT IN ('Jobdesk')";
      }
    }

    return $this->db->query("SELECT * FROM (SELECT
                              mom.id_mom,
                              md5(mom.id_mom) AS id_link,
                              mom.judul,
                              mom.tempat,
                              DATE_FORMAT( mom.tgl, '%d %b %y' ) AS tgl,
                              CONCAT( SUBSTR(mom.start_time,1,5), ' - ', SUBSTR(mom.end_time,1,5) ) AS waktu,
                              mom.agenda,
                              mom.meeting,
                              dep.department_name AS department,
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
                              created.department_id,
                              created.company_id,
                              CASE
                              WHEN created.profile_picture = '' 
                              AND created.gender = 'Male' THEN
                                'default_male.jpg' 
                                WHEN created.profile_picture = '' 
                                AND created.gender = 'Female' THEN
                                  'default_female.jpg' ELSE created.profile_picture 
                                  END AS profile_picture,
                              DATE_FORMAT( mom.created_at, '%d %b %y' ) AS created_at,
                              mom.pembahasan,
                              CONCAT(
                                mom.peserta,
                                ',',
                              GROUP_CONCAT( item.pic )) AS list_peserta_pic,
                              mom.cc,
                              CONCAT(GROUP_CONCAT(peserta.dep_id),',',GROUP_CONCAT( item.dep_pic )) AS list_dep_pic,
                              CONCAT(GROUP_CONCAT(peserta.comp_id),',',GROUP_CONCAT( item.comp_pic )) AS list_comp_pic
                            FROM
                              mom_header AS mom
                              LEFT JOIN (
                                SELECT
                                  item.id_mom,
                                  item.peserta,
                                  GROUP_CONCAT( item.pic ) AS pic,
                                  GROUP_CONCAT( item.dep_pic ) AS dep_pic,
                                  GROUP_CONCAT( item.comp_pic ) AS comp_pic 
                                FROM
                                  (
                                  SELECT
                                    item.id_mom,
                                    mom.peserta,
                                    em.user_id AS pic,
                                    em.department_id AS dep_pic,
                                    em.company_id AS comp_pic 
                                  FROM
                                    mom_issue_item AS item
                                    JOIN mom_header AS mom ON mom.id_mom = item.id_mom
                                    LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic )
                                    LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by
                                  WHERE
                                    mom.closed = $closed $kondisi_jobdesk
                                    $kondisi
                                  GROUP BY
                                    item.id_mom,
                                    em.user_id 
                                  ) AS item 
                                GROUP BY
                                  item.id_mom 
                              ) AS item ON item.id_mom = mom.id_mom
                              LEFT JOIN ( SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name, contact_no, profile_picture, gender, department_id AS dep_id, company_id AS comp_id FROM xin_employees ) AS peserta ON FIND_IN_SET( peserta.user_id, mom.peserta )
                              LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by 
                              LEFT JOIN (
                              SELECT
                                mom.id_mom,
                                xin_departments.department_id,
                                GROUP_CONCAT( xin_departments.department_name ) AS department_name 
                              FROM
                                mom_header AS mom
                                JOIN xin_departments ON FIND_IN_SET( xin_departments.department_id, mom.department )
                                LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by
                              WHERE
                                mom.closed = $closed $kondisi_jobdesk
                                $kondisi
                              GROUP BY
                                mom.id_mom 
                              ) AS dep ON dep.id_mom = mom.id_mom 
                            WHERE
                              mom.closed = $closed $kondisi_jobdesk
                              $kondisi
                            GROUP BY
                              mom.id_mom) AS final $kondisi_new")->result();
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
                CONCAT( em.first_name, ' ', em.last_name, ' | ', dp.department_name, ' - ', comp.kode ) AS employee_name  
              FROM
                hris.xin_employees AS em
                LEFT JOIN xin_departments AS dp ON dp.department_id = em.department_id
                LEFT JOIN xin_companies AS comp ON comp.company_id = em.company_id
              WHERE
                em.is_active = 1 
                AND em.`user_id` <> 1";
    return $this->db->query($query)->result();
  }

  function get_kategori()
  {
    return $this->db->query("SELECT * FROM mom_kategori WHERE id IN (1,8,9,10,12,13,14)")->result();
  }

  function get_kategori_new()
  {
    return $this->db->query("SELECT * FROM mom_kategori WHERE id IN (1,8,9,10)")->result();
  }

  function get_kategori_new2()
  {
    return $this->db->query("SELECT * FROM mom_kategori WHERE id IN (1,8,9,10,12,13,14)")->result();
  }

  function get_level()
  {
    return $this->db->query("SELECT id, `level`, `day`, color, ket_level AS leveling FROM mom_level")->result();
  }

  function get_total_kategori()
  {
    return $this->db->query("SELECT COUNT(id) AS total FROM mom_kategori WHERE id IN (1,2,8,9,10)")->row_array();
  }

  function cek_topik($id_mom, $id_issue)
  {
    $this->db->where('id_mom', $id_mom);
    $this->db->where('id_issue', $id_issue);
    return $this->db->get('mom_issue')->num_rows();
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
    $company_id     = $_SESSION['company_id'];
    $designation_id = $_SESSION['designation_id'];

    $list_designation = [1217, 1218]; // HRBP Manager, Officer
    $list_super       = [1139, 8892, 8970, 4138, 5385, 329, 4498, 5121, 9645,979,10127]; // alfin3333, ratih, sandi2696

    $join = "";
    // if ($user_id == "803") { // Pak Ibnu
    //   $cond = "AND pic.user_id IN ('$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76','2505','476')";
    // } else 
    if (in_array($user_id, $list_super) || $department_id == 117 || $role_id == 1 || in_array($designation_id, $list_designation)) { // Viky, Lintang Sekdir, Div PDCA, Super Admin, Farhan HRBP
      $cond = "";
    } else if ($role_id == 2) { // Head
      $cond = "AND (pic.department_id = $department_id OR pic.user_id = $user_id)";
    } else if ($role_id == 3) { // Manager
      $cond = "AND pic.department_id = $department_id AND (pic.user_role_id <> 2 OR pic.user_id = $user_id)";
    } else if ($user_id == 70 || $user_id == 2729 || $user_id == 321) { // nining27, saeroh1425, Andre22
      $cond = "AND ((pic.company_id IN (1,4,5) AND pic.user_role_id NOT IN (1,2,10)) OR pic.user_id = $user_id)";
    } else if ($user_id == 4499) { // elia2700
      $join = "LEFT JOIN rsp_project_live.`user` AS rsp ON rsp.id_hr = pic.user_id";
      $cond = "AND (pic.department_id = 106 OR rsp.id_divisi = 6 OR pic.user_id = $user_id)"; // Project
    } else if ($user_id == 2735 || $user_id == 1186 || $user_id == 3690) { // siti1423 dan idham, addnew Aldina2114
      $join = "LEFT JOIN rsp_project_live.`user` AS rsp ON rsp.id_hr = pic.user_id";
      $cond = "AND (pic.department_id IN( 106,142,207,204,210,205,206,211) OR rsp.id_divisi = 6 OR pic.user_id = $user_id)"; // Project
    } else if (in_array($user_id, [3650, 3651, 2505, 4954, 5078])) { // supri, andre, puput1261, rochmat2962, aisyah3066
      $join = "LEFT JOIN rsp_project_live.`user` AS rsp ON rsp.id_hr = pic.user_id";
      $cond = "AND ((pic.department_id IN (120,154,155) AND rsp.id_divisi = 2) OR pic.user_id = $user_id)"; // Marketing
    } else {
      $cond = "AND pic.user_id = '$user_id'";
    }

    // Tambahan Kondisi Khusus karena Role : 3 | Manager
    if ($user_id == 5197) { // hience3160 Akses All Marketing
      $join = "LEFT JOIN rsp_project_live.`user` AS rsp ON rsp.id_hr = pic.user_id";
      $cond = "AND (pic.department_id IN ($department_id,120,154,155) OR rsp.id_divisi = 2)"; // Marketing
    }

    // Tambahan Kondisi Khusus karena Role : 3 | Manager
    if ($user_id == 2378) { // ilham1150
      $join = "LEFT JOIN rsp_project_live.`user` AS rsp ON rsp.id_hr = pic.user_id";
      $cond = "AND (pic.department_id IN ($department_id,93,106,111,138,142,151,181) OR pic.user_id = $user_id)";
    }

    $join = "";
    $cond = "";

    return $this->db->query("SELECT 
      pic.user_id,
      pic.username,
      CONCAT(pic.first_name, ' ', pic.last_name) AS employee_name,
      dg.designation_name AS jabatan,
      item.kategori,
      item.id_sub_task,
      
      -- Mingguan
      COUNT(IF(weekly.`week` = 1, 1, NULL)) AS w1,
      COUNT(IF(weekly.`week` = 2, 1, NULL)) AS w2,
      COUNT(IF(weekly.`week` = 3, 1, NULL)) AS w3,
      COUNT(IF(weekly.`week` = 4, 1, NULL)) AS w4,
      COUNT(IF(weekly.`week` = 5, 1, NULL)) AS w5,
      COUNT(IF(weekly.`week` = 6, 1, NULL)) AS w6,
      
      -- Kategori
      COUNT(IF(item.kategori = 1, 1, NULL)) AS tasklist,
      COUNT(IF(item.kategori = 12, 1, NULL)) AS grd,
      COUNT(IF(item.kategori = 8, 1, NULL)) AS daily,
      COUNT(IF(item.kategori = 9, 1, NULL)) AS weekly,
      COUNT(IF(item.kategori = 10, 1, NULL)) AS monthly,
      
      -- Status
      COUNT(IF(ibr.`status` != 3, 1, NULL)) AS progres,
      COUNT(IF(ibr.`status` = 2 AND item.verified_status = 2, 1, NULL)) AS revisi,
      COUNT(IF(ibr.`status` = 2 AND item.owner_verified_status = 2, 1, NULL)) AS revisi_owner,
      COUNT(IF(ibr.`status` = 3 AND COALESCE(item.verified_status,0) <> 2, 1, NULL)) AS done,
      
      -- Waktu
      COUNT(IF(DATEDIFF(IF(ibr.`status` = 3 AND item.freq_revisi IS NULL, COALESCE(DATE(his_sub_task.sub_done_date),DATE(ibr.done_date)),NULL), item.deadline) < 1, 1, NULL)) AS ontime,
      COUNT(IF(DATEDIFF(IF(ibr.`status` = 3 AND item.freq_revisi IS NULL, COALESCE(DATE(his_sub_task.sub_done_date),DATE(ibr.done_date)),NULL), item.deadline) > 0, 1, NULL)) AS late,
      
      -- Lain-lain
      SUM(COALESCE(item.freq_revisi, 0)) AS freq_revisi,
      COALESCE(kunci.total_lock, 0) AS total_lock
      
    FROM 
      mom_issue_item AS item
      
      -- Join tabel
      LEFT JOIN xin_employees AS pic ON FIND_IN_SET(pic.user_id, item.pic) AND pic.is_active = 1
      $join
      LEFT JOIN xin_designations AS dg ON dg.designation_id = pic.designation_id
      LEFT JOIN mom_header AS mom ON mom.id_mom = item.id_mom
      LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
      LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
      LEFT JOIN (
        SELECT 
          trusmi_history_lock.employee_id, 
          COUNT(trusmi_history_lock.employee_id) AS total_lock
        FROM 
          trusmi_history_lock
        WHERE 
          reason = 'Tasklist IBR Pro dari MoM belum selesai, mohon cek detail lock pada resume MoM yang tersedia.'
          AND trusmi_history_lock.created_at BETWEEN '$start' AND '$end'
        GROUP BY 
          trusmi_history_lock.employee_id
      ) AS kunci ON kunci.employee_id = pic.user_id
      LEFT JOIN (
      SELECT 
        id_sub_task, 
        id_task, 
        MAX(created_at) AS sub_done_date
      FROM 
        td_sub_task_history
      -- WHERE 
      --  progress = 100
      GROUP BY 
        id_sub_task, 
        id_task
    ) AS his_sub_task ON his_sub_task.id_task = item.id_task AND his_sub_task.id_sub_task = item.id_sub_task
      LEFT JOIN (
        SELECT 
          date, 
          (WEEK(all_dates.date, 3) - WEEK(DATE_SUB(all_dates.date, INTERVAL DAY(all_dates.date) - 1 DAY), 3) + 1) AS `week`
        FROM 
          all_dates
        WHERE 
          SUBSTR(all_dates.date, 1, 7) = SUBSTR('$start', 1, 7)
      ) AS weekly ON IF(CURDATE() <= item.deadline, item.deadline, ibr.due_date) = weekly.date
      
    WHERE 
      mom.closed = 1
      -- AND mom.meeting NOT IN ('Jobdesk')
      AND item.kategori IS NOT NULL
      AND item.kategori IN (1,12,8,9,10)
      AND (ibr.due_date BETWEEN '$start' AND '$end' OR item.deadline BETWEEN '$start' AND '$end')
      $cond
    GROUP BY 
      pic.user_id
      ")->result();
  }

  function get_detail_rekap($start, $end, $user, $tipe)
  {
    if ($tipe == 30) {
      $kondisi = "AND ibr.`status` IN (1,2)";
    } else if ($tipe == 40) {
      $kondisi = "AND ibr.`status` = 3 AND COALESCE(item.verified_status,0) <> 2";
    } else if ($tipe == 50) {
      $kondisi = "AND DATEDIFF(IF(ibr.`status` = 3 AND item.freq_revisi IS NULL, COALESCE(DATE(his_sub_task.sub_done_date),DATE(ibr.done_date)),NULL), item.deadline) < 1";
    } else if ($tipe == 60) {
      $kondisi = "AND DATEDIFF(IF(ibr.`status` = 3 AND item.freq_revisi IS NULL, COALESCE(DATE(his_sub_task.sub_done_date),DATE(ibr.done_date)),NULL), item.deadline) > 0";
    } else if ($tipe == 70) { //revisi
      $kondisi = "AND ibr.`status` = 2 AND item.verified_status = 2";
    } else if ($tipe == 80) { //revisi owner
      $kondisi = "AND ibr.`status` = 2 AND item.owner_verified_status = 2";
    } else if ($tipe == 90) {
      $kondisi = "AND ibr.`status` = 3 AND item.freq_revisi IS NOT NULL";
    } else if ($tipe == 'w1') {
      $kondisi = "AND weekly.`week` = 1";
    } else if ($tipe == 'w2') {
      $kondisi = "AND weekly.`week` = 2";
    } else if ($tipe == 'w3') {
      $kondisi = "AND weekly.`week` = 3";
    } else if ($tipe == 'w4') {
      $kondisi = "AND weekly.`week` = 4";
    } else if ($tipe == 'w5') {
      $kondisi = "AND weekly.`week` = 5";
    } else if ($tipe == 'w6') {
      $kondisi = "AND weekly.`week` = 6";
    } else {
      $kondisi = "AND item.kategori = $tipe";
      // $kondisi = "";
    }
    return $this->db->query("SELECT 
      item.id_mom,
      md5(item.id_mom) AS en_id_mom,
      mom.tgl AS tgl_meeting,
      weekly.`week`,
      pic.user_id,
      pic.username,
      CONCAT(pic.first_name, ' ', pic.last_name) AS employee_name,
      COALESCE(issue.topik, '') AS topik,
      issue.issue,
      item.action,
      item.kategori AS id_kategori,
      kat.kategori,
      item.level AS id_level,
      lvl.level,
      ibr.due_date,
      item.deadline,
      ibr.`status` AS id_status,
      COALESCE(sts.`status`, '') AS `status`,
      sts.color,
      DATE(ibr.done_date) AS done_date,
      COALESCE(DATE(his_sub_task.sub_done_date),DATE(ibr.done_date)) AS sub_done_date,
      DATEDIFF(DATE(ibr.done_date), item.deadline) AS leadtime,
      sub.evaluasi,
      COALESCE(sub.progress, 0) AS progres,
      COALESCE(attch.`file`, '') AS `file`,
      COALESCE(attch.link, '') AS link,
      mom.created_at,
      CONCAT(em.first_name, ' ', em.last_name) AS created_by,
      
      -- Kondisi locked
      CASE 
        WHEN item.deadline BETWEEN '2024-01-05' AND CURDATE() 
          AND COALESCE(sub.progress, 0) < 100 
          AND ibr.`status` < 3 
          AND item.verified_status IS NULL 
        THEN 'Locked'
        
        WHEN item.deadline BETWEEN '2024-01-05' AND CURDATE() 
          AND ibr.`status` = 2
          AND (item.verified_status = 2 OR item.owner_verified_status = 2)
        THEN 'Locked'
        
        
        WHEN ibr.due_date BETWEEN '2024-01-05' AND CURDATE() 
          AND ibr.`status` < 3 
        THEN 'Locked'
        
        ELSE 'Unlocked' 
      END AS locked,
      
      item.id_sub_task,
      item.verified_note
      
    FROM 
      mom_issue_item AS item
      
      -- Join tabel
      LEFT JOIN xin_employees AS pic ON FIND_IN_SET(pic.user_id, item.pic)
      LEFT JOIN mom_issue AS issue ON issue.id_mom = item.id_mom AND issue.id_issue = item.id_issue
      LEFT JOIN mom_header AS mom ON mom.id_mom = item.id_mom
      LEFT JOIN xin_employees AS em ON em.user_id = mom.created_by
      LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
      LEFT JOIN mom_level AS lvl ON lvl.id = item.level
      LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
      LEFT JOIN td_sub_task AS sub ON ibr.id_task = item.id_task AND sub.id_sub_task = item.id_sub_task
      LEFT JOIN td_status AS sts ON sts.id = ibr.`status`
      LEFT JOIN (
        SELECT 
          id_sub_task, 
          id_task, 
          SUM(progress) AS progres, 
          MAX(file) AS `file`, 
          MAX(link) AS link
        FROM 
          td_sub_task_history
        GROUP BY 
          id_sub_task, 
          id_task
      ) AS attch ON attch.id_task = item.id_task AND attch.id_sub_task = item.id_sub_task
      LEFT JOIN (
      SELECT 
        id_sub_task, 
        id_task, 
        MAX(created_at) AS sub_done_date
      FROM 
        td_sub_task_history
      -- WHERE 
      --  progress = 100
      GROUP BY 
        id_sub_task, 
        id_task
    ) AS his_sub_task ON his_sub_task.id_task = item.id_task AND his_sub_task.id_sub_task = item.id_sub_task
      LEFT JOIN (
        SELECT 
          date, 
          (WEEK(all_dates.date, 3) - WEEK(DATE_SUB(all_dates.date, INTERVAL DAY(all_dates.date) - 1 DAY), 3) + 1) AS `week`
        FROM 
          all_dates
        WHERE 
          SUBSTR(all_dates.date, 1, 7) = SUBSTR('$start', 1, 7)
      ) AS weekly ON IF(CURDATE() <= item.deadline, item.deadline, ibr.due_date) = weekly.date
      
    WHERE 
      ( ibr.due_date BETWEEN '$start' AND '$end' 
        OR item.deadline BETWEEN '$start' AND '$end')
      -- AND mom.meeting NOT IN ('Jobdesk')
      AND item.kategori IS NOT NULL
      AND pic.user_id = '$user'
      AND mom.closed = 1
      $kondisi
      -- GROUP BY item.id
      ")->result();
  }

  // function resume_get_list_rekap($start, $end)
  // {
  //   $user_id = $_SESSION['user_id'];
  //   if ($user_id == 803) {
  //     // 786 = Abdul Goffar,
  //     // 1434 = Alfiyawati Santika,
  //     // 2 = Ali Yasin,
  //     // 1449 = Angga Nur Fardiansah,
  //     // 2964 = Bregas Prakoso,
  //     // 77 = Fani Fitrianingsih,
  //     // 331 = Feronita,
  //     // 2397 = Firman Tigoastomo Basuki,
  //     // 323 = Hendra Arya Cahyadi,
  //     // 1186 = Idham Nurhakim Dipura,
  //     // 90 = Indra Bayu Ramadhani,
  //     // 355 = Mochamad Ridwan,
  //     // 68 = Syekh Farhan Robbani,
  //     // 76 = Yeyen Nuryenti 
  //     $cond = "AND pic.user_id IN ('$user_id','786','1434','2','1449','820','77','331','2397','323','1186','90','355','68','76')";
  //   } else {
  //     $cond = "";
  //   }
  //   return $this->db->query("SELECT
  //                             pic.user_id,
  //                             pic.username,
  //                             CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
  //                             COUNT(IF(item.kategori IN (1,6,8,9,10),1,NULL)) AS tasklist,
  //                             COUNT(IF(item.kategori <> 1,1,NULL)) AS non_tasklist,
  //                             COUNT(IF(ibr.`status` IN (1,2),1,NULL)) AS progres,
  //                             COUNT(IF(ibr.`status` = 3,1,NULL)) AS done,
  //                             COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1,1,NULL)) AS ontime,
  //                             COUNT(IF(DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0,1,NULL)) AS late
  //                           FROM
  //                             mom_issue_item as item
  //                             JOIN xin_employees AS pic ON FIND_IN_SET(pic.user_id,item.pic)
  //                             JOIN mom_header as mom ON mom.id_mom = item.id_mom
  //                             JOIN mom_kategori AS kat ON kat.id = item.kategori
  //                             LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
  //                           WHERE
  //                             mom.tgl BETWEEN '$start' AND '$end' $cond
  //                           GROUP BY
  //                             pic.user_id")->result();
  // }

  // function resume_get_detail_rekap($start, $end, $user, $tipe)
  // {
  //   if ($tipe == 1) {
  //     $kondisi = "AND item.kategori IN (1,6,8,9,10)";
  //   } else if ($tipe == 2) {
  //     $kondisi = "AND item.kategori <> 1";
  //   } else if ($tipe == 3) {
  //     $kondisi = "AND ibr.`status` IN (1,2)";
  //   } else if ($tipe == 4) {
  //     $kondisi = "AND ibr.`status` = 3";
  //   } else if ($tipe == 5) {
  //     $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) < 1";
  //   } else if ($tipe == 6) {
  //     $kondisi = "AND DATEDIFF(DATE(ibr.done_date),ibr.due_date) > 0";
  //   } else {
  //     $kondisi = "";
  //   }
  //   return $this->db->query("SELECT
  //                             mom.tgl AS tgl_meeting,
  //                             pic.user_id,
  //                             pic.username,
  //                             CONCAT(pic.first_name,' ',pic.last_name) AS employee_name,
  //                             issue.issue,
  //                             item.action,
  //                             item.kategori AS id_kategori,
  //                             kat.kategori,
  //                             item.deadline,
  //                             ibr.`status` AS id_status,
  //                             COALESCE(sts.`status`,'') AS `status`,
  //                             sts.color,
  //                             ibr.done_date,
  //                             sub.evaluasi 
  //                           FROM
  //                             mom_issue_item AS item
  //                             JOIN xin_employees AS pic ON FIND_IN_SET( pic.user_id, item.pic )
  //                             JOIN mom_issue AS issue ON issue.id_mom = item.id_mom AND issue.id_issue = item.id_issue
  //                             JOIN mom_header AS mom ON mom.id_mom = item.id_mom
  //                             JOIN mom_kategori AS kat ON kat.id = item.kategori
  //                             LEFT JOIN td_task AS ibr ON ibr.id_task = item.id_task
  //                             LEFT JOIN td_sub_task AS sub ON ibr.id_task = item.id_task AND sub.id_sub_task = item.id_sub_task
  //                             LEFT JOIN td_status AS sts ON sts.id = ibr.`status`
  //                           WHERE
  //                             mom.tgl BETWEEN '$start' 
  //                             AND '$end'
  //                             AND pic.user_id = '$user'
  //                             $kondisi")->result();
  // }

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
                              CONCAT('MEETING ',UPPER(meeting)) AS meeting,
                              meeting AS tipe_meeting,
                              REPLACE(GROUP_CONCAT( CONCAT(dp.department_name,' - ',comp.kode) ),',',', ') AS department,
                              agenda,
                              agenda,
                              pembahasan,
                              closing_statement
                            FROM
                              mom_header 
                              LEFT JOIN xin_departments AS dp ON FIND_IN_SET(dp.department_id, mom_header.department)
                              LEFT JOIN xin_companies AS comp ON comp.company_id = dp.company_id
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
    // return $this->db->query("SELECT id_mom, id_issue, issue FROM mom_issue WHERE md5(id_mom) = '$id' AND is_eskalasi IS NULL")->result();
    return $this->db->query("SELECT
                              mom_issue.id_mom,
                              mom_issue.id_issue,
                              mom_issue.issue,
                              ai.`status` AS status_solving,
                              ai.no_ps
                            FROM
                              mom_issue 
                              LEFT JOIN ( SELECT * FROM ai_problem_solving WHERE `status` = 'solved' GROUP BY id_mom, id_issue ) AS ai ON ai.id_mom = mom_issue.id_mom AND ai.id_issue = mom_issue.id_issue
                            WHERE
                              md5( mom_issue.id_mom ) = '$id'
                              AND mom_issue.is_eskalasi IS NULL")->result();
  }

  function print_issue_detail($start, $end)
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];

    $kondisi_new = "";
    if ($role_id == 1 || in_array($user_id, [1139, 8892, 8970, 803, 2951, 4138])) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
      $kondisi = "";
    } else if ($role_id == 2 || $role_id == 3) { // Role Head Department, Manager
      // Munculkan Created By User Department
      $kondisi = "AND FIND_IN_SET($department_id,CONCAT(GROUP_CONCAT(ps.department_id),',',item.dep_pic)) OR created.department_id = $department_id";
    } else if ($department_id == 117) { // PDCA RSP
      $kondisi = "AND (mom.created_by = $user_id OR created.company_id = 2)";
    } else {
      $kondisi = "AND FIND_IN_SET($user_id,CONCAT( mom.peserta, ',', item.pic )) OR mom.created_by = $user_id";
    }

    return $this->db->query("SELECT
                              issue.id_mom,
                              mom.judul,
                              issue.id_issue,
                              issue.issue
                            FROM
                              mom_issue AS issue
                              JOIN mom_header AS mom ON mom.id_mom = issue.id_mom
                              JOIN (
                              SELECT
                                item.id_mom,
                                item.id_issue,
                                GROUP_CONCAT( em.user_id ) AS pic,
                                GROUP_CONCAT( em.department_id ) AS dep_pic 
                              FROM
                                ( SELECT id_mom, id_issue, GROUP_CONCAT( pic ) AS pic FROM mom_issue_item AS item GROUP BY id_mom, id_issue ) AS item
                                LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic ) 
                              GROUP BY
                                item.id_mom,
                                item.id_issue 
                              ) AS item ON item.id_mom = issue.id_mom 
                              AND item.id_issue = issue.id_issue
                              LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by
                              LEFT JOIN xin_employees AS ps ON FIND_IN_SET( ps.user_id, mom.peserta ) 
                            WHERE
                              mom.closed = 1 
                              AND mom.tgl BETWEEN '$start' 
                              AND '$end' 
                            GROUP BY
                              issue.id_mom,
                              issue.id_issue
                            ORDER BY
                              issue.id_mom")->result();
  }

  function print_issue_item($id_mom, $id_issue)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              item.id,
                              item.id_task,
                              item.id_sub_task,
                              issue.topik,
                              issue.issue,
                              item.action,
                              kat.id AS id_kategori,
                              kat.kategori,
                              item.level AS id_level,
                              lvl.level,
                              lvl.color,
                              item.deadline AS deadline_e,
                              DATE_FORMAT( item.deadline, '%d %b %Y' ) AS deadline,
                              GROUP_CONCAT( DISTINCT 
                              CONCAT( em.first_name, ' ', em.last_name )) AS pic,
                              td_task.`status` AS id_status,
                              td_status.`status`,
                              td_status.`label`,
                              td_sub_task.evaluasi,
                              COALESCE(td_sub_task.status,'') AS id_status_strategy,
                              COALESCE(ss.status,'') AS status_strategy,
                              COALESCE(apr.status,'') AS status_approval,
                              COALESCE(apr.color_status,'') AS color_status_approval,
                              COALESCE(mtask.file,'') AS `file`,
                              mtask.link,
                              item.ekspektasi,
                              item.verified_status AS id_status_verified,
                              COALESCE(item.freq_revisi,0) AS freq_revisi,
                              CASE 
                              WHEN item.verified_status = 1 THEN 'Oke'
                              WHEN item.verified_status = 2 THEN 'Tidak Oke'
                              WHEN item.verified_status = 3 THEN 'Oke Meeting'
                              ELSE NULL
                              END AS verified_status,
                              item.verified_note,
                              CONCAT(ver.first_name,' ', ver.last_name) AS verified_by,
                              item.owner_verified_status AS id_owner_verified_status,
                              CASE 
                              WHEN item.owner_verified_status = 1 THEN 'Oke Result'
                              WHEN item.owner_verified_status = 2 THEN 'Tidak Oke'
                              WHEN item.owner_verified_status = 3 THEN 'Oke Meeting'
                              ELSE NULL
                              END AS owner_verified_status,
                              item.owner_verified_note,
                              item.owner_verified_by,
                              item.pdca_meeting
                            FROM
                              mom_issue AS issue
                              JOIN mom_issue_item AS item ON item.id_mom = issue.id_mom 
                              AND item.id_issue = issue.id_issue
                              LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic ) 
                              LEFT JOIN xin_employees ver ON item.verified_by = ver.user_id
                              LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN td_task ON td_task.id_task = issue.id_task
                              LEFT JOIN td_sub_task ON td_task.id_task = issue.id_task AND td_sub_task.id_sub_task = item.id_sub_task
                              LEFT JOIN td_status ON td_status.id = td_task.`status`
                              LEFT JOIN td_status_strategy ss ON ss.id = td_sub_task.status
                              LEFT JOIN mom_level AS lvl ON lvl.id = item.level
                              LEFT JOIN (SELECT
                                  tipe,
                                  id_mom,
                                  id_issue,
                                  id_issue_item,
                                CASE
                                    WHEN waiting > 0 THEN
                                    'Waiting Feedback' 
                                    WHEN reject > 0 THEN
                                    'Reject Feedback' 
                                    WHEN `end` > 0 THEN
                                    'End Feedback' ELSE 'ACC Feedback' 
                                  END AS `status`,
                                CASE
                                    WHEN waiting > 0 THEN
                                    'label label-outline-warning' 
                                    WHEN reject > 0 THEN
                                    'label label-outline-danger' 
                                    WHEN `end` > 0 THEN
                                    'label label-outline-dark' ELSE 'label label-outline-success' 
                                  END AS color_status 
                                FROM
                                  (
                                  SELECT
                                    tipe,
                                    id_mom,
                                    id_issue,
                                    id_issue_item,
                                    COUNT(IF( `status` IN ( 1, 4, 5, 6 ), 1, NULL )) AS waiting,
                                    COUNT(IF( `status` = 2, 1, NULL )) AS acc,
                                    COUNT(IF( `status` = 3, 1, NULL )) AS reject,
                                    COUNT(IF( `status` = 7, 1, NULL )) AS `end` 
                                  FROM
                                    trusmi_approval 
                                  WHERE
                                    id_mom IS NOT NULL 
                                  GROUP BY
                                    id_mom,
                                    id_issue,
                                    id_issue_item 
                                  ) AS approval) AS apr ON apr.id_mom = item.id_mom AND apr.id_issue = item.id_issue AND apr.id_issue_item = item.id_issue_item
                              LEFT JOIN td_sub_task_history AS hs ON hs.id_sub_task = item.id_sub_task 
                              LEFT JOIN (SELECT
                                    max_task.id,
                                    max_task.id_sub_task AS idx,
                                    max_task.evaluasi,
                                    max_task.file,
                                    max_task.link 
                                  FROM
                                    td_sub_task_history AS max_task
                                    JOIN ( SELECT id_sub_task, MAX( id ) AS max_id FROM td_sub_task_history GROUP BY id_sub_task ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task 
                                    AND max_task.id = subquery_max.max_id) AS mtask ON mtask.idx = item.id_sub_task
                            WHERE
                              issue.id_mom = '$id_mom'
                              AND item.id_issue = '$id_issue' AND issue.is_eskalasi IS NULL AND item.is_eskalasi IS NULL
                            GROUP BY
                              item.id_issue_item")->result();
  }

  function print_issue_eskalasi_item($id_mom, $reff_id_sub_task)
  {
    return $this->db->query("SELECT 
	issue.id_mom,
    issue.topik,
    issue.issue,
	tas.id_task,
	subt.id_sub_task,
	item.`action`,
	tas.pic AS id_pic,
	CONCAT( em.first_name, ' ', em.last_name ) AS pic,
	kat.id AS id_kategori,
    kat.kategori,
    item.level AS id_level,
    lvl.level,
    lvl.color,
    item.deadline AS deadline_e,
    DATE_FORMAT( item.deadline, '%d %b %Y' ) AS deadline,
    tas.`status` AS id_status,
    td_status.`status`,
    td_status.`label`,
    subt.evaluasi,
    COALESCE(subt.status,'') AS id_status_strategy,
    COALESCE(ss.status,'') AS status_strategy,
    COALESCE(apr.status,'') AS status_approval,
    COALESCE(apr.color_status,'') AS color_status_approval,
    COALESCE(mtask.file,'') AS `file`,
    mtask.link,
    item.ekspektasi,
    item.verified_status AS id_status_verified,
    COALESCE(item.freq_revisi,0) AS freq_revisi,
    CASE 
        WHEN item.verified_status = 1 THEN 'Oke'
        WHEN item.verified_status = 2 THEN 'Tidak Oke'
        ELSE NULL
    END AS verified_status,
  item.verified_note,
  CONCAT(ver.first_name,' ', ver.last_name) AS verified_by,
  item.owner_verified_status AS id_owner_verified_status,
  CASE 
  WHEN item.owner_verified_status = 1 THEN 'Oke'
  WHEN item.owner_verified_status = 2 THEN 'Tidak Oke'
  ELSE NULL
  END AS owner_verified_status,
  item.owner_verified_note,
  item.owner_verified_by
FROM 
	mom_issue_item AS item
JOIN td_sub_task subt ON FIND_IN_SET( subt.id_sub_task, item.id_sub_task ) AND item.is_eskalasi = 1
LEFT JOIN mom_issue AS issue ON issue.id_mom = item.id_mom AND item.id_issue = issue.id_issue AND item.reff_id_sub_task = issue.reff_id_sub_task
LEFT JOIN td_task AS tas ON FIND_IN_SET( tas.id_task, item.id_task )
LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, tas.pic ) 
LEFT JOIN xin_employees ver ON item.verified_by = ver.user_id
LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
LEFT JOIN td_status ON td_status.id = tas.`status`
LEFT JOIN td_status_strategy ss ON ss.id = subt.status
LEFT JOIN mom_level AS lvl ON lvl.id = item.level
LEFT JOIN (SELECT
    tipe,
    id_mom,
    id_issue,
    id_issue_item,
  CASE
      WHEN waiting > 0 THEN
      'Waiting Feedback' 
      WHEN reject > 0 THEN
      'Reject Feedback' 
      WHEN `end` > 0 THEN
      'End Feedback' ELSE 'ACC Feedback' 
    END AS `status`,
  CASE
      WHEN waiting > 0 THEN
      'label label-outline-warning' 
      WHEN reject > 0 THEN
      'label label-outline-danger' 
      WHEN `end` > 0 THEN
      'label label-outline-dark' ELSE 'label label-outline-success' 
    END AS color_status 
  FROM
    (
    SELECT
      tipe,
      id_mom,
      id_issue,
      id_issue_item,
      COUNT(IF( `status` IN ( 1, 4, 5, 6 ), 1, NULL )) AS waiting,
      COUNT(IF( `status` = 2, 1, NULL )) AS acc,
      COUNT(IF( `status` = 3, 1, NULL )) AS reject,
      COUNT(IF( `status` = 7, 1, NULL )) AS `end` 
    FROM
      trusmi_approval 
    WHERE
      id_mom IS NOT NULL 
    GROUP BY
      id_mom,
      id_issue,
      id_issue_item 
    ) AS approval) AS apr ON apr.id_mom = item.id_mom AND apr.id_issue = item.id_issue AND apr.id_issue_item = item.id_issue_item
LEFT JOIN (SELECT
                                    max_task.id,
                                    max_task.id_task AS ids,
                                    max_task.id_sub_task AS idx,
                                    max_task.evaluasi,
                                    max_task.file,
                                    max_task.link 
                                  FROM
                                    td_sub_task_history AS max_task
                                    JOIN ( SELECT id_task, id_sub_task, MAX( id ) AS max_id FROM td_sub_task_history GROUP BY id_sub_task ) AS subquery_max ON max_task.id_task = subquery_max.id_task 
                                    AND max_task.id = subquery_max.max_id) AS mtask ON mtask.ids = tas.id_task
WHERE 
	issue.id_mom = '$id_mom' AND item.reff_id_sub_task = '$reff_id_sub_task'
GROUP BY tas.id_task
ORDER BY tas.id_task")->result();
  }

  function get_send_wa($id_mom)
  {
    return $this->db->query("SELECT
                      mom.id_mom,
                      mom.judul,
                      mom.tempat,
                      DATE_FORMAT(mom.tgl, '%d %b %Y') AS tgl,
                      mom.waktu,
                      mom.agenda,
                      mom.peserta,
                      mom.pembahasan,
                      mom.closing_statement,
                      em.user_id,
                      GROUP_CONCAT(
                        REPLACE(REPLACE(REPLACE(em.contact_no, ' ', ''), '+', ''), '-', '')
                      ) AS kontak,
                      CONCAT('https://trusmiverse.com/apps/pr/mom/', MD5(mom.id_mom)) AS link
                    FROM (
                      SELECT
                        mom.id_mom,
                        mom.judul,
                        mom.tempat,
                        mom.tgl,
                        CONCAT(LEFT(mom.start_time, 5), ' - ', LEFT(mom.end_time, 5)) AS waktu,
                        mom.agenda,
                        GROUP_CONCAT(CONCAT(em.first_name, ' ', em.last_name)) AS peserta,
                        CONCAT(mom.peserta, ',', COALESCE(item.pic, ''), ',', COALESCE(mom.cc, '')) AS pic,
                        mom.pembahasan,
                        mom.closing_statement
                      FROM
                        mom_header AS mom
                        JOIN (
                          SELECT id_mom, GROUP_CONCAT(pic) AS pic
                          FROM mom_issue_item
                          WHERE id_mom = '$id_mom'
                          GROUP BY id_mom
                        ) AS item ON item.id_mom = mom.id_mom
                        LEFT JOIN xin_employees AS em ON FIND_IN_SET(em.user_id, mom.peserta)
                      WHERE
                        mom.id_mom = '$id_mom'
                    ) AS mom
                    LEFT JOIN (
                      SELECT
                        user_id,
                        IF(LEFT(contact_no, 1) = '0', CONCAT('62', SUBSTR(contact_no, 2)), contact_no) AS contact_no
                      FROM
                        xin_employees
                    ) AS em ON FIND_IN_SET(em.user_id, mom.pic)
                    GROUP BY
                      em.user_id
                    ")->result_array();
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
                              REPLACE ( REPLACE ( REPLACE ( em.kontak, ' ', '' ), '+', '' ), '-', '' ) AS kontak_pic,
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
                              em.user_id,
                              CONCAT(
                                'https://trusmiverse.com/apps/pr/mom/',
                              md5( mom.id_mom )) AS link 
                            FROM
                              (
                              SELECT
                                mom_issue_item.id_mom,
                                mom_issue_item.id_issue,
                                mom_issue_item.id_issue_item,
                                mom_issue_item.kategori,
                                mom_issue_item.deadline,
                                mom_issue_item.pic,
                                mom_issue_item.id_task,
                                mom_issue_item.id_sub_task,
                                td_task.`status`
                              FROM
                                mom_issue_item 
                                LEFT JOIN td_task ON td_task.id_task = mom_issue_item.id_task
                              WHERE
                                mom_issue_item.kategori IN ( 1, 5, 6, 8, 9, 10, 11 ) 
                                AND CURDATE() = DATE_SUB( mom_issue_item.deadline, INTERVAL 1 DAY ) 
                              GROUP BY
                                mom_issue_item.id_mom,
                                mom_issue_item.id_issue,
                                mom_issue_item.pic 
                              ) AS item
                              JOIN mom_issue AS issue ON issue.id_issue = item.id_issue 
                              AND issue.id_mom = item.id_mom
                              JOIN mom_header AS mom ON mom.id_mom = item.id_mom
                              LEFT JOIN (
                              SELECT
                                user_id,
                                CONCAT( first_name, ' ', last_name ) AS employee_name,
                              IF
                                ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS kontak 
                              FROM
                                xin_employees 
                              ) AS em ON FIND_IN_SET( em.user_id, item.pic )
                              LEFT JOIN ( SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name FROM xin_employees ) AS ps ON FIND_IN_SET( ps.user_id, mom.peserta ) 
                            WHERE
                              mom.closed = 1
                              AND item.`status` IN (1,2)
                            GROUP BY
                              em.user_id,
                              item.id_mom")->result_array();
  }

  // Data untuk Autonotif ketika H dari Deadline tiap 3 jam
  function mom_autonotif_deadline()
  {
    return $this->db->query("SELECT
   item.id_mom,
   item.id_issue,
   item.id_issue_item,
   item.deadline,
   em.employee_name,
   REPLACE ( REPLACE ( REPLACE ( em.kontak, ' ', '' ), '+', '' ), '-', '' ) AS kontak_pic,
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
   CONCAT(
     'https://trusmiverse.com/apps/pr/mom/',
   md5( mom.id_mom )) AS link 
 FROM
   (
   SELECT
     mom_issue_item.id_mom,
     mom_issue_item.id_issue,
     mom_issue_item.id_issue_item,
     mom_issue_item.kategori,
     mom_issue_item.deadline,
     mom_issue_item.pic,
     mom_issue_item.id_task,
     mom_issue_item.id_sub_task,
     td_task.`status` 
   FROM
     mom_issue_item
     LEFT JOIN td_task ON td_task.id_task = mom_issue_item.id_task 
   WHERE
     mom_issue_item.kategori IN ( 1, 5, 6, 8, 9, 10, 11 ) 
     AND mom_issue_item.deadline = CURDATE()
   GROUP BY
     mom_issue_item.id_mom,
     mom_issue_item.id_issue,
     mom_issue_item.pic 
   ) AS item
   JOIN mom_issue AS issue ON issue.id_issue = item.id_issue 
   AND issue.id_mom = item.id_mom
   JOIN mom_header AS mom ON mom.id_mom = item.id_mom
   LEFT JOIN (
   SELECT
     user_id,
     CONCAT( first_name, ' ', last_name ) AS employee_name,
   IF
     ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS kontak 
   FROM
     xin_employees 
   ) AS em ON FIND_IN_SET( em.user_id, item.pic )
   LEFT JOIN ( SELECT user_id, CONCAT( first_name, ' ', last_name ) AS employee_name FROM xin_employees ) AS ps ON FIND_IN_SET( ps.user_id, mom.peserta ) 
 WHERE
   mom.closed = 1 
   AND item.`status` IN ( 1, 2 ) 
 GROUP BY
   em.user_id,
   item.id_mom")->result_array();
  }

  function get_result_meeting($id)
  {
    return $this->db->query("SELECT
                              issue.id_mom,
                              issue.id_issue,
                              COALESCE(issue.topik,'') AS topik,
                              issue.issue,
                              item.id_issue_item,
                              item.id_task,
                              item.id_sub_task,
                              item.action,
                              COALESCE(item.kategori,'') AS id_kategori,
                              kat.kategori,
                              COALESCE(item.level,'') AS id_level,
                              COALESCE(lvl.level,'') AS `level`,
                              COALESCE(item.deadline,'') AS deadline,
                              item.pic,
                              GROUP_CONCAT( COALESCE(em.employee_name,'') ) AS list_pic,
                              item.ekspektasi,
                              CASE 
                              WHEN item.verified_status = 1 THEN 'Oke'
                              WHEN item.verified_status = 2 THEN 'Tidak Oke'
                              ELSE NULL
                              END AS verified_status,
                              item.verified_note,
                              CONCAT(vr.first_name,' ',vr.last_name) AS verified_by
                            FROM
                              mom_issue AS issue
                              JOIN mom_issue_item AS item ON item.id_mom = issue.id_mom AND item.id_issue = issue.id_issue
                              LEFT JOIN xin_employees vr ON vr.user_id = item.verified_by
                              LEFT JOIN (SELECT user_id, CONCAT(first_name,' ',last_name) AS employee_name FROM xin_employees) AS em ON FIND_IN_SET( em.user_id, item.pic )
                              LEFT JOIN mom_kategori AS kat ON kat.id = item.kategori
                              LEFT JOIN mom_level AS lvl ON lvl.id = item.level
                            WHERE
                              issue.id_mom = '$id' AND issue.is_eskalasi IS NULL
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
                              MAX( issue.deadline ) AS deadline,
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
                                AND item.kategori IN (1,5,6,8,9,10,11) 
                              GROUP BY
                                issue.id_issue,
                                em.user_id 
                              ) AS issue 
                            GROUP BY
                              issue.id_issue
                            ORDER BY
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
                              item.kategori,
                              item.grdsi,
                              si.si,
                              so.so,
                              so.divisi
                            FROM
                              mom_issue_item AS item
                              JOIN mom_issue AS issue ON issue.id_mom = item.id_mom 
                              AND issue.id_issue = item.id_issue
                              LEFT JOIN grd_t_si AS si ON si.id_si = item.grdsi
                              LEFT JOIN grd_m_so AS so ON so.id_so = si.id_so
                            WHERE
                              issue.id_mom = '$id_mom' 
                              AND item.id_issue = '$id_issue' 
                              AND item.kategori IN (1,5,6,8,9,10,11)
                            ORDER BY
                              item.id_issue,
                              item.id_issue_item")->result();
  }

  function get_issue_item_grd($id_mom)
  {
    return $this->db->query("SELECT
                                  issue.id_mom,
                                  issue.issue,
                                  item.id_issue,
                                  item.id_issue_item,
                                  item.action,
                                  item.deadline,
                                  item.pic,
                                  item.kategori,
                                  item.ekspektasi,
                                  item.grdsi,
                                  si.si,
                                  so.so,
                                  so.divisi
                                FROM
                                  mom_issue_item AS item
                                  JOIN mom_issue AS issue ON issue.id_mom = item.id_mom 
                                  AND issue.id_issue = item.id_issue 
                                  LEFT JOIN grd_t_si AS si ON si.id_si = item.grdsi
                                  LEFT JOIN grd_m_so AS so ON so.id_so = si.id_so
                                WHERE
                                  issue.id_mom = '$id_mom'
                                  AND item.kategori IN ( 12 ) 
                                ORDER BY
                                  item.id_issue,
                                  item.id_issue_item")->result();
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
                              meeting,
                              department,
                              agenda,
                              peserta,
                              pembahasan,
                              closing_statement,
                              mom_header.created_at,
                              mom_header.created_by,
                              closed,
                              mom_header.project as id_project,
                              mom_header.pekerjaan as id_pekerjaan,
                              mom_header.sub_pekerjaan as id_sub_pekerjaan,
                              mom_header.detail_pekerjaan as id_detail_pekerjaan,
                              m_pekerjaan.pekerjaan as nama_pekerjaan, 
                              m_sub_pekerjaan.sub_pekerjaan as nama_sub_pekerjaan, 
                              GROUP_CONCAT(t_detail_pekerjaan_old.detail) as nama_detail_pekerjaan,
                              m.project as nama_project
                            FROM
                              mom_header 
                              LEFT JOIN rsp_project_live.m_project m ON m.id_project = mom_header.project
                              LEFT JOIN m_pekerjaan ON m_pekerjaan.id = mom_header.pekerjaan
                              LEFT JOIN m_sub_pekerjaan ON m_sub_pekerjaan.id = mom_header.sub_pekerjaan
                              LEFT JOIN t_detail_pekerjaan_old ON FIND_IN_SET(t_detail_pekerjaan_old.id,mom_header.detail_pekerjaan)
                            WHERE
                              id_mom = '$id' 
                              AND closed = 0
                              GROUP BY mom_header.id_mom")->row_array();
  }

  // Result Draft
  function get_issue_result($id_mom)
  {
    $query = "SELECT
        mom_issue.id_issue,
        mom_issue.topik,
        mom_issue.issue,
        mom_issue_item.id_goal,
        COUNT( mom_issue.id_issue ) AS action,
        COUNT( mom_issue.id_issue ) + 1 AS rowspan
      FROM
        mom_issue
        LEFT JOIN mom_issue_item ON mom_issue.id_mom = mom_issue_item.id_mom 
        AND mom_issue.id_issue = mom_issue_item.id_issue
      WHERE
        mom_issue.id_mom = '$id_mom' 
        AND mom_issue_item.id_issue_item IS NOT NULL 
        AND mom_issue_item.id_issue_item > 0  
      GROUP BY
        mom_issue.id_issue
      ORDER BY
        mom_issue.id_issue";

    return $this->db->query($query);
  }

  function get_issue_item_result($id_mom, $id_issue)
  {
    // $this->db->where('id_mom', $id_mom);
    // $this->db->where('id_issue', $id_issue);
    // return $this->db->get('mom_issue_item')->result();
    return $this->db->query("SELECT
                              * 
                            FROM
                              mom_issue_item 
                            WHERE
                              id_mom = '$id_mom' 
                              AND id_issue = '$id_issue'
                              AND id_issue_item IS NOT NULL
                              AND id_issue_item > 0")->result();
  }
  // End Result Draft

  function check_validasi_result($id_mom)
  {
    return $this->db->query("SELECT
                              iss.id_mom,
                              iss.id_issue,
                              item.id_issue_item,
                              iss.topik,
                              iss.issue,
                              item.action,
                              item.kategori,
                              item.grdsi,
                              item.ekspektasi,
                              item.level,
                              item.deadline,
                              item.pic
                            FROM
                              mom_issue AS iss
                              LEFT JOIN mom_issue_item AS item ON item.id_mom = iss.id_mom AND item.id_issue = iss.id_issue
                            WHERE
                              item.id_mom = '$id_mom'
                              AND item.kategori IN (1,5,6,8,9,10,11,12)
                            ORDER BY
                              iss.id_issue,
                              item.id_issue_item");
  }

  // Notif Plan MoM
  function get_plan_send_wa($id_plan)
  {
    return $this->db->query("SELECT
                              mom.id_plan,
                              mom.judul,
                              mom.tempat,
                              DATE_FORMAT( mom.tgl, '%d %b %Y' ) AS tgl,
                              CONCAT( SUBSTR( mom.start_time, 1, 5 ), ' s/d selesai' ) AS waktu,
                              mom.peserta,
                              mom.note,
                              em.user_id,
                              GROUP_CONCAT(
                              REPLACE ( REPLACE ( REPLACE ( em.contact_no, ' ', '' ), '+', '' ), '-', '' )) AS kontak,
                              CONCAT(
                                'https://trusmiverse.com/apps/bahan_mom/',
                              md5( CONCAT(mom.id_plan,'/',em.user_id) )) AS link,
                              DATE_FORMAT( mom.deadline, '%d %b %Y' ) AS deadline 
                            FROM
                              (
                              SELECT
                                plan.id_plan,
                                plan.judul,
                                plan.tempat,
                                plan.tgl,
                                plan.start_time,
                                GROUP_CONCAT(
                                CONCAT( em.first_name, ' ', em.last_name )) AS peserta,
                                plan.peserta AS pic,
                                plan.note,
                                DATE_SUB( plan.tgl, INTERVAL 1 DAY ) AS deadline 
                              FROM
                                mom_plan AS plan
                                LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, plan.peserta ) 
                              WHERE
                                plan.id_plan = '$id_plan' 
                              ) AS mom
                              LEFT JOIN (
                              SELECT
                                user_id,
                              IF
                                ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS contact_no 
                              FROM
                                xin_employees 
                              ) AS em ON FIND_IN_SET( em.user_id, mom.pic ) 
                            GROUP BY
                              em.user_id")->result_array();
  }

  function get_list_plan()
  {
    $user_id        = $_SESSION['user_id'];
    $role_id        = $_SESSION['user_role_id'];
    $department_id  = $_SESSION['department_id'];

    $kondisi = "";
    if ($role_id == 1 || in_array($user_id, [1139, 8892, 8970, 803])) { // Ittrusmi & Super Admin & Viky & Lintang(Sekdir) & Pak Ibnu
      $kondisi = "";
    } else if ($department_id == 117) { // PDCA RSP
      $kondisi = "";
    } else {
      $kondisi = "WHERE plan.created_by = $user_id OR FIND_IN_SET($user_id,plan.peserta)";
    }
    return $this->db->query("SELECT
                              plan.id_plan,
                              plan.judul,
                              plan.tempat,
                              DATE_FORMAT( plan.tgl, '%d %b %Y' ) AS tgl,
                              CONCAT( plan.start_time, ' s/d selesai' ) AS waktu,
                              plan.meeting,
                              dep.department_name AS department,
                              GROUP_CONCAT(CONCAT( em.first_name, ' ', em.last_name )) AS peserta,
                              plan.note,
                              plan.created_at,
                              CONCAT( created.first_name, ' ', created.last_name ) AS created_by,
                              bahan.deadline,
                              IF(bahan.total_pic = bahan.total_file,'Completed','Waiting Completed') AS status_bahan,
                              IF(mom.id_plan IS NOT NULL,'Done','Waiting') AS status_plan
                            FROM
                              mom_plan AS plan
                              LEFT JOIN mom_header AS mom ON mom.id_plan = plan.id_plan
                              LEFT JOIN (
                              SELECT
                                id_plan,
                                deadline,
                                COUNT(
                                IF
                                ( attachment IS NOT NULL OR attachment <> '' OR link IS NOT NULL OR link <> '', 1, NULL )) AS total_file,
                                COUNT( pic ) AS total_pic 
                              FROM
                                mom_plan_bahan 
                              GROUP BY
                                id_plan 
                              ) AS bahan ON bahan.id_plan = plan.id_plan
                              LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, plan.peserta )
                              LEFT JOIN xin_employees AS created ON created.user_id = plan.created_by 
                              LEFT JOIN (
                              SELECT
                                mom.id_plan,
                                xin_departments.department_id,
                                GROUP_CONCAT( xin_departments.department_name ) AS department_name 
                              FROM
                                mom_plan AS mom
                                JOIN xin_departments ON FIND_IN_SET( xin_departments.department_id, mom.department ) 
                              GROUP BY
                                mom.id_plan 
                              ) AS dep ON dep.id_plan = plan.id_plan
                              $kondisi
                            GROUP BY
                              plan.id_plan")->result();
  }

  function get_list_plan_bahan($id_plan)
  {
    return $this->db->query("SELECT
                              md5(CONCAT(bahan.id_plan,'/',bahan.pic)) AS id,
                              bahan.id_plan,
                              bahan.pic,
                              CONCAT(pic.first_name,' ',pic.last_name) AS pic_name,
                              COALESCE(bahan.attachment,'') AS attachment,
                              COALESCE(bahan.link,'') AS link,
                              bahan.note,
                              bahan.updated_at,
                              CONCAT(updated.first_name,' ',updated.last_name) AS updated_by
                            FROM
                              mom_plan_bahan AS bahan
                              LEFT JOIN xin_employees AS pic ON pic.user_id = bahan.pic
                              LEFT JOIN xin_employees AS updated ON updated.user_id = bahan.updated_by
                            WHERE
                              bahan.id_plan = '$id_plan'")->result();
  }

  // Untuk di Mom_plan_bahan
  function get_detail_plan($id)
  {
    return $this->db->query("SELECT
                              plan.id_plan,
                              bahan.pic,
                              plan.judul,
                              plan.tempat,
                              DATE_FORMAT( plan.tgl, '%d %b %Y' ) AS tgl,
                              CONCAT( plan.start_time, ' s/d selesai' ) AS waktu,
                              GROUP_CONCAT(
                              CONCAT( em.first_name, ' ', em.last_name )) AS peserta,
                              plan.note,
                              bahan.deadline AS due_date,
                              plan.tgl AS due_date_new,
                              DATE_FORMAT( bahan.deadline, '%d %b %Y' ) AS deadline,
                              plan.created_at,
                              CONCAT( created.first_name, ' ', created.last_name ) AS created_by,
                              loc.location_name AS created_location,
                              com.`name` AS created_company,
                              dep.department_name AS created_department,
                              dg.designation_name AS created_designation,
                              CONCAT(pic.first_name,' ',pic.last_name) AS uploaded_by,
                              bahan.updated_at AS uploaded_at,
                              dg_pic.designation_name AS uploaded_designation,
                              IF (
                                bahan.attachment IS NOT NULL 
                                OR bahan.link IS NOT NULL 
                                OR bahan.attachment <> '' 
                                OR bahan.link <> '',
                                'Upload Completed',
                                'Waiting Upload' 
                              ) AS uploaded_status,
                              IF (
                                bahan.attachment IS NOT NULL 
                                OR bahan.link IS NOT NULL 
                                OR bahan.attachment <> '' 
                                OR bahan.link <> '',
                                'bg-light-green',
                                'bg-light-yellow' 
                              ) AS uploaded_color,
                              IF (
                                bahan.attachment IS NOT NULL 
                                OR bahan.link IS NOT NULL 
                                OR bahan.attachment <> '' 
                                OR bahan.link <> '',
                                '100',
                                '0' 
                              ) AS uploaded_progres
                            FROM
                              mom_plan AS plan
                              JOIN mom_plan_bahan AS bahan ON bahan.id_plan = plan.id_plan
                              LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, plan.peserta )
                              LEFT JOIN xin_employees AS pic ON pic.user_id = bahan.pic
                              LEFT JOIN xin_designations AS dg_pic ON dg_pic.designation_id = pic.designation_id
                              LEFT JOIN xin_employees AS created ON created.user_id = plan.created_by
                              LEFT JOIN xin_office_location AS loc ON loc.location_id = created.location_id
                              LEFT JOIN xin_companies AS com ON com.company_id = created.company_id
                              LEFT JOIN xin_departments AS dep ON dep.department_id = created.department_id
                              LEFT JOIN xin_designations AS dg ON dg.designation_id = created.designation_id 
                            WHERE
                              md5(CONCAT(bahan.id_plan,'/',bahan.pic)) = '$id'")->row_array();
  }

  function get_data_plan($id_plan)
  {
    return $this->db->query("SELECT
                              id_plan,
                              judul,
                              tempat,
                              tgl,
                              LEFT(start_time,5) AS start_time,
                              meeting,
                              department,
                              peserta
                            FROM
                              mom_plan 
                            WHERE
                              id_plan = '$id_plan'")->row_array();
  }

  // Get Data for Notif Uploaded File MOM in mom_plan_bahan
  function get_bahan_send_wa($id_plan, $pic)
  {
    return $this->db->query("SELECT
                              plan.id_plan,
                              plan.judul,
                              plan.tempat,
                              DATE_FORMAT( plan.tgl, '%d %b %Y' ) AS tgl,
                              CONCAT( SUBSTR( plan.start_time, 1, 5 ), ' s/d selesai' ) AS waktu,
                              GROUP_CONCAT(CONCAT( ps.first_name, ' ', ps.last_name )) AS peserta,
                              plan.note,
                              bahan.attachment AS file,
                              bahan.link,
                              bahan.note as note_upload,
                              bahan.updated_at,
                              CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                              REPLACE ( REPLACE ( REPLACE ( em.contact_no, ' ', '' ), '+', '' ), '-', '' ) AS kontak
                            FROM
                              mom_plan_bahan AS bahan
                              JOIN mom_plan AS plan ON plan.id_plan = bahan.id_plan
                              LEFT JOIN (
                              SELECT
                                user_id,
                              IF
                                ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS contact_no 
                              FROM
                                xin_employees 
                              ) AS em ON em.user_id = plan.created_by
                              LEFT JOIN xin_employees AS ps ON FIND_IN_SET( ps.user_id, plan.peserta )
                              LEFT JOIN xin_employees AS up ON up.user_id = bahan.updated_by
                            WHERE
                              bahan.id_plan = '$id_plan' 
                              AND bahan.pic = $pic")->result_array();
  }

  function get_pic_for_approval($id_mom, $id_issue, $id_issue_item)
  {
    return $this->db->query("SELECT
                              @no:=@no+1 nomor,
                              item.id_mom,
                              item.id_issue,
                              item.id_issue_item,
                              item.action,
                              item.kategori,
                              item.deadline,
                              em.user_id AS pic
                            FROM
                              mom_issue_item AS item
                              JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic ),
                              (SELECT @no:= 0) AS no
                            WHERE
                              item.id_mom = '$id_mom' 
                              AND item.id_issue = $id_issue
                              AND item.id_issue_item = $id_issue_item
                            GROUP BY
                              em.user_id")->result();
  }

  function get_send_wa_trusmi_approval($no_app)
  {
    return $this->db->query("SELECT
                              up.employee_name AS approve_to,
                              CONCAT( req.first_name, ' ', req.last_name ) AS requested_by,
                              apr.created_at AS requested_at,
                              apr.no_app,
                              apr.`subject`,
                              apr.description,
                              CONCAT( 'https://trusmiverse.com/apps/login/verify?u=', apr.approve_to, '&id=', apr.no_app ) AS link_approve,
                              REPLACE(REPLACE(REPLACE(up.contact_no,' ',''),'+',''),'-','') AS kontak
                            FROM
                              trusmi_approval AS apr
                              LEFT JOIN (
                              SELECT
                                user_id,
                                CONCAT( first_name, ' ', last_name ) AS employee_name,
                              IF
                                ( LEFT ( contact_no, 1 ) = '0', CONCAT( '62', SUBSTR( contact_no, 2 )), contact_no ) AS contact_no 
                              FROM
                                xin_employees 
                              ) AS up ON up.user_id = apr.approve_to
                              LEFT JOIN xin_employees AS req ON req.user_id = apr.created_by 
                            WHERE
                              no_app = '$no_app'")->result();
  }

  function no_app()
  {
    $q = $this->db->query("SELECT
        MAX( RIGHT ( trusmi_approval.no_app, 3 ) ) AS kd_max 
        FROM
        trusmi_approval 
        WHERE
        SUBSTR( trusmi_approval.created_at, 1, 10 ) = DATE_ADD( CURDATE(), INTERVAL 1 DAY )");
    $kd = "";

    if ($q->num_rows() > 0) {
      foreach ($q->result() as $k) {
        $tmp = ((int) $k->kd_max) + 1;
        $kd = sprintf("%03s", $tmp);
      }
    } else {
      $kd = "001";
    }
    return 'AP' . date('ymd', strtotime("+ 1 day")) . $kd;
  }

  //fuji
  public function generate_head_resume_v3()
  {
    $start = date("Y-m-01");
    $end = date("Y-m-t");
    $data = $this->db->query("SELECT
                        CONCAT('W',@rank := @rank + 1) AS week_number,
                        CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_awal,'%d %b')
                        END AS f_tgl_awal,
	                    CASE WHEN SUBSTR(calendar_week.tgl_awal,1,7) = SUBSTR(calendar_week.tgl_akhir,1,7)  THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        WHEN SUBSTR(calendar_week.tgl_awal,1,4) != SUBSTR(calendar_week.tgl_akhir,1,4) THEN
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        ELSE
                            DATE_FORMAT(calendar_week.tgl_akhir,'%d %b %y')
                        END AS f_tgl_akhir,
                        calendar_week.* 
                    FROM (
                        SELECT
                            start_date AS `tgl_awal`,
                            (start_date + INTERVAL 6 DAY) AS tgl_akhir
                        FROM 
                        (
                            SELECT 
                                ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                            FROM
                                (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                        ) v
                        WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                        GROUP BY (start_date)
                        ORDER BY (start_date)
                    ) AS calendar_week, 
                    (SELECT @rank := 0 ) AS num");
    $response['data'] = $data->result();

    $body_resume = $this->generate_body_resume_v3($start, $end, $data->num_rows());
    $response['body_resume'] = $body_resume;
    $response['jumlah_week'] = $data->num_rows();
    echo json_encode($response);
  }

  public function generate_body_resume_v3($start, $end, $jumlah_week)
  {
    $select = "";
    $week = 1;
    for ($i = 0; $i < $jumlah_week; $i++) {
      $select .= " COUNT(IF(xx.input >= 1 AND xx.w = '$week',1,NULL)) AS w" . $week . ",";
      $select .= " SUM(IF(xx.w = '$week',COALESCE(xx.input,0),0)) AS input_w" . $week . ",";
      $week++;
    }
    $query = "SELECT 
                    xx.user_id, 
                    xx.employee_name,
                    $select 
                    xx.company_name,
                    xx.jabatan
                FROM(
                    SELECT tm.user_id, tm.employee_name, tm.company_name, tm.jabatan, th.w, th.tgl_awal, th.tgl_akhir, SUM(IF(th.w IS NOT NULL,1,0)) AS input FROM
                      (
                      SELECT 
                      a.user_id,  CONCAT(a.first_name, ' ', a.last_name) AS employee_name,
                      a.company_id, a.department_id, a.designation_id, c.name AS company_name, ds.designation_name AS jabatan
                      FROM xin_employees a
                      LEFT JOIN xin_user_roles ur ON ur.role_id = a.user_role_id
                      LEFT JOIN xin_companies c ON c.company_id = a.company_id
                      LEFT JOIN xin_departments d ON d.department_id = a.department_id
                      LEFT JOIN xin_designations ds ON ds.designation_id = a.designation_id
                      WHERE user_id IN (118,637,116,998,4201) AND a.is_active = 1
                      ) tm
                      LEFT JOIN mom_plan b ON FIND_IN_SET(tm.user_id, peserta) AND b.meeting NOT IN ('Jobdesk')
                      LEFT JOIN (
                                          SELECT
                                              @rank := @rank + 1 AS w,
                                              calendar_week.* 
                                          FROM (
                                              SELECT
                                                  start_date AS `tgl_awal`,
                                                  (start_date + INTERVAL 6 DAY) AS tgl_akhir
                                              FROM 
                                              (
                                                  SELECT 
                                                      ADDDATE('1970-01-01', t4 * 10000 + t3 * 1000 + t2 * 100 + t1 * 10 + t0) AS start_date
                                                  FROM
                                                      (SELECT 0 t0 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t0,
                                                      (SELECT 0 t1 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t1,
                                                      (SELECT 0 t2 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t2,
                                                      (SELECT 0 t3 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t3,
                                                      (SELECT 0 t4 UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9) t4
                                              ) v
                                              WHERE start_date BETWEEN DATE_SUB('$start', INTERVAL 1 WEEK) AND '$end' AND WEEKDAY(start_date) = 6
                                              GROUP BY (start_date)
                                              ORDER BY (start_date)
                                          ) AS calendar_week, 
                                          (SELECT @rank := 0 ) AS num
                    ) th ON SUBSTR(b.tgl,1,10) BETWEEN th.tgl_awal AND th.tgl_akhir
                    GROUP BY tm.user_id, th.w
                ) xx GROUP BY xx.user_id";
    return $this->db->query($query)->result();
  }

  function get_department()
  {
    return $this->db->query("SELECT
                                dp.department_id AS id,
                                CONCAT(dp.department_name,' - ',comp.kode) AS department
                              FROM
                                xin_departments AS dp
                                JOIN xin_companies AS comp ON dp.company_id = comp.company_id")->result();
  }
  function get_send_email($id_mom)
  {
    $query = "SELECT
                id,
                mom_issue_item.id_mom,
                `action`,
                deadline,
                mom_issue_item.pic,
                xe.email,
                start_time,
                end_time,
                tempat,
                tgl,
                task	 
              FROM
                mom_issue_item 
              JOIN xin_employees as xe ON xe.user_id = mom_issue_item.pic
              JOIN td_task ON td_task.id_task = mom_issue_item.id_task
              JOIN mom_header ON mom_header.id_mom = mom_issue_item.id_mom
              WHERE
                mom_issue_item.id_mom = '$id_mom'";
    return $this->db->query($query)->result();
  }

  function get_project()
  {
    return $this->db->query("SELECT id_project, project FROM rsp_project_live.m_project")->result();
  }

  function get_detail_ibr($id_sub_task)
  {
    $query = "SELECT
            YEAR(mom_header.created_at) AS tahun,
            sub_task.id_sub_task,
            sub_task.id_task,
            mom_header.id_mom,
            MD5(mom_header.id_mom) AS mom,
            CASE    
                WHEN solver.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( solver.contact_no, 2 )) ELSE solver.contact_no 
            END AS contact_no,
												CASE    
                WHEN pic_mom.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( pic_mom.contact_no, 2 )) ELSE pic_mom.contact_no 
            END AS contact_no_pic,
            task.task,
            sub_task.sub_task,
            sub_task.evaluasi,
            TRIM(CONCAT(solver.first_name, ' ', solver.last_name)) AS pic,
            TRIM(CONCAT(pic_mom.first_name, ' ', pic_mom.last_name)) AS pic_mom,
            CASE    
                WHEN sub_task.status = 1 THEN
                'Jalan Berhasil' 
                WHEN sub_task.status = 2 THEN
                'Jalan Tidak Berhasil' 
                WHEN sub_task.status = 3 THEN
                'Tidak Berjalan' 
                WHEN sub_task.status = 4 THEN
                'Progress' ELSE '' 
            END AS status,
            his.file,
            his.link,
            TRIM(CONCAT(crt.first_name, ' ', crt.last_name)) AS pdca,
            issue_item.verified_note
        FROM
            td_sub_task AS sub_task
            JOIN td_task AS task ON task.id_task = sub_task.id_task
            LEFT JOIN mom_issue_item AS issue_item ON issue_item.id_sub_task = sub_task.id_sub_task
            LEFT JOIN xin_employees pic_mom ON FIND_IN_SET(pic_mom.user_id,issue_item.pic) 
            LEFT JOIN mom_header ON mom_header.id_mom = issue_item.id_mom
            JOIN xin_employees AS crt ON crt.user_id = mom_header.created_by
            JOIN (
            SELECT
                td_sub_task_history.id_sub_task,
                IF ( td_sub_task_history.file = '', NULL, CONCAT( 'https://trusmiverse.com/apps/uploads/monday/history_sub_task/', td_sub_task_history.file )) AS file,
                td_sub_task_history.link,
                td_sub_task_history.created_by
            FROM
                td_sub_task_history 
            WHERE
                id_sub_task = '$id_sub_task' 
            ORDER BY
                id DESC 
            LIMIT 1
            ) AS his ON his.id_sub_task = sub_task.id_sub_task 
            JOIN xin_employees AS solver ON solver.user_id = his.created_by
        WHERE
            sub_task.id_sub_task = '$id_sub_task'
												GROUP BY pic_mom.user_id";

    return $this->db->query($query)->row_object();
  }

  function get_detail_ibr_for_notif($id_sub_task)
  {
    $query = "SELECT
            YEAR(mom_header.created_at) AS tahun,
            sub_task.id_sub_task,
            sub_task.id_task,
            mom_header.id_mom,
            MD5(mom_header.id_mom) AS mom,
            CASE    
                WHEN solver.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( solver.contact_no, 2 )) ELSE solver.contact_no 
            END AS contact_no,
												CASE    
                WHEN pic_mom.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( pic_mom.contact_no, 2 )) ELSE pic_mom.contact_no 
            END AS contact_no_pic,
            task.task,
            sub_task.sub_task,
            sub_task.evaluasi,
            TRIM(CONCAT(solver.first_name, ' ', solver.last_name)) AS pic,
            TRIM(CONCAT(pic_mom.first_name, ' ', pic_mom.last_name)) AS pic_mom,
            CASE    
                WHEN sub_task.status = 1 THEN
                'Jalan Berhasil' 
                WHEN sub_task.status = 2 THEN
                'Jalan Tidak Berhasil' 
                WHEN sub_task.status = 3 THEN
                'Tidak Berjalan' 
                WHEN sub_task.status = 4 THEN
                'Progress' ELSE '' 
            END AS status,
            his.file,
            his.link,
            TRIM(CONCAT(crt.first_name, ' ', crt.last_name)) AS pdca,
            TRIM(CONCAT(vowner.first_name, ' ', vowner.last_name)) AS `owner`,
            issue_item.verified_note,
            issue_item.deadline,
            issue_item.owner_verified_status,
            issue_item.owner_verified_note
        FROM
            td_sub_task AS sub_task
            JOIN td_task AS task ON task.id_task = sub_task.id_task
            LEFT JOIN mom_issue_item AS issue_item ON issue_item.id_sub_task = sub_task.id_sub_task
            LEFT JOIN xin_employees pic_mom ON FIND_IN_SET(pic_mom.user_id,issue_item.pic) 
            LEFT JOIN mom_header ON mom_header.id_mom = issue_item.id_mom
            JOIN xin_employees AS crt ON crt.user_id = mom_header.created_by
            LEFT JOIN xin_employees AS vowner ON vowner.user_id = issue_item.owner_verified_by
            JOIN (
            SELECT
                td_sub_task_history.id_sub_task,
                IF ( td_sub_task_history.file = '', NULL, CONCAT( 'https://trusmiverse.com/apps/uploads/monday/history_sub_task/', td_sub_task_history.file )) AS file,
                td_sub_task_history.link,
                td_sub_task_history.created_by
            FROM
                td_sub_task_history 
            WHERE
                id_sub_task = '$id_sub_task' 
            ORDER BY
                id DESC 
            LIMIT 1
            ) AS his ON his.id_sub_task = sub_task.id_sub_task 
            JOIN xin_employees AS solver ON solver.user_id = his.created_by
        WHERE
            sub_task.id_sub_task = '$id_sub_task'
												GROUP BY pic_mom.user_id";

    return $this->db->query($query)->result();
  }

  function get_detail_ibr_for_notif_meeting($id_sub_task)
  {
    $query = "SELECT
            YEAR(mom_header.created_at) AS tahun,
            sub_task.id_sub_task,
            sub_task.id_task,
            mom_header.id_mom,
            MD5(mom_header.id_mom) AS mom,
            CASE    
                WHEN solver.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( solver.contact_no, 2 )) ELSE solver.contact_no 
            END AS contact_no,
                        CASE    
                WHEN pic_mom.contact_no LIKE '0%' THEN
                CONCAT(
                    '62',
                SUBSTRING( pic_mom.contact_no, 2 )) ELSE pic_mom.contact_no 
            END AS contact_no_pic,
            task.task,
            sub_task.sub_task,
            sub_task.evaluasi,
            TRIM(CONCAT(solver.first_name, ' ', solver.last_name)) AS pic,
            TRIM(CONCAT(pic_mom.first_name, ' ', pic_mom.last_name)) AS pic_mom,
            CASE    
                WHEN sub_task.status = 1 THEN
                'Jalan Berhasil' 
                WHEN sub_task.status = 2 THEN
                'Jalan Tidak Berhasil' 
                WHEN sub_task.status = 3 THEN
                'Tidak Berjalan' 
                WHEN sub_task.status = 4 THEN
                'Progress' ELSE '' 
            END AS status,
            his.file,
            his.link,
            TRIM(CONCAT(crt.first_name, ' ', crt.last_name)) AS pdca,
            TRIM(CONCAT(vowner.first_name, ' ', vowner.last_name)) AS `owner`,
            issue_item.verified_note,
            issue_item.owner_verified_status,
            issue_item.owner_verified_note
        FROM
            td_sub_task AS sub_task
            JOIN td_task AS task ON task.id_task = sub_task.id_task
            LEFT JOIN mom_issue_item AS issue_item ON issue_item.id_sub_task = sub_task.id_sub_task
            LEFT JOIN xin_employees pic_mom ON FIND_IN_SET(pic_mom.user_id,issue_item.pic) 
            LEFT JOIN mom_header ON mom_header.id_mom = issue_item.id_mom
            JOIN xin_employees AS crt ON crt.user_id = mom_header.created_by
            LEFT JOIN xin_employees AS vowner ON vowner.user_id = issue_item.owner_verified_by
            JOIN (
            SELECT
                td_sub_task_history.id_sub_task,
                IF ( td_sub_task_history.file = '', NULL, CONCAT( 'https://trusmiverse.com/apps/uploads/monday/history_sub_task/', td_sub_task_history.file )) AS file,
                td_sub_task_history.link,
                td_sub_task_history.created_by
            FROM
                td_sub_task_history 
            WHERE
                id_sub_task = '$id_sub_task' 
            ORDER BY
                id DESC 
            LIMIT 1
            ) AS his ON his.id_sub_task = sub_task.id_sub_task 
            JOIN xin_employees AS solver ON solver.user_id = his.created_by
        WHERE
            sub_task.id_sub_task = '$id_sub_task'
                        GROUP BY pic_mom.user_id";

    return $this->db->query($query)->result();
  }

  function get_grd_si()
  {
    return $this->db->query("SELECT
                                  si.id_si,
                                  so.id_so,
                                  CONCAT(si.si,' | ',so.so,' ',DATE_FORMAT(so.created_at,'%b %y') ,' | ',so.divisi) AS grdsi
                                FROM
                                  grd_t_si AS si
                                  JOIN grd_m_so AS so ON so.id_so = si.id_so")->result();
  }
  function list_verif_owner($filter)
  {
    $today = date('Y-m-d');
    $kondisi = "";
    if ($filter == "") { // jika ada filter tanggal
      $kondisi = "AND momi.verified_at > '2025-03-31' AND DATE(mom.created_at) > '2025-05-13'";
    } else if ($filter > $today) {
      $kondisi = "AND momi.verified_at >= '$today' AND DATE(mom.created_at) > '2025-05-13'";
    } else {
      $kondisi = "AND momi.verified_at > '2025-03-31' AND momi.verified_at < CURDATE() AND DATE(mom.created_at) > '2025-05-13'";
    }

    $query = "SELECT
        momi.id_mom,
        md5(momi.id_mom) AS id_mom_en,
        momi.id_issue,
        momi.id AS id_item_issue,
        momi.id_task,
        momi.id_sub_task,
        mom.meeting,
        moms.topik,
        moms.issue,
        momi.action,
        momk.kategori,
        moml.`level`,
        GROUP_CONCAT(
            TRIM(CONCAT(emp.first_name, ' ', emp.last_name))
        ) AS pic,
        momi.deadline,
        momi.ekspektasi,
        mtask.evaluasi,
        mtask.file,
        mtask.link,
        IF(momi.verified_status = 1, 'Oke', 'Not Oke') AS pdca_status,
        momi.verified_note AS pdca_note,
        DATE(momi.verified_at) AS pdca_at,
        CONCAT(crt.first_name, ' ', crt.last_name) AS created_by,
        CONCAT(pby.first_name, ' ', pby.last_name) AS pdca_by,
        momi.owner_verified_status AS id_owner_verified_status,
        IF(momi.owner_verified_status = 1, 'Oke', 'Not Oke') AS owner_verified_status,
        momi.owner_verified_note

    FROM mom_issue_item AS momi
        LEFT JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
        LEFT JOIN mom_issue AS moms ON moms.id_mom = momi.id_mom AND moms.id_issue = momi.id_issue
        LEFT JOIN mom_kategori AS momk ON momk.id = momi.kategori
        LEFT JOIN mom_level AS moml ON moml.id = momi.`level`
        LEFT JOIN xin_employees crt ON crt.user_id = mom.created_by
        LEFT JOIN xin_employees AS emp ON FIND_IN_SET(emp.user_id, momi.pic)
        LEFT JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
        LEFT JOIN (
            SELECT
                max_task.id,
                max_task.id_sub_task AS idx,
                max_task.evaluasi,
                max_task.file,
                max_task.link
            FROM td_sub_task_history AS max_task
            JOIN (
                SELECT id_sub_task, MAX(id) AS max_id
                FROM td_sub_task_history
                GROUP BY id_sub_task
            ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task
                AND max_task.id = subquery_max.max_id
        ) AS mtask ON mtask.idx = momi.id_sub_task
        LEFT JOIN xin_employees pby ON pby.user_id = momi.verified_by
    WHERE
    mom.meeting = 'Owner' 
        AND momi.is_eskalasi IS NULL 
        AND momi.verified_status = 1 
        
        $kondisi
        AND momi.owner_verified_status IS NULL
    GROUP BY momi.id_sub_task
    --     momi.verified_status = 1
    --     AND DATE(momi.deadline) > '2025-03-31'
    --     $kondisi
    --     AND mom.meeting = 'Owner'
    --     AND momi.is_eskalasi IS NULL
    --     AND momi.verified_at > '2025-03-31'

    --     -- AND DATE(momi.verified_status) > '2025-03-31'
    --     AND momi.owner_verified_status IS NULL
    -- GROUP BY momi.id_sub_task
    ";

    return $this->db->query($query)->result();
  }

  function list_meeting_owner($user_id, $start, $end)
  {
    $kondisi = (in_array($user_id, [1, 803, 4498,10127])) ? "" : "AND momi.pic = $user_id";
    $query = "SELECT
        momi.id_mom,
        md5(momi.id_mom) AS id_mom_en,
        momi.id_issue,
        momi.id AS id_item_issue,
        momi.id_task,
        momi.id_sub_task,
        mom.meeting,
        moms.topik,
        moms.issue,
        momi.action,
        momk.kategori,
        moml.`level`,
        GROUP_CONCAT(
            TRIM(CONCAT(emp.first_name, ' ', emp.last_name))
        ) AS pic,
        momi.deadline,
        momi.ekspektasi,
        mtask.evaluasi,
        mtask.file,
        mtask.link,
        IF(momi.verified_status = 1, 'Oke', 'Not Oke') AS pdca_status,
        momi.verified_note AS pdca_note,
        DATE(momi.verified_at) AS pdca_at,
        CONCAT(crt.first_name, ' ', crt.last_name) AS created_by,
        CONCAT(pby.first_name, ' ', pby.last_name) AS pdca_by,
        momi.owner_verified_status AS id_owner_verified_status,
        CASE 
        WHEN momi.owner_verified_status = 1 THEN 'Oke Result'
        WHEN momi.owner_verified_status = 2 THEN 'Not Oke'
        WHEN momi.owner_verified_status = 3 THEN 'Oke Meeting / Diskusi'
        END AS owner_verified_status,
        momi.owner_verified_note

    FROM mom_issue_item AS momi
        LEFT JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
        LEFT JOIN mom_issue AS moms ON moms.id_mom = momi.id_mom AND moms.id_issue = momi.id_issue
        LEFT JOIN mom_kategori AS momk ON momk.id = momi.kategori
        LEFT JOIN mom_level AS moml ON moml.id = momi.`level`
        LEFT JOIN xin_employees crt ON crt.user_id = mom.created_by
        LEFT JOIN xin_employees AS emp ON FIND_IN_SET(emp.user_id, momi.pic)
        LEFT JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
        LEFT JOIN (
            SELECT
                max_task.id,
                max_task.id_sub_task AS idx,
                max_task.evaluasi,
                max_task.file,
                max_task.link
            FROM td_sub_task_history AS max_task
            JOIN (
                SELECT id_sub_task, MAX(id) AS max_id
                FROM td_sub_task_history
                GROUP BY id_sub_task
            ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task
                AND max_task.id = subquery_max.max_id
        ) AS mtask ON mtask.idx = momi.id_sub_task
        LEFT JOIN xin_employees pby ON pby.user_id = momi.verified_by
    WHERE
    mom.meeting = 'Owner' 
        AND momi.owner_meeting BETWEEN '$start' AND '$end'
        $kondisi
    GROUP BY momi.id_sub_task
    ";

    return $this->db->query($query)->result();
  }

  public function list_verif_pdca($filter)
  {
    $kondisi = "";
    $is_super_user = "";
    if ($filter != "") { //all
      $kondisi = "AND DATE_ADD( task.done_date,INTERVAL 1 DAY ) = '$filter'";
    }
    $user = $this->session->userdata('user_id');
    $super = [1, 4498, 10127];
    if (!in_array($user, $super)) {
      $is_super_user = "AND mom.created_by = '$user'";
    }
    $start = '2025-03-01';
    $query = "SELECT
	momi.id_mom,
	md5(momi.id_mom) AS id_mom_en,
	momi.id_issue,
	momi.id AS id_item_issue,
	momi.id_task,
	momi.id_sub_task,
	mom.meeting,
	moms.topik,
	moms.issue,
	momi.action,
	momk.kategori,
	moml.`level`,
	GROUP_CONCAT(
		TRIM(
		CONCAT( emp.first_name, ' ', emp.last_name ))) AS pic,
	momi.deadline,
	momi.ekspektasi,
	mtask.evaluasi,
	mtask.file,
	mtask.link,
IF
	( momi.verified_status = 1, 'Oke', 'Not Oke' ) AS pdca_status,
	momi.verified_note AS pdca_note,
	DATE( momi.verified_at ) AS pdca_at ,
	CONCAT( crt.first_name, ' ', crt.last_name ) AS created_by,
          CONCAT( pby.first_name, ' ', pby.last_name ) AS pdca_by,
          momi.owner_verified_status AS id_owner_verified_status,
          IF(momi.owner_verified_status = 1, 'Oke', 'Not Oke') AS owner_verified_status,
          momi.owner_verified_note
FROM
	mom_issue_item AS momi
	LEFT JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
	LEFT JOIN mom_issue AS moms ON moms.id_mom = momi.id_mom 
	AND moms.id_issue = momi.id_issue
	LEFT JOIN mom_kategori AS momk ON momk.id = momi.kategori
	LEFT JOIN mom_level AS moml ON moml.id = momi.`level`
	LEFT JOIN xin_employees crt ON crt.user_id = mom.created_by
	LEFT JOIN xin_employees AS emp ON FIND_IN_SET( emp.user_id, momi.pic ) 
	LEFT JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
	LEFT JOIN td_task task ON task.id_task = stask.id_task
	LEFT JOIN (SELECT
	max_task.id,
	max_task.id_sub_task AS idx,
	max_task.evaluasi,
	max_task.file,
	max_task.link 
FROM
	td_sub_task_history AS max_task
	JOIN ( SELECT id_sub_task, MAX( id ) AS max_id FROM td_sub_task_history GROUP BY id_sub_task ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task 
	AND max_task.id = subquery_max.max_id) AS mtask ON mtask.idx = momi.id_sub_task
  LEFT JOIN xin_employees pby ON pby.user_id=momi.verified_by
WHERE
	momi.verified_status IS NULL
	AND task.`status` IN (2,3)
  $kondisi
	AND DATE(mom.created_at) > '$start'
  $is_super_user
-- 	AND DATE( momi.verified_at ) > '2025-03-10'
	AND mom.meeting NOT IN ('Jobdesk')
  AND momi.is_eskalasi IS NULL
GROUP BY
	momi.id_sub_task";
    return $this->db->query($query)->result();
  }


  public function detail_notif_eskalasi($id_mom)
  {
    $query = "SELECT
        item.id_mom,
        item.id_issue,
        GROUP_CONCAT(item.action SEPARATOR '#DELIM#') AS actions,
        GROUP_CONCAT(item.deadline SEPARATOR '#DELIM#') AS deadlines,
        epic.user_id,
        CONCAT(epic.first_name,' ',epic.last_name) AS pic_name,
        epic.contact_no AS pic_contact,
        item.is_eskalasi,
        GROUP_CONCAT(sub.id_sub_task) AS id_sub_task,
        item.reff_id_sub_task,
        item.eskalasi_by,
        CONCAT(eby.first_name,' ',eby.last_name) AS eskalasi_name
        
      FROM
        `mom_issue_item` item 
        LEFT JOIN xin_employees epic ON FIND_IN_SET(epic.user_id,item.pic)
        LEFT JOIN xin_employees eby ON eby.user_id = item.eskalasi_by
        LEFT JOIN td_sub_task sub ON FIND_IN_SET(sub.id_sub_task,item.id_sub_task)
      WHERE
        item.is_eskalasi = 1 
        AND item.id_mom = '$id_mom'
      GROUP BY epic.user_id";
    return $this->db->query($query)->result();
  }
  public function list_eskalasi()
  {
    $user = $this->session->userdata('user_id');
    $super = [1, 8204, 803, 4498, 10127];
    $kondisi = "";
    if (in_array($user, $super)) {
      $kondisi = "";
    } else {
      $kondisi = "AND (item.pic = '$user' OR item.eskalasi_by = '$user')";
    }
    $query = "SELECT
        item.id_mom,
        mom.meeting,
        moms.topik,
        moms.issue,
        item.action,
        item.deadline,
        item.pic,
        GROUP_CONCAT(DISTINCT CONCAT(epic.first_name,' ',epic.last_name)) AS pic_name,
        item.id_task,
        item.id_sub_task,
        item.is_eskalasi,
        item.reff_id_sub_task,
        tst.status,
        tst.label,
        tst.color,
        sub.progress,
        item.eskalasi_by,
        CONCAT(eby.first_name,' ',eby.last_name) AS eskalasi_name,
        COALESCE(mtask.evaluasi,'-') AS evaluasi,
        mtask.file,
        mtask.link
      FROM
        mom_issue_item item
        LEFT JOIN mom_header AS mom ON mom.id_mom = item.id_mom
        LEFT JOIN mom_issue AS moms ON moms.id_mom = item.id_mom 
        AND moms.id_issue = item.id_issue
        
        LEFT JOIN xin_employees epic ON FIND_IN_SET(epic.user_id,item.pic)
        LEFT JOIN xin_employees eby ON eby.user_id = item.eskalasi_by
        LEFT JOIN td_sub_task sub ON FIND_IN_SET(sub.id_sub_task,item.id_sub_task)
        LEFT JOIN td_task task ON sub.id_task = task.id_task
        LEFT JOIN td_status tst ON tst.id = task.status
        LEFT JOIN (SELECT
        max_task.id,
        max_task.id_sub_task AS idx,
        max_task.evaluasi,
        max_task.file,
        max_task.link 
      FROM
        td_sub_task_history AS max_task
        JOIN ( SELECT id_sub_task, MAX( id ) AS max_id FROM td_sub_task_history GROUP BY id_sub_task ) AS subquery_max ON max_task.id_sub_task = subquery_max.id_sub_task 
        AND max_task.id = subquery_max.max_id) AS mtask ON mtask.idx = sub.id_sub_task
      WHERE item.is_eskalasi = 1 AND mom.meeting NOT IN ('Jobdesk') $kondisi
    -- 	AND sub.created_at = '' BETWEEN sub.created_at = ''
      GROUP BY item.id";
    return $this->db->query($query)->result();
  }

  function get_goals()
  {
    $query = "SELECT
        id_goal,
        CONCAT(divisi, ' - ', goal) AS goal
      FROM
        rsp_project_live.`m_kpi_item`
        WHERE 
        is_active = 1";

    return $this->db->query($query)->result();
  }
}
