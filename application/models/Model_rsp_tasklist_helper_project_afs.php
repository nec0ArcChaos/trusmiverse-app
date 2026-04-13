<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_rsp_tasklist_helper_project_afs extends CI_Model
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
                                    ph.id_project,
                                    pro.project,
                                    ph.pekerjaan AS id_pekerjaan,
                                    m_ph.aftersales AS pekerjaan,
                                    ph.detail_pekerjaan,
                                    ph.item,
                                    ph.tanggal_pengerjaan,
                                    ph.helper AS id_hr_helper,
                                    GROUP_CONCAT(
                                    CONCAT( hlp.first_name, ' ', hlp.last_name )) AS helper,
                                    ph.equipment,
                                    ph.created_at,
                                    ph.created_by AS id_created_by,
                                    usr.employee_name AS created_by,
                                    ph.`status` AS id_status,
                                    st.tasklist_helper_project AS `status`,
                                    ph.foto_start,
                                    ph.note_start,
                                    ph.start_at,
                                    ph.start_by AS id_start_by,
                                    str.employee_name AS start_by,
                                    ph.foto_end,
                                    ph.note_end,
                                    ph.end_at,
                                    ph.end_by AS id_end_by,
                                    en.employee_name AS end_by,
                                    a.id_after_sales
                                FROM
                                    rsp_project_live.t_helper_project_afs AS ph
                                    LEFT JOIN rsp_project_live.m_project_unit mpu ON (mpu.id_project = ph.id_project AND mpu.blok = ph.item)
	                                LEFT JOIN rsp_project_live.t_after_sales a ON a.id_project_unit = mpu.id_project_unit
                                    JOIN rsp_project_live.m_project AS pro ON pro.id_project = ph.id_project
                                    JOIN rsp_project_live.m_helper_project AS m_ph ON m_ph.id = ph.pekerjaan
                                    JOIN hris.xin_employees AS hlp ON FIND_IN_SET( hlp.user_id, ph.helper )
                                    JOIN rsp_project_live.`user` AS usr ON usr.id_user = ph.created_by
                                    JOIN rsp_project_live.m_status AS st ON st.id_status = ph.`status`
                                    LEFT JOIN rsp_project_live.`user` AS str ON str.id_user = ph.start_by
                                    LEFT JOIN rsp_project_live.`user` AS en ON en.id_user = ph.end_by
                                $kondisi $cond
                                GROUP BY
                                    ph.no_ph
                                ORDER BY ph.tanggal_pengerjaan DESC, ph.status ASC");
    }
}
