<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_grd_manpower extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_support($divisi, $start, $end){
		// $periode = DateTime::createFromFormat('m-Y', $month)->format('Y-m');		
		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}
		$query = "SELECT
					det.divisi,
					COALESCE ( ibr.jumlah, 0 ) AS ibr_jumlah,
					COALESCE ( ibr.jln_berhasil, 0 ) AS ibr_jln_berhasil,
					COALESCE ( ibr.tdk_berhasil, 0 ) AS ibr_tdk_berhasil,
					COALESCE ( ibr.tdk_jalan, 0 ) AS ibr_tdk_jalan,
					COALESCE ( ibr.progres, 0 ) AS ibr_progres,
					COALESCE ( ibr.belum, 0 ) AS ibr_belum,
					ROUND( COALESCE (( ibr.jln_berhasil / NULLIF( ibr.jumlah, 0 )) * 100, 0 ), 0 ) AS persen_jln_berhasil,
					ROUND( COALESCE (( ibr.tdk_berhasil / NULLIF( ibr.jumlah, 0 )) * 100, 0 ), 0 ) AS persen_tdk_berhasil,
					ROUND( COALESCE (( ibr.tdk_jalan / NULLIF( ibr.jumlah, 0 )) * 100, 0 ), 0 ) AS persen_tdk_jalan,
					ROUND( COALESCE (( ibr.progres / NULLIF( ibr.jumlah, 0 )) * 100, 0 ), 0 ) AS persen_progres,
					ROUND( COALESCE (( ibr.belum / NULLIF( ibr.jumlah, 0 )) * 100, 0 ), 0 ) AS persen_belum,
					COALESCE ( mom.jumlah, 0 ) AS mom_jumlah,
					COALESCE ( tt.jumlah, 0 ) AS tt_jumlah,
					COALESCE ( tt.rating, 0 ) AS tt_rating,
					COALESCE ( gen.jumlah, 0 ) AS gen_jumlah,
					COALESCE ( gen.jln_berhasil, 0 ) AS gen_jln_berhasil,
					COALESCE ( gen.tdk_berhasil, 0 ) AS gen_tdk_berhasil,
					COALESCE ( gen.tdk_jalan, 0 ) AS gen_tdk_jalan,
					COALESCE ( gen.progres, 0 ) AS gen_progres,
					COALESCE ( gen.belum, 0 ) AS gen_belum,
					ROUND( COALESCE (( gen.jln_berhasil / NULLIF( gen.jumlah, 0 )) * 100, 0 ), 0 ) AS gen_persen_jln_berhasil,
					ROUND( COALESCE (( gen.tdk_berhasil / NULLIF( gen.jumlah, 0 )) * 100, 0 ), 0 ) AS gen_persen_tdk_berhasil,
					ROUND( COALESCE (( gen.tdk_jalan / NULLIF( gen.jumlah, 0 )) * 100, 0 ), 0 ) AS gen_persen_tdk_jalan,
					ROUND( COALESCE (( gen.progres / NULLIF( gen.jumlah, 0 )) * 100, 0 ), 0 ) AS gen_persen_progres,
					ROUND( COALESCE (( gen.belum / NULLIF( gen.jumlah, 0 )) * 100, 0 ), 0 ) AS gen_persen_belum,
					COALESCE ( solving.jumlah, 0 ) AS solving_jumlah,
					COALESCE ( sharing.jumlah, 0 ) AS sharing_jumlah,
					COALESCE ( oneby.jumlah, 0 ) AS oneby_jumlah,
					COALESCE ( brief.jumlah, 0 ) AS brief_jumlah
				FROM
					grd_t_tasklist det
					LEFT JOIN grd_t_si sub ON sub.id_si = det.id_si
					LEFT JOIN `grd_m_so` so ON so.id_so = sub.id_so
					LEFT JOIN (
					SELECT
						COUNT( td_task.id_task ) AS jumlah,
						SUM( CASE WHEN sub.`status` = 1 THEN 1 ELSE 0 END ) AS jln_berhasil,
						SUM( CASE WHEN sub.`status` = 2 THEN 1 ELSE 0 END ) AS tdk_berhasil,
						SUM( CASE WHEN sub.`status` = 3 THEN 1 ELSE 0 END ) AS tdk_jalan,
						SUM( CASE WHEN sub.`status` = 4 THEN 1 ELSE 0 END ) AS progres,
						SUM( CASE WHEN sub.`status` IS NULL THEN 1 ELSE 0 END ) AS belum,
						td_task.divisi 
					FROM
						td_task
						LEFT JOIN td_sub_task sub ON td_task.id_task = sub.id_task
						LEFT JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, td_task.tasklist ) 
					WHERE
						DATE ( td_task.created_at ) BETWEEN '$start' AND '$end'
					GROUP BY
						td_task.divisi 
					) ibr ON ibr.divisi = det.divisi
					LEFT JOIN (
					SELECT
						COUNT( id_mom ) AS jumlah,
						mom_header.divisi 
					FROM
						mom_header
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, mom_header.tasklist ) 
					WHERE
						DATE ( mom_header.created_at ) BETWEEN '$start' AND '$end' 
					GROUP BY
						mom_header.divisi 
					) mom ON mom.divisi = det.divisi
					LEFT JOIN (
					SELECT
						chat.pekerjaan,
						chat.sub_pekerjaan,
						COUNT( id_chat ) AS jumlah,
						ROUND( AVG( rate_pelayanan ), 0 ) AS rating,
						chat.divisi 
					FROM
						rsp_project_live.t_chat_bm chat
						JOIN hris.t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, chat.tasklist ) 
					WHERE
						DATE ( chat.created_at ) BETWEEN '$start' AND '$end'
					GROUP BY
						chat.divisi 
					) tt ON tt.divisi = det.divisi
					LEFT JOIN (
					SELECT
						COUNT( id_gemba ) AS jumlah,
						SUM( CASE WHEN gemba.`status` = 1 THEN 1 ELSE 0 END ) AS jln_berhasil,
						SUM( CASE WHEN gemba.`status` = 2 THEN 1 ELSE 0 END ) AS tdk_berhasil,
						SUM( CASE WHEN gemba.`status` = 3 THEN 1 ELSE 0 END ) AS tdk_jalan,
						SUM( CASE WHEN gemba.`status` = 4 THEN 1 ELSE 0 END ) AS progres,
						SUM( CASE WHEN gemba.`status` IS NULL THEN 1 ELSE 0 END ) AS belum,
						gemba.divisi 
					FROM
						gemba
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, gemba.tasklist ) 
					WHERE
						DATE ( gemba.created_at ) BETWEEN '$start' AND '$end' 
					GROUP BY
						gemba.divisi 
					) gen ON gen.divisi = det.divisi
					LEFT JOIN (
					SELECT
						COUNT( id_ps ) AS jumlah,
						ps_task.divisi 
					FROM
						ps_task
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, ps_task.tasklist ) 
					WHERE
						DATE ( ps_task.created_at ) BETWEEN '$start' AND '$end'
					GROUP BY
						ps_task.divisi 
					) solving ON solving.divisi = det.divisi
					LEFT JOIN (
					SELECT
						COUNT( id_sl ) AS jumlah,
						t_sharing_leader.divisi 
					FROM
						t_sharing_leader
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, t_sharing_leader.tasklist ) 
					WHERE
						DATE ( t_sharing_leader.created_at) BETWEEN '$start' AND '$end' 
					GROUP BY
						t_sharing_leader.divisi 
					) sharing ON sharing.divisi = det.divisi
					LEFT JOIN (
					SELECT
						COUNT( id_one ) AS jumlah,
						one_header.divisi 
					FROM
						one_header
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, one_header.tasklist ) 
					WHERE
						DATE ( one_header.created_at ) BETWEEN '$start' AND '$end'
					GROUP BY
						one_header.divisi 
					) oneby ON oneby.divisi = det.divisi
					LEFT JOIN(
					SELECT
						COUNT( id_briefing ) AS jumlah,
						briefing.divisi 
					FROM
						briefing
						JOIN t_detail_pekerjaan det ON FIND_IN_SET( det.id_tasklist, briefing.tasklist ) 
					WHERE
						DATE ( briefing.created_at ) BETWEEN '$start' AND '$end'
					GROUP BY
						briefing.divisi 
					) brief ON brief.divisi = det.divisi
					
				WHERE
					-- det.divisi = 'Operasional' 
					det.divisi = '$divisi' 
				GROUP BY
					det.divisi";
		return $this->db->query($query)->row_object();
	}

	public function get_warning_manpower($start, $end){
		// $periode = DateTime::createFromFormat('m-Y', $month)->format('Y-m');
		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}
		$query = "SELECT 
				SUM(CASE WHEN nama = 'Lock' THEN jumlah ELSE 0 END) AS lk,
				SUM(CASE WHEN nama = 'ST' THEN jumlah ELSE 0 END) AS st,
				SUM(CASE WHEN nama = 'SP' THEN jumlah ELSE 0 END) AS sp,
				SUM(CASE WHEN nama = 'Denda' THEN jumlah ELSE 0 END) AS denda,
				SUM(CASE WHEN nama = 'Denda' THEN detail ELSE 0 END) AS nominal
			FROM (
				SELECT
					'Lock' AS nama,
					SUM(total) AS jumlah,
					'' AS detail
				FROM (
					SELECT
						his.employee_id,
						his.lock_type,
						CONCAT(emp.first_name, '', emp.last_name) AS employee_name,
						COUNT(his.employee_id) AS total
					FROM
						trusmi_history_lock his
						JOIN xin_employees emp ON his.employee_id = emp.user_id 
					WHERE
						emp.company_id = 5
						AND DATE(his.created_at) BETWEEN '$start' AND '$end'
					GROUP BY emp.user_id, his.lock_type
				) AS subquery

				UNION ALL

				SELECT
					'ST' AS nama,
					COUNT(warning.warning_id) AS jumlah,
					'' AS detail
				FROM
					xin_employee_warnings warning
				WHERE 
					warning.company_id = 5 
					AND warning.warning_type_id = 1 
					AND DATE(warning.created_at) BETWEEN '$start' AND '$end'

				UNION ALL

				SELECT
					'SP' AS nama,
					COUNT(warning.warning_id) AS jumlah,
					'' AS detail
				FROM
					xin_employee_warnings warning
				WHERE 
					warning.company_id = 5 
					AND warning.warning_type_id IN (2,3,4) 
					AND DATE(warning.created_at) BETWEEN '$start' AND '$end'
					
				UNION ALL
				SELECT
					'Denda' AS nama,
					COUNT( trusmi_denda.id ) AS jumlah ,
					trusmi_denda.nominal AS detail
				FROM
					trusmi_denda
					LEFT JOIN xin_employees emp ON emp.user_id = trusmi_denda.employee_id 
				WHERE
					emp.company_id = 5 
					AND DATE ( trusmi_denda.created_at ) BETWEEN '$start' AND '$end'
					
			) AS combined_data;
";
		return $this->db->query($query)->row_object();
	}
	public function get_warning_manpower_kehadiran($start, $end){

		// $periode = DateTime::createFromFormat('m-Y', $month)->format('Y-m');
		// $start = date('Y-m', strtotime('-1 month', strtotime($periode))) . '-21';
		// $end = $periode . '-20';
		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}


		$query = "SELECT
			SUM( data_all_absen.harus_hadir ) AS harus_hadir,
			SUM( data_all_absen.total_hadir ) AS total_hadir,
			ROUND(CASE 
				WHEN SUM(data_all_absen.harus_hadir) = 0 THEN 0
				ELSE (SUM(data_all_absen.total_hadir) / SUM(data_all_absen.harus_hadir)) * 100
			END,1) AS persen_hadir,
			CASE 
				WHEN ROUND(CASE 
					WHEN SUM(data_all_absen.harus_hadir) = 0 THEN 0
					ELSE (SUM(data_all_absen.total_hadir) / SUM(data_all_absen.harus_hadir)) * 100
				END,1) < 60 THEN 'red'
				
				WHEN ROUND(CASE 
					WHEN SUM(data_all_absen.harus_hadir) = 0 THEN 0
					ELSE (SUM(data_all_absen.total_hadir) / SUM(data_all_absen.harus_hadir)) * 100
				END,1) BETWEEN 60 AND 75 THEN 'yellow'
				
				ELSE 'green'
			END AS warna
		FROM
			(
			SELECT COALESCE
		(
			trusmi_harus_hadir.harus_hadir,
			CASE

			WHEN rekap.designation_id IN ( 9, 10, 395, 441 ) THEN
			21 
			WHEN rekap.designation_id = 458 THEN
			COUNT( rekap.`status` ) 
			WHEN rekap.user_role_id = 8 THEN
			COUNT(
			IF
			(
			rekap.`status` NOT IN ( '', 'A', 'F', 'LV', 'LT', 'LE', 'LR', 'LA', 'R' ),
			1,
			NULL 
			)) 
			WHEN COUNT(
			IF
			( rekap.`status` = 'R', 1, NULL )) > 0 THEN
			COUNT(
			IF
			( rekap.`status` NOT IN ( '', 'R' ), 1, NULL )) - COUNT(
			IF
			( rekap.libur_aktif = 1, 1, NULL )) ELSE COUNT( rekap.`status` ) -
			IF
			(
			rekap.libur > 0,
			rekap.libur,
			COUNT(
			IF
			( rekap.hari = 'Sun' AND rekap.date >= rekap.date_of_joining, 1, NULL ))) - COUNT(
			IF
			( rekap.`status` = '', 1, NULL )) 
			END 
			) AS harus_hadir,
			COUNT( IF (
			rekap.`status` NOT IN ( '', 'A', 'F', 'LV', 'LT', 'LE', 'LR', 'LA', 'R' ),
			1, NULL  )) AS total_hadir 
			FROM
			( SELECT
			xin_employees.user_id,
			CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `employee`,
			xin_departments.department_name AS department,
			xin_designations.designation_name AS designation,
			xin_office_location.location_name AS location,
			xin_employees.user_role_id,
			xin_employees.date_of_joining,
			xin_employees.date_of_leaving,
			xin_employees.designation_id,
			xin_leave_applications.leave_id,
			xin_departments.libur,
			IF ( xin_employees.date_of_leaving != '' 
			AND xin_employees.date_of_leaving < all_dates.date,
			NULL,
			IF (
			DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' 
			AND IF ( all_dates.date < xin_employees.date_of_joining, '', NULL ) != '', 1,
			NULL )) AS libur_aktif,
			CASE-- Karyawan baru join tidak absen
			WHEN all_dates.date < xin_employees.date_of_joining THEN
			'' -- Karyawan baru absen
			WHEN xin_employees.date_of_joining = xin_attendance_time.attendance_date THEN
			'P' --  Resign

			WHEN xin_employees.date_of_leaving != '' 
			AND xin_employees.date_of_leaving < all_dates.date THEN 'R' --  Hari Esok
			WHEN all_dates.date > CURDATE() THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END --  Pergantian Hari Libur

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 7 THEN
			CASE

			WHEN xin_leave_applications.tgl_ph < '$end' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'H' 
			END 
			WHEN ganti_libur.holiday_id IS NOT NULL THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'H' 
			END 
			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NOT NULL THEN
			'P' ELSE
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			END --  Cuti Tahunan

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id IN ( 1, 14 ) THEN
			'C' --  Cuti Menikah

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 2 THEN
			'M' --  Izin Sakit

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 5 THEN
			'S' --  Cuti Bersalin

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id IN ( 3, 8 ) THEN
			CASE--  Libur Mingguan/Pergantian hari libur dalam periode cutoff

			WHEN xin_office_shift.monday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.tuesday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.wednesday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.thursday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.friday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.saturday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN ( xin_office_shift.sunday_in_time = '' OR xin_leave_applications.leave_type_id IN ( 3, 8 ) ) 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off

			WHEN xin_holidays.event_name IS NOT NULL THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'H' 
			END --  Absent
			ELSE 'CB' 
			END --  Pernikahan anak / saudara

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND ( xin_leave_applications.leave_type_id = 15 OR xin_leave_applications.leave_type_id = 16 ) THEN
			'PR' --  Khitan Anak

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 25 THEN
			'KA' --  Keluarga sakit

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND ( xin_leave_applications.leave_type_id = 21 OR xin_leave_applications.leave_type_id = 22 ) THEN
			'SK' --  Kematan Keluarga

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND ( xin_leave_applications.leave_type_id = 9 || xin_leave_applications.leave_type_id = 17 ) THEN
			'KL' --  Wisuda/skripsi

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 18 THEN
			'SW' --  DLK non driver

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 13 
			AND
			IF
			( IF ( xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL ) <
			IF ( xin_leave_applications.to_date = all_dates.date, CONCAT( xin_attendance_time.shift_in, ':00' ), NULL ), 1, 0  ) = 0 THEN 'DL' --  DLK driver

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 23 THEN
			'DD' --  Skripsi/wisuda

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 18 THEN
			'SW' --  Cuti thun lalu

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 19 THEN
			'CL' --  Telat (lebih 40% termasuk absen)

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND
			IF
			( DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), 1, 0 ) = 1 
			AND xin_leave_applications.leave_id IS NULL THEN
			CASE WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF( MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.4  ) MINUTE THEN-- Kondisi Shift Store
			CASE WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) > 479 
			AND xin_employees.office_shift_id IN ( 7, 11, 12, 13, 14, 18, 21 ) THEN
			'P' -- Jam masuk dan jam pulang sama
 			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' ELSE
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			END ELSE -- Kondisi Shift Store
			CASE

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) > 479 
			AND xin_employees.office_shift_id IN ( 7, 11, 12, 13, 14, 18, 21 ) THEN
			'P' ELSE
			CASE

			WHEN xin_attendance_time.clock_out IS NULL THEN
			'F' ELSE
			CASE

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NULL 
			AND locked.employee_id IS NOT NULL THEN
			CASE

			WHEN locked.jenis = 'tasklist' THEN
			'LT' 
			WHEN locked.jenis = 'eaf' THEN
			'LE' 
			WHEN locked.jenis = 'training' THEN
			'LR' 
			WHEN locked.jenis IS NULL THEN
			'LA' ELSE 'lock' 
			END ELSE
			CASE

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND xin_attendance_time.clock_out IS NULL THEN
			'F' ELSE 'T' 
			END 
			END 
			END 
			END 
			END -- Flat Shift

			WHEN (
			CASE

			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
			480 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
			540 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
			600 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
			660 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
			720 ELSE NULL 
			END 
			) > TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) THEN
			'NP' 
			WHEN (
			CASE

			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
			480 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
			540 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
			600 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
			660 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
			720 ELSE NULL 
			END 
			) < TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) THEN
			'P' --  Pulang Cepat (kurang 60% termasuk absen)

			WHEN xin_attendance_time.clock_out IS NOT NULL 
			AND
			IF ( xin_attendance_time.clock_out < IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			), 1, 0  ) = 1 
			AND xin_leave_applications.leave_id IS NULL THEN
			CASE

			WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF(
			MINUTE, IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			), IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.6 
			) MINUTE THEN
			CASE

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' ELSE
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			END 
			WHEN SUBSTR(
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF(
			MINUTE,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF
			(
			xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.6  ) MINUTE, 12  ) = '00:00:00' THEN-- Jam masuk dan jam pulang sama
			CASE

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' ELSE 'P' 
			END ELSE
			CASE

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' ELSE 'NP' 
			END 
			END --  Absen 1x Karna Lock

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NULL 
			AND locked.employee_id IS NOT NULL THEN
			CASE

			WHEN locked.jenis = 'video' THEN
			'LV' 
			WHEN locked.jenis = 'tasklist' THEN
			'LT' 
			WHEN locked.jenis = 'eaf' THEN
			'LE' 
			WHEN locked.jenis = 'training' THEN
			'LR' 
			WHEN locked.jenis IS NULL THEN
			'LA' ELSE '' 
			END --  Izin datang terlambat (lebih 40% termasuk absen)

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 11 THEN
			CASE

			WHEN xin_attendance_time.clock_out IS NULL THEN
			'F' 
			WHEN
			IF
			(
			DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > DATE_FORMAT(
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF(
			MINUTE,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF
			(
			xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.4 
			) MINUTE,
			'%Y-%m-%d %H:%i:00' 
			),
			TIMESTAMPDIFF(
			MINUTE,
			DATE_FORMAT(
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF(
			MINUTE,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF
			(
			xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.4 
			) MINUTE,
			'%Y-%m-%d %H:%i:00' 
			),
			DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )), 0  ) > 10 THEN 'A' ELSE 'DT' 
			END --  Izin pulang cepat (kurang 60% termasuk absen)

			WHEN xin_leave_applications.leave_id IS NOT NULL 
			AND xin_leave_applications.leave_type_id = 10 THEN
			CASE

			WHEN xin_attendance_time.clock_out IS NULL THEN
			'F' 
			WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND( TIMESTAMPDIFF( MINUTE, IF
			( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			), IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.6 ) MINUTE THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN
			IF
			( DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ) < DATE_FORMAT(
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF( MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.6  ) MINUTE, '%Y-%m-%d %H:%i:00' ),
			TIMESTAMPDIFF(
			MINUTE, DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
			DATE_FORMAT(
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
			TIMESTAMPDIFF( MINUTE, CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
			IF ( xin_attendance_time.shift_in > '17:00',
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
			CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
			))* 0.6  ) MINUTE, '%Y-%m-%d %H:%i:00' 
			)), 0  ) > 10 THEN 'A' ELSE 'PC' 
			END --  Absen 1x di hari libur nasional

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NULL 
			AND xin_holidays.event_name IS NOT NULL THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'H' 
			END --  Absen 1x kecuali

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NULL THEN
			'F' -- Jam masuk dan pulang sama

			WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
			'F' --  Libur Mingguan/Pergantian hari libur dalam periode cutoff

			WHEN xin_office_shift.monday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.tuesday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.wednesday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.thursday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.friday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.saturday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			WHEN xin_office_shift.sunday_in_time = '' 
			AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off

			WHEN xin_holidays.event_name IS NOT NULL 
			AND xin_attendance_time.clock_in IS NULL 
			AND xin_attendance_time.clock_out IS NULL THEN
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'H' 
			END -- lock manual

			WHEN manual_locked.jenis IS NOT NULL 
			AND manual_locked.jenis = 'video' THEN
			'LV' 
			WHEN manual_locked.jenis IS NOT NULL 
			AND manual_locked.jenis = 'other' THEN
			'LA' --  Absent
			--  Present (hadir)

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
			AND xin_attendance_time.clock_out IS NOT NULL THEN
			'P' -- Tidak Absen karna Lock

			WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NULL 
			AND xin_attendance_time.clock_out IS NULL 
			AND locked.employee_id IS NOT NULL THEN
			CASE

			WHEN locked.jenis = 'video' THEN
			'LV' 
			WHEN locked.jenis = 'tasklist' THEN
			'LT' 
			WHEN locked.jenis = 'eaf' THEN
			'LE' 
			WHEN locked.jenis = 'training' THEN
			'LR' 
			WHEN locked.jenis IS NULL THEN
			'LA' ELSE '' 
			END ELSE
			CASE

			WHEN xin_employees.user_role_id = 8 THEN
			'' ELSE 'A' 
			END 
			END AS `status`,
			all_dates.date,
			xin_attendance_time.attendance_date,
			xin_employees.office_shift_id,
			xin_designations.trusmi_shift,
			DATE_FORMAT( all_dates.date, '%a' ) hari,
			CASE

			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
			480 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
			540 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
			600 
			WHEN xin_attendance_time.clock_in IS NOT NULL 
			AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
				660 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
					720 ELSE NULL 
					END AS jam_flat,
				TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) AS jam_kerja,
			IF
				( xin_holidays.event_name IS NOT NULL, 1, NULL ) AS holiday,
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) AS clock_in,
				CONCAT(
					'JM',
					DATE_FORMAT( xin_attendance_time.clock_in, '%H:%i' ),
					'JP',
				DATE_FORMAT( xin_attendance_time.clock_out, '%H:%i' )) AS jam_absen,
			IF
				(
					TIMESTAMPDIFF(
						MINUTE,
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
					DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
					TIMESTAMPDIFF(
						MINUTE,
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
					DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
				NULL 
				) AS telat,
			IF
				(
					TIMESTAMPDIFF(
						MINUTE,
						DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
					IF
						(
							xin_attendance_time.shift_in > '17:00',
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
						))> 0,
					TIMESTAMPDIFF(
						MINUTE,
						DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
					IF
						(
							xin_attendance_time.shift_in > '17:00',
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
						)),
				NULL 
				) AS telat_pc,
				CEILING(
				IF
					(
						TIMESTAMPDIFF(
							MINUTE,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
						DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
						TIMESTAMPDIFF(
							MINUTE,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
						DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
					NULL 
					) / 60 
				) * 60 AS tambah_menit,
			IF
				(
					TIMESTAMPDIFF(
						MINUTE,
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
					DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
					TIMESTAMPDIFF(
						MINUTE,
					IF
						(
							xin_attendance_time.shift_in > '17:00',
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
						),
					DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' )),
				NULL 
				) AS menit_tambah,
			IF
				(
				IF
					( xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL ) <
				IF
					( xin_leave_applications.to_date = all_dates.date, CONCAT( xin_attendance_time.shift_in, ':00' ), NULL ),
					1,
					0 
				) AS dlk_aktif,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) AS shift_in,
				xin_attendance_time.clock_out,
			IF
				(
					xin_attendance_time.shift_in > '17:00',
					CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
					CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				) AS shift_out,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
					TIMESTAMPDIFF(
						MINUTE,
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
					IF
						(
							xin_attendance_time.shift_in > '17:00',
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
						))* 0.4 
				) MINUTE AS max_dt,
			IF
				(
					DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > DATE_FORMAT(
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
							TIMESTAMPDIFF(
								MINUTE,
								CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
							IF
								(
									xin_attendance_time.shift_in > '17:00',
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
								))* 0.4 
						) MINUTE,
						'%Y-%m-%d %H:%i:00' 
					),
					TIMESTAMPDIFF(
						MINUTE,
						DATE_FORMAT(
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
								TIMESTAMPDIFF(
									MINUTE,
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
								IF
									(
										xin_attendance_time.shift_in > '17:00',
										CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
										CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
									))* 0.4 
							) MINUTE,
							'%Y-%m-%d %H:%i:00' 
						),
					DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
					0 
				) AS telat_idt,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
					TIMESTAMPDIFF(
						MINUTE,
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
					IF
						(
							xin_attendance_time.shift_in > '17:00',
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
						))* 0.6 
				) MINUTE AS max_pc,
			IF
				(
					DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ) < DATE_FORMAT(
						CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
							TIMESTAMPDIFF(
								MINUTE,
								CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
							IF
								(
									xin_attendance_time.shift_in > '17:00',
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
								))* 0.6 
						) MINUTE,
						'%Y-%m-%d %H:%i:00' 
					),
					TIMESTAMPDIFF(
						MINUTE,
						DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
						DATE_FORMAT(
							CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
								TIMESTAMPDIFF(
									MINUTE,
									CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
								IF
									(
										xin_attendance_time.shift_in > '17:00',
										CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
										CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
									))* 0.6 
							) MINUTE,
							'%Y-%m-%d %H:%i:00' 
						)),
					0 
				) AS telat_ipc 
			FROM
				xin_employees
				JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
				JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
				JOIN xin_office_location ON xin_employees.location_id = xin_office_location.location_id
				JOIN all_dates ON all_dates.date BETWEEN '$start' 
				AND '$end'
				LEFT JOIN xin_attendance_time ON xin_employees.user_id = xin_attendance_time.employee_id 
				AND all_dates.date = xin_attendance_time.attendance_date
				LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id
				LEFT JOIN xin_holidays ON xin_holidays.start_date <= all_dates.date AND xin_holidays.end_date >= all_dates.date
				LEFT JOIN xin_leave_applications ON xin_leave_applications.`status` = 2 
				AND xin_leave_applications.employee_id = xin_employees.user_id 
				AND xin_leave_applications.from_date <= all_dates.date AND xin_leave_applications.to_date >= all_dates.date
				LEFT JOIN xin_holidays AS ganti_libur ON ganti_libur.start_date <= xin_leave_applications.tgl_ph AND ganti_libur.end_date >= xin_leave_applications.tgl_ph
				LEFT JOIN (
				SELECT
					trusmi_history_lock.employee_id,
					DATE( trusmi_history_lock.created_at ) AS date,
					trusmi_m_lock.jenis 
				FROM
					trusmi_history_lock
					JOIN trusmi_m_lock ON trusmi_history_lock.lock_type = trusmi_m_lock.id_lock 
				WHERE
					trusmi_history_lock.id IN (
						(
						SELECT
							MAX( trusmi_history_lock.id ) AS id 
						FROM
							trusmi_history_lock 
						WHERE
							DATE( trusmi_history_lock.created_at ) BETWEEN '$start' 
							AND '$end' 
						GROUP BY
							trusmi_history_lock.employee_id,
							DATE( trusmi_history_lock.created_at ) 
						) 
					) 
				) AS locked ON locked.employee_id = xin_employees.user_id 
				AND locked.date = all_dates.date
				LEFT JOIN (
				SELECT
					lock_manual.employee_id,
					lock_manual.type_lock AS jenis,
					all_dates.date 
				FROM
					(
					SELECT
						trusmi_lock_absen_manual.id,
						trusmi_lock_absen_manual.type_lock,
						trusmi_lock_absen_manual.employee_id,
						MIN( DATE( trusmi_lock_absen_manual.created_at ) ) AS start_periode,
						COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) AS end_periode 
					FROM
						trusmi_lock_absen_manual 
					WHERE
						trusmi_lock_absen_manual.`status` = 1 
						AND (
							( DATE( trusmi_lock_absen_manual.created_at ) BETWEEN '$start' AND '$end' ) 
							OR ( COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) BETWEEN '$start' AND '$end' ) 
						) 
					GROUP BY
						trusmi_lock_absen_manual.employee_id 
					) AS lock_manual
					JOIN all_dates ON all_dates.date BETWEEN lock_manual.start_periode 
					AND lock_manual.end_periode 
				WHERE
					all_dates.date BETWEEN '$start' 
					AND '$end' 
				) manual_locked ON manual_locked.employee_id = xin_employees.user_id 
				AND manual_locked.date = all_dates.date 
			WHERE
				xin_employees.company_id = 5 
				AND (
					( xin_employees.is_active = 1 AND xin_employees.date_of_joining <= '$end' ) 
					OR (
						xin_employees.is_active = 0 
					AND
					IF
						(
						IF
							( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving ) > '$end',
							'$end',
						IF
						( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving )) BETWEEN '$start' 
						AND '$end' 
					) 
				) 
			GROUP BY
				xin_employees.user_id,
				all_dates.date 
			ORDER BY
				xin_employees.employee_id,
				CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ASC,
				all_dates.date,
				xin_departments.department_name,
				xin_designations.designation_name 
			) AS rekap
			LEFT JOIN trusmi_harus_hadir ON rekap.user_id = trusmi_harus_hadir.employee_id 
			AND trusmi_harus_hadir.periode = '2025-02' 
			GROUP BY
			rekap.user_id 
			) AS data_all_absen";
		return $this->db->query($query)->row_object();
	}







	public function get_warning_manpower_undone($start, $end){
		// $periode = DateTime::createFromFormat('m-Y', $month)->format('Y-m');
		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}
		$query = "SELECT 
				COUNT(undone.id_tasklist) AS total,
				COUNT(*) AS jumlah_undone,
				COALESCE(ROUND(COUNT(undone.id_tasklist) * 100.0 / NULLIF(COUNT(*), 0),1),0) AS persen,
				CASE 
					WHEN COALESCE(ROUND(COUNT(undone.id_tasklist) * 100.0 / NULLIF(COUNT(*), 0),1),0) < 60 THEN 'red'
					WHEN COALESCE(ROUND(COUNT(undone.id_tasklist) * 100.0 / NULLIF(COUNT(*), 0),1),0) BETWEEN 60 AND 75 THEN 'yellow'
					ELSE 'green'
				END AS warna
			FROM grd_t_tasklist
			LEFT JOIN (
				SELECT * 
				FROM grd_t_tasklist 
				WHERE 
					grd_t_tasklist.status IN (1, 2) 
				AND COALESCE(grd_t_tasklist.done_at, CURDATE()) > grd_t_tasklist.end
				AND ( (DATE(grd_t_tasklist.start) BETWEEN '$start' AND '$end') OR (DATE(grd_t_tasklist.end) BETWEEN '$start' AND '$end') )
			) undone ON grd_t_tasklist.id_tasklist = undone.id_tasklist
			WHERE ( (DATE(grd_t_tasklist.start) BETWEEN '$start' AND '$end') OR (DATE(grd_t_tasklist.end) BETWEEN '$start' AND '$end') )

			";
		return $this->db->query($query)->row_object();
	}






	public function get_warning_manpower_detail($start, $end){
		// $periode = DateTime::createFromFormat('m-Y', $month)->format('Y-m');
		// $start = date('Y-m', strtotime('-1 month', strtotime($periode))) . '-21';
		// $end = $periode . '-20';
		if(empty($start) && empty($end)){
			$start = date('Y-m-01');
			$end = date('Y-m-t');
		}
		$query = "SELECT
            rekap.user_id,
						rekap.foto_profile,
            rekap.employee,
            rekap.department,
						rekap.kode,
            rekap.designation,
            rekap.location,
			0 AS temuan,
			rekap.jumlah_denda AS denda,
            
            
            CASE
                WHEN rekap.designation_id IN (9,10,395,441) THEN 21
                WHEN rekap.designation_id = 458 THEN COUNT(rekap.`status`)
                WHEN rekap.user_role_id = 8 THEN COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL))
                WHEN COUNT(IF(rekap.`status` = 'R', 1, NULL)) > 0 THEN COUNT(IF(rekap.`status` NOT IN ('','R'), 1, NULL)) - COUNT(IF(rekap.libur_aktif = 1, 1, NULL))
                ELSE COUNT(rekap.`status`) - IF(rekap.libur > 0, rekap.libur, COUNT(IF(rekap.hari = 'Sun' AND rekap.date >= rekap.date_of_joining, 1, NULL))) - COUNT(IF(rekap.`status` = '', 1, NULL)) 
            END AS harus_hadir,
            COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL)) AS total_hadir,
						ROUND(COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL)) * 100 / CASE
                WHEN rekap.designation_id IN (9,10,395,441) THEN 21
                WHEN rekap.designation_id = 458 THEN COUNT(rekap.`status`)
                WHEN rekap.user_role_id = 8 THEN COUNT(IF(rekap.`status` NOT IN ('','A','F','LV','LT','LE','LR','LA','R'), 1, NULL))
                WHEN COUNT(IF(rekap.`status` = 'R', 1, NULL)) > 0 THEN COUNT(IF(rekap.`status` NOT IN ('','R'), 1, NULL)) - COUNT(IF(rekap.libur_aktif = 1, 1, NULL))
                ELSE COUNT(rekap.`status`) - IF(rekap.libur > 0, rekap.libur, COUNT(IF(rekap.hari = 'Sun' AND rekap.date >= rekap.date_of_joining, 1, NULL))) - COUNT(IF(rekap.`status` = '', 1, NULL)) 
            END,1) AS persen,
						rekap.jumlah_st,
						rekap.jumlah_sp,
						rekap.jumlah_lk
            
        FROM
				 (SELECT
	xin_employees.user_id,
	CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) AS `employee`,
	xin_departments.department_name AS department,
	xin_designations.designation_name AS designation,
	xin_office_location.location_name AS location,
	xin_employees.user_role_id,
	xin_employees.date_of_joining,
	xin_employees.date_of_leaving,
	xin_employees.designation_id,
	xin_leave_applications.leave_id,
	xin_departments.libur,
				IF
				(
				xin_employees.date_of_leaving != '' 
				AND xin_employees.date_of_leaving < all_dates.date,
				NULL,
				IF
				(
				DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' 
				AND
				IF
				( all_dates.date < xin_employees.date_of_joining, '', NULL ) != '',
				1,
				NULL 
				)) AS libur_aktif,
				CASE-- Karyawan baru join tidak absen

				WHEN all_dates.date < xin_employees.date_of_joining THEN
				'' -- Karyawan baru absen

				WHEN xin_employees.date_of_joining = xin_attendance_time.attendance_date THEN
				'P' --  Resign

				WHEN xin_employees.date_of_leaving != '' 
				AND xin_employees.date_of_leaving < all_dates.date THEN 'R' --  Hari Esok
				WHEN all_dates.date > CURDATE() THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END --  Pergantian Hari Libur

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 7 THEN
				CASE

				WHEN xin_leave_applications.tgl_ph < '$end' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'H' 
				END 
				WHEN ganti_libur.holiday_id IS NOT NULL THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'H' 
				END 
				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NOT NULL THEN
				'P' ELSE
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				END --  Cuti Tahunan

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id IN ( 1, 14 ) THEN
				'C' --  Cuti Menikah

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 2 THEN
				'M' --  Izin Sakit

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 5 THEN
				'S' --  Cuti Bersalin

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id IN ( 3, 8 ) THEN
				CASE--  Libur Mingguan/Pergantian hari libur dalam periode cutoff

				WHEN xin_office_shift.monday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.tuesday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.wednesday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.thursday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.friday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.saturday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN ( xin_office_shift.sunday_in_time = '' OR xin_leave_applications.leave_type_id IN ( 3, 8 ) ) 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off

				WHEN xin_holidays.event_name IS NOT NULL THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'H' 
				END --  Absent
				ELSE 'CB' 
				END --  Pernikahan anak / saudara

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND ( xin_leave_applications.leave_type_id = 15 OR xin_leave_applications.leave_type_id = 16 ) THEN
				'PR' --  Khitan Anak

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 25 THEN
				'KA' --  Keluarga sakit

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND ( xin_leave_applications.leave_type_id = 21 OR xin_leave_applications.leave_type_id = 22 ) THEN
				'SK' --  Kematan Keluarga

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND ( xin_leave_applications.leave_type_id = 9 || xin_leave_applications.leave_type_id = 17 ) THEN
				'KL' --  Wisuda/skripsi

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 18 THEN
				'SW' --  DLK non driver

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 13 
				AND
				IF
				(
				IF
				( xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL ) <
				IF
				( xin_leave_applications.to_date = all_dates.date, CONCAT( xin_attendance_time.shift_in, ':00' ), NULL ),
				1,
				0 
				) = 0 THEN
				'DL' --  DLK driver

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 23 THEN
				'DD' --  Skripsi/wisuda

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 18 THEN
				'SW' --  Cuti thun lalu

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 19 THEN
				'CL' --  Telat (lebih 40% termasuk absen)

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND
				IF
				( DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ), 1, 0 ) = 1 
				AND xin_leave_applications.leave_id IS NULL THEN
				CASE

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE THEN-- Kondisi Shift Store
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) > 479 
				AND xin_employees.office_shift_id IN ( 7, 11, 12, 13, 14, 18, 21 ) THEN
				'P' -- Jam masuk dan jam pulang sama

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' ELSE
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				END ELSE -- Kondisi Shift Store
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) > 479 
				AND xin_employees.office_shift_id IN ( 7, 11, 12, 13, 14, 18, 21 ) THEN
				'P' ELSE
				CASE

				WHEN xin_attendance_time.clock_out IS NULL THEN
				'F' ELSE
				CASE

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NULL 
				AND locked.employee_id IS NOT NULL THEN
				CASE

				WHEN locked.jenis = 'tasklist' THEN
				'LT' 
				WHEN locked.jenis = 'eaf' THEN
				'LE' 
				WHEN locked.jenis = 'training' THEN
				'LR' 
				WHEN locked.jenis IS NULL THEN
				'LA' ELSE 'lock' 
				END ELSE
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND xin_attendance_time.clock_out IS NULL THEN
				'F' ELSE 'T' 
				END 
				END 
				END 
				END 
				END -- Flat Shift

				WHEN (
				CASE

				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
				480 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
				540 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
				600 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
				660 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
				720 ELSE NULL 
				END 
				) > TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) THEN
				'NP' 
				WHEN (
				CASE

				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
				480 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
				540 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
				600 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
				660 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
				720 ELSE NULL 
				END 
				) < TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) THEN
				'P' --  Pulang Cepat (kurang 60% termasuk absen)

				WHEN xin_attendance_time.clock_out IS NOT NULL 
				AND
				IF
				(
				xin_attendance_time.clock_out < IF ( xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				),
				1,
				0 
				) = 1 
				AND xin_leave_applications.leave_id IS NULL THEN
				CASE

				WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE THEN
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' ELSE
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				END 
				WHEN SUBSTR(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE,
				12 
				) = '00:00:00' THEN-- Jam masuk dan jam pulang sama
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' ELSE 'P' 
				END ELSE
				CASE

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' ELSE 'NP' 
				END 
				END --  Absen 1x Karna Lock

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NULL 
				AND locked.employee_id IS NOT NULL THEN
				CASE

				WHEN locked.jenis = 'video' THEN
				'LV' 
				WHEN locked.jenis = 'tasklist' THEN
				'LT' 
				WHEN locked.jenis = 'eaf' THEN
				'LE' 
				WHEN locked.jenis = 'training' THEN
				'LR' 
				WHEN locked.jenis IS NULL THEN
				'LA' ELSE '' 
				END --  Izin datang terlambat (lebih 40% termasuk absen)

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 11 THEN
				CASE

				WHEN xin_attendance_time.clock_out IS NULL THEN
				'F' 
				WHEN
				IF
				(
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
				0 
				) > 10 THEN
				'A' ELSE 'DT' 
				END --  Izin pulang cepat (kurang 60% termasuk absen)

				WHEN xin_leave_applications.leave_id IS NOT NULL 
				AND xin_leave_applications.leave_type_id = 10 THEN
				CASE

				WHEN xin_attendance_time.clock_out IS NULL THEN
				'F' 
				WHEN xin_attendance_time.clock_out < CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN
				IF
				(
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ) < DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
				DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				)),
				0 
				) > 10 THEN
				'A' ELSE 'PC' 
				END --  Absen 1x di hari libur nasional

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NULL 
				AND xin_holidays.event_name IS NOT NULL THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'H' 
				END --  Absen 1x kecuali

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NULL THEN
				'F' -- Jam masuk dan pulang sama

				WHEN TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) < 11 THEN
				'F' --  Libur Mingguan/Pergantian hari libur dalam periode cutoff

				WHEN xin_office_shift.monday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Mon' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.tuesday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Tue' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.wednesday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Wed' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.thursday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Thu' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.friday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Fri' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.saturday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sat' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				WHEN xin_office_shift.sunday_in_time = '' 
				AND DATE_FORMAT( all_dates.date, '%a' ) = 'Sun' THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END --  Hari libur nasional/perhantian hari libur nasional/pergantian hari libur beda periode cut off

				WHEN xin_holidays.event_name IS NOT NULL 
				AND xin_attendance_time.clock_in IS NULL 
				AND xin_attendance_time.clock_out IS NULL THEN
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'H' 
				END -- lock manual

				WHEN manual_locked.jenis IS NOT NULL 
				AND manual_locked.jenis = 'video' THEN
				'LV' 
				WHEN manual_locked.jenis IS NOT NULL 
				AND manual_locked.jenis = 'other' THEN
				'LA' --  Absent
				--  Present (hadir)

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NOT NULL 
				AND xin_attendance_time.clock_out IS NOT NULL THEN
				'P' -- Tidak Absen karna Lock

				WHEN DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) IS NULL 
				AND xin_attendance_time.clock_out IS NULL 
				AND locked.employee_id IS NOT NULL THEN
				CASE

				WHEN locked.jenis = 'video' THEN
				'LV' 
				WHEN locked.jenis = 'tasklist' THEN
				'LT' 
				WHEN locked.jenis = 'eaf' THEN
				'LE' 
				WHEN locked.jenis = 'training' THEN
				'LR' 
				WHEN locked.jenis IS NULL THEN
				'LA' ELSE '' 
				END ELSE
				CASE

				WHEN xin_employees.user_role_id = 8 THEN
				'' ELSE 'A' 
				END 
				END AS `status`,
				all_dates.date,
				xin_attendance_time.attendance_date,
				xin_employees.office_shift_id,
				xin_designations.trusmi_shift,
				DATE_FORMAT( all_dates.date, '%a' ) hari,
				CASE

				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 166 OR xin_designations.trusmi_shift = 31 ) THEN
				480 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 167 OR xin_designations.trusmi_shift = 32 ) THEN
				540 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 168 OR xin_designations.trusmi_shift = 33 ) THEN
				600 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 169 OR xin_designations.trusmi_shift = 34 ) THEN
				660 
				WHEN xin_attendance_time.clock_in IS NOT NULL 
				AND ( xin_employees.office_shift_id = 170 OR xin_designations.trusmi_shift = 35 ) THEN
				720 ELSE NULL 
				END AS jam_flat,
				TIMESTAMPDIFF( MINUTE, xin_attendance_time.clock_in, xin_attendance_time.clock_out ) AS jam_kerja,
				IF
				( xin_holidays.event_name IS NOT NULL, 1, NULL ) AS holiday,
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) AS clock_in,
				CONCAT(
				'JM',
				DATE_FORMAT( xin_attendance_time.clock_in, '%H:%i' ),
				'JP',
				DATE_FORMAT( xin_attendance_time.clock_out, '%H:%i' )) AS jam_absen,
				IF
				(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
				NULL 
				) AS telat,
				IF
				(
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))> 0,
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				)),
				NULL 
				) AS telat_pc,
				CEILING(
				IF
				(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
				NULL 
				) / 60 
				) * 60 AS tambah_menit,
				IF
				(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ))> 0,
				TIMESTAMPDIFF(
				MINUTE,
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				),
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' )),
				NULL 
				) AS menit_tambah,
				IF
				(
				IF
				( xin_leave_applications.to_date = all_dates.date, xin_leave_applications.end_time, NULL ) <
				IF
				( xin_leave_applications.to_date = all_dates.date, CONCAT( xin_attendance_time.shift_in, ':00' ), NULL ),
				1,
				0 
				) AS dlk_aktif,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) AS shift_in,
				xin_attendance_time.clock_out,
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				) AS shift_out,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE AS max_dt,
				IF
				(
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' ) > DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.4 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				DATE_FORMAT( xin_attendance_time.clock_in, '%Y-%m-%d %H:%i:00' )),
				0 
				) AS telat_idt,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE AS max_pc,
				IF
				(
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ) < DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				),
				TIMESTAMPDIFF(
				MINUTE,
				DATE_FORMAT( xin_attendance_time.clock_out, '%Y-%m-%d %H:%i:00' ),
				DATE_FORMAT(
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ) + INTERVAL ROUND(
				TIMESTAMPDIFF(
				MINUTE,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_in, ':00' ),
				IF
				(
				xin_attendance_time.shift_in > '17:00',
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) + INTERVAL 1 DAY,
				CONCAT( all_dates.date, ' ', xin_attendance_time.shift_out, ':00' ) 
				))* 0.6 
				) MINUTE,
				'%Y-%m-%d %H:%i:00' 
				)),
				0 
				) AS telat_ipc,
				COUNT(surat_teguran.warning_id) AS jumlah_st,
				COUNT(surat_peringatan.warning_id) AS jumlah_sp,
				COUNT(his_lock.id) AS jumlah_lk,
				COUNT(denda.id) AS jumlah_denda,
				CASE
				WHEN xin_employees.profile_picture = '' 
				AND xin_employees.gender = 'Male' THEN
				'default_male.jpg' 
				WHEN xin_employees.profile_picture = '' 
				AND xin_employees.gender = 'Female' THEN
				'default_female.jpg' ELSE COALESCE(xin_employees.profile_picture,'default_male.jpg') 
				END AS foto_profile,
				xin_departments.kode																																																																																																													FROM
				xin_employees
				JOIN xin_departments ON xin_employees.department_id = xin_departments.department_id
				JOIN xin_designations ON xin_employees.designation_id = xin_designations.designation_id
				JOIN xin_office_location ON xin_employees.location_id = xin_office_location.location_id
				JOIN all_dates ON all_dates.date BETWEEN '$start' AND '$end'
				LEFT JOIN xin_attendance_time ON xin_employees.user_id = xin_attendance_time.employee_id 
				AND all_dates.date = xin_attendance_time.attendance_date
				LEFT JOIN xin_office_shift ON xin_employees.office_shift_id = xin_office_shift.office_shift_id
				LEFT JOIN xin_holidays ON xin_holidays.start_date <= all_dates.date AND xin_holidays.end_date >= all_dates.date
				LEFT JOIN xin_leave_applications ON xin_leave_applications.`status` = 2 
				AND xin_leave_applications.employee_id = xin_employees.user_id 
				AND xin_leave_applications.from_date <= all_dates.date AND xin_leave_applications.to_date >= all_dates.date 
				LEFT JOIN xin_holidays AS ganti_libur ON ganti_libur.start_date <= xin_leave_applications.tgl_ph AND ganti_libur.end_date >= xin_leave_applications.tgl_ph
				LEFT JOIN (
				SELECT
				trusmi_history_lock.employee_id,
				DATE( trusmi_history_lock.created_at ) AS date,
				trusmi_m_lock.jenis 
				FROM
				trusmi_history_lock
				JOIN trusmi_m_lock ON trusmi_history_lock.lock_type = trusmi_m_lock.id_lock 
				WHERE
				trusmi_history_lock.id IN (
				(
				SELECT
				MAX( trusmi_history_lock.id ) AS id 
				FROM
				trusmi_history_lock 
				WHERE
				DATE( trusmi_history_lock.created_at ) BETWEEN '$start' 
				AND '$end' 
				GROUP BY
				trusmi_history_lock.employee_id,
				DATE( trusmi_history_lock.created_at ) 
				) 
				)
				) AS locked ON locked.employee_id = xin_employees.user_id AND locked.date = all_dates.date
				LEFT JOIN (SELECT
				lock_manual.employee_id,
				lock_manual.type_lock AS jenis,
				all_dates.date 
				FROM
				(
				SELECT
				trusmi_lock_absen_manual.id,
				trusmi_lock_absen_manual.type_lock,
				trusmi_lock_absen_manual.employee_id,
				MIN( DATE( trusmi_lock_absen_manual.created_at ) ) AS start_periode,
				COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) AS end_periode 
				FROM
				trusmi_lock_absen_manual 
				WHERE
				trusmi_lock_absen_manual.`status` = 1 
				AND (
				( DATE( trusmi_lock_absen_manual.created_at ) BETWEEN '$start' AND '$end' ) 
				OR ( COALESCE ( DATE( trusmi_lock_absen_manual.updated_by ), CURDATE( ) ) BETWEEN '$start' AND '$end' ) 
				) 
				GROUP BY
				trusmi_lock_absen_manual.employee_id 
				) AS lock_manual
				JOIN all_dates ON all_dates.date BETWEEN lock_manual.start_periode 
				AND lock_manual.end_periode 

				WHERE
				all_dates.date BETWEEN '$start' 
				AND '$end') manual_locked ON manual_locked.employee_id = xin_employees.user_id AND manual_locked.date = all_dates.date
				LEFT JOIN (
				SELECT * FROM xin_employee_warnings WHERE warning_type_id = 1
				) surat_teguran ON  surat_teguran.warning_to = xin_employees.user_id BETWEEN surat_teguran.warning_date AND all_dates.date
				LEFT JOIN (
				SELECT * FROM xin_employee_warnings WHERE warning_type_id IN  (2,3,4)
				) surat_peringatan ON  surat_peringatan.warning_to = xin_employees.user_id BETWEEN surat_peringatan.warning_date AND all_dates.date
				LEFT JOIN (
				SELECT * FROM trusmi_history_lock GROUP BY employee_id,lock_type
				) his_lock ON  his_lock.employee_id = xin_employees.user_id BETWEEN his_lock.created_at AND all_dates.date
				LEFT JOIN (
				SELECT * FROM trusmi_denda GROUP BY employee_id
				) denda ON  denda.employee_id = xin_employees.user_id BETWEEN denda.created_at AND all_dates.date
				WHERE
				xin_employees.company_id = 5 
				AND xin_employees.user_role_id 	AND 
				xin_employees.user_role_id IN (2,3) 
																																																									
				AND (
				( xin_employees.is_active = 1 AND xin_employees.date_of_joining <= '$end' ) 
				OR (
				xin_employees.is_active = 0 
				AND
				IF ( IF ( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving ) > '$end', '$end', IF ( xin_employees.date_of_leaving = '' OR xin_employees.date_of_leaving IS NULL, '$start' - INTERVAL 1 DAY, xin_employees.date_of_leaving )) BETWEEN '$start' 
				AND '$end' 
				) 
				)


				GROUP BY
				xin_employees.user_id, all_dates.date
				ORDER BY
				xin_employees.employee_id,
				CONCAT( xin_employees.first_name, ' ', xin_employees.last_name ) ASC,
				all_dates.date,
				xin_departments.department_name,
				xin_designations.designation_name ) rekap
 				GROUP BY
				rekap.user_id 
				ORDER BY persen ASC

				LIMIT 10";
		return $this->db->query($query)->result();
	}



}