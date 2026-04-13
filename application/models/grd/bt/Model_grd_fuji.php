<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_grd_fuji extends CI_Model
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

	function cek_department($user_id)
	{
		$query = "SELECT department_id, company_id, date_of_joining FROM xin_employees WHERE user_id = $user_id LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	public function get_header_milestone($id_milestone)
	{
		$query = "SELECT 
						comp.`name` AS nama_company,
						id,
						mile.milestone, 
						`start`, 
						`end`, 
						progress AS progress_old,
						CASE 
							WHEN progress < 60 THEN 'FD97A4'
							WHEN progress BETWEEN 60 AND 75 THEN 'FFE97B'
						ELSE 'BFEC78'
						END AS warna,
						-- COALESCE(SUM(prg.persen),0) AS progress
						ROUND(COALESCE(SUM(prg.persen),0) / COALESCE(COUNT(prg.id_tasklist),0)) AS progress
					FROM grd_m_milestone mile
					LEFT JOIN (
						SELECT
							tm.id_tasklist,
							tm.divisi,
							tm.id_milestone,
							m.milestone,
							COALESCE(tm.target, 0),
							COALESCE(tm.actual, 0) AS actual,
							-- ROUND(COALESCE(tm.actual, 0)/COALESCE(tm.target, 0) * 100,0) AS persen
							actual_milestone_p AS persen

						FROM
							grd_t_tasklist_milestone tm 
						LEFT JOIN grd_m_milestone m ON m.id = tm.id_milestone
					) prg ON prg.id_milestone = mile.id

					LEFT JOIN xin_companies comp ON comp.company_id = mile.id_company
					WHERE id = '$id_milestone'

					GROUP BY mile.id";

		return $this->db->query($query)->row_object();
	}

	public function get_tasklist_milestone($id_milestone)
	{
		$query = "SELECT 
						id_tasklist,
						divisi,
						task.id_milestone,
						mile.milestone,
						CONCAT( pic.first_name, ' ', pic.last_name ) AS pic,
						COALESCE ( SUBSTR( task.`start`, 1, 10 ), '' ) AS `start`,
						COALESCE ( SUBSTR( task.`end`, 1, 10 ), '' ) AS `end`,
						task.detail,
						task.output,
						task.target,
						CONCAT( emp.first_name, ' ', emp.last_name ) AS created_by,
						task.`status`,
						st.nama AS nama_status,
						st.warna,
						st.warna2,
						task.actual,
						task.note,
						task.evidence,
						COALESCE ( SUBSTR( task.done_at, 1, 10 ), '' ) AS done_at,
						task.target_milestone_type,
						task.actual_milestone_type


				FROM grd_t_tasklist_milestone task
				LEFT JOIN grd_m_milestone mile ON mile.id = task.id_milestone
				LEFT JOIN xin_employees pic ON pic.user_id = task.pic
				LEFT JOIN xin_employees emp ON emp.user_id = task.created_by
				LEFT JOIN m_pekerjaan_status st ON st.id = task.`status`

				WHERE task.id_milestone = '$id_milestone'
		";
		return $this->db->query($query)->result();
	}

	public function get_tasklist($id_tasklist)
	{
		$query = "SELECT 
						id_tasklist,
						divisi,
						task.id_milestone,
						mile.milestone,
						CONCAT( pic.first_name, ' ', pic.last_name ) AS pic,
						COALESCE ( SUBSTR( task.`start`, 1, 10 ), '' ) AS `start`,
						COALESCE ( SUBSTR( task.`end`, 1, 10 ), '' ) AS `end`,
						task.detail,
						task.output,
						task.target,
						CONCAT( emp.first_name, ' ', emp.last_name ) AS created_by,
						task.`status`,
						st.nama AS nama_status,
						st.warna,
						st.warna2,
						task.actual,
						task.note,
						task.evidence,
						COALESCE ( SUBSTR( task.done_at, 1, 10 ), '' ) AS done_at

				FROM grd_t_tasklist_milestone task
				LEFT JOIN grd_m_milestone mile ON mile.id = task.id_milestone
				LEFT JOIN xin_employees pic ON pic.user_id = task.pic
				LEFT JOIN xin_employees emp ON emp.user_id = task.created_by
				LEFT JOIN m_pekerjaan_status st ON st.id = task.`status`

				WHERE task.id_tasklist = '$id_tasklist'
		";
		return $this->db->query($query)->row_object();
	}

	function data_goal($divisi, $month)
	{
		$monthNumber = substr($month, 0, 2);
		$year = substr($month, 3, 4);

		$sql = "SELECT
					comp.`name` AS company,
					goal.id_goal,
					goal.nama_goal,
					goal.target,
					goal.actual,
					ROUND(((goal.actual / goal.target) * 100),1) AS prs,
					CASE 
						WHEN ROUND(((goal.actual / goal.target) * 100),1) < 60 THEN 'danger'
						WHEN ROUND(((goal.actual / goal.target) * 100),1) BETWEEN 60 AND 75 THEN 'warning'
						ELSE 'success'
					END AS warna,

					COUNT(DISTINCT si.id_si) AS total_si,
					ROUND(COALESCE(SUM(
							CASE 
								WHEN progress.total_target = 0 THEN 0 
								ELSE progress.total_actual / progress.total_target * 100 
							END
					) / COUNT(DISTINCT si.id_si), 0), 1) AS progress_si,
					
					COALESCE(SUM(progress.total_tasklist),0) AS total_tasklist,
					ROUND(COALESCE(SUM(
							CASE 
								WHEN progress.total_target = 0 THEN 0 
								ELSE progress.total_actual / progress.total_target * 100 
							END
					) / SUM(progress.total_tasklist), 0), 1) AS progress_tasklist,

					-- Calculate Done PRS (Capped at 100%)
					ROUND(COALESCE(
						CASE 
							WHEN ROUND(((goal.actual / goal.target) * 100),1) > 100 THEN 100
							ELSE ROUND(((goal.actual / goal.target) * 100),1)
						END
					, 0),2) AS done_prs,

					-- Calculate Not Started PRS (100 - Progress, with min 0)
					ROUND(COALESCE(
						CASE 
							WHEN ROUND(((goal.actual / goal.target) * 100),1) > 100 THEN 0
							ELSE 100 - ROUND(((goal.actual / goal.target) * 100),1)
						END
					, 0),2) AS not_started_prs
					
				FROM
					grd_m_goal AS goal
				LEFT JOIN xin_companies AS comp ON goal.id_company = comp.company_id

				LEFT JOIN grd_m_so AS so ON so.id_goal = goal.id_goal
				LEFT JOIN grd_t_si AS si ON si.id_so = so.id_so
				
				LEFT JOIN (
						SELECT 
								id_si, 
								SUM(target) AS total_target, 
								SUM(actual) AS total_actual,
								COUNT(id_tasklist) AS total_tasklist
						FROM grd_t_tasklist
						GROUP BY id_si
				) AS progress ON progress.id_si = si.id_si
				

				WHERE goal.divisi = '$divisi'
					-- AND MONTH(goal.created_at) = '$monthNumber' AND YEAR(goal.created_at) = '$year'	
					AND (MONTH(goal.startdate) = '$monthNumber' AND YEAR(goal.startdate) = '$year') OR (MONTH(goal.enddate) = '$monthNumber' AND YEAR(goal.enddate) = '$year')
				GROUP BY goal.id_goal
				";

		return $this->db->query($sql)->result();
	}

	function data_so($divisi, $month)
	{
		$monthNumber = substr($month, 0, 2);
		$year = substr($month, 3, 4);

		$sql = "SELECT
					so.id_so, 
					so.id_goal, 
					goal.nama_goal,
					so.so, 
					so.id_company, 
					so.divisi,

					DATE_FORMAT(so.`start`, '%d-%m-%Y %H:%i') AS `start_so_satuan`,
					DATE_FORMAT(so.`end`, '%d-%m-%Y %H:%i') AS `end_so_satuan`,
					CONCAT(
						TIMESTAMPDIFF(DAY, so.`start`, so.`done_at`), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, so.`start`, so.`done_at`), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, so.`start`, so.`done_at`), 60), ' m'
					) AS leadtime_so,
					GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
					COALESCE(so.evidence, '-') AS evidence,
					so.`status`,
					COALESCE(so.target_so, '-') AS target,
					COALESCE(so.actual_so, '-') AS actual,
					COALESCE(so.output, '-') AS output,

					
					COALESCE(LEFT(so.done_at, 10), '-') AS done_at,
					st.nama AS nama_status,

					so.created_at, 
					so.created_by, 
					so.deleted_at, 
					so.updated_at, 
					so.updated_by,
					COALESCE(MIN(DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i')),'-') AS start,
					COALESCE(MAX(DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i')),'-') AS end,
					CONCAT(
						TIMESTAMPDIFF(DAY, MIN(`task`.`start`), MAX(`task`.`done_at`)), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, MIN(`task`.`start`), MAX(`task`.`done_at`)), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, MIN(`task`.`start`), MAX(`task`.`done_at`)), 60), ' m'
					) AS leadtime,
					-- CASE
					-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) > 100 THEN 100
					-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) <= 0 THEN 0
					-- ELSE ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1)
					-- END AS progress_so_satuan,
					-- CASE
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) > 100 THEN 100
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) <= 0 THEN 0
					-- ELSE ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1)
					-- END AS progress_so,

					-- ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) AS progress_so,

					-- CASE 
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) < 60 THEN 'danger'
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) BETWEEN 60 AND 75 THEN 'warning'
					-- 	ELSE 'success'
					-- END AS warna 
					
					ROUND(COALESCE(so.actual_so_p, 0), 1) AS progress_so_satuan,
					-- ROUND(COALESCE(total_actual_si_p,0), 1) AS progress_so,
					CASE
						WHEN ROUND(COALESCE(progress.total_actual_si_p / progress.total_actual_si * 100, 0), 1) > 100 THEN 100
						WHEN ROUND(COALESCE(progress.total_actual_si_p / progress.total_actual_si * 100, 0), 1) <= 0 THEN 0
					ELSE ROUND(COALESCE(progress.total_actual_si_p / progress.total_actual_si * 100, 0), 1)
					END AS progress_so,
					CASE 
						WHEN ROUND(COALESCE(total_actual_si_p,0), 1) < 60 THEN 'danger'
						WHEN ROUND(COALESCE(total_actual_si_p,0), 1) BETWEEN 60 AND 75 THEN 'warning'
						ELSE 'success'
					END AS warna 
				FROM
					grd_m_so AS so
				LEFT JOIN grd_m_goal AS goal ON so.id_goal = goal.id_goal
				LEFT JOIN grd_t_si AS si ON si.id_so = so.id_so
				LEFT JOIN grd_t_tasklist AS task ON task.id_si = si.id_si

				LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id, so.pic)
				LEFT JOIN m_pekerjaan_status st ON st.id = so.status

				LEFT JOIN (
					SELECT id_so, SUM(target) AS total_target, SUM(actual) AS total_actual,
					COUNT(grd_t_si.id_si) AS total_actual_si,
					SUM(actual_si_p) AS total_actual_si_p
					FROM grd_t_tasklist
					JOIN grd_t_si ON grd_t_tasklist.id_si = grd_t_si.id_si
					GROUP BY id_so
				) AS progress ON progress.id_so = so.id_so
				WHERE goal.divisi = 'Operasional'
					-- AND MONTH(so.created_at) = '$monthNumber' AND YEAR(so.created_at) = '$year'	
					AND (MONTH(so.start) = '$monthNumber' AND YEAR(so.start) = '$year') OR (MONTH(so.end) = '$monthNumber' AND YEAR(so.end) = '$year')

				
				GROUP BY so.id_so
				";

		return $this->db->query($sql)->result();
	}

	function data_si($divisi, $month)
	{
		$monthNumber = substr($month, 0, 2);
		$year = substr($month, 3, 4);

		$sql = "SELECT
					si.id_si, 
					si.id_so, 
					goal.nama_goal,
					so.so,
					si.si, 

					DATE_FORMAT(si.`start`, '%d-%m-%Y %H:%i') AS `start_si_satuan`,
					DATE_FORMAT(si.`end`, '%d-%m-%Y %H:%i') AS `end_si_satuan`,
					CONCAT(
						TIMESTAMPDIFF(DAY, si.`start`, si.`done_at`), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, si.`start`, si.`done_at`), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, si.`start`, si.`done_at`), 60), ' m'
					) AS leadtime_si,
					GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
					COALESCE(si.evidence, '-') AS evidence,
					si.`status`,
					COALESCE(si.target_si, '-') AS target,
					COALESCE(si.actual_si, '-') AS actual,
					COALESCE(si.output, '-') AS output,

					CASE
						WHEN ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1) > 100 THEN 100
						WHEN ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1) <= 0 THEN 0
					ELSE ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1)
					END AS progress_si_satuan,
					COALESCE(LEFT(so.done_at, 10), '-') AS done_at,
					st.nama AS nama_status,

					si.created_at, 
					si.created_by, 
					si.deleted_at, 
					si.updated_at, 
					si.updated_by,
					COALESCE(MIN(DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i')),'-') AS start,
					COALESCE(MAX(DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i')),'-') AS end,
					CONCAT(
						TIMESTAMPDIFF(DAY, MIN(`task`.`start`), MAX(`task`.`done_at`)), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, MIN(`task`.`start`), MAX(`task`.`done_at`)), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, MIN(`task`.`start`), MAX(`task`.`done_at`)), 60), ' m'
					) AS leadtime,

					-- CASE
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) > 100 THEN 100
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) <= 100 THEN 0
					-- ELSE ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1)
					-- END AS progress_si,

					-- ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) AS progress_si,

					ROUND(COALESCE(total_actual_si_p,0), 1) AS progress_si,


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
										
                    '0' AS training,
                    'secondary' AS warna_training
				FROM
					grd_t_si AS si
				LEFT JOIN grd_m_so AS so ON si.id_so = so.id_so
				LEFT JOIN grd_m_goal AS goal ON so.id_goal = goal.id_goal
				LEFT JOIN grd_t_tasklist AS task ON task.id_si = si.id_si

				LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id, si.pic)
				LEFT JOIN m_pekerjaan_status st ON st.id = si.status

				LEFT JOIN (
					SELECT 
							grd_t_si.id_si, 
							SUM(target) AS total_target, 
							SUM(actual) AS total_actual,
							SUM(actual_si_p) AS total_actual_si_p

					FROM grd_t_tasklist
					JOIN grd_t_si ON grd_t_tasklist.id_si = grd_t_si.id_si
					GROUP BY id_si
				) AS progress ON progress.id_si = si.id_si

				LEFT JOIN (
					SELECT 
						chat.divisi, 
						chat.so, 
						chat.si, 
						task.id_tasklist,
						COUNT(id_chat) AS jumlah
					FROM rsp_project_live.t_chat_bm chat
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,chat.tasklist)
					WHERE chat.divisi = 'Operasional'
						AND MONTH(chat.created_at) = '2' AND YEAR(chat.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) tt ON tt.divisi = task.divisi 
					AND tt.so = si.id_so
					AND tt.si = si.id_si
					AND task.id_tasklist = tt.id_tasklist
											
				LEFT JOIN (
					SELECT 
						mom_header.divisi, 
						mom_header.so, 
						mom_header.si, 
						task.id_tasklist,
						COUNT(id_mom) AS jumlah
					FROM mom_header
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,mom_header.tasklist)
					WHERE mom_header.divisi = 'Operasional'
						AND MONTH(mom_header.created_at) = '2' AND YEAR(mom_header.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) mom ON mom.divisi = task.divisi
					AND mom.so = si.id_so
					AND mom.si = si.id_si
					AND task.id_tasklist = mom.id_tasklist
											
				LEFT JOIN (
					SELECT 
						cm_task.divisi, 
						cm_task.so, 
						cm_task.si, 
						task.id_tasklist,
						COUNT(id_task) AS jumlah
					FROM cm_task
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,cm_task.tasklist)
					WHERE cm_task.divisi = 'Operasional'
						AND MONTH(cm_task.created_at) = '2' AND YEAR(cm_task.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) comp ON comp.divisi = task.divisi
					AND comp.so = si.id_so
					AND comp.si = si.id_si
					AND task.id_tasklist = comp.id_tasklist
											
				LEFT JOIN (
					SELECT 
						gemba.divisi, 
						gemba.so, 
						gemba.si, 
						task.id_tasklist,
						COUNT(id_gemba) AS jumlah
					FROM gemba
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,gemba.tasklist)
					WHERE gemba.divisi = 'Operasional'
						AND MONTH(gemba.created_at) = '2' AND YEAR(gemba.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) gen ON gen.divisi = task.divisi 
					AND gen.so = si.id_so
					AND gen.si = si.id_si
					AND task.id_tasklist = gen.id_tasklist
											
				LEFT JOIN (
					SELECT 
						coaching.divisi, 
						coaching.so, 
						coaching.si, 
						task.id_tasklist,
						COUNT(id_coaching) AS jumlah
					FROM coaching
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,coaching.tasklist)
					WHERE coaching.divisi = 'Operasional'
						AND MONTH(coaching.created_at) = '2' AND YEAR(coaching.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) coac ON coac.divisi = task.divisi
					AND coac.so = si.id_so
					AND coac.si = si.id_si
					AND task.id_tasklist = coac.id_tasklist
											
				LEFT JOIN (
					SELECT 
						td_task.divisi, 
						td_task.so, 
						td_task.si, 
						task.id_tasklist,
						COUNT(sub.id_task) AS jumlah
					FROM td_task
					JOIN td_sub_task sub ON td_task.id_task = sub.id_task
					JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,td_task.tasklist)
					WHERE td_task.divisi = 'Operasional'
						AND MONTH(td_task.created_at) = '2' AND YEAR(td_task.created_at) = '2025'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) ibr ON ibr.divisi = task.divisi 
					AND ibr.so = si.id_so
					AND ibr.si = si.id_si
					AND task.id_tasklist = ibr.id_tasklist

				WHERE goal.divisi = 'Operasional'
					-- AND MONTH(si.created_at) = '$monthNumber' AND YEAR(si.created_at) = '$year'	
					AND (MONTH(si.start) = '$monthNumber' AND YEAR(si.start) = '$year') OR (MONTH(si.end) = '$monthNumber' AND YEAR(si.end) = '$year')

				GROUP BY si.id_si
				";

		return $this->db->query($sql)->result();
	}

	function data_tasklist($divisi, $month)
	{
		$monthNumber = substr($month, 0, 2);
		$year = substr($month, 3, 4);

		$sql = "SELECT
					goal.nama_goal,
										
                    so.id_so,
                    so.so,
					si.id_si,
                    si.si,
                    task.id_tasklist,
                    task.detail,
                    task.divisi,
					DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i') AS `start`,
                    DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i') AS `end`,
					CONCAT(
						TIMESTAMPDIFF(DAY, `task`.`start`, `task`.`done_at`), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, `task`.`start`, `task`.`done_at`), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, `task`.`start`, `task`.`done_at`), 60), ' m'
					) AS leadtime,
                    GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
                    COALESCE(task.evidence, '-') AS evidence,
                    task.`status`,
                    COALESCE(task.target, '-') AS target,
                    COALESCE(task.actual, '-') AS actual,
                    COALESCE(task.output, '-') AS output,

					CASE
						WHEN ROUND(COALESCE(task.actual / task.target * 100, 0), 1) > 100 THEN 100
						WHEN ROUND(COALESCE(task.actual / task.target * 100, 0), 1) <= 0 THEN 0
					ELSE ROUND(COALESCE(task.actual / task.target * 100, 0), 1)
					END AS progress_tasklist,

					-- ROUND(COALESCE(task.actual / task.target * 100, 0), 1) AS progress_tasklist,
										
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
										
                    '0' AS training,
                    'secondary' AS warna_training,
                    COALESCE(LEFT(task.done_at, 10), '-') AS done_at,
                    st.nama AS nama_status,
                    st.warna
                    -- CASE 
                    --     WHEN task.done_at IS NULL THEN DATEDIFF(task.`end`, CURDATE())
                    --     ELSE '-'
                    -- END AS leadtime
                FROM
                    grd_t_tasklist task
                    LEFT JOIN grd_t_si si ON si.id_si = task.id_si
                    LEFT JOIN grd_m_so so ON so.id_so = si.id_so
                    LEFT JOIN grd_m_goal goal ON goal.id_goal = so.id_goal
										
                    LEFT JOIN xin_employees emp ON emp.user_id = so.created_by
                    LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id, task.pic)
                    LEFT JOIN m_pekerjaan_status st ON st.id = task.status
										
                    LEFT JOIN (
                        SELECT 
                            chat.divisi, 
                            chat.so, 
                            chat.si, 
                            task.id_tasklist,
                            COUNT(id_chat) AS jumlah
                        FROM rsp_project_live.t_chat_bm chat
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,chat.tasklist)
                        WHERE chat.divisi = 'Operasional'
							AND MONTH(chat.created_at) = '2' AND YEAR(chat.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) tt ON tt.divisi = task.divisi 
                        AND tt.so = si.id_so
                        AND tt.si = si.id_si
                        AND task.id_tasklist = tt.id_tasklist
												
                    LEFT JOIN (
                        SELECT 
                            mom_header.divisi, 
                            mom_header.so, 
                            mom_header.si, 
                            task.id_tasklist,
                            COUNT(id_mom) AS jumlah
                        FROM mom_header
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,mom_header.tasklist)
                        WHERE mom_header.divisi = 'Operasional'
							AND MONTH(mom_header.created_at) = '2' AND YEAR(mom_header.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) mom ON mom.divisi = task.divisi
                        AND mom.so = si.id_so
                        AND mom.si = si.id_si
                        AND task.id_tasklist = mom.id_tasklist
												
                    LEFT JOIN (
                        SELECT 
                            cm_task.divisi, 
                            cm_task.so, 
                            cm_task.si, 
                            task.id_tasklist,
                            COUNT(id_task) AS jumlah
                        FROM cm_task
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,cm_task.tasklist)
                        WHERE cm_task.divisi = 'Operasional'
                            AND MONTH(cm_task.created_at) = '2' AND YEAR(cm_task.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) comp ON comp.divisi = task.divisi
                        AND comp.so = si.id_so
                        AND comp.si = si.id_si
                        AND task.id_tasklist = comp.id_tasklist
												
                    LEFT JOIN (
                        SELECT 
                            gemba.divisi, 
                            gemba.so, 
                            gemba.si, 
                            task.id_tasklist,
                            COUNT(id_gemba) AS jumlah
                        FROM gemba
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,gemba.tasklist)
                        WHERE gemba.divisi = 'Operasional'
                            AND MONTH(gemba.created_at) = '2' AND YEAR(gemba.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) gen ON gen.divisi = task.divisi 
                        AND gen.so = si.id_so
                        AND gen.si = si.id_si
                        AND task.id_tasklist = gen.id_tasklist
												
                    LEFT JOIN (
                        SELECT 
                            coaching.divisi, 
                            coaching.so, 
                            coaching.si, 
                            task.id_tasklist,
                            COUNT(id_coaching) AS jumlah
                        FROM coaching
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,coaching.tasklist)
                        WHERE coaching.divisi = 'Operasional'
                            AND MONTH(coaching.created_at) = '2' AND YEAR(coaching.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) coac ON coac.divisi = task.divisi
                        AND coac.so = si.id_so
                        AND coac.si = si.id_si
                        AND task.id_tasklist = coac.id_tasklist
												
                    LEFT JOIN (
                        SELECT 
                            td_task.divisi, 
                            td_task.so, 
                            td_task.si, 
                            task.id_tasklist,
                            COUNT(sub.id_task) AS jumlah
                        FROM td_task
                        JOIN td_sub_task sub ON td_task.id_task = sub.id_task
                        JOIN hris.grd_t_tasklist task ON FIND_IN_SET(task.id_tasklist,td_task.tasklist)
                        WHERE td_task.divisi = 'Operasional'
                            AND MONTH(td_task.created_at) = '2' AND YEAR(td_task.created_at) = '2025'
                        GROUP BY task.id_tasklist
                    ) ibr ON ibr.divisi = task.divisi 
                        AND ibr.so = si.id_so
                        AND ibr.si = si.id_si
                        AND task.id_tasklist = ibr.id_tasklist
                WHERE
                    task.divisi = 'Operasional' 
						-- AND MONTH(task.created_at) = '$monthNumber' AND YEAR(task.created_at) = '$year'	
						AND (MONTH(task.start) = '$monthNumber' AND YEAR(task.start) = '$year') OR (MONTH(task.end) = '$monthNumber' AND YEAR(task.end) = '$year')
                GROUP BY
                    task.id_tasklist
				";

		return $this->db->query($sql)->result();
	}

	public function get_header_detail($id_tasklist)
	{
		$query = "SELECT
					so.id_goal,
					`so`.`id_so`,
					`si`.`id_si`,
					`task`.`id_tasklist`,
					`so`.`id_company`,
					`comp`.`name` AS `company_name`,
					goal.nama_goal,
					`so`.`so`,
					`si`.`si`,
					`task`.`detail`,
					DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i') AS `start`,
					DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i') AS `end`,
					group_concat( DISTINCT concat( `pic`.`first_name`, ' ', `pic`.`last_name` ) SEPARATOR ', ' ) AS `pic`,
					`task`.`evidence` AS `evidence`,
					`task`.`status` AS `status`,
					`task`.`target` AS `target`,
					COALESCE ( `task`.`actual`, 0 ) AS `actual`,
					`task`.`output` AS `output`,
					`st`.`nama` AS `nama_status`,
					`st`.`warna` AS `warna`,
					`st`.`warna2` AS `warna2`,
					`so`.`created_at` AS `created_at`,
					concat( `emp`.`first_name`, ' ', `emp`.`last_name` ) AS `created_by`,(
					CASE
						WHEN ( `task`.`status` = 3 ) THEN
						100 ELSE 0 
					END 
					) AS `progres_persen`,
					`task`.`divisi` AS `divisi`,
					`task`.`done_at` AS `done_at` 
					FROM
						(((((((
													`grd_m_so` `so`
													JOIN `xin_companies` `comp` ON ((
															`comp`.`company_id` = `so`.`id_company` 
														)))
												LEFT JOIN `grd_t_si` `si` ON ((
														`so`.`id_so` = `si`.`id_so` 
													)))
											LEFT JOIN `grd_t_tasklist` `task` ON ((
													`task`.`id_si` = `si`.`id_si` 
												)))
										LEFT JOIN `xin_employees` `emp` ON ((
												`emp`.`user_id` = `so`.`created_by` 
											)))
									LEFT JOIN `xin_employees` `pic` ON ((
										0 <> find_in_set( `pic`.`user_id`, `task`.`pic` ))))
								LEFT JOIN `m_pekerjaan_status` `st` ON ((
										`st`.`id` = `task`.`status` 
									)))
								LEFT JOIN grd_m_goal goal ON (
									goal.id_goal = so.id_goal
								)
							) 
					WHERE id_tasklist = '$id_tasklist'
					GROUP BY
						`task`.`id_tasklist`,
						`si`.`id_si`
					";

		return $this->db->query($query)->row_object();
	}

	public function get_history($id)
	{
		$query = "SELECT
					DATE_FORMAT(his.created_at,'%e %b') AS created_at,
					his.id_tasklist,
					his.progress,
					his.`status`,
					his.status_before,
					his.note,
					st.nama AS st,
					st.warna AS st_warna,
					st_before.nama AS st_before,
					st_before.warna AS st_before_warna
				FROM
					`grd_t_tasklist_history` his
					JOIN m_pekerjaan_status st ON st.id = his.`status`
					JOIN m_pekerjaan_status st_before ON st_before.id = his.status_before
				WHERE his.id_tasklist = '$id' 
				ORDER BY his.created_at DESC 
			";

		return $this->db->query($query)->result();
	}

	public function get_history_det($id)
	{
		$query = "SELECT
					DATE_FORMAT(his.created_at,'%e %b') AS created_at,
					his.id_tasklist,
					his.progress,
					his.`status`,
					his.status_before,
					his.note,
					st.nama AS st,
					st.warna AS st_warna,
					st_before.nama AS st_before,
					st_before.warna AS st_before_warna
				FROM
					`grd_t_tasklist_milestone_history` his
					JOIN m_pekerjaan_status st ON st.id = his.`status`
					JOIN m_pekerjaan_status st_before ON st_before.id = his.status_before
				WHERE his.id_tasklist = '$id' 
				ORDER BY his.created_at DESC 
			";

		return $this->db->query($query)->result();
	}

	public function get_file($id)
	{
		$query = "SELECT
                evidence
            FROM
                grd_t_tasklist 
            WHERE
                id_tasklist = '$id'";

		return $this->db->query($query)->result();
	}

	public function get_file_det($id)
	{
		$query = "SELECT
                evidence
            FROM
                grd_t_tasklist_milestone
            WHERE
                id_tasklist = '$id'";

		return $this->db->query($query)->result();
	}


	// content 2
	public function data_poin_check_bt($month)
	{
		$query = "SELECT
					x.id,
					x.periode,
					x.`name`,
					
					-- operasional
					x.tgt_sales,
					x.m_tgt_sales,
					x.l_tgt_sales,
					x.y_tgt_sales,

					x.tgt_basket,
					x.tgt_transaksi,
					
					x.act_sales,
					x.m_act_sales,
					x.l_act_sales,
					x.y_act_sales,

					x.act_basket,
					x.act_transaksi,
					
					CASE WHEN ROUND(((x.act_sales / x.tgt_sales) * 100),1) > 100 THEN 100
					ELSE ROUND(((x.act_sales / x.tgt_sales) * 100),1)
					END AS prs_sales,
					
					CASE WHEN ROUND(((x.m_act_sales / x.m_tgt_sales) * 100),1) > 100 THEN 100
					ELSE ROUND(((x.m_act_sales / x.m_tgt_sales) * 100),1)
					END AS prs_m_sales,
					
					CASE WHEN ROUND(((x.l_act_sales / x.l_tgt_sales) * 100),1) > 100 THEN 100
					ELSE ROUND(((x.l_act_sales / x.l_tgt_sales) * 100),1)
					END AS prs_l_sales,
					
					CASE WHEN ROUND(((x.y_act_sales / x.y_tgt_sales) * 100),1) > 100 THEN 100
					ELSE ROUND(((x.y_act_sales / x.y_tgt_sales) * 100),1)
					END AS prs_y_sales,

					ROUND(((x.act_basket / x.tgt_basket) * 100),1) AS prs_basket,
					ROUND(((x.act_transaksi / x.tgt_transaksi) * 100),1) AS prs_transaksi,

					-- produksi
					x.tgt_keamanan,
					x.tgt_leadtime_po,
					x.tgt_tingkat_reject,
					x.tgt_produk_baru,

					x.act_keamanan,
					x.act_leadtime_po,
					x.act_tingkat_reject,
					x.act_produk_baru,

					ROUND(((x.act_keamanan / x.tgt_keamanan) * 100),1) AS prs_keamanan,
					ROUND(((x.act_leadtime_po / x.tgt_leadtime_po) * 100),1) AS prs_leadtime_po,
					ROUND(((x.act_tingkat_reject / x.tgt_tingkat_reject) * 100),1) AS prs_tingkat_reject,
					ROUND(((x.act_produk_baru / x.tgt_produk_baru) * 100),1) AS prs_produk_baru,

					-- riset
					x.tgt_leadtime,
					x.tgt_keberhasilan,

					x.act_leadtime,
					x.act_keberhasilan,

					ROUND(((x.act_leadtime / x.tgt_leadtime) * 100),1) AS prs_leadtime,
					ROUND(((x.act_keberhasilan / x.tgt_keberhasilan) * 100),1) AS prs_keberhasilan
					
				FROM
					(
						SELECT
							a.id,
							a.periode,
							b.`name`,
							
						-- 	operasional
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales', a.target, NULL)) AS tgt_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales Last', a.target, NULL)) AS m_tgt_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales Last Year', a.target, NULL)) AS l_tgt_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales This Year', a.target, NULL)) AS y_tgt_sales,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Basket Size', a.target, NULL)) AS tgt_basket,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Transaksi', a.target, NULL)) AS tgt_transaksi,
							
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales', a.actual, NULL)) AS act_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales Last', a.actual, NULL)) AS m_act_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales Last Year', a.actual, NULL)) AS l_act_sales,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Sales This Year', a.actual, NULL)) AS y_act_sales,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Basket Size', a.actual, NULL)) AS act_basket,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Operasional' AND a.nama_target = 'Transaksi', a.actual, NULL)) AS act_transaksi,
							
						-- 	produksi
							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Keamanan Stok', a.target, NULL)) AS tgt_keamanan,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Keamanan Stok', a.actual, NULL)) AS act_keamanan,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Leadtime PO', a.target, NULL)) AS tgt_leadtime_po,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Leadtime PO', a.actual, NULL)) AS act_leadtime_po,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Tingkat Reject', a.target, NULL)) AS tgt_tingkat_reject,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Tingkat Reject', a.actual, NULL)) AS act_tingkat_reject,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Produk Baru', a.target, NULL)) AS tgt_produk_baru,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Produk Baru', a.actual, NULL)) AS act_produk_baru,

						-- 	riset
							SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Leadtime', a.target, NULL)) AS tgt_leadtime,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Leadtime', a.actual, NULL)) AS act_leadtime,

							SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Keberhasilan', a.target, NULL)) AS tgt_keberhasilan,
							SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Keberhasilan', a.actual, NULL)) AS act_keberhasilan
							
						FROM
							grd_m_target AS a
						LEFT JOIN xin_companies AS b ON a.company = b.company_id
						WHERE a.periode = '$month'
					) AS x
				";

		return $this->db->query($query)->row_object();
	}

	public function data_persen_bt($month)
	{
		$query = "SELECT
					x.periode,
					ROUND(AVG(x.prs),1) AS prs_ops,
					y.prs_pro,
					a.prs_rs
				FROM
					(
						SELECT
							id_goal,
							id_company,
							divisi,
							CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
							ELSE ROUND((actual / target) * 100,1)
							END AS prs,
							SUBSTR(created_at,1,7) AS periode
						FROM
							grd_m_goal
						WHERE SUBSTR(created_at,1,7) = SUBSTR('$month',1,7)
						AND id_company = 5
						AND divisi = 'Operasional'
					) AS x
				LEFT JOIN
					(
						SELECT
							x.periode,
							ROUND(AVG(x.prs),1) AS prs_pro
						FROM
							(
								SELECT
									id_goal,
									id_company,
									divisi,
									CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
									ELSE ROUND((actual / target) * 100,1)
									END AS prs,
									SUBSTR(created_at,1,7) AS periode
								FROM
									grd_m_goal
								WHERE SUBSTR(created_at,1,7) = SUBSTR('$month',1,7)
								AND id_company = 5
								AND divisi = 'Produksi'
							) AS x
					) AS y
				ON x.periode = y.periode
				LEFT JOIN
					(
						SELECT
							x.periode,
							ROUND(AVG(x.prs),1) AS prs_rs
						FROM
							(
								SELECT
									id_goal,
									id_company,
									divisi,
									CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
									ELSE ROUND((actual / target) * 100,1)
									END AS prs,
									SUBSTR(created_at,1,7) AS periode
								FROM
									grd_m_goal
								WHERE SUBSTR(created_at,1,7) = SUBSTR('$month',1,7)
								AND id_company = 5
								AND divisi = 'Riset'
							) AS x
					) AS a
				ON x.periode = y.periode

				";

		return $this->db->query($query)->row_object();
	}

	public function get_warning_manpower()
	{
		$query = "SELECT * FROM your_table WHERE condition = 'value'";
		return $this->db->query($query)->result();
	}

	public function get_budget_vs_actual($tahun, $bulan)
	{
		$query = "SELECT
					grd_category,
					budget_awal, budget_sisa,
					ROUND(((budget_awal - budget_sisa) / (budget_awal)) * 100) budget_all_p,
					ROUND(((budget_awal - budget_sisa) / (budget_awal)) * 100) budget_all_p,
					ROUND(((budget_awal_pe - budget_sisa_pe) / (budget_awal - budget_sisa)) * 100) budget_all_pe_prs,
					ROUND(((budget_awal_pr - budget_sisa_pr) / (budget_awal - budget_sisa)) * 100) budget_all_pr_prs,
					ROUND(((budget_awal_sd - budget_sisa_sd) / (budget_awal - budget_sisa)) * 100) budget_all_sd_prs,
					budget_awal_pe, budget_sisa_pe, ROUND(((budget_awal_pe-budget_sisa_pe) / (budget_awal_pe)) * 100) budget_pe_p,
					budget_awal_pr, budget_sisa_pr, ROUND(((budget_awal_pr-budget_sisa_pr) / (budget_awal_pr)) * 100) budget_pr_p,
					budget_awal_sd, budget_sisa_sd, ROUND(((budget_awal_sd-budget_sisa_sd) / (budget_awal_sd)) * 100) budget_sd_p
					FROM (
					SELECT 
					grd_category,
					-- COALESCE(dt.budget_awal,0), COALESCE(dt.budget,0) AS budget_sisa,
					SUM(COALESCE(dt.budget_awal,0)) AS budget_awal,
					SUM(COALESCE(dt.budget,0)) AS budget_sisa,
					SUM(IF(grd_category = 'pengeluaran', COALESCE(dt.budget_awal,0), 0)) AS budget_awal_pe,
					SUM(IF(grd_category = 'pengeluaran', COALESCE(dt.budget,0), 0)) AS budget_sisa_pe,
					SUM(IF(grd_category = 'produksi', COALESCE(dt.budget_awal,0), 0)) AS budget_awal_pr,
					SUM(IF(grd_category = 'produksi', COALESCE(dt.budget,0), 0)) AS budget_sisa_pr,
					SUM(IF(grd_category = 'sdm', COALESCE(dt.budget_awal,0), 0)) AS budget_awal_sd,
					SUM(IF(grd_category = 'sdm', COALESCE(dt.budget,0), 0)) AS budget_sisa_sd

					FROM e_eaf.e_budget

					LEFT JOIN (
					SELECT
					
					e_biaya.id_biaya,
					budget.employee_name AS user,
					budget.contact_no AS no_hp1, 
					budget.contact AS no_hp2,
					e_biaya.nama_biaya,
					e_biaya.budget_awal,
					e_biaya.budget,
					e_biaya.budget2,
					e_biaya.minggu,
					e_biaya.bulan,
					e_biaya.tahun_budget,
					e_biaya.note_budget,
					e_biaya.updated_at,
					e_biaya.id_budget ,
					e_biaya.company_id,
					e_company.company_name

				FROM
					e_eaf.e_biaya
					LEFT JOIN ( 
                        SELECT
                        e_jenis_biaya.id_budget,
                        COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee_name,
                            emp.contact_no AS contact,
                            emp.contact_no 
                        FROM
                            e_eaf.e_jenis_biaya
                            LEFT JOIN hris.xin_employees AS emp ON e_jenis_biaya.id_user_approval = emp.user_id
                    ) AS budget ON e_biaya.id_budget = budget.id_budget 
                    LEFT JOIN e_eaf.e_company ON e_company.company_id = e_biaya.company_id										
				WHERE
					tahun_budget = '$tahun'
					AND bulan = '$bulan'
					AND e_biaya.company_id = 5
				GROUP BY
					id_biaya 
				ORDER BY
					id_biaya
					) dt ON dt.id_budget = e_budget.id_budget
					WHERE e_budget.company_id = 5
					) dt";
		return $this->db->query($query)->row_object();
	}

	public function get_budget_vs_actual_det($category, $tahun, $bulan)
	{
		$query = "SELECT 
					grd_category,
					e_budget.budget,
					dt.id_biaya,
					dt.`user`,
					dt.no_hp1, dt. no_hp2, dt.nama_biaya, dt.budget_awal, dt.budget, dt.budget2,
					minggu, bulan, tahun_budget, note_budget, updated_at, dt.id_budget, e_budget.company_id, 
					e_company.company_name


					FROM e_eaf.e_budget
					LEFT JOIN e_eaf.e_company ON e_company.company_id = e_budget.company_id										
					LEFT JOIN (
					SELECT
										
					e_biaya.id_biaya,
					budget.employee_name AS `user`,
					budget.contact_no AS no_hp1, 
					budget.contact AS no_hp2,
					e_biaya.nama_biaya,
					e_biaya.budget_awal,
					e_biaya.budget,
					e_biaya.budget2,
					e_biaya.minggu,
					e_biaya.bulan,
					e_biaya.tahun_budget,
					e_biaya.note_budget,
					e_biaya.updated_at,
					e_biaya.id_budget ,
					e_biaya.company_id

				FROM
					e_eaf.e_biaya
					LEFT JOIN ( 
                        SELECT
                        e_jenis_biaya.id_budget,
                        COALESCE(REPLACE(CONCAT(TRIM(emp.first_name), ' ', TRIM(emp.last_name)),',',', '),'') AS employee_name,
                            emp.contact_no AS contact,
                            emp.contact_no 
                        FROM
                            e_eaf.e_jenis_biaya
                            LEFT JOIN hris.xin_employees AS emp ON e_jenis_biaya.id_user_approval = emp.user_id
                    ) AS budget ON e_biaya.id_budget = budget.id_budget 
				WHERE
					tahun_budget = '$tahun'
					AND bulan = '$bulan'
					AND e_biaya.company_id = 5
				GROUP BY
					id_biaya 
				ORDER BY
					id_biaya
					) dt ON dt.id_budget = e_budget.id_budget
					WHERE e_budget.company_id = 5 AND e_budget.grd_category = '$category'
		";
		return $this->db->query($query)->result();
	}

	function kanban_data($divisi = null, $month)
	{
		if ($divisi == null) {
			$kondisi = "";
		} else {
			$kondisi = "AND task.divisi = '$divisi'";
		}


		$query = "SELECT
	task.id_tasklist AS id_task,
	task.divisi,
	si.si AS type,
	task.detail AS task,
	task.output AS description,
	COALESCE(task.actual,0) AS progress,
	task.`START` AS `start`,
	task.`end` AS `end`,
	task.created_at,
	task.done_at AS done_date,
	task.note,
	task.evidence AS attachment,
	task.pic AS id_pic,
	GROUP_CONCAT(
	CONCAT( emp.first_name, ' ', emp.last_name )) AS pic,
	GROUP_CONCAT(
	CASE
			
			WHEN emp.profile_picture IS NULL 
			OR emp.profile_picture = '' 
			OR emp.profile_picture = 'no file' THEN
			CASE
					
					WHEN emp.gender = 'Male' THEN
					'default_male.jpg' ELSE 'default_female.jpg' 
				END ELSE COALESCE ( emp.profile_picture, '' ) 
			END 
			) AS profile_picture,
	CONCAT( created_by.first_name, ' ', created_by.last_name ) AS created_by,
	task.`status` AS id_status,
	m_status.nama AS `status`,
	m_status.warna AS status_color
FROM
	`grd_t_tasklist` task
	LEFT JOIN grd_m_task_status m_status ON m_status.id = task.`status`
	LEFT JOIN xin_employees emp ON FIND_IN_SET( emp.user_id, task.pic )
	LEFT JOIN xin_employees created_by ON created_by.user_id = task.created_by
	LEFT JOIN grd_t_si si ON si.id_si = task.id_si
	WHERE 
	DATE_FORMAT(task.created_at, '%m-%Y') ='$month'
	 $kondisi
GROUP BY
	task.id_tasklist";
		return $this->db->query($query)->result();
	}
}
