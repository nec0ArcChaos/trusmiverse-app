<?php

class Model_cv_screening extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_data_cv()
    {
        $query = "SELECT
                xja.application_id,
                xja.full_name,
                IF(xja.`application_status` = 0, 'Waiting', '') AS application_status,
                xja.gender,
                xja.contact,
                xja.email,
                TIMESTAMPDIFF(
                    YEAR,
                    xja.tgl_lahir,
                CURDATE()) AS age,
                xja.domisili,
                xqal.`name` AS pendidikan,
                xja.jurusan,
                xja.tempat_pendidikan,
                xja.posisi_kerja_terakhir,
                xja.tempat_kerja_terakhir,
                xja.masa_kerja_terakhir,
                xja.salary AS expected_salary,
                xja.job_resume,
                xin_jobs.job_title,
                xin_jobs.short_description,
                xin_jobs.long_description,
                trusmi_jobs_request.salary AS salary_offering,
                trusmi_jobs_request.latar_kebutuhan,
                CASE WHEN trusmi_jobs_request.minimum_experience = 0 THEN 'Fresh Graduate' ELSE trusmi_jobs_request.minimum_experience END AS minimum_experience,
                trusmi_jobs_request.pendidikan AS min_pendidikan,
                trusmi_jobs_request.komp_kunci AS kompetensi_inti,
                trusmi_jobs_request.kemampuan AS kompetensi_umum,
                trusmi_jobs_request.komp_pemimpin AS kompetensi_kepemimpinan,
            CASE WHEN trusmi_jobs_request.gender = '0' THEN
                    'Male' 
                    WHEN trusmi_jobs_request.gender = '1' THEN
                    'Female' ELSE 'No Preference' 
                END AS gender_req
            FROM
                xin_job_applications xja
                LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
				LEFT JOIN xin_job_application_scores s ON s.application_id = xja.application_id
                LEFT JOIN trusmi_jobs_request ON trusmi_jobs_request.job_id = xin_jobs.reff_job_id
                LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan
            WHERE 
            -- xja.application_id = '69824' 
            -- AND 
            xja.full_name != '' AND xja.full_name IS NOT NULL AND xja.application_status = 0 AND DATE(xja.created_at) >= DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND s.application_id IS NULL 
            AND xja.job_resume REGEXP '\\.(pdf)$'
            ORDER BY DATE(xja.created_at) DESC LIMIT 20
            ";
        return $this->db->query($query)->result_array();
    }
    function get_data_cv_by_app_id($application_id)
    {
        $query = "SELECT
                xja.application_id,
                xja.full_name,
                IF(xja.`application_status` = 0, 'Waiting', '') AS application_status,
                xja.gender,
                xja.contact,
                xja.email,
                TIMESTAMPDIFF(
                    YEAR,
                    xja.tgl_lahir,
                CURDATE()) AS age,
                xja.domisili,
                xqal.`name` AS pendidikan,
                xja.jurusan,
                xja.tempat_pendidikan,
                xja.posisi_kerja_terakhir,
                xja.tempat_kerja_terakhir,
                xja.masa_kerja_terakhir,
                xja.salary AS expected_salary,
                xja.job_resume,
                xin_jobs.job_title,
                xin_jobs.short_description,
                xin_jobs.long_description,
                trusmi_jobs_request.salary AS salary_offering,
                trusmi_jobs_request.latar_kebutuhan,
                CASE WHEN trusmi_jobs_request.minimum_experience = 0 THEN 'Fresh Graduate' ELSE trusmi_jobs_request.minimum_experience END AS minimum_experience,
                trusmi_jobs_request.pendidikan AS min_pendidikan,
                trusmi_jobs_request.komp_kunci AS kompetensi_inti,
                trusmi_jobs_request.kemampuan AS kompetensi_umum,
                trusmi_jobs_request.komp_pemimpin AS kompetensi_kepemimpinan,
            CASE WHEN trusmi_jobs_request.gender = '0' THEN
                    'Male' 
                    WHEN trusmi_jobs_request.gender = '1' THEN
                    'Female' ELSE 'No Preference' 
                END AS gender_req
            FROM
                xin_job_applications xja
                LEFT JOIN xin_jobs ON xin_jobs.job_id = xja.job_id
				LEFT JOIN xin_job_application_scores s ON s.application_id = xja.application_id
                LEFT JOIN trusmi_jobs_request ON trusmi_jobs_request.job_id = xin_jobs.reff_job_id
                LEFT JOIN xin_qualification_education_level xqal ON xqal.education_level_id = xja.pendidikan
            WHERE 
            xja.application_id = '$application_id'";
        return $this->db->query($query)->result_array();
    }

    public function insert_application_scores($data)
    {
        return $this->db->insert('xin_job_application_scores', $data);
    }

    public function insert_profile_matches($matches)
    {
        return $this->db->insert_batch('xin_job_application_profile_matches', $matches);
    }

    public function insert_scoring_details($details)
    {
        return $this->db->insert_batch('xin_job_application_scoring_details', $details);
    }

    public function save_full_analysis($payload)
    {
        $this->db->trans_start();

        // $payload->payload_body->application_id

        // 1. Save main score
        $scoreData = array(
            'application_id'       => $payload->payload_body->application_id,
            'matching_total_score' => $payload->payload_body->cleanedData->matching_total_score,
            'matching_score_profile' => $payload->payload_body->cleanedData->matching_score_profile,
            'matching_score_skills'  => $payload->payload_body->cleanedData->matching_score_skills,
            'reason'               => $payload->payload_body->cleanedData->reason,
            'processed_at'         => date('Y-m-d H:i:s', strtotime($payload->payload_body->processed_at))
        );

        $existing = $this->db->get_where('xin_job_application_scores', ['application_id' => $payload->payload_body->application_id])->num_rows();
        if ($existing > 0) {
            $scoreData = array(
                'matching_total_score' => $payload->payload_body->cleanedData->matching_total_score,
                'matching_score_profile' => $payload->payload_body->cleanedData->matching_score_profile,
                'matching_score_skills'  => $payload->payload_body->cleanedData->matching_score_skills,
                'reason'               => $payload->payload_body->cleanedData->reason,
                'processed_at'         => date('Y-m-d H:i:s', strtotime($payload->payload_body->processed_at))
            );
            $this->db->where('application_id', $payload->payload_body->application_id)->update('xin_job_application_scores', $scoreData);
        } else {
            $this->insert_application_scores($scoreData);
        }

        // 2. Save profile matches
        $profileMatches = [];
        foreach ($payload->payload_body->cleanedData->matched_profile_items as $item) {
            $profileMatches[] = array(
                'application_id' => $payload->payload_body->application_id,
                'type'           => 'matched_profile',
                'description'    => $item
            );
        }
        foreach ($payload->payload_body->cleanedData->missing_profile_items as $item) {
            $profileMatches[] = array(
                'application_id' => $payload->payload_body->application_id,
                'type'           => 'missing_profile',
                'description'    => $item
            );
        }
        foreach ($payload->payload_body->cleanedData->matched_skills as $item) {
            $profileMatches[] = array(
                'application_id' => $payload->payload_body->application_id,
                'type'           => 'matched_skill',
                'description'    => $item
            );
        }
        foreach ($payload->payload_body->cleanedData->missing_skills as $item) {
            $profileMatches[] = array(
                'application_id' => $payload->payload_body->application_id,
                'type'           => 'missing_skill',
                'description'    => $item
            );
        }
        if (!empty($profileMatches)) {
            $existing = $this->db->get_where('xin_job_application_profile_matches', ['application_id' => $payload->payload_body->application_id])->num_rows();
            if ($existing > 0) {
                $this->db->where('application_id', $payload->payload_body->application_id)->delete('xin_job_application_profile_matches');
            }
            $this->insert_profile_matches($profileMatches);
        }

        // 3. Save scoring details
        $scoringDetails = [];
        foreach ($payload->payload_body->cleanedData->scoring as $score) {
            $scoringDetails[] = array(
                'application_id' => $payload->payload_body->application_id,
                'criteria'       => $score->criteria,
                'category'       => $score->category,
                'weight'         => $score->weight,
                'score'          => $score->score,
                'reason'         => $score->reason
            );
        }
        if (!empty($scoringDetails)) {
            $existing = $this->db->get_where('xin_job_application_scoring_details', ['application_id' => $payload->payload_body->application_id])->num_rows();
            if ($existing > 0) {
                $this->db->where('application_id', $payload->payload_body->application_id)->delete('xin_job_application_scoring_details');
            }
            $this->insert_scoring_details($scoringDetails);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }
}
