<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_input_head extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_mom()
    {
        $query = "SELECT
  *
FROM
  (
    SELECT
      mom.id_mom,
--       MD5(mom.id_mom) AS id_link,
      mom.judul,
      mom.meeting,
      dep.department_name AS department,
      GROUP_CONCAT(
        CASE
          WHEN peserta.profile_picture = ''
            AND peserta.gender = 'Male' THEN
            'default_male.jpg'
          WHEN peserta.profile_picture = ''
            AND peserta.gender = 'Female' THEN
            'default_female.jpg'
          ELSE
            COALESCE(peserta.profile_picture, 'default_male.jpg')
        END
      ) AS pp_peserta,
      mom.agenda,
      mom.pembahasan,
      mom.tempat,
      DATE_FORMAT(mom.tgl, '%d %b %y') AS tgl,
      CONCAT(SUBSTR(mom.start_time, 1, 5), ' - ', SUBSTR(mom.end_time, 1, 5)) AS waktu,
      GROUP_CONCAT(COALESCE(peserta.employee_name, '')) AS peserta,
      CONCAT(created.first_name, ' ', created.last_name) AS created_by,
      created.username,
      created.user_id,
      DATE_FORMAT(mom.created_at, '%d %b %y') AS created_at,
      
      mom.department AS mom_department_id,
      created.department_id AS created_department_id,
      created.company_id,
      CASE
        WHEN created.profile_picture = ''
          AND created.gender = 'Male' THEN
          'default_male.jpg'
        WHEN created.profile_picture = ''
          AND created.gender = 'Female' THEN
          'default_female.jpg'
        ELSE
          created.profile_picture
      END AS profile_picture,
      CONCAT(mom.peserta, ',', GROUP_CONCAT(item.pic)) AS list_peserta_pic,
      mom.cc,
      CONCAT(GROUP_CONCAT(peserta.dep_id), ',', GROUP_CONCAT(item.dep_pic)) AS list_dep_pic,
      CONCAT(GROUP_CONCAT(peserta.comp_id), ',', GROUP_CONCAT(item.comp_pic)) AS list_comp_pic
    FROM
      mom_header mom
      LEFT JOIN (
        SELECT
          x.id_mom,
          GROUP_CONCAT(x.pic) AS pic,
          GROUP_CONCAT(x.dep_pic) AS dep_pic,
          GROUP_CONCAT(x.comp_pic) AS comp_pic
        FROM
          (
            SELECT
              mi.id_mom,
              em.user_id AS pic,
              em.department_id AS dep_pic,
              em.company_id AS comp_pic
            FROM
              mom_issue_item mi
              JOIN mom_header mh ON mh.id_mom = mi.id_mom
              LEFT JOIN xin_employees em ON FIND_IN_SET(em.user_id, mi.pic)
            WHERE
              mh.closed = 1
              AND mh.meeting NOT IN ('Jobdesk')
              AND mh.tgl BETWEEN '2025-12-01'
              AND '2025-12-31'
            GROUP BY
              mi.id_mom,
              em.user_id
          ) x
        GROUP BY
          x.id_mom
      ) item ON item.id_mom = mom.id_mom
      LEFT JOIN (
        SELECT
          user_id,
          CONCAT(first_name, ' ', last_name) AS employee_name,
          profile_picture,
          gender,
          department_id AS dep_id,
          company_id AS comp_id
        FROM
          xin_employees
      ) peserta ON FIND_IN_SET(peserta.user_id, mom.peserta)
      LEFT JOIN xin_employees created ON created.user_id = mom.created_by
      LEFT JOIN (
        SELECT
          mh.id_mom,
          GROUP_CONCAT(dep.department_name) AS department_name
        FROM
          mom_header mh
          JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mh.department)
        WHERE
          mh.closed = 1
          AND mh.meeting NOT IN ('Jobdesk')
          AND mh.tgl BETWEEN '2025-12-01'
          AND '2025-12-31'
        GROUP BY
          mh.id_mom
      ) dep ON dep.id_mom = mom.id_mom
    WHERE
      mom.closed = 1
      AND mom.meeting NOT IN ('Jobdesk')
      AND mom.tgl BETWEEN '2025-12-01'
      AND '2025-12-31'
      AND mom.created_by <> 1212
    GROUP BY
      mom.id_mom
  ) final
WHERE
  final.user_id = 8889
  AND final.judul NOT LIKE '%Gemba%'
  AND final.judul NOT LIKE '%Genba%'
  AND NOT EXISTS (
      SELECT 1
      FROM head_t_event_upload hteu
      WHERE hteu.ids = final.id_mom
  )
GROUP BY final.id_mom
";
        return $this->db->query($query)->result();
    }

    public function get_data_keluar()
    {
        $query = "SELECT * 
              FROM xin_attendance_time_manual_keluar 
              WHERE processed IS NULL";
        return $this->db->query($query)->result();
    }


    public function get_detail_karyawan_masuk($id)
    {
        return $this->db->select('e.user_id, e.first_name, e.last_name, r.role_name, c.name as company_name, d.department_name, e.username')
            ->from('xin_employees e')
            ->join('xin_companies c', 'e.company_id = c.company_id', 'left')
            ->join('xin_user_roles r', 'e.user_role_id = r.role_id', 'left')
            ->join('xin_departments d', 'e.department_id = d.department_id', 'left')
            ->where('e.is_active', 1)
            ->where('e.user_id', $id)  // filter berdasarkan ID
            ->get()
            ->row(); // pakai row() karena hanya 1 data
    }

    public function get_detail_karyawan_keluar($id)
    {
        return $this->db->select('e.user_id, e.first_name, e.last_name, r.role_name, c.name as company_name, d.department_name, e.username')
            ->from('xin_employees e')
            ->join('xin_companies c', 'e.company_id = c.company_id', 'left')
            ->join('xin_user_roles r', 'e.user_role_id = r.role_id', 'left')
            ->join('xin_departments d', 'e.department_id = d.department_id', 'left')
            ->where('e.is_active', 1)
            ->where('e.user_id', $id)  // filter berdasarkan ID
            ->get()
            ->row(); // pakai row() karena hanya 1 data
    }

    public function get_all_karyawan_null()
    {
        return $this->db->select('e.user_id, e.first_name, e.last_name, r.role_name, c.name as company_name, d.department_name, e.username')
            ->from('xin_employees e')
            ->join('xin_companies c', 'e.company_id = c.company_id', 'left')
            ->join('xin_user_roles r', 'e.user_role_id = r.role_id', 'left')
            ->join('xin_departments d', 'e.department_id = d.department_id', 'left')
            ->where('e.is_active', 1)
            ->get()
            ->result();
    }

    public function get_all_karyawan_null_keluar()
    {
        return $this->db->select('e.user_id, e.first_name, e.last_name, r.role_name, c.name as company_name, d.department_name, e.username')
            ->from('xin_employees e')
            ->join('xin_companies c', 'e.company_id = c.company_id', 'left')
            ->join('xin_user_roles r', 'e.user_role_id = r.role_id', 'left')
            ->join('xin_departments d', 'e.department_id = d.department_id', 'left')
            ->where('e.is_active', 1)
            ->get()
            ->result();
    }


}