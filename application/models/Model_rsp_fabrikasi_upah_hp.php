<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rsp_fabrikasi_upah_hp extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    function data_tasklist($start = null, $end = null, $tipe, $id_user = null, $no_ph = null)
    {
        if ($tipe == 1) { // Get Data All
            $kondisi = "WHERE ph.tanggal_pengerjaan BETWEEN '$start' AND '$end'";
        } else if ($tipe == 3) { // Get Proses Detail
            $kondisi = "WHERE ph.no_ph = '$no_ph'";
        } else { // Selain Pelaksana akan Akses Semua Data Proses
            $kondisi = "WHERE ph.status <> 3";
        }

        $cond = " AND FIND_IN_SET('$id_user',ph.helper)";
        $allowed_user_akses = ['2063', '1', '61'];
        if (in_array($id_user, $allowed_user_akses)) {
            $cond = "";
        }
        return $this->db->query("SELECT
                                    ph.no_ph,
                                    m_ph.pekerjaan AS pekerjaan,
                                    ph.detail_pekerjaan,
                                    COALESCE ( ph.tanggal_pengerjaan, ' ' ) AS tanggal_pengerjaan,
                                    CONCAT( hlp.first_name, ' ', hlp.last_name ) AS helper,
                                    ph.equipment,
                                    ph.created_at,
                                    ph.created_by AS id_created_by,
                                    usr.employee_name AS created_by,
                                    ph.`status` AS id_status,
                                    st.tasklist_helper_project AS `status`,
                                    COALESCE ( ph.foto_start, ' ' ) AS foto_start,
                                    COALESCE ( ph.note_start, ' ' ) AS note_start,
                                    COALESCE ( ph.start_at, ' ' ) AS start_at,
                                    COALESCE ( ph.start_by, ' ' ) AS id_start_by,
                                    COALESCE ( CONCAT( str.first_name, ' ', str.last_name ), ' ' ) AS start_by,
                                    COALESCE ( ph.foto_end, ' ' ) AS foto_end,
                                    COALESCE ( ph.note_end, ' ' ) AS note_end,
                                    COALESCE ( ph.end_at, ' ' ) AS end_at,
                                    COALESCE ( ph.end_by, ' ' ) AS id_end_by,
                                    COALESCE ( CONCAT( en.first_name, ' ', en.last_name ), ' ' ) AS end_by,
                                    GROUP_CONCAT( m_ph_item.item_pekerjaan ) AS item_pekerjaan 
                                FROM
                                    rsp_project_live.t_fabrikasi_upah_hp AS ph
                                    JOIN rsp_project_live.m_fabrikasi_upah_hp AS m_ph ON m_ph.id = ph.pekerjaan
                                    LEFT JOIN rsp_project_live.m_fabrikasi_upah_hp_item AS m_ph_item ON FIND_IN_SET( m_ph_item.id, ph.item )
                                    JOIN hris.xin_employees AS hlp ON hlp.user_id = ph.helper
                                    JOIN rsp_project_live.`user` AS usr ON usr.id_user = ph.created_by
                                    JOIN rsp_project_live.m_status AS st ON st.id_status = ph.`status`
                                    LEFT JOIN `hris`.`xin_employees` AS str ON str.user_id = ph.start_by
                                    LEFT JOIN `hris`.`xin_employees` AS en ON en.user_id = ph.end_by
                                    LEFT JOIN rsp_project_live.`user` AS apr ON apr.id_user = ph.approval_by
                                    LEFT JOIN rsp_project_live.m_status AS st_apr ON st_apr.id_status = ph.`status_approval` 
                                $kondisi $cond
                                GROUP BY
                                    ph.no_ph");
    }
}
