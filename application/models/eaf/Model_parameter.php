<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_parameter extends CI_Model
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('upload');
        $this->load->database();
    }

    function list_menu()
    {
        $sql = "SELECT menu_id, menu_nm FROM trusmi_navigation WHERE menu_id IN (76,82,86,91,93,94,95,104)";
        return $this->db->query($sql);
    }

    function dt_akses_menu()
    {
        $sql = "SELECT menu_id, menu_nm,
                    em.user_id AS id_user,
                    CONCAT( em.first_name, ' ', em.last_name, '( ',dp.department_name,' )' ) AS employee_name

                    FROM 
                    xin_employees em
                    LEFT JOIN hris.xin_departments as dp ON dp.department_id = em.department_id
                    LEFT JOIN hris.xin_companies as com ON com.company_id = em.company_id
                    LEFT JOIN trusmi_navigation nav ON FIND_IN_SET(em.user_id,nav.user_id)
                    WHERE nav.menu_id IN (76,82,86,91,93,94,95) AND em.user_id NOT IN (1)";
        return $this->db->query($sql);
    }

    function data_karyawan()
    {
        $query = "SELECT
                        em.user_id AS id_user,
                        CONCAT( em.first_name, ' ', em.last_name, '( ',dp.department_name,' )' ) AS employee_name,
                        dp.department_name AS divisi, em.company_id, com.name AS company_name

                    FROM
                        hris.xin_employees AS em
                        LEFT JOIN hris.xin_departments as dp ON dp.department_id = em.department_id
                        LEFT JOIN hris.xin_companies as com ON com.company_id = em.company_id

                    WHERE
                        ( em.company_id IN ( 1,2,3,4,5,6 ) OR em.user_id = 1543 ) 
                        AND em.is_active = 1 AND em.user_id <> 1
                        OR em.`user_id` = 2493";

        return $this->db->query($query);
    }

    function list_fitur()
    {
        $sql = "SELECT * FROM e_eaf.e_parameter fit WHERE fit.id IN (1,7,8)";
        return $this->db->query($sql);
    }

    function dt_akses_fitur()
    {
        $sql = "SELECT id  AS fitur_id, access AS fitur_nm, fit.keterangan AS fitur_ket,
                    em.user_id AS id_user,
                    CONCAT( em.first_name, ' ', em.last_name, '( ', dp.department_name, ' )' ) AS employee_name 
                    FROM
                        xin_employees em
                        LEFT JOIN hris.xin_departments AS dp ON dp.department_id = em.department_id
                        LEFT JOIN hris.xin_companies AS com ON com.company_id = em.company_id
                        LEFT JOIN e_eaf.e_parameter fit ON FIND_IN_SET( em.user_id, fit.user_id ) 
                    WHERE
                        fit.id IN ( 1,7,8 ) 
                        AND em.user_id NOT IN (
                        1)";
        return $this->db->query($sql);
    }
   
}
