<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_trusmi_wb extends CI_Model
{
    protected $userId;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->userId = $this->session->userdata('user_id');
    }

    public function getAllDepartment()
    {
        $query = "SELECT
        department_id,
        department_name AS nama_dep,
        company_id 
    FROM
        xin_departments";

        return $this->db->query($query)->result();
    }

    public function getDepartmentActive()
    {
        $query = "SELECT
        dep.department_id,
        CONCAT( dep.department_name, ' | ', comp.`name` ) AS nama_dep 
    FROM
        xin_departments dep
        JOIN ( SELECT user_id, department_id FROM xin_employees WHERE is_active = 1 ) emp ON emp.department_id = dep.department_id
        LEFT JOIN xin_companies comp ON comp.company_id = dep.company_id 
    GROUP BY
        dep.department_id 
    ORDER BY
        department_name";
        return $this->db->query($query)->result();
    }

    public function getEmployee($id = null)
    {
        if ($id != null) {
            $kondisi = "WHERE xin_employees.department_id = $id and is_active = 1";
        } else {
            $kondisi = "WHERE is_active = 1";
        }

        $query = "SELECT
        user_id AS 
    `value`
        ,
        CONCAT( first_name, ' ', last_name,' | ',ds.designation_name ) AS `text`
    FROM
        `xin_employees`
        LEFT JOIN xin_designations ds ON xin_employees.designation_id = ds.designation_id
        $kondisi
        ORDER BY ds.designation_name";
        return $this->db->query($query)->result();
    }

    public function getCompany()
    {
        $query = "SELECT company_id, `name` AS nama_com FROM xin_companies";
        return $this->db->query($query)->result();
    }

    public function getDepartmentByCompany($id)
    {
        $query = "SELECT
        department_id,
        department_name AS nama_dep,
        company_id 
    FROM
        xin_departments
        WHERE 
        company_id = $id";

        return $this->db->query($query)->result();
    }

    public function getWbAktivitas()
    {
        $this->db->select('*')->from('trusmi_m_wb_aktivitas')->order_by('id_aktivitas', 'asc');
        return $this->db->get()->result();
    }

    public function getWbPertanyaan()
    {
        $this->db->select('*')->from('trusmi_m_wb_pertanyaan')->order_by('id_pertanyaan', 'asc');
        return $this->db->get()->result_array();
    }

    public function getListWb($start, $end)
    {
        $user = $this->session->userdata('user_id');
        $userList = [1, 68, 803];
        if (!in_array($user, $userList)) {
            $kondisi = "AND twb.created_by = '$user'";
        } else {
            $kondisi = "";
        }

        $query = "SELECT
        twb.id_wb,
        twb.laporan,
        xd.department_name AS nama_department,
        CONCAT(xe.first_name,' ',xe.last_name) AS nama_employee,
        xe.username,
        xe.profile_picture,
        twb.tgl_temuan,
        twb.id_aktivitas,
        mwa.aktivitas,
        twb.note_other,
        twb.kronologi,
        twb.lokasi,
        twb.kota,
        twb.hubungan,
        xct.`name` AS nama_company_terkait,
        xdt.department_name AS nama_department_terkait,
        twb.informasi,
        twb.bukti,
        COALESCE(twb.persetujuan,1) AS persetujuan,
        created_by.profile_picture AS created_profile_picture,
	    created_by.username AS created_username,
        CONCAT(created_by.first_name,' ',created_by.last_name) AS created_by,
        twb.created_at,
        GROUP_CONCAT( CONCAT( twbp.pertanyaan, ' ', '<b>',twbp.jawaban,'</b>' ) SEPARATOR '<br>' ) AS jawaban 
    FROM
        `trusmi_t_wb` twb
        LEFT JOIN trusmi_m_wb_aktivitas mwa ON mwa.id_aktivitas = twb.id_aktivitas
        LEFT JOIN xin_employees xe ON xe.user_id = twb.employee_id
        LEFT JOIN xin_departments xd ON xd.department_id = twb.department_id
        LEFT JOIN xin_departments xdt ON xdt.department_id = twb.department_terkait
        LEFT JOIN xin_companies xct ON xct.company_id = twb.company_terkait
        LEFT JOIN xin_employees created_by ON created_by.user_id = twb.created_by
        JOIN trusmi_t_wb_pertanyaan twbp ON twbp.id_wb = twb.id_wb 
        WHERE
        DATE(twb.created_at) BETWEEN '$start' AND '$end'
        $kondisi
    GROUP BY
        twb.id_wb 
    ORDER BY
        tgl_temuan";
        return $this->db->query($query)->result();
    }
}
