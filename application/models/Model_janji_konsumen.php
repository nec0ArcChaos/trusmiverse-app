<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_janji_konsumen extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function view_janji_konsumen(){
        $query = "SELECT * FROM view_janji_konsumen";
        return $this->db->query($query)->result();
    }
    function get_komplain($periode,$week,$jenis){
        $query = "SELECT 
                vw.id AS id_komplain,
                vw.komplain,
                vw.detail_komplain,
                vw.jenis,
                vw.kompensasi,
                vw.kebijakan,
                vw.nominal,
                vw.persen_company,
                vw.persen_employee
            FROM view_janji_konsumen vw
            LEFT JOIN t_janji_konsumen t 
                ON t.id_komplain = vw.id
                
                AND t.periode = '$periode'
                AND t.week = $week
            WHERE t.id IS NULL
            AND vw.jenis = '$jenis'
            ;
            ";
        return $this->db->query($query)->result();
    }
    function get_data($start,$end){
        $query = "SELECT
            t.id,
            t.id_komplain,
            t.periode,
            t.`week`,
            t.`value`,
            vw.komplain,
            vw.detail_komplain,
            vw.jenis,
            vw.kompensasi,
            vw.kebijakan,
            vw.nominal,
            vw.persen_company,
            vw.persen_employee,
            t.created_at,
            t.created_by,
            CONCAT(emp.first_name, ' ',emp.last_name) AS created_name
            FROM
            t_janji_konsumen t
            LEFT JOIN view_janji_konsumen vw ON vw.id = t.id_komplain
            LEFT JOIN xin_employees emp ON emp.user_id = t.created_by
            WHERE t.created_at BETWEEN '$start' AND '$end'
            ";
        return $this->db->query($query)->result();
    }

}
