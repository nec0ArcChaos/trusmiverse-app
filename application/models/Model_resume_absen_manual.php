<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_resume_absen_manual extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_data_masuk($start = null, $end = null)
    {
        $this->db->from('xin_attendance_time_manual_masuk');
        $this->db->where('processed IS NULL', null, false);

        if (!empty($start) && !empty($end)) {
            $this->db->where("
                (
                STR_TO_DATE(REPLACE(TRIM(`timestamp`), '-', '/'), '%d/%m/%Y')
                BETWEEN
                STR_TO_DATE('$start', '%d/%m/%Y')
                AND
                STR_TO_DATE('$end', '%d/%m/%Y')
                )
            ", null, false);
        }

        return $this->db->get()->result();
    }

    public function get_data_keluar($start = null, $end = null)
    {
        $this->db->from('xin_attendance_time_manual_keluar');
        $this->db->where('processed IS NULL', null, false);

        if (!empty($start) && !empty($end)) {
            $this->db->where("
                (
                STR_TO_DATE(REPLACE(TRIM(`timestamp`), '-', '/'), '%d/%m/%Y')
                BETWEEN
                STR_TO_DATE('$start', '%d/%m/%Y')
                AND
                STR_TO_DATE('$end', '%d/%m/%Y')
                )
            ", null, false);
        }

        return $this->db->get()->result();
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