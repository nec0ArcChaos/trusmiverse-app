<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_master_jenis_biaya extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function get_list_jenis_biaya($tipe, $id)
    {
        if ($tipe == 1) {
            $kondisi = "WHERE e_jenis_biaya.id_jenis = '$id'";
        } else {
            $kondisi = "";
        }
        $query = "SELECT
                        e_jenis_biaya.id_jenis,
                        e_jenis_biaya.jenis,
                        e_m_akun.id_akun,
                        e_m_akun.nama_akun,
                        e_budget.id_budget,
                        e_budget.budget,
                        e_tipe_biaya.id_tipe_biaya,
                        e_tipe_biaya.nama_tipe_biaya,
                        usr.user_id AS id_user,
                        usr.user_id AS id_user_approval,
                        usr2.user_id AS id_user_approval2,
                        COALESCE(REPLACE(CONCAT(TRIM(usr.first_name), ' ', TRIM(usr.last_name)),',',', '),'') AS employee_name,
                        COALESCE(REPLACE(CONCAT(TRIM(usr2.first_name), ' ', TRIM(usr2.last_name)),',',', '),'') AS employee_name2,
                        COALESCE(REPLACE(CONCAT(TRIM(updated.first_name), ' ', TRIM(updated.last_name)),',',', '),'') AS created,
                        usr_ver.user_id as id_verifikator,
                        COALESCE(REPLACE(CONCAT(TRIM(usr_ver.first_name), ' ', TRIM(usr_ver.last_name)),',',', '),'') AS verifikator,
                        c.`name` AS company,
                        e_jenis_biaya.company_id AS jb_company_id,
                        e_company.company_name
                    FROM
                        e_eaf.e_jenis_biaya
                        LEFT JOIN e_eaf.e_m_akun ON e_m_akun.id_akun = e_jenis_biaya.id_akun
                        JOIN e_eaf.e_budget ON e_budget.id_budget = e_jenis_biaya.id_budget AND e_jenis_biaya.company_id = e_budget.company_id
                        LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id
                        JOIN e_eaf.e_tipe_biaya ON e_tipe_biaya.id_tipe_biaya = e_jenis_biaya.id_tipe_biaya

                        -- JOIN `user` as usr ON usr.id_user = e_jenis_biaya.id_user_approval
                        -- LEFT JOIN `user` AS updated ON updated.id_user = e_jenis_biaya.updated_by
                        -- LEFT JOIN `user` AS created ON created.id_user = e_jenis_biaya.created_by
                        -- LEFT JOIN `user` AS usr_ver ON usr_ver.id_user = e_jenis_biaya.id_user_verified
                        
                        JOIN `xin_employees` as usr ON usr.user_id = e_jenis_biaya.id_user_approval
                        LEFT JOIN `xin_employees` as usr2 ON usr2.user_id = e_jenis_biaya.id_user_approval2
                        LEFT JOIN `xin_employees` as updated ON updated.user_id = e_jenis_biaya.updated_by
                        LEFT JOIN `xin_employees` as created ON created.user_id = e_jenis_biaya.created_by
                        LEFT JOIN `xin_employees` as usr_ver ON usr_ver.user_id = e_jenis_biaya.id_user_verified
                        LEFT JOIN xin_companies AS c ON c.company_id = e_jenis_biaya.company_id
                        $kondisi";
        return $this->db->query($query)->result();

        // $e_eaf = $this->load->database('e_eaf', TRUE);
        // return $e_eaf->query($query)->result();
    }

    function get_tipe_biaya()
    {
        return $this->db->query("SELECT id_tipe_biaya, nama_tipe_biaya FROM e_eaf.e_tipe_biaya")->result();
    }

    function get_akun()
    {
        return $this->db->query("SELECT id_akun, nama_akun FROM e_eaf.e_m_akun")->result();
        // $db_e_eaf = $this->load->database('e_eaf', TRUE);
        // return $db_e_eaf->query("SELECT id_akun, nama_akun FROM e_m_akun")->result();

    }

    // function get_budget(){
    //     return $this->db->query("SELECT id_budget, budget FROM e_eaf.e_budget")->result();
    // }

    function get_budget_det($company_id)
    {
        return $this->db->query("SELECT id_budget, budget FROM e_eaf.e_budget WHERE company_id = $company_id");
    }

    function get_coa()
    {
        $eces = $this->load->database('db_eces_live', TRUE);
        $query = "SELECT coa_id, coa_kd, coa_nm FROM tm_coa";

        return $eces->query($query)->result();
    }

    function get_no_last_budget()
    {
        return $this->db->query("SELECT MAX(id_budget) AS id_budget, budget FROM e_eaf.e_budget")->row_array();
    }

    function get_user_approval()
    {
        // return $this->db->query("SELECT
        //     `user`.id_user,
        //     IF(`user`.employee_name = 'RI 2', 'Hendra Arya Cahyadi', `user`.employee_name) AS employee_name 
        // FROM
        //     `user` 
        // WHERE
        //     `user`.isActive = 1
        //     AND `user`.id_approval = 1")->result();
        // AND `user`.id_user IN ( SELECT e_jenis_biaya.id_user_approval FROM e_jenis_biaya GROUP BY e_jenis_biaya.id_user_approval ) OR (`user`.id_user IN (747,237,385,128,18,1066))

        return $this->db->query("SELECT 
        e.`user_id` AS id_user,
        COALESCE(
				CONCAT(
				REPLACE(CONCAT(TRIM(e.first_name), ' ', TRIM(e.last_name)),',',', '),
				' | ', c.kode ,  ' | ', d.department_name
				)
				,'') AS employee_name
        FROM e_eaf.e_parameter p 
				LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id, p.user_id)
				LEFT JOIN xin_companies c ON c.company_id = e.company_id
				LEFT JOIN xin_departments d ON d.department_id = e.department_id
        WHERE p.id = 1 AND e.is_active = 1 		")->result();
    }

    function cek_tipe_biaya($id)
    {
        return $this->db->query("SELECT
                                    id_biaya,
                                    nama_biaya,
                                    budget_awal,
                                    budget,
                                    IF(budget IS NULL,'Unlimited','Limited') as tipe
                                FROM
                                    e_eaf.e_biaya 
                                WHERE
                                    id_budget = '$id' 
                                    AND bulan = SUBSTR( CURDATE(), 6, 2 ) 
                                    AND tahun_budget = YEAR (
                                    CURDATE())")->row_array();
    }

    function get_tipe_biaya_new($tipe)
    {
        return $this->db->query("SELECT
                                    id_tipe_biaya AS id,
                                    nama_tipe_biaya AS tipe 
                                FROM
                                    e_eaf.e_tipe_biaya 
                                WHERE
                                    id_tipe_biaya IN ( $tipe )")->result();
    }

    // function get_company()
    // {
    //     return $this->db->query("SELECT
    //                                 company_id, `name`
    //                             FROM
    //                                 xin_companies
    //                            ")->result();
    // }

    function get_company()
    {
        return $this->db->query("SELECT company_id,
                                    company_name as `name`,
                                    company_master,
                                    company_kode
                                    FROM 
                                    e_eaf.e_company
                               ")->result();
    }

    function get_e_parameter($id_user)
    {
        return $this->db->query("SELECT * FROM e_eaf.e_parameter WHERE id = 2 AND FIND_IN_SET($id_user,user_id) ")->result();
    }
}

/* End of file model_eaf.php */
/* Location: ./application/models/model_divisi.php */