<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_grd_dept extends CI_Model
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

	function get_divisi($id_company)
	{
		$query = "SELECT divisi FROM grd_m_goal WHERE id_company = $id_company GROUP BY id_company, divisi";
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
							WHEN ROUND(COALESCE(SUM(prg.persen),0) / COALESCE(COUNT(prg.id_tasklist),0)) < 70 THEN 'FD97A4'
							WHEN ROUND(COALESCE(SUM(prg.persen),0) / COALESCE(COUNT(prg.id_tasklist),0)) BETWEEN 70 AND 85 THEN 'FFE97B'
						ELSE 'BFEC78'
						END AS warna,
						COALESCE(SUM(prg.persen),0) AS progress,
						COALESCE(ROUND(COALESCE(SUM(prg.persen),0) / COALESCE(COUNT(prg.id_tasklist),0)),0)AS progress

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
						COALESCE ( SUBSTR( task.done_at, 1, 10 ), '' ) AS done_at,
						task.target_milestone_type,
						task.actual_milestone_type

				FROM grd_t_tasklist_milestone task
				LEFT JOIN grd_m_milestone mile ON mile.id = task.id_milestone
				LEFT JOIN xin_employees pic ON pic.user_id = task.pic
				LEFT JOIN xin_employees emp ON emp.user_id = task.created_by
				LEFT JOIN m_pekerjaan_status st ON st.id = task.`status`

				WHERE task.id_tasklist = '$id_tasklist'
		";
		return $this->db->query($query)->row_object();
	}

	function data_goal($divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);

		if ( empty($divisi) ) {
			$divisi = '$divisi';
		}

		if ( empty($start) && empty($end) ) {
			$start = date('Y-m-01');
			$end = date('Y-m-d');
		}
		$sql_x = "SELECT
					x.periode,
					x.company,
					x.divisi AS nama,
					x.nama_target,
					x.target AS tgt_sales,
					SUM(x.actual) AS act_sales,
					CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
					ELSE ROUND((SUM(x.actual) / target) * 100,1)
					END AS prs_sales
				FROM
					(
						SELECT
							company,
							divisi,
							nama_target,
							target,
							actual,
							periode
						FROM
							grd_m_target_new
						WHERE periode BETWEEN '$start' AND '$end'
				-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
						AND company = 5
						AND divisi = '$divisi'
						AND nama_target = 'Sales'
					) AS x";
		$sql_tgt_sales = "SELECT
					COALESCE(sales.tgt_sales,0) AS tgt_sales		
				FROM
					(".$sql_x.") AS sales";
					
		$sql_act_sales = "SELECT
					COALESCE(sales.act_sales,0) AS act_sales
				FROM
					(".$sql_x.") AS sales";
					
		$sql_prs_sales = "SELECT
					COALESCE(sales.prs_sales,0) AS prs_sales
				FROM
					(".$sql_x.") AS sales";
		$sql = "SELECT
					comp.`name` AS company,
					goal.id_goal,
					goal.nama_goal,
					CASE 
						WHEN goal.nama_goal = 'Revenue' THEN ($sql_tgt_sales)
						ELSE goal.target
					END AS 'target',
					CASE 
						WHEN goal.nama_goal = 'Revenue' THEN ($sql_act_sales)
						ELSE goal.actual
					END AS 'actual',
					CASE 
						WHEN goal.nama_goal = 'Revenue' THEN ($sql_prs_sales)	
						ELSE ROUND(((goal.actual / goal.target) * 100),1)
					END AS 'prs',
					CASE 
						WHEN ROUND(((goal.actual / goal.target) * 100),1) < 70 THEN 'danger'
						WHEN ROUND(((goal.actual / goal.target) * 100),1) BETWEEN 70 AND 85 THEN 'warning'
						ELSE 'success'
					END AS warna,

					COUNT(DISTINCT si.id_si) AS total_si,
					ROUND(SUM(si.actual_si_p) / COUNT(si.id_si),1) AS progress_si,

					
					COALESCE(SUM(progress.total_tasklist),0) AS total_tasklist,
					-- ROUND(SUM(progress.actual_tasklist_p) / SUM(progress.total_tasklist),1) AS progress_tasklist,
					ROUND(SUM(progress.total_actual) / SUM(progress.total_tasklist),1) AS progress_tasklist,


					ROUND(COALESCE(
						CASE 
							WHEN ROUND(((goal.actual / goal.target) * 100),1) > 100 THEN 100
							ELSE ROUND(((goal.actual / goal.target) * 100),1)
						END
					, 0),2) AS done_prs,

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
								SUM(COALESCE(actual,0)) AS total_actual,
								SUM(COALESCE(actual_tasklist_p,0)) AS actual_tasklist_p,
								COUNT(id_tasklist) AS total_tasklist
						FROM grd_t_tasklist
						GROUP BY id_si
				) AS progress ON progress.id_si = si.id_si
				

				WHERE goal.divisi = '$divisi' AND ( (DATE(goal.startdate) <= '$start' AND DATE(goal.enddate) >= '$end') OR (DATE(goal.startdate) BETWEEN '$start' AND '$end') OR (DATE(goal.enddate) BETWEEN '$start' AND '$end') )
				GROUP BY goal.id_goal
				";

		return $this->db->query($sql)->result();
	}

	// function data_so($divisi, $month)
	// {
	// 	$monthNumber = substr($month, 0, 2);
	// 	$year = substr($month, 3, 4);

	// 	$sql = "SELECT
	// 				so.id_so, 
	// 				so.id_goal, 
	// 				goal.nama_goal,
	// 				so.so, 
	// 				so.id_company, 
	// 				so.divisi,

	// 				DATE_FORMAT(so.`start`, '%d-%m-%Y %H:%i') AS `start_so_satuan`,
	// 				DATE_FORMAT(so.`end`, '%d-%m-%Y %H:%i') AS `end_so_satuan`,
	// 				CONCAT(
	// 					TIMESTAMPDIFF(DAY, so.`start`, so.`done_at`), ' h, ',
	// 					MOD(TIMESTAMPDIFF(HOUR, so.`start`, so.`done_at`), 24), ' j, ',
	// 					MOD(TIMESTAMPDIFF(MINUTE, so.`start`, so.`done_at`), 60), ' m'
	// 				) AS leadtime_so,
	// 				GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
	// 				COALESCE(so.evidence, '-') AS evidence,
	// 				so.`status`,
	// 				COALESCE(so.target_so, 0) AS target,
	// 				COALESCE(so.actual_so, 0) AS actual,
	// 				COALESCE(so.output, '-') AS output,

	// 				-- CASE
	// 				-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) > 100 THEN 100
	// 				-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) <= 0 THEN 0
	// 				-- ELSE ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1)
	// 				-- END AS progress_so_satuan,
	// 				COALESCE(LEFT(so.done_at, 10), '-') AS done_at,
	// 				st.nama AS nama_status,

	// 				so.created_at, 
	// 				so.created_by, 
	// 				so.deleted_at, 
	// 				so.updated_at, 
	// 				so.updated_by,
	// 				COALESCE(MIN(DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i')),'-') AS start,
	// 				COALESCE(MAX(DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i')),'-') AS end,
	// 				COALESCE(CONCAT(
	// 					TIMESTAMPDIFF(DAY, MIN(`task`.`start`), MAX(`task`.`done_at`)), ' h, ',
	// 					MOD(TIMESTAMPDIFF(HOUR, MIN(`task`.`start`), MAX(`task`.`done_at`)), 24), ' j, ',
	// 					MOD(TIMESTAMPDIFF(MINUTE, MIN(`task`.`start`), MAX(`task`.`done_at`)), 60), ' m'
	// 				), '-') AS leadtime,

	// 				-- CASE
	// 				-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) > 100 THEN 100
	// 				-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) <= 0 THEN 0
	// 				-- ELSE ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1)
	// 				-- END AS progress_so,

	// 				-- ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) AS progress_so,

	// 				-- CASE 
	// 				-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) < 60 THEN 'danger'
	// 				-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) BETWEEN 60 AND 75 THEN 'warning'
	// 				-- 	ELSE 'success'
	// 				-- END AS warna 

	// 				-- CASE
	// 				-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) > 100 THEN 100
	// 				-- 	WHEN ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1) <= 0 THEN 0
	// 				-- ELSE ROUND(COALESCE(so.actual_so / so.target_so * 100, 0), 1)
	// 				-- END AS progress_so_satuan,
	// 				ROUND(COALESCE(so.actual_so_p, 0), 1) AS progress_so_satuan,
	// 				-- ROUND(COALESCE(total_actual_si_p,0), 1) AS progress_so,
	// 				CASE
	// 					WHEN ROUND(COALESCE(overall_so, 0), 1) > 100 THEN 100
	// 					WHEN ROUND(COALESCE(overall_so, 0), 1) <= 0 THEN 0
	// 				ELSE ROUND(COALESCE(overall_so, 0), 1)
	// 				END AS progress_so,
	// 				CASE 
	// 					WHEN ROUND(COALESCE(total_actual_si_p,0), 1) < 60 THEN 'danger'
	// 					WHEN ROUND(COALESCE(total_actual_si_p,0), 1) BETWEEN 60 AND 75 THEN 'warning'
	// 					ELSE 'success'
	// 				END AS warna


	// 			FROM
	// 				grd_m_so AS so
	// 			LEFT JOIN grd_m_goal AS goal ON so.id_goal = goal.id_goal
	// 			LEFT JOIN grd_t_si AS si ON si.id_so = so.id_so
	// 			LEFT JOIN grd_t_tasklist AS task ON task.id_si = si.id_si

	// 			LEFT JOIN xin_employees pic ON FIND_IN_SET(pic.user_id, so.pic)
	// 			LEFT JOIN m_pekerjaan_status st ON st.id = so.status

	// 			LEFT JOIN (
	// 				SELECT id_so, SUM(target) AS total_target, SUM(actual) AS total_actual,
	// 				COUNT(grd_t_si.id_si) AS total_actual_si,
	// 				SUM(grd_t_si.actual_si_p) AS total_actual_si_p
	// 				FROM grd_t_tasklist
	// 				JOIN grd_t_si ON grd_t_tasklist.id_si = grd_t_si.id_si
	// 				GROUP BY id_so
	// 			) AS progress ON progress.id_so = so.id_so
	// 			LEFT JOIN (
	// 				SELECT grd_t_si.id_si, id_so, 
	// 				COALESCE(SUM(actual_si_p) / COUNT(grd_t_si.id_si),0) AS overall_so
	// 				FROM grd_t_si 
	// 				GROUP BY id_so
	// 			) AS overall ON overall.id_so = so.id_so
	// 			WHERE goal.divisi = '$divisi'
	// 				-- AND MONTH(so.created_at) = '$monthNumber' AND YEAR(so.created_at) = '$year'	
	// 				AND ((MONTH(so.start) = '$monthNumber' AND YEAR(so.start) = '$year') OR (MONTH(so.end) = '$monthNumber' AND YEAR(so.end) = '$year'))

	// 			GROUP BY so.id_so
	// 			";

	// 	return $this->db->query($sql)->result();
	// }

	function data_so($divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);

		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}

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
					COALESCE(so.target_so, 0) AS target,
					COALESCE(so.actual_so, 0) AS actual,
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
					COALESCE(CONCAT(
						TIMESTAMPDIFF(DAY, MIN(`task`.`start`), MAX(`task`.`done_at`)), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, MIN(`task`.`start`), MAX(`task`.`done_at`)), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, MIN(`task`.`start`), MAX(`task`.`done_at`)), 60), ' m'
					), '-') AS leadtime,

				
					ROUND(COALESCE(so.actual_so_p, 0), 1) AS progress_so_satuan,
					CASE
						WHEN ROUND(COALESCE(overall_so, 0), 1) > 100 THEN 100
						WHEN ROUND(COALESCE(overall_so, 0), 1) <= 0 THEN 0
					ELSE ROUND(COALESCE(overall_so, 0), 1)
					END AS progress_so,
					CASE 
						WHEN ROUND(COALESCE(overall_so, 0), 1) < 70 THEN 'danger'
						WHEN ROUND(COALESCE(overall_so, 0), 1) BETWEEN 70 AND 85 THEN 'warning'
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
					SUM(grd_t_si.actual_si_p) AS total_actual_si_p
					FROM grd_t_tasklist
					JOIN grd_t_si ON grd_t_tasklist.id_si = grd_t_si.id_si
					GROUP BY id_so
				) AS progress ON progress.id_so = so.id_so
				LEFT JOIN (
					SELECT grd_t_si.id_si, id_so, 
					COALESCE(SUM(actual_si_p) / COUNT(grd_t_si.id_si),0) AS overall_so
					FROM grd_t_si 
					GROUP BY id_so
				) AS overall ON overall.id_so = so.id_so
				WHERE goal.divisi = '$divisi'
					AND ( (DATE(so.start) <= '$start' AND DATE(so.end) >= '$end') OR (DATE(so.start) BETWEEN '$start' AND '$end') OR (DATE(so.end) BETWEEN '$start' AND '$end') )
				GROUP BY so.id_so
				";

		return $this->db->query($sql)->result();
	}

	function data_si($divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);

		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}

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
					COALESCE(si.target_si, 0) AS target,
					COALESCE(si.actual_si, 0) AS actual,
					COALESCE(si.output, '-') AS output,

					-- CASE
					-- 	WHEN ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1) > 100 THEN 100
					-- 	WHEN ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1) <= 0 THEN 0
					-- ELSE ROUND(COALESCE(si.actual_si / si.target_si * 100, 0), 1)
					-- END AS progress_si_satuan,
					ROUND(COALESCE(si.actual_si_p, 0), 1) AS progress_si_satuan,

					COALESCE(LEFT(so.done_at, 10), '-') AS done_at,
					st.nama AS nama_status,

					si.created_at, 
					si.created_by, 
					si.deleted_at, 
					si.updated_at, 
					si.updated_by,
					COALESCE(MIN(DATE_FORMAT(`task`.`start`, '%d-%m-%Y %H:%i')),'-') AS start,
					COALESCE(MAX(DATE_FORMAT(`task`.`end`, '%d-%m-%Y %H:%i')),'-') AS end,
					COALESCE(CONCAT(
						TIMESTAMPDIFF(DAY, MIN(`task`.`start`), MAX(`task`.`done_at`)), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, MIN(`task`.`start`), MAX(`task`.`done_at`)), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, MIN(`task`.`start`), MAX(`task`.`done_at`)), 60), ' m'
					), '-') AS leadtime,

					-- CASE
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) > 100 THEN 100
					-- 	WHEN ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) <= 100 THEN 0
					-- ELSE ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1)
					-- END AS progress_si,
					ROUND(COALESCE(total_actual_si_p,0), 1) AS progress_si,

					-- ROUND(COALESCE(progress.total_actual / progress.total_target * 100, 0), 1) AS progress_si,

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
							SUM(grd_t_si.actual_si_p) AS total_actual_si_p

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
					WHERE chat.divisi = '$divisi'
						AND DATE(chat.created_at) BETWEEN '$start' AND '$end'
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
					WHERE mom_header.divisi = '$divisi'
						AND DATE(mom_header.created_at) BETWEEN '$start' AND '$end'
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
					WHERE cm_task.divisi = '$divisi'
						AND DATE(cm_task.created_at) BETWEEN '$start' AND '$end'
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
					WHERE gemba.divisi = '$divisi'
						AND DATE(gemba.created_at) BETWEEN '$start' AND '$end'
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
					WHERE coaching.divisi = '$divisi'
						AND DATE(coaching.created_at) BETWEEN '$start' AND '$end'
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
					WHERE td_task.divisi = '$divisi'
						AND DATE(td_task.created_at) BETWEEN '$start' AND '$end'
						GROUP BY divisi, so, si
					-- GROUP BY task.id_tasklist
				) ibr ON ibr.divisi = task.divisi 
					AND ibr.so = si.id_so
					AND ibr.si = si.id_si
					AND task.id_tasklist = ibr.id_tasklist

				WHERE goal.divisi = '$divisi'
					AND ( (DATE(si.start) <= '$start' AND DATE(si.end) >= '$end') OR (DATE(si.start) BETWEEN '$start' AND '$end') OR (DATE(si.end) BETWEEN '$start' AND '$end') )
				GROUP BY si.id_si
				";

		return $this->db->query($sql)->result();
	}

	function data_tasklist($divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);

		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}

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
					COALESCE(CONCAT(
						TIMESTAMPDIFF(DAY, `task`.`start`, `task`.`done_at`), ' h, ',
						MOD(TIMESTAMPDIFF(HOUR, `task`.`start`, `task`.`done_at`), 24), ' j, ',
						MOD(TIMESTAMPDIFF(MINUTE, `task`.`start`, `task`.`done_at`), 60), ' m'
					), '-') AS leadtime,
                    GROUP_CONCAT(DISTINCT CONCAT(pic.first_name, ' ', pic.last_name)) AS pic,
                    COALESCE(task.evidence, '-') AS evidence,
                    task.`status`,
                    COALESCE(task.target, 0) AS target,
                    COALESCE(task.actual, 0) AS actual,
					COALESCE(task.jenis_tasklist, '-') AS jenis_tasklist,
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
					IF(COALESCE(DATE(task.done_at),CURDATE()) > DATE(task.`end`),'Late','Ontime') AS status_leadtime,
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
                        WHERE chat.divisi = '$divisi'
							AND DATE(chat.created_at) BETWEEN '$start' AND '$end'
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
                        WHERE mom_header.divisi = '$divisi'
							AND DATE(mom_header.created_at) BETWEEN '$start' AND '$end'
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
                        WHERE cm_task.divisi = '$divisi'
                            AND DATE(cm_task.created_at) BETWEEN '$start' AND '$end'
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
                        WHERE gemba.divisi = '$divisi'
                            AND DATE(gemba.created_at) BETWEEN '$start' AND '$end'
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
                        WHERE coaching.divisi = '$divisi'
                            AND DATE(coaching.created_at) BETWEEN '$start' AND '$end'
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
                        WHERE td_task.divisi = '$divisi'
                            AND DATE(td_task.created_at) BETWEEN '$start' AND '$end'
                        GROUP BY task.id_tasklist
                    ) ibr ON ibr.divisi = task.divisi 
                        AND ibr.so = si.id_so
                        AND ibr.si = si.id_si
                        AND task.id_tasklist = ibr.id_tasklist
                WHERE
                    task.divisi = '$divisi'
					" . (!in_array($this->session->userdata('user_id'), [1,61,118,321, 323, 476, 803, 8259]) && !in_array($this->session->userdata('user_role_id'),[2,3,10]) ? ' AND pic.user_id =\'' . $this->session->userdata('user_id').'\'' : '') . " 	
					 AND ( (DATE(task.start) <= '$start' AND DATE(task.end) >= '$end') OR (DATE(task.start) BETWEEN '$start' AND '$end') OR (DATE(task.end) BETWEEN '$start' AND '$end') )
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

	public function get_detail_mom($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',mom.tasklist)";
		}

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
									AND DATE(mom.tgl) BETWEEN '$start' AND '$end'
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
									AND DATE(mom.tgl) BETWEEN '$start' AND '$end'
									GROUP BY
										mom.id_mom 
									) AS dep ON dep.id_mom = mom.id_mom 
								WHERE
									mom.closed = 1
									AND mom.divisi='$divisi' AND mom.so = '$id_so' AND mom.si = '$id_si' AND DATE(mom.created_at) BETWEEN '$start' AND '$end' $kondisi
								GROUP BY
								mom.id_mom 
							) AS final";
		return $this->db->query($query)->result();
	}

	public function get_detail_ibr($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);
		
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',t.tasklist)";
		}

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
                WHERE t.divisi='$divisi' AND t.so = '$id_so' AND t.si = '$id_si' AND DATE(t.created_at) BETWEEN '$start' AND '$end' $kondisi
            GROUP BY
                st.id_sub_task 
            ORDER BY
                t.created_at DESC";
		return $this->db->query($query)->result();
	}

	public function get_detail_genba($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',gemba.tasklist)";
		}

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
                WHERE gemba.divisi='$divisi' AND gemba.so = '$id_so' AND gemba.si = '$id_si' AND DATE(gemba.tgl_plan) BETWEEN '$start' AND '$end' $kondisi";
		return $this->db->query($query)->result();
	}

	public function get_detail_conco($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);		
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',coaching.tasklist)";
		}

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
                coaching.divisi='$divisi' AND coaching.so = '$id_so' AND coaching.si = '$id_si' AND DATE(coaching.created_at) BETWEEN '$start' AND '$end' $kondisi";
		return $this->db->query($query)->result();
	}

	public function get_detail_comp($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);
		
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',t.tasklist)";
		}

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
                t.divisi='$divisi' AND t.so = '$id_so' AND t.si = '$id_si' AND DATE(t.created_at) BETWEEN '$start' AND '$end' $kondisi
                GROUP BY t.id_task ORDER BY t.created_at DESC";

		return $this->db->query($query)->result();
	}

	public function get_detail_teamtalk($id_tasklist, $id_si, $id_so, $divisi, $start, $end)
	{
		// $monthNumber = substr($month, 0, 2);
		// $year = substr($month, 3, 4);
		
		$kondisi = "";
		if ($id_tasklist != 0) {
			$kondisi = "AND FIND_IN_SET('$id_tasklist',chat.tasklist)";
		}

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
                chat.divisi='$divisi' AND chat.so = '$id_so' AND chat.si = '$id_si' AND DATE(chat.created_at) BETWEEN '$start' AND '$end' $kondisi";
		return $this->db->query($query)->result();
	}


	// content 2
	// public function data_poin_check_bt($month)
	// {
	// 	$query = "SELECT
	// 				x.id,
	// 				x.periode,
	// 				x.`name`,
					
	// 				-- $divisi
	// 				x.tgt_sales,
	// 				x.m_tgt_sales,
	// 				x.l_tgt_sales,
	// 				x.y_tgt_sales,

	// 				x.tgt_basket,
	// 				x.tgt_transaksi,
					
	// 				x.act_sales,
	// 				x.m_act_sales,
	// 				x.l_act_sales,
	// 				x.y_act_sales,

	// 				x.act_basket,
	// 				x.act_transaksi,
					
	// 				CASE WHEN ROUND(((x.act_sales / x.tgt_sales) * 100),1) > 100 THEN 100
	// 				ELSE ROUND(((x.act_sales / x.tgt_sales) * 100),1)
	// 				END AS prs_sales,
					
	// 				CASE WHEN ROUND(((x.m_act_sales / x.m_tgt_sales) * 100),1) > 100 THEN 100
	// 				ELSE ROUND(((x.m_act_sales / x.m_tgt_sales) * 100),1)
	// 				END AS prs_m_sales,
					
	// 				CASE WHEN ROUND(((x.l_act_sales / x.l_tgt_sales) * 100),1) > 100 THEN 100
	// 				ELSE ROUND(((x.l_act_sales / x.l_tgt_sales) * 100),1)
	// 				END AS prs_l_sales,
					
	// 				CASE WHEN ROUND(((x.y_act_sales / x.y_tgt_sales) * 100),1) > 100 THEN 100
	// 				ELSE ROUND(((x.y_act_sales / x.y_tgt_sales) * 100),1)
	// 				END AS prs_y_sales,

	// 				ROUND(((x.act_basket / x.tgt_basket) * 100),1) AS prs_basket,
	// 				ROUND(((x.act_transaksi / x.tgt_transaksi) * 100),1) AS prs_transaksi,

	// 				-- produksi
	// 				x.tgt_keamanan,
	// 				x.tgt_leadtime_po,
	// 				x.tgt_tingkat_reject,
	// 				x.tgt_produk_baru,

	// 				x.act_keamanan,
	// 				x.act_leadtime_po,
	// 				x.act_tingkat_reject,
	// 				x.act_produk_baru,

	// 				ROUND(((x.act_keamanan / x.tgt_keamanan) * 100),1) AS prs_keamanan,
	// 				ROUND(((x.act_leadtime_po / x.tgt_leadtime_po) * 100),1) AS prs_leadtime_po,
	// 				ROUND(((x.act_tingkat_reject / x.tgt_tingkat_reject) * 100),1) AS prs_tingkat_reject,
	// 				ROUND(((x.act_produk_baru / x.tgt_produk_baru) * 100),1) AS prs_produk_baru,

	// 				-- riset
	// 				x.tgt_leadtime,
	// 				x.tgt_keberhasilan,

	// 				x.act_leadtime,
	// 				x.act_keberhasilan,

	// 				ROUND(((x.act_leadtime / x.tgt_leadtime) * 100),1) AS prs_leadtime,
	// 				ROUND(((x.act_keberhasilan / x.tgt_keberhasilan) * 100),1) AS prs_keberhasilan
					
	// 			FROM
	// 				(
	// 					SELECT
	// 						a.id,
	// 						a.periode,
	// 						b.`name`,
							
	// 					-- 	$divisi
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales', a.target, NULL)) AS tgt_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales Last', a.target, NULL)) AS m_tgt_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales Last Year', a.target, NULL)) AS l_tgt_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales This Year', a.target, NULL)) AS y_tgt_sales,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Basket Size', a.target, NULL)) AS tgt_basket,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Transaksi', a.target, NULL)) AS tgt_transaksi,
							
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales', a.actual, NULL)) AS act_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales Last', a.actual, NULL)) AS m_act_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales Last Year', a.actual, NULL)) AS l_act_sales,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Sales This Year', a.actual, NULL)) AS y_act_sales,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Basket Size', a.actual, NULL)) AS act_basket,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = '$divisi' AND a.nama_target = 'Transaksi', a.actual, NULL)) AS act_transaksi,
							
	// 					-- 	produksi
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Keamanan Stok', a.target, NULL)) AS tgt_keamanan,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Keamanan Stok', a.actual, NULL)) AS act_keamanan,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Leadtime PO', a.target, NULL)) AS tgt_leadtime_po,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Leadtime PO', a.actual, NULL)) AS act_leadtime_po,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Tingkat Reject', a.target, NULL)) AS tgt_tingkat_reject,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Tingkat Reject', a.actual, NULL)) AS act_tingkat_reject,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Produk Baru', a.target, NULL)) AS tgt_produk_baru,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Produksi' AND a.nama_target = 'Produk Baru', a.actual, NULL)) AS act_produk_baru,

	// 					-- 	riset
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Leadtime', a.target, NULL)) AS tgt_leadtime,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Leadtime', a.actual, NULL)) AS act_leadtime,

	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Keberhasilan', a.target, NULL)) AS tgt_keberhasilan,
	// 						SUM(IF(a.periode = '$month' AND a.divisi = 'Riset' AND a.nama_target = 'Keberhasilan', a.actual, NULL)) AS act_keberhasilan
							
	// 					FROM
	// 						grd_m_target AS a
	// 					LEFT JOIN xin_companies AS b ON a.company = b.company_id
	// 					WHERE a.periode = '$month'
	// 				) AS x
	// 			";

	// 	return $this->db->query($query)->row_object();
	// }

	public function data_poin_check_bt($divisi, $start, $end)
	{
		$query = "SELECT
					COALESCE(sales.periode,0) AS periode,
					COALESCE(sales.company,0) AS company,
					COALESCE(sales.nama,0) AS nama,
					
					COALESCE(sales.nama_target,0) AS nama_target_sales,
					COALESCE(sales.tgt_sales,0) AS tgt_sales,
					COALESCE(sales.act_sales,0) AS act_sales,
					COALESCE(sales.prs_sales,0) AS prs_sales,
					
					COALESCE(trx.periode,0) AS periode_transaksi,
					COALESCE(trx.nama_target,0) AS nama_target_transaksi,
					COALESCE(trx.tgt_transaksi,0) AS tgt_transaksi,
					COALESCE(trx.act_transaksi,0) AS act_transaksi,
					COALESCE(trx.prs_transaksi,0) AS prs_transaksi,
					
					COALESCE(basket.periode,0) AS periode_basket,
					COALESCE(basket.nama_target,0) AS nama_target_basket,
					COALESCE(basket.tgt_basket,0) AS tgt_basket,
					COALESCE(basket.act_basket,0) AS act_basket,
					COALESCE(basket.prs_basket,0) AS prs_basket,
					
					COALESCE(l_sales.periode,0) AS periode_l_sales,
					COALESCE(l_sales.nama_target,0) AS nama_target_l_sales,
					COALESCE(l_sales.tgt_l_sales,0) AS tgt_l_sales,
					COALESCE(l_sales.act_l_sales,0) AS act_l_sales,
					COALESCE(l_sales.prs_l_sales,0) AS prs_l_sales,
					
					COALESCE(y_sales.periode,0) AS periode_y_sales,
					COALESCE(y_sales.nama_target,0) AS nama_target_y_sales,
					COALESCE(y_sales.tgt_y_sales,0) AS tgt_y_sales,
					COALESCE(y_sales.act_y_sales,0) AS act_y_sales,
					COALESCE(y_sales.prs_y_sales,0) AS prs_y_sales,
					
					COALESCE(m_sales.periode,0) AS periode_m_sales,
					COALESCE(m_sales.nama_target,0) AS nama_target_m_sales,
					COALESCE(m_sales.tgt_m_sales,0) AS tgt_m_sales,
					COALESCE(m_sales.act_m_sales,0) AS act_m_sales,
					COALESCE(m_sales.prs_m_sales,0) AS prs_m_sales
					
				FROM
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi AS nama,
							x.nama_target,
							x.target AS tgt_sales,
							SUM(x.actual) AS act_sales,
							CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
							ELSE ROUND((SUM(x.actual) / target) * 100,1)
							END AS prs_sales
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Sales'
								ORDER BY periode ASC
							) AS x
					) AS sales
				LEFT JOIN
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi,
							x.nama_target,
							x.target AS tgt_transaksi,
							SUM(x.actual) AS act_transaksi,
							CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
							ELSE ROUND((SUM(x.actual) / target) * 100,1)
							END AS prs_transaksi
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Transaksi'
								ORDER BY periode ASC
							) AS x
					) AS trx 
				ON sales.periode = trx.periode
				LEFT JOIN
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi,
							'Basket Size' AS nama_target,
							z.target AS tgt_basket,
							ROUND(SUM(x.actual) / SUM(y.actual),0) AS act_basket,
							-- CASE WHEN ROUND(((SUM(x.actual) / SUM(y.actual)) / (x.target / y.target)) * 100,1) > 100 THEN 100
							-- ELSE ROUND(((SUM(x.actual) / SUM(y.actual)) / (x.target / y.target)) * 100,1)
							-- END AS prs_basket
							CASE WHEN ROUND(((SUM(x.actual) / SUM(y.actual)) / z.target) * 100,1) > 100 THEN 100
							ELSE ROUND(((SUM(x.actual) / SUM(y.actual)) / z.target) * 100,1)
							END AS prs_basket
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Sales'
								ORDER BY periode ASC
							) AS x
						LEFT JOIN
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Transaksi'
								ORDER BY periode ASC
							) AS y 
						ON x.periode = y.periode
						LEFT JOIN
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Basket Size'
								ORDER BY periode ASC
							) AS z
						ON x.periode = z.periode
					) AS basket 
				ON sales.periode = basket.periode
				LEFT JOIN
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi,
							x.nama_target,
							x.target AS tgt_l_sales,
							SUM(x.actual) AS act_l_sales,
							CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
							ELSE ROUND((SUM(x.actual) / target) * 100,1)
							END AS prs_l_sales
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									DATE_ADD(periode, INTERVAL 1 MONTH) AS periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN DATE_ADD('$start', INTERVAL -1 MONTH) AND DATE_ADD('$end', INTERVAL -1 MONTH)
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Sales Last'
								ORDER BY periode ASC
							) AS x
					) AS l_sales 
				ON sales.periode = l_sales.periode
				LEFT JOIN
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi,
							x.nama_target,
							x.target AS tgt_y_sales,
							SUM(x.actual) AS act_y_sales,
							CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
							ELSE ROUND((SUM(x.actual) / target) * 100,1)
							END AS prs_y_sales
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									DATE_ADD(periode, INTERVAL 1 YEAR) AS periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN DATE_ADD('$start', INTERVAL -1 YEAR) AND DATE_ADD('$end', INTERVAL -1 YEAR)
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Sales Last Year'
								ORDER BY periode ASC
							) AS x
					) AS y_sales 
				ON sales.periode = y_sales.periode
				LEFT JOIN
					(
						SELECT
							MIN(x.periode) AS periode,
							x.company,
							x.divisi,
							x.nama_target,
							x.target AS tgt_m_sales,
							SUM(x.actual) AS act_m_sales,
							CASE WHEN ROUND((SUM(x.actual) / x.target) * 100,1) > 100 THEN 100
							ELSE ROUND((SUM(x.actual) / target) * 100,1)
							END AS prs_m_sales
						FROM
							(
								SELECT
									company,
									divisi,
									nama_target,
									target,
									actual,
									periode
								FROM
									grd_m_target_new
								WHERE periode BETWEEN '$start' AND '$end'
						-- 		WHERE DATE_FORMAT(periode, '%d-%m-%Y') BETWEEN '01-02-2025' AND '10-02-2025'
								AND company = 5
								AND divisi = '$divisi'
								AND nama_target = 'Sales This Year'
								ORDER BY periode ASC
							) AS x
					) AS m_sales 
				ON sales.periode = m_sales.periode
				";

		return $this->db->query($query)->row_object();
	}

	public function data_persen_bt($divisi, $start, $end)
	{
		$query = "SELECT
					COALESCE(x.periode,0) AS periode,
					COALESCE(ROUND(AVG(x.prs),1),0) AS prs_ops,
					COALESCE(y.prs_pro,0) AS prs_pro,
					COALESCE(a.prs_rs,0) AS prs_rs
				FROM
					(
						SELECT
							id_goal,
							id_company,
							divisi,
							CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
							ELSE ROUND((actual / target) * 100,1)
							END AS prs,
							created_at AS periode
						FROM
							grd_m_goal
						WHERE SUBSTR(created_at,1,7) BETWEEN SUBSTR('$start',1,7) AND SUBSTR('$end',1,7)
						AND id_company = 5
						AND divisi = '$divisi'
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
									created_at AS periode
								FROM
									grd_m_goal
								WHERE SUBSTR(created_at,1,7) BETWEEN SUBSTR('$start',1,7) AND SUBSTR('$end',1,7)
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
									created_at AS periode
								FROM
									grd_m_goal
								WHERE SUBSTR(created_at,1,7) BETWEEN SUBSTR('$start',1,7) AND SUBSTR('$end',1,7)
								AND id_company = 5
								AND divisi = 'Riset'
							) AS x
					) AS a
				ON x.periode = y.periode

				";

		return $this->db->query($query)->row_object();
	}

	// 24-2-25
	// public function data_persen_bt($start, $end)
	// {
	// 	$query = "SELECT
	// 				x.periode,
	// 				ROUND(AVG(x.prs),1) AS prs_ops,
	// 				y.prs_pro,
	// 				a.prs_rs
	// 			FROM
	// 				(
	// 					SELECT
	// 						id_goal,
	// 						id_company,
	// 						divisi,
	// 						CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
	// 						ELSE ROUND((actual / target) * 100,1)
	// 						END AS prs,
	// 						SUBSTR(created_at,1,7) AS periode
	// 					FROM
	// 						grd_m_goal
	// 					WHERE DATE_FORMAT(created_at, '%m-%Y') = '$month'
	// 					AND id_company = 5
	// 					AND divisi = '$divisi'
	// 				) AS x
	// 			LEFT JOIN
	// 				(
	// 					SELECT
	// 						x.periode,
	// 						ROUND(AVG(x.prs),1) AS prs_pro
	// 					FROM
	// 						(
	// 							SELECT
	// 								id_goal,
	// 								id_company,
	// 								divisi,
	// 								CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
	// 								ELSE ROUND((actual / target) * 100,1)
	// 								END AS prs,
	// 								SUBSTR(created_at,1,7) AS periode
	// 							FROM
	// 								grd_m_goal
	// 							WHERE DATE_FORMAT(created_at, '%m-%Y') = '$month'
	// 							AND id_company = 5
	// 							AND divisi = 'Produksi'
	// 						) AS x
	// 				) AS y
	// 			ON x.periode = y.periode
	// 			LEFT JOIN
	// 				(
	// 					SELECT
	// 						x.periode,
	// 						ROUND(AVG(x.prs),1) AS prs_rs
	// 					FROM
	// 						(
	// 							SELECT
	// 								id_goal,
	// 								id_company,
	// 								divisi,
	// 								CASE WHEN ROUND((actual / target) * 100,1) > 100 THEN 100
	// 								ELSE ROUND((actual / target) * 100,1)
	// 								END AS prs,
	// 								SUBSTR(created_at,1,7) AS periode
	// 							FROM
	// 								grd_m_goal
	// 							WHERE DATE_FORMAT(created_at, '%m-%Y') = '$month'
	// 							AND id_company = 5
	// 							AND divisi = 'Riset'
	// 						) AS x
	// 				) AS a
	// 			ON x.periode = y.periode

	// 			";

	// 	return $this->db->query($query)->row_object();
	// }

	public function get_warning_manpower()
	{
		$query = "SELECT * FROM your_table WHERE condition = 'value'";
		return $this->db->query($query)->result();
	}

	public function get_budget_vs_actual($start, $end)
	{
		$tahun = substr($start, 0, 4);
		$bulan = substr($start, 5, 2);

		$tahun2 = substr($end, 0, 4);
		$bulan2 = substr($end, 5, 2);

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
					(tahun_budget = '$tahun'
					AND bulan = '$bulan') OR (tahun_budget = '$tahun2'
					AND bulan = '$bulan2')
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

	function kanban_data($divisi = null, $start, $end)
	{
		if ($divisi == null) {
			$kondisi = "";
		} else {
			$kondisi = "AND task.divisi = '$divisi'";
		}

		if (empty($start)) {
			$start = date('Y-m-01'); // First day of the current month
		}
		if (empty($end)) {
			$end = date('Y-m-d'); // Current date
		}

		$query = "SELECT
					task.id_tasklist AS id_task,
					task.id_si,
					si.id_so,
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
						DATE(task.created_at) BETWEEN '$start' AND '$end'
						$kondisi
				GROUP BY
					task.id_tasklist";
		return $this->db->query($query)->result();
	}

	// Get data details SI by khael
	public function getDetailSi($id_si)
	{
		$query = "SELECT
	si.id_si,
	si.si,
	so.so,
	COALESCE ( si.`status`, 1 ) AS `status`,
	COALESCE(st.nama,'Not Started') as nama_status,
	COALESCE(st.warna,'bg-secondary text-white') AS warna,
	si.output,
	so.divisi,
	si.`start`,
	si.`end`,
	comp.`name` AS company_name,
	GROUP_CONCAT(DISTINCT CONCAT(emp.first_name,' ',emp.last_name)) AS pic,
	si.actual_si AS actual,
	si.target_si AS target,
	si.target_si_type AS target_tipe,
	si.actual_si_type AS actual_tipe
FROM
	grd_t_si si
	LEFT JOIN grd_m_so so ON so.id_so = si.id_so
	LEFT JOIN xin_companies comp ON comp.company_id = so.id_company
	LEFT JOIN xin_employees emp ON si.pic = emp.user_id
	LEFT JOIN grd_m_task_status st ON st.id = si.`status` 
	WHERE si.id_si = $id_si
	GROUP BY 
	id_si";
		return $this->db->query($query)->row_object();
	}

	// Get data details So by khael
	public function getDetailSo($id_so)
	{
		$query = "SELECT
	so.id_so,
	so.so,
	COALESCE ( so.`status`, 1 ) AS `status`,
	COALESCE ( st.nama, 'Not Started' ) AS nama_status,
	COALESCE ( st.warna, 'bg-secondary text-white' ) AS warna,
	so.output,
	so.divisi,
	so.`start`,
	so.`end`,
	comp.`name` AS company_name,
	GROUP_CONCAT(
	DISTINCT CONCAT( emp.first_name, ' ', emp.last_name )) AS pic,
	so.actual_so AS actual,
	so.target_so AS target,
	so.target_so_type AS target_tipe,
	so.actual_so_type AS actual_tipe 
FROM
	grd_m_so so
	LEFT JOIN xin_companies comp ON comp.company_id = so.id_company
	LEFT JOIN xin_employees emp ON so.pic = emp.user_id
	LEFT JOIN grd_m_task_status st ON st.id = so.`status` 
WHERE
	so.id_so = $id_so 
GROUP BY
	id_so";
		return $this->db->query($query)->row_object();
	}


	// get data hitory for tabs by khael
	public function get_history_update($id, $type = 1)
	{
		if ($type == 1) {
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
					`grd_t_si_history` his
					JOIN m_pekerjaan_status st ON st.id = his.`status`
					JOIN m_pekerjaan_status st_before ON st_before.id = his.status_before
				WHERE his.id_tasklist = '$id' 
				ORDER BY his.created_at DESC";
		} else {
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
					`grd_m_so_history` his
					JOIN m_pekerjaan_status st ON st.id = his.`status`
					JOIN m_pekerjaan_status st_before ON st_before.id = his.status_before
				WHERE his.id_tasklist = '$id' 
				ORDER BY his.created_at DESC";
		}

		return $this->db->query($query)->result();
	}

	// get data files for tabs by khael
	public function get_files($id, $type)
	{
		if ($type == 1) {
			$query = "SELECT
                evidence
            FROM
                grd_t_si 
            WHERE
                id_si = '$id'
				AND evidence IS NOT NULL";
		} else {
			$query = "SELECT
                evidence
            FROM
                grd_m_so
            WHERE
                id_so = '$id'
				AND evidence IS NOT NULL";
		}
		return $this->db->query($query)->result();
	}


	// 8-3-25 Edit detail tasklist
	public function get_edit_detail_tasklist($id_tasklist)
	{
		$query = "SELECT
					a.id_tasklist,
					a.divisi,
					a.pic,
					GROUP_CONCAT(DISTINCT CONCAT(b.first_name, ' ', b.last_name)) AS nama_pic,
					SUBSTR(a.`start`,1,16) AS `start`,
					SUBSTR(a.`end`,1,16) AS `end`,
					a.detail,
					a.target,
					a.output
				FROM
					grd_t_tasklist AS a
				LEFT JOIN xin_employees AS b ON FIND_IN_SET(b.user_id, a.pic)
				WHERE a.id_tasklist = $id_tasklist
				GROUP BY a.id_tasklist
				";

		return $this->db->query($query)->row_object();
	}

	public function get_pic_edit($id_company)
	// public function get_pic_edit()
	{
		$query = "SELECT
					e.user_id,
					CONCAT(e.first_name,' ',e.last_name, ' - ', ds.designation_name) AS pic_name
				FROM `xin_employees` e
				LEFT JOIN xin_designations ds ON ds.designation_id = e.designation_id
				WHERE e.user_id != 1 AND e.is_active = 1
				-- AND e.company_id = 5
				AND e.company_id = $id_company
				ORDER BY CONCAT(e.first_name,' ',e.last_name)
				";

		return $this->db->query($query)->result();
	}


	
}
