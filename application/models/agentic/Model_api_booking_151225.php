<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_api_booking extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function generate_kpi_id()
    {
        $prefix = 'AC' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.1_kpi_data');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_health_id()
    {
        $prefix = 'KH' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.2_kpi_health');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_system_analysis_id()
    {
        $prefix = 'SA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.3_system_analysis');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_governance_id()
    {
        $prefix = 'SA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.4_governance_check');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_4M_id()
    {
        $prefix = 'FM' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.5_four_m_analysis');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_action_plan_id()
    {
        $prefix = 'TL' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.6_timeline_tracking');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_rule_consequence_id()
    {
        $prefix = 'RC' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.7_rules_consequence');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_reward_id()
    {
        $prefix = 'RW' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.8_reward');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_tech_ccp_id()
    {
        $prefix = 'TA' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.9_tech_ccp_accountability');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_ringkasan_eks_id()
    {
        $prefix = 'EX' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.10_executive_summary');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_resiko_kritis_id()
    {
        $prefix = 'ER' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.11_executive_risks');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    public function generate_kpi_fokus_minggu_ini_id()
    {
        $prefix = 'EF' . date('ymd');
        $this->db->select('id');
        $this->db->from('agentic.12_executive_focus');
        $this->db->like('id', $prefix, 'after'); // Mencari id yang berawalan 'ACyymmdd'
        $this->db->order_by('id', 'DESC');
        $this->db->limit(1);

        $query = $this->db->get();
        $last_row = $query->row();
        if ($last_row) {
            $last_sequence = (int) substr($last_row->id, -4);
            $next_sequence = $last_sequence + 1;
        } else {
            $next_sequence = 1;
        }
        $formatted_sequence = sprintf('%04d', $next_sequence);
        $new_id = $prefix . $formatted_sequence;
        return $new_id;
    }

    function kpi_rm($id_gm, $periode)
    {

        $query = "SELECT
                    'Pemenuhan Booking' AS goal,
                    tgt.target AS target,
                    COUNT(gci.id_gci) AS actual,
                    100 AS target_persentase,
                    ROUND(COUNT(gci.id_gci) / tgt.target * 100) AS achieve_persentase
                FROM
                    rsp_project_live.t_gci AS gci
                LEFT JOIN rsp_project_live.`user` AS mkt ON mkt.id_user = gci.id_user
                LEFT JOIN
                    (
                        SELECT
                            periode,
                            SUM(target_booking) AS `target`,
                            SUM(book_1) AS book_1,
                            SUM(book_2) AS book_2,
                            SUM(book_3) AS book_3,
                            SUM(book_4) AS book_4,
                            SUM(book_5) AS book_5
                        FROM rsp_project_live.m_target_monthly_rm
                        WHERE periode = '$periode'
                        AND rsp_project_live.m_target_monthly_rm.id_rm = '$id_gm'
                    ) AS tgt ON '$periode' = tgt.periode
                WHERE gci.id_kategori = 3
                AND LEFT(gci.created_at, 7) = '$periode'
                AND gci.id_gm = '$id_gm'
                ";

        return $this->db->query($query)->row_array();

    }

    function get_rm($id_gm)
    {

        $query = "SELECT
                    u.id_user as id,
                    u.employee_name AS `name`
                FROM rsp_project_live.`user` u
                WHERE u.id_user = '$id_gm'
            ";

        return $this->db->query($query)->row_array();

    }

    function kpi_corporate($periode)
    {

        $query = "SELECT
                    'Pemenuhan Booking' AS goal,
                    tgt.target AS target,
                    COUNT(gci.id_gci) AS actual,
                    100 AS target_persentase,
                    ROUND(COUNT(gci.id_gci) / tgt.target * 100) AS achieve_persentase
                FROM
                    rsp_project_live.t_gci AS gci
                LEFT JOIN rsp_project_live.`user` AS mkt ON mkt.id_user = gci.id_user
                LEFT JOIN
                    (
                        SELECT
                            periode,
                            SUM(target_booking) AS `target`,
                            SUM(book_1) AS book_1,
                            SUM(book_2) AS book_2,
                            SUM(book_3) AS book_3,
                            SUM(book_4) AS book_4,
                            SUM(book_5) AS book_5
                        FROM rsp_project_live.m_target_monthly_rm
                        WHERE periode = '$periode'
                    ) AS tgt ON '$periode' = tgt.periode
                WHERE gci.id_kategori = 3
                AND LEFT(gci.created_at, 7) = '$periode'
            ";

        return $this->db->query($query)->row_array();

    }

    // function produktivitas_mpp($id_gm, $periode)
    // {

    //     $query = "SELECT
    //                 book.goal,
    //                 book.target,
    //                 COUNT(book.id_gci) AS actual,
    //                 book.target_persentase,
    //                 ROUND(COUNT(book.id_gci) / book.target * 100) AS achieve_persentase,
    //                 book.id_rm,
    //                 COUNT(book.mpp) AS total_sales
    //             FROM
    //                 (
    //                     SELECT
    //                         'Pemenuhan Booking' AS goal,
    //                         tgt.target AS target,
    //                         gci.id_gci,
    //                         100 AS target_persentase,
    //                         CASE
    //                             WHEN mkt.id_manager IN (838,2029) AND mkt.id_gm = 838 THEN 838
    //                             WHEN mkt.id_manager IN (19,24327,167,2003) AND mkt.id_gm = 18 THEN 18
    //                             WHEN mkt.id_manager IN (111) AND mkt.id_gm = 18 THEN 111
    //                             WHEN mkt.id_manager IN (106) AND mkt.id_gm = 18 THEN 106
    //                             WHEN mkt.id_manager IN (2029) AND mkt.id_gm = 24099 THEN 24099
    //                         END AS id_rm,
    //                         (mkt.id_user) AS mpp
    //                     FROM
    //                         rsp_project_live.t_gci AS gci
    //                     LEFT JOIN rsp_project_live.`user` AS mkt ON mkt.id_user = gci.id_user
    //                     LEFT JOIN
    //                         (
    //                             SELECT
    //                                 periode,
    //                                 id_rm,
    //                                 SUM(target_booking) AS `target`,
    //                                 COALESCE(SUM(book_1),0) AS book_1,
    //                                 COALESCE(SUM(book_2),0) AS book_2,
    //                                 COALESCE(SUM(book_3),0) AS book_3,
    //                                 COALESCE(SUM(book_4),0) AS book_4,
    //                                 COALESCE(SUM(book_5),0) AS book_5
    //                             FROM rsp_project_live.m_target_monthly_rm
    //                             WHERE periode = '$periode'
    //                             AND rsp_project_live.m_target_monthly_rm.id_rm = '$id_gm'
    //                         ) AS tgt ON '$periode' = tgt.periode
    //                     WHERE gci.id_kategori = 3
    //                     AND LEFT(gci.created_at, 7) = '$periode'
    //                 ) AS book
    //             WHERE book.id_rm = '$id_gm'
    //         ";

    //     return $this->db->query($query)->row_array();

    // }

    function produktivitas_mpp($id_gm, $periode)
    {

        $query = "SELECT 
                    rm.gm_fix AS id_gm,
                    rm.employee_name AS head,          
                    'Pemenuhan Booking' AS goal,
                    tgt.target AS `target`,
                    SUM(rm.booking) AS actual,
                    100 AS target_persen,
                    COUNT(rm.gm_fix) AS total_sales,
                    COUNT(IF(rm.booking > 0, 1, NULL)) AS sales_achieve,
                    COUNT(IF(rm.booking < 1, 1, NULL)) AS sales_not_achieve,
                    ROUND(COALESCE(SUM(rm.booking) / COUNT(IF(rm.booking > 0, 1, NULL)),0), 1) AS persen_produktivitas,
                    ROUND((COUNT(IF(rm.booking > 0, 1, NULL)) / COUNT(rm.gm_fix)) * 100) AS persen_sales_jual
                FROM
                    (
                        SELECT
                            mkt.join_hr,
                            mkt.id_user,
                            mkt.nama,
                            mkt.id_manager,
                            mkt.id_gm,
                            CASE
                                WHEN mkt.id_manager IN (838,2029) AND mkt.id_gm = 838 THEN 838
                                WHEN mkt.id_manager IN (19,24327,167,2003) AND mkt.id_gm = 18 THEN 18
                                WHEN mkt.id_manager IN (111) AND mkt.id_gm = 18 THEN 111
                                WHEN mkt.id_manager IN (106) AND mkt.id_gm = 18 THEN 106
                                WHEN mkt.id_manager IN (2029) AND mkt.id_gm = 24099 THEN 24099
                            END AS gm_fix,
                            `user`.employee_name,
                            mkt.booking
                        FROM
                            (
                                SELECT
                                    `user`.join_hr,
                                    `user`.id_user,
                                    `user`.employee_name AS nama,
                                    t_gci.manager AS id_manager,
                                    t_gci.id_gm,
                                    ds.designation_id,
                                    mng.username AS mng,
                                    gm.username AS gm,
                                    `user`.date_of_joining,
                                    COUNT(t_gci.id_gci) AS booking
                                FROM rsp_project_live.`user` AS `user`
                                LEFT JOIN hris.xin_employees ON hris.xin_employees.user_id = `user`.join_hr
                                LEFT JOIN hris.xin_designations ds ON hris.xin_employees.designation_id = ds.designation_id
                                LEFT JOIN rsp_project_live.`user` AS spv ON spv.id_user = COALESCE(`user`.spv, 0)
                                LEFT JOIN rsp_project_live.t_gci AS t_gci ON t_gci.id_user = `user`.id_user AND t_gci.id_kategori IN (3,4) AND LEFT(t_gci.created_at, 7) = '$periode'
                                LEFT JOIN rsp_project_live.`user` AS mng ON mng.id_user = t_gci.manager
                                LEFT JOIN rsp_project_live.`user` AS gm ON gm.id_user = t_gci.id_gm
                                WHERE `user`.id_user NOT IN (596, 485)
                                AND `user`.isActive = 1
                                GROUP BY t_gci.id_user, t_gci.id_gm
                            ) mkt
                        JOIN rsp_project_live.`user` AS `user` ON `user`.id_user = CASE
                            WHEN mkt.id_manager IN (838,2029) AND mkt.id_gm = 838 THEN 838
                            WHEN mkt.id_manager IN (19,24327,167,2003) AND mkt.id_gm = 18 THEN 18
                            WHEN mkt.id_manager IN (111) AND mkt.id_gm = 18 THEN 111
                            WHEN mkt.id_manager IN (106) AND mkt.id_gm = 18 THEN 106
                            WHEN mkt.id_manager IN (2029) AND mkt.id_gm = 24099 THEN 24099
                        END
                        ORDER BY mkt.gm ASC
                    ) AS rm
                LEFT JOIN
                    (
                        SELECT
                            periode,
                            id_rm,
                            SUM(target_booking) AS `target`,
                            COALESCE(SUM(book_1),0) AS book_1,
                            COALESCE(SUM(book_2),0) AS book_2,
                            COALESCE(SUM(book_3),0) AS book_3,
                            COALESCE(SUM(book_4),0) AS book_4,
                            COALESCE(SUM(book_5),0) AS book_5
                        FROM rsp_project_live.m_target_monthly_rm
                        WHERE periode = '$periode'
                        AND rsp_project_live.m_target_monthly_rm.id_rm = '$id_gm'
                    ) AS tgt ON '$periode' = tgt.periode
                WHERE rm.gm_fix = '$id_gm'
                GROUP BY rm.gm_fix
                ORDER BY rm.employee_name ASC
            ";

        return $this->db->query($query)->row_array();

    }

    function jumlah_mpp_per_spv($id_gm)
    {

        $query = "SELECT
                    SUM(mpp.mpp) AS total_sales,
                    COUNT(mpp.spv) AS total_spv,
                    MIN(mpp.mpp) AS spv_dengan_mpp_tersedikit,
                    MAX(mpp.mpp) AS spv_dengan_mpp_terbanyak,
                    ROUND(AVG(mpp.mpp)) AS rata_rata_tim_spv,
                    8 AS target_mpp_per_spv,
                    ROUND((ROUND(AVG(mpp.mpp))/8)*100) AS actual,
                    100 AS target
                FROM
                    (
                        SELECT
                            x.spv,
                            COUNT(x.mpp) AS mpp,
                            x.id_rm
                        FROM
                            (
                                SELECT
                                    usr.spv,
                                    (usr.id_user) AS mpp,
                                    CASE
                                        WHEN usr.id_manager IN (838,2029) AND usr.id_gm = 838 THEN 838
                                        WHEN usr.id_manager IN (19,24327,167,2003) AND usr.id_gm = 18 THEN 18
                                        WHEN usr.id_manager IN (111) AND usr.id_gm = 18 THEN 111
                                        WHEN usr.id_manager IN (106) AND usr.id_gm = 18 THEN 106
                                        WHEN usr.id_manager IN (2029) AND usr.id_gm = 24099 THEN 24099
                                    END AS id_rm
                                FROM rsp_project_live.`user` AS usr
                                WHERE usr.id_user != usr.spv
                                AND usr.isActive = 1
                                AND usr.id_divisi = 2
                            ) AS x
                        GROUP BY x.spv
                    ) AS mpp
                WHERE mpp.id_rm = '$id_gm'
                ";

        return $this->db->query($query)->row_array();

    }

    function nilai_training_sales($id_gm)
    {

        $query = "SELECT
                    COUNT(u.id_user) AS total_sales,
                    COUNT(IF(training.rata_nilai > 69, 1, NULL)) AS total_sales_lolos,
                    ROUND((COUNT(IF(training.rata_nilai > 69, 1, NULL))/COUNT(u.id_user))*100) AS achieve_lolos,
                    MIN(COALESCE(training.rata_nilai,0)) AS nilai_terendah_sales,
                    MAX(COALESCE(training.rata_nilai,0)) AS nilai_tertinggi_sales,
                    ROUND(AVG(COALESCE(training.rata_nilai,0))) AS rata_rata_nilai_sales,
                    ROUND((ROUND(AVG(COALESCE(training.rata_nilai,0)))/80)*100) AS actual_persen,
                    100 AS target_nilai
                FROM rsp_project_live.`user` u
                LEFT JOIN
                    (
                        SELECT
                            x.id_user,
                            x.id_gm,
                            x.rata_nilai
                        FROM
                            (
                                SELECT
                                    marketing.id_user,
                                    CASE
                                        WHEN marketing.id_manager IN (838,2029) AND marketing.id_gm = 838 THEN 838
                                        WHEN marketing.id_manager IN (19,24327,167,2003) AND marketing.id_gm = 18 THEN 18
                                        WHEN marketing.id_manager IN (111) AND marketing.id_gm = 18 THEN 111
                                        WHEN marketing.id_manager IN (106) AND marketing.id_gm = 18 THEN 106
                                        WHEN marketing.id_manager IN (2029) AND marketing.id_gm = 24099 THEN 24099
                                    END AS id_gm,
                                    ROUND(
                                            AVG(
                                                GREATEST(
                                                    COALESCE(p.nilai_posttest, 0),
                                                    COALESCE(p.nilai_posttest2, 0),
                                                    COALESCE(p.nilai_posttest3, 0)
                                                )
                                            )
                                        ) AS rata_nilai
                                FROM hris.xin_employees e
                                LEFT JOIN hris.trusmi_pretest p ON p.employe_id = e.user_id
                                AND p.id_training IN ( 13,1,5,265,22,33,159,17,162,161,184,230,179,239,167,208,274,363,342,'M25010601','M25010803','M25010804' )
                                JOIN rsp_project_live.`user` marketing ON marketing.id_hr = e.user_id
                                AND marketing.id_user <> marketing.spv
                                AND marketing.id_user <> marketing.id_manager
                                AND marketing.isActive = 1
                                WHERE e.department_id = 120
                                AND e.is_active = 1
                                AND e.user_role_id = 7
                                GROUP BY marketing.id_user
                            ) AS x
                        WHERE x.id_gm = '$id_gm'
                    ) AS training ON training.id_user = u.id_user
                WHERE training.id_gm = '$id_gm'
                AND u.isActive = 1
                AND u.id_user != u.spv
                AND u.id_divisi = 2
            ";

        return $this->db->query($query)->row_array();

    }

    function rasio_follow_up_database($id_gm, $periode)
    {

        $query = "SELECT
                    gci_fu.id_gm,
                    COUNT(gci_fu.id_gci) AS total_database,
                    COUNT(gci_fu.total_fu) AS total_fu,
                    gci_fu.persen_target,
                    ROUND((COUNT(gci_fu.total_fu) / COUNT(gci_fu.id_gci)) * 100) AS persen_achieve
                FROM
                    (
                        SELECT
                            IF(gfu.id_gci IS NOT NULL,1,NULL) AS total_fu,
                            gci.id_gci,
                            100 AS persen_target,
                            CASE
                                WHEN us.id_manager IN (838,2029) AND us.id_gm = 838 THEN 838
                                WHEN us.id_manager IN (19,24327,167,2003) AND us.id_gm = 18 THEN 18
                                WHEN us.id_manager IN (111) AND us.id_gm = 18 THEN 111
                                WHEN us.id_manager IN (106) AND us.id_gm = 18 THEN 106
                                WHEN us.id_manager IN (2029) AND us.id_gm = 24099 THEN 24099
                            END AS id_gm
                        FROM rsp_project_live.t_gci AS gci
                        LEFT JOIN rsp_project_live.t_gci_fu AS gfu ON gci.id_gci = gfu.id_gci
                        LEFT JOIN rsp_project_live.`user` AS us ON us.id_user = gci.id_user
                        WHERE gci.id_kategori NOT IN (2.1, 3.0)
                        AND LEFT(gci.created_at, 7) = '$periode'
                    ) AS gci_fu
                WHERE gci_fu.id_gm = '$id_gm'
                ";

        return $this->db->query($query)->row_array();

    }

    function rasio_hot_prospect_ke_leads($id_gm, $periode)
    {

        $query = "SELECT
                    COUNT(fu_mm.id_gci) AS total_hot_prospect,
                    COUNT(fu_mm.total_leads) AS total_leads,
                    ROUND( (COUNT(fu_mm.total_leads) / COUNT(fu_mm.id_gci)) * 100) persen_achieve,
                    100 AS persen_target
                FROM
                    (
                        SELECT
                            f_mm.id_gci,
                            IF(leads.id_gci IS NOT NULL,1,NULL) AS total_leads,
                            100 AS persen_target,
                            CASE
                                WHEN us.id_manager IN (838,2029) AND us.id_gm = 838 THEN 838
                                WHEN us.id_manager IN (19,24327,167,2003) AND us.id_gm = 18 THEN 18
                                WHEN us.id_manager IN (111) AND us.id_gm = 18 THEN 111
                                WHEN us.id_manager IN (106) AND us.id_gm = 18 THEN 106
                                WHEN us.id_manager IN (2029) AND us.id_gm = 24099 THEN 24099
                            END AS id_gm
                        FROM rsp_project_live.t_gci AS gci
                        JOIN rsp_project_live.t_follow_up_mm AS f_mm ON gci.id_gci = f_mm.id_gci
                        LEFT JOIN rsp_project_live.`user` AS us ON us.id_user = gci.id_user
                        LEFT JOIN rsp_project_live.t_gci_history AS leads ON leads.id_gci = f_mm.id_gci
                        AND leads.id_kategori IN (2.1)
                        WHERE gci.id_kategori NOT IN (2.1, 3.0)
                        AND LEFT(gci.created_at, 7) = '$periode'
                    ) AS fu_mm
                WHERE fu_mm.id_gm = '$id_gm'
                ";

        return $this->db->query($query)->row_array();

    }

    function rasio_leads_ke_booking($id_gm, $periode)
    {

        $query = "SELECT
                    COUNT(ghis.id_gci) AS total_leads,
                    COUNT(ghis.total_booking) AS total_booking,
                    ROUND( (COUNT(ghis.total_booking) / COUNT(ghis.id_gci)) * 100 ) AS persen_achieve,
                    ghis.persen_target
                FROM
                    (  
                        SELECT
                            his.id_gci,
                            100 AS persen_target,
                            book.total_booking,
                            book.id_gm
                        FROM rsp_project_live.t_gci_history AS his
                        LEFT JOIN
                            (
                                SELECT
                                    gci.created_at,
                                    gci.id_kategori,
                                    gci.id_gci,
                                    IF(gci.id_gci IS NOT NULL,1,NULL) AS total_booking,
                                    CASE
                                        WHEN us.id_manager IN (838,2029) AND us.id_gm = 838 THEN 838
                                        WHEN us.id_manager IN (19,24327,167,2003) AND us.id_gm = 18 THEN 18
                                        WHEN us.id_manager IN (111) AND us.id_gm = 18 THEN 111
                                        WHEN us.id_manager IN (106) AND us.id_gm = 18 THEN 106
                                        WHEN us.id_manager IN (2029) AND us.id_gm = 24099 THEN 24099
                                    END AS id_gm
                                FROM rsp_project_live.t_gci AS gci
                                LEFT JOIN rsp_project_live.`user` AS us ON us.id_user = gci.id_user
                            ) AS book
                        ON book.id_gci = his.id_gci AND book.id_kategori = 3
                        JOIN rsp_project_live.t_gci AS gci ON gci.id_gci = his.id_gci AND gci.id_gm = '$id_gm' AND LEFT(gci.created_at, 7) = '$periode'
                        WHERE LEFT(his.created_at, 7) = '$periode'
                        AND his.id_kategori IN (2.1)
                    ) AS ghis
                ";

        return $this->db->query($query)->row_array();

    }

    function produktivitas_grab_posting($id_gm, $periode)
    {

        $query = "SELECT
                    COUNT(gci_ps.id_user) AS total_sales,
                    COUNT(gci_ps.total_user) AS total_sales_yang_posing,
                    SUM(gci_ps.total_posting) AS total_postingan_ke_sosmed,
                    ROUND(AVG(gci_ps.total_posting)) AS average_posting_per_sales,
                    ROUND( (COUNT(gci_ps.total_user) / COUNT(gci_ps.id_user) ) * 100 ) AS persen_achieve,
                    100 AS persen_target
                FROM
                    (
                        SELECT
                            us.id_user,
                            posting.total_user,
                            posting.total_posting,
                            CASE
                                WHEN us.id_manager IN (838,2029) AND us.id_gm = 838 THEN 838
                                WHEN us.id_manager IN (19,24327,167,2003) AND us.id_gm = 18 THEN 18
                                WHEN us.id_manager IN (111) AND us.id_gm = 18 THEN 111
                                WHEN us.id_manager IN (106) AND us.id_gm = 18 THEN 106
                                WHEN us.id_manager IN (2029) AND us.id_gm = 24099 THEN 24099
                            END AS id_gm
                        FROM rsp_project_live.`user` AS us
                        LEFT JOIN
                            (
                                SELECT
                                    g_ps.created_by AS id_user,
                                    IF(g_ps.created_by IS NOT NULL,1,NULL) AS total_user,
                                    COUNT(g_ps.id_posting) AS total_posting
                                FROM rsp_project_live.t_grab_posting AS g_ps
                                WHERE LEFT(g_ps.created_at, 7) = '$periode'
                                AND g_ps.gm = '$id_gm'
                                GROUP BY g_ps.created_by
                            ) AS posting ON posting.id_user = us.id_user
                        WHERE us.id_user != us.spv
                        AND us.isActive = 1
                        AND us.id_divisi = 2
                        AND us.id_gm = '$id_gm'
                    ) AS gci_ps
                ";

        return $this->db->query($query)->row_array();

    }

    function keterlaksanaan_canvasing($id_gm, $periode)
    {

        $query = "SELECT
                    COUNT(canvasing.id_activity) AS total_canvasing_spv,
                    COUNT(IF(canvasing.ach = 1, 1, NULL)) AS total_canvasing_sesuai_target_database,
                    COUNT(IF(canvasing.ach = 0, 1, NULL)) AS total_canvasing_tidak_sesuai_target_database,
                    ROUND((COUNT(IF(canvasing.ach = 1, 1, NULL)) / COUNT(canvasing.id_activity)) * 100) AS persen_achieve,
                    100 AS persen_target
                FROM
                    (
                        SELECT
                            g_act.id_activity,
                            SUBSTR(g_act.tanggal,1,10) AS tanggal,
                            g_act.`event` AS id_event,
                            r_kel.kecamatan,
                            r_kel.kelurahan,
                            g_act.bertemu,
                            SUBSTR(g_act.created_at, 1, 10) AS created_at,
                            us.id_user AS id_created_by,
                            us.username AS created_by,
                            COALESCE(SUM(tam.`database`), g_act.target_db, 0) AS target_db,+ COALESCE(ach.db, 0) AS db,
                            IF( COALESCE(SUM(tam.`database`), g_act.target_db, 0) <= COALESCE(ach.db, 0), 1, 0 ) AS ach
                        FROM
                            rsp_project_live.t_activity AS g_act
                        LEFT JOIN
                            (
                                SELECT
                                    kel.id_kelurahan,
                                    LCASE(kec.kecamatan) AS kecamatan,
                                    LCASE(kel.kelurahan) AS kelurahan
                                FROM rsp_project_live.r_kelurahan_new AS kel
                                JOIN rsp_project_live.r_kecamatan AS kec ON kel.id_kecamatan = kec.id_kecamatan
                            ) AS r_kel ON r_kel.id_kelurahan = g_act.kelurahan
                        JOIN
                            (
                                SELECT
                                    us.id_user,
                                    us.username,
                                    CASE
                                    WHEN us.id_manager IN (838,2029) AND us.id_gm = 838 THEN 838
                                    WHEN us.id_manager IN (19,24327,167,2003) AND us.id_gm = 18 THEN 18
                                    WHEN us.id_manager IN (111) AND us.id_gm = 18 THEN 111
                                    WHEN us.id_manager IN (106) AND us.id_gm = 18 THEN 106
                                    WHEN us.id_manager IN (2029) AND us.id_gm = 24099 THEN 24099
                                    END AS id_gm
                                FROM rsp_project_live.`user` AS us
                                WHERE us.isActive = 1
                                AND us.id_divisi = 2
                            ) AS us
                        ON us.id_user = g_act.created_by
                        AND us.id_gm = '$id_gm'
                        LEFT JOIN
                            (
                                SELECT
                                    gci.created_by AS id_marketing,
                                    SUBSTR(gci.created_at,1,10) AS created_at,
                                    gci.id_event,
                                    COUNT(gci.id_gci) AS db,
                                    gci.spv
                                FROM rsp_project_live.t_gci AS gci
                                LEFT JOIN rsp_project_live.`user` AS us ON us.id_user = gci.created_by
                                WHERE gci.id_event IN (1, 184, 7, 204)
                                AND LEFT(gci.created_at,7) = '$periode'
                                AND us.isActive = 1
                                GROUP BY SUBSTR(gci.created_at,1,10), gci.id_event, gci.spv
                            ) AS ach
                        ON ach.id_event = g_act.`event`
                        AND ach.spv = g_act.created_by
                        AND ach.created_at = SUBSTR(g_act.tanggal, 1, 10)
                        LEFT JOIN rsp_project_live.t_activity_marketing AS tam ON g_act.id_activity = tam.id_activity
                        WHERE LEFT(g_act.tanggal, 7) = '$periode'
                        AND g_act.tipe = 'spv'
                        GROUP BY g_act.id_activity
                    ) AS canvasing
                ";

        return $this->db->query($query)->row_array();

    }



    
}