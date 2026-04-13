<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lock_absen_viky_andani extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function index()
    {
        echo "Cronjob insert to lock manual";
    }

    // Insert weekly on every Saturday
    function insert_ev_saturday()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_personal_consistency = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('personal', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Personal Consistency - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_personal_consistency;

        $insert_company_consistency = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('comp const', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Company Consistency - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_company_consistency;

        $insert_penjualan_rumah = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('penjualan', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Penjualan Rumah - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_penjualan_rumah;

        $insert_rekap_fu = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('rekap FU', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Rekap FU & Aprroval - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_rekap_fu;

        var_dump($this->db->affected_rows());
    }

    // Insert weekly on every tuesday
    function insert_ev_tuesday()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_review_pa = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('review PA', $user, 'Silahkan melakukan review Personal Assitant dan dapat mengirim hasilnya kepada pak Ibnu - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_review_pa;
    }

    function insert_ev_20()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_review_pa = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('review PA', $user, 'Silahkan dapat mengirimkan report ke Fafricony terkait CCP Sekdir
 - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_review_pa;
    }

    // Insert weekly on every monday
    function insert_ev_monday()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_consistency_bu_sally = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('const sally', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Consistency Bu Sally - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_consistency_bu_sally;
    }

    // MONTHLY
    // Insert monthly on 22
    function insert_ev_22()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_haki = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('haki', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait HAKI - Akun DJKI ( Paten, Merek, Desain Industri) - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_haki;
    }

    function insert_ev_21()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_haki = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('haki', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait HAKI - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_haki;
    }

    function insert_ev_16()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_haki = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                        (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                        VALUES ('haki', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait L/R Mega - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_haki;
    }

    // Insert monthly on 19
    function insert_ev_19()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_miles = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                         (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                         VALUES ('miles', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait miles by Bintang - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_miles;
    }

    // Insert monthly on 2
    function insert_ev_2()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_pengeluaran_anak2 = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                         (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                         VALUES ('pengeluaran', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait pengeluaran anak-anak - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_pengeluaran_anak2;

        $insert_personal_consistency = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                         (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                         VALUES ('personal', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Personal Consistency - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_personal_consistency;
    }

    // Insert monthly on 1
    function insert_ev_1()
    {
        $gagas7309 = 9633;
        $putri7696 = 10034;
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_comp_consist = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                         (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                         VALUES ('comp const', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait Company Consistency - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_comp_consist;
    }

    // Insert monthly on 3
    function insert_ev_3()
    {
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_peng_prive = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                         (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                         VALUES ('pgg prive', $user, 'Silahkan dapat mengirimkan report ke pak Ibnu terkait penggunaan prive - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_peng_prive;
    }

    // Insert monthly on 8
    function insert_ev_8()
    {
        $user = 1139; // viky andani
        $created_by = 78; // Fafrycony

        $insert_evaluasi_pa = $this->db->query("INSERT INTO `trusmi_lock_absen_manual` 
                                          (`type_lock`, `employee_id`, `alasan_lock`, `status`, `created_at`,  `created_by`, `updated_at`, `updated_by`) 
                                          VALUES ('eval PA', $user, 'Silahkan mengirimkan evaluasi Personal Assistant kepada pak Ibnu - By Fafricony Ristiara Devi', 1, '" . date('Y-m-d H:i:s') . "', $created_by, NULL, NULL)");
        echo $insert_evaluasi_pa;
    }
}
