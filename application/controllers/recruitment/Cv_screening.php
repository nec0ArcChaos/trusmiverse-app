<?php

class Cv_screening extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('recruitment/model_cv_screening');
    }

    public function get_data_cv()
    {
        $data = $this->model_cv_screening->get_data_cv();
        $kandidats = [];
        foreach ($data as $key => $value) {
            $kandidats[] = [
                'application_id' => $value['application_id'],
                'full_name' => $value['full_name'],
                'gender' => $value['gender'],
                'contact' => $value['contact'],
                'email' => $value['email'],
                'age' => $value['age'],
                'domisili' => $value['domisili'],
                'pendidikan' => $value['pendidikan'],
                'jurusan' => $value['jurusan'],
                'tempat_pendidikan' => $value['tempat_pendidikan'],
                'posisi_kerja_terakhir' => $value['posisi_kerja_terakhir'],
                'tempat_kerja_terakhir' => $value['tempat_kerja_terakhir'],
                'masa_kerja_terakhir' => $value['masa_kerja_terakhir'],
                'expected_salary' => $value['expected_salary'],
                'job_resume' => $value['job_resume'],
                'job_title' => $value['job_title'],
                'short_description' => strip_tags($value['short_description']),
                'long_description' => strip_tags($value['long_description']),
                'salary_offering' => $value['salary_offering'],
                'latar_kebutuhan' => $value['latar_kebutuhan'],
                'minimum_experience' => $value['minimum_experience'],
                'min_pendidikan' => $value['min_pendidikan'],
                'kompetensi_inti' => $value['kompetensi_inti'],
                'kompetensi_umum' => $value['kompetensi_umum'],
                'kompetensi_kepemimpinan' => $value['kompetensi_kepemimpinan'],
                'gender_requirement' => $value['gender_req'],
            ];
            $data[$key]['long_description'] = strip_tags($value['long_description']);
        }

        $response['kandidats'] = $kandidats;
        echo json_encode($response);
    }

    public function get_data_cv_by_app_id()
    {
        $rawInput = file_get_contents('php://input');
        $payload = json_decode($rawInput);
        $data = $this->model_cv_screening->get_data_cv_by_app_id($payload->application_id);
        $kandidats = [];
        foreach ($data as $key => $value) {
            $kandidats[] = [
                'application_id' => $value['application_id'],
                'full_name' => $value['full_name'],
                'gender' => $value['gender'],
                'contact' => $value['contact'],
                'email' => $value['email'],
                'age' => $value['age'],
                'domisili' => $value['domisili'],
                'pendidikan' => $value['pendidikan'],
                'jurusan' => $value['jurusan'],
                'tempat_pendidikan' => $value['tempat_pendidikan'],
                'posisi_kerja_terakhir' => $value['posisi_kerja_terakhir'],
                'tempat_kerja_terakhir' => $value['tempat_kerja_terakhir'],
                'masa_kerja_terakhir' => $value['masa_kerja_terakhir'],
                'expected_salary' => $value['expected_salary'],
                'job_resume' => $value['job_resume'],
                'job_title' => $value['job_title'],
                'short_description' => strip_tags($value['short_description']),
                'long_description' => strip_tags($value['long_description']),
                'salary_offering' => $value['salary_offering'],
                'latar_kebutuhan' => $value['latar_kebutuhan'],
                'minimum_experience' => $value['minimum_experience'],
                'min_pendidikan' => $value['min_pendidikan'],
                'kompetensi_inti' => $value['kompetensi_inti'],
                'kompetensi_umum' => $value['kompetensi_umum'],
                'kompetensi_kepemimpinan' => $value['kompetensi_kepemimpinan'],
                'gender_requirement' => $value['gender_req'],
            ];
            $data[$key]['long_description'] = strip_tags($value['long_description']);
        }

        $response['kandidats'] = $kandidats;
        echo json_encode($response);
    }

    // Endpoint POST untuk simpan hasil analisis
    public function save_analysis()
    {
        // Ambil input JSON dari body request
        $rawInput = file_get_contents('php://input');
        $payload = json_decode($rawInput);

        if (!$payload) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Invalid JSON input'
                ]));
        }
        // echo json_encode($payload->payload_body->cleanedData->matching_total_score);
        // return;

        $saved = false;
        // Cek apakah data yang diterima adalah array
        if (isset($payload->payload_body)) {
            // Simpan ke DB
            $saved = $this->model_cv_screening->save_full_analysis($payload);
        }

        if ($saved) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode([
                    'status'  => true,
                    'message' => 'Analysis saved successfully',
                ]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status'  => false,
                    'message' => 'Failed to save analysis'
                ]));
        }
    }
}
