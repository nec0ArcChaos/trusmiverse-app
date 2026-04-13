<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_timeline_project extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_status()
    {
        $query = "SELECT * FROM m_pekerjaan_status WHERE is_active = 1 ORDER BY urutan ASC";
        return $this->db->query($query)->result();
    }

    function get_department()
    {
        $query = "SELECT
                d.department_id,
                CONCAT( d.department_name, ' | ', c.`name` ) AS department_name
            FROM
                `xin_departments` d
                LEFT JOIN xin_companies c ON c.company_id = d.company_id
                LEFT JOIN m_pekerjaan m ON m.department_id = d.department_id 
            WHERE
                m.department_id IS NOT NULL 
            GROUP BY
                d.department_id 
            HAVING
                COUNT( d.department_id ) > 0 
            ORDER BY
                d.department_name";
        return $this->db->query($query)->result();
        
    }

    function generate_id_task()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( t_detail_pekerjaan.id_detail_pekerjaan, 3 ) ) AS kd_max 
        FROM
        t_detail_pekerjaan 
        WHERE
        SUBSTR( t_detail_pekerjaan.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'DPK' . date('ymd') . $kd;
    }
    public function req_id()
    {
        $prefix = 'R';
        $date = date('ymd');
        $this->db->where('DATE(created_at)', date('Y-m-d'));
        $this->db->from('t_detail_req');
        $total = $this->db->count_all_results();
        $count = $total + 1;
        $countFormatted = str_pad($count, 2, '0', STR_PAD_LEFT);
        $req_id = $prefix . $date . $countFormatted;
        return $req_id;
    }
    public function get_resume_pekerjaan_status($project, $year)
    {
        $query = "SELECT
                COUNT(id) AS jumlah,
                COUNT(IF(status = 1, 1, NULL)) AS waiting,
                ROUND(COUNT(IF(status = 1, 1, NULL)) / COUNT(id) * 100, 0) AS persen_waiting,
                COUNT(IF(status = 2, 1, NULL)) AS working_on,
                ROUND(COUNT(IF(status = 2, 1, NULL)) / COUNT(id) * 100, 0) AS persen_working_on,
                COUNT(IF(status = 3, 1, NULL)) AS done,
                ROUND(COUNT(IF(status = 3, 1, NULL)) / COUNT(id) * 100, 0) AS persen_done,
                COUNT(IF(status = 4, 1, NULL)) AS cancel,
                ROUND(COUNT(IF(status = 4, 1, NULL)) / COUNT(id) * 100, 0) AS persen_cancel,
                COUNT(IF(DATE(IFNULL(done_at, CURRENT_DATE)) <= DATE(end), 1, NULL)) AS ontime,
                ROUND(COUNT(IF(DATE(IFNULL(done_at, CURRENT_DATE)) <= DATE(end), 1, NULL)) / COUNT(id) * 100, 0) AS persen_ontime,
                COUNT(IF(DATE(IFNULL(done_at, CURRENT_DATE)) > DATE(end), 1, NULL)) AS late,
                ROUND(COUNT(IF(DATE(IFNULL(done_at, CURRENT_DATE)) > DATE(end), 1, NULL)) / COUNT(id) * 100, 0) AS persen_late,
                warna2
            FROM
                view_timeline_project 
            WHERE
                id_project = '$project'
                AND YEAR(created_at) = '$year'";
        return $this->db->query($query)->row_object();
    }
    public function get_resume_pekerjaan_progres($project, $year)
    {
        $query = "SELECT
                    department_id,
                    kode_dep,
                    department_name,
                    ROUND(AVG(actual),1) AS progres
                FROM
                    view_timeline_project 
                WHERE
                    id_project = '$project'
                    AND YEAR(created_at) = '$year'
                GROUP BY
                    department_id";
        return $this->db->query($query)->result();
    }
    public function get_resume_pekerjaan_leadtime($project, $year)
    {
        $query = "SELECT
                department_id,
                department_name,
                kode_dep,
                COUNT( CASE WHEN COALESCE ( done_at, CURDATE()) <= end THEN 1 ELSE NULL END ) AS ontime,
                COUNT( CASE WHEN COALESCE ( done_at, CURDATE()) > end THEN 1 ELSE NULL END ) AS late,
                ROUND( COUNT( CASE WHEN COALESCE ( done_at, CURDATE()) <= end THEN 1 ELSE NULL END ) * 100.0 / COUNT( id_detail_pekerjaan ), 0 ) AS persen_ontime,
                ROUND( COUNT( CASE WHEN COALESCE ( done_at, CURDATE()) > end THEN 1 ELSE NULL END ) * 100.0 / COUNT( id_detail_pekerjaan ), 0 ) AS persen_late 
            FROM
                view_timeline_project
                 WHERE
                    id_project = '$project'
                    AND YEAR(created_at) = '$year'
            GROUP BY
                department_id";
        return $this->db->query($query)->result();
    }

    public function get_resume_data_header($project, $year)
    {
        $query = "SELECT
                    pr.id_project,
                    pr.project,
                    booking.actual AS booking_actual,
                    booking.target AS booking_target,
                    booking.persen AS booking_persen,
                    booking.warna AS booking_warna, -- Warna untuk booking
                    akad.actual AS akad_actual,
                    akad.target AS akad_target,
                    akad.persen AS akad_persen,
                    akad.warna AS akad_warna -- Warna untuk akad
                FROM
                    rsp_project_live.m_project pr
                LEFT JOIN (
                    SELECT
                        t_gci.id_project,
                        COUNT(DISTINCT t_gci.id_gci) AS actual, 
                        COALESCE(SUM(DISTINCT tr.target), 0) AS target,
                        ROUND(CASE 
                            WHEN COALESCE(SUM(DISTINCT tr.target), 0) > 0 THEN 
                                ROUND((COUNT(DISTINCT t_gci.id_gci) / SUM(DISTINCT tr.target)) * 100, 2)
                            ELSE 0 
                        END, 1) AS persen, -- Perhitungan persentase booking
                        CASE 
                            WHEN ROUND((COUNT(DISTINCT t_gci.id_gci) / COALESCE(SUM(DISTINCT tr.target), 1)) * 100, 2) < 60 THEN 'red'
                            WHEN ROUND((COUNT(DISTINCT t_gci.id_gci) / COALESCE(SUM(DISTINCT tr.target), 1)) * 100, 2) BETWEEN 60 AND 75 THEN 'yellow'
                            ELSE 'green'
                        END AS warna -- Kondisi warna untuk booking
                    FROM
                        rsp_project_live.t_gci t_gci
                    LEFT JOIN (
                        SELECT 
                            project, 
                            SUM(target) AS target 
                        FROM 
                            rsp_project_live.m_target_project_mm
                        WHERE 
                            SUBSTR(periode, 1, 4) = SUBSTR('2024-11',1,4)
                        GROUP BY 
                            project
                    ) tr ON tr.project = t_gci.id_project
                    WHERE
                        t_gci.id_kategori IN (3, 4, 5)
                        AND DATE(t_gci.created_at) BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01') 
                        AND LAST_DAY(CONCAT('2024-11', '-01'))
                        AND t_gci.id_project != 30
                        AND t_gci.manager IS NOT NULL
                    GROUP BY
                        t_gci.id_project
                ) booking ON booking.id_project = pr.id_project
                LEFT JOIN (
                    SELECT
                        a.id_project,
                        COUNT(DISTINCT a.id_akad) AS actual,
                        COALESCE(SUM(DISTINCT tr.target), 0) AS target,
                        ROUND(CASE 
                            WHEN COALESCE(SUM(DISTINCT tr.target), 0) > 0 THEN 
                                ROUND((COUNT(DISTINCT a.id_akad) / SUM(DISTINCT tr.target)) * 100, 2)
                            ELSE 0 
                        END, 1) AS persen, -- Perhitungan persentase akad
                        CASE 
                            WHEN ROUND((COUNT(DISTINCT a.id_akad) / COALESCE(SUM(DISTINCT tr.target), 1)) * 100, 2) < 60 THEN 'red'
                            WHEN ROUND((COUNT(DISTINCT a.id_akad) / COALESCE(SUM(DISTINCT tr.target), 1)) * 100, 2) BETWEEN 60 AND 75 THEN 'yellow'
                            ELSE 'green'
                        END AS warna -- Kondisi warna untuk akad
                    FROM
                        rsp_project_live.t_akad a
                    LEFT JOIN (
                        SELECT 
                            id_project,
                            SUM(target_akad) AS target
                        FROM
                            rsp_project_live.dash_ceo_target_booking_akad
                        WHERE SUBSTR(periode,1,4) = SUBSTR('2024-11',1,4)
                        GROUP BY id_project
                    ) tr ON tr.id_project = a.id_project 
                    WHERE
                        DATE(a.jadwal_akad) BETWEEN CONCAT(YEAR(CURDATE()), '-01-01') 
                        AND LAST_DAY(CONCAT('2024-11', '-01'))
                        AND a.hasil_akad = 1
                    GROUP BY
                        a.id_project
                ) akad ON akad.id_project = pr.id_project
                WHERE
                    pr.id_project = '$project';";
        return $this->db->query($query)->row_object();
    }
    public function get_resume_data_all($project, $year)
    {
        $query = "SELECT
                COUNT( unit.id_project_unit ) AS jumlah,
                SUM(
                IF
                ( unit.ready = 2, 1, 0 )) AS ready,
                SUM(
                IF
                ( unit.ready = 1, 1, 0 )) AS sisa,
                COUNT( gc.id_gci ) AS ceklok,
                COUNT(sp3k.id_gci) AS sp3k,
                COUNT(inv.id_gci) AS bank
            FROM
                rsp_project_live.m_project_unit unit
                LEFT JOIN (
                SELECT
                    * 
                FROM
                    rsp_project_live.t_gci 
                WHERE
                    id_kategori = 2 
                    AND id_project != 30 
                    AND id_project IS NOT NULL 
                    AND blok <> '' 
                    AND id_kategori IS NOT NULL 
                    AND hasil_ceklok IS NULL 
                    AND id_project = '$project' 
                    AND YEAR ( t_gci.created_at ) = '$year' 
                GROUP BY
                    id_gci 
                ) gc ON gc.id_project = unit.id_project 
                AND gc.blok = unit.blok
                LEFT JOIN (
                SELECT
                    gc.id_gci,
                    gc.id_project,
                    gc.blok 
                FROM
                    rsp_project_live.t_interview
                    JOIN (
                    SELECT *
                    FROM rsp_project_live.t_gci
                    WHERE 
                    id_project != 30 
                    AND id_project IS NOT NULL 
                    AND blok <> '' 
                    AND id_project = '$project' 
                    AND YEAR ( t_gci.created_at ) = '$year' 
                GROUP BY
                    id_gci 
                    )
                    gc ON gc.id_gci = t_interview.id_gci 
                WHERE
                    hasil_int = 1
                ) sp3k ON sp3k.id_project = unit.id_project 
                AND sp3k.blok = unit.blok 
                LEFT JOIN (
                SELECT
                    gc.id_gci,
                    gc.id_project,
                    gc.blok 
                FROM
                    rsp_project_live.t_interview
                    JOIN (
                    SELECT *
                    FROM rsp_project_live.t_gci
                    WHERE 
                    id_project != 30 
                    AND id_project IS NOT NULL 
                    AND blok <> '' 
                    AND id_project = '$project' 
                    AND YEAR ( t_gci.created_at ) = '$year' 
                GROUP BY
                    id_gci 
                    ) gc ON gc.id_gci = t_interview.id_gci 
                WHERE
                    hasil_int = 0 
                ) inv ON inv.id_project = unit.id_project 
                AND inv.blok = unit.blok 
            WHERE
                unit.id_project = '$project'";
        return $this->db->query($query)->row_object();
    }

    public function get_detail_department($project, $year)
    {
        $query = "SELECT
            department_id,
            department_name,
            kode_dep,
            ROUND(AVG(actual),0) AS progres,
            CASE
                WHEN ROUND(AVG(actual), 0) < 60 THEN 'red'
                WHEN ROUND(AVG(actual), 0) BETWEEN 60 AND 75 THEN 'yellow'
                ELSE 'green'
            END AS warna
        FROM
            `view_timeline_project` 
        WHERE
            id_project = '$project'
            GROUP BY department_id";
        return $this->db->query($query)->result();
    }
    public function get_task_main($project, $year)
    {
        $query = "SELECT
                mp.id AS id,
                mp.id_pekerjaan,
                mp.pekerjaan,
                mp.department_id,
                dep.department_name,
                mp.designation_id,
                mp.created_at,
                mp.created_by,
                COALESCE(MIN(DATE(det.`start`)),'-') AS start,
                    COALESCE(MAX(DATE(det.`end`)),'-') AS end,
                ROUND(COALESCE(AVG(det.actual), 0),1) AS persen,
                CASE 
                    WHEN ROUND(COALESCE(AVG(det.actual), 0),1) < 60 THEN 'danger'
                    WHEN ROUND(COALESCE(AVG(det.actual), 0),1) BETWEEN 60 AND 75 THEN 'warning'
                    ELSE 'success'
                END AS warna 

            FROM
                `m_pekerjaan` mp
                JOIN xin_departments dep ON dep.department_id = mp.department_id
                LEFT JOIN m_sub_pekerjaan sub ON sub.id_pekerjaan = mp.id
                LEFT JOIN t_detail_pekerjaan det ON det.id_sub_pekerjaan = sub.id
                LEFT JOIN xin_employees emp ON emp.user_id = mp.created_by
            WHERE
                det.id_project = '$project'
                AND YEAR(mp.created_at) = '$year'
                GROUP BY mp.id
                ;";
        return $this->db->query($query)->result();
    }

    public function get_sub_task($project, $year)
    {
        $query = "SELECT
                    sub.id AS id,
                    sub.id_pekerjaan,
                    mp.pekerjaan,
                    dep.department_name,
                    sub.sub_pekerjaan,
                    mp.designation_id,
                    COALESCE(MIN(DATE(det.`start`)),'-') AS start,
                    COALESCE(MAX(DATE(det.`end`)),'-') AS end,
                    COALESCE(tt.jumlah, 0) AS teamtalk,
                    COALESCE(mom.jumlah, 0) AS meeting,
                    COALESCE(comp.jumlah, 0)AS complain,
                    COALESCE(gen.jumlah, 0) AS genba,
                    COALESCE(coac.jumlah, 0) AS conco,
                    COALESCE(ibr.jumlah, 0) AS ibr,
                    IF(COALESCE(mom.jumlah,0) > 0, 'primary','secondary') AS warna_meeting,
                    IF(COALESCE(tt.jumlah,0) > 0, 'primary','secondary') AS warna_teamtalk,
                    IF(COALESCE(comp.jumlah,0) > 0, 'primary','secondary') AS warna_complain,
                    IF(COALESCE(gen.jumlah,0) > 0, 'primary','secondary') AS warna_genba,
                    IF(COALESCE(coac.jumlah,0) > 0, 'primary','secondary') AS warna_conco,
                    IF(COALESCE(ibr.jumlah,0) > 0, 'primary','secondary') AS warna_ibr,
                    '0' AS training
                FROM
                    `m_pekerjaan` mp
                    JOIN xin_departments dep ON dep.department_id = mp.department_id
                    LEFT JOIN m_sub_pekerjaan sub ON sub.id_pekerjaan = mp.id
                    LEFT JOIN t_detail_pekerjaan det ON  det.id_sub_pekerjaan = sub.id
                    LEFT JOIN xin_employees emp ON emp.user_id = mp.created_by
                    LEFT JOIN (
                        SELECT 
                            chat.project, 
                            chat.pekerjaan , 
                            chat.sub_pekerjaan , 
                            chat.detail_pekerjaan,
                            COUNT(id_chat) AS jumlah
                        FROM rsp_project_live.t_chat_bm chat
                        LEFT JOIN hris.t_detail_pekerjaan det ON FIND_IN_SET(det.id,chat.detail_pekerjaan)
                        WHERE chat.project = '$project'
                            AND YEAR(chat.created_at) = '$year'
                            GROUP BY project, pekerjaan, sub_pekerjaan
                    ) tt ON tt.project = det.id_project 
                        AND tt.pekerjaan = sub.id_pekerjaan
                        AND tt.sub_pekerjaan = sub.id
                    LEFT JOIN (
                        SELECT 
                            mom_header.project, 
                            mom_header.pekerjaan, 
                            mom_header.sub_pekerjaan, 
                            mom_header.detail_pekerjaan,
                            COUNT(id_mom) AS jumlah
                        FROM mom_header
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,mom_header.detail_pekerjaan)
                        WHERE mom_header.project = '$project'
                            AND YEAR(mom_header.created_at) = '$year'
                            GROUP BY project, pekerjaan, sub_pekerjaan
                    ) mom ON mom.project = det.id_project 
                        AND mom.pekerjaan = sub.id_pekerjaan
                        AND mom.sub_pekerjaan = sub.id
                    LEFT JOIN (
                        SELECT 
                            cm_task.id_project, 
                            cm_task.id_pekerjaan, 
                            cm_task.id_sub_pekerjaan, 
                            cm_task.id_detail_pekerjaan,
                            COUNT(id_task) AS jumlah
                        FROM cm_task
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,cm_task.id_detail_pekerjaan)
                        WHERE cm_task.id_project = '$project'
                            AND YEAR(cm_task.created_at) = '$year'
                            GROUP BY id_project, id_pekerjaan, id_sub_pekerjaan
                    ) comp ON comp.id_project = det.id_project 
                        AND comp.id_pekerjaan = sub.id_pekerjaan
                        AND comp.id_sub_pekerjaan = sub.id
                    LEFT JOIN (
                        SELECT 
                            gemba.id_project, 
                            gemba.id_pekerjaan, 
                            gemba.id_sub_pekerjaan, 
                            gemba.id_detail_pekerjaan,
                            COUNT(id_gemba) AS jumlah
                        FROM gemba
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,gemba.id_detail_pekerjaan)
                        WHERE gemba.id_project = '$project'
                            AND YEAR(gemba.created_at) = '$year'
                            GROUP BY id_project, id_pekerjaan, id_sub_pekerjaan
                    ) gen ON gen.id_project = det.id_project 
                        AND gen.id_pekerjaan = sub.id_pekerjaan
                        AND gen.id_sub_pekerjaan = sub.id
                    LEFT JOIN (
                        SELECT 
                            coaching.id_project, 
                            coaching.id_pekerjaan, 
                            coaching.id_sub_pekerjaan, 
                            coaching.id_detail_pekerjaan,
                            COUNT(*) AS jumlah
                        FROM coaching
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,coaching.id_detail_pekerjaan)
                        WHERE coaching.id_project = '$project'
                            AND YEAR(coaching.created_at) = '$year'
                            GROUP BY id_project, id_pekerjaan, id_sub_pekerjaan
                    ) coac ON coac.id_project = det.id_project 
                        AND coac.id_pekerjaan = sub.id_pekerjaan
                        AND coac.id_sub_pekerjaan = sub.id
                    LEFT JOIN (
                        SELECT 
                            td_task.id_project, 
                            td_task.id_pekerjaan, 
                            td_task.id_sub_pekerjaan, 
                            COUNT(sub.id_task) AS jumlah
                        FROM td_task
                        JOIN td_sub_task sub ON td_task.id_task = sub.id_task
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,td_task.id_detail_pekerjaan)
                        WHERE td_task.id_project = '$project'
                            AND YEAR(td_task.created_at) = '$year'
                            GROUP BY id_project, id_pekerjaan, id_sub_pekerjaan
                    ) ibr ON ibr.id_project = det.id_project 
                        AND ibr.id_pekerjaan = sub.id_pekerjaan
                        AND ibr.id_sub_pekerjaan = sub.id
                WHERE
                    det.id_project = '$project'
                    AND YEAR(mp.created_at) = '$year'
                    GROUP BY sub.id
                    ;";
        return $this->db->query($query)->result();
    }
    public function get_detail_task($project, $year)
    {
        $query = "SELECT
                    det.id_sub_pekerjaan AS id,
                    mp.id AS id_pekerjaan,
                    mp.pekerjaan AS nama_pekerjaan,
                    sub.sub_pekerjaan AS nama_sub_pekerjaan,
                    sub.id AS id_sub_pekerjaan,
                    det.id_detail_pekerjaan,
                    det.id AS id_detail,
                    dep.department_name,
                    COALESCE(dep.kode,'-') AS kode,
                    det.detail,
                    det.id_project,
                    pr.project,
                    DATE(det.`start`) AS start,
                    DATE(det.`end`) AS end,
                    GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
                    COALESCE(det.evidence, '-') AS evidence,
                    det.`status`,
                    COALESCE(det.target, '-') AS target,
                    COALESCE(det.actual, '-') AS actual,
                    COALESCE(det.output, '-') AS output,
                    COALESCE(mom.jumlah, 0) AS meeting,
                    COALESCE(tt.jumlah, 0) AS teamtalk,
                    COALESCE(comp.jumlah, 0) AS complain,
                    COALESCE(gen.jumlah, 0) AS genba,
                    COALESCE(coac.jumlah, 0) AS conco,
                    COALESCE(ibr.jumlah, 0) AS ibr,
                    IF(COALESCE(mom.jumlah,0) > 0, 'primary','secondary') AS warna_meeting,
                    IF(COALESCE(tt.jumlah,0) > 0, 'primary','secondary') AS warna_teamtalk,
                    IF(COALESCE(comp.jumlah,0) > 0, 'primary','secondary') AS warna_complain,
                    IF(COALESCE(gen.jumlah,0) > 0, 'primary','secondary') AS warna_genba,
                    IF(COALESCE(coac.jumlah,0) > 0, 'primary','secondary') AS warna_conco,
                    IF(COALESCE(ibr.jumlah,0) > 0, 'primary','secondary') AS warna_ibr,
                    -- COALESCE(COUNT(mom.detail_pekerjaan), 0) AS meeting,
                    -- COALESCE(COUNT(tt.detail_pekerjaan), 0) AS teamtalk,
                    -- COALESCE(COUNT(comp.id_detail_pekerjaan), 0) AS complain,
                    -- COALESCE(COUNT(gen.id_detail_pekerjaan), 0) AS genba,
                    -- COALESCE(COUNT(coac.id_detail_pekerjaan), 0) AS conco,
                    -- COALESCE(COUNT(ibr.id_detail_pekerjaan), 0) AS ibr,
                    '0' AS training,
                    'secondary' AS warna_training,
                    COALESCE(LEFT(det.done_at, 10), '-') AS done_at,
                    st.nama AS nama_status,
                    st.warna,
                    CASE 
                        WHEN det.done_at IS NULL THEN DATEDIFF(det.`end`, CURDATE())
                        ELSE '-'
                    END AS leadtime
                FROM
                    t_detail_pekerjaan det
                    LEFT JOIN m_sub_pekerjaan sub ON sub.id = det.id_sub_pekerjaan
                    LEFT JOIN `m_pekerjaan` mp ON mp.id = sub.id_pekerjaan
                    LEFT JOIN rsp_project_live.m_project pr ON pr.id_project = det.id_project
                    LEFT JOIN xin_departments dep ON dep.department_id = mp.department_id
                    LEFT JOIN xin_employees emp ON emp.user_id = mp.created_by
                    LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id, det.pic)
                    LEFT JOIN m_pekerjaan_status st ON st.id = det.status
                    LEFT JOIN (
                        SELECT 
                            chat.project, 
                            chat.pekerjaan, 
                            chat.sub_pekerjaan, 
                            det.id,
                            COUNT(id_chat) AS jumlah
                        FROM rsp_project_live.t_chat_bm chat
                        JOIN hris.t_detail_pekerjaan det ON FIND_IN_SET(det.id,chat.detail_pekerjaan)
                        WHERE chat.project = '$project'
                            AND YEAR(chat.created_at) = '$year'
                        GROUP BY det.id
                    ) tt ON tt.project = det.id_project 
                        AND tt.pekerjaan = sub.id_pekerjaan
                        AND tt.sub_pekerjaan = sub.id
                        AND det.id = tt.id
                    LEFT JOIN (
                        SELECT 
                            mom_header.project, 
                            mom_header.pekerjaan, 
                            mom_header.sub_pekerjaan, 
                            det.id,
                            COUNT(id_mom) AS jumlah
                        FROM mom_header
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,mom_header.detail_pekerjaan)
                        WHERE mom_header.project = '$project'
                            AND YEAR(mom_header.created_at) = '$year'
                        GROUP BY det.id
                    ) mom ON mom.project = det.id_project 
                        AND mom.pekerjaan = sub.id_pekerjaan
                        AND mom.sub_pekerjaan = sub.id
                        AND det.id = mom.id
                    LEFT JOIN (
                        SELECT 
                            cm_task.id_project, 
                            cm_task.id_pekerjaan, 
                            cm_task.id_sub_pekerjaan, 
                            det.id,
                            COUNT(id_task) AS jumlah
                        FROM cm_task
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,cm_task.id_detail_pekerjaan)
                        WHERE cm_task.id_project = '$project'
                            AND YEAR(cm_task.created_at) = '$year'
                        GROUP BY det.id
                    ) comp ON comp.id_project = det.id_project 
                        AND comp.id_pekerjaan = sub.id_pekerjaan
                        AND comp.id_sub_pekerjaan = sub.id
                        AND det.id=comp.id
                    LEFT JOIN (
                        SELECT 
                            gemba.id_project, 
                            gemba.id_pekerjaan, 
                            gemba.id_sub_pekerjaan, 
                            det.id,
                            COUNT(id_gemba) AS jumlah
                        FROM gemba
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,gemba.id_detail_pekerjaan)
                        WHERE gemba.id_project = '$project'
                            AND YEAR(gemba.created_at) = '$year'
                        GROUP BY det.id
                    ) gen ON gen.id_project = det.id_project 
                        AND gen.id_pekerjaan = sub.id_pekerjaan
                        AND gen.id_sub_pekerjaan = sub.id
                        AND det.id=gen.id
                    LEFT JOIN (
                        SELECT 
                            coaching.id_project, 
                            coaching.id_pekerjaan, 
                            coaching.id_sub_pekerjaan, 
                            det.id,
                            COUNT(id_coaching) AS jumlah
                        FROM coaching
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,coaching.id_detail_pekerjaan)
                        WHERE coaching.id_project = '$project'
                            AND YEAR(coaching.created_at) = '$year'
                        GROUP BY det.id
                    ) coac ON coac.id_project = det.id_project 
                        AND coac.id_pekerjaan = sub.id_pekerjaan
                        AND coac.id_sub_pekerjaan = sub.id
                        AND det.id = coac.id
                    LEFT JOIN (
                        SELECT 
                            td_task.id_project, 
                            td_task.id_pekerjaan, 
                            td_task.id_sub_pekerjaan, 
                            det.id,
                            COUNT(sub.id_task) AS jumlah
                        FROM td_task
                        JOIN td_sub_task sub ON td_task.id_task = sub.id_task
                        JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,td_task.id_detail_pekerjaan)
                        WHERE td_task.id_project = '$project'
                            AND YEAR(td_task.created_at) = '$year'
                        GROUP BY det.id
                    ) ibr ON ibr.id_project = det.id_project 
                        AND ibr.id_pekerjaan = sub.id_pekerjaan
                        AND ibr.id_sub_pekerjaan = sub.id
                        AND det.id=ibr.id
                WHERE
                    det.id_project = '$project' 
                    AND YEAR(mp.created_at) = '$year'
                GROUP BY
                    det.id_detail_pekerjaan;
                ";
        return $this->db->query($query)->result();
    }
    public function get_header_detail($id_pekerjaan)
    {
        $query = "SELECT * 
        FROM view_timeline_project
        WHERE id_detail_pekerjaan = '$id_pekerjaan'
        GROUP BY id_detail_pekerjaan";
        return $this->db->query($query)->row_object();
    }
    public function get_pekerjaan_deadline($project, $year)
    {
        $query = "SELECT * , IF(DATEDIFF(end,CURDATE())<0,'Late',CONCAT('H-',DATEDIFF(end,CURDATE()))) AS deadline
        FROM view_timeline_project
				WHERE 
				(
        DATE(start) BETWEEN DATE_SUB(CURDATE(), INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY)
        AND DATE_ADD(CURDATE(), INTERVAL (7 - DAYOFWEEK(CURDATE())) DAY)
        OR
        DATE(end) BETWEEN DATE_SUB(CURDATE(), INTERVAL (DAYOFWEEK(CURDATE()) - 1) DAY)
        AND DATE_ADD(CURDATE(), INTERVAL (7 - DAYOFWEEK(CURDATE())) DAY)
    ) AND status <> 3
    AND id_project = '$project'
    AND YEAR(created_at) = '$year'
        GROUP BY id_detail_pekerjaan";
        return $this->db->query($query)->result();
    }
    public function get_pekerjaan_undone($project, $year)
    {
        $query = "SELECT * , IF(DATEDIFF(end,CURDATE())<0,'Late',CONCAT('H-',DATEDIFF(end,CURDATE()))) AS deadline
        FROM view_timeline_project
			WHERE status <> 3
            AND id_project = '$project'
            AND YEAR(created_at) = '$year'
        GROUP BY id_detail_pekerjaan";
        return $this->db->query($query)->result();
    }
    public function get_pekerjaan_dimulai($project, $year)
    {
        $query = "SELECT * , IF(DATEDIFF(end,CURDATE())<0,'Late',CONCAT('H-',DATEDIFF(end,CURDATE()))) AS deadline
        FROM view_timeline_project
			WHERE start >= CURDATE()
            AND status <> 3
            AND id_project = '$project'
            AND YEAR(created_at) = '$year'
        GROUP BY id_detail_pekerjaan";
        return $this->db->query($query)->result();
    }
    public function get_resume_activity($project, $year)
    {
        $query = "SELECT
                    det.id_project,
                    COALESCE(ibr.jumlah, 0) AS ibr_jumlah,
                    COALESCE(ibr.jln_berhasil, 0) AS ibr_jln_berhasil,
                    COALESCE(ibr.tdk_berhasil, 0) AS ibr_tdk_berhasil,
                    COALESCE(ibr.tdk_jalan, 0) AS ibr_tdk_jalan,
                    COALESCE(ibr.progres, 0) AS ibr_progres,
                    COALESCE(ibr.belum, 0) AS ibr_belum,
                    ROUND(COALESCE((ibr.jln_berhasil / NULLIF(ibr.jumlah, 0)) * 100, 0), 1) AS persen_jln_berhasil,
                    ROUND(COALESCE((ibr.tdk_berhasil / NULLIF(ibr.jumlah, 0)) * 100, 0), 1) AS persen_tdk_berhasil,
                    ROUND(COALESCE((ibr.tdk_jalan / NULLIF(ibr.jumlah, 0)) * 100, 0), 1) AS persen_tdk_jalan,
                    ROUND(COALESCE((ibr.progres / NULLIF(ibr.jumlah, 0)) * 100, 0), 1) AS persen_progres,
                    ROUND(COALESCE((ibr.belum / NULLIF(ibr.jumlah, 0)) * 100, 0), 1) AS persen_belum,
                    COALESCE(mom.jumlah, 0) AS mom_jumlah,
                    COALESCE(comp.jumlah, 0) AS comp_jumlah,
                    COALESCE(tt.jumlah, 0) AS tt_jumlah,
                    COALESCE(tt.rating, 0) AS tt_rating,
                    COALESCE(gen.jumlah, 0) AS gen_jumlah,
                    COALESCE(coac.jumlah, 0) AS coac_jumlah
                FROM
                    t_detail_pekerjaan det
                    LEFT JOIN m_sub_pekerjaan sub ON sub.id = det.id_sub_pekerjaan
                    LEFT JOIN `m_pekerjaan` mp ON mp.id = sub.id_pekerjaan
                LEFT JOIN (
                    SELECT 
                        COUNT(td_task.id_task) AS jumlah,
                        SUM(CASE WHEN sub.`status` = 1 THEN 1 ELSE 0 END) AS jln_berhasil,
                        SUM(CASE WHEN sub.`status` = 2 THEN 1 ELSE 0 END) AS tdk_berhasil,
                        SUM(CASE WHEN sub.`status` = 3 THEN 1 ELSE 0 END) AS tdk_jalan,
                        SUM(CASE WHEN sub.`status` = 4 THEN 1 ELSE 0 END) AS progres,
                        SUM( CASE WHEN sub.`status` IS NULL THEN 1 ELSE 0 END ) AS belum,
                        td_task.id_project
                    FROM td_task
                    JOIN td_sub_task sub ON td_task.id_task = sub.id_task
                    JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,td_task.id_detail_pekerjaan)
                    WHERE td_task.id_project = '$project'
                    AND YEAR(td_task.created_at) = '$year'
                    GROUP BY td_task.id_project
                ) ibr ON ibr.id_project = det.id_project
                LEFT JOIN (
                    SELECT 
                        COUNT(id_mom) AS jumlah,
                        mom_header.project
                    FROM mom_header
                    JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,mom_header.detail_pekerjaan)
                    WHERE mom_header.project = '$project'
                    AND YEAR(mom_header.created_at) = '$year'
                    GROUP BY mom_header.project
                ) mom ON mom.project = det.id_project
                LEFT JOIN (
                    SELECT 
                        COUNT(id_task) AS jumlah,
                        cm_task.id_project
                    FROM cm_task
                    JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,cm_task.id_detail_pekerjaan)
                    WHERE cm_task.id_project = '$project'
                    AND YEAR(cm_task.created_at) = '$year'
                    GROUP BY cm_task.id_project
                ) comp ON comp.id_project = det.id_project
                LEFT JOIN (
                    SELECT 
                        chat.pekerjaan,
                        chat.sub_pekerjaan,
                        COUNT(id_chat) AS jumlah,
                        ROUND(AVG(rate_pelayanan), 0) AS rating,
                        chat.project
                    FROM rsp_project_live.t_chat_bm chat
                    JOIN hris.t_detail_pekerjaan det ON FIND_IN_SET(det.id,chat.detail_pekerjaan)
                    WHERE chat.project = '$project'
                    AND YEAR(chat.created_at) = '$year'
                    GROUP BY chat.project
                ) tt ON tt.project = det.id_project

                LEFT JOIN (
                    SELECT 
                        COUNT(id_gemba) AS jumlah,
                        gemba.id_project
                    FROM gemba
                    JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,gemba.id_detail_pekerjaan)
                    WHERE gemba.id_project = '$project'
                    AND YEAR(gemba.created_at) = '$year'
                    GROUP BY gemba.id_project
                ) gen ON gen.id_project = det.id_project
                LEFT JOIN (
                    SELECT 
                        COUNT(id_coaching) AS jumlah,
                        coaching.id_project
                    FROM coaching
                    JOIN t_detail_pekerjaan det ON FIND_IN_SET(det.id,coaching.id_detail_pekerjaan)
                    WHERE coaching.id_project = '$project'
                    AND YEAR(coaching.created_at) = '$year'
                    GROUP BY coaching.id_project
                ) coac ON coac.id_project = det.id_project
                WHERE
                    det.id_project = '$project'
                GROUP BY det.id_project;
                ";
        return $this->db->query($query)->row_object();
    }
    public function get_detail_mom($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
	* 
FROM
	(
	SELECT
		mom.id_mom,
		md5( mom.id_mom ) AS id_link,
		mom.judul,
		mom.tempat,
		DATE_FORMAT( mom.tgl, '%d %b %y' ) AS tgl,
		CONCAT( SUBSTR( mom.start_time, 1, 5 ), ' - ', SUBSTR( mom.end_time, 1, 5 ) ) AS waktu,
		mom.agenda,
		mom.meeting,
		dep.department_name AS department,
		GROUP_CONCAT( COALESCE ( peserta.employee_name, '' ) ) AS peserta,
		GROUP_CONCAT(
		CASE
				
				WHEN peserta.profile_picture = '' 
				AND peserta.gender = 'Male' THEN
					'default_male.jpg' 
					WHEN peserta.profile_picture = '' 
					AND peserta.gender = 'Female' THEN
						'default_female.jpg' ELSE COALESCE ( peserta.profile_picture, 'default_male.jpg' ) 
					END 
					) AS pp_peserta,
					CONCAT( created.first_name, ' ', created.last_name ) AS created_by,
					created.username,
					created.user_id,
					created.department_id,
					created.company_id,
				CASE
						
						WHEN created.profile_picture = '' 
						AND created.gender = 'Male' THEN
							'default_male.jpg' 
							WHEN created.profile_picture = '' 
							AND created.gender = 'Female' THEN
								'default_female.jpg' ELSE created.profile_picture 
								END AS profile_picture,
							DATE_FORMAT( mom.created_at, '%d %b %y' ) AS created_at,
							mom.pembahasan,
							CONCAT(
								mom.peserta,
								',',
							GROUP_CONCAT( item.pic )) AS list_peserta_pic,
							CONCAT(
								GROUP_CONCAT( peserta.dep_id ),
								',',
							GROUP_CONCAT( item.dep_pic )) AS list_dep_pic,
							CONCAT(
								GROUP_CONCAT( peserta.comp_id ),
								',',
							GROUP_CONCAT( item.comp_pic )) AS list_comp_pic 
						FROM
							mom_header AS mom
							LEFT JOIN (
							SELECT
								item.id_mom,
								item.peserta,
								GROUP_CONCAT( item.pic ) AS pic,
								GROUP_CONCAT( item.dep_pic ) AS dep_pic,
								GROUP_CONCAT( item.comp_pic ) AS comp_pic 
							FROM
								(
								SELECT
									item.id_mom,
									mom.peserta,
									em.user_id AS pic,
									em.department_id AS dep_pic,
									em.company_id AS comp_pic 
								FROM
									mom_issue_item AS item
									JOIN mom_header AS mom ON mom.id_mom = item.id_mom
									LEFT JOIN xin_employees AS em ON FIND_IN_SET( em.user_id, item.pic )
									LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by 
								WHERE
									mom.closed = 1
							AND mom.tgl = '2024-12-02'
								GROUP BY
									item.id_mom,
									em.user_id 
								) AS item 
							GROUP BY
								item.id_mom 
							) AS item ON item.id_mom = mom.id_mom
							LEFT JOIN (
							SELECT
								user_id,
								CONCAT( first_name, ' ', last_name ) AS employee_name,
								contact_no,
								profile_picture,
								gender,
								department_id AS dep_id,
								company_id AS comp_id 
							FROM
								xin_employees 
							) AS peserta ON FIND_IN_SET( peserta.user_id, mom.peserta )
							LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by
							LEFT JOIN (
							SELECT
								mom.id_mom,
								xin_departments.department_id,
								GROUP_CONCAT( xin_departments.department_name ) AS department_name 
							FROM
								mom_header AS mom
								JOIN xin_departments ON FIND_IN_SET( xin_departments.department_id, mom.department )
								LEFT JOIN xin_employees AS created ON created.user_id = mom.created_by 
							WHERE
								mom.closed = 1
							AND YEAR(mom.tgl) = '$year'
							GROUP BY
								mom.id_mom 
							) AS dep ON dep.id_mom = mom.id_mom 
						WHERE
							mom.closed = 1
							AND mom.project='$id_project' AND mom.pekerjaan = '$id_pekerjaan' AND mom.sub_pekerjaan = '$id_sub' AND YEAR(mom.created_at) = '$year' AND FIND_IN_SET('$id_detail',mom.detail_pekerjaan)
						GROUP BY
						mom.id_mom 
	) AS final";
        return $this->db->query($query)->result();
    }
    public function get_detail_ibr($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
                t.created_by,
                DATE_FORMAT( t.created_at, '%d %b %y' ) AS tgl_dibuat,
                SUBSTR( t.created_at, 12, 5 ) AS jam_dibuat,
                em.username AS owner_username,
                CONCAT( em.first_name, ' ', em.last_name ) AS owner_name,
                em.profile_picture AS owner_photo,
                d.department_name AS owner_department,
                cmp.name AS owner_company,
                GROUP_CONCAT(
                DISTINCT CONCAT( ' ', e.first_name, ' ', e.last_name )) AS team_name,
                GROUP_CONCAT(
                DISTINCT
                CASE
                        
                        WHEN e.profile_picture IS NOT NULL 
                        AND e.profile_picture != '' 
                        AND e.profile_picture != 'no file' THEN
                            e.profile_picture ELSE
                        IF
                            ( e.gender = 'Male', 'default_male.jpg', 'default_female.jpg' ) 
                        END 
                        ) AS profile_picture_pic,
                        COUNT( e.user_id ) AS team_count,
                        t.id_task,
                        t.task,
                        t.indicator,
                        t.progress,
                        GROUP_CONCAT(
                        DISTINCT COALESCE ( st.sub_task, '' )) AS strategy,
                        COALESCE ( t.jenis_strategy, '' ) AS jenis_strategy,
                        COALESCE ( t.evaluation, '' ) AS evaluation,
                        COALESCE ( SUBSTR( t.start, 1, 10 ), '' ) AS `start`,
                    COALESCE ( SUBSTR( t.end, 1, 10 ), '' ) AS `end`,
                    COALESCE (
                    CASE
                            
                        WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN
                        CONCAT(
                            DATE_FORMAT( t.START, '%d' ),
                            '-',
                        DATE_FORMAT( t.END, '%d %b %y' )) 
                WHEN DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) 
                AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN
                CONCAT(
                    DATE_FORMAT( t.START, '%d %b' ),
                    ' - ',
                    DATE_FORMAT( t.END, '%d %b %y' )) ELSE CONCAT(
                    DATE_FORMAT( t.START, '%d %b %y' ),
                    ' - ',
                DATE_FORMAT( t.END, '%d %b %y' )) 
                END,
                '' 
                ) AS timeline,
                t.type AS id_type,
                ty.type,
                t.category AS id_category,
                c.category,
                t.object AS id_object,
                o.object,
                t.priority AS id_priority,
                p.priority,
                p.color AS priority_color,
                t.`status` AS id_status,
                s.`status`,
                s.`color` AS status_color,
                pic AS id_pic,
                DATE_FORMAT( t.due_date, '%d %b %y' ) AS due_date,
                TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ) AS due_diff,
            CASE
                    
                    WHEN TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ) > 0 THEN
                    CONCAT( TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ), ' days overdue' ) 
                    WHEN TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ) = 0 THEN
                    'Today' ELSE CONCAT( TIMESTAMPDIFF( DAY, CURRENT_DATE, t.due_date ), ' days left' ) 
                END AS due_date_text,
            CASE
                    
                    WHEN TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ) > 0 THEN
                    'bg-danger' 
                    WHEN TIMESTAMPDIFF( DAY, t.due_date, CURRENT_DATE ) = 0 THEN
                    'bg-warning' ELSE 'bg-primary' 
                END AS due_date_style 
            FROM
                `td_task` t
                LEFT JOIN td_sub_task st ON st.id_task = t.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                LEFT JOIN xin_employees em ON em.user_id = t.created_by
                LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                LEFT JOIN xin_departments d ON d.department_id = em.department_id
                LEFT JOIN td_type ty ON ty.id = t.type
                LEFT JOIN td_category c ON c.id = t.category
                LEFT JOIN td_object o ON o.id = t.object
                LEFT JOIN td_status s ON s.id = t.`status`
                LEFT JOIN td_priority p ON p.id = t.priority 
                WHERE t.id_project='$id_project' AND t.id_pekerjaan = '$id_pekerjaan' AND t.id_sub_pekerjaan = '$id_sub' AND YEAR(t.created_at) = '$year' AND FIND_IN_SET('$id_detail',t.id_detail_pekerjaan)
            GROUP BY
                st.id_sub_task 
            ORDER BY
                t.created_at DESC";
        return $this->db->query($query)->result();
    }
    public function get_detail_genba($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
                    gemba.id_gemba,
                    gemba.tgl_plan,
                    gemba.tipe_gemba AS id_gemba_tipe,
                    tp.tipe_gemba,
                    gemba.lokasi,
                    gemba.evaluasi,
                    gemba.peserta,
                    gemba.created_at,
                    CONCAT(em.first_name,' ',em.last_name) AS created_by,
                    gemba.updated_at,
                    CONCAT(up.first_name,' ',up.last_name) AS updated_by,
                    IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'Waiting Completed','Completed') AS `status`,
                    IF(item.total_progres > 0 OR gemba.evaluasi IS NULL,'warning','success') AS color,
                    sts.`status` AS status_akhir,
                    sts.`color` AS color_akhir
                FROM
                    gemba
                    JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                    JOIN gemba_tipe AS tp ON tp.id = gemba.tipe_gemba
                    LEFT JOIN xin_employees AS em ON em.user_id = gemba.created_by
                    LEFT JOIN xin_employees AS up ON up.user_id = gemba.updated_by
                    LEFT JOIN td_status_strategy AS sts ON sts.id = gemba.`status`
                WHERE gemba.id_project='$id_project' AND gemba.id_pekerjaan = '$id_pekerjaan' AND gemba.id_sub_pekerjaan = '$id_sub' AND YEAR(gemba.tgl_plan) = '$year' AND FIND_IN_SET('$id_detail',gemba.id_detail_pekerjaan)";
        return $this->db->query($query)->result();
    }
    public function get_detail_conco($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
                coaching.id_coaching,
                CONCAT(kary.first_name,' ',kary.last_name) AS karyawan,
                coaching.tempat,
                DATE_FORMAT(coaching.tanggal,'%d %b %Y') AS tanggal,
                CONCAT(atas.first_name,' ',atas.last_name) AS atasan,
                coaching.review,
                coaching.goals,
                coaching.reality,
                coaching.option,
                coaching.will,
                coaching.komitmen,
                COALESCE(coaching.foto,'') AS foto,
                coaching.company_id,
                comp.name AS company_name,
                coaching.department_id,
                dp.department_name,
                coaching.designation_id,
                dg.designation_name,
                coaching.role_id,
                role.role_name,
                coaching.created_at,
                CONCAT(usr.first_name,' ',usr.last_name) AS created_by
            FROM
                coaching 
                JOIN xin_employees AS kary ON kary.user_id = coaching.karyawan
                JOIN xin_employees AS atas ON atas.user_id = coaching.atasan
                JOIN xin_employees AS usr ON usr.user_id = coaching.created_by
                LEFT JOIN xin_companies AS comp ON comp.company_id = coaching.company_id
                LEFT JOIN xin_departments AS dp ON dp.department_id = coaching.department_id
                LEFT JOIN xin_designations AS dg ON dg.designation_id = coaching.designation_id
                LEFT JOIN xin_user_roles AS role ON role.role_id = coaching.role_id
            WHERE
                coaching.id_project='$id_project' AND coaching.id_pekerjaan = '$id_pekerjaan' AND coaching.id_sub_pekerjaan = '$id_sub' AND YEAR(coaching.created_at) = '$year' AND FIND_IN_SET('$id_detail',coaching.id_detail_pekerjaan)";
        return $this->db->query($query)->result();
    }

    public function get_detail_comp($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
                t.created_at,
                t.created_by,
                t.verified_by,
                t.project,
                t.blok,
                COALESCE(t.verified_at,'waiting') AS verified_at,
                t.verified_name,
                t.verified_note,
                t.description,
                t.escalation_by,
                t.escalation_name,
                COALESCE(t.done_date,'on process') AS solver_at,
                COALESCE(t.escalation_at,'waiting') AS escalation_at,
                DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS tgl_diproses,
                SUBSTR(t.created_at,12,5) AS jam_dibuat,
                em.username AS owner_username,
                CONCAT(em.first_name, ' ', em.last_name) AS owner_name,
                CASE WHEN em.profile_picture IS NOT NULL AND em.profile_picture != '' AND em.profile_picture != 'no file' THEN em.profile_picture ELSE IF(em.gender='Male','default_male.jpg','default_female.jpg')  END AS owner_photo,
                CASE WHEN vf.profile_picture IS NOT NULL AND vf.profile_picture != '' AND vf.profile_picture != 'no file' THEN vf.profile_picture ELSE IF(vf.gender='Male','default_male.jpg','default_female.jpg')  END AS verified_photo,
                CASE WHEN es.profile_picture IS NOT NULL AND es.profile_picture != '' AND es.profile_picture != 'no file' THEN es.profile_picture ELSE IF(es.gender='Male','default_male.jpg','default_female.jpg')  END AS escalation_photo,
                d.department_name AS owner_department,
                cmp.name AS owner_company,
                GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name)) AS team_name,
                GROUP_CONCAT(DISTINCT CASE WHEN e.profile_picture IS NOT NULL AND e.profile_picture != '' AND e.profile_picture != 'no file' THEN e.profile_picture ELSE IF(e.gender='Male','default_male.jpg','default_female.jpg')  END) AS profile_picture_pic,
                COUNT(e.user_id) AS team_count,
                t.id_task,
                t.task,
                t.progress,
                CASE WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > (60*24) THEN
                        CONCAT(TIMESTAMPDIFF( DAY, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' days')
                    WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 60 THEN
                        CONCAT(TIMESTAMPDIFF( HOUR, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' hour')
                    WHEN TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ) > 0 THEN
                        CONCAT(TIMESTAMPDIFF( MINUTE, t.created_at, COALESCE(t.`start`,CURRENT_TIME) ), ' minutes')
                    ELSE
                        ''
                END AS leadtime_process,
                CASE WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > (60*24) THEN
                        CONCAT(TIMESTAMPDIFF( DAY, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' days')
                    WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 60 THEN
                        CONCAT(TIMESTAMPDIFF( HOUR, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' hour')
                    WHEN TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ) > 0 THEN
                        CONCAT(TIMESTAMPDIFF( MINUTE, COALESCE(t.`start`,CURRENT_TIME), COALESCE(t.`done_date`,CURRENT_TIME) ), ' minutes')
                    ELSE
                        ''
                END AS leadtime_progress,
                COALESCE(t.evaluation,'') AS evaluation,
                COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                COALESCE(CASE WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.START, '%d' ), '-', DATE_FORMAT( t.END, '%d %b %y' ))
        WHEN  DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN CONCAT(DATE_FORMAT( t.START, '%d %b' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' ))
        ELSE CONCAT(DATE_FORMAT( t.START, '%d %b %y' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' )) END,'') AS timeline,
                t.id_category,
                c.category,
                COALESCE(t.priority,'') AS id_priority,
                COALESCE(p.priority,'') AS priority,
                p.color AS priority_color,
                t.`status` AS id_status,
                s.`status`,
                s.`color` AS status_color,
                COALESCE(pic,'') AS id_pic,
                COALESCE(DATE_FORMAT(t.due_date, '%d %b %y'),'') AS due_date,
                TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-danger' 
                WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-warning' 
                ELSE 'bg-primary' END AS due_date_style
            FROM
                `cm_task` t
                LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                LEFT JOIN xin_employees em ON em.user_id = t.created_by
                LEFT JOIN xin_employees vf ON vf.user_id = t.verified_by
                LEFT JOIN xin_employees es ON es.user_id = t.escalation_by
                LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                LEFT JOIN xin_departments d ON d.department_id = em.department_id
                LEFT JOIN cm_category c ON c.id = t.id_category
                LEFT JOIN cm_status s ON s.id = t.`status`
                LEFT JOIN cm_priority p ON p.id = t.priority
                WHERE
                t.id_project='$id_project' AND t.id_pekerjaan = '$id_pekerjaan' AND t.id_sub_pekerjaan = '$id_sub' AND YEAR(t.created_at) = '$year' AND FIND_IN_SET('$id_detail',t.id_detail_pekerjaan)
                GROUP BY t.id_task ORDER BY t.created_at DESC";
        return $this->db->query($query)->result();
    }

    public function get_detail_teamtalk($id, $id_detail, $id_sub, $id_pekerjaan, $id_project, $year)
    {
        $query = "SELECT
                id_chat,
                send_by,
                sd.employee_name AS sd,
                rv.employee_name AS rv,
                chat.rate_masalah,
                chat.rate_informasi,
                chat.rate_pelayanan,
                chat.created_at
            FROM
                rsp_project_live.t_chat_bm chat
                LEFT JOIN rsp_project_live.user sd ON sd.id_user = chat.send_by
                LEFT JOIN rsp_project_live.user rv ON rv.id_user = chat.receive_by
                WHERE
                chat.project='$id_project' AND chat.pekerjaan = '$id_pekerjaan' AND chat.sub_pekerjaan = '$id_sub' AND YEAR(chat.created_at) = '$year' AND FIND_IN_SET('$id_detail',chat.detail_pekerjaan)";
        return $this->db->query($query)->result();
    }


    public function get_history($id)
    {
        $query = "SELECT
                -- DATE(his.created_at) AS created_at,
                DATE_FORMAT(his.created_at,'%e %b') AS created_at,
                his.id_detail_pekerjaan,
                his.progress,
                his.`status`,
                his.status_before,
                his.note,
                st.nama AS st,
                st.warna AS st_warna,
                st_before.nama AS st_before,
                st_before.warna AS st_before_warna
            FROM
                `t_detail_pekerjaan_history` his
                JOIN m_pekerjaan_status st ON st.id = his.`status`
                JOIN m_pekerjaan_status st_before ON st_before.id = his.status_before
            WHERE his.id_detail_pekerjaan = '$id' 
            ORDER BY his.created_at DESC   
            ";
        return $this->db->query($query)->result();
    }
    public function get_file($id)
    {
        $query = "SELECT
                evidence
            FROM
                t_detail_pekerjaan 
            WHERE
                id_detail_pekerjaan = '$id'";
        return $this->db->query($query)->result();
    }
    public function get_request($id = null)
    {
        if ($id == null) {
            $kondisi = "";
        } else {
            $kondisi = "WHERE req.id_req = '$id'
    AND req.status = 1";
        }
        $query = "SELECT
	req.id AS id,
	req.id_req,
	req.id_detail,
	vw.project,
	vw.pekerjaan,
	vw.sub_pekerjaan,
	vw.detail,
	vw.`start`,
	vw.`end`,
	DATE_FORMAT(req.`start`,'%d-%m-%Y') AS req_start,
	DATE_FORMAT(req.`end`,'%d-%m-%Y') AS req_end,
	req.`start` AS req_start_2,
	req.`end` AS req_end_2,
	req.note AS note,
	CASE req.`status`
		WHEN 1 THEN 'Waiting'
		WHEN 2 THEN 'Approve'
		ELSE 'Reject'
	END AS sts,
    req.status,
	CONCAT(emp_req.first_name,' ',emp_req.last_name) AS request_to,
	emp_req.contact_no AS request_contact,
	CONCAT(emp_crt.first_name,' ',emp_crt.last_name) AS created_by,
	emp_crt.contact_no AS created_contact,
    req.created_at
FROM
	t_detail_req req
	LEFT JOIN view_timeline_project vw ON req.id_detail = vw.id_detail
	JOIN xin_employees emp_req ON FIND_IN_SET(emp_req.user_id, req.request_to) 
	JOIN xin_employees emp_crt ON emp_crt.user_id = req.created_by
	$kondisi
	";
        if ($id == null) {
            return $this->db->query($query)->result();
        }
        return $this->db->query($query)->row_object();
    }
    public function get_resume_head($project,$year){
        $query = "SELECT
                  stats_tt.*,
                  IF(id_user = 61,100,ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 )) AS achieve,
                CASE
                    WHEN id_user = 61 THEN 'Falcon'
                    WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 60 THEN 'Sloth' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 60 
                    AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 75 THEN 'Horse' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 75 
                      AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 90 THEN
                        'Cheetah' ELSE 'Falcon' 
                      END AS achieve_status,
                CASE
                    WHEN id_user = 61 THEN 'F'
                    WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 60 THEN 'S' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 60 
                    AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 75 THEN 'H' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 75 
                      AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 90 THEN
                        'C' ELSE 'F' 
                      END AS achieve_label, 
                CASE
                    WHEN id_user = 61 THEN '#0D6EFD'
                    WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 60 THEN '#FD97A4' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 60 
                    AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 75 THEN '#FFEC8F' WHEN ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) >= 75 
                      AND ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) < 90 THEN
                        '#C9EE8F' ELSE '#8DA9E3' 
                      END AS achieve_color
                    FROM
                      (
                      SELECT
                      leadtime.created_by as id_user,
											xe.user_id,
                        CONCAT(
                          TRIM( xe.first_name ),
                          ' ',
                        TRIM( xe.last_name )) AS employee_name,
                        -- xd.department_name,
                        xd.kode AS department_name,
                        xdg.designation_name,
                        ROUND( rating.avg_rating ) AS avg_rating,
                        IF(leadtime.created_by = 61,100,rating.avg_rating * 20) AS actual_rating,
                            CONCAT(
                  IF
                    ( xe.profile_picture IS NULL OR xe.profile_picture = '', 'https://trusmicorp.com/rspproject/assets/user/', 'https://trusmiverse.com/hr/uploads/profile/' ),
                  COALESCE ( IF(xe.profile_picture = '',NULL,xe.profile_picture), u.images )) AS employee_img,
                      CASE
                          WHEN leadtime.created_by = 61 THEN 100
                          WHEN leadtime.avg_leadtime < 3600 THEN 100 WHEN leadtime.avg_leadtime >= 3600 
                          AND leadtime.avg_leadtime < 10800 THEN 80 WHEN leadtime.avg_leadtime >= 10800 
                            AND leadtime.avg_leadtime < 86400 THEN
                              60 ELSE 40 
                            END AS actual_leadtime,
                            IF(leadtime.created_by = 61,'2 mnt',IF(leadtime.avg_leadtime < 3600,CONCAT( FLOOR( leadtime.avg_leadtime / 60 ), ' mnt'),CONCAT(FLOOR( leadtime.avg_leadtime / 3600 ), ' Hr'))) AS avg_leadtime,
                            leadtime.avg_leadtime as number_avg_leadtime,
                            IF(leadtime.created_by = 61,14,rating.jml_chat) as jml_chat,
                            COALESCE(mom.jumlah,0) AS mom,
                            COALESCE(comp.jumlah,0) AS comp,
                            COALESCE(ibr.jumlah,0) AS ibr,
                            COALESCE(gen.jumlah,0) AS gen,
                            COALESCE(coac.jumlah,0) AS coac,
                            IF(COALESCE(mom.jumlah,0)>0,'bg-primary','bg-secondary') AS warna_mom,
                            IF(COALESCE(comp.jumlah,0)>0,'bg-primary','bg-secondary') AS warna_comp,
                            IF(COALESCE(ibr.jumlah,0)>0,'bg-primary','bg-secondary') AS warna_ibr,
                            IF(COALESCE(gen.jumlah,0)>0,'bg-primary','bg-secondary') AS warna_gen,
                            IF(COALESCE(coac.jumlah,0)>0,'bg-primary','bg-secondary') AS warna_coac
                          FROM
                            (
                            SELECT
                              ROUND(
                                AVG(
                                TIMESTAMPDIFF( SECOND, item2.created_at, item1.created_at ))) AS avg_leadtime,
                              item1.created_by

                            FROM
                              ( SELECT * FROM rsp_project_live.t_chat_bm_item WHERE replay_for IS NOT NULL ) item1
                              JOIN rsp_project_live.t_chat_bm_item item2 ON FIND_IN_SET( item2.id, item1.replay_for ) 
                            WHERE
                              YEAR( item1.created_at) = '$year'
                            GROUP BY
                              created_by 
                            ORDER BY
                              created_by ASC 
                            ) leadtime
                            JOIN (
                            SELECT
                              ROUND( AVG(( COALESCE ( rate_masalah, 0 )+ COALESCE ( rate_informasi, 0 )+ COALESCE ( rate_pelayanan, 0 ))/ 3 ), 1 ) AS avg_rating,
                              COUNT(*) AS jml_chat,
                              receive_by,
                              project
                            FROM
                              rsp_project_live.t_chat_bm 
                            WHERE
                              status_chat = 1 
                              AND YEAR( created_at) = '$year' 
                            --   AND project = '$project' 

                              AND rate_masalah IS NOT NULL 
                            GROUP BY
                              receive_by 
                            ) rating ON leadtime.created_by = rating.receive_by
                            JOIN rsp_project_live.`user` `u` ON u.id_user = leadtime.created_by
                            JOIN hris.xin_employees xe ON xe.user_id = u.join_hr
                            JOIN hris.xin_departments xd ON xd.department_id = xe.department_id
                            JOIN hris.xin_designations xdg ON xdg.designation_id = xe.designation_id
                            LEFT JOIN (
                                SELECT 
                                project, 
                                id_mom, 
                                COUNT(id_mom) AS jumlah, 
                                peserta
                                FROM hris.mom_header 
                                WHERE project = '$project' AND YEAR(created_at) = '$year'
                                -- GROUP BY id_mom
                            ) mom ON FIND_IN_SET(xe.user_id,mom.peserta)
                            LEFT JOIN (
                                SELECT COUNT(id_task) AS jumlah,
                                id_project,
                                pic
                                FROM hris.cm_task
                                WHERE id_project = '$project' AND YEAR(created_at) = '$year'
                                -- GROUP BY id_task
                            ) comp ON FIND_IN_SET(xe.user_id,comp.pic)
                            LEFT JOIN (
                                SELECT 
                                COUNT(id_task) jumlah,
                                id_project,
                                pic
                                FROM hris.td_task
                                WHERE id_project = '$project' AND YEAR(created_at) = '$year'
                                -- GROUP BY id_task
                            ) ibr ON FIND_IN_SET(xe.user_id,ibr.pic)
                            LEFT JOIN (
                                SELECT
                                COUNT(id_gemba) AS jumlah,
                                id_project,
                                created_by
                                FROM hris.gemba gen
                                WHERE id_project = '$project' AND YEAR(created_at) = '$year'
                                -- GROUP BY id_gemba
                            ) gen ON gen.created_by = xe.user_id
                            LEFT JOIN (
                                SELECT 
                                COUNT(id_coaching) AS jumlah,
                                id_project,
                                atasan
                                FROM hris.coaching
                                WHERE id_project = '$project' AND YEAR(created_at) = '$year'
                                -- GROUP BY id_coaching
                            ) coac ON FIND_IN_SET(xe.user_id,coac.atasan)
        WHERE xe.user_role_id IN (2,3)

                            GROUP BY xe.user_id
                  ) stats_tt
                  ORDER BY ROUND(( actual_rating * 3 )/ 5 + ( actual_leadtime * 2 )/ 5 ) DESC, jml_chat DESC, number_avg_leadtime ASC;";
        return $this->db->query($query)->result();
    }
    
    public function resume_rekrut($periode,$company){
        $query = "SELECT
                    req.id,
                    req.permintaan_now AS permintaan,
                    skrg.pemenuhan_now AS pemenuhan,
                    ROUND(skrg.pemenuhan_now/req.permintaan_now*100) AS achieve,
                    CASE 
                    WHEN ROUND(skrg.pemenuhan_now/req.permintaan_now*100,2) < 60 THEN 'danger'
                    WHEN ROUND(skrg.pemenuhan_now/req.permintaan_now*100,2) BETWEEN 60 AND 75 THEN 'warning'
                    ELSE 'success'
                END AS warna
                FROM
                    (
                    SELECT
                        1 AS id,
                        SUM( jb.job_vacancy ) AS permintaan_now 
                    FROM
                        hris.xin_jobs AS jb
                        JOIN hris.xin_designations AS dg ON jb.designation_id = dg.designation_id
                        JOIN hris.xin_departments AS dp ON dg.department_id = dp.department_id
                        -- LEFT JOIN hris.trusmi_job_request jreq ON jreq.job_id = jb.reff_job_id
                    WHERE
                        '$periode' BETWEEN LEFT ( jb.created_at, 7 ) 
                        AND LEFT ( jb.date_of_closing, 7 ) 
                        AND jb.reff_job_id IS NOT NULL
                        AND jb.pic IS NOT NULL 
                        AND dp.department_id = 120
                        AND jb.position_id <> 8
                    ) AS req
                    
                    JOIN (
                    SELECT
                        1 AS id,
                        COUNT( jb.job_id ) AS pemenuhan_now
                    FROM
                        hris.xin_jobs AS jb
                        LEFT JOIN hris.xin_job_applications AS job ON job.job_id = jb.job_id
                        JOIN hris.xin_designations AS dg ON jb.designation_id = dg.designation_id
                        JOIN hris.xin_departments AS dp ON dg.department_id = dp.department_id 
                    WHERE
                        '$periode' BETWEEN LEFT ( jb.created_at, 7 ) 
                        AND LEFT ( jb.date_of_closing, 7 ) 
                        AND jb.reff_job_id IS NOT NULL 
                        AND job.application_status = 7 
                        AND LEFT ( job.created_at, 7 ) = '$periode'
                        AND dp.department_id = 120 
                        AND jb.position_id <> 8
                    ) AS skrg ON skrg.id = req.id
                    ";
        return $this->db->query($query)->row_object();
    }
    public function resume_training($periode,$company){
        $query = "SELECT
                COUNT( materi.jumlah ) AS jumlah,
                ROUND( AVG( nilai_pretest ), 1 ) AS pretest,
                ROUND( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )), 1 ) AS postest,
            CASE
                    
                    WHEN ROUND( AVG( nilai_pretest ), 1 ) < 60 THEN
                    'danger' 
                    WHEN ROUND( AVG( nilai_pretest ), 1 ) BETWEEN 60 
                    AND 75 THEN
                        'warning' ELSE 'success' 
                        END AS warna_pretest,
                CASE
                        
                        WHEN ROUND( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )), 1 ) < 60 THEN
                        'danger' 
                        WHEN ROUND( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )), 1 ) BETWEEN 60 
                        AND 75 THEN
                            'warning' ELSE 'success' 
                            END AS warna_postest,
                        ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 0 ) AS rasio,
                        CASE
                        
                        WHEN ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 2 ) < 60 THEN
                        'danger' 
                        WHEN ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 2 ) BETWEEN 60 
                        AND 75 THEN
                            'warning' ELSE 'success' 
                            END AS warna_rasio
                    FROM
                        trusmi_pretest 
                        
                        LEFT JOIN (
                            SELECT
                            id,
                            COUNT(id) AS jumlah
                            FROM
                            trusmi_materi_training
                            
                        ) materi ON materi.id = trusmi_pretest.id_training
                        

                    WHERE
                        id_training IS NOT NULL 
                        AND YEAR ( pretest_start ) = YEAR (
                        CURDATE()) 
                    ";
        return $this->db->query($query)->row_object();
    }

    public function resume_department(){
        $query = "SELECT
                    trusmi_pretest.id_test,
                    trusmi_pretest.id_training,
                    trusmi_pretest.employe_id,
                    emp.department_id,
                    dep.department_name,
                    dep.kode,
                    ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 0 ) AS rasio 
                FROM
                    trusmi_pretest
                    LEFT JOIN hris.xin_employees emp ON trusmi_pretest.employe_id = emp.user_id
                    JOIN hris.xin_departments dep ON emp.department_id = dep.department_id 
                WHERE
                    YEAR ( pretest_start ) = YEAR (
                    CURDATE()) 
                GROUP BY
                    emp.department_id 
                ORDER BY
                    ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 0 ) DESC 
                    LIMIT 2
                        ";
        return $this->db->query($query)->result();
    }

    public function table_footer_hr(){
        $query = "SELECT
                    trusmi_pretest.id_test,
                    trusmi_pretest.id_training,
                    materi.training,
                    trusmi_pretest.employe_id,
                    ROUND(AVG(GREATEST(trusmi_pretest.nilai_posttest, trusmi_pretest.nilai_posttest2, trusmi_pretest.nilai_posttest3))) AS actual,
                    lulus.lulus,
                    ROUND( AVG( nilai_pretest ), 1 ) AS pretest,
                    ROUND( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )), 1 ) AS postest,
                    ROUND( ( AVG( GREATEST( nilai_posttest, nilai_posttest2, nilai_posttest3 )) / NULLIF( AVG( nilai_pretest ), 0 )) * 100, 0 ) AS rasio
                FROM
                    trusmi_pretest
                    LEFT JOIN trusmi_materi_training materi ON materi.id = trusmi_pretest.id_training
                    LEFT JOIN (
                    SELECT 
                    trusmi_pretest.employe_id,
                    ROUND(COUNT(IF(GREATEST(trusmi_pretest.nilai_posttest, trusmi_pretest.nilai_posttest2, trusmi_pretest.nilai_posttest3) > 80, 1, 0)) / COUNT(*) * 100) AS lulus
                    FROM
                    trusmi_pretest
                    GROUP BY employe_id
                    ) lulus ON lulus.employe_id = trusmi_pretest.employe_id
                WHERE
                    YEAR ( pretest_start ) = YEAR (
                    CURDATE()) AND id_training IS NOT NULL
                GROUP BY
                    trusmi_pretest.id_training
                ORDER BY lulus.lulus
                    LIMIT 10";
        return $this->db->query($query)->result();
    }
}
