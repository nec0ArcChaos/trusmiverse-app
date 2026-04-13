<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_absent_public extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    function dt_list_department()
    {
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
            if ($status == "1") {
                $kondisi = "AND xin_departments.publik = $status";
            } else if ($status == "0") {
                $kondisi = "AND xin_departments.publik = $status
                            OR xin_departments.publik IS NULL";
            } else {
                $kondisi = "";
            }
        } else {
            $kondisi = "";
        }
        $query = "SELECT 
                    xin_departments.department_id,
                    xin_departments.department_name,
                    xin_companies.`name` AS company_name,
                    IF(COALESCE(xin_departments.publik,0)='',0,1) AS publik
                FROM xin_departments
                LEFT JOIN xin_companies ON xin_companies.company_id = xin_departments.company_id
                -- WHERE xin_departments.department_id != 68
                $kondisi";
        return $this->db->query($query)->result();
    }


    function dt_list_employees()
    {
        if (isset($_POST['status'])) {
            $status = $_POST['status'];
            if ($status == "1") {
                $kondisi = "WHERE (xin_employees.is_active = 1
                            AND COALESCE(xin_departments.publik,0) != 1)
                            AND (xin_employees.publik = $status)";
            } else if ($status == "0") {
                $kondisi = "WHERE (xin_employees.is_active = 1
                            AND COALESCE(xin_departments.publik,0) != 1)
                            AND (xin_employees.publik = $status
                            OR xin_employees.publik IS NULL)";
            } else {
                $kondisi = "WHERE (xin_employees.is_active = 1
                            AND COALESCE(xin_departments.publik,0) != 1)";
            }
        } else {
            $kondisi = "WHERE (xin_employees.is_active = 1
                        AND COALESCE(xin_departments.publik,0) != 1)";
        }
        $query = "SELECT 
                    xin_employees.user_id,
                    CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee_name,
                    xin_designations.designation_name AS designation,
                    xin_departments.department_name AS department,
                    xin_companies.`name` AS company,
                    IF(COALESCE(xin_employees.publik,0)='',0,1) AS publik
                FROM xin_employees
                LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
                LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
                LEFT JOIN xin_companies ON xin_companies.company_id = xin_employees.company_id
                $kondisi";
        return $this->db->query($query)->result();
    }

    function dt_list_companies()
    {
        $this->db->select('xin_companies.company_id, xin_companies.name, xin_companies.is_public');
        // Menambahkan Count Karyawan Aktif
        $this->db->select('COUNT(xin_employees.user_id) as total_employees');
        $this->db->select('COUNT(DISTINCT xin_departments.department_id) as total_departments');

        $this->db->from('xin_companies');

        // Join ke tabel employees dengan filter is_active = 1
        // Menggunakan LEFT JOIN agar Company yang tidak punya karyawan tetap muncul (dengan total 0)
        $this->db->join('xin_employees', 'xin_employees.company_id = xin_companies.company_id AND xin_employees.is_active = 1', 'left');
        $this->db->join('xin_departments', 'xin_departments.department_id = xin_employees.department_id', 'left');

        // Grouping berdasarkan company_id wajib dilakukan untuk fungsi agregat (COUNT)
        $this->db->group_by('xin_companies.company_id');

        return $this->db->get()->result();
    }

    function update_company_batch($ids, $status)
    {
        // $ids adalah array company_id, $status adalah 0 atau 1
        $data = array(
            'is_public' => $status
        );
        $this->db->where_in('company_id', $ids);
        return $this->db->update('xin_companies', $data);
    }

    // TAMBAHAN: List Working Location + Total Employee
    function dt_list_working_locations()
    {
        $this->db->select('m_working_location.id, m_working_location.lokasi, m_working_location.is_public');
        // Hitung total karyawan aktif yang departemennya terhubung ke lokasi ini
        $this->db->select('COUNT(xin_employees.user_id) as total_employees');

        $this->db->from('m_working_location');

        // Join ke Department (penghubung)
        $this->db->join('xin_departments', 'xin_departments.work_location_id = m_working_location.id', 'left');

        // Join ke Employees (untuk dihitung)
        $this->db->join('xin_employees', 'xin_employees.department_id = xin_departments.department_id AND xin_employees.is_active = 1', 'left');

        $this->db->group_by('m_working_location.id');

        return $this->db->get()->result();
    }

    // TAMBAHAN: Update Batch Working Location
    function update_working_location_batch($ids, $status)
    {
        $data = array(
            'is_public' => $status
        );
        $this->db->where_in('id', $ids);
        return $this->db->update('m_working_location', $data);
    }
}
