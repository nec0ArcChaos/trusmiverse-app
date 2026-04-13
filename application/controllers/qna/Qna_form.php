<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qna_form extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Model_qna', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            $id = $this->uri->segment(2);
            $link = array(
                'previus_link'  => 'frm-qna/' . $id,
                // 'previus_link'  => 'qna/qna_form/view/' . $id,
            );
            $this->session->set_userdata($link);
            redirect('login', 'refresh');
        }
    }

    public function view($id)
    {
        $data['pageTitle']  = "Form - Question and Answer (QnA)";
        $data['qna']        = $this->model->get_qna($id);
        $data['qna_item']   = $this->model->get_qna_item($id);

        $ck = $this->model->check_qna($_SESSION['user_id'],$id);
        if ($ck > 0) {
            $this->load->view('qna/form/detail_closing', $data);
        } else {
            $this->load->view('qna/form/detail', $data);
        }
        
    }

    public function view_closing($id)
    {
        $data['pageTitle']  = "Form - Question and Answer (QnA)";
        $data['qna']        = $this->model->get_qna($id);
        $this->load->view('qna/form/detail_closing', $data);
    }

    public function submit_answer()
    {
        $total_pertanyaan 	= $_POST['total_pertanyaan'];
        $user_id 		    = $_SESSION['user_id'];
        
        $id_answer      = $this->model->generate_no_answer();
		$id_question 	= $_POST['id_question'];

        $emp            = $this->model->get_detail_employee($user_id);
		$company_id 	= $emp['company_id'];
		$department_id 	= $emp['department_id'];
		$user_role_id 	= $emp['user_role_id'];

        $prd            = $this->model->get_periode();
        $week           = $prd['minggu'];
        $periode        = $prd['bulan'];

        $nilai          = 0.00;
		$created_at 	= date('Y-m-d H:i:s');

        $answer = array(
            'id_answer' 		=> $id_answer,
            'id_question' 		=> $id_question,
            'week' 		        => $week,
            'periode' 		    => $periode,
            'company_id'	    => $company_id,
            'department_id'	    => $department_id,
            'user_role_id'	    => $user_role_id,
            'nilai' 			=> $nilai,
            'created_by' 		=> $user_id,
            'created_at' 		=> $created_at
        );
        $result['insert_answer'] = $this->db->insert('qna_answer', $answer);
        
		$i = 0;
        for ($x=0; $x < $total_pertanyaan; $x++) { 
            $i++;
            if ($_POST['type_id'][$x] != 0) {

                if ($_POST['type_id'][$x] == 1) {
                    $answer = $_POST['answer_'.$i];
                    $bobot  = $_POST['bobot_'.$i];
                } else {
                    $ans = explode('|',$_POST['answer_'.$i]);
                    $answer = $ans[0];
                    $bobot  = $ans[1];
                }

                $nilai += $bobot;
                $item = array(
                    'id_answer' 	    => $id_answer,
                    'id_question' 	    => $id_question,
                    'id_question_item' 	=> $_POST['id_question_item'][$x],
                    'answer' 	        => $answer,
                    'type_id' 	        => $_POST['type_id'][$x],
                    'bobot' 	        => $bobot
                );
                $result['insert_item'.$i] = $this->db->insert('qna_answer_item', $item);	
            }
        }

        $this->db->where('id_answer', $id_answer);
        $result['update_nilai'] = $this->db->update('qna_answer', array('nilai' => $nilai));
		echo json_encode($result);
    }

}
