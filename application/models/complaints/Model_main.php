<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_main extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('Filter');
    }

    function is_konsumen($id_task)
    {
        $data = $this->db->query("SELECT COALESCE(status_konsumen,0) AS status_konsumen FROM cm_task WHERE id_task = '$id_task'")->row();
        if ($data) {
            return $data->status_konsumen;
        } else {
            return 0;
        }
    }

    function generate_id_task()
    {
        $q = $this->db->query("SELECT
        MAX( RIGHT ( cm_task.id_task, 3 ) ) AS kd_max 
        FROM
        cm_task 
        WHERE
        SUBSTR( cm_task.created_at, 1, 10 ) = CURDATE( )");
        $kd = "";

        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf("%03s", $tmp);
            }
        } else {
            $kd = "001";
        }
        return 'C' . date('ymd') . $kd;
    }

    public function get_user()
    {
        $user_id = $this->session->userdata('user_id');
        return $this->db->query("SELECT
        CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ) AS employee_name,
        CONCAT(
            hris.xin_companies.alias,
            ' | ',
            hris.xin_departments.department_name 
        ) AS department,
        hris.xin_employees.user_id AS `id_requester`,
        CASE WHEN hris.xin_employees.profile_picture = '' THEN 'default_male.jpg' ELSE hris.xin_employees.profile_picture END AS profile_picture,
        hris.xin_departments.head_id AS head_requester_id,
        CONCAT( u.first_name, ' ', u.last_name ) AS head_requester_name
    FROM
        hris.xin_employees
        JOIN hris.xin_companies ON hris.xin_employees.company_id = hris.xin_companies.company_id
        JOIN hris.xin_departments ON hris.xin_employees.department_id = hris.xin_departments.department_id
        LEFT JOIN hris.xin_employees u ON u.user_id = hris.xin_departments.head_id
    WHERE
        hris.xin_employees.is_active = 1 AND hris.xin_employees.user_id != 1 AND hris.xin_employees.user_id = '$user_id'")->row();
    }

    public function get_project()
    {
        return $this->db->query("SELECT id_project, project, kota FROM rsp_project_live.m_project WHERE `status` IS NULL ORDER BY project");
    }

    public function get_blok_by_id_project()
    {
        $id_project = $this->filter->sanitaze_input($this->input->post('id_project'));
        // $sql = "SELECT blok FROM rsp_project_live.m_project_unit WHERE id_project = ? ORDER BY blok";
        $sql = "SELECT 
            mp.blok, 
            IF(COALESCE(p.kota,0) = 'Cirebon',340,8070) AS user_id, 
            CONCAT(e.first_name,' ',e.last_name) AS head_name 
        FROM rsp_project_live.m_project_unit mp
        LEFT JOIN rsp_project_live.m_project p ON p.id_project = mp.id_project
        LEFT JOIN xin_employees e ON e.user_id = IF(COALESCE(p.kota,0) = 'Cirebon',340,8070)
        WHERE mp.id_project = ? ORDER BY blok";
        return $this->db->query($sql, array($id_project));
    }

    public function get_konsumen()
    {
        $id_project = $this->filter->sanitaze_input($this->input->post('id_project'));
        $blok = $this->filter->sanitaze_input($this->input->post('blok'));
        if ($id_project != '' && $blok != '') {

            $sql = "SELECT k.id_konsumen, k.nama_konsumen, COALESCE(a.id_akad,'') AS is_akad FROM rsp_project_live.t_gci g 
        LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = g.id_konsumen
        LEFT JOIN rsp_project_live.t_akad a ON a.id_konsumen = g.id_konsumen AND a.hasil_akad = 1
        WHERE g.id_project = ? AND g.blok = ? AND id_kategori = 3";
            return $this->db->query($sql, array($id_project, $blok))->row();
        }
        return '';
    }

    public function get_requester()
    {
        return $this->db->query("SELECT
			CONCAT(
				CONCAT( hris.xin_employees.first_name, ' ', hris.xin_employees.last_name ),
				' | ',
				hris.xin_companies.alias,
				' | ',
				hris.xin_departments.department_name 
			) AS requester,
			hris.xin_employees.user_id AS `id_requester` 
		FROM
			hris.xin_employees
			JOIN hris.xin_companies ON hris.xin_employees.company_id = hris.xin_companies.company_id
			JOIN hris.xin_departments ON hris.xin_employees.department_id = hris.xin_departments.department_id 
		WHERE
			hris.xin_employees.is_active = 1 AND hris.xin_employees.user_id != 1");
    }

    public function get_detail_task($id_task)
    {
        $query = "SELECT
                    COALESCE(t.reschedule,0) AS reschedule,
                    COALESCE(IF(t.project = '', null, t.project), m_project.project) AS project,
                    t.blok,
                    t.created_by,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    CASE WHEN t.status_konsumen = 1 OR t.created_by = 9791 THEN t.konsumen ELSE CONCAT(em.first_name, ' ', em.last_name) END AS requested_by,
                    t.verified_by AS verified_user_id,
                    t.escalation_by AS escalation_user_id,
                    CONCAT(vm.first_name, ' ', vm.last_name) AS verified_by,
                    COALESCE(DATE_FORMAT(t.verified_at, '%d %b %y'),'') AS tgl_verified,
                    IF(LEFT(vm.contact_no,1) = 0,CONCAT('62',SUBSTR(vm.contact_no,2)),vm.contact_no) AS verified_contact_no,
                    COALESCE(SUBSTR(t.verified_at,12,5),'') AS jam_verified,
                    CONCAT(hp.first_name, ' ', hp.last_name) AS escalation_by,
                    COALESCE(DATE_FORMAT(t.escalation_at, '%d %b %y'),'') AS tgl_escalation,
                    IF(LEFT(hp.contact_no,1) = 0,CONCAT('62',SUBSTR(hp.contact_no,2)),hp.contact_no) AS escalation_contact_no,
                    COALESCE(SUBSTR(t.escalation_at,12,5),'') AS jam_escalation,
                    em.profile_picture AS requested_photo,
                    CASE WHEN t.created_by = '5428' THEN
                        REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(k.no_hp, '-',''),'+','') END
                        ),' ','')
                    ELSE
                                            REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(em.contact_no, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(em.contact_no, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(em.contact_no, '-',''),'+','') END
                        ), ' ','') END AS requested_contact_no,
                    CASE WHEN t.created_by = 9791 THEN 'Instagram' ELSE d.department_name END AS requested_department,
                    CASE WHEN t.created_by = 9791 THEN 'DM/Comment' ELSE ds.designation_name END AS requested_designation,
                    CASE WHEN t.created_by = 9791 THEN '-' ELSE cmp.name END AS requested_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name, ' (',e.contact_no,')')) AS team_name,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    t.level AS id_level,
                    lvl.level AS `level`,
                    lvl.color AS `level_color`,
                    t.task,
                    t.description,
                    t.pic_note,
                    t.verified_note,
                    t.progress,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS `start_2`,
                    COALESCE(DATE_FORMAT(t.end, '%d %b %y'),'') AS `end_2`,
                    COALESCE(CASE WHEN DATE_FORMAT( t.`start`, '%b %y' ) = DATE_FORMAT( t.`end`, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d' ), '-', DATE_FORMAT( t.`end`, '%d %b %y' ))
	WHEN  DATE_FORMAT( t.`start`, '%y' ) = DATE_FORMAT( t.`end`, '%y' ) AND DATE_FORMAT( t.`start`, '%b' ) != DATE_FORMAT( t.`end`, '%b' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d %b' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' ))
	ELSE CONCAT(DATE_FORMAT( t.`start`, '%d %b %y' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' )) END,'') AS timeline,
                    t.id_category,
                    c.category,
                    t.priority AS id_priority,
                    p.priority,
                    p.color AS priority_color,
                    t.`status` AS id_status,
                    s.`status`,
                    s.`color` AS status_color,
                    COALESCE(t.pic,'') AS id_pic,
                    COALESCE(t.due_date,'') AS due_date,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date_2,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_TIME, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'bg-light-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'bg-light-yellow' 
                    ELSE 'bg-light-blue' END AS due_date_style,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'text-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'text-yellow' 
                    ELSE 'text-blue' END AS due_date_style_text,
                    COALESCE(t.start,CURRENT_TIME) AS `start`,
                    COALESCE(t.end,t.due_date) AS `end`,
                    DATE(t.done_date) AS done_date,
                    g.id_gci,
                    COALESCE(afs.tgl_komplain,'-') AS tgl_aftersales,
                    COALESCE(afs.id_after_sales,'') AS id_after_sales,
                    COALESCE(rt.id,'') AS id_rating,
                    COALESCE(rt.kualitas,'') AS kualitas,
                    COALESCE(rt.respons,'') AS respons,
                    COALESCE(rt.rekomendasi,'') AS rekomendasi,
                    COALESCE(rt.feedback,'') AS feedback,
                    COALESCE(rt.avg_rating,'') AS avg_rating,
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
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_employees vm ON vm.user_id = t.verified_by
                    LEFT JOIN xin_employees hp ON hp.user_id = t.escalation_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = em.designation_id
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN cm_level lvl ON lvl.id = t.`level`
                    LEFT JOIN cm_priority p ON p.id = t.priority
                    LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = t.id_konsumen
                    LEFT JOIN rsp_project_live.t_gci g ON g.id_project = t.id_project AND g.blok = t.blok AND g.id_konsumen = t.id_konsumen AND g.id_kategori >= 3
                    LEFT JOIN rsp_project_live.`user` mkt ON mkt.id_user = g.created_by
                    LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = g.spv
                    LEFT JOIN rsp_project_live.t_after_sales afs ON afs.id_konsumen = g.id_konsumen
                    LEFT JOIN cm_rating rt ON rt.id_task = t.id_task
                    LEFT JOIN rsp_project_live.m_project m_project ON m_project.id_project = t.id_project
                    LEFT JOIN rsp_project_live.t_project_update tpu ON tpu.id_project = t.id_project AND tpu.blok = t.blok
                    LEFT JOIN rsp_project_live.t_penyerahan_kunci kunci ON kunci.id_project = t.id_project AND kunci.blok = t.blok
                    LEFT JOIN rsp_project_live.t_task_qc t_task_qc ON t_task_qc.project = t.id_project AND t_task_qc.blok = t.blok
                    LEFT JOIN rsp_project_live.m_project_unit unit ON (unit.id_project = t.id_project AND unit.blok = t.blok)
                    LEFT JOIN rsp_project_live.t_project_bangun_detail spk_detail ON t.id_project = spk_detail.id_project AND t.blok = spk_detail.blok
                    LEFT JOIN rsp_project_live.t_project_bangun spk ON spk.id_rencana = spk_detail.id_rencana
                    LEFT JOIN rsp_project_live.m_vendor ven ON ven.id_vendor = spk.vendor
                    LEFT JOIN rsp_project_live.t_infrastruktur_detail spk_infra_detail ON spk_infra_detail.project = t.id_project AND FIND_IN_SET(t.blok,spk_infra_detail.blok)
                    LEFT JOIN rsp_project_live.t_infrastruktur spk_infra ON spk_infra_detail.id_inf = spk_infra.id_inf
                    LEFT JOIN rsp_project_live.m_vendor ven_infra ON ven.id_vendor = spk_infra.vendor
                    WHERE t.id_task = '$id_task'
                    GROUP BY t.id_task";
        return $this->db->query($query)->row();
    }

    public function get_detail_task_new($id_task)
    {
        $query = "SELECT
                    COALESCE(t.reschedule,0) AS reschedule,
                    COALESCE(IF(t.project = '', null, t.project), m_project.project) AS project,
                    t.blok,
                    t.created_by,
                    DATE_FORMAT(t.created_at, '%d %b %y') AS tgl_dibuat,
                    SUBSTR(t.created_at,12,5) AS jam_dibuat,
                    CASE WHEN t.status_konsumen = 1 OR t.created_by = 9791 THEN t.konsumen ELSE CONCAT(em.first_name, ' ', em.last_name) END AS requested_by,
                    -- t.verified_by AS verified_user_id,
                    10118 AS verified_user_id,
                    t.escalation_by AS escalation_user_id,
                    CONCAT(vm.first_name, ' ', vm.last_name) AS verified_by,
                    COALESCE(DATE_FORMAT(t.verified_at, '%d %b %y'),'') AS tgl_verified,
                    IF(LEFT(vm.contact_no,1) = 0,CONCAT('62',SUBSTR(vm.contact_no,2)),vm.contact_no) AS verified_contact_no,
                    COALESCE(SUBSTR(t.verified_at,12,5),'') AS jam_verified,
                    CONCAT(hp.first_name, ' ', hp.last_name) AS escalation_by,
                    COALESCE(DATE_FORMAT(t.escalation_at, '%d %b %y'),'') AS tgl_escalation,
                    IF(LEFT(hp.contact_no,1) = 0,CONCAT('62',SUBSTR(hp.contact_no,2)),hp.contact_no) AS escalation_contact_no,
                    COALESCE(SUBSTR(t.escalation_at,12,5),'') AS jam_escalation,
                    em.profile_picture AS requested_photo,
                    CASE WHEN t.created_by = '5428' THEN
                        REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(k.no_hp, '-',''),'+','') END
                        ),' ','')
                    ELSE
                                            REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(em.contact_no, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(em.contact_no, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(em.contact_no, '-',''),'+','') END
                        ), ' ','') END AS requested_contact_no,
                    CASE WHEN t.created_by = 9791 THEN 'Instagram' ELSE d.department_name END AS requested_department,
                    CASE WHEN t.created_by = 9791 THEN 'DM/Comment' ELSE ds.designation_name END AS requested_designation,
                    CASE WHEN t.created_by = 9791 THEN '-' ELSE cmp.name END AS requested_company,
                    GROUP_CONCAT(DISTINCT CONCAT(' ',e.first_name, ' ', e.last_name, ' (',e.contact_no,')')) AS team_name,
                    COUNT(e.user_id) AS team_count,
                    t.id_task,
                    t.level AS id_level,
                    lvl.level AS `level`,
                    lvl.color AS `level_color`,
                    t.task,
                    t.description,
                    t.pic_note,
                    t.verified_note,
                    t.progress,
                    COALESCE(t.evaluation,'') AS evaluation,
                    COALESCE(SUBSTR(t.start,1,10),'') AS `start`,
                    COALESCE(SUBSTR(t.end,1,10),'') AS `end`,
                    COALESCE(DATE_FORMAT(t.start, '%d %b %y'),'') AS `start_2`,
                    COALESCE(DATE_FORMAT(t.end, '%d %b %y'),'') AS `end_2`,
                    COALESCE(CASE WHEN DATE_FORMAT( t.`start`, '%b %y' ) = DATE_FORMAT( t.`end`, '%b %y' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d' ), '-', DATE_FORMAT( t.`end`, '%d %b %y' ))
	WHEN  DATE_FORMAT( t.`start`, '%y' ) = DATE_FORMAT( t.`end`, '%y' ) AND DATE_FORMAT( t.`start`, '%b' ) != DATE_FORMAT( t.`end`, '%b' ) THEN CONCAT(DATE_FORMAT( t.`start`, '%d %b' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' ))
	ELSE CONCAT(DATE_FORMAT( t.`start`, '%d %b %y' ), ' - ', DATE_FORMAT( t.`end`, '%d %b %y' )) END,'') AS timeline,
                    t.id_category,
                    c.category,
                    t.priority AS id_priority,
                    p.priority,
                    p.color AS priority_color,
                    t.`status` AS id_status,
                    s.`status`,
                    s.`color` AS status_color,
                    COALESCE(t.pic,'') AS id_pic,
                    COALESCE(t.due_date,'') AS due_date,
                    DATE_FORMAT(t.due_date, '%d %b %y') AS due_date_2,
                    TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) AS due_diff,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN CONCAT(TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME), ' days overdue') 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'Today' 
                    ELSE CONCAT(TIMESTAMPDIFF(DAY,CURRENT_TIME, t.due_date), ' days left') END AS due_date_text,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'bg-light-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'bg-light-yellow' 
                    ELSE 'bg-light-blue' END AS due_date_style,
                    CASE WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) > 0 THEN 'text-red' 
                    WHEN TIMESTAMPDIFF(DAY,t.due_date,CURRENT_TIME) = 0 THEN 'text-yellow' 
                    ELSE 'text-blue' END AS due_date_style_text,
                    COALESCE(t.start,CURRENT_TIME) AS `start`,
                    COALESCE(t.end,t.due_date) AS `end`,
                    DATE(t.done_date) AS done_date,
                    g.id_gci,
                    COALESCE(afs.tgl_komplain,'-') AS tgl_aftersales,
                    COALESCE(afs.id_after_sales,'') AS id_after_sales,
                    COALESCE(rt.id,'') AS id_rating,
                    COALESCE(rt.kualitas,'') AS kualitas,
                    COALESCE(rt.respons,'') AS respons,
                    COALESCE(rt.rekomendasi,'') AS rekomendasi,
                    COALESCE(rt.feedback,'') AS feedback,
                    COALESCE(rt.avg_rating,'') AS avg_rating,
                    CASE
                        WHEN t.id_category = 18 AND t.created_by = 9791  THEN 1
                        WHEN t.status_konsumen = 1 THEN 1
                        ELSE 0
                    END AS status_input
                FROM
                    `cm_task` t
                    LEFT JOIN xin_employees e ON FIND_IN_SET( e.user_id, t.pic )
                    LEFT JOIN xin_employees em ON em.user_id = t.created_by
                    LEFT JOIN xin_employees vm ON vm.user_id = t.verified_by
                    LEFT JOIN xin_employees hp ON hp.user_id = t.escalation_by
                    LEFT JOIN xin_companies cmp ON cmp.company_id = em.company_id
                    LEFT JOIN xin_departments d ON d.department_id = em.department_id
                    LEFT JOIN xin_designations ds ON ds.designation_id = em.designation_id
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN cm_level lvl ON lvl.id = t.`level`
                    LEFT JOIN cm_priority p ON p.id = t.priority
                    LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = t.id_konsumen
                    LEFT JOIN rsp_project_live.t_gci g ON g.id_project = t.id_project AND g.blok = t.blok AND g.id_konsumen = t.id_konsumen AND g.id_kategori >= 3
                    LEFT JOIN rsp_project_live.`user` mkt ON mkt.id_user = g.created_by
                    LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = g.spv
                    LEFT JOIN rsp_project_live.t_after_sales afs ON afs.id_konsumen = g.id_konsumen
                    LEFT JOIN cm_rating rt ON rt.id_task = t.id_task
                    LEFT JOIN rsp_project_live.m_project m_project ON m_project.id_project = t.id_project
                    WHERE t.id_task = '$id_task'
                    GROUP BY t.id_task";
        return $this->db->query($query)->row();
    }

    function get_log_history($id_task)
    {

        $query = "SELECT * 
                FROM 
                (
                        
                    -- CREATED
                    SELECT 
                        'created' AS jenis,
                        task.task AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM cm_task_history h
                    LEFT JOIN cm_task task ON task.id_task = h.id_task
                    LEFT JOIN cm_status s ON s.id = h.`status`
                    LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NULL
                    AND h.status = 1
                    -- CREATED

                    UNION

                    -- STATUS
                    SELECT 
                        'status' AS jenis,
                        NULL AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM cm_task_history h
                    LEFT JOIN cm_task task ON task.id_task = h.id_task
                    LEFT JOIN cm_status s ON s.id = h.`status`
                    LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NOT NULL
                    AND h.status != h.status_before
                    -- STATUS
                                       

                    UNION 
                                        
                    -- NOTE
                    SELECT 
                        'note' AS jenis,
                        h.note AS history,
                        NULL AS status_before,
                        NULL AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM cm_task_history h
                    LEFT JOIN cm_task task ON task.id_task = h.id_task
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND (h.note IS NOT NULL AND h.note  != '')
                    -- NOTE

                                
                ) history_log 
                ORDER BY datetime DESC";
        return $this->db->query($query)->result();
    }


    function get_log_history_timeline($id_task)
    {
        $query = "SELECT 
                        COALESCE(x.jenis,'') AS jenis,
                        COALESCE(x.history,'') AS history,
                        COALESCE(x.status_before,'') AS status_before,
                        COALESCE(x.status_before_color,'') AS status_before_color,
                        COALESCE(x.status,'') AS `status`,
                        COALESCE(x.status_color,'') AS status_color,
                        COALESCE(x.progress_before,'') AS progress_before,
                        COALESCE(x.progress,'') AS progress,
                        COALESCE(x.employee,'') AS employee,
                        COALESCE(x.photo,'') AS photo,
                        COALESCE(x.datetime,'') AS datetime,
                        COALESCE(x.tgl_history,'') AS tgl_history,
                        COALESCE(x.note,'') AS note
                    FROM (
                            SELECT
                                1 AS no_urut, 
                                'Dibuat' AS jenis,
                                task.task AS history,
                                sb.`status_konsumen` AS status_before,
                                sb.color AS status_before_color,
                                s.`status_konsumen` AS `status`,
                                s.color AS status_color,
                                COALESCE(h.progress_before,0) AS progress_before,
                                COALESCE(h.progress,0) AS progress,
                                IF(e.user_id = 5428, k.nama_konsumen, CONCAT(e.first_name,' ', e.last_name)) AS employee,
                                IF(e.user_id = 5428, 
                                        (CASE WHEN COALESCE(k.selfie,'') != '' THEN
                                            COALESCE(CONCAT('https://trusmicorp.com/rspproject/assets/uploads/spr_digital/selfie/',k.selfie),'')
                                        ELSE '' END)
                                        ,
                                        (CASE WHEN COALESCE(e.profile_picture,'') != '' THEN
                                            COALESCE(CONCAT('http://trusmiverse.com/hr/uploads/profile/',e.profile_picture),'')
                                        ELSE '' END)	
                                    ) AS photo,
                                h.created_at AS datetime,
                                COALESCE(DATE_FORMAT(h.created_at,'%d %b %Y | %H:%i WIB'),'-') AS tgl_history,
                                COALESCE(h.note,'-') AS note
                            FROM cm_task task
                            LEFT JOIN cm_task_history h ON task.id_task = h.id_task AND task.created_by = h.created_by
                            LEFT JOIN cm_status s ON s.id = h.`status`
                            LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                            LEFT JOIN xin_employees e ON e.user_id = task.created_by
                            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = task.id_konsumen
                            WHERE h.id_task = '$id_task'
                            AND h.status = 1

                            UNION

                            SELECT
                                2 AS no_urut,
                                'Verifikasi' AS jenis,
                                task.task AS history,
                                sb.`status_konsumen` AS status_before,
                                sb.color AS status_before_color,
                                s.`status_konsumen` AS `status`,
                                s.color AS status_color,
                                COALESCE(h.progress_before,0) AS progress_before,
                                COALESCE(h.progress,0) AS progress,
                                IF(e.user_id = 5428, k.nama_konsumen, CONCAT(e.first_name,' ', e.last_name)) AS employee,
                                IF(e.user_id = 5428, 
                                        (CASE WHEN COALESCE(k.selfie,'') != '' THEN
                                            COALESCE(CONCAT('https://trusmicorp.com/rspproject/assets/uploads/spr_digital/selfie/',k.selfie),'')
                                        ELSE '' END)
                                        ,
                                        (CASE WHEN COALESCE(e.profile_picture,'') != '' THEN
                                            COALESCE(CONCAT('http://trusmiverse.com/hr/uploads/profile/',e.profile_picture),'')
                                        ELSE '' END)	
                                    ) AS photo,
                                h.created_at AS datetime,
                                COALESCE(DATE_FORMAT(h.created_at,'%d %b %Y | %H:%i WIB'),'-') AS tgl_history,
                                COALESCE(h.note,'-') AS note
                            FROM cm_task task
                            LEFT JOIN cm_task_history h ON task.id_task = h.id_task AND task.verified_by = h.created_by AND h.status IN (2,3)
                            LEFT JOIN cm_status s ON s.id = h.`status`
                            LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                            LEFT JOIN xin_employees e ON e.user_id = task.verified_by
                            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = task.id_konsumen
                            WHERE task.id_task = '$id_task'

                            UNION

                            SELECT
                                3 AS no_urut,
                                'Eskalasi' AS jenis,
                                task.task AS history,
                                sb.`status_konsumen` AS status_before,
                                sb.color AS status_before_color,
                                s.`status_konsumen` AS `status`,
                                s.color AS status_color,
                                COALESCE(h.progress_before,0) AS progress_before,
                                COALESCE(h.progress,0) AS progress,
                                IF(e.user_id = 5428, k.nama_konsumen, CONCAT(e.first_name,' ', e.last_name)) AS employee,
                                IF(e.user_id = 5428, 
                                        (CASE WHEN COALESCE(k.selfie,'') != '' THEN
                                            COALESCE(CONCAT('https://trusmicorp.com/rspproject/assets/uploads/spr_digital/selfie/',k.selfie),'')
                                        ELSE '' END)
                                        ,
                                        (CASE WHEN COALESCE(e.profile_picture,'') != '' THEN
                                            COALESCE(CONCAT('http://trusmiverse.com/hr/uploads/profile/',e.profile_picture),'')
                                        ELSE '' END)	
                                    ) AS photo,
                                h.created_at AS datetime,
                                COALESCE(DATE_FORMAT(h.created_at,'%d %b %Y | %H:%i WIB'),'-') AS tgl_history,
                                COALESCE(h.note,'-') AS note
                            FROM cm_task task
                            LEFT JOIN cm_task_history h ON task.id_task = h.id_task AND task.escalation_by = h.created_by AND h.status IN (4,5)
                            LEFT JOIN cm_status s ON s.id = h.`status`
                            LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                            LEFT JOIN xin_employees e ON e.user_id = task.escalation_by
                            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = task.id_konsumen
                            WHERE task.id_task = '$id_task'

                            UNION

                            SELECT
                                4 AS no_urut,
                                'Eksekusi' AS jenis,
                                task.task AS history,
                                sb.`status_konsumen` AS status_before,
                                sb.color AS status_before_color,
                                s.`status_konsumen` AS `status`,
                                s.color AS status_color,
                                COALESCE(h.progress_before,0) AS progress_before,
                                COALESCE(h.progress,0) AS progress,
                                GROUP_CONCAT(IF(e.user_id = 5428, k.nama_konsumen, CONCAT(e.first_name,' ', e.last_name))) AS employee,
                                GROUP_CONCAT(IF(e.user_id = 5428, 
                                        (CASE WHEN COALESCE(k.selfie,'') != '' THEN
                                            COALESCE(CONCAT('https://trusmicorp.com/rspproject/assets/uploads/spr_digital/selfie/',k.selfie),'')
                                        ELSE '' END)
                                        ,
                                        (CASE WHEN COALESCE(e.profile_picture,'') != '' THEN
                                            COALESCE(CONCAT('http://trusmiverse.com/hr/uploads/profile/',e.profile_picture),'')
                                        ELSE '' END)	
                                    )) AS photo,
                                h.created_at AS datetime,
                                COALESCE(DATE_FORMAT(h.created_at,'%d %b %Y | %H:%i WIB'),'-') AS tgl_history,
                                COALESCE(h.note,'-') AS note
                            FROM cm_task task
                            LEFT JOIN cm_task_history h ON task.id_task = h.id_task AND FIND_IN_SET(h.created_by,task.pic) AND h.status >= 4
                            LEFT JOIN cm_status s ON s.id = h.`status`
                            LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                            LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,task.pic)
                            LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = task.id_konsumen
                            WHERE task.id_task = '$id_task'
                            GROUP BY task.id_task, h.id
                    ) AS x
                    ORDER BY x.`no_urut`";
        return $this->db->query($query)->result();
    }

    function get_log_history_for_konsumen($id_task)
    {

        $query = "SELECT * 
                FROM 
                (
                        
                    -- CREATED
                    SELECT 
                        'created' AS jenis,
                        task.task AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM cm_task_history h
                    LEFT JOIN cm_task task ON task.id_task = h.id_task
                    LEFT JOIN cm_status s ON s.id = h.`status`
                    LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NULL
                    AND h.status = 1
                    -- CREATED

                    UNION

                    -- STATUS
                    SELECT 
                        'status' AS jenis,
                        NULL AS history,
                        sb.`status` AS status_before,
                        s.`status` AS status,
                        COALESCE(h.progress_before,0) AS progress_before,
                        COALESCE(h.progress,0) AS progress,
                        CONCAT(e.first_name,' ', e.last_name) AS employee,
                        COALESCE(e.profile_picture,'') AS photo,
                        h.created_at AS datetime,
                        DATE(h.created_at) AS tanggal,
                        TIME(h.created_at) AS waktu,
                        COALESCE(h.note,'') AS note
                    FROM cm_task_history h
                    LEFT JOIN cm_task task ON task.id_task = h.id_task
                    LEFT JOIN cm_status s ON s.id = h.`status`
                    LEFT JOIN cm_status sb ON sb.id = h.`status_before`
                    LEFT JOIN xin_employees e ON e.user_id = h.created_by
                    WHERE h.id_task = '$id_task'
                    AND h.status_before IS NOT NULL
                    AND h.status != h.status_before
                    -- STATUS   
                ) history_log 
                ORDER BY datetime DESC";
        return $this->db->query($query)->result();
    }

    function get_comment($id_task)
    {
        $query = "SELECT
        COALESCE(c.id,0) AS id_comment,
        c.id_task,
        c.`comment`,
        COALESCE(c.reply_to,'') AS reply_to,
        CASE WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 24 THEN
					CONCAT(DATE_FORMAT(c.created_at,'%d %b %y'),' | ', DATE_FORMAT(c.created_at,'%H:%i'))
				WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 1 THEN
					CONCAT(TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME),' hrs ago')
					ELSE
						CONCAT(TIMESTAMPDIFF(MINUTE,c.created_at,CURRENT_TIME), ' mnt ago')
				END AS `times`,
        DATE_FORMAT(c.created_at,'%d %b %y') AS tgl,
        DATE_FORMAT(c.created_at,'%H:%i') AS jam,
        c.created_by,
        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
        e.profile_picture
    FROM
        `cm_comment` c
        LEFT JOIN xin_employees e ON e.user_id = c.created_by
        WHERE c.id_task = '$id_task' AND c.reply_to IS NULL
        ORDER BY c.created_at DESC";
        return $this->db->query($query)->result();
    }

    function get_reply($id_task)
    {
        $query = "SELECT
        COALESCE(c.id,0) AS id_comment,
        c.id_task,
        c.`comment`,
        COALESCE(c.reply_to,'') AS reply_to,
        CASE WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 24 THEN
					CONCAT(DATE_FORMAT(c.created_at,'%d %b %y'),' | ', DATE_FORMAT(c.created_at,'%H:%i'))
				WHEN TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME) > 1 THEN
					CONCAT(TIMESTAMPDIFF(HOUR,c.created_at,CURRENT_TIME),' hrs ago')
					ELSE
						CONCAT(TIMESTAMPDIFF(MINUTE,c.created_at,CURRENT_TIME), ' mnt ago')
				END AS times,
        DATE_FORMAT(c.created_at,'%d %b %y') AS tgl,
        DATE_FORMAT(c.created_at,'%H:%i') AS jam,
        c.created_by,
        CONCAT(e.first_name,' ',e.last_name) AS employee_name,
        e.profile_picture
    FROM
        `cm_comment` c
        LEFT JOIN xin_employees e ON e.user_id = c.created_by
        WHERE c.id_task = '$id_task' AND c.reply_to IS NOT NULL
        ORDER BY c.created_at";
        return $this->db->query($query)->result();
    }

    function get_attachment($id_task)
    {
        $query = "SELECT
                        COALESCE(a.note,a.attachment) AS `filename`,
                        a.attachment AS `file`,
                        SUBSTRING_INDEX(a.attachment, '.', -1) AS type_file,
                        COALESCE(CONCAT(e.first_name,' ',e.last_name),'') AS created_by,
                        a.created_at,
                        CASE WHEN TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) > 24 THEN
                            CONCAT(DATE_FORMAT(a.created_at,'%d %b %y'),' | ', DATE_FORMAT(a.created_at,'%H:%i'))
                        WHEN TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME) > 1 THEN
                            CONCAT(TIMESTAMPDIFF(HOUR,a.created_at,CURRENT_TIME),' hrs ago')
                            ELSE
                                CONCAT(TIMESTAMPDIFF(MINUTE,a.created_at,CURRENT_TIME), ' mnt ago')
                        END AS `times`
                    FROM cm_task_attach a 
                    LEFT JOIN xin_employees e ON e.user_id = a.created_by
                    WHERE a.id_task = '$id_task'
                    UNION
                    SELECT
                        b.id_task AS `filename`,
                        b.file AS `file`,
                        SUBSTRING_INDEX(b.file, '.', -1) AS type_file,
                        CONCAT( e.first_name, ' ', e.last_name ) AS created_by,
                        b.created_at,
                        CASE WHEN TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) > 24 THEN
                            CONCAT(DATE_FORMAT(b.created_at,'%d %b %y'),' | ', DATE_FORMAT(b.created_at,'%H:%i'))
                        WHEN TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) < 24 AND TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME) > 1 THEN
                            CONCAT(TIMESTAMPDIFF(HOUR,b.created_at,CURRENT_TIME),' hrs ago')
                            ELSE
                                CONCAT(TIMESTAMPDIFF(MINUTE,b.created_at,CURRENT_TIME), ' mnt ago')
                        END AS `times`
                    FROM
                        cm_task b
                        LEFT JOIN xin_employees e ON e.user_id = b.created_by 
                    WHERE
                        b.id_task = '$id_task' AND b.file IS NOT NULL AND b.file != ''";
        return $this->db->query($query)->result();
    }

    public function get_cm_notif_verify($id_task)
    {
        $query = "SELECT
                    t.id_task,
                    t.konsumen,
                    COALESCE(t.verified_note,'') AS verified_note,
                    COALESCE(t.escalation_note,'') AS escalation_note,
                    COALESCE(t.pic_note,'') AS pic_note,
                    t.`status` AS id_status,
                    s.`status`,
                    t.project,
                    t.blok,
                    g.spv AS spv_id,
                    COALESCE(spv.employee_name,'') AS spv_name,
                    g.created_by,
                    COALESCE(mkt.employee_name,'') AS mkt_name,
                    t.task,
                    t.description,
                    c.category,
                    COALESCE(DATE_FORMAT(t.escalation_at,'%H:%i | %d-%b-%Y'),'') AS escalation_at,
                    COALESCE(DATE_FORMAT(t.verified_at,'%H:%i | %d-%b-%Y'),'') AS verified_at,
                    COALESCE(DATE_FORMAT(t.done_date,'%H:%i | %d-%b-%Y'),'') AS done_date,
                    COALESCE(DATE_FORMAT(t.start,'%H:%i | %d-%b-%Y'),'') AS start_timeline,
                    COALESCE(DATE_FORMAT(t.end,'%H:%i | %d-%b-%Y'),'') AS end_timeline,
                    p.priority,
                    DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                    r.user_id as requester_id,
                    CASE WHEN t.created_by = '5428' THEN 
                        t.konsumen
                    ELSE CONCAT(r.first_name,' ',r.last_name) END AS requester_name,
                    CASE WHEN t.created_by = '5428' THEN
                        REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(k.no_hp, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(k.no_hp, '-',''),'+','') END
                        ),' ','')
                                                ELSE
                                            REPLACE((
                            CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                            ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END
                        ), ' ','')
                    END AS requester_contact_no,
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name) AS head_pic_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS head_pic_contact_no,
                                        escalate.user_id AS escalation_user_id,
                    CONCAT(escalate.first_name,' ',escalate.last_name) AS escalation_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(escalate.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(escalate.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(escalate.contact_no, '-',''),'+','') END AS escalation_contact_no,
                    COALESCE(GROUP_CONCAT(CONCAT(pic.first_name,' ',pic.last_name)),'') AS pic_name
                FROM
                    `cm_task` t
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN xin_employees r ON r.user_id = t.created_by
                    LEFT JOIN xin_departments d ON d.department_id = r.department_id
                    LEFT JOIN xin_employees e ON e.user_id = t.verified_by
                    LEFT JOIN xin_employees escalate ON escalate.user_id = t.escalation_by
                    LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id,t.pic)
                    LEFT JOIN cm_priority p ON p.id = t.priority
                    LEFT JOIN rsp_project_live.m_konsumen k ON k.id_konsumen = t.id_konsumen
                    LEFT JOIN rsp_project_live.t_gci g ON g.id_project = t.id_project AND g.blok = t.blok AND g.id_konsumen = t.id_konsumen AND g.id_kategori >= 3
                    LEFT JOIN rsp_project_live.`user` mkt ON mkt.id_user = g.created_by
                    LEFT JOIN rsp_project_live.`user` spv ON spv.id_user = g.spv
                WHERE t.id_task = '$id_task'
                GROUP BY t.id_task";
        return $this->db->query($query)->row();
    }

    public function get_cm_notif_pic($id_task)
    {
        $query = "SELECT
                    t.id_task,
                    t.konsumen,
                    COALESCE(t.verified_note,'') AS verified_note,
                    COALESCE(t.escalation_note,'') AS escalation_note,
                    t.`status` AS id_status,
                    s.`status`,
                    t.project,
                    t.blok,
                    t.task,
                    t.description,
                    c.category,
                    COALESCE(DATE_FORMAT(t.escalation_at,'%H:%i | %d-%b-%Y'),'') AS escalation_at,
                    COALESCE(DATE_FORMAT(t.verified_at,'%H:%i | %d-%b-%Y'),'') AS verified_at,
                    COALESCE(DATE_FORMAT(t.start,'%H:%i | %d-%b-%Y'),'') AS start_timeline,
					COALESCE(DATE_FORMAT(t.end,'%H:%i | %d-%b-%Y'),'') AS end_timeline,
                    p.priority,
                    DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                    r.user_id as requester_id,
                    CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name) AS head_pic_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS head_pic_contact_no,
                                        escalate.user_id AS escalation_user_id,
                    CONCAT(escalate.first_name,' ',escalate.last_name) AS escalation_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(escalate.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(escalate.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(escalate.contact_no, '-',''),'+','') END AS escalation_contact_no,
                    COALESCE(CONCAT(pic.first_name,' ',pic.last_name),'') AS pic_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(pic.contact_no, '-',''),'+',''),1) = 0 THEN
                    CONCAT('62',SUBSTR(REPLACE(REPLACE(pic.contact_no, '-',''),'+',''),2)) 
                    ELSE REPLACE(REPLACE(pic.contact_no, '-',''),'+','') END AS pic_contact_no
                FROM
                    `cm_task` t
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN xin_employees r ON r.user_id = t.created_by
                    LEFT JOIN xin_departments d ON d.department_id = r.department_id
                    LEFT JOIN xin_employees e ON e.user_id = t.verified_by
                    LEFT JOIN xin_employees escalate ON escalate.user_id = t.escalation_by
                    LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id,t.pic)
                    LEFT JOIN cm_priority p ON p.id = t.priority
                WHERE t.id_task = '$id_task'";
        return $this->db->query($query)->result();
    }

    public function get_cm_request($id_task)
    {
        $query = "SELECT
                    t.id_task,
                    t.task,
                    t.description,
                    tt.type,
                    c.category,
                    o.object,
                    p.priority,
                    DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                    r.user_id as requester_id,
                    CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                        CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                        ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                    e.user_id,
                    CONCAT(e.first_name,' ',e.last_name) AS employee_name,
                    CASE WHEN LEFT(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),1) = 0 THEN
                        CONCAT('62',SUBSTR(REPLACE(REPLACE(e.contact_no, '-',''),'+',''),2)) 
                        ELSE REPLACE(REPLACE(e.contact_no, '-',''),'+','') END AS contact_no
                FROM
                    `cm_task` t
                    LEFT JOIN cm_category c ON c.id = t.category
                    LEFT JOIN cm_type tt ON tt.id = t.type
                    LEFT JOIN cm_object o ON o.id = t.object
                    LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                    LEFT JOIN xin_employees r ON r.user_id = t.created_by
                    LEFT JOIN cm_priority p ON p.id = t.priority
                WHERE
                    t.id_task = '$id_task'";
        return $this->db->query($query)->result();
    }

    public function get_cm_request_working_on($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        CONCAT(DATE_FORMAT(t.`start`, '%d %b'), ' s/d ', DATE_FORMAT(t.`end`,'%d %b')) AS timeline,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `cm_task` t
                        LEFT JOIN cm_category c ON c.id = t.category
                        LEFT JOIN cm_type tt ON tt.id = t.type
                        LEFT JOIN cm_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN cm_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 2";
        return $this->db->query($query)->row();
    }

    public function get_cm_request_done($id_task)
    {
        $query = "SELECT
                        t.id_task,
                        t.task,
                        t.description,
                        tt.type,
                        c.category,
                        o.object,
                        p.priority,
                        DATE_FORMAT(t.created_at,'%d %b %Y | %H:%i') AS created_at,
                        r.user_id as requester_id,
                        CONCAT(r.first_name,' ',r.last_name) AS requester_name,
                        CASE WHEN LEFT(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),1) = 0 THEN
                                CONCAT('62',SUBSTR(REPLACE(REPLACE(r.contact_no, '-',''),'+',''),2)) 
                                ELSE REPLACE(REPLACE(r.contact_no, '-',''),'+','') END AS requester_contact_no,
                        GROUP_CONCAT(DISTINCT CONCAT(e.first_name,' ',e.last_name)) AS pic_name
                FROM
                        `cm_task` t
                        LEFT JOIN cm_category c ON c.id = t.category
                        LEFT JOIN cm_type tt ON tt.id = t.type
                        LEFT JOIN cm_object o ON o.id = t.object
                        LEFT JOIN xin_employees e ON FIND_IN_SET(e.user_id,t.pic)
                        LEFT JOIN xin_employees r ON r.user_id = t.created_by
                        LEFT JOIN cm_priority p ON p.id = t.priority
                WHERE
                        t.id_task = '$id_task' AND t.`status` = 3";
        return $this->db->query($query)->row();
    }
}
