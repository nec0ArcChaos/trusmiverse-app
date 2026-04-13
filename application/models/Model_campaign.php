<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_campaign extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_campaign()
    {
        $query = "SELECT
  xin_companies.name AS company_name,
  xin_departments.department_name,
  CONCAT(xin_employees.first_name, ' ', xin_employees.last_name) AS employee_name,
  MAX(trusmi_campaign.created_at) AS tgl,
  MAX(trusmi_campaign.foto) AS foto
FROM trusmi_campaign
JOIN xin_employees 
  ON trusmi_campaign.created_by = xin_employees.user_id
JOIN xin_departments 
  ON xin_employees.department_id = xin_departments.department_id
JOIN xin_companies 
  ON xin_companies.company_id = xin_employees.company_id
WHERE DATE(trusmi_campaign.created_at) = CURDATE()
GROUP BY trusmi_campaign.created_by
ORDER BY tgl ASC;





--         SELECT
--   xin_companies.name AS company_name,
--   xin_departments.department_name,
--   CONCAT(xin_employees.first_name, ' ',xin_employees.last_name) AS employee_name,
--   trusmi_campaign.created_at AS tgl
-- FROM
--   trusmi_campaign
-- JOIN xin_employees ON trusmi_campaign.created_by = xin_employees.user_id
-- JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
-- JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id




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