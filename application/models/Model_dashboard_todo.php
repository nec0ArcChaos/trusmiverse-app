<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_dashboard_todo extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function data_todo($category, $start, $end, $user_id)
    {
        if($category == 'all'){
            if ($user_id == '803') { // Pak Ibnu
                if ($start == date('Y-m-d') && $end == date('Y-m-d')) {
                    $query    = $this->db->query("CALL dashboard_todo_today_super($user_id)");
                } else {
                    $query    = $this->db->query("CALL dashboard_todo($user_id, '$start','$end')");
                }
            } else {
                if ($start == date('Y-m-d') && $end == date('Y-m-d')) {
                    $query    = $this->db->query("CALL dashboard_todo_today($user_id)");
                } else {
                    $query    = $this->db->query("CALL dashboard_todo($user_id, '$start','$end')");
                }
            }
            
			return $query->result();
        }else{
            if ($user_id == '803') { // Pak Ibnu
                if ($start == date('Y-m-d') && $end == date('Y-m-d')) {
                    $query = $this->db->query("CALL dashboard_todo_custom_today_super($user_id,'$category','NULL')");
                } else {
                    $query = $this->db->query("CALL dashboard_todo_custom($user_id, '$start','$end','$category',NULL)");
                }
            } else {
                if ($start == date('Y-m-d') && $end == date('Y-m-d')) {
                    $query = $this->db->query("CALL dashboard_todo_custom_today($user_id,'$category','NULL')");
                } else {
                    $query = $this->db->query("CALL dashboard_todo_custom($user_id, '$start','$end','$category',NULL)");
                }
            }
            
            
			return $query->result();

        }
        // $query = "SELECT * FROM view_dashboard_todo 
        //           WHERE end_date BETWEEN '$start' AND '$end' 
        //           AND user_id = '$user_id' $kondisi";
        // return $this->db->query($query)->result();
    }


    public function get_task_resume($date, $user_id)
    {

        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, e.department_id, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $level_sto = $get_level_sto['level_sto'];
        $department_id = $get_level_sto['department_id'];

        if ($level_sto >= 4) { // kondisi jika level sto dari roles lebih atau sama dengan officer
            $kondisi = "AND em.department_id = '$department_id'
                    AND ur.level_sto < '$level_sto'";

            $kondisi2 = "AND (us.level_sto <= '$level_sto' AND l.department_id IN ($department_id))";
        } else { //kondisi user
            $kondisi = "AND tr.employee_id = $user_id";

            $kondisi2 = "AND l.employee_id = $user_id";
        }

        $query = "SELECT 
                        approval.*

                    FROM
                    (
                        SELECT 
                            'Approval' AS nama,
                            COUNT(*) AS total,
                        COUNT(CASE WHEN `status` = 1 THEN 1 END) AS undone
                        FROM trusmi_approval 
                        WHERE approve_to = $user_id
                        AND `created_at` LIKE '$date%'
                    ) approval

                    UNION

                    SELECT 
                        'IBR Pro' AS nama,
                        COUNT(*) AS total,
                        COUNT(CASE WHEN `status` IN (1,2) THEN 1 END) AS undone
                    FROM td_task 
                    WHERE FIND_IN_SET($user_id, pic) > 0
                    AND `due_date` LIKE '$date%'

                    UNION 

                    SELECT 
                        'Verifikasi IBR Pro',	
                        COUNT(sub.id_sub_task) AS total,
                        COUNT(CASE WHEN sub.verified_status IS NULL THEN 1 END) AS undone
                    FROM td_sub_task sub
                    LEFT JOIN td_task task ON task.id_task = sub.id_task
                    LEFT JOIN mom_issue_item item ON item.id_sub_task = sub.id_sub_task
                    WHERE FIND_IN_SET($user_id, task.created_by) > 0
                    AND task.`start` LIKE '$date%'

                    UNION 

                    SELECT 
                        'Verifikasi MoM',
                        COUNT(momi.id) AS total,
                        COUNT(CASE WHEN task.`status` = 3 THEN 1 END) AS undone
                    FROM mom_issue_item momi
                    JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
                    JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
                    JOIN td_task task ON task.id_task = stask.id_task
                    WHERE	
                        momi.verified_status IS NULL
                    AND DATE(mom.created_at) LIKE '$date%'
                    AND mom.created_by = $user_id
                    AND mom.meeting NOT IN ('Jobdesk')
                    AND momi.is_eskalasi IS NULL

                    UNION

                    SELECT 
                        'Approve Mng Leave',
                        COUNT(l.leave_id) AS total,
                        COUNT(CASE WHEN l.`status` = '1' THEN 1 END) AS undone
                    FROM xin_leave_applications l
                    LEFT JOIN xin_employees c ON c.user_id = l.employee_id
                    LEFT JOIN xin_user_roles us ON us.role_name = c.ctm_posisi
                    WHERE	
                        DATE(l.from_date) LIKE '$date%'
                    -- AND (us.level_sto <= '$level_sto' AND l.department_id IN ($department_id))
                    $kondisi2

                    UNION

                    SELECT 
                        'Approve Overtime',
                        COUNT(tr.time_request_id) AS total,
                        COUNT(CASE WHEN tr.is_approved = 1 THEN 1 END) AS undone
                    FROM xin_attendance_time_request tr
                    JOIN xin_employees em ON em.user_id = tr.employee_id
                    LEFT JOIN xin_user_roles ur ON ur.role_id = em.user_role_id
                    WHERE	
                        DATE(tr.request_date) LIKE '$date%'
                    -- AND (ur.level_sto <= '$level_sto' AND em.department_id IN ($department_id))
                    $kondisi

                    UNION

                    SELECT 
                        'Approval EAF',
                        COUNT(e_pengajuan.id_pengajuan) AS total,
                        COUNT(CASE WHEN e_pengajuan.`status` IN ( 1 ) THEN 1 END) AS undone
                    FROM e_eaf.e_pengajuan
                    LEFT JOIN e_eaf.e_approval AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                    LEFT JOIN hris.xin_employees AS usr_apr ON usr_apr.user_id = e_approval.id_user_approval
                    WHERE	
                        DATE(e_pengajuan.tgl_input) LIKE '$date%'
                    AND e_approval.id_user_approval = '$user_id'

                    UNION

                    SELECT 
                        'Complaints',
                        COUNT(t.id_task) AS total,
                        COUNT(CASE WHEN t.`status` IN ( 1,2,4,8,9 ) THEN 1 END) AS undone
                    FROM `cm_task` t
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    WHERE	
                        DATE(t.`end`) LIKE '$date%'
                    AND (FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' OR t.verified_by = '$user_id' OR t.escalation_by = '$user_id' OR c.head_id = '$user_id')

                    UNION

                    SELECT 
                        'Co n Co',
                        COUNT(coaching.id_coaching) AS total,
                        0 AS undone
                    FROM coaching
                    WHERE	
                        DATE(coaching.created_at) LIKE '$date%'
                    AND coaching.created_by = '$user_id'


                    UNION

                    SELECT 
                        'Gemba',
                        COUNT(gemba.id_gemba) AS total,
                        COUNT(CASE WHEN (item.total_progres = 100 OR gemba.evaluasi IS NOT NULL) THEN 1 END) AS undone
                    FROM gemba
                    JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                    WHERE	
                        DATE(gemba.tgl_plan) LIKE '$date%'
                    AND gemba.created_by = '$user_id'

                    UNION

                    SELECT 
                        'Renewal Contract',
                        COUNT(c.id) AS total,
                        COUNT(CASE WHEN c.`status` IS NULL THEN 1 END) AS undone
                    FROM (SELECT * FROM trusmi_renewal_contract GROUP BY employee_id) c
                    JOIN xin_employees e ON e.user_id = c.employee_id
                    LEFT JOIN xin_employee_contract contract ON (contract.employee_id = e.user_id AND contract.is_active = 1)

                    WHERE deadline IS NOT NULL
                    AND DATE(deadline) LIKE '$date%'
                    AND e.is_active = 1
                    AND COALESCE(contract.contract_type_id,'') <> 1
                    AND c.dept_head = $user_id
                    AND e.user_id != $user_id

                    UNION

                    SELECT 
                        'Jobdesk',
                        COUNT(momi.id) AS total,
                        COUNT(CASE WHEN task.`status` NOT IN (3) THEN 1 END) AS undone
                    FROM mom_issue_item momi
                    JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
                    LEFT JOIN xin_employees AS pic ON FIND_IN_SET( pic.user_id, momi.pic )

                    JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
                    JOIN td_task task ON task.id_task = stask.id_task
                    WHERE DATE(momi.deadline) LIKE '$date%'
                    AND momi.pic = $user_id
                    AND mom.meeting IN ('Jobdesk')

                    UNION

                    SELECT 
                        'T-Lock',
                        COUNT(locked.id) AS total,
                        COUNT(CASE WHEN locked.updated_at IS NULL THEN 1 END) AS undone
                    FROM trusmi_lock_absen_manual AS locked
                    WHERE	DATE(locked.created_at) LIKE '$date%'
                    AND (locked.employee_id = '$user_id')

                    UNION

                    SELECT 
                        'Tasklist GRD',
                        COUNT(task.id_tasklist) AS total,
                        COUNT(CASE WHEN task.`status` NOT IN (3,4) THEN 1 END) AS undone
                    FROM grd_t_tasklist AS task
                    WHERE	(DATE(task.`start`) LIKE '$date%' OR DATE(task.`end`) LIKE '$date%')
                    AND FIND_IN_SET('$user_id', task.pic) > 0


                    UNION

                    SELECT 
                        'Briefing',
                        COUNT(id_briefing) AS total,
                        0 AS undone
                    FROM briefing
                    WHERE	DATE(created_at) LIKE '$date%' 
                    AND briefing.created_by = $user_id

                    UNION

                    SELECT 
                        'Review Sistem',
                        COUNT(id) AS total,
                        COUNT(CASE WHEN rmi.pic_at IS NULL THEN 1 END) AS undone
                    FROM review_t_menu_item rmi
                    WHERE	DATE(deadline_pic) LIKE '$date%' 
                    AND rmi.pic = $user_id

                    UNION

                    SELECT 
                        'Approve Resignation',
                        COUNT(r.resignation_id) AS total,
                        COUNT(CASE WHEN ec.approved_at IS NULL THEN 1 END) AS undone
                    FROM xin_employee_resignations r
                    LEFT JOIN trusmi_exit_clearance ec ON ec.id_resignation = r.resignation_id
                    WHERE	resignation_date LIKE '$date%' 
                    AND ec.pic = '$user_id'
                ";

        return $this->db->query($query)->result();
    }

    public function get_task_pie($date, $user_id)
    {

        $get_level_sto = $this->db->query("SELECT e.ctm_posisi, e.department_id, r.level_sto FROM xin_employees e LEFT JOIN xin_user_roles r ON r.role_name = e.ctm_posisi WHERE e.user_id = '$user_id'")->row_array();
        $level_sto = $get_level_sto['level_sto'];
        $department_id = $get_level_sto['department_id'];

        if ($level_sto >= 4) { // kondisi jika level sto dari roles lebih atau sama dengan officer
            $kondisi = "AND em.department_id = '$department_id'
                    AND ur.level_sto < '$level_sto'";

            $kondisi2 = "AND (us.level_sto <= '$level_sto' AND l.department_id IN ($department_id))";
        } else { //kondisi user
            $kondisi = "AND tr.employee_id = $user_id";

            $kondisi2 = "AND l.employee_id = $user_id";
        }

        $query = "SELECT 
                    SUM(dt.total) as total,
                    SUM(dt.undone) as undone

                FROM 
                (
                    SELECT 
                        approval.*

                    FROM
                    (
                        SELECT 
                            'Approval' AS nama,
                            COUNT(*) AS total,
                        COUNT(CASE WHEN `status` = 1 THEN 1 END) AS undone
                        FROM trusmi_approval 
                        WHERE approve_to = $user_id
                        AND `created_at` LIKE '$date%'
                    ) approval

                    UNION

                    SELECT 
                        'IBR Pro' AS nama,
                        COUNT(*) AS total,
                        COUNT(CASE WHEN `status` IN (1,2) THEN 1 END) AS undone
                    FROM td_task 
                    WHERE FIND_IN_SET($user_id, pic) > 0
                    AND `due_date` LIKE '$date%'

                    UNION 

                    SELECT 
                        'Verifikasi IBR Pro',	
                        COUNT(sub.id_sub_task) AS total,
                        COUNT(CASE WHEN sub.verified_status IS NULL THEN 1 END) AS undone
                    FROM td_sub_task sub
                    LEFT JOIN td_task task ON task.id_task = sub.id_task
                    LEFT JOIN mom_issue_item item ON item.id_sub_task = sub.id_sub_task
                    WHERE FIND_IN_SET($user_id, task.created_by) > 0
                    AND task.`start` LIKE '$date%'

                    UNION 

                    SELECT 
                        'Verifikasi MoM',
                        COUNT(momi.id) AS total,
                        COUNT(CASE WHEN task.`status` = 3 THEN 1 END) AS undone
                    FROM mom_issue_item momi
                    JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
                    JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
                    JOIN td_task task ON task.id_task = stask.id_task
                    WHERE	
                        momi.verified_status IS NULL
                    AND DATE(mom.created_at) LIKE '$date%'
                    AND mom.created_by = $user_id
                    AND mom.meeting NOT IN ('Jobdesk')
                    AND momi.is_eskalasi IS NULL

                    UNION

                    SELECT 
                        'Approve Mng Leave',
                        COUNT(l.leave_id) AS total,
                        COUNT(CASE WHEN l.`status` = '1' THEN 1 END) AS undone
                    FROM xin_leave_applications l
                    LEFT JOIN xin_employees c ON c.user_id = l.employee_id
                    LEFT JOIN xin_user_roles us ON us.role_name = c.ctm_posisi
                    WHERE	
                        DATE(l.from_date) LIKE '$date%'
                    -- AND (us.level_sto <= '$level_sto' AND l.department_id IN ($department_id))
                    $kondisi2

                    UNION

                    SELECT 
                        'Approve Overtime',
                        COUNT(tr.time_request_id) AS total,
                        COUNT(CASE WHEN tr.is_approved = 1 THEN 1 END) AS undone
                    FROM xin_attendance_time_request tr
                    JOIN xin_employees em ON em.user_id = tr.employee_id
                    LEFT JOIN xin_user_roles ur ON ur.role_id = em.user_role_id
                    WHERE	
                        DATE(tr.request_date) LIKE '$date%'
                    -- AND (ur.level_sto <= '$level_sto' AND em.department_id IN ($department_id))
                    $kondisi

                    UNION

                    SELECT 
                        'Approval EAF',
                        COUNT(e_pengajuan.id_pengajuan) AS total,
                        COUNT(CASE WHEN e_pengajuan.`status` IN ( 1 ) THEN 1 END) AS undone
                    FROM e_eaf.e_pengajuan
                    LEFT JOIN e_eaf.e_approval AS e_approval ON e_approval.id_pengajuan = e_pengajuan.id_pengajuan
                    LEFT JOIN hris.xin_employees AS usr_apr ON usr_apr.user_id = e_approval.id_user_approval
                    WHERE	
                        DATE(e_pengajuan.tgl_input) LIKE '$date%'
                    AND e_approval.id_user_approval = '$user_id'

                    UNION

                    SELECT 
                        'Complaints',
                        COUNT(t.id_task) AS total,
                        COUNT(CASE WHEN t.`status` IN ( 1,2,4,8,9 ) THEN 1 END) AS undone
                    FROM `cm_task` t
                    LEFT JOIN cm_status s ON s.id = t.`status`
                    LEFT JOIN cm_category c ON c.id = t.id_category
                    WHERE	
                        DATE(t.`end`) LIKE '$date%'
                    AND (FIND_IN_SET( '$user_id', t.pic ) OR t.created_by = '$user_id' OR t.verified_by = '$user_id' OR t.escalation_by = '$user_id' OR c.head_id = '$user_id')

                    UNION

                    SELECT 
                        'Co n Co',
                        COUNT(coaching.id_coaching) AS total,
                        0 AS undone
                    FROM coaching
                    WHERE	
                        DATE(coaching.created_at) LIKE '$date%'
                    AND coaching.created_by = '$user_id'


                    UNION

                    SELECT 
                        'Gemba',
                        COUNT(gemba.id_gemba) AS total,
                        COUNT(CASE WHEN (item.total_progres = 100 OR gemba.evaluasi IS NOT NULL) THEN 1 END) AS undone
                    FROM gemba
                    JOIN ( SELECT id_gemba, COUNT( IF ( `status` IS NULL, 1, NULL )) AS total_progres FROM gemba_item GROUP BY id_gemba ) AS item ON item.id_gemba = gemba.id_gemba
                    WHERE	
                        DATE(gemba.tgl_plan) LIKE '$date%'
                    AND gemba.created_by = '$user_id'

                    UNION

                    SELECT 
                        'Renewal Contract',
                        COUNT(c.id) AS total,
                        COUNT(CASE WHEN c.`status` IS NULL THEN 1 END) AS undone
                    FROM (SELECT * FROM trusmi_renewal_contract GROUP BY employee_id) c
                    JOIN xin_employees e ON e.user_id = c.employee_id
                    LEFT JOIN xin_employee_contract contract ON (contract.employee_id = e.user_id AND contract.is_active = 1)

                    WHERE deadline IS NOT NULL
                    AND DATE(deadline) LIKE '$date%'
                    AND e.is_active = 1
                    AND COALESCE(contract.contract_type_id,'') <> 1
                    AND c.dept_head = $user_id
                    AND e.user_id != $user_id

                    UNION

                    SELECT 
                        'Jobdesk',
                        COUNT(momi.id) AS total,
                        COUNT(CASE WHEN task.`status` NOT IN (3) THEN 1 END) AS undone
                    FROM mom_issue_item momi
                    JOIN mom_header AS mom ON mom.id_mom = momi.id_mom
                    LEFT JOIN xin_employees AS pic ON FIND_IN_SET( pic.user_id, momi.pic )

                    JOIN td_sub_task AS stask ON stask.id_sub_task = momi.id_sub_task
                    JOIN td_task task ON task.id_task = stask.id_task
                    WHERE DATE(momi.deadline) LIKE '$date%'
                    AND momi.pic = $user_id
                    AND mom.meeting IN ('Jobdesk')

                    UNION

                    SELECT 
                        'T-Lock',
                        COUNT(locked.id) AS total,
                        COUNT(CASE WHEN locked.updated_at IS NULL THEN 1 END) AS undone
                    FROM trusmi_lock_absen_manual AS locked
                    WHERE	DATE(locked.created_at) LIKE '$date%'
                    AND (locked.employee_id = '$user_id')

                    UNION

                    SELECT 
                        'Tasklist GRD',
                        COUNT(task.id_tasklist) AS total,
                        COUNT(CASE WHEN task.`status` NOT IN (3,4) THEN 1 END) AS undone
                    FROM grd_t_tasklist AS task
                    WHERE	(DATE(task.`start`) LIKE '$date%' OR DATE(task.`end`) LIKE '$date%')
                    AND FIND_IN_SET('$user_id', task.pic) > 0


                    UNION

                    SELECT 
                        'Briefing',
                        COUNT(id_briefing) AS total,
                        0 AS undone
                    FROM briefing
                    WHERE	DATE(created_at) LIKE '$date%' 
                    AND briefing.created_by = $user_id

                    UNION

                    SELECT 
                        'Review Sistem',
                        COUNT(id) AS total,
                        COUNT(CASE WHEN rmi.pic_at IS NULL THEN 1 END) AS undone
                    FROM review_t_menu_item rmi
                    WHERE	DATE(deadline_pic) LIKE '$date%' 
                    AND rmi.pic = $user_id

                    UNION

                    SELECT 
                        'Approve Resignation',
                        COUNT(r.resignation_id) AS total,
                        COUNT(CASE WHEN ec.approved_at IS NULL THEN 1 END) AS undone
                    FROM xin_employee_resignations r
                    LEFT JOIN trusmi_exit_clearance ec ON ec.id_resignation = r.resignation_id
                    WHERE	resignation_date LIKE '$date%' 
                    AND ec.pic = '$user_id'
                ) dt
                ";

        return $this->db->query($query)->result();
    }

    public function lock_running($id, $status)
    {
        $curdate = date('Y-m-d');
        $query    = $this->db->query("CALL dashboard_todo_today($id)");
        return $query->result();
        // $query = "SELECT
        //         * 
        // FROM
        //     `view_dashboard_todo` 
        // WHERE
        //     user_id = $id
        //     AND status_lock = '$status'
        //     AND end_date = CURDATE()";

        // return  $this->db->query($query)->result();
    }

    public function lock_history($id)
    {
        $query = "SELECT
        m_lock.status_lock AS category,
        h.reason AS description,
        DATE_FORMAT( h.created_at, '%d %b %Y' ) AS tgl,
        h.employee_id,
        CONCAT( e.first_name, ' ', e.last_name ) AS employee_name,
        h.reason
    FROM
        trusmi_history_lock h
        LEFT JOIN trusmi_m_lock m_lock ON m_lock.id_lock = h.lock_type
        LEFT JOIN xin_employees e ON e.user_id = h.employee_id 
    WHERE
        SUBSTR( h.created_at, 1, 10 ) BETWEEN DATE_FORMAT( DATE_SUB( CURRENT_DATE (), INTERVAL 1 MONTH ), '%Y-%m-21' ) 
        AND DATE_FORMAT( CURRENT_DATE (), '%Y-%m-20' ) 
        AND h.employee_id = $id
    GROUP BY
        h.employee_id,
        SUBSTR( h.created_at, 1, 10 ),
        h.reason 
    ORDER BY
        h.created_at DESC";

        return  $this->db->query($query)->result();
    }

    public function today_progress($id)
    {
//         $query = "SELECT 
// 	user_id,
// 	category,
// 	sum(IF(progres > 0,1,0)) as progress,
// 	count(category) as total,
// 	COALESCE(ROUND(sum(IF(progres > 0,1,0)) / count(category) * 100),0) AS percent,
// 	status_lock,
// 	revisi
// FROM 
// `view_dashboard_todo`
// WHERE
// 	category in (
// 		'Tasklist IBR Pro',
// 		'Verifikasi IBR Pro',
// 		'Verifikasi Mom',
// 		'Jobdesk',
// 		'Co & Co',
// 		'Approve Resignation',
// 		'Renewal Contract',
// 		'T-Lock',
// 		'Approval',
//         'Review Sistem'
// 	) 
// 	AND end_date = CURDATE() AND user_id = $id
// GROUP BY category";

//         return  $this->db->query($query)->result();

        if ($id == '803') {
            $query = $this->db->query("CALL dashboard_todo_today_super($id)");
        } else {
            $query = $this->db->query("CALL dashboard_todo_today($id)");
        }
        
        $data = $query->result_array();

        $summary = [];

        foreach ($data as $item) {
            $key = $item['user_id'] . '_' . $item['category'];

            // Inisialisasi jika belum ada
            if (!isset($summary[$key])) {
                $summary[$key] = [
                    'user_id' => $item['user_id'],
                    'category' => $item['category'],
                    'progress' => 0,
                    'total' => 0,
                    'status_lock' => $item['status_lock'],
                    'revisi' => $item['revisi']
                ];
            }

            // Tambah total task
            $summary[$key]['total'] += 1;

            // Tambah progress jika progress == 100
            if ((int)$item['progress'] == 100) {
                $summary[$key]['progress'] += 1;
            }
        }

        // Hitung persentase
        foreach ($summary as &$s) {
            $s['percent'] = (string) round(($s['progress'] / $s['total']) * 100);
            $s['progress'] = (string) $s['progress'];
            $s['total'] = (string) $s['total'];
        }

        return array_values($summary);
    }

}
