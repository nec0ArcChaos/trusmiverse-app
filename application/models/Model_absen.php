<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_absen extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function cek_department($user_id)
	{
		$query = "SELECT department_id, company_id, date_of_joining FROM xin_employees WHERE user_id = $user_id LIMIT 1";
		return $this->db->query($query)->row_array();
	}

	function cek_quiz($user_id)
	{
		$query = "SELECT * FROM trusmi_attendance_quiz WHERE employee_id = '$user_id' AND attendance_date = CURRENT_DATE AND `status` = 1 LIMIT 1";
		return $this->db->query($query);
	}

	function cek_date($id, $date)
	{
		return $this->db->query("SELECT * FROM xin_attendance_time WHERE employee_id = $id AND attendance_date = '$date'");
	}

	function cek_mkt($id, $department_id)
	{
		// return $this->db->query("SELECT * FROM trusmi_rsp WHERE id_hr = $id");
		if (in_array($department_id, ['106', '107', '111', '28'])) { // 28: PELAKSANA
			return $this->db->query("SELECT l.id_lock, l.warning_lock, divisi, total, created_at, spv FROM absen_pelaksana
			LEFT JOIN trusmi_m_lock l ON l.id_lock = CASE WHEN absen_pelaksana.spv = 1 THEN 36 ELSE 3 END 
			 WHERE id_hr = $id LIMIT 1");
		}

		if ($department_id == 147) { // 147: PURCHASING BT
			$DB2 = $this->load->database('purchasing_crb', TRUE);
			return $DB2->query("SELECT dt.*, m_lock.id_lock, m_lock.warning_lock, 1477 AS divisi  FROM(

				SELECT CURRENT_DATE AS created_at, v_lock_absen_pcs.id_user AS created_by, username AS employee_name, id_hr, 
				CASE WHEN sts > 1 THEN 1 ELSE 0 END AS absen, tipe
				FROM v_lock_absen_pcs
				JOIN `user` ON `user`.id_user = v_lock_absen_pcs.id_user
				WHERE v_lock_absen_pcs.sts > 1
				
				UNION ALL
				
				SELECT * FROM v_absen_alarm_po WHERE tipe IS NOT NULL
				-- AND created_by NOT IN (177, 236, 220, 247, 251, 202, 150)
				) dt 
				JOIN m_lock ON m_lock.id_lock = dt.tipe
				WHERE id_hr = $id
				GROUP BY id_hr
				;");
		}

		if ($department_id == 95) { // 95:  BT SCM
			$DB2 = $this->load->database('purchasing_crb', TRUE);
			return $DB2->query("SELECT 
			9500 AS divisi, created_at, created_by, employee_name, id_hr, absen, warning_lock
			FROM lock_scm_all 
			LEFT JOIN m_lock ON m_lock.id_lock = lock_scm_all.tipe
			WHERE id_hr = $id");
		}

		if ($department_id == 14 || $department_id == 9) { // 147: STORE BT
			return $this->db->query("SELECT dt.*, 1400 AS divisi, 18 AS id_lock, CONCAT('Maaf Daily Tasklist Anda Belum achive ', acv , '% dari 100%') AS warning_lock FROM( SELECT * FROM absen_store) dt WHERE id_hr = $id LIMIT 1");
		}

		if ($department_id == 134 || $department_id == 27 || $department_id == 138) { // 28: PELAKSANA
			return $this->db->query("SELECT
										divisi,
										total,
										created_at,
										spv,
										lc.id_lock,
										lc.status_lock,
										lc.warning_lock
									FROM
										absen_pelaksana
									LEFT JOIN trusmi_m_lock lc ON CASE WHEN spv = 1 THEN lc.id_lock = 36 ELSE lc.id_lock = 3 END
									WHERE
										id_hr = $id 
										LIMIT 1");
		} else { // MARKETING
			return $this->db->query(
				"SELECT
					absen_mkt.divisi,
					absen_mkt.total,
					absen_mkt.created_at,
					absen_mkt.spv,
					trusmi_m_lock.id_lock,
					trusmi_m_lock.status_lock,
					REPLACE ( trusmi_m_lock.warning_lock, '[change]', absen_mkt.total ) AS warning_lock 
				FROM
					absen_mkt
					JOIN trusmi_m_lock ON absen_mkt.spv = trusmi_m_lock.id_lock 
				WHERE
					absen_mkt.id_hr = $id
					LIMIT 1"
			);
		}

		// return $this->db->query("SELECT divisi, total, created_at, spv FROM trusmi_rsp WHERE id_hr = $id LIMIT 1");
	}

	function cek_hr($id)
	{
		return $this->db->query("SELECT id_hr, actual, `target`, total, id_lock, status_lock, warning_lock FROM view_lock_absen_hr WHERE id_hr='$id' ORDER BY total ASC LIMIT 1");
	}

	function cek_kry_bsc()
	{
		return $this->db->query("SELECT user_id, actual, `target`, total, status_lock, warning_lock , ket FROM view_lock_absen_karyawan_basic_training");
	}

	function cek_karyawan_basic_training($user_id)
	{
		return $this->db->query("SELECT user_id, actual, `target`, total, id_lock, status_lock, warning_lock , ket FROM view_lock_absen_karyawan_basic_training WHERE user_id='$user_id' LIMIT 1");
	}

	function cek_karyawan_basic_training_mkt($user_id)
	{
		return $this->db->query("SELECT id_hr, total, id_lock, status_lock, warning_lock , ket FROM view_lock_absen_karyawan_basic_training_marketing WHERE id_hr='$user_id' LIMIT 1");
	}

	function cek_adm_collect($id)
	{
		return $this->db->query("SELECT id_hr, actual, `target`, total, id_lock, status_lock, warning_lock FROM view_lock_absen_adm_collect WHERE id_hr='$id'");
	}

	function shift($user_id, $kondisi)
	{
		$query = "SELECT
				xin_employees.user_id,
				xin_employees.office_shift_id,
				xin_office_shift.shift_name,
				$kondisi
			FROM
				xin_employees
				LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id 
			WHERE
				xin_employees.user_id = $user_id";

		return $this->db->query($query)->result();
	}

	function cek_absen($employee_id, $attendance_date)
	{
		$query = "SELECT
				xin_attendance_time.employee_id,
				xin_attendance_time.attendance_date,
				xin_attendance_time.clock_in 
			FROM
				xin_attendance_time 
			WHERE
				xin_attendance_time.employee_id = $employee_id 
				AND xin_attendance_time.attendance_date = '$attendance_date'";

		return $this->db->query($query)->row_array();
	}

	function profil($user_id, $date)
	{
		$query = "SELECT
					xin_employees.user_id,
					xin_employees.office_shift_id,
					xin_employees.first_name,
					xin_employees.last_name,
					xin_employees.designation_id,
					xin_designations.designation_name,
					xin_employees.profile_picture,
					xin_employees.gender,
					xin_departments.break,
					xin_departments.department_id,
					absen.photo_in,
					absen.clock_in,
					absen.photo_out,
					absen.clock_out,
					absen.break_out,
					absen.break_in,
					absen.total_work,
				CASE
					    WHEN DAYNAME('$date') = 'monday' THEN xin_office_shift.monday_in_time
					    WHEN DAYNAME('$date') = 'tuesday' THEN xin_office_shift.tuesday_in_time
					    WHEN DAYNAME('$date') = 'wednesday' THEN xin_office_shift.wednesday_in_time
					    WHEN DAYNAME('$date') = 'thursday' THEN xin_office_shift.thursday_in_time
					    WHEN DAYNAME('$date') = 'friday' THEN xin_office_shift.friday_in_time
					    WHEN DAYNAME('$date') = 'saturday' THEN xin_office_shift.saturday_in_time
					    WHEN DAYNAME('$date') = 'sunday' THEN xin_office_shift.sunday_in_time
					END AS shift_in,
					CASE
					    WHEN DAYNAME('$date') = 'monday' THEN xin_office_shift.monday_out_time
					    WHEN DAYNAME('$date') = 'tuesday' THEN xin_office_shift.tuesday_out_time
					    WHEN DAYNAME('$date') = 'wednesday' THEN xin_office_shift.wednesday_out_time
					    WHEN DAYNAME('$date') = 'thursday' THEN xin_office_shift.thursday_out_time
					    WHEN DAYNAME('$date') = 'friday' THEN xin_office_shift.friday_out_time
					    WHEN DAYNAME('$date') = 'saturday' THEN xin_office_shift.saturday_out_time
					    WHEN DAYNAME('$date') = 'sunday' THEN xin_office_shift.sunday_out_time
					END AS shift_out,
					COALESCE(quiz.status,'') AS quiz_status, -- 2023-03-08 14:42
					COALESCE(xin_departments.quiz_required,'') AS quiz_required -- 2023-03-09 15:27
			FROM
				xin_employees
				LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
				LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
				LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id
				LEFT JOIN (
				SELECT
					xin_attendance_time.employee_id,
					xin_attendance_time.clock_in,
					xin_attendance_time.photo_in,
					xin_attendance_time.clock_out,
					xin_attendance_time.photo_out,
					xin_attendance_time.break_out,
					xin_attendance_time.break_in,
					xin_attendance_time.total_work
				FROM
					xin_attendance_time 
				WHERE
					xin_attendance_time.employee_id = $user_id 
					AND xin_attendance_time.attendance_date = '$date' 
				) AS absen ON xin_employees.user_id = absen.employee_id 
				LEFT JOIN (
					SELECT 
						employee_id, 
						COALESCE(MAX(status),0) AS status 
					FROM trusmi_attendance_quiz 
					WHERE employee_id = $user_id
					AND attendance_date = CURRENT_DATE
					LIMIT 1
				) quiz ON quiz.employee_id = xin_employees.user_id -- 2023-03-08 14:42 
			WHERE
				xin_employees.user_id = $user_id";

		return $this->db->query($query)->row_array();
	}

	function profil_by_id($user_id, $attendance_id)
	{
		$query = "SELECT
					xin_employees.user_id,
					xin_employees.office_shift_id,
					xin_employees.first_name,
					xin_employees.last_name,
					xin_employees.designation_id,
					xin_designations.designation_name,
					xin_employees.profile_picture,
					xin_employees.gender,
					xin_departments.break,
					xin_departments.department_id,
					absen.photo_in,
					absen.clock_in,
					absen.photo_out,
					absen.clock_out,
					absen.break_out,
					absen.break_in,
					absen.total_work,
				CASE
					    WHEN DAYNAME(absen.attendance_date) = 'monday' THEN xin_office_shift.monday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'tuesday' THEN xin_office_shift.tuesday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'wednesday' THEN xin_office_shift.wednesday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'thursday' THEN xin_office_shift.thursday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'friday' THEN xin_office_shift.friday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'saturday' THEN xin_office_shift.saturday_in_time
					    WHEN DAYNAME(absen.attendance_date) = 'sunday' THEN xin_office_shift.sunday_in_time
					END AS shift_in,
					CASE
					    WHEN DAYNAME(absen.attendance_date) = 'monday' THEN xin_office_shift.monday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'tuesday' THEN xin_office_shift.tuesday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'wednesday' THEN xin_office_shift.wednesday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'thursday' THEN xin_office_shift.thursday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'friday' THEN xin_office_shift.friday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'saturday' THEN xin_office_shift.saturday_out_time
					    WHEN DAYNAME(absen.attendance_date) = 'sunday' THEN xin_office_shift.sunday_out_time
					END AS shift_out,
					COALESCE(quiz.status,'') AS quiz_status, -- 2023-03-09 08:37
					COALESCE(xin_departments.quiz_required,'') AS quiz_required -- 2023-03-09 15:27
			FROM
				xin_employees
				LEFT JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id
				LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
				LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id
				LEFT JOIN (
				SELECT
					xin_attendance_time.employee_id,
					xin_attendance_time.attendance_date,
					xin_attendance_time.clock_in,
					xin_attendance_time.photo_in,
					xin_attendance_time.clock_out,
					xin_attendance_time.photo_out,
					xin_attendance_time.break_out,
					xin_attendance_time.break_in,
					xin_attendance_time.total_work
				FROM
					xin_attendance_time 
				WHERE
					xin_attendance_time.time_attendance_id = $attendance_id 
				) AS absen ON xin_employees.user_id = absen.employee_id 
				LEFT JOIN (
					SELECT 
						employee_id, 
						COALESCE(MAX(status),0) AS status 
					FROM trusmi_attendance_quiz 
					WHERE employee_id = $user_id
					AND attendance_date = CURRENT_DATE
					LIMIT 1
				) quiz ON quiz.employee_id = xin_employees.user_id -- 2023-03-09 08:37
			WHERE
				xin_employees.user_id = $user_id";

		return $this->db->query($query)->row_array();
	}

	function cek_absen_lalu($user_id)
	{
		return $this->db->query("SELECT
				Max( xin_attendance_time.time_attendance_id ) AS id_terakhir,
				MAX( xin_attendance_time.clock_in ) AS clock_in  
			FROM
				xin_attendance_time 
			WHERE
				xin_attendance_time.employee_id = $user_id")->row_array();
	}

	function profil1($user_id, $date)
	{
		$query = "SELECT
				xin_employees.user_id,
				xin_employees.first_name,
				xin_employees.last_name,
				xin_employees.designation_id,
				xin_designations.designation_name,
				xin_employees.profile_picture,
				xin_employees.gender,
				absen.photo_in,
				absen.clock_in,
				absen.photo_out,
				absen.clock_out,
				absen.total_work
			FROM
				xin_employees
				LEFT JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
				LEFT JOIN (
				SELECT
					xin_attendance_time.employee_id,
					xin_attendance_time.clock_in,
					xin_attendance_time.photo_in,
					xin_attendance_time.clock_out,
					xin_attendance_time.photo_out,
					xin_attendance_time.total_work
				FROM
					xin_attendance_time 
				) AS absen ON xin_employees.user_id = absen.employee_id LIMIT 1";

		return $this->db->query($query)->row_array();
	}

	function get_shift($user_id)
	{
		return $this->db->query("SELECT
				xin_employees.office_shift_id 
			FROM
				xin_employees 
			WHERE
				xin_employees.user_id = $user_id")->row_array();
	}

	function cek_company($user_id)
	{
		return $this->db->query("SELECT company_id FROM xin_employees WHERE user_id = '$user_id'")->row();
	}


	function get_status($user_id)
	{
		// return $this->db->query("SELECT
		// 		xin_employees.is_active 
		// 	FROM
		// 		xin_employees 
		// 	WHERE
		// 		xin_employees.user_id = $user_id LIMIT 1")->row_array();		


		// $cek = $this->db->query("SELECT company_id FROM xin_employees WHERE user_id = $user_id LIMIT 1")->row_array();
		// if($cek['company_id'] == '3'){
		// 	$ip_address = $_SERVER['host_name'];
		// 	if($ip_address=='103.39.50.142'){
		// 		return $this->db->query("SELECT
		// 			0 AS `is_active`,
		// 			view_absen_lock.booking
		// 		FROM xin_employees 
		// 		LEFT JOIN view_absen_lock ON view_absen_lock.id_hr = xin_employees.user_id
		// 		WHERE xin_employees.user_id = $user_id LIMIT 1")->row_array();		
		// 	}else{
		// 		return $this->db->query("SELECT
		// 					CASE 
		// 						WHEN view_absen_lock.booking=0 AND view_absen_lock.`status`=0 AND xin_employees.is_active=1
		// 							THEN 0
		// 						ELSE xin_employees.is_active
		// 					END AS `is_active`,
		// 					view_absen_lock.booking
		// 				FROM xin_employees 
		// 				LEFT JOIN view_absen_lock ON view_absen_lock.id_hr = xin_employees.user_id
		// 				WHERE xin_employees.user_id = $user_id LIMIT 1")->row_array();		
		// 	}

		// }else{
		return $this->db->query("SELECT
					CASE 
						WHEN view_absen_lock.booking=0 AND view_absen_lock.`status`=0 AND xin_employees.is_active=1
							THEN 0
						ELSE xin_employees.is_active
					END AS `is_active`,
					view_absen_lock.booking
				FROM xin_employees 
				LEFT JOIN view_absen_lock ON view_absen_lock.id_hr = xin_employees.user_id
				WHERE xin_employees.user_id = $user_id LIMIT 1")->row_array();
		// }

	}

	public function lock_absen_app_old_version()
	{
		return $this->db->query("SELECT * FROM trusmi_m_lock WHERE id_lock =35")->row_array();
	}

	function cek_bday($user_id)
	{
		$cur_year = date('Y');
		$date = date('m-d');
		$query = "SELECT 
					CONCAT(first_name,' ',last_name) as `name`,
					$cur_year - SUBSTR(date_of_birth,1,4) AS age,
					date_of_birth
				FROM xin_employees 
				WHERE SUBSTR(date_of_birth,6,5) = '$date'
				AND user_id = $user_id";
		return $this->db->query($query)->row_array();
	}

	function cek_dep_bad($user_id)
	{
		$data = $this->db->query("SELECT
			xin_departments.department_id 
		FROM
			xin_employees
			JOIN xin_departments ON xin_departments.department_id = xin_employees.department_id 
		WHERE
			xin_employees.user_id = $user_id")->row_array();

		return $data['department_id'];
	}

	function list_emp_notif($department_id, $type)
	{
		if ($type == 1) {
			$order = "ORDER BY trusmi_bad_emp.score DESC";
		} else {
			$order = "ORDER BY trusmi_bad_emp.score ASC";
		}
		return $this->db->query("SELECT
			trusmi_bad_emp.id,
			trusmi_bad_emp.user_id,
			trusmi_bad_emp.score,
			trusmi_bad_emp.periode,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS employee,
			xin_designations.designation_name AS jabatan,
		CASE
				
				WHEN xin_employees.profile_picture IS NOT NULL 
				AND xin_employees.profile_picture != '' THEN
					CONCAT( 'hr/uploads/profile/', xin_employees.profile_picture ) ELSE (
					SELECT
						CONCAT( 'hr_upload/', MAX( xin_attendance_time.photo_in ) ) AS absen 
					FROM
						xin_attendance_time 
					WHERE
						xin_attendance_time.employee_id = trusmi_bad_emp.user_id 
					ORDER BY
						xin_attendance_time.time_attendance_id DESC
						LIMIT 1 
					) 
				END AS profile_picture
				FROM
					trusmi_bad_emp
					JOIN xin_employees ON trusmi_bad_emp.user_id = xin_employees.user_id
					JOIN xin_designations ON xin_designations.designation_id = xin_employees.designation_id
					JOIN trusmi_batch_dep ON FIND_IN_SET( xin_employees.department_id, trusmi_batch_dep.department_id )  
				WHERE
					trusmi_bad_emp.periode = SUBSTR( CURDATE( ) - INTERVAL 1 MONTH, 1, 7 ) 
					AND trusmi_bad_emp.type = $type
					AND FIND_IN_SET( $department_id, trusmi_batch_dep.department_id ) 
			$order");
	}

	function get_user_approval_eaf($id)
	{
		// return $this->db->query("SELECT
		// 							x.id_hr,
		// 							CONCAT( emp.first_name, ' ', emp.last_name ) AS `name` 
		// 						FROM
		// 							(
		// 							SELECT
		// 								usr_rsp.id_hr 
		// 							FROM
		// 								( SELECT id_user_approval FROM rsp_project_live.e_jenis_biaya GROUP BY id_user_approval ) AS usr_approval
		// 								JOIN ( SELECT id_user, employee_name, id_hr FROM rsp_project_live.`user` WHERE isActive = 1 ) AS usr_rsp ON usr_rsp.id_user = usr_approval.id_user_approval UNION ALL
		// 							SELECT
		// 								e_pengajuan.pengaju 
		// 							FROM
		// 								rsp_project_live.e_pengajuan AS e_pengajuan 
		// 							WHERE
		// 								e_pengajuan.pengaju IS NOT NULL 
		// 							GROUP BY
		// 								e_pengajuan.pengaju 
		// 							) AS x
		// 							LEFT JOIN hris.xin_employees AS emp ON emp.user_id = x.id_hr 
		// 						WHERE
		// 							x.id_hr = '$id'")->row_array();

		// Akun Mba Ade Finance berjalan & bisa di Lock, jika user Finance di RSP id_user = 737 dan id_hr = 79
		return $this->db->query("SELECT
										x.id_hr,
										CONCAT( emp.first_name, ' ', emp.last_name ) AS `name` 
									FROM
										(
										SELECT
											usr_rsp.id_hr 
										FROM
											( SELECT id_user_approval FROM rsp_project_live.e_jenis_biaya GROUP BY id_user_approval ) AS usr_approval
											JOIN ( SELECT id_user, employee_name, id_hr FROM rsp_project_live.`user` WHERE isActive = 1 ) AS usr_rsp ON usr_rsp.id_user = usr_approval.id_user_approval UNION ALL
										SELECT
											e_pengajuan.pengaju AS id_hr 
										FROM
											rsp_project_live.e_pengajuan AS e_pengajuan 
										WHERE
											e_pengajuan.pengaju IS NOT NULL 
										GROUP BY
											e_pengajuan.pengaju UNION ALL
										SELECT
										IF
											( usr_rsp.id_hr = 737, 79, usr_rsp.id_hr ) AS id_hr 
										FROM
											rsp_project_live.e_jenis_biaya AS e_jenis_biaya
											JOIN ( SELECT id_user, employee_name, id_hr FROM rsp_project_live.`user` WHERE isActive = 1 ) AS usr_rsp ON usr_rsp.id_user = e_jenis_biaya.id_user_verified 
										WHERE
											e_jenis_biaya.id_user_verified IS NOT NULL 
										GROUP BY
											e_jenis_biaya.id_user_verified UNION ALL
										SELECT
											employee_id AS id_hr 
										FROM
											hris.trusmi_lock_absen_manual 
										) AS x
										LEFT JOIN hris.xin_employees AS emp ON emp.user_id = x.id_hr 
									WHERE
										x.id_hr = '$id' 
									GROUP BY
										x.id_hr")->row_array();
	}

	function get_lock_eaf($id)
	{
		return $this->db->query("SELECT * FROM hris.lock_eaf WHERE id_hr = '$id'")->row_array();
	}

	// Lock MEP
	function cek_designation($id)
	{
		return $this->db->query("SELECT * FROM xin_employees as em WHERE em.user_id = '$id'")->row_array();
	}

	function get_lock_mep($id)
	{
		return $this->db->query("SELECT * FROM hris.lock_mep WHERE id_hr = '$id'")->row_array();
	}
	// End Lock MEP

	// Auto Non Aktif Akun
	function cek_resignation($user_id)
	{
		$query = "SELECT date_of_leaving FROM xin_employees WHERE user_id = '$user_id' AND date_of_leaving=current_date";
		$data_leaving = $this->db->query($query);
		if ($data_leaving->num_rows() > 0) {
			$data_non_aktif = [
				'is_active' => 0
			];
			$this->db->where('user_id', $user_id);
			$this->db->update('xin_employees', $data_non_aktif);
			$akun_rsp = $this->db->query("SELECT id_user FROM rsp_project_live.user WHERE id_hr = '$user_id'");
			if ($akun_rsp->num_rows() > 0) {
				$data_non_aktif_rsp = [
					'isActive' => 0,
					'nonactive_at' => date("Y-m-d H:i:s")
				];
				$this->db->where('id_hr', $user_id);
				$this->db->update('rsp_project_live.user', $data_non_aktif_rsp);
			}
		}
		return true;
	}


	function getProfile($user_id)
	{
		return $this->db->query("SELECT user_id, company_id, department_id, designation_id, date_of_joining, date_of_leaving, is_active FROM xin_employees WHERE user_id = '$user_id'");
	}

	function isPelaksanaLock($user_id)
	{
		return $this->db->query("SELECT l.id_lock, l.warning_lock, divisi, total, created_at, spv FROM absen_pelaksana
			LEFT JOIN trusmi_m_lock l ON l.id_lock = CASE WHEN absen_pelaksana.spv = 1 THEN 36 ELSE 3 END 
			 WHERE id_hr = $user_id LIMIT 1");
	}

	function isPurchasingBtLock($user_id)
	{
		$DB2 = $this->load->database('purchasing_crb', TRUE);
		return $DB2->query("SELECT dt.*, m_lock.id_lock, m_lock.warning_lock, 1477 AS divisi  FROM(

				SELECT CURRENT_DATE AS created_at, v_lock_absen_pcs.id_user AS created_by, username AS employee_name, id_hr, 
				CASE WHEN sts > 1 THEN 1 ELSE 0 END AS absen, tipe
				FROM v_lock_absen_pcs
				JOIN `user` ON `user`.id_user = v_lock_absen_pcs.id_user
				WHERE v_lock_absen_pcs.sts > 1
				
				UNION ALL
				
				SELECT * FROM v_absen_alarm_po WHERE tipe IS NOT NULL
				-- AND created_by NOT IN (177, 236, 220, 247, 251, 202, 150)
				) dt 
				JOIN m_lock ON m_lock.id_lock = dt.tipe
				WHERE id_hr = $user_id
				GROUP BY id_hr
				;");
	}

	function isStoreBtLock($user_id)
	{
		return $this->db->query("SELECT dt.*, 1400 AS divisi, 18 AS id_lock, CONCAT('Maaf Daily Tasklist Anda Belum achive ', acv , '% dari 100%') AS warning_lock FROM( SELECT * FROM absen_store) dt WHERE id_hr = $user_id LIMIT 1");
	}

	function isScmBtLock($user_id)
	{
		$DB2 = $this->load->database('purchasing_crb', TRUE);
		return $DB2->query("SELECT 
		9500 AS divisi, created_at, created_by, employee_name, id_hr, absen, warning_lock
		FROM lock_scm_all 
		LEFT JOIN m_lock ON m_lock.id_lock = lock_scm_all.tipe
		WHERE id_hr = $user_id");
	}

	function isMarketingLock($user_id)
	{
		return $this->db->query(
			"SELECT
					absen_mkt.divisi,
					absen_mkt.total,
					absen_mkt.created_at,
					absen_mkt.spv,
					trusmi_m_lock.id_lock,
					trusmi_m_lock.status_lock,
					REPLACE ( trusmi_m_lock.warning_lock, '[change]', absen_mkt.total ) AS warning_lock 
				FROM
					absen_mkt
					JOIN trusmi_m_lock ON absen_mkt.spv = trusmi_m_lock.id_lock 
				WHERE
					absen_mkt.id_hr = $user_id
					LIMIT 1"
		);
	}

	function isHrRspLock($user_id)
	{
		return $this->db->query("SELECT id_hr, actual, `target`, total, id_lock, status_lock, warning_lock FROM view_lock_absen_hr WHERE id_hr='$user_id' ORDER BY total ASC LIMIT 1");
	}

	function isBasicTrainingKaryawanRsp($user_id)
	{
		return $this->db->query("SELECT user_id, actual, `target`, total, id_lock, status_lock, warning_lock , ket FROM view_lock_absen_karyawan_basic_training WHERE user_id='$user_id' LIMIT 1");
	}

	function isBasicTrainingMarketingLock($user_id)
	{
		return $this->db->query("SELECT id_hr, total, id_lock, status_lock, warning_lock , ket FROM view_lock_absen_karyawan_basic_training_marketing WHERE id_hr='$user_id' LIMIT 1");
	}
}
