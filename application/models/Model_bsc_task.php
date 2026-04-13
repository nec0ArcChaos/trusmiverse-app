<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_bsc_task extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Filter');
        $this->load->database();
    }

    function data_all_tasklist($periode, $pic)
    {
        $where_pic = (in_array($pic, [1,61,2,329,2378,2951,3388,3651,4138,4770,4948,4954,5121,5286,5336,5382,5508,5510,5530,5534,5598,5842,6030,476,2729,5649,108,786,272,340,1186])) ? "" : "AND bsc_tasklist.pic = $pic" ;

        $query = "SELECT
            bsc_tasklist.id,
            bsc_tasklist.periode,
            xin_companies.alias AS unit_bisnis,
            bsc_m.department,
            bsc_m.perspective,
            bsc_m.sub,
            bsc_tasklist.jabatan,
            bsc_so.strategy AS so,
            bsc_si.strategy AS si, 
            bsc_tasklist.strategy,
            bsc_tasklist.target,
            COALESCE(bsc_tasklist.actual, 0) AS actual,
            COALESCE(bsc_tasklist.target - bsc_tasklist.actual,0) AS deviasi,
            bsc_tasklist.achieve,
            bsc_tasklist.frekuensi,
            bsc_tasklist.`status`,
            COALESCE ( bsc_tasklist.lampiran, '' ) AS lampiran,
            COALESCE ( bsc_tasklist.link, '' ) AS link,
            bsc_tasklist.resume,
            bsc_tasklist.updated_at AS created_at,
            TRIM( CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ) AS created_by 
        FROM
            bsc_tasklist
            JOIN bsc_si ON bsc_tasklist.id_si = bsc_si.id_si 
            AND bsc_tasklist.id_so = bsc_si.id_so
            JOIN bsc_so ON bsc_si.id_so = bsc_so.id_so
            LEFT JOIN bsc_m ON bsc_m.category = bsc_so.category 
            AND bsc_m.company_id = bsc_so.company_id 
            AND bsc_m.department = bsc_so.department
            LEFT JOIN xin_companies ON bsc_m.company_id = xin_companies.company_id
            LEFT JOIN xin_employees ON bsc_tasklist.updated_by = xin_employees.user_id 
        WHERE
            bsc_tasklist.periode = '$periode' 
            $where_pic
        ORDER BY
            bsc_si.strategy ASC";

        return $this->db->query($query)->result();
    }

    function data_tasklist($periode, $type, $pic)
    {

        $where_type = ($type == "All") ? "" : "AND COALESCE(bsc_tasklist.frekuensi, 'Monthly') = '$type'" ;
        $where_pic = (in_array($pic, [1,61,2,329,2378,2951,3388,3651,4138,4770,4948,4954,5121,5286,5336,5382,5508,5510,5530,5534,5598,5842,6030,476,2729,5649,108,786,272,340,1186])) ? "" : "AND bsc_tasklist.pic = $pic" ;

        $query = "SELECT
            bsc_tasklist.id,
            bsc_tasklist.periode,
            xin_companies.alias AS unit_bisnis,
            bsc_m.department,
            bsc_m.perspective,
            bsc_m.sub,
            bsc_tasklist.jabatan,
            bsc_so.strategy AS so,
            bsc_si.strategy AS si,
            bsc_tasklist.strategy AS tasklist,
            bsc_tasklist.target,
            COALESCE(bsc_tasklist.actual, 0) AS actual,
            bsc_tasklist.achieve,
            COALESCE(bsc_tasklist.frekuensi, 'Monthly') AS frekuensi,
            bsc_tasklist.`status`,
            bsc_tasklist.updated_at AS created_at,
            TRIM( CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ) AS created_by 
        FROM
            bsc_tasklist
            JOIN bsc_si ON bsc_tasklist.id_si = bsc_si.id_si 
            AND bsc_tasklist.id_so = bsc_si.id_so
            JOIN bsc_so ON bsc_si.id_so = bsc_so.id_so
            LEFT JOIN bsc_m ON bsc_m.category = bsc_so.category 
            AND bsc_m.company_id = bsc_so.company_id 
            AND bsc_m.department = bsc_so.department
            LEFT JOIN xin_companies ON bsc_m.company_id = xin_companies.company_id
            LEFT JOIN xin_employees ON bsc_tasklist.updated_by = xin_employees.user_id 
        WHERE
            bsc_tasklist.periode = '$periode' 
            $where_type
            $where_pic
        ORDER BY
            bsc_si.strategy ASC";

        return $this->db->query($query)->result();
    }

    function data_tasklist_item_history($periode, $id)
    {
        $query = "SELECT
            bsc_tasklist_h.periode,
            TRIM( CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ) AS created_by,
            bsc_tasklist_h.`status`,
            bsc_tasklist_h.actual,
            bsc_tasklist_h.resume,
            bsc_tasklist_h.lampiran,
            bsc_tasklist_h.link,
            bsc_tasklist_h.updated_at AS created_at 
        FROM
            bsc_tasklist_h
            JOIN xin_employees ON bsc_tasklist_h.updated_by = xin_employees.user_id 
        WHERE
            bsc_tasklist_h.id_task = $id
            AND bsc_tasklist_h.periode = '$periode'";

        return $this->db->query($query)->result();
    }

    function get_task_item($id)
    {
        $query = "SELECT * FROM bsc_tasklist WHERE bsc_tasklist.id = $id";

        return $this->db->query($query)->row_array();
    }
}
