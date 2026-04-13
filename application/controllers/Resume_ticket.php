<?php
ob_start();
defined('BASEPATH') or exit('No direct script access allowed');

class Resume_ticket extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
        $this->load->model('Model_resume_ticket', 'model');
        if ($this->session->userdata('user_id') != "") {
        } else {
            redirect('login', 'refresh');
        }
    }

    function index()
    {
        $data['content']             = "resume_ticket/index";
        $data['pageTitle']             = "Resume Ticket Development";
        $data['css']                 = "resume_ticket/css";
        $data['js']                 = "resume_ticket/js";

        // 
        $start = date("Y-m-01");
        $end = date("Y-m-t");

        $data['resume_1_to_4'] = $this->model->dt_resume_tiket("62,64,1161,2041", $start, $end);
        $data['resume_5_to_8'] = $this->model->dt_resume_tiket("2063,2070,2969,5203", $start, $end);
        $data['resume_9_to_12'] = $this->model->dt_resume_tiket("5397,5840,5963,7111", $start, $end);
        $data['resume_13_to_14'] = $this->model->dt_resume_tiket("7651", $start, $end);
        // var_dump($dt_resume_tiket_all_pic);
        // $data['resume_1_to_4'] = $this->model->dt_resume_tiket()[0];

        // $pic = 5840;
        // $data['dt_resume_tiket_dev_done'] = $this->model->dt_resume_tiket_dev_done($pic);

        $this->load->view("layout/main", $data);
    }

    function dt_tbl_resume_tiket()
    {
        $group_pic = $_POST['group_pic'];
        $start     = $_POST['start'];
        $end       = $_POST['end'];

        $result['data'] = $this->model->dt_resume_tiket($group_pic, $start, $end);
        echo json_encode($result);
    }

    function load_card_resume()
    {
        $start     = $_POST['start'];
        $end       = $_POST['end'];
        $group_pic_1_4 = "62,64,1161,2041";
        $group_pic_5_8 = "2063,2070,2969,5203";
        $group_pic_9_12 = "5397,5840,7111,7651";
        $group_pic_13_14 = "8257,8259";

        $dt_resume_1_to_4 = $this->model->dt_resume_tiket($group_pic_1_4, $start, $end);
        $dt_resume_5_to_8 = $this->model->dt_resume_tiket($group_pic_5_8, $start, $end);
        $dt_resume_9_to_12 = $this->model->dt_resume_tiket($group_pic_9_12, $start, $end);
        $dt_resume_13_to_14 = $this->model->dt_resume_tiket($group_pic_13_14, $start, $end);

        $html = '<div class="swiper swiperauto">';

        $html .= '<div class="swiper-wrapper">';
        foreach ($dt_resume_1_to_4 as $row) {
            $html .= '<div class="swiper-slide">
                        <div class="card border-0 w-250">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Profile</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <figure class="avatar avatar-100 coverimg mb-3 rounded-circle">
                                    <img src="https://trusmiverse.com/hr/uploads/profile/' . $row->profile_picture . '" alt="" />
                                </figure>

                                <h6 class="mb-1"><span class="avatar avatar-10 bg-green me-1 rounded-circle vm"></span> ' . $row->employee_name . '</h6>
                                <p class="text-secondary small">Komitmen Development</p>
                                <p><i class="bi bi-star-fill text-yellow"></i> ' . $row->total_target_komit . ' / ' . $row->total_actual_komit . ' (' . $row->achievement_komit . '%)</p>
                            </div>
                            <div class="card-footer">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-building"></i> Dev</p>
                                        <p class="small w-100 text-truncate text-center"><span class="">' . $row->total_dev_done . '</span></p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-ticket"></i> Ticket</p>
                                        <p class="small text-center">' . $row->total_tiket_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i classx="bi bi-x"></i>Undone</p>
                                        <p class="small text-center">' . $row->total_all_tiket_undone . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $html .= '</div>';

        $html .= '<div class="swiper-wrapper">';
        foreach ($dt_resume_5_to_8 as $row) {
            $html .= '<div class="swiper-slide">
                        <div class="card border-0 w-250">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Profile</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <figure class="avatar avatar-100 coverimg mb-3 rounded-circle">
                                    <img src="https://trusmiverse.com/hr/uploads/profile/' . $row->profile_picture . '" alt="" />
                                </figure>

                                <h6 class="mb-1"><span class="avatar avatar-10 bg-green me-1 rounded-circle vm"></span> ' . $row->employee_name . '</h6>
                                <p class="text-secondary small">Komitmen Development</p>
                                <p><i class="bi-star-fill text-yellow"></i> ' . $row->total_target_komit . ' / ' . $row->total_actual_komit . ' (' . $row->achievement_komit . '%)</p>
                            </div>
                            <div class="card-footer">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-building"></i> Dev</p>
                                        <p class="small w-100 text-truncate text-center">' . $row->total_dev_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-ticket"></i> Ticket</p>
                                        <p class="small text-center">' . $row->total_tiket_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i classx="bi bi-x"></i>Undone</p>
                                        <p class="small text-center">' . $row->total_all_tiket_undone . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $html .= '</div>';

        $html .= '<div class="swiper-wrapper">';
        foreach ($dt_resume_9_to_12 as $row) {
            $html .= '<div class="swiper-slide">
                        <div class="card border-0 w-250">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Profile</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <figure class="avatar avatar-100 coverimg mb-3 rounded-circle">
                                    <img src="https://trusmiverse.com/hr/uploads/profile/' . $row->profile_picture . '" alt="" />
                                </figure>

                                <h6 class="mb-1"><span class="avatar avatar-10 bg-green me-1 rounded-circle vm"></span> ' . $row->employee_name . '</h6>
                                <p class="text-secondary small">Komitmen Development</p>
                                <p><i class="bi-star-fill text-yellow"></i> ' . $row->total_target_komit . ' / ' . $row->total_actual_komit . ' (' . $row->achievement_komit . '%)</p>
                            </div>
                            <div class="card-footer">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-building"></i> Dev</p>
                                        <p class="small w-100 text-truncate text-center">' . $row->total_dev_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-ticket"></i> Ticket</p>
                                        <p class="small text-center">' . $row->total_tiket_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i classx="bi bi-x"></i>Undone</p>
                                        <p class="small text-center">' . $row->total_all_tiket_undone . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $html .= '</div>';

        $html .= '<div class="swiper-wrapper">';
        foreach ($dt_resume_13_to_14 as $row) {
            $html .= '<div class="swiper-slide">
                        <div class="card border-0 w-250">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <i class="bi bi-person-circle h5 me-1 avatar avatar-40 bg-light-theme rounded me-2"></i>
                                    </div>
                                    <div class="col ps-0">
                                        <h6 class="fw-medium mb-0">Profile</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center">
                                <figure class="avatar avatar-100 coverimg mb-3 rounded-circle">
                                    <img src="https://trusmiverse.com/hr/uploads/profile/' . $row->profile_picture . '" alt="" />
                                </figure>

                                <h6 class="mb-1"><span class="avatar avatar-10 bg-green me-1 rounded-circle vm"></span> ' . $row->employee_name . '</h6>
                                <p class="text-secondary small">Komitmen Development</p>
                                <p><i class="bi bi-star-fill text-yellow"></i> ' . $row->total_target_komit . ' / ' . $row->total_actual_komit . ' (' . $row->achievement_komit . '%)</p>
                            </div>
                            <div class="card-footer">
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-building"></i> Dev</p>
                                        <p class="small w-100 text-truncate text-center">' . $row->total_dev_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i class="bi bi-ticket"></i> Ticket</p>
                                        <p class="small text-center">' . $row->total_tiket_done . '</p>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-secondary small mb-0"><i classx="bi bi-x"></i>Undone</p>
                                        <p class="small text-center">' . $row->total_all_tiket_undone . '</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
        }
        $html .= '</div>';

        $html .= '</div>';

        echo $html;
        // $response['data'] = $this->model->dt_resume_tiket($group_pic, $start, $end);
        // echo json_encode($response);
    }

    // ------------------------------------------------------------------------
    function resume()
    {
        $data['content']             = "resume_ticket/resume";
        $data['pageTitle']             = "Resume Ticket Development";
        $data['css']                 = "resume_ticket/css";
        $data['js']                 = "resume_ticket/js";

        $this->load->view("layout/main", $data);
    }
}
