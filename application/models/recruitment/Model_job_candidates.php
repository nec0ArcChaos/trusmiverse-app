<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_job_candidates extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function get_candidates($start, $end, $id = null)
	{
		if ($id != null) {
			$sub_query = "xja.job_id = $id";
		} else {
			$sub_query = "SUBSTR(xja.created_at,1,10) BETWEEN '$start' AND '$end'";
		}
		$query = "SELECT
					xja.full_name,
					xja.gender,
					xja.contact,
					xja.email,
					TIMESTAMPDIFF(YEAR, xja.tgl_lahir, CURDATE()) AS age,
					xja.domisili,
					xqal.NAME AS pendidikan,
					xja.jurusan,
					xja.tempat_pendidikan,
					xja.posisi_kerja_terakhir,
					xja.tempat_kerja_terakhir,
					xja.masa_kerja_terakhir,
					xja.salary,
					xja.application_status,
					DATE_FORMAT(SUBSTR(xja.created_at, 1, 10), '%d %M %Y') AS created_at,
					xja.job_resume,
					xja.job_id,
					xja.application_id,
					COALESCE(xmed.name, xja.informasi, '') AS informasi,
					xin_jobs.job_title,
					xin_user_roles.role_name,
					xin_job_categories.category_name,
					xin_users.company_name,
					GROUP_CONCAT(que.label SEPARATOR ', ') AS question,
					CASE
						WHEN xjs.matching_total_score < 70 THEN 'Not Recomended'
						WHEN xjs.matching_total_score >= 70
						AND xjs.matching_total_score < 80 THEN 'Considered'
						WHEN xjs.matching_total_score >= 80 THEN 'Recomended'
						ELSE ''
					END AS status_score,
					COALESCE(xjs.matching_total_score, '') AS matching_total_score,
					COALESCE(xjs.matching_score_profile, '') AS matching_score_profile,
					COALESCE(xjs.matching_score_skills, '') AS matching_score_skills,
					xja.id_user_talent,
					tiu.score AS tiu_score,
					dsc.m_d,
					dsc.m_i,
					dsc.m_s,
					dsc.m_c,
					dsc.l_d,
					dsc.l_i,
					dsc.l_s,
					dsc.l_c,
					dsc.c_d,
					dsc.c_i,
					dsc.c_s,
					dsc.c_c,
					COALESCE(
						CONCAT(
						CASE
							WHEN dsc.m_d = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'D'
							ELSE ''
						END,
						CASE
							WHEN dsc.m_i = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'I'
							ELSE ''
						END,
						CASE
							WHEN dsc.m_s = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'S'
							ELSE ''
						END,
						CASE
							WHEN dsc.m_c = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'C'
							ELSE ''
						END
						),
						''
					) AS mask_type,
					COALESCE(
						CONCAT(
						CASE
							WHEN dsc.l_d = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN 'D'
							ELSE ''
						END,
						CASE
							WHEN dsc.l_i = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN 'I'
							ELSE ''
						END,
						CASE
							WHEN dsc.l_s = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN 'S'
							ELSE ''
						END,
						CASE
							WHEN dsc.l_c = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN 'C'
							ELSE ''
						END
						),
						''
					) AS life_type,
					COALESCE(
						CONCAT(
						CASE WHEN dsc.c_d = GREATEST(dsc.c_d, dsc.c_i, dsc.c_s, dsc.c_c) THEN 'D' ELSE '' END,
						CASE WHEN dsc.c_i = GREATEST(dsc.c_d, dsc.c_i, dsc.c_s, dsc.c_c) THEN 'I' ELSE '' END,
						CASE WHEN dsc.c_s = GREATEST(dsc.c_d, dsc.c_i, dsc.c_s, dsc.c_c) THEN 'S' ELSE '' END,
						CASE WHEN dsc.c_c = GREATEST(dsc.c_d, dsc.c_i, dsc.c_s, dsc.c_c) THEN 'C' ELSE '' END
						),
						''
					) AS change_type,
					COALESCE(
						CASE
						WHEN (mbti.ekstrovert + mbti.introvert) = 0 THEN 0
						ELSE ROUND(
							mbti.ekstrovert / (mbti.ekstrovert + mbti.introvert) * 100
						)
						END,
						0
					) AS E_percent,
					COALESCE(
						CASE
						WHEN (mbti.ekstrovert + mbti.introvert) = 0 THEN 0
						ELSE ROUND(
							mbti.introvert / (mbti.ekstrovert + mbti.introvert) * 100
						)
						END,
						0
					) AS I_percent,
					COALESCE(
						CASE
						WHEN (mbti.sensing + mbti.intuition) = 0 THEN 0
						ELSE ROUND(
							mbti.sensing / (mbti.sensing + mbti.intuition) * 100
						)
						END,
						0
					) AS S_percent,
					COALESCE(
						CASE
						WHEN (mbti.sensing + mbti.intuition) = 0 THEN 0
						ELSE ROUND(
							mbti.intuition / (mbti.sensing + mbti.intuition) * 100
						)
						END,
						0
					) AS N_percent,
					COALESCE(
						CASE
						WHEN (mbti.thinking + mbti.feeling) = 0 THEN 0
						ELSE ROUND(
							mbti.thinking / (mbti.thinking + mbti.feeling) * 100
						)
						END,
						0
					) AS T_percent,
					COALESCE(
						CASE
						WHEN (mbti.thinking + mbti.feeling) = 0 THEN 0
						ELSE ROUND(
							mbti.feeling / (mbti.thinking + mbti.feeling) * 100
						)
						END,
						0
					) AS F_percent,
					COALESCE(
						CASE
						WHEN (mbti.perceiving + mbti.judging) = 0 THEN 0
						ELSE ROUND(
							mbti.perceiving / (mbti.perceiving + mbti.judging) * 100
						)
						END,
						0
					) AS P_percent,
					COALESCE(
						CASE
						WHEN (mbti.perceiving + mbti.judging) = 0 THEN 0
						ELSE ROUND(
							mbti.judging / (mbti.perceiving + mbti.judging) * 100
						)
						END,
						0
					) AS J_percent,
					cfit.score AS score_cfit,
					akses.access,
					COALESCE(dx.simulation_score,'') AS simulation_score,
					COALESCE(dx.simulation_grade,'') AS simulation_grade
					FROM
					xin_job_applications AS xja
					LEFT JOIN xin_job_application_scores xjs ON xjs.application_id = xja.application_id
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_medsos xmed ON xmed.id = xja.informasi
					LEFT JOIN xin_designations ON xin_designations.designation_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN xin_user_roles ON xin_user_roles.role_id = xin_jobs.position_id
					LEFT JOIN xin_users ON xin_users.user_id = xja.user_id
					LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan
					LEFT JOIN trusmi_jobs_question que ON FIND_IN_SET(que.id, xja.question)
					LEFT JOIN talent_pool.t_tiu tiu ON xja.id_user_talent = tiu.id_user
					LEFT JOIN talent_pool.t_disc dsc ON xja.id_user_talent = dsc.created_by
					LEFT JOIN talent_pool.t_mbti mbti ON xja.id_user_talent = mbti.id_user
					LEFT JOIN talent_pool.t_cvit cfit ON xja.id_user_talent = cfit.id_user
					LEFT JOIN talent_pool.t_test_assessment akses ON xja.id_user_talent = akses.id_user
					OR xja.email = akses.id_user
					LEFT JOIN (
						SELECT
						t.last_id_training,
						dt.user_id,
						de.skor_berbobot AS simulation_score,
						de.grade AS simulation_grade
						FROM
						(
							SELECT
							MAX(t.id) AS last_id_training
							FROM
							talent_pool.dt_training_sessions t
							GROUP BY
							t.user_id
						) AS t
						LEFT JOIN talent_pool.dt_training_sessions dt ON dt.id = t.last_id_training
						LEFT JOIN talent_pool.dt_training_evaluations de ON de.training_session_id = dt.id
					) AS dx ON dx.user_id = xja.id_user_talent
					WHERE
					$sub_query
					GROUP BY
					xja.application_id";
		return $this->db->query($query)->result();
	}

	public function get_list_test()
	{
		$query = "SELECT * FROM talent_pool.m_test_assessment";
		return $this->db->query($query)->result();
	}

	public function cover_letter($id)
	{
		$query = "SELECT 
					xja.message,
					xin_jobs.job_title
				  FROM
				  xin_job_applications as xja
				  LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
				  WHERE xja.application_id = $id";
		return $this->db->query($query)->row_array();
	}

	public function get_alasan($tipe)
	{
		$query = "SELECT * FROM trusmi_m_gagal_join WHERE step = '$tipe'";
		return $this->db->query($query)->result();
	}

	function get_detail_screener($id)
	{
		$query = "SELECT
					xja.full_name,
					COALESCE(u.photo,'') AS photo,
					xja.gender,
					xja.contact,
					xja.email,
					TIMESTAMPDIFF(YEAR,xja.tgl_lahir,CURDATE()) as age,
					xja.domisili,
					xqal.name as pendidikan,
					xja.jurusan,
					xja.tempat_pendidikan,
					xja.posisi_kerja_terakhir,
					xja.tempat_kerja_terakhir,
					xja.masa_kerja_terakhir,
					xja.salary,
					xja.application_status,
					DATE_FORMAT(SUBSTR(xja.created_at,1,10), '%d %M %Y') as created_at,
					xja.job_resume,
					xja.job_id,
					xja.application_id,
					xja.informasi,
					xin_jobs.job_title,
					xin_user_roles.role_name,
					xin_job_categories.category_name,
					xin_users.company_name,
					GROUP_CONCAT(que.label SEPARATOR ', ') AS question,
					CASE WHEN xjs.matching_total_score < 70 THEN 'Not Recomended'
					WHEN xjs.matching_total_score >= 70 AND xjs.matching_total_score < 80 THEN 'Considered'
					WHEN xjs.matching_total_score >= 80 THEN 'Recomended' ELSE '' END AS status_score,
					COALESCE(xjs.matching_total_score,0) AS matching_total_score,
					COALESCE(xjs.matching_score_profile,0) AS matching_score_profile,
					COALESCE(xjs.matching_score_skills,0) AS matching_score_skills,
					COALESCE(xjs.reason,'') AS reason,
					COALESCE(xjs.processed_at,'') AS processed_at,
					xja.id_user_talent
				FROM
					xin_job_applications as xja
					LEFT JOIN xin_job_application_scores xjs ON xjs.application_id = xja.application_id
					LEFT JOIN talent_pool.users u ON u.id_user = xja.id_user_talent
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_designations ON xin_designations.designation_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN xin_user_roles ON xin_user_roles.role_id = xin_jobs.position_id
					LEFT JOIN xin_users ON xin_users.user_id = xja.user_id
					LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan
					LEFT JOIN trusmi_jobs_question que ON FIND_IN_SET(que.id,xja.question)
				WHERE
				    xja.application_id = '$id'
					GROUP BY xja.application_id";
		return $this->db->query($query)->row_array();
	}

	function get_detail_radar($id_user_talent)
	{
		$query = "SELECT
					CASE s.category
						WHEN 'communication_skills' THEN
							'Clarity'
						WHEN 'product_knowledge' THEN
							'Mastery'
						WHEN 'customer_service' THEN
							'Service'
						WHEN 'sales_technique' THEN
							'Selling'
						WHEN 'engagement_quality' THEN
							'Engagement'
						WHEN 'followup_excellence' THEN
							'Consistency'
						WHEN 'customer_satisfaction' THEN
							'Satisfaction'
						WHEN 'conversion_effectiveness' THEN
							'Conversion'
						ELSE
							''
					END AS statement_list,
					s.score
					FROM
					talent_pool.dt_training_sessions e
					LEFT JOIN talent_pool.dt_training_evaluations_score s ON s.training_session_id = e.id 
					WHERE
					e.user_id = '$id_user_talent' AND s.id IS NOT NULL";
		return $this->db->query($query)->result();
	}
	function get_detail_radar_cv($application_id)
	{
		$query = "SELECT
					CASE s.criteria
						WHEN 'Usia' THEN
							'Usia'
						WHEN 'Status' THEN
							'Status'
						WHEN 'Gender' THEN
							'Gender'
						WHEN 'Pendidikan' THEN
							'Pendidikan'
						WHEN 'Pengalaman Kerja' THEN
							'Pengalaman'
						WHEN 'Soft Skills' THEN
							'Soft Skills'
						WHEN 'Keahlian Utama' THEN
							'Keahlian'
						WHEN 'Kesesuaian Job Desc' THEN
							'Job Desc'
						WHEN 'Sertifikasi/Pelatihan' THEN
							'Sertifikasi'
						WHEN 'Portofolio/Proyek' THEN
							'Portofolio'
						ELSE
							''
					END AS criteria,
					ROUND(s.score) AS score
					FROM
					xin_job_application_scoring_details s
					WHERE s.application_id = $application_id";
		return $this->db->query($query)->result();
	}
	function get_profile_match($id, $type)
	{
		$query = "SELECT
					xjm.application_id,
					xjm.type,
					xjm.description 
				FROM
					`xin_job_application_profile_matches` xjm 
				WHERE
					xjm.application_id = '$id' 
					AND xjm.type = '$type'";
		return $this->db->query($query)->result();
	}
	function get_score_detail($id)
	{
		$query = "SELECT
			xjd.application_id,
			xjd.category,
			xjd.criteria,
			xjd.weight,
			xjd.score,
			xjd.reason 
		FROM
			xin_job_application_scoring_details xjd
			WHERE xjd.application_id ='$id'";
		return $this->db->query($query)->result();
	}

	function get_summary_ella()
	{
		$query = "SELECT
			COUNT(DISTINCT application_id) AS total_screened,
			MAX(processed_at) AS last_screened 
		FROM
			`xin_job_application_scores` xjs
			WHERE date(processed_at) = CURRENT_DATE";
		return $this->db->query($query)->row_array();
	}

	function get_top_candidate_this_month()
	{
		$query = "SELECT
					xja.full_name,
					xja.gender,
					xja.contact,
					xja.email,
					TIMESTAMPDIFF(YEAR,xja.tgl_lahir,CURDATE()) as age,
					xja.domisili,
					xqal.name as pendidikan,
					xja.jurusan,
					xja.tempat_pendidikan,
					xja.posisi_kerja_terakhir,
					xja.tempat_kerja_terakhir,
					xja.masa_kerja_terakhir,
					xja.salary,
					xja.application_status,
					DATE_FORMAT(SUBSTR(xja.created_at,1,10), '%d %M %Y') as created_at,
					xja.job_resume,
					xja.job_id,
					xja.application_id,
					xja.informasi,
					xin_jobs.job_title,
					xin_user_roles.role_name,
					xin_job_categories.category_name,
					xin_users.company_name,
					GROUP_CONCAT(que.label SEPARATOR ', ') AS question,
					CASE WHEN xjs.matching_total_score < 70 THEN 'Not Recomended'
					WHEN xjs.matching_total_score >= 70 AND xjs.matching_total_score <= 80 THEN 'Considered'
					WHEN xjs.matching_total_score > 80 THEN 'Recomended' ELSE '' END AS status_score,
					xjs.matching_total_score,
					xjs.matching_score_profile,
					xjs.matching_score_skills,
					xjs.reason,
					xjs.processed_at
				FROM
					xin_job_applications as xja
					LEFT JOIN xin_job_application_scores xjs ON xjs.application_id = xja.application_id
					LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
					LEFT JOIN xin_designations ON xin_designations.designation_id = xja.job_id
					LEFT JOIN xin_job_categories ON xin_jobs.category_id = xin_job_categories.category_id
					LEFT JOIN xin_user_roles ON xin_user_roles.role_id = xin_jobs.position_id
					LEFT JOIN xin_users ON xin_users.user_id = xja.user_id
					LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan
					LEFT JOIN trusmi_jobs_question que ON FIND_IN_SET(que.id,xja.question) 
			WHERE
				xja.application_status = 0 
			GROUP BY xja.application_id
			ORDER BY
				COALESCE ( xjs.matching_total_score, 0 ) DESC 
				LIMIT 3";
		return $this->db->query($query)->result();
	}
	public function get_all_test()
	{
		$query = "SELECT
				usr.full_name,
				usr.email,
				tiu.score AS tiu_score,
				dsc.m_d AS most_d,
				dsc.m_i AS most_i,
				dsc.m_s AS most_s,
				dsc.m_c AS most_c,
				dsc.l_d AS least_d,
				dsc.l_i AS least_i,
				dsc.l_s AS least_s,
				dsc.l_c AS least_c,
				COALESCE(
					CONCAT(
						CASE
							WHEN dsc.m_d = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN
							'D'
							ELSE
							''
						END,
						CASE
							WHEN dsc.m_i = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN
							'I'
							ELSE
							''
						END,
						CASE
							WHEN dsc.m_s = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN
							'S'
							ELSE
							''
						END,
						CASE
							WHEN dsc.m_c = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN
							'C'
							ELSE
							''
						END
					),
					''
				) AS mask_type,
				COALESCE(
					CONCAT(
						CASE
							WHEN dsc.l_d = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN
							'D'
							ELSE
							''
						END,
						CASE
							WHEN dsc.l_i = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN
							'I'
							ELSE
							''
						END,
						CASE
							WHEN dsc.l_s = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN
							'S'
							ELSE
							''
						END,
						CASE
							WHEN dsc.l_c = GREATEST(dsc.l_d, dsc.l_i, dsc.l_s, dsc.l_c) THEN
							'C'
							ELSE
							''
						END
					),
					''
				) AS life_type,
				COALESCE(
					CASE
						WHEN (mbti.ekstrovert + mbti.introvert) = 0 THEN
							0
						ELSE
							ROUND(mbti.ekstrovert / (mbti.ekstrovert + mbti.introvert) * 100)
					END,
					0
				) AS E_percent,
				COALESCE(
					CASE
						WHEN (mbti.ekstrovert + mbti.introvert) = 0 THEN
							0
						ELSE
							ROUND(mbti.introvert / (mbti.ekstrovert + mbti.introvert) * 100)
					END,
					0
				) AS I_percent,
				COALESCE(
					CASE
						WHEN (mbti.sensing + mbti.intuition) = 0 THEN
							0
						ELSE
							ROUND(mbti.sensing / (mbti.sensing + mbti.intuition) * 100)
					END,
					0
				) AS S_percent,
				COALESCE(
					CASE
						WHEN (mbti.sensing + mbti.intuition) = 0 THEN
							0
						ELSE
							ROUND(mbti.intuition / (mbti.sensing + mbti.intuition) * 100)
					END,
					0
				) AS N_percent,
				COALESCE(
					CASE
						WHEN (mbti.thinking + mbti.feeling) = 0 THEN
							0
						ELSE
							ROUND(mbti.thinking / (mbti.thinking + mbti.feeling) * 100)
					END,
					0
				) AS T_percent,
				COALESCE(
					CASE
						WHEN (mbti.thinking + mbti.feeling) = 0 THEN
							0
						ELSE
							ROUND(mbti.feeling / (mbti.thinking + mbti.feeling) * 100)
					END,
					0
				) AS F_percent,
				COALESCE(
					CASE
						WHEN (mbti.perceiving + mbti.judging) = 0 THEN
							0
						ELSE
							ROUND(mbti.perceiving / (mbti.perceiving + mbti.judging) * 100)
					END,
					0
				) AS P_percent,
				COALESCE(
					CASE
						WHEN (mbti.perceiving + mbti.judging) = 0 THEN
							0
						ELSE
							ROUND(mbti.judging / (mbti.perceiving + mbti.judging) * 100)
					END,
					0
				) AS J_percent,
				cfit.score AS score_cfit
				FROM
				talent_pool.users usr
				LEFT JOIN talent_pool.t_tiu tiu ON usr.id_user = tiu.id_user
				LEFT JOIN talent_pool.t_disc dsc ON usr.id_user = dsc.created_by
				LEFT JOIN talent_pool.t_mbti mbti ON usr.id_user = mbti.id_user
				LEFT JOIN talent_pool.t_cvit cfit ON usr.id_user = cfit.id_user";
		return $this->db->query($query)->result();
	}

	public function get_sla_interview_hr($application_id)
	{
		$query = "SELECT
					ja.application_id,
					ja.updated_at,
					ja.job_id,
					ja.full_name,
					ja.contact,
					ja.email,
					ja.date_interview_hr,
					ja.time_interview_hr,
					ja.zoom_link,
					ja.masa_kerja_terakhir,
					COALESCE(xqal.name, '') AS pendidikan,
					xj.job_title,
					xj.position_id,
					DATE_FORMAT(xj.date_of_closing, '%d %M %Y') AS tgl,
					ur.role_id,
					ur.role_name,
					sla.sla_days,
					COALESCE(tiu.score, '') AS iq,
					COALESCE(
						CONCAT(
							CASE WHEN dsc.m_d = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'D' ELSE '' END,
							CASE WHEN dsc.m_i = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'I' ELSE '' END,
							CASE WHEN dsc.m_s = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'S' ELSE '' END,
							CASE WHEN dsc.m_c = GREATEST(dsc.m_d, dsc.m_i, dsc.m_s, dsc.m_c) THEN 'C' ELSE '' END
						), ''
					) AS disc,
					COALESCE(
						CASE
							WHEN xjs.matching_total_score >= 80 THEN 'Recomended'
							WHEN xjs.matching_total_score >= 70 THEN 'Considered'
							WHEN xjs.matching_total_score IS NOT NULL THEN 'Not Recomended'
							ELSE ''
						END
					) AS keterangan,
					COALESCE(e.first_name, '') AS user,
					COALESCE(e.contact_no, '') AS contact_no_pic
				 FROM xin_job_applications ja
				 INNER JOIN xin_jobs xj ON xj.job_id = ja.job_id
				 INNER JOIN xin_user_roles ur ON ur.role_id = xj.position_id
				 INNER JOIN trusmi_m_sla_recruitment sla
					ON sla.step_code = 'interview_hr'
					AND sla.role_id = ur.role_id
					AND sla.is_active = 1
				 LEFT JOIN trusmi_jobs_request jb ON jb.job_id = xj.reff_job_id
				 LEFT JOIN xin_employees e ON e.user_id = jb.pic
				 LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = ja.pendidikan
				 LEFT JOIN xin_job_application_scores xjs ON xjs.application_id = ja.application_id
				 LEFT JOIN talent_pool.t_tiu tiu ON ja.id_user_talent = tiu.id_user
				 LEFT JOIN talent_pool.t_disc dsc ON ja.id_user_talent = dsc.created_by
				 WHERE ja.application_id = ?";
		return $this->db->query($query, array($application_id))->row_array();
	}

}
