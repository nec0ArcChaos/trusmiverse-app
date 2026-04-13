<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_table extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function dt_complaints($start, $end, $filter_category, $filter_pic)
    {
        $user_id = $this->session->userdata("user_id");
        $user_role_id = $this->session->userdata("user_role_id");
        $department_id = $this->session->userdata("department_id");

        if ($filter_category == "all") {
            $cond_category = "";
        } elseif ($filter_category == 10) {
            if (in_array($user_id, [3013]) == 1) {
                $cond_category = "AND t.id_category = '$filter_category' AND t.id_project in (53, 61, 70)";
            } else {
                $cond_category = "AND t.id_category = '$filter_category'";
            }
        } else {
            $cond_category = "AND t.id_category = '$filter_category'";
        }

        if ($filter_pic == "all") {
            $cond_pic = "";
            // } elseif ($filter_pic != $user_id) {
            //     $cond_pic = "AND (FIND_IN_SET( '$filter_pic', t.pic ) OR t.created_by = '$filter_pic')";
        } else {
            if ((in_array($user_id, [3013]) == 1) && $filter_category == 10) {
                $cond_pic = "";
            } else {
                $cond_pic = "AND (FIND_IN_SET( '$filter_pic', t.pic ) OR t.created_by = '$filter_pic' OR t.verified_by = '$filter_pic' OR t.escalation_by = '$filter_pic')";
            }
        }

        if ($user_role_id == 1 || in_array($user_id, [1, 61, 62, 68, 323, 340, 979, 63, 64, 1161, 2041, 2063, 2969, 2969, 2070, 2903, 6486, 2951, 1186, 2735, 7804, 5073, 2903, 2903, 476, 118, 2397, 76, 5768, 5121, 2505, 8893, 8005, 3670, 4138, 4498, 3013, 321, 10278, 10118, 5504, 11065,4954]) == 1 || in_array($department_id, [68, 83, 117, 230]) == 1) {
            $cond = "WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' $cond_pic $cond_category OR (t.due_date BETWEEN '$start' AND '$end' $cond_pic $cond_category)";
        } else {
            $cond = "WHERE substr(t.created_at,1,10) BETWEEN '$start' AND '$end' AND (FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' OR t.verified_by = '$user_id' OR t.escalation_by = '$user_id' OR c.head_id = '$user_id')";
        }

        $query = "SELECT
                t.created_at,
                t.created_by,
                t.verified_by,
                COALESCE(IF(t.project = '', null, t.project), m_project.project) AS project,
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
                DATEDIFF(DATE(t.escalation_at),t.created_at) as escalation_diff,
                IF(DATEDIFF(DATE(t.escalation_at),t.created_at) > 0,'Late','Ontime') as leadtime_escalation,
                COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS tgl_diproses,
                SUBSTR(t.created_at,12,5) AS jam_dibuat,
                em.username AS owner_username,
                CASE 
                    WHEN LEFT(REGEXP_REPLACE(em.contact_no, '[^0-9]', ''), 1) = '0' 
                    THEN CONCAT('62', SUBSTRING(REGEXP_REPLACE(em.contact_no, '[^0-9]', ''), 2)) 
                    ELSE REGEXP_REPLACE(em.contact_no, '[^0-9]', '') 
                END AS owner_contact_no,
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
                CASE 
                    WHEN t.created_by = 9791 THEN 'Dari Sosmed'
                    ELSE 'Dari Konsumen'
                END AS sumber_task,
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
                COALESCE(t.start,'') AS `start`,
                COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                COALESCE(CASE WHEN DATE_FORMAT( t.START, '%b %y' ) = DATE_FORMAT( t.END, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.START, '%d' ), '-', DATE_FORMAT( t.END, '%d %b %y' ))
        WHEN  DATE_FORMAT( t.START, '%y' ) = DATE_FORMAT( t.END, '%y' ) AND DATE_FORMAT( t.START, '%b' ) != DATE_FORMAT( t.END, '%b' ) THEN CONCAT(DATE_FORMAT( t.START, '%d %b' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' ))
        ELSE CONCAT(DATE_FORMAT( t.START, '%d %b %y' ), ' - ', DATE_FORMAT( t.END, '%d %b %y' )) END,'') AS timeline,
                t.id_category,
                c.category,
                c.ket_category,
                COALESCE(t.priority,'') AS id_priority,
                COALESCE(p.priority,'') AS priority,
                p.color AS priority_color,
                t.`status` AS id_status,
                s.`status`,
                s.`color` AS status_color,
                COALESCE(t.pic,'') AS id_pic,
                COALESCE(t.due_date,'') AS tgl_due_date,
                COALESCE(DATE_FORMAT(t.due_date, '%d %b %y'),'') AS due_date,
                TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) AS due_diff,
                DATEDIFF(DATE(t.done_date),t.due_date) as solver_diff,
                IF(DATEDIFF(DATE(t.done_date),t.due_date) > 0,'Late','Ontime') as leadtime_solver,
                CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE), ' days overdue') 
                WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'Today' 
                ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_DATE, t.due_date), ' days left') END AS due_date_text,
                CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) > 0 THEN 'bg-danger' 
                WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_DATE) = 0 THEN 'bg-warning' 
                ELSE 'bg-primary' END AS due_date_style,
                COALESCE(r.pelayanan,'') AS rating_pelayanan,
                COALESCE(r.kualitas,'') AS rating_kualitas,
                COALESCE(r.respons,'') AS rating_respons,
                COALESCE(r.avg_rating,'') AS avg_rating,
                CASE WHEN COALESCE(r.rekomendasi,'') = 1 THEN 'Tidak' WHEN COALESCE(r.rekomendasi,'') = 2 THEN 'Mungkin' WHEN COALESCE(r.rekomendasi,'') = 3 THEN 'Ya' ELSE '' END AS rating_rekomendasi,
                COALESCE(r.feedback,'') AS rating_feedback,
                COALESCE(r.created_at,'') AS tgl_input_rating,
                COALESCE(k.nama_konsumen,'') AS nama_konsumen,
                CASE 
                    WHEN LEFT(REGEXP_REPLACE(COALESCE(k.no_hp,''), '[^0-9]', ''), 1) = '0' 
                    THEN CONCAT('62', SUBSTRING(REGEXP_REPLACE(COALESCE(k.no_hp,''), '[^0-9]', ''), 2)) 
                    ELSE REGEXP_REPLACE(COALESCE(k.no_hp,''), '[^0-9]', '') 
                END AS no_hp_konsumen,
                t.follow_up_at,
                t.follow_up_by,
                CONCAT(
                    FLOOR(TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) / (60*24)), ' Hari, ',
                    FLOOR((TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) % (60*24)) / 60), ' Jam, ',
                    TIMESTAMPDIFF(MINUTE, t.created_at, t.follow_up_at) % 60, ' menit'
                ) AS leadtime_follow_up,
                    CASE
                        WHEN t.id_category = 18 AND t.created_by = 9791  THEN 1
                        WHEN t.status_konsumen = 1 THEN 1
                        ELSE 0
                    END AS status_input,
                    spk.vendor,
                    CASE WHEN
                    t.id_category = 4 THEN ven_infra.vendor
                    ELSE ven.vendor END AS nama_vendor,
                kunci.created_at AS tgl_kunci,
                tpu.tgl_pemasangan_kwh,
                t_task_qc.tgl_selesai AS tgl_selesai_qc,
                afs.tgl_perbaikan AS tgl_after_sales,
                DATEDIFF(CURDATE(), unit.tgl_vendor) AS usia_bangunan
            FROM
                `cm_task` t
                LEFT JOIN cm_rating r ON r.id_task = t.id_task
                LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                LEFT JOIN xin_employees em ON em.user_id = t.created_by
                LEFT JOIN xin_employees vf ON vf.user_id = t.verified_by
                LEFT JOIN xin_employees es ON es.user_id = t.escalation_by
                LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                LEFT JOIN xin_departments d ON d.department_id = em.department_id
                LEFT JOIN cm_category c ON c.id = t.id_category
                LEFT JOIN cm_status s ON s.id = t.`status`
                LEFT JOIN cm_priority p ON p.id = t.priority
                LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = t.id_konsumen
                LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON t.id_project = spk_detail.id_project AND t.blok = spk_detail.blok
                LEFT JOIN rsp_project_live.t_project_bangun spk ON spk.id_rencana = spk_detail.id_rencana
                LEFT JOIN rsp_project_live.m_vendor ven ON ven.id_vendor = spk.vendor
                LEFT JOIN rsp_project_live.t_infrastruktur_detail spk_infra_detail ON spk_infra_detail.project = t.id_project AND FIND_IN_SET(t.blok,spk_infra_detail.blok)
                LEFT JOIN rsp_project_live.t_infrastruktur spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
                LEFT JOIN rsp_project_live.m_vendor ven_infra ON ven.id_vendor = spk_infra.vendor
                LEFT JOIN rsp_project_live.m_project m_project ON m_project.id_project = t.id_project
                LEFT JOIN rsp_project_live.t_project_update tpu ON tpu.id_project = t.id_project AND tpu.blok = t.blok
                LEFT JOIN rsp_project_live.t_penyerahan_kunci kunci ON kunci.id_project = t.id_project AND kunci.blok = t.blok
                LEFT JOIN rsp_project_live.t_task_qc t_task_qc ON t_task_qc.project = t.id_project AND t_task_qc.blok = t.blok
                LEFT JOIN rsp_project_live.m_project_unit unit ON (unit.id_project = t.id_project AND unit.blok = t.blok)
                LEFT JOIN rsp_project_live.t_after_sales afs ON afs.id_project_unit = unit.id_project_unit
                $cond
                GROUP BY t.id_task ORDER BY t.created_at DESC";
        return $this->db->query($query)->result();
    }


    function get_complaints_by_id($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        CASE WHEN t.status_konsumen = 1 THEN t.konsumen ELSE CONCAT(em.first_name, ' ', em.last_name) END AS nama_konsumen,
                        COALESCE(DATE(t.created_at), '-') AS tanggal_pengajuan,
                        COALESCE(DATE(qc.tgl_selesai),'-') AS tgl_qc_passed,
                        COALESCE(DATE(afs.tgl_perbaikan),'-') AS tgl_after_sales,
                        m_project.project,
                        t.blok,
                        CONCAT(verifier.first_name, ' ', verifier.last_name) AS verified_by,
                        CONCAT(escalator.first_name, ' ', escalator.last_name) AS escalation_to,
                        COALESCE(p.priority,'-') AS priority,
                        GROUP_CONCAT(file.attachment) AS attachment,
                        t.description
                    FROM cm_task t
                    LEFT JOIN rsp_project_live.t_task_qc qc ON (qc.project = t.id_project AND qc.blok = t.blok)
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN cm_task_attach file ON file.id_task = t.id_task
                    LEFT JOIN rsp_project_live.m_project_unit unit ON (unit.id_project = t.id_project AND unit.blok = t.blok)
                    LEFT JOIN rsp_project_live.t_after_sales afs ON afs.id_project_unit = unit.id_project_unit
                    LEFT JOIN rsp_project_live.m_project ON m_project.id_project = t.id_project
                    LEFT JOIN xin_employees verifier ON verifier.user_id = t.verified_by
                    LEFT JOIN xin_employees escalator ON escalator.user_id = t.escalation_by
                    LEFT JOIN cm_priority p ON p.id = t.priority
                    LEFT JOIN (
                        SELECT 
                            t.id_task,
                            t.note
                        FROM 
                            cm_task_history t
                        JOIN 
                            (SELECT 
                                id_task,
                                MAX(id) AS max_id
                            FROM 
                                cm_task_history
                            GROUP BY 
                                id_task) m
                        ON 
                            t.id = m.max_id
                    ) history_note ON history_note.id_task = t.id_task
                    WHERE t.id_task = '$id_task'
                    GROUP BY t.id_task
                    LIMIT 1";
        return $this->db->query($query)->row();
    }
}
