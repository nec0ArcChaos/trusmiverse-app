<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_pajak extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_pph21()
    {
        $q = $this->db->query("SELECT 
                                MAX( RIGHT ( id_pajak, 4 ) ) AS kd_max 
                              FROM
                                trusmi_pph21 
                              WHERE
                                DATE( created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return 'RP' . date('ymd') . $kd;
    }

    function list_pph21($start, $end)
    {
        $user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['user_role_id'];
        $company_id = $_SESSION['company_id'];
        $department_id = $_SESSION['department_id'];
        $designation_id = $_SESSION['designation_id'];

        $list_super = [5286];   // farid3241

        if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
            $kondisi = "";
        } else {
            $kondisi = "AND tsk.department_id = $department_id";
        }

        $kondisi_kategori = "";
        if ($role_id == 1) {
            // hanya kategori 1,2,3 yang muncul
            $kondisi_kategori = "AND pph.category IN (1,2,3)";
        }

        return $this->db->query("SELECT
                                pph.id_pajak,
                                pph.status,
                                pph.attachment,
                                pph.created_at,
                                emp_create.username AS created_by,
                                pph.verified_file,
                                pph.verified_at,
                                emp_ver.username AS verified_by,
                                pph.paid_file,
                                pph.paid_at,
                                emp_paid.username AS paid_by, 
                                pph.note,
                                cat.category AS category_name
                            FROM
                                trusmi_pph21 AS pph
                                LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
                                LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
                                LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by
                                LEFT JOIN trusmi_pph_category AS cat ON cat.id = pph.category 
                            WHERE
                                DATE(pph.created_at) BETWEEN '$start' AND '$end' ")->result();

    }

    function dt_verif_pph21()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $user_id = $this->session->userdata('user_id');

        $filter_category = "";

        // bu fani, mba aisah, mba eka
        if ($user_id == 77) {
            $filter_category = " AND pph.category IN (1,2,3,4,5,6,7,8,9,10,15,18,21,22,23,24,25,26,29,30) ";
        } elseif ($user_id == 4302) {
            $filter_category = " AND pph.category IN (11,12,16,17) ";
        } elseif ($user_id == 81) {
            $filter_category = " AND pph.category IN (13,14,19,20) ";
        }

        $sql = "SELECT
                pph.id_pajak,
                pph.status,
                pph.attachment,
                pph.created_at,
                emp_create.username AS created_by,
                pph.verified_file,
                pph.verified_at,
                emp_ver.username AS verified_by,
                pph.paid_file,
                pph.paid_at,
                emp_paid.username AS paid_by,
                pph.note,
                cat.category AS category_name
            FROM trusmi_pph21 AS pph
            LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
            LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
            LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by
            LEFT JOIN trusmi_pph_category AS cat ON cat.id = pph.category
            WHERE pph.status = 1
            AND DATE(pph.created_at) BETWEEN '$start' AND '$end'
            $filter_category
    ";

        return $this->db->query($sql)->result();
    }


    // function dt_verif_pph21()
    // {
    //     $start = date("Y-m-01");
    //     $end = date("Y-m-t");

    //     $sql = "SELECT
    //             pph.id_pajak,
    //             pph.status,
    //             pph.attachment,
    //             pph.created_at,
    //             emp_create.username AS created_by,
    //             pph.verified_file,
    //             pph.verified_at,
    //             emp_ver.username AS verified_by,
    //             pph.paid_file,
    //             pph.paid_at,
    //             emp_paid.username AS paid_by, 
    //             pph.note,
    //             cat.category AS category_name 
    //         FROM
    //             trusmi_pph21 AS pph
    //             LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
    //             LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
    //             LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by
    //             LEFT JOIN trusmi_pph_category AS cat ON cat.id = pph.category  
    //         WHERE
    //             pph.status = 1
    //             AND DATE(pph.created_at) BETWEEN '$start' AND '$end'";

    //     return $this->db->query($sql)->result();
    // }


    function dt_paid_pph21()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $sql = "SELECT
                pph.id_pajak,
                pph.status,
                pph.attachment,
                pph.created_at,
                emp_create.username AS created_by,
                pph.verified_file,
                pph.verified_at,
                emp_ver.username AS verified_by,
                pph.paid_file,
                pph.paid_at,
                emp_paid.username AS paid_by, 
                pph.note,
                cat.category AS category_name 
            FROM
                trusmi_pph21 AS pph
                LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
                LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
                LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by
                LEFT JOIN trusmi_pph_category AS cat ON cat.id = pph.category 
            WHERE
                pph.status = 2
                AND DATE(pph.created_at) BETWEEN '$start' AND '$end'";

        return $this->db->query($sql)->result();
    }


    // AUTONOTIF PENYERAHAN, VERIFIKASI DAN PEMBAYARAN PPH 21
    function autonotif_penyerahan()
    {
    }
} // End of class
