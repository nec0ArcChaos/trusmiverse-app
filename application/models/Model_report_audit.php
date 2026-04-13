<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_report_audit extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function generate_id_report_audit()
    {
        $q = $this->db->query("SELECT 
                                MAX( RIGHT ( id_report, 4 ) ) AS kd_max 
                              FROM
                                report_audit_finance 
                              WHERE
                                DATE( created_at ) = CURDATE()");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int)$k->kd_max) + 1;
                $kd = sprintf("%04s", $tmp);
            }
        } else {
            $kd = "0001";
        }

        return 'RA' . date('ymd') . $kd;
    }

    function dt_report($start, $end)
    {
        $user_id        = $_SESSION['user_id'];

        $sql = "SELECT
                    raf.id_report,
                    raf.`status`,
                    raf.attachment,
                    raf.created_at,
                    raf.created_by AS id_created_by,
                    CONCAT(usr_create.first_name, ' ',  usr_create.last_name) AS created_by,
                    raf.note,
                    raf.approved_at,
                    raf.approved_by AS id_approved_by,
                    CONCAT(usr_approve.first_name, ' ',  usr_approve.last_name) AS approved_by,
                    raf.approved_note
                FROM
                    `report_audit_finance` AS raf
                    JOIN `xin_employees` usr_create ON raf.created_by = usr_create.user_id
                    LEFT JOIN `xin_employees` usr_approve ON raf.approved_by = usr_approve.user_id
                WHERE
	                DATE(raf.created_at) BETWEEN '$start' AND '$end'";

        return $this->db->query($sql)->result();
    }

    function dt_waiting_report()
    {
        $sql = "SELECT
                    raf.id_report,
                    raf.`status`,
                    raf.attachment,
                    raf.created_at,
                    raf.created_by AS id_created_by,
                    CONCAT(usr_create.first_name, ' ',  usr_create.last_name) AS created_by,
                    raf.note
                FROM
                    `report_audit_finance` AS raf
                    JOIN `xin_employees` usr_create ON raf.created_by = usr_create.user_id
                WHERE
	                raf.`status` = 1";

        return $this->db->query($sql)->result();
    }

    // -------------------------------------------------------------------------------



    function list_pph21($start, $end)
    {
        $user_id        = $_SESSION['user_id'];
        $role_id        = $_SESSION['user_role_id'];
        $company_id     = $_SESSION['company_id'];
        $department_id  = $_SESSION['department_id'];
        $designation_id = $_SESSION['designation_id'];

        $list_super       = [5286];   // farid3241

        if ($role_id == 1 || in_array($user_id, $list_super)) { // Super Admin
            $kondisi = "";
        } else {
            $kondisi = "AND tsk.department_id = $department_id";
        }

        return $this->db->query("SELECT
                                    pph.id_pajak,
                                    pph.`status`,
                                    pph.attachment,
                                    pph.created_at,
                                    emp_create.username AS created_by,
                                    pph.verified_file,
                                    pph.verified_at,
                                    emp_ver.username AS verified_by,
                                    pph.paid_file,
                                    pph.paid_at,
                                    emp_paid.username AS paid_by, 
                                    pph.note
                                FROM
                                    `trusmi_pph21` AS pph
                                    LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
                                    LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
                                    LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by 
                                WHERE
                                    DATE ( pph.created_at ) BETWEEN '$start' 
                                    AND '$end'")->result();
    }

    function dt_verif_pph21()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $sql = "SELECT
                    pph.id_pajak,
                    pph.`status`,
                    pph.attachment,
                    pph.created_at,
                    emp_create.username AS created_by,
                    pph.verified_file,
                    pph.verified_at,
                    emp_ver.username AS verified_by,
                    pph.paid_file,
                    pph.paid_at,
                    emp_paid.username AS paid_by, 
                    pph.note
                FROM
                    `trusmi_pph21` AS pph
                    LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
                    LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
                    LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by 
                WHERE
                    pph.status = 1
                    AND DATE ( pph.created_at ) BETWEEN '$start' 
                    AND '$end'";
        return $this->db->query($sql)->result();
    }

    function dt_paid_pph21()
    {
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $sql = "SELECT
                    pph.id_pajak,
                    pph.`status`,
                    pph.attachment,
                    pph.created_at,
                    emp_create.username AS created_by,
                    pph.verified_file,
                    pph.verified_at,
                    emp_ver.username AS verified_by,
                    pph.paid_file,
                    pph.paid_at,
                    emp_paid.username AS paid_by, 
                    pph.note
                FROM
                    `trusmi_pph21` AS pph
                    LEFT JOIN xin_employees AS emp_create ON emp_create.user_id = pph.created_by
                    LEFT JOIN xin_employees AS emp_ver ON emp_ver.user_id = pph.verified_by
                    LEFT JOIN xin_employees AS emp_paid ON emp_paid.user_id = pph.paid_by 
                WHERE
                    pph.status = 2
                    AND DATE ( pph.created_at ) BETWEEN '$start' 
                    AND '$end'";
        return $this->db->query($sql)->result();
    }

    // AUTONOTIF PENYERAHAN, VERIFIKASI DAN PEMBAYARAN PPH 21
    function autonotif_penyerahan() {}
} // End of class
