<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_head_division extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function data_achieve($periode, $divisi = null){
        $kondisi = ($divisi == null) ? '' : "AND pic.divisi = '$divisi'";
        $query = "SELECT
            head.pic,
            head.employee,
            head.department,
            head.designation,
            head.divisi,
            80 AS target_score,
            head.total_target_pelaksanaan,
            ROUND(COALESCE(SUM(head.persen_score) / 8,0), 1) AS score,
            ROUND(COALESCE(SUM(head.persen_score) / head.total_target_pelaksanaan,0), 1) AS persen_score,
            -- ROUND(AVG(head.persen_pelaksanaan), 1) AS pelaksanaan,
            ROUND(SUM(head.persen_pelaksanaan) / 8, 1) AS pelaksanaan,
            COUNT(head.pelaksanaan) AS total_pelaksanaan,
            ROUND((COUNT(head.pelaksanaan) / 8) * 100, 1) AS persen_pelaksanaan,
            MAX(IF(head.tipe = 'GRD', head.persen_pelaksanaan, 0)) AS grd,
            MAX(IF(head.tipe = 'GRD', head.persen_score, 0)) AS grd_score,
            MAX(IF(head.tipe = 'Interview', head.persen_pelaksanaan, 0)) AS interview,
            MAX(IF(head.tipe = 'Interview', head.persen_score, 0)) AS interview_score,
            MAX(IF(head.tipe = 'MOM', head.persen_pelaksanaan, 0)) AS mom,
            MAX(IF(head.tipe = 'MOM', head.persen_score, 0)) AS mom_score,
            MAX(IF(head.tipe = 'Genba', head.persen_pelaksanaan, 0)) AS genba,
            MAX(IF(head.tipe = 'Genba', head.persen_score, 0)) AS genba_score,
            MAX(IF(head.tipe = 'Coaching', head.persen_pelaksanaan, 0)) AS coaching,
            MAX(IF(head.tipe = 'Coaching', head.persen_score, 0)) AS coaching_score,
            MAX(IF(head.tipe = 'Sharing Leader', head.persen_pelaksanaan, 0)) AS sharing_leader,
            MAX(IF(head.tipe = 'Sharing Leader', head.persen_score, 0)) AS sharing_leader_score,
            MAX(IF(head.tipe = 'Improvement System', head.persen_pelaksanaan, 0)) AS improvement_system,
            MAX(IF(head.tipe = 'Improvement System', head.persen_score, 0)) AS improvement_system_score,
            MAX(IF(head.tipe = 'Briefing', head.persen_pelaksanaan, 0)) AS briefing,
            MAX(IF(head.tipe = 'Briefing', head.persen_score, 0)) AS briefing_score
            FROM
            (SELECT
                evn.pic,
                evn.tipe,
                TRIM(CONCAT(emp.first_name, ' ', emp.last_name)) AS employee,
                dep.department_name AS department,
                des.designation_name AS designation,
                pic.divisi,
                COALESCE(COUNT(evn.id_event),0) AS pelaksanaan,
                CASE
                    WHEN pic.divisi = 'Produksi' THEN 22
                    WHEN pic.divisi = 'Support' THEN 15
                    WHEN pic.divisi = 'Sales' THEN 20
                    ELSE 1
                END as total_target_pelaksanaan,
                CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END target_pelaksanaan,
                LEAST(
                100,
                ROUND(
                    (COALESCE(COUNT(evn.id_event), 0) /
                    CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END
                    ) * 100,
                    1
                )
                ) AS persen_pelaksanaan,
                ROUND(AVG(evn.total_bobot), 1) AS score,
                ROUND(SUM(evn.total_bobot), 1) AS total_score,
                LEAST(
                100,ROUND(
                    (COALESCE(SUM(evn.total_bobot), 0) /
                    CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END
                    ),
                    1
                )) AS persen_score
            FROM
                `head_t_event_upload` AS evn
                JOIN m_event_head_pic AS pic ON pic.pic = evn.pic
                JOIN xin_employees AS emp ON evn.pic = emp.user_id
                JOIN xin_departments AS dep ON dep.department_id = emp.department_id
                JOIN xin_designations AS des ON des.designation_id = emp.designation_id
            WHERE
                evn.periode = '$periode'
                $kondisi
            GROUP BY
                evn.pic,
                evn.tipe) AS head
            GROUP BY head.pic";
        return $this->db->query($query)->result();
    }
    function data_resume($periode, $divisi = null){
        $kondisi = ($divisi == null) ? '' : "AND pic.divisi = '$divisi'";
        $query = "SELECT
                ROUND(COALESCE(SUM(resume.score) / COUNT(resume.employee),0),1) AS avg_score,
                ROUND(COALESCE(SUM(resume.pelaksanaan) / COUNT(resume.employee),0),1) AS avg_pelaksanaan,
                ROUND(COALESCE(SUM(resume.grd) / COUNT(resume.employee),0),1) AS avg_grd,
                ROUND(COALESCE(SUM(resume.grd_score) / COUNT(resume.employee),0),1) AS avg_grd_score,
                ROUND(COALESCE(SUM(resume.interview) / COUNT(resume.employee),0),1) AS avg_interview,
                ROUND(COALESCE(SUM(resume.interview_score) / COUNT(resume.employee),0),1) AS avg_interview_score,
                ROUND(COALESCE(SUM(resume.mom) / COUNT(resume.employee),0),1) AS avg_mom,
                ROUND(COALESCE(SUM(resume.mom_score) / COUNT(resume.employee),0),1) AS avg_mom_score,
                ROUND(COALESCE(SUM(resume.genba) / COUNT(resume.employee),0),1) AS avg_genba,
                ROUND(COALESCE(SUM(resume.genba_score) / COUNT(resume.employee),0),1) AS avg_genba_score,
                ROUND(COALESCE(SUM(resume.coaching) / COUNT(resume.employee),0),1) AS avg_coaching,
                ROUND(COALESCE(SUM(resume.coaching_score) / COUNT(resume.employee),0),1) AS avg_coaching_score,
                ROUND(COALESCE(SUM(resume.sharing_leader) / COUNT(resume.employee),0),1) AS avg_sharing_leader,
                ROUND(COALESCE(SUM(resume.sharing_leader_score) / COUNT(resume.employee),0),1) AS avg_sharing_leader_score,
                ROUND(COALESCE(SUM(resume.improvement_system) / COUNT(resume.employee),0),1) AS avg_improvement_system,
                ROUND(COALESCE(SUM(resume.improvement_system_score) / COUNT(resume.employee),0),1) AS avg_improvement_system_score,
                ROUND(COALESCE(SUM(resume.briefing) / COUNT(resume.employee),0),1) AS avg_briefing,
                ROUND(COALESCE(SUM(resume.briefing_score) / COUNT(resume.employee),0),1) AS avg_briefing_score
                FROM
                (SELECT
                    head.employee,
                    head.department,
                    head.designation,
                    head.posisi,
                    80 AS target_score,
            head.total_target_pelaksanaan,
            ROUND(COALESCE(SUM(head.persen_score) / 8,0), 1) AS score,
            head.total_score,
            ROUND(COALESCE(SUM(head.persen_score) / head.total_target_pelaksanaan,0), 1) AS persen_score,
            -- ROUND(AVG(head.persen_pelaksanaan), 1) AS pelaksanaan,
            ROUND(SUM(head.persen_pelaksanaan) / 8, 1) AS pelaksanaan,
            COUNT(head.pelaksanaan) AS total_pelaksanaan,
            ROUND((COUNT(head.pelaksanaan) / 8) * 100, 1) AS persen_pelaksanaan,
            MAX(IF(head.tipe = 'GRD', head.persen_pelaksanaan, 0)) AS grd,
            MAX(IF(head.tipe = 'GRD', head.persen_score, 0)) AS grd_score,
            MAX(IF(head.tipe = 'Interview', head.persen_pelaksanaan, 0)) AS interview,
            MAX(IF(head.tipe = 'Interview', head.persen_score, 0)) AS interview_score,
            MAX(IF(head.tipe = 'MOM', head.persen_pelaksanaan, 0)) AS mom,
            MAX(IF(head.tipe = 'MOM', head.persen_score, 0)) AS mom_score,
            MAX(IF(head.tipe = 'Genba', head.persen_pelaksanaan, 0)) AS genba,
            MAX(IF(head.tipe = 'Genba', head.persen_score, 0)) AS genba_score,
            MAX(IF(head.tipe = 'Coaching', head.persen_pelaksanaan, 0)) AS coaching,
            MAX(IF(head.tipe = 'Coaching', head.persen_score, 0)) AS coaching_score,
            MAX(IF(head.tipe = 'Sharing Leader', head.persen_pelaksanaan, 0)) AS sharing_leader,
            MAX(IF(head.tipe = 'Sharing Leader', head.persen_score, 0)) AS sharing_leader_score,
            MAX(IF(head.tipe = 'Improvement System', head.persen_pelaksanaan, 0)) AS improvement_system,
            MAX(IF(head.tipe = 'Improvement System', head.persen_score, 0)) AS improvement_system_score,
            MAX(IF(head.tipe = 'Briefing', head.persen_pelaksanaan, 0)) AS briefing,
            MAX(IF(head.tipe = 'Briefing', head.persen_score, 0)) AS briefing_score
                FROM
                    (SELECT
                    evn.pic,
                    evn.tipe,
                    TRIM(CONCAT(emp.first_name, ' ', emp.last_name)) AS employee,
                    dep.department_name AS department,
                    des.designation_name AS designation,
                    emp.ctm_posisi AS posisi,
                    COALESCE(COUNT(evn.id_event),0) AS pelaksanaan,
                CASE
                    WHEN pic.divisi = 'Produksi' THEN 22
                    WHEN pic.divisi = 'Support' THEN 15
                    WHEN pic.divisi = 'Sales' THEN 20
                    ELSE 1
                END as total_target_pelaksanaan,
                CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END target_pelaksanaan,
                LEAST(
                100,
                ROUND(
                    (COALESCE(COUNT(evn.id_event), 0) /
                    CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END
                    ) * 100,
                    1
                )
                ) AS persen_pelaksanaan,
                ROUND(AVG(evn.total_bobot), 1) AS score,
                ROUND(SUM(evn.total_bobot), 1) AS total_score,
                LEAST(
                100,ROUND(
                    (COALESCE(SUM(evn.total_bobot), 0) /
                    CASE
                        WHEN 
                            evn.tipe = 'GRD' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Sharing Leader' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 1
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 1
                                ELSE 1
                            END
                        WHEN 
                            evn.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        WHEN 
                            evn.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        WHEN 
                            evn.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END
                    ),
                    1
                )) AS persen_score
                    FROM
                    `head_t_event_upload` AS evn
                    JOIN m_event_head_pic AS pic ON pic.pic = evn.pic
                    JOIN xin_employees AS emp ON evn.pic = emp.user_id
                    JOIN xin_departments AS dep ON dep.department_id = emp.department_id
                    JOIN xin_designations AS des ON des.designation_id = emp.designation_id
                    WHERE
                    evn.periode = '$periode'
                    $kondisi
                    GROUP BY
                    evn.pic,
                    evn.tipe) AS head
                GROUP BY head.pic) AS resume";
        return $this->db->query($query)->row();
    }

    function mom_header($id_mom)
    {
        $query = "SELECT
                mom.id_mom,
                hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                mom.judul,
                mom.tempat,
                mom.tgl,
                CONCAT(mom.start_time, ' - ', mom.end_time) AS waktu,
                COALESCE(mom.meeting, '') AS tipe_meeting,
                GROUP_CONCAT(DISTINCT dep.department_name) AS department_name,
                mom.agenda,
                GROUP_CONCAT(DISTINCT CONCAT(pst.first_name, ' ', pst.last_name)) AS peserta,
                -- Menghapus tag HTML dari pembahasan
                REGEXP_REPLACE (mom.pembahasan, '<[^>]+>', '') AS pembahasan,
                -- Menghapus tag HTML dari closing_statement
                REGEXP_REPLACE (mom.closing_statement, '<[^>]+>', '') AS closing_statement
                FROM
                mom_header mom
                LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mom.department)
                LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id, mom.peserta)
                LEFT JOIN head_t_event_upload hd ON hd.ids = mom.id_mom
                LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                WHERE
                id_mom = '$id_mom'
                AND mom.judul NOT LIKE '%genba%'
                AND mom.judul NOT LIKE '%gemba%'
                GROUP BY
                mom.id_mom; -- Penting: GROUP BY ditambahkan karena ada GROUP_CONCAT";
        return $this->db->query($query)->row_object();
    }

    function mom_task($id_mom)
    {
        $query = "SELECT
                issue.topik,
                issue.issue,
                item.action,
                kt.kategori,
                lv.`level`,
                item.deadline,
                GROUP_CONCAT(DISTINCT CONCAT(pc.first_name, ' ', pc.last_name)) AS pic,
                st.status,
                sub.evaluasi,
                item.ekspektasi,
                IF(item.verified_status = 1, 'Oke', 'Tidak Oke') AS verified_status,
                item.verified_note,
                CONCAT(vld.first_name, ' ', vld.last_name) AS verified_by,
                CASE
                    item.owner_verified_status
                    WHEN 1 THEN
                        'Oke'
                    WHEN 2 THEN
                        'Tidak Oke'
                    ELSE
                        'Oke Meeting'
                END AS owner_verified_status
                --    IF(
                --       hist.file IS NOT NULL AND hist.file != '', 
                --       CONCAT('https://trusmiverse.com/apps/uploads/monday/history_sub_task/', hist.file), 
                --       hist.link
                --    ) AS file_evidence
                FROM
                mom_issue_item item
                LEFT JOIN mom_issue issue ON issue.id_mom = item.id_mom
                AND issue.id_issue = item.id_issue
                JOIN mom_header mom ON mom.id_mom = item.id_mom
                LEFT JOIN mom_kategori kt ON kt.id = item.kategori
                JOIN mom_level lv ON lv.id = item.`level`
                LEFT JOIN xin_employees pc ON FIND_IN_SET(pc.user_id, item.pic)
                LEFT JOIN td_sub_task sub ON sub.id_sub_task = item.id_sub_task
                LEFT JOIN td_task task ON task.id_task = sub.id_task
                LEFT JOIN td_status st ON task.status =st.id
                LEFT JOIN xin_employees vld ON vld.user_id = item.verified_by
                --    LEFT JOIN (
                --        SELECT t1.*
                --        FROM td_sub_task_history t1
                --        JOIN (
                --            SELECT id_sub_task, MAX(created_at) as max_date
                --            FROM td_sub_task_history
                --            GROUP BY id_sub_task
                --        ) t2 ON t1.id_sub_task = t2.id_sub_task AND t1.created_at = t2.max_date
                --    ) hist ON hist.id_sub_task = item.id_sub_task
                WHERE
                item.id_mom = '$id_mom'
                AND mom.judul NOT LIKE '%genba%'
                AND mom.judul NOT LIKE '%gemba%'
                GROUP BY
                item.id";
        return $this->db->query($query)->result();
    }
    function genba_header($id_mom)
    {
        $query = "SELECT
                mom.id_mom,
                hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                mom.judul,
                mom.tempat,
                mom.tgl,
                CONCAT(mom.start_time, ' - ', mom.end_time) AS waktu,
                COALESCE(mom.meeting, '') AS tipe_meeting,
                GROUP_CONCAT(DISTINCT dep.department_name) AS department_name,
                mom.agenda,
                GROUP_CONCAT(DISTINCT CONCAT(pst.first_name, ' ', pst.last_name)) AS peserta,
                -- Menghapus tag HTML dari pembahasan
                REGEXP_REPLACE (mom.pembahasan, '<[^>]+>', '') AS pembahasan,
                -- Menghapus tag HTML dari closing_statement
                REGEXP_REPLACE (mom.closing_statement, '<[^>]+>', '') AS closing_statement
                FROM
                mom_header mom
                LEFT JOIN xin_departments dep ON FIND_IN_SET(dep.department_id, mom.department)
                LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id, mom.peserta)
                LEFT JOIN head_t_event_upload hd ON hd.ids = mom.id_mom
                LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                WHERE
                id_mom = '$id_mom'
                -- AND mom.judul NOT LIKE '%genba%'
                -- AND mom.judul NOT LIKE '%gemba%'
                GROUP BY
                mom.id_mom; -- Penting: GROUP BY ditambahkan karena ada GROUP_CONCAT";
        return $this->db->query($query)->row_object();
    }

    function genba_task($id_mom)
    {
        $query = "SELECT
                issue.topik,
                issue.issue,
                item.action,
                kt.kategori,
                lv.`level`,
                item.deadline,
                GROUP_CONCAT(DISTINCT CONCAT(pc.first_name, ' ', pc.last_name)) AS pic,
                st.status,
                sub.evaluasi,
                item.ekspektasi,
                IF(item.verified_status = 1, 'Oke', 'Tidak Oke') AS verified_status,
                item.verified_note,
                CONCAT(vld.first_name, ' ', vld.last_name) AS verified_by,
                CASE
                    item.owner_verified_status
                    WHEN 1 THEN
                        'Oke'
                    WHEN 2 THEN
                        'Tidak Oke'
                    ELSE
                        'Oke Meeting'
                END AS owner_verified_status
                --    IF(
                --       hist.file IS NOT NULL AND hist.file != '', 
                --       CONCAT('https://trusmiverse.com/apps/uploads/monday/history_sub_task/', hist.file), 
                --       hist.link
                --    ) AS file_evidence
                FROM
                mom_issue_item item
                LEFT JOIN mom_issue issue ON issue.id_mom = item.id_mom
                AND issue.id_issue = item.id_issue
                JOIN mom_header mom ON mom.id_mom = item.id_mom
                LEFT JOIN mom_kategori kt ON kt.id = item.kategori
                JOIN mom_level lv ON lv.id = item.`level`
                LEFT JOIN xin_employees pc ON FIND_IN_SET(pc.user_id, item.pic)
                LEFT JOIN td_sub_task sub ON sub.id_sub_task = item.id_sub_task
                LEFT JOIN td_task task ON task.id_task = sub.id_task
                JOIN td_status st ON task.status =st.id
                JOIN xin_employees vld ON vld.user_id = item.verified_by
                --    LEFT JOIN (
                --        SELECT t1.*
                --        FROM td_sub_task_history t1
                --        JOIN (
                --            SELECT id_sub_task, MAX(created_at) as max_date
                --            FROM td_sub_task_history
                --            GROUP BY id_sub_task
                --        ) t2 ON t1.id_sub_task = t2.id_sub_task AND t1.created_at = t2.max_date
                --    ) hist ON hist.id_sub_task = item.id_sub_task
                WHERE
                item.id_mom = '$id_mom'
                -- AND mom.judul NOT LIKE '%genba%'
                -- AND mom.judul NOT LIKE '%gemba%'
                GROUP BY
                item.id";
        return $this->db->query($query)->result();
    }
    function coaching($id)
    {
        $query = "SELECT
                hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                --   coaching.id_coaching,
                  CONCAT(kary.first_name,' ',kary.last_name) AS karyawan,
                  coaching.tempat,
                  DATE_FORMAT(coaching.tanggal,'%d %b %Y') AS tanggal,
                  CONCAT(atas.first_name,' ',atas.last_name) AS atasan,
                  REGEXP_REPLACE(coaching.review, '<[^>]+>', '') AS review,
                  REGEXP_REPLACE(coaching.goals, '<[^>]+>', '') AS goals,
                  REGEXP_REPLACE(coaching.reality, '<[^>]+>', '') AS reality,
                  REGEXP_REPLACE(coaching.option, '<[^>]+>', '') AS `option`,
                  REGEXP_REPLACE(coaching.will, '<[^>]+>', '') AS will,
                  REGEXP_REPLACE(coaching.komitmen, '<[^>]+>', '') AS komitmen,
                  CONCAT('https://trusmiverse.com/apps/uploads/coaching/',COALESCE(coaching.foto,'')) AS foto,
                --   coaching.company_id,
                  comp.name AS company_name,
                --   coaching.department_id,
                  dp.department_name,
                --   coaching.designation_id,
                  dg.designation_name,
                --   coaching.role_id,
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
                  LEFT JOIN head_t_event_upload hd ON hd.ids = coaching.id_coaching
                LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                WHERE
                  coaching.id_coaching = '$id'";
        return $this->db->query($query)->row_object();
    }

    function sharing_leader($id)
    {
        $query = "SELECT
                hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                sl.created_at,
                CONCAT(cr.first_name,' ',cr.last_name) AS created_by,
                sl.judul,
                kl.soft_skill,
                REGEXP_REPLACE(sl.impact, '<[^>]+>', '') AS impact,
                GROUP_CONCAT(CONCAT(pst.first_name,' ',pst.last_name)) AS peserta,
                CONCAT('https://trusmiverse.com/apps/uploads/sharing_leader/',sl.lampiran) AS lampiran,
                CONCAT('https://trusmiverse.com/apps/uploads/sharing_leader/',sl.file_materi) AS file_materi
                FROM
                `t_sharing_leader` sl
                JOIN m_soft_skill kl ON kl.id = sl.klasifikasi
                LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id,sl.peserta)
                LEFT JOIN xin_employees cr ON cr.user_id = sl.created_by
                LEFT JOIN head_t_event_upload hd ON hd.ids = sl.id_sl
                LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                WHERE sl.id_sl = '$id'
                ";
        return $this->db->query($query)->row_object();
    }
    public function briefing($id)
    {
        $query = "SELECT
        hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                    brf.review,
                    brf.plan,
                    brf.informasi,
                    brf.motivasi,
                    comp.`name` AS company_name,
                    dep.department_name,
                    des.designation_name,
                    rol.role_name,
                    CONCAT('https://trusmiverse.com/apps/uploads/briefing/',brf.foto) AS foto,
                    GROUP_CONCAT(CONCAT(pst.first_name,' ',pst.last_name)) AS peserta,
                    brf.sanksi,
                    brf.feedback,
                    brf.feedback_at,
                    CONCAT(crt.first_name,' ',crt.last_name) AS created_by
                    FROM
                    `briefing` brf
                    JOIN xin_companies comp ON comp.company_id = brf.company_id
                    JOIN xin_departments dep ON dep.department_id = brf.department_id
                    JOIN xin_designations des ON des.designation_id = brf.designation_id
                    JOIN xin_user_roles rol ON rol.role_id = brf.role_id
                    LEFT JOIN xin_employees pst ON FIND_IN_SET(pst.user_id,brf.peserta)
                    JOIN xin_employees crt ON crt.user_id = brf.created_by
                    LEFT JOIN head_t_event_upload hd ON hd.ids = brf.id_briefing
                    LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                    LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                    WHERE
                    brf.id_briefing = '$id'";
        return $this->db->query($query)->row_object();
    }

    public function improvement($id)
    {
        $query = "SELECT
                hd.id_event,
                hd.tipe,
                hd.periode,
                itm.id_indikator,
                idk.aspek,
                idk.sub_aspek,
                idk.indikator,
                idk.bobot,
                tic.id_task,
                typ.type AS tipe_ticket,
                ct.category,
                GROUP_CONCAT(imp.impact) AS impact,
                obj.object,
                tic.task,
                tic.description,
                GROUP_CONCAT(DISTINCT CONCAT(pc.first_name, ' ', pc.last_name)) AS pic,
                st.status,
                tic.progress,
                prt.priority,
                lvl.level,
                tic.start,
                tic.end,
                tic.due_date,
                tic.done_date,
                tic.dod,
                CONCAT(crt.first_name,' ',crt.last_name) AS created_by,
                tic.created_at
                FROM
                `ticket_task` tic
                JOIN ticket_type typ ON typ.id = tic.type
                JOIN ticket_category ct ON ct.id = tic.category
                LEFT JOIN ticket_impact imp ON FIND_IN_SET(imp.id,tic.impact)
                JOIN ticket_object obj ON obj.id = tic.object
                JOIN xin_employees pc ON FIND_IN_SET(pc.user_id,tic.pic)
                JOIN ticket_status st ON st.id = tic.status
                JOIN ticket_priority prt ON prt.id = tic.priority
                LEFT JOIN ticket_level lvl ON lvl.id = tic.level
                JOIN xin_employees crt ON crt.user_id = tic.created_by
                LEFT JOIN head_t_event_upload hd ON hd.ids = tic.id_task
                LEFT JOIN head_t_event_upload_item itm ON itm.id_event = hd.id_event
                LEFT JOIN head_m_indikator idk ON idk.id = itm.id_indikator
                WHERE
                tic.id_task = '$id'";
        return $this->db->query($query)->row_object();
    }

    private function _generate_id()
    {
        $prefix = "EVN" . date('ymd'); // EVN260102

        $this->db->select('id_event');
        $this->db->like('id_event', $prefix, 'after');
        $this->db->order_by('id_event', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('hris.head_t_event_upload');

        if ($query->num_rows() > 0) {
            $last_id = $query->row()->id_event;
            $sequence = intval(substr($last_id, -3)) + 1; // Ambil 3 digit terakhir + 1
        } else {
            $sequence = 1;
        }

        // Format ulang jadi 3 digit (001, 002, dst)
        return $prefix . sprintf("%03d", $sequence);
    }

    public function insert_data($header, $items)
    {
        $this->db->trans_start(); // Mulai Transaksi Database

        // 1. Generate ID Baru
        $new_id = $this->_generate_id();

        // 3. Insert Header
        $data_insert_head = [
            'id_event' => $new_id,
            'tipe' => $header['tipe'],
            'pic' => $header['pic'],
            'periode' => $header['periode'],
            'freq' => $header['freq'],
            'files' => $header['files'],
            'ids' => $header['ids'],
            // 'total_bobot'    => $total_bobot,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $header['pic']
        ];

        $this->db->insert('head_t_event_upload', $data_insert_head);

        // 4. Insert Items (Batch)
        $data_insert_items = [];
        foreach ($items as $itm) {
            $data_insert_items[] = [
                'id_event' => $new_id,
                'id_indikator' => $itm['id_indikator'],
                // 'is_check'       => isset($itm['is_check']) ? $itm['is_check'] : 0,
                // 'bobot'          => isset($itm['bobot']) ? $itm['bobot'] : 0,
                // 'recommendation' => isset($itm['recommendation']) ? $itm['recommendation'] : null,
                'reason' => isset($itm['reason']) ? $itm['reason'] : null,
                // 'insight' => isset($itm['insight']) ? $itm['insight'] : null,
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        if (!empty($data_insert_items)) {
            $this->db->insert_batch('head_t_event_upload_item', $data_insert_items);
        }

        $this->db->trans_complete(); // Selesai Transaksi
        if ($this->db->trans_status() === FALSE) {
            $db_error = $this->db->error();
            return [
                'status' => false,
                'msg' => 'SQL Error: ' . $db_error['message'] . ' (Code: ' . $db_error['code'] . ')'
            ];
        }


        return ['status' => true, 'id_event' => $new_id];
    }

    public function update_data($id_event, $header, $items, $path_folder)
    {
        $this->db->trans_start(); // Mulai Transaksi

        // 1. Cek Data Lama (Penting untuk menghapus file lama)
        $this->db->where('id_event', $id_event);
        $query = $this->db->get('head_t_event_upload');

        if ($query->num_rows() == 0) {
            $this->db->trans_rollback();
            return ['status' => false, 'msg' => 'ID Event tidak ditemukan.'];
        }

        $old_data = $query->row();

        // 2. Siapkan Data Update Header
        $data_update_head = [
            'tipe' => $header['tipe'],
            'pic' => $header['pic'],
            'periode' => $header['periode'],
            'freq' => $header['freq'],
            'ids' => $header['ids'],
            // 'total_bobot' => ... (Bisa dihitung ulang di sini jika mau)
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $header['pic']
        ];

        // 3. Logika Ganti File
        // Jika user upload file baru ($header['files'] tidak null)
        if (!empty($header['files'])) {
            // Masukkan nama file baru ke array update
            $data_update_head['files'] = $header['files'];

            // HAPUS FILE LAMA dari folder (Fisik)
            if (!empty($old_data->files) && file_exists($path_folder . $old_data->files)) {
                unlink($path_folder . $old_data->files);
            }
        }
        // Jika $header['files'] null, berarti user tidak ganti file, skip update kolom 'files'

        // Eksekusi Update Header
        $this->db->where('id_event', $id_event);
        $this->db->update('head_t_event_upload', $data_update_head);

        $this->db->where('id_event', $id_event);
        $this->db->delete('head_t_event_upload_item');

        // Insert Item Baru
        $data_insert_items = [];
        foreach ($items as $itm) {
            $data_insert_items[] = [
                'id_event' => $id_event, // Pakai ID lama
                'id_indikator' => $itm['id_indikator'],
                // 'is_check'       => isset($itm['is_check']) ? $itm['is_check'] : 0,
                // 'bobot'          => isset($itm['bobot']) ? $itm['bobot'] : 0,
                // 'recommendation' => isset($itm['recommendation']) ? $itm['recommendation'] : null,
                'reason' => isset($itm['reason']) ? $itm['reason'] : null,
                // 'insight' => isset($itm['insight']) ? $itm['insight'] : null,
                'created_at' => date('Y-m-d H:i:s') // Tetap set created_at baru atau tambah updated_at di table item
            ];
        }

        if (!empty($data_insert_items)) {
            $this->db->insert_batch('head_t_event_upload_item', $data_insert_items);
        }

        $this->db->trans_complete(); // Selesai

        // 5. Error Handling
        if ($this->db->trans_status() === FALSE) {
            $db_error = $this->db->error();
            return [
                'status' => false,
                'msg' => 'SQL Update Error: ' . $db_error['message'] . ' (Code: ' . $db_error['code'] . ')'
            ];
        }

        return ['status' => true];
    }

    function update_bobot($id)
    {
        $this->db->trans_start();
        $query1 = "UPDATE head_t_event_upload_item AS item
                JOIN head_m_indikator AS indikator ON item.id_indikator = indikator.id
                SET item.bobot = indikator.bobot
                WHERE item.id_event = ?";

        $this->db->query($query1, [$id]);
        $query2 = "UPDATE head_t_event_upload AS head
                JOIN (
                    SELECT
                        id_event,
                        ROUND(COALESCE(SUM(bobot), 0), 1) AS total_bobot
                    FROM
                        head_t_event_upload_item
                    WHERE
                        id_event = ?
                        AND is_check = 1
                    GROUP BY
                        id_event
                ) AS item_sum ON head.id_event = item_sum.id_event
                SET head.total_bobot = item_sum.total_bobot";

        $this->db->query($query2, [$id]);
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    function data_event_header($periode, $pic, $tipe, $week = 1){
        $query = "SELECT
                hd.id_event,
                hd.tipe,
                CONCAT(emp.first_name,'',emp.last_name) AS pic,
                dep.department_name,
                des.designation_name,
                hd.total_bobot,
                hd.created_at,
                hd.recommendation,
                hd.insight,
                COUNT(item.id_event_item) AS jumlah
                
                FROM
                `head_t_event_upload` hd
                JOIN xin_employees emp ON emp.user_id = hd.pic
                JOIN xin_departments dep ON dep.department_id = emp.department_id
                JOIN xin_designations des ON des.designation_id = emp.designation_id
                LEFT JOIN head_t_event_upload_item item ON item.id_event = hd.id_event

                WHERE hd.pic = '$pic'
                AND hd.periode = '$periode'
                AND hd.freq = '$week'
                AND LOWER(hd.tipe) = LOWER('$tipe')";
        return $this->db->query($query)->row_object();
    }

    function data_event_item($periode, $pic, $tipe, $week = 1){
        $query = "SELECT
            '$periode' AS periode,
            '$pic' AS pic,
            item.id_event,
            item.id_indikator,
            idk.aspek,
            idk.sub_aspek,
            idk.indikator,
            item.is_check,
            item.reason,
            -- item.insight,
            -- item.recommendation,
            IF(item.is_check = 1, item.bobot, 0) AS bobot,
            hd.total_bobot
            FROM
            head_t_event_upload_item item
            LEFT JOIN head_t_event_upload hd ON hd.id_event = item.id_event
            LEFT JOIN head_m_indikator idk ON idk.id = item.id_indikator
            WHERE
                LOWER(hd.tipe) = LOWER('$tipe')
                AND hd.periode = '$periode'
                AND hd.pic = '$pic'
                AND hd.freq = '$week'";
        return $this->db->query($query)->result();
    }

    function data_mom($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  COALESCE(event.week_3, 0) AS week_3,
  COALESCE(event.week_4, 0) AS week_4,
  ROUND(((event.week_1 + event.week_2 + event.week_3 + event.week_4)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'MOM' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'MOM' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'MOM' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'MOM' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 3 AND hteu.periode = head_t_event_upload.periode limit 1) as week_3,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'MOM' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 4 AND hteu.periode = head_t_event_upload.periode limit 1) as week_4
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'MOM'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }
    
    function data_genba($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  ROUND(((event.week_1 + event.week_2)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Genba' THEN
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 2
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Genba' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Genba' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'Genba'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }
    
    function data_coaching($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  COALESCE(event.week_3, 0) AS week_3,
  COALESCE(event.week_4, 0) AS week_4,
  ROUND(((event.week_1 + event.week_2 + event.week_3 + event.week_4)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Coaching' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Coaching' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Coaching' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Coaching' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 3 AND hteu.periode = head_t_event_upload.periode limit 1) as week_3,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Coaching' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 4 AND hteu.periode = head_t_event_upload.periode limit 1) as week_4
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'Coaching'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }
    
    function data_sharing_leader($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
  xin_departments.department_name,
  xin_designations.designation_name as posisi,
  COALESCE(head_t_event_upload.total_bobot,0) as scoring
FROM
  `head_t_event_upload`
  LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
  LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
  LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
WHERE
  head_t_event_upload.tipe = 'Sharing Leader'
  AND head_t_event_upload.periode = '$periode'
  $kondisi";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row();
        }
    }

    function data_grd($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
  xin_departments.department_name,
  xin_designations.designation_name as posisi,
  COALESCE(head_t_event_upload.total_bobot,0) as scoring
FROM
  `head_t_event_upload`
  LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
  LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
  LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
WHERE
  head_t_event_upload.tipe = 'GRD'
  AND head_t_event_upload.periode = '$periode'
  $kondisi";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row();
        }
    }

    function data_interview($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  event.target,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  COALESCE(event.week_3, 0) AS week_3,
  COALESCE(event.week_4, 0) AS week_4,
  ROUND(((event.week_1 + event.week_2 + event.week_3 + event.week_4)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Interview' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 4
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Interview' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Interview' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Interview' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 3 AND hteu.periode = head_t_event_upload.periode limit 1) as week_3,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Interview' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 4 AND hteu.periode = head_t_event_upload.periode limit 1) as week_4
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'Interview'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }

    function data_improvment_system($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  ROUND(((event.week_1 + event.week_2)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Improvement System' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 2
                                WHEN pic.divisi = 'Support' THEN 1
                                WHEN pic.divisi = 'Sales' THEN 2
                                ELSE 2
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Improvement System' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Improvement System' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'Improvement System'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";
        
        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }

    function data_briefing($periode, $pic = null){
        $kondisi = ($pic == null) ? '' : "AND head_t_event_upload.pic = '$pic'";

        $query = "SELECT
        '$periode' AS periode,
            '$pic' AS pic,
  event.periode,
  event.tipe,
  event.employee_name,
  event.department_name,
  event.posisi,
  COALESCE(event.target, 0) AS target,
  COALESCE(event.actual, 0) AS actual,
  COALESCE(event.percent, 0) AS percent,
  COALESCE(event.week_1, 0) AS week_1,
  COALESCE(event.week_2, 0) AS week_2,
  COALESCE(event.week_3, 0) AS week_3,
  COALESCE(event.week_4, 0) AS week_4,
  ROUND(((event.week_1 + event.week_2 + event.week_3 + event.week_4)/event.target)) as avg
FROM
(
  SELECT
    head_t_event_upload.periode,
    head_t_event_upload.tipe,
    CONCAT(xin_employees.first_name,' ',xin_employees.last_name) as employee_name,
    xin_departments.department_name,
    xin_designations.designation_name as posisi,
    CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END as target,
    COUNT(head_t_event_upload.freq) as actual,
    ROUND((COUNT(head_t_event_upload.freq)/CASE
                        WHEN 
                            head_t_event_upload.tipe = 'Briefing' THEN 
                            CASE
                                WHEN pic.divisi = 'Produksi' THEN 4
                                WHEN pic.divisi = 'Support' THEN 4
                                WHEN pic.divisi = 'Sales' THEN 4
                                ELSE 4
                            END
                        ELSE 0
                    END)*100) as percent,
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Briefing' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 1 AND hteu.periode = head_t_event_upload.periode limit 1) as week_1,

    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Briefing' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 2 AND hteu.periode = head_t_event_upload.periode limit 1) as week_2,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Briefing' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 3 AND hteu.periode = head_t_event_upload.periode limit 1) as week_3,
    
    (SELECT COALESCE(total_bobot,0) FROM head_t_event_upload hteu WHERE hteu.tipe = 'Briefing' AND hteu.pic = head_t_event_upload.pic AND hteu.freq = 4 AND hteu.periode = head_t_event_upload.periode limit 1) as week_4
  FROM
    `head_t_event_upload`
    LEFT JOIN m_event_head_pic pic ON pic.pic = head_t_event_upload.pic
    LEFT JOIN xin_employees ON xin_employees.user_id = head_t_event_upload.pic
    LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
    LEFT JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
  WHERE
    head_t_event_upload.tipe = 'Briefing'
    AND head_t_event_upload.periode = '$periode'
    $kondisi
  GROUP BY head_t_event_upload.pic
) event";

        if ($pic == null) {
            return $this->db->query($query)->result();
        } else {
            return $this->db->query($query)->row_object();
        }
    }

    public function data_file(){
        $query = "SELECT * FROM your_table WHERE condition = 'value'";
        return $this->db->query($query)->result();
    }

    function data_emp($max_id){
        $query = "SELECT
        `xin_employees`.`user_id` AS `user_id`,
        trim(concat(`xin_employees`.`first_name`, ' ', `xin_employees`.`last_name`)) AS `Name_exp_2`,
        `xin_companies`.`name` AS `name`,
        `xin_departments`.`department_name` AS `department_name`,
        `xin_designations`.`designation_name` AS `designation_name`
        FROM
        (
            (
            (`xin_employees` JOIN `xin_companies` ON ((`xin_employees`.`company_id` = `xin_companies`.`company_id`)))
            JOIN `xin_departments` ON ((`xin_employees`.`department_id` = `xin_departments`.`department_id`))
            )
            JOIN `xin_designations` ON ((`xin_employees`.`designation_id` = `xin_designations`.`designation_id`))
        )
        WHERE
        (`xin_employees`.`user_id` > $max_id)";

        return $this->db->query($query)->result();
    }

}