<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_jkhpj_m_item extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_company()
    {
        $query = "SELECT * FROM xin_users WHERE is_active = 1";
        return $this->db->query($query)->result();
    }

    public function get_department($id)
    {
        $query = "SELECT * FROM xin_departments WHERE company_id = $id AND hide = 0";
        return $this->db->query($query)->result();
    }

    public function get_designation($company_id, $department_id)
    {
        $query = "SELECT 
                *  
                FROM xin_designations 
                WHERE hide = 0 
                    AND company_id = $company_id 
                    AND department_id = $department_id";
        return $this->db->query($query)->result();
    }

    public function dt_jkhpj_m_item()
    {
        $user_id = $this->session->userdata('user_id');
        $kondisi = "";
        if (in_array($user_id, [1])) {
            $kondisi .= "";
        }

        $query = "SELECT 
            jkhpj_m_item.*,
            xin_designations.designation_name
        FROM
            jkhpj_m_item
        JOIN xin_designations ON xin_designations.designation_id = jkhpj_m_item.designation_id
        $kondisi
        GROUP BY jkhpj_m_item.designation_id
        ORDER BY jkhpj_m_item.id_jkhpj_item DESC";
        return $this->db->query($query)->result();
    }

    public function dt_jkhpj_m_item_detail($designation)
    {
        $user_id = $this->session->userdata('user_id');

        $query = "SELECT 
            jkhpj_m_item.*,
            xin_designations.designation_name
        FROM
            jkhpj_m_item
        JOIN xin_designations ON xin_designations.designation_id = jkhpj_m_item.designation_id
        WHERE jkhpj_m_item.designation_id = $designation";
        return $this->db->query($query)->result();
    }

    public function update_item($id, $data)
    {
        // Gunakan query builder CI untuk keamanan
        $this->db->where('id_jkhpj_item', $id);
        $this->db->update('jkhpj_m_item', $data);

        // Kembalikan true jika ada baris yang ter-update
        return $this->db->affected_rows() > 0;
    }
}
