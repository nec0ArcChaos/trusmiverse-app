<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_sosi extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Filter');
        $this->load->database();
    }

    function get_strategi_objektif()
    {
        $user_id = $this->filter->sanitaze_input($this->input->post('user_id')) ?? "";
        $id_objektif = $this->filter->sanitaze_input($this->input->post('id_objektif')) ?? "";
        $periode = $this->filter->sanitaze_input($this->input->post('periode')) ?? "";
        $cond = "";
        if ($id_objektif != "") {
            $cond = "WHERE id = '$id_objektif'";
        }
        return $this->db->query("SELECT mso.*, 
        tso.jml_o, 
        tso.ach_o, 
        IF(ROUND(tso.ach_o/tso.jml_o*100)>=100,100,0) AS persen 
        FROM m_strategi_objektif mso 
        LEFT JOIN (
        SELECT
            msi.objektif,
            COUNT(msi.id) AS jml_o,
            SUM(IF(tsi.ach_i >= tsi.jml_i,1,0)) AS ach_o
        FROM
            m_strategi_inisiatif msi
            LEFT JOIN (
            SELECT
                xi.inisiatif,
                xi.jml_i,
                xi.ach_i 
            FROM
                (
                SELECT
                    mst.inisiatif,
                    COUNT( mst.id ) AS jml_i,
                    SUM(
                    IF
                    ( xt.ach_k >= xt.jml_k, 1, 0 )) AS ach_i 
                FROM
                    m_strategi_task mst
                    LEFT JOIN (
                    SELECT
                        x.task,
                        COUNT( x.id ) AS jml_k,
                        SUM( x.ach ) AS ach_k 
                    FROM
                        (
                        SELECT
                            msk.task,
                            msk.id,
                            msk.target,
                            COALESCE ( tsk.actual, 0 ) AS actual,
                        IF
                            ( COALESCE ( tsk.actual, 0 )>= msk.target, 1, 0 ) AS ach 
                        FROM
                            m_strategi_ketercapaian msk
                            LEFT JOIN (
                            SELECT
                                s.ketercapaian,
                                SUM( s.actual ) AS actual 
                            FROM
                                t_strategi_actual s
                                LEFT JOIN xin_employees e ON e.user_id = s.created_by 
                            WHERE
                                SUBSTR( s.created_at, 1, 7 ) = '$periode' 
                                AND s.created_by = '$user_id' 
                            GROUP BY
                                s.ketercapaian 
                            ) AS tsk ON tsk.ketercapaian = msk.id 
                        ) AS x 
                    GROUP BY
                        x.task 
                    ) AS xt ON xt.task = mst.id 
                GROUP BY
                    mst.inisiatif 
                ) AS xi 
            ) AS tsi ON tsi.inisiatif = msi.id
            GROUP BY msi.objektif
            ) AS tso ON tso.objektif = mso.id $cond ORDER BY strategi")->result();
    }

    function get_strategi_inisiatif()
    {
        $user_id = $this->filter->sanitaze_input($this->input->post('user_id')) ?? "";
        $id_objektif = $this->filter->sanitaze_input($this->input->post('id_objektif')) ?? "";
        $periode = $this->filter->sanitaze_input($this->input->post('periode')) ?? "";
        $cond = "";
        if ($id_objektif != "") {
            $cond = "WHERE objektif = '$id_objektif'";
        }
        return $this->db->query("SELECT
        i.id,
        i.inisiatif,
        a.task,
        a.actual,
        IF(ROUND(a.actual/a.task*100)>=100,100,ROUND(a.actual/a.task*100)) AS persen
    FROM
        `m_strategi_inisiatif` i
        LEFT JOIN (
        SELECT
            t.inisiatif,
            COUNT( t.id ) AS task,
        IF
            ( a.actual >= a.target, 1, 0 ) AS actual 
        FROM
            `m_strategi_task` t
            LEFT JOIN (
            SELECT
                m.task,
                COUNT( m.id ) AS target,
                SUM(
                IF
                ( COALESCE ( a.actual, 0 ) >= m.target, 1, 0 )) AS actual 
            FROM
                `m_strategi_ketercapaian` m
                LEFT JOIN (
                SELECT
                    s.`week`,
                    s.periode,
                    s.created_at,
                    s.created_by,
                    s.ketercapaian,
                    SUM( s.actual ) AS actual 
                FROM
                    t_strategi_actual s
                    LEFT JOIN xin_employees e ON e.user_id = s.created_by 
                WHERE
                    SUBSTR( s.created_at, 1, 7 ) = '$periode'
                    AND s.created_by = '$user_id' 
                GROUP BY
                    s.ketercapaian 
                ) a ON a.ketercapaian = m.id 
            GROUP BY
                m.task 
            ) AS a ON t.id = a.task 
        GROUP BY
        t.inisiatif 
        ) AS a ON a.inisiatif = i.id
        $cond")->result();
    }

    function get_strategi_task()
    {
        $user_id = $this->filter->sanitaze_input($this->input->post('user_id')) ?? "";
        $id_inisiatif = $this->filter->sanitaze_input($this->input->post('id_inisiatif')) ?? "";
        $periode = $this->filter->sanitaze_input($this->input->post('periode')) ?? "";
        $cond = "";
        if ($id_inisiatif != "") {
            $cond = "WHERE inisiatif = '$id_inisiatif'";
        }
        return $this->db->query("SELECT
            t.id,
            t.task,
            a.target,
            a.actual,
            ROUND(a.actual/a.target*100) AS persen
        FROM
            `m_strategi_task` t
            LEFT JOIN (
            SELECT
                m.task,
                COUNT( m.id ) AS target,
                SUM(
                IF
                ( COALESCE ( a.actual, 0 ) >= m.target, 1, 0 )) AS actual 
            FROM
                `m_strategi_ketercapaian` m
                LEFT JOIN (
                SELECT
                    s.`week`,
                    s.periode,
                    s.created_at,
                    s.created_by,
                    s.ketercapaian,
                    SUM( s.actual ) AS actual 
                FROM
                    t_strategi_actual s
                    LEFT JOIN xin_employees e ON e.user_id = s.created_by 
                WHERE
                    SUBSTR( s.created_at, 1, 7 ) = '$periode'
                    AND s.created_by = $user_id 
                GROUP BY
                    s.ketercapaian 
                ) a ON a.ketercapaian = m.id 
            GROUP BY
            m.task 
            ) AS a ON t.id = a.task 
            $cond")->result();
    }

    function get_strategi_ketercapaian()
    {
        $user_id = $this->filter->sanitaze_input($this->input->post('user_id'));
        $id_task = $this->filter->sanitaze_input($this->input->post('id_task'));
        $periode = $this->filter->sanitaze_input($this->input->post('periode'));
        $cond = "";
        if ($id_task != "") {
            $cond = "WHERE task = '$id_task'";
        }
        return $this->db->query("SELECT
            m.id,
            m.ketercapaian,
            m.`target`,
            COALESCE ( a.actual, 0 ) AS actual,
            IF(COALESCE ( a.actual, 0 ) >= m.target,1,0) AS tercapai,
            IF(ROUND(COALESCE ( a.actual, 0 )/m.`target`*100) >= 100, 100, ROUND(COALESCE ( a.actual, 0 )/m.`target`*100)) AS persen
        FROM
            `m_strategi_ketercapaian` m
            LEFT JOIN (
            SELECT
                s.`week`,
                s.periode,
                s.created_at,
                s.created_by,
                s.ketercapaian,
                SUM( s.actual ) AS actual 
            FROM
                t_strategi_actual s
                LEFT JOIN xin_employees e ON e.user_id = s.created_by 
            WHERE
                SUBSTR( s.created_at, 1, 7 ) = '$periode'
                AND s.created_by = $user_id 
            GROUP BY
            s.ketercapaian 
            ) a ON a.ketercapaian = m.id $cond")->result();
    }

    function get_detail_ketercapaian()
    {
        $id_ketercapaian = $this->filter->sanitaze_input($this->input->post('id_ketercapaian'));
        $cond = "";
        if ($id_ketercapaian != "") {
            $cond = "WHERE id = '$id_ketercapaian'";
        }
        return $this->db->query("SELECT id, ketercapaian, `target` FROM `m_strategi_ketercapaian` $cond")->result();
    }

    function get_week()
    {
        $sql = "SELECT week FROM rsp_project_live.`m_target_week_hr` w WHERE CURRENT_DATE BETWEEN w.`start` AND w.`end`";
        $data = $this->db->query($sql)->row();
        return $data->week;
    }

    function dt_sosi()
    {
        $user_id = $this->session->userdata('user_id');
        $start = $this->filter->sanitaze_input($this->input->post('start'));
        $end = $this->filter->sanitaze_input($this->input->post('end'));
        $sql = "SELECT
            s.no_act,
            o.id AS id_objektif,
            o.objektif,
            i.id AS id_inisiatif,
            i.inisiatif,
            t.id AS id_task,
            t.task,
            k.id AS id_ketercapaian,
            k.ketercapaian,
            k.target,
            s.actual,
            s.`status`,
            s.resume,
            COALESCE(s.file,'') AS `file`,
            s.link,
            DATE(s.created_at) AS created_at,
            s.created_by,
            CONCAT(e.first_name, ' ',e.last_name) AS employee_name,
            s.periode,
            s.`week`
        FROM
            t_strategi_actual s
            LEFT JOIN  m_strategi_ketercapaian k ON k.id = s.ketercapaian
            LEFT JOIN m_strategi_task t ON t.id = k.task
            LEFT JOIN m_strategi_inisiatif i ON i.id = t.inisiatif
            LEFT JOIN m_strategi_objektif o ON o.id = i.objektif
            LEFT JOIN xin_employees e ON e.user_id = s.created_by
        WHERE DATE(s.created_at) BETWEEN '$start' AND '$end'
        AND s.created_by = $user_id";
        return $this->db->query($sql)->result();
    }


    function dt_detail_ketercapaian()
    {
        $user_id = $this->session->userdata('user_id');
        $id_ketercapaian = $this->filter->sanitaze_input($this->input->post('id_ketercapaian'));
        $sql = "SELECT
            s.no_act,
            o.id AS id_objektif,
            o.objektif,
            i.id AS id_inisiatif,
            i.inisiatif,
            t.id AS id_task,
            t.task,
            k.id AS id_ketercapaian,
            k.ketercapaian,
            k.target,
            s.actual,
            s.`status`,
            s.resume,
            COALESCE(s.file,'') AS `file`,
            s.link,
            DATE(s.created_at) AS created_at,
            s.created_by,
            CONCAT(e.first_name, ' ',e.last_name) AS employee_name,
            s.periode,
            s.`week`
        FROM
            t_strategi_actual s
            LEFT JOIN  m_strategi_ketercapaian k ON k.id = s.ketercapaian
            LEFT JOIN m_strategi_task t ON t.id = k.task
            LEFT JOIN m_strategi_inisiatif i ON i.id = t.inisiatif
            LEFT JOIN m_strategi_objektif o ON o.id = i.objektif
            LEFT JOIN xin_employees e ON e.user_id = s.created_by
        WHERE SUBSTR(s.created_at,1,7) = SUBSTR(CURRENT_DATE,1,7)
        AND s.created_by = $user_id AND s.ketercapaian = '$id_ketercapaian'";
        return $this->db->query($sql)->result();
    }
}
