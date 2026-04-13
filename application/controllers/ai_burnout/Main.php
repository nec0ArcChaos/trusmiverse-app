<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model("Model_ai_burnout", 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }


    public function index()
    {
        $data['pageTitle'] = "Dashboard Analisa Agentic AI";
        $data['css'] = "ai_burnout/css";
        $data['content'] = "ai_burnout/index";
        $data['js'] = "ai_burnout/js";
        
        $this->load->view('layout/main_agentic', $data);
    }

    public function master_data()
    {
        $data['symptoms'] =  $this->model->get_symptoms();
        $data['diagnoses'] =  $this->model->get_diagnoses();
        $data['solutions'] =  $this->model->get_solutions();
        $data['rules'] =  $this->model->get_rules();
        $data['ratings'] =  $this->model->get_ratings();
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function questionnaire()
    {
        $user_id = $this->session->userdata('user_id');
        $data = $this->model->get_data_by('bo_session', ['user_id' => $user_id, 'status' => 'started'])->row_array();
        if(!$data){
            $data = [
                "user_id" => $user_id,
                "status" => 'started',
                "started_at" => date('Y-m-d H:i:s'),
            ];
            $this->db->insert('bo_session', $data);
            $data["id"] = $this->db->insert_id();
            $answers = [];
        } else {
            $answers = $this->model->get_data_by('bo_answers', ['session_id' => $data['id']])->result_array();
        }

        header('Content-Type: application/json');
        echo json_encode(['data' => $data,'answers' => $answers]);
    }

    public function save_questionnaire(){
        $answers = $this->input->post('answers');
        $user_id = $this->session->userdata('user_id');
        $session = $this->model->get_data_by('bo_session', ['user_id' => $user_id, 'status' => 'started'])->row_array();
        $symptoms = $this->db->get('bo_symptom')->result_array();
        if($session){
            foreach ($answers as $symptom_id => $cf_user) {
                $cf_pakar = $symptoms[array_search($symptom_id, array_column($symptoms, 'symptom_id'))]['cf_pakar'];
                $answer_data = [
                    "session_id" => $session['id'],
                    "symptom_id" => $symptom_id,
                    "cf_user" => $cf_user,
                    "cfhe" => $cf_user*$cf_pakar,
                ];
                $answer = $this->model->get_data_by('bo_answers',['session_id' => $session['id'], 'symptom_id' => $symptom_id])->row();
                if($answer){
                    // $this->db->where('session_id', $session['id']);
                    // $this->db->where('symptom_id', $symptom_id);
                    // $this->db->update()
                    $this->model->update_where('bo_answers', ['session_id' => $session['id'], 'symptom_id' => $symptom_id], $answer_data);
                } else {
                    $this->db->insert('bo_answers', $answer_data);
                }
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => true,'answers' => $answers]);
        } else {
            echo json_encode(['success' => false,'answers' => $answers, 'No session found']);
        }
    }

    public function complete_questionnaire(){
        $diagnose = $this->input->post('diagnose');
        $user_id = $this->session->userdata('user_id');
        $session = $this->model->get_data_by('bo_session', ['user_id' => $user_id, 'status' => 'started'])->row_array();
        $session_data = [
            'status' => 'completed',
            'diagnose_id' => $diagnose['diagnosis'],
            'confidence' => $diagnose['percentage'],
            'cf_combined' => $diagnose['cfCombined'],
            'completed_at' => date('Y-m-d H:i:s'),
        ];
        $this->model->update_where('bo_session', ['id' => $session['id']], $session_data);
        $user = $this->model->get_user($user_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => true,'data' => $session_data, 'session' => $session, 'user' => $user]);
    }
    
    public function load_history()
    {
        $user_id = $this->input->post('user_id');
        $userId = ($user_id == 'default' ? $this->session->userdata('user_id') : $user_id);
        $allowed_akses = ['2063', '1', '979'];
        if ($user_id == 'default' && in_array($userId, $allowed_akses)){
            $data['history'] = $this->model->load_history();
            $data['user'] = $this->model->get_user($userId);
            $data['solution'] = $this->db->get('bo_solution')->result_array();
        } else {
            $data['history'] = $this->model->load_history($userId);
            $data['user'] = $this->model->get_user($userId);
            $data['solution'] = $this->db->get('bo_solution')->result_array();
        }
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function rate_testimoni(){
        $comment = $this->input->post('comment');
        $rating = $this->input->post('rating');
        $session_id = $this->input->post('sessionId');
        $user_id = $this->session->userdata('user_id');
        $rating_data = [
            "session_id" => $session_id,
            "user_id" => $user_id,
            "rating" => $rating,
            "testimoni" => $comment,
        ];
        $this->db->insert('bo_rating', $rating_data);
        // $user = $this->model->get_user($user_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => true,'data' => $rating_data]);
    }

    public function top_rate_testimoni()
    {
        $data['ratings'] =  $this->model->get_ratings();
        
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function get_employee_id()
    {
        $data = $this->model->get_employee_id();
        echo json_encode($data);
    }
    public function load_diagnose(){
        $data['diagnoses'] = $this->model->load_diagnoses();
        $answers = $this->model->load_answers();
        $data['answers'] = [];
        foreach ($answers as $key => $answer) {
            if (!isset($data['answers'][$answer['session_id']])) {
                $data['answers'][$answer['session_id']] = [];
            }

            $data['answers'][$answer['session_id']][$answer['symptom_id']] = $answer['cf_user'];
        }
        // $data['user'] = $this->model->get_user($userId);
        // $data['solution'] = $this->db->get('bo_solution')->result_array();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
