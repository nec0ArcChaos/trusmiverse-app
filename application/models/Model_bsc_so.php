<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_bsc_so extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('Filter');
        $this->load->database();
    }

    function get_strategi_perspektif()
    {

        return $this->db->query("SELECT a.id, a.perspective, a.sub, a.category, a.target,
         a.actual, a.periode, a.target - a.actual AS deviasi, ROUND((a.actual / a.target) * 100) AS persentase,
        a.tipe, a.spend
        FROM bsc_m a 
        ");
    }

    function get_dt_goal($periode)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        return $this->db->query("SELECT a.id, a.company_id,  a.perspective, a.sub, a.category, a.target,
         COALESCE(a.actual, 0) AS actual, a.periode, COALESCE(a.target - a.actual,0) AS deviasi, COALESCE(ROUND((a.actual / a.target) * 100),0) AS persentase,
        a.tipe, a.spend, a.updated_at, CONCAT(b.first_name, ' ', b.last_name) as employee_name,
        CASE WHEN a.spend = 'under' AND COALESCE(ROUND((a.actual / a.target) * 100),0) > 100 THEN 'danger'
        WHEN a.spend = 'under' AND COALESCE(ROUND((a.actual / a.target) * 100),0) BETWEEN 0 AND 100 THEN 'success'
        WHEN a.spend = 'under' AND COALESCE(ROUND((a.actual / a.target) * 100),0) < 0 THEN 'success'
        WHEN a.spend = 'over' AND COALESCE(ROUND((a.actual / a.target) * 100),0) >= 75 THEN 'success'
        WHEN a.spend = 'over' AND COALESCE(ROUND((a.actual / a.target) * 100),0) < 75 THEN 'danger'
        ELSE 'warning'
        END AS persen_panah,
        a.department,
        cm.name AS company, a.pm, a.project, a.created_at,
                CONCAT(e.first_name, ' ',e.last_name) AS employee_name

        FROM bsc_m a 
        LEFT JOIN xin_employees b ON b.user_id = a.updated_by
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
                LEFT JOIN xin_employees e ON e.user_id = a.created_by
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND project = '' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND project = '' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND project = '' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) c ON c.department = a.department AND c.company_id = a.company_id
        WHERE a.periode = '$periode' AND a.datas != 'actual' AND c.tipe_bsc IS NOT NULL
        ");
    }

    function get_dt_goal_h($periode, $goal_id)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        if ($goal_id != null) {
            $kon = "AND a.id = '$goal_id'";
        } else {
            $kon = "";
        }
        return $this->db->query("SELECT a.id, a.perspective, a.sub, a.category, a.periode, a.target,
            a.actual, a.target - a.actual AS deviasi, ROUND((a.actual / a.target) * 100) AS persentase,
            c.actual AS actual_h,  c.target - c.actual AS deviasi_h, COALESCE(ROUND((c.actual / c.target) * 100),0) AS persentase_h, c.resume AS resume_h, c.lampiran AS lampiran_h, c.link AS link_h,
            a.tipe, a.spend, c.created_at, CONCAT(first_name, ' ', last_name) as employee_name,
            CASE WHEN a.spend = 'under' AND COALESCE(ROUND((c.actual / c.target) * 100),0) > 100 THEN 'danger'
            WHEN a.spend = 'under' AND COALESCE(ROUND((c.actual / c.target) * 100),0) BETWEEN 0 AND 100 THEN 'success'
            WHEN a.spend = 'under' AND COALESCE(ROUND((c.actual / c.target) * 100),0) < 0 THEN 'success'
            WHEN a.spend = 'over' AND COALESCE(ROUND((c.actual / c.target) * 100),0) >= 75 THEN 'success'
            WHEN a.spend = 'over' AND COALESCE(ROUND((c.actual / c.target) * 100),0) < 75 THEN 'danger'
            ELSE 'warning'
            END AS persen_panah,
            a.department,
            cm.name AS company
        FROM bsc_m a
        LEFT JOIN bsc_m_h c ON a.id = c.id
        LEFT JOIN xin_employees b ON b.user_id = c.created_by
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = a.department AND cc.company_id = a.company_id
        WHERE c.id IS NOT NULL AND a.periode = '$periode' $kon AND cc.tipe_bsc IS NOT NULL 
        ORDER BY c.created_at DESC
        ");
    }

    function get_dt_so($periode)
    {


        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        return $this->db->query("SELECT a.id, a.perspective, a.sub, COALESCE(a.category, '_') AS category,
        b.periode,
        b.id_so, COALESCE(b.strategy, '') AS strategy, COALESCE(b.target,0) AS target_so, COALESCE(b.actual, 0) AS actual_so, COALESCE(b.achieve,0) AS achieve_so,
        b.tipe AS tipe_so, b.spend AS spend_so, b.`status` AS status_so,  b.lampiran AS lampiran_so, b.link AS link_so, b.company_id AS company_id_so,
        CASE WHEN b.spend = 'under' AND b.achieve > 100 THEN 'danger'
        WHEN b.spend = 'under' AND b.achieve BETWEEN 0 AND 100 THEN 'success'
        WHEN b.spend = 'under' AND b.achieve < 0 THEN 'success'
        WHEN b.spend = 'over' AND b.achieve >= 75 THEN 'success'
        WHEN b.spend = 'over' AND b.achieve < 75 THEN 'danger'
        ELSE 'warning'
        END AS persen_panah,
        b.id_bsc AS department,
        cm.name AS company,
        b.created_at,
        CONCAT(e.first_name, ' ',e.last_name) AS employee_name
        
        FROM bsc_so b 
        LEFT JOIN bsc_m a ON (a.company_id = b.company_id AND a.category = b.category) AND a.periode = '$periode'
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN xin_employees e ON e.user_id = b.created_by
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = b.department AND cc.company_id = b.company_id
        WHERE b.category IS NOT NULL AND b.periode = '$periode' AND cc.tipe_bsc IS NOT NULL 
        ");
    }

    function get_dt_so_h($periode, $id_so)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        if ($id_so != null) {
            $kon = "AND b.id_so = '$id_so'";
        } else {
            $kon = "";
        }
        return $this->db->query("SELECT a.id, a.perspective, a.sub, a.category, 
            b.periode,
            b.id_so, b.strategy, b.target AS target_so, b.actual AS actual_so, b.achieve AS achieve_so,
            b.tipe AS tipe_so, b.spend AS spend_so, b.`status` AS status_so,  b.lampiran AS lampiran_so, b.link AS link_so, b.resume AS resume_so, 

            COALESCE(d.target,0) AS target_so_h, COALESCE(d.actual,0) AS actual_so_h, COALESCE(d.achieve,0) AS achieve_so_h,
            d.`status` AS status_so_h,  d.lampiran AS lampiran_so_h, d.link AS link_so_h, d.resume AS resume_so_h, d.created_at,
            CONCAT(first_name, ' ', last_name) as employee_name,
            CASE WHEN b.spend = 'under' AND d.achieve > 100 THEN 'danger'
            WHEN b.spend = 'under' AND d.achieve BETWEEN 0 AND 100 THEN 'success'
            WHEN b.spend = 'under' AND d.achieve < 0 THEN 'success'
            WHEN b.spend = 'over' AND d.achieve >= 75 THEN 'success'
            WHEN b.spend = 'over' AND d.achieve < 75 THEN 'danger'
            ELSE 'warning'
            END AS persen_panah,
            b.id_bsc AS department,
            cm.name AS company
        FROM bsc_m a 
        LEFT JOIN bsc_so b ON (a.company_id = b.company_id AND a.category = b.category)
        LEFT JOIN bsc_so_h d ON a.category = b.category AND b.id_so = d.id_so
        LEFT JOIN xin_employees c ON c.user_id = d.created_by
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'so' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = b.department AND cc.company_id = b.company_id
        WHERE d.id_so IS NOT NULL AND b.periode  = '$periode' $kon AND cc.tipe_bsc IS NOT NULL
        ORDER BY d.created_at DESC
        ");
    }

    function get_dt_si($periode)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        return $this->db->query("SELECT a.id, a.perspective, a.sub, a.category,
        b.periode,
        c.id_so, c.id_si, c.strategy, c.target AS target_si, c.actual AS actual_si, c.achieve AS achieve_si,
        c.tipe AS tipe_si, c.spend AS spend_si, c.`status` AS status_si,  c.lampiran AS lampiran_si, c.link AS link_si,
        CASE WHEN c.spend = 'under' AND c.achieve > 100 THEN 'danger'
						WHEN c.spend = 'under' AND c.achieve BETWEEN 0 AND 100 THEN 'success'
						WHEN c.spend = 'under' AND c.achieve < 0 THEN 'success'
						WHEN c.spend = 'over' AND c.achieve >= 75 THEN 'success'
						WHEN c.spend = 'over' AND c.achieve < 75 THEN 'danger'
						ELSE 'warning'
					 END AS persen_panah,
                     b.id_bsc AS department,
                     cm.name AS company,
        c.created_at,
        CONCAT(e.first_name, ' ',e.last_name) AS employee_name
        FROM bsc_m a 
        LEFT JOIN bsc_so b ON (a.company_id = b.company_id AND a.category = b.category AND a.periode = b.periode)
        LEFT JOIN bsc_si c ON a.category = c.category AND b.id_so = c.id_so
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN xin_employees e ON e.user_id = c.created_by

        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = b.department AND cc.company_id = b.company_id
        WHERE c.id_si IS NOT NULL AND c.periode = '$periode' AND cc.tipe_bsc IS NOT NULL
        ");
    }

    function get_dt_si_h($periode, $id_so, $id_si)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');

        if ($id_si != null) {
            $kon = "AND d.id_si = '$id_si'";
        } else {
            $kon = "";
        }
        return $this->db->query("SELECT a.id, a.perspective, a.sub, a.category, 
        b.periode,
        b.id_so, e.strategy, e.target AS target_so, e.actual AS actual_so, e.achieve AS achieve_so,
        e.tipe AS tipe_si, e.spend AS spend_si, b.`status` AS status_si,  b.lampiran AS lampiran_so, b.link AS link_so, b.resume AS resume_so, 

        d.target AS target_si_h, d.actual AS actual_si_h, d.achieve AS achieve_si_h,
        d.`status` AS status_si_h,  d.lampiran AS lampiran_si_h, d.link AS link_si_h, d.resume AS resume_si_h, d.created_at,
        CONCAT(first_name, ' ', last_name) as employee_name,
        b.id_bsc AS department,
        cm.name AS company
        FROM bsc_m a 
        LEFT JOIN bsc_so b ON (a.company_id = b.company_id AND a.category = b.category)
        LEFT JOIN bsc_si e ON a.category = e.category AND b.id_so = e.id_so
        LEFT JOIN bsc_si_h d ON a.category = d.category AND b.id_so = d.id_so AND e.id_si = d.id_si        LEFT JOIN xin_employees c ON c.user_id = d.created_by
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'si' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = b.department AND cc.company_id = b.company_id
        WHERE d.id_so IS NOT NULL AND b.periode  = '$periode' $kon AND cc.tipe_bsc IS NOT NULL
        ");
    }

    // ==============
    function get_strategi_sosi($periode, $tipe, $category, $id_so, $id_si)
    {
        // $start 	= date('Y-m-01');
        // $end 	= date('Y-m-t');

        if ($tipe == 1) {
            $kon = "COUNT(a.category) AS action, COUNT(a.id_so)  AS rowspan1";
            $kond = "WHERE a.category = '$category' GROUP BY a.id_so";
        } else if ($tipe == 2) {
            $kon = "COUNT(a.category) AS action, COUNT(b.id_so)  AS rowspan1";
            $kond = "WHERE a.category = '$category' AND b.id_so = '$id_so' GROUP BY a.id_so, b.id_si";
        }

        $query = " SELECT 
                    a.id_so, a.category, a.strategy, a.tipe, a.target, a.actual, a.`status`,
                    b.strategy AS strategy_si, b.tipe AS tipe_si, b.target AS target_si, b.actual AS actual_si,
                    b.`status` AS status_si, b.id_si,
                    -- COUNT(a.category) AS action, COUNT(a.id_so)  AS rowspa1
                    $kon
                    FROM bsc_so_bt a 
                    LEFT JOIN bsc_si_bt b ON a.category = b.category AND a.id_so = b.id_so
                    -- WHERE a.category = '$category' AND b.id_so = '$id_so'
                    -- GROUP BY a.id_so
                    $kond
				";

        return $this->db->query($query);
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

    function cek_aksess()
    {
    }


    function cek_akses($tipe_bsc, $company_id, $project)
    {
        $user_id = $this->session->userdata('user_id');
        $department_id = $this->session->userdata('department_id');
        $sql = "SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND company_id = 5 AND project = '' AND FIND_IN_SET($user_id,user_id)
                UNION ALL 
            SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND company_id = 5 AND project = '' AND FIND_IN_SET($department_id,department_id)";
        $result =  $this->db->query($sql);

        if ($result->num_rows() > 0) {
            // Ada hasil
            $hasil = "Ada data yang ditemukan.";
        } else {
            // Tidak ada hasil
            $hasil = "Tidak ada data yang ditemukan.";
        }

        return $hasil;
    }

    public function get_company()
    {
        $query = "SELECT
            xin_companies.company_id,
            xin_companies.`name` AS company 
        FROM
            xin_companies";

        return $this->db->query($query);
    }

    public function get_department($company_id)
    {
        $query = "SELECT 0 AS `value`, 'Pilih Department' AS `text` UNION SELECT department AS `value`, department AS `text` FROM bsc_m WHERE company_id =  $company_id  GROUP BY company_id, department";

        return $this->db->query($query);
    }

    function get_dt_master_goals($company, $department)
    {

        $user_id = $this->session->userdata('user_id');
        $company_id = $this->session->userdata('company_id');
        $department_id = $this->session->userdata('department_id');
        $designation_id = $this->session->userdata('designation_id');


        return $this->db->query("SELECT a.id, a.perspective, COALESCE(a.sub, '') AS sub, COALESCE(a.category, '') AS category, a.periode, a.target,a.bobot, COALESCE(a.company_id, '') AS company_id,
            a.actual, a.target - a.actual AS deviasi, ROUND((a.actual / a.target) * 100) AS persentase,
            COALESCE(a.pm, '') AS pm, COALESCE(a.project, '') project,
            a.tipe, a.spend, COALESCE(a.datas, '') AS datas,
            COALESCE(a.department, '') as department,
            COALESCE(cm.name, '') AS company
        FROM bsc_m a
        LEFT JOIN xin_companies cm ON cm.company_id = a.company_id
        LEFT JOIN (SELECT tipe_bsc, department, company_id FROM (
            SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($user_id,user_id)
        UNION ALL 
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($department_id ,department_id)
        UNION ALL
        SELECT * FROM bsc_access WHERE tipe_bsc = 'goal' AND FIND_IN_SET($designation_id ,designation_id)
        ) x GROUP BY id) cc ON cc.department = a.department AND cc.company_id = a.company_id
        WHERE a.company_id = $company AND a.department = '$department'
        AND cc.tipe_bsc IS NOT NULL 
        GROUP BY company_id, department, perspective, category, project, pm
        ORDER BY a.perspective DESC
        ");
    }
}
